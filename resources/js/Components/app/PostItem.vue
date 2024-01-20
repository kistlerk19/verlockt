<script setup>

import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue';

defineProps({
    post: Object
})

const isImage = (attachment) => {
    const mime = attachment.mime.split('/')
    return mime[0].toLowerCase() === 'image'
}

</script>

<template>
    <div class="p-4 mb-3 bg-gray-200 border rounded-md shadow">
        <div class="flex items-center gap-2 mb-3">
            <a href="javascript:void(0)">
                <img :src="post.user.avatar" class="w-[40px] rounded-full border-2 transition-all hover:border-blue-400"/>
            </a>
            <div>
               <h4 class="font-bold">
                    <a href="javascript:void(0)" class="hover:underline">
                        {{ post.user.name }}
                    </a>
                    <template v-if="post.group">
                        >
                        <a href="javascript:void(0)" class="hover:underline">
                            {{ post.group.name }}
                        </a>
                    </template>
               </h4>
                <small class="text-grey-100">
                    {{ post.created_at }}
                </small>
            </div>

        </div>

        <div class="mb-3">
            <Disclosure v-slot="{ open }">
                <div v-if="!open" v-html="post.body.substring(0, 200)" />
                <DisclosurePanel>
                    <div v-html="post.body" />
                </DisclosurePanel>
                <DisclosureButton
                    class="flex items-center justify-end w-full px-4 py-2 text-sm font-medium text-left text-blue-500 rounded-lg hover:underline focus:outline-none focus-visible:ring"
                >
                    {{ open ? 'Read less' : 'Read more...' }}
                </DisclosureButton>
            </Disclosure>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div v-for="attachment of post.attachments" :key="attachment.id" class="w-[300px] height-[300px] ">
                <img v-if="isImage(attachment)" :src="attachment.url" class="max-w-full">
                <div v-else>
                    {{ attachment.name }}
                </div>
            </div>
        </div>

        <div>
            <button>Like</button>
            <button>comment</button>
        </div>

    </div>
</template>

<style scoped>

</style>
