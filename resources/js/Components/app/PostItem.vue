<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { DocumentIcon } from '@heroicons/vue/24/outline';
import { ChatBubbleBottomCenterTextIcon, ChatBubbleLeftRightIcon, HandThumbUpIcon, TrashIcon, ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { isImage } from '@/helpers.js'
import { router, usePage } from "@inertiajs/vue3";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import PostUserHeader from "@/Components/app/PostUserHeader.vue";
import ReadMore from "@/Components/app/ReadMore.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import EditDeleteMenu from "@/Components/app/EditDeleteMenu.vue";
import axiosClient from "@/axiosClient.js"
import { ref } from "vue";

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

function sendPostReaction() {
    axiosClient.post(route('post.reaction', props.post), {
        reaction: 'like'
    }).then(({ data }) => {
        props.post.user_has_impression = data.user_has_impression
        props.post.impressions = data.impressions
    })
}

function sendCommentReaction() {
    axiosClient.post(route('comment.reaction', props.post), {
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
}

function updateComment() {
    axiosClient.put(route('post.comment.update', editingComment.value.id), editingComment.value)
        .then(({data}) => {
            editingComment.value = null
            props.post.comments = props.post.comments.map((c) => {
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
                    <EditDeleteMenu :user="props.post.user" @edit="openEditModal" @delete="deletePost" />
                </div>
            </div>
        </div>

        <div class="mb-3">
            <ReadMore :content="props.post.body" />
        </div>

        <div class="grid gap-3 mb-3 " :class="props.post.attachments.length === 1 ? 'grid-cols-1' : 'grid-cols-2'">
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
                <button @click="sendPostReaction" :class="[
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
                                    {{ comment.updated_at }}
                                </small>
                            </div>
                        </div>
                        <EditDeleteMenu :user="comment.user" @edit="editCommentModal(comment)"
                            @delete="deleteComment(comment)" />
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
                        <div class="flex gap-2 mt-1">
                            <button class="flex items-center px-1 py-0.5 text-xs text-indigo-500 rounded-full hover:bg-indigo-200">
                                <HandThumbUpIcon class="w-4 h-4 m-1" />
                            </button>
                            <button class="flex items-center p-2 text-xs text-indigo-500 rounded-full hover:bg-indigo-200">
                                <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 0 1 8 8v2M3 10l6 6m-6-6l6-6" />
                                </svg> reply
                            </button>
                        </div>
                    </div>
                </div>
            </DisclosurePanel>
        </Disclosure>

    </div>
</template>

<style scoped></style>
