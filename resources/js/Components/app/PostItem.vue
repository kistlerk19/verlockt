<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { DocumentIcon } from '@heroicons/vue/24/outline';
import { ChatBubbleBottomCenterTextIcon, HandThumbUpIcon, TrashIcon, ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { isImage } from '@/helpers.js'
import { router, usePage } from "@inertiajs/vue3";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import PostUserHeader from "@/Components/app/PostUserHeader.vue";
import ReadMore from "@/Components/app/ReadMore.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import EditDeleteMenu from "@/Components/app/EditDeleteMenu.vue";
import axiosClient from "@/axiosClient.js"
import { ref } from "vue";
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const authUser = usePage().props.auth.user;

const editingComment = ref(null)

const newCommentText = ref('')

const props = defineProps({
    post: Object,
})


const emit = defineEmits(['editClick', 'attachmentClick'])

function openEditModal() {
    emit('editClick', props.post)
}

function deletePost() {
    if (window.confirm('Are you sure you want to delete this post?')) {
        router.delete(route('post.delete', props.post), {
            preserveScroll: true
        })
    }
}

function previewAttachment(index) {
    emit('attachmentClick', props.post, index);
}

function sendReaction() {
    axiosClient.post(route('post.reaction', props.post), {
        reaction: 'like'
    }).then(({ data }) => {
        props.post.user_has_impression = data.user_has_impression
        props.post.impressions = data.impressions
    })
}

function createComment() {
    axiosClient.post(route('post.comment.create', props.post), {
        comment: newCommentText.value
    }).then(({ data }) => {
        newCommentText.value = ''
        props.post.comments.unshift(data)
        props.post.num_of_comments++
    })
}
function editCommentModal(comment) {
    editingComment.value = {
        id: comment.id,
        comment: comment.comment.replace(/<br\s*\/?>/gi, '\n') // variations of <br />
    }
    console.log(comment);
}

function deleteComment(comment) {
    if (!window.confirm("Are you sure you want to delete this comment?")) {
        return false;
    }
    axiosClient.delete(route('post.comment.delete', comment.id))
        .then(({ data }) => {
            props.post.comments = props.post.comments.filter(c => c.id !== comment.id)
            props.post.num_of_comments--;
        })
}
</script>

<template>
    <div class="p-4 mb-3 bg-gray-100 border rounded-md shadow hover:bg-gray-200">
        <div class="flex items-center justify-between mb-3">
            <PostUserHeader :post="post" />
            <div class="justify-self-end">
                <div class="text-right top-16">
                    <!-- <Menu as="div" class="relative z-10 inline-block text-left">
                        <div>
                            <MenuButton
                                class="flex items-center justify-center px-2 py-2 text-sm transition rounded-full hover:bg-black/10">
                                <EllipsisVerticalIcon class="w-5 h-5 rounded-full " />
                            </MenuButton>
                        </div>

                        <transition enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
                            leave-active-class="transition duration-75 ease-in"
                            leave-from-class="transform scale-100 opacity-100"
                            leave-to-class="transform scale-95 opacity-0">
                            <MenuItems
                                class="absolute right-0 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg w-30 ring-1 ring-black/5 focus:outline-none">
                                <div class="px-1 py-1">
                                    <MenuItem v-slot="{ active }">
                                    <button @click="openEditModal" :class="[
                                        active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                                        'group flex w-[100px] items-center rounded-md px-2 py-2 text-sm',
                                    ]">
                                        <PencilIcon class="w-5 h-5 mr-2" aria-hidden="true" />
                                        Edit
                                    </button>
                                    </MenuItem>
                                </div>

                                <div class="px-1 py-1">
                                    <MenuItem v-slot="{ active }">
                                    <button @click="deletePost" :class="[
                                        active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                                        'group flex w-[100px] items-center rounded-md px-2 py-2 text-sm',
                                    ]">
                                        <TrashIcon class="w-5 h-5 mr-2 text-red-800" aria-hidden="true" />
                                        Delete
                                    </button>
                                    </MenuItem>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu> -->
                    <EditDeleteMenu :user="props.post.user" @edit="openEditModal" @delete="deletePost" />
                </div>
            </div>
        </div>

        <div class="mb-3">
            <ReadMore :content="post.body" />
        </div>

        <div class="grid gap-3 mb-3 " :class="post.attachments.length === 1 ? 'grid-cols-1' : 'grid-cols-2'">
            <template v-for="(attachment, index) of post.attachments.slice(0, 4)" :key="attachment.id">
                <div @click="previewAttachment(index)"
                    class="relative flex flex-col items-center justify-center text-gray-500 bg-blue-200 rounded cursor-pointer group aspect-square">
                    <div v-if="index === 3 && post.attachments.length > 4"
                        class="absolute top-0 bottom-0 left-0 right-0 z-10 flex items-center justify-center text-xl text-white bg-black/60">
                        + {{ post.attachments.length - 4 }}
                    </div>
                    <!-- download -->
                    <a @click.stop :href="route('post.download', attachment)"
                        class="absolute flex items-center justify-center w-8 h-8 text-white rounded opacity-0 cursor-pointer bg-black/20 group-hover:opacity-100 hover:bg-black/80 top-2 right-2">
                        <ArrowDownTrayIcon class="p-2" />
                    </a>

                    <img v-if="isImage(attachment)" :src="attachment.url"
                        class="object-cover rounded nowrap aspect-square" />

                    <div v-else class="flex flex-col items-center justify-center">
                        <!-- file -->
                        <DocumentIcon class="w-12 h-12" />
                        <small>{{ attachment.name }}</small>
                    </div>

                </div>
            </template>
        </div>

        <Disclosure v-slot="{ open }">
            <div class="flex gap-2 text-gray-700">
                <button @click="sendReaction" :class="[
                    post.user_has_impression ? 'bg-indigo-300 hover:bg-indigo-100' : 'bg-gray-100 hover:bg-indigo-300'
                ]" class="flex items-center justify-center flex-1 gap-1 px-4 py-2 rounded-full shadow-2xl ">
                    <HandThumbUpIcon class="w-6 h-6" />
                    <span class="mr-2">{{ post.impressions }}</span>
                    {{ post.has_impression ? 'Unlike' : 'Like' }}
                </button>
                <DisclosureButton
                    class="flex items-center justify-center flex-1 gap-1 px-4 py-2 bg-gray-100 rounded-full shadow-2xl hover:bg-indigo-300">
                    <ChatBubbleBottomCenterTextIcon class="w-6 h-6" />
                    <span class="mr-2">{{ post.num_of_comments }}</span>
                    Comment
                </DisclosureButton>

            </div>

            <DisclosurePanel class="mt-4">
                <div class="flex gap-2 mb-4">
                    <a href="javascript:void(0)">
                        <img :src="authUser.avatar_url"
                            class="w-[40px] h-[40px] rounded-full border-2 transition-all hover:border-blue-400" />
                    </a>
                    <div class="flex flex-1">
                        <TextAreaInput v-model="newCommentText" rows="1"
                            class="w-full max-h-[160px] rounded-r-none shadow-2xl resize-none"
                            placeholder="Add new comment...">
                        </TextAreaInput>
                        <PrimaryButton @click="createComment" class="rounded-l-none rounded-r-lg w-[100px]">Submit
                        </PrimaryButton>
                    </div>
                </div>

                <div class="p-2 mb-4 hover:bg-gray-100 rounded-xl" v-for="comment of post.comments" :key="comment.id">
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
                                    {{ comment.created_at }}
                                </small>
                            </div>
                        </div>
                        <EditDeleteMenu :user="comment.user" @edit="editCommentModal(comment)"
                            @delete="deleteComment(comment)" />
                    </div>
                    <div v-if="editingComment" class="ml-12">
                        <TextAreaInput v-model="editingComment.comment" rows="1"
                            class="w-full max-h-[160px] shadow-2xl resize-none" placeholder="Add comment...">
                        </TextAreaInput>
                        <div class="flex justify-end gap-2">
                            <button @click="editingComment = null"
                                class="relative flex items-center justify-center px-3 py-2 font-semibold text-red-500 border-none rounded-full hover:bg-gray-200">cancel</button>
                            <PrimaryButton @click="createComment" class="rounded-full w-[100px]">update
                            </PrimaryButton>
                        </div>
                    </div>
                    <ReadMore v-else :content="comment.comment" content-class="flex flex-1 ml-12 text-sm" />
                </div>
            </DisclosurePanel>
        </Disclosure>

    </div>
</template>

<style scoped></style>
