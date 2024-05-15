<?php

namespace App\Http\Controllers;

use App\Notifications\UserRemovedFromGroup;
use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Group;
use App\Models\GroupUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Enums\GroupUserRole;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\GroupResource;
use App\Notifications\GroupInvitation;
use App\Notifications\RequestApproved;
use App\Http\Enums\GroupUserStatusEnum;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\InviteUserRequest;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\GroupUserResource;
use App\Notifications\InvitationApproved;
use App\Notifications\RequestToJoinGroup;
use App\Notifications\RoleChanged;
use Illuminate\Support\Facades\Notification;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function groupInfo(Group $group)
    {
        $group->load('currentUserGroup');

        $users = User::query()
            ->select(['users.*', 'gu.role', 'gu.status', 'gu.group_id'])
            ->join('group_users AS gu', 'gu.user_id', 'users.id')
            ->orderBy('users.name')
            ->where('group_id', $group->id)
            ->get();
        $requests = $group->pendingUsers;

        return Inertia::render(
            'Group/View',
            [
                'success' => session('success'),
                'group' => new GroupResource($group),
                'users' => GroupUserResource::collection($users),
                'requests' => UserResource::collection($requests),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $group = Group::create($data);

        $groupUserData = [
            'status' => GroupUserStatusEnum::APPROVED->value,
            'role' => GroupUserRole::ADMIN->value,
            'user_id' => Auth::id(),
            'group_id' => $group->id,
            'created_by' => Auth::id(),
        ];

        GroupUser::create($groupUserData);
        $group->status = $groupUserData['status'];
        $group->role = $groupUserData['role'];

        return response(new GroupResource($group), 201);
    }

    public function updateGroupImage(Request $request, Group $group)
    {
        if (!$group->isAdmin(Auth::id())) {
            return response("You are not authorized to perform this action!!", 403);
        }
        $data = $request->validate(
            [
                'cover' => ['nullable', 'image'],
                'thumbnail' => ['nullable', 'image'],
            ]
        );

        $thumbnail = $data['thumbnail'] ?? null;
        $cover = $data['cover'] ?? null;

        $success = '';

        if ($thumbnail) {
            if ($group->thumbnail_path) {
                Storage::disk('public')->delete($group->thumbnail_path);
            }
            $path = $thumbnail->store('images/groups/' . $group->id . '/thumbnail', 'public');
            $group->update(['thumbnail_path' => $path]);

            $success = 'thumbnail Was Updated.';
        }

        if ($cover) {
            if ($group->cover_path) {
                Storage::disk('public')->delete($group->cover_path);
            }
            $path = $cover->store('images/groups/' . $group->id . '/cover', 'public');
            $group->update(['cover_path' => $path]);

            $success = 'Cover Image was Updated.';
        }

        return back()->with('success', $success);
    }

    public function inviteUsers(InviteUserRequest $request, Group $group)
    {
        $data = $request->validated();

        $user = $request->user;

        $groupUser = $request->groupUser;
        if ($groupUser) {
            $groupUser->delete();
        }

        $hours = 24;
        $token = Str::random(256);

        GroupUser::create(
            [
                'status' => GroupUserStatusEnum::PENDING->value,
                'role' => GroupUserRole::USER->value,
                'token' => $token,
                'token_expires_date' => Carbon::now()->addHours($hours),
                'user_id' => $user->id,
                'group_id' => $group->id,
                'created_by' => Auth::id(),
            ]
        );

        $user->notify(new GroupInvitation($group, $hours, $token));

        return back()->with('success', 'Group invitation link sent to user.');
    }

    public function acceptInvitation(string $token)
    {
        $groupUser = GroupUser::query()
            ->where('token', $token)
            ->first();
        $errorTitle = '';
        if (!$groupUser) {
            $title = "Invalid link.";
        } elseif ($groupUser->token_used_on || $groupUser->status === GroupUserStatusEnum::APPROVED->value) {
            $title = "The link has already been used!";
        } elseif ($groupUser->token_expires_on < Carbon::now()) {
            $title = "The link has expired!";
        }

        if ($errorTitle) {
            return Inertia('Error', compact('title'));
        }

        $groupUser->status = GroupUserStatusEnum::APPROVED->value;
        $groupUser->token_used_on = Carbon::now();
        $groupUser->save();

        $adminUser = $groupUser->adminUser;
        $adminUser->notify(new InvitationApproved($groupUser->group, $groupUser->user));

        return redirect(route('group.info', $groupUser->group))
            ->with('success', 'You accepted to join the group "' . $groupUser->group->name . '"');
    }

    public function join(Group $group)
    {
        $user = request()->user();
        $status = GroupUserStatusEnum::APPROVED->value;
        $successMessage = 'You joined the group "' . $group->name . '"';

        if (!$group->auto_approval) {
            $status = GroupUserStatusEnum::PENDING->value;

            // Send Mail
            $group->adminUsers();
            dd($group->adminUsers);
            Notification::send($group->adminUsers, new RequestToJoinGroup($group, $user));
            $successMessage = 'Your request to join the "' . $group->name . '" group has been accepted.';
        }

        GroupUser::create([
            'status' => $status,
            'role' => GroupUserRole::USER->value,
            'user_id' => $user->id,
            'group_id' => $group->id,
            'created_by' => $user->id,
        ]);

        return back()->with('success', $successMessage);
    }

    public function approveRequest(Request $request, Group $group)
    {
        if (!$group->isAdmin(Auth::id())) {
            return response("You are not authorized to perform this action!!", 403);
        }

        $data = $request->validate([
            'user_id' => ['required'],
            'action' => ['required']
        ]);

        $groupUser = GroupUser::where('user_id', $data['user_id'])
            ->where('group_id', $group->id)
            ->where('status', GroupUserStatusEnum::PENDING->value)
            ->first();

        if ($groupUser) {
            $approved = false;
            if ($data['action'] === 'approve') {
                $approved = true;
                $groupUser->status = GroupUserStatusEnum::APPROVED->value;
            } else {
                $groupUser->status = GroupUserStatusEnum::REJECTED->value;
            }
            $groupUser->save();

            $user = $groupUser->user;
            // Sending mail to alert user that they've been approved.
            $user->notify(new RequestApproved($groupUser->group, $user, $approved));

            return back()->with('success', 'User "' . $groupUser->user->name . '" was ' . ($approved ? 'approved.' : 'rejected.'));
        }

        return back();
    }

    public function roleChange(Request $request, Group $group)
    {
        if (!$group->isAdmin(Auth::id())) {
            return response("You are not authorized to perform this action!!", 403);
        }

        $data = $request->validate([
            'user_id' => ['required'],
            'role' => ['required', Rule::enum(GroupUserRole::class)]
        ]);

        $user_id = $data['user_id'];

        if ($group->isOwner($user_id)) {
            return response("You cannot change the role of the group owner.", 403);
        }

        $groupUser = GroupUser::where('user_id', $user_id)
            ->where('group_id', $group->id)
            ->first();

        if ($groupUser) {
            $groupUser->role = $data['role'];
            $groupUser->save();

            $groupUser->user->notify(new RoleChanged($group, $data['role']));

            // return back();
        }

        return back();
    }

    public function removeUser(Request $request, Group $group)
    {
        if (!$group->isAdmin(Auth::id())) {
            return response("You are not authorized to perform this action!!", 403);
        }

        $data = $request->validate([
            'user_id' => ['required'],
        ]);

        $user_id = $data['user_id'];

        if ($group->isOwner($user_id)) {
            return response("You cannot remove the owner from the group.", 403);
        }

        $groupUser = GroupUser::where('user_id', $user_id)
            ->where('group_id', $group->id)
            ->first();

        if ($groupUser) {
            $user = $groupUser->user;
            $groupUser->delete();

            $groupUser->user->notify(new UserRemovedFromGroup($group));
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }
}

// $groupUser = GroupUser::where('user_id', Auth::id())->where('group_id', $group->id)->first();

// if ($groupUser && $groupUser->status === GroupUserStatusEnum::APPROVED->value) {
//     return back()->with('success', 'User is already joined the group.');
// }
