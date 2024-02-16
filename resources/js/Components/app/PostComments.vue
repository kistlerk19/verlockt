<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { ChatBubbleBottomCenterTextIcon, HandThumbUpIcon } from '@heroicons/vue/24/outline';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import EditDeleteMenu from "@/Components/app/EditDeleteMenu.vue";
import ReadMore from "@/Components/app/ReadMore.vue";
import { router, usePage } from "@inertiajs/vue3";
import { ref } from "vue"; import PostComments from "@/Components/app/PostComments.vue";
import axiosClient from "@/axiosClient.js"

const authUser = usePage().props.auth.user;

const newCommentText = ref('')
const editingComment = ref(null)

const props = defineProps({
    post: Object,
    data: Object,
    parentComment: {
        type: [Object, null],
        default: null,
    },
})

const emit = defineEmits(['commentCreate', 'commentDelete']);

function createComment() {
    axiosClient.post(route('post.comment.create', props.post), {
        comment: newCommentText.value,
        parent_id: props.parentComment?.id || null,
    }).then(({ data }) => {
        newCommentText.value = ''
        props.data.comments.unshift(data)
        // props.post.num_of_comments++;
        if (props.parentComment) {
            props.parentComment.num_of_comments++;
        }
        props.post.num_of_comments++;
        emit('commentCreate', data)
    })
}

function editCommentModal(comment) {
    editingComment.value = {
        id: comment.id,
        comment: comment.comment.replace(/<br\s*\/?>/gi, '\n') // variations of <br />
    }
}

function updateComment() {
    axiosClient.put(route('comment.update', editingComment.value.id), editingComment.value)
        .then(({ data }) => {
            editingComment.value = null
            props.data.comments = props.data.comments.map((c) => {
                if (c.id === data.id) {
                    return data
                }
                return c;
            })
        })
}

function deleteComment(comment) {
    if (!window.confirm("Are you sure you want to delete this comment?")) {
        return false;
    }
    axiosClient.delete(route('comment.delete', comment.id))
        .then(({ data }) => {
            const cIndex = props.data.comments.findIndex(c => c.id === comment.id)
            props.data.comments.splice(cIndex, 1)
            // props.data.comments = props.data.comments.filter(c => c.id !== comment.id)
            // props.post.comments = props.post.comments.filter(c => c.id !== comment.id)
            if (props.parentComment) {
                props.parentComment.num_of_comments--;
            }
            props.post.num_of_comments--;
            emit('commentDelete', comment)
        })
}
function sendCommentReaction(comment) {
    axiosClient.post(route('comment.impression', comment.id), {
        reaction: 'like'
    }).then(({ data }) => {
        comment.user_has_impression = data.user_has_impression
        comment.impressions = data.impressions
    })
}

function onCreateComment(comment) {
    if(props.parentComment){
        props.parentComment.num_of_comments++;
    }
    emit('commentCreate', comment)
}
function onDeleteComment(comment) {
    if(props.parentComment){
        props.parentComment.num_of_comments--;
    }
    emit('commentDelete', comment)
}
</script>
<template>
    <div>
        <div class="flex gap-2 mb-4">
            <a href="javascript:void(0)">
                <img :src="authUser.avatar_url"
                    class="w-[40px] h-[40px] rounded-full border-2 transition-all hover:border-blue-400" />
            </a>
            <div class="flex flex-1">
                <TextAreaInput v-model="newCommentText" rows="1"
                    class="w-full max-h-[160px] rounded-r-none shadow-2xl resize-none" placeholder="Add new comment...">
                </TextAreaInput>
                <PrimaryButton @click="createComment" class="rounded-l-none rounded-r-lg w-[100px]">Submit
                </PrimaryButton>
            </div>
        </div>

        <div class="p-2 mb-4 hover:bg-gray-100 rounded-xl" v-for="comment of props.data.comments" :key="comment.id">
            <div class="flex justify-between gap-2">
                <div class="flex gap-2">
                    <a href="javascript:void(0)">
                        <img :src="comment.user.avatar_url"
                            class="w-[40px] h-[40px] rounded-full border-2 transition-all hover:border-blue-400" />
                    </a>
                    <div>
                        <h4 class="font-bold">
                            <a href="javascript:void(0)" class="hover:underline">
                                {{ comment.user.username }}
                            </a>
                        </h4>
                        <small class="text-xs text-grey-400">
                            {{ comment.updated_at }}
                        </small>
                    </div>
                </div>
                <EditDeleteMenu :user="comment.user" @edit="editCommentModal(comment)" @delete="deleteComment(comment)" />
            </div>
            <div class="pl-12 pr-4">
                <div v-if="editingComment && editingComment.id === comment.id" class="">
                    <TextAreaInput v-model="editingComment.comment" rows="1"
                        class="w-full max-h-[160px] shadow-2xl resize-none">
                    </TextAreaInput>
                    <div class="flex justify-end gap-2">
                        <button @click="editingComment = null"
                            class="relative flex items-center justify-center px-3 py-2 font-semibold text-red-500 border-none rounded-full hover:bg-gray-200">cancel</button>
                        <PrimaryButton @click="updateComment" class="rounded-full w-[100px]">update
                        </PrimaryButton>
                    </div>
                </div>
                <ReadMore v-else :content="comment.comment" content-class="flex flex-1 text-sm" />
                <Disclosure>
                    <div class="flex gap-2 mt-1">
                        <button @click="sendCommentReaction(comment)" :class="[
                            comment.user_has_impression ? 'bg-indigo-100 hover:bg-indigo-50' : 'bg-gray-100 hover:bg-indigo-300'
                        ]" class="flex items-center px-1 shadow-xl py-0.5 text-xs text-indigo-500 rounded-full">
                            <HandThumbUpIcon class="w-4 h-4 m-1" />
                            <span class="mr-2">{{ comment.impressions }}</span>
                            {{ comment.user_has_impression ? 'unlike' : 'like' }}
                        </button>
                        <DisclosureButton
                            class="flex items-center p-2 text-xs text-indigo-500 rounded-full shadow-xl hover:bg-indigo-100">
                            <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M3 10h10a8 8 0 0 1 8 8v2M3 10l6 6m-6-6l6-6" />
                            </svg><span :class="[comment.num_of_comments > 0 ? 'mr-2' : '']">{{ comment.num_of_comments > 0
                                ? comment.num_of_comments : '' }}</span>
                            replies
                        </DisclosureButton>
                    </div>
                    <DisclosurePanel class="mt-3">
                        <!-- <pre>{{ comment.comments }}</pre> -->
                        <PostComments :post="post" :data="{ comments: comment.comments }" :parent-comment="comment"
                            @comment-create="onCreateComment" @comment-delete="onDeleteComment" />
                    </DisclosurePanel>
                </Disclosure>

            </div>
        </div>
    </div>
</template>
