<script setup>
import {Disclosure, DisclosureButton, DisclosurePanel} from "@headlessui/vue";
import {ChatBubbleBottomCenterTextIcon, HandThumbUpIcon} from '@heroicons/vue/24/outline';

import {router, usePage} from "@inertiajs/vue3";
import PostUserHeader from "@/Components/app/PostUserHeader.vue";
import ReadMore from "@/Components/app/ReadMore.vue";
import EditDeleteMenu from "@/Components/app/EditDeleteMenu.vue";
import axiosClient from "@/axiosClient.js"
import PostAttachment from "@/Components/app/PostAttachment.vue";
import PostComments from "@/Components/app/PostComments.vue";

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
            <PostAttachment :attachments="post.attachments" @attachmentClick="previewAttachment" />
        </div>

        <Disclosure v-slot="{ open }">
            <!-- post impressions thus like & comment buttons -->
            <div class="flex gap-2 text-gray-700">
                <button @click="sendPostReaction" :class="[
                    post.user_has_impression ? 'bg-indigo-100 hover:bg-indigo-50' : 'bg-gray-50 hover:bg-indigo-100'
                ]" class="flex items-center justify-center flex-1 gap-1 px-4 py-2 rounded-full shadow-2xl ">
                    <HandThumbUpIcon class="w-6 h-6" />
                    <span class="mr-2">{{ post.impressions }}</span>
                    {{ post.user_has_impression ? 'unlike' : 'like' }}
                </button>
                <DisclosureButton
                    class="flex items-center justify-center flex-1 gap-1 px-4 py-2 bg-gray-100 rounded-full shadow-2xl hover:bg-indigo-100">
                    <ChatBubbleBottomCenterTextIcon class="w-6 h-6" />
                    <span class="mr-2">{{ post.num_of_comments }}</span>
                    comments
                </DisclosureButton>

            </div>

            <DisclosurePanel class="mt-4">
                <PostComments :post="props.post" :data="{ comments: post.comments }"/>
            </DisclosurePanel>
        </Disclosure>

    </div>
</template>

