<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { PencilIcon, EllipsisVerticalIcon } from '@heroicons/vue/24/solid';
import { DocumentIcon } from '@heroicons/vue/24/outline';
import { ChatBubbleBottomCenterTextIcon, HandThumbUpIcon, TrashIcon, ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import {isImage} from '@/helpers.js'

import PostUserHeader from "@/Components/app/PostUserHeader.vue";
import { router } from "@inertiajs/vue3";

const emit = defineEmits(['editClick', 'attachmentClick'])

const props = defineProps({
  post: Object,
})



function openEditModal(){
    emit('editClick', props.post)
}

function deletePost()
{
    if(window.confirm('Are you sure you want to delete this post?'))
    {
        router.delete(route('post.delete', props.post), {
            preserveScroll: true
        })
    }
}

function previewAttachment(index)
{
    emit('attachmentClick', props.post, index);
}

</script>

<template>
  <div class="p-4 mb-3 bg-gray-100 border rounded-md shadow hover:bg-gray-300">
    <div class="flex items-center justify-between mb-3">
      <PostUserHeader :post="post" />
      <div class="justify-self-end">
        <div class="text-right top-16">
            <Menu as="div" class="relative z-10 inline-block text-left">
            <div>
                <MenuButton
                class="flex items-center justify-center px-2 py-2 text-sm transition rounded-full hover:bg-black/10"
                >
                <EllipsisVerticalIcon class="w-5 h-5 rounded-full "/>
                </MenuButton>
            </div>

            <transition
                enter-active-class="transition duration-100 ease-out"
                enter-from-class="transform scale-95 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-75 ease-in"
                leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0"
            >
                <MenuItems
                class="absolute right-0 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg w-30 ring-1 ring-black/5 focus:outline-none"
                >
                <div class="px-1 py-1">
                    <MenuItem v-slot="{ active }">
                    <button
                        @click="openEditModal"
                        :class="[
                        active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                        'group flex w-[100px] items-center rounded-md px-2 py-2 text-sm',
                        ]"
                    >
                        <PencilIcon
                        class="w-5 h-5 mr-2"
                        aria-hidden="true"
                        />
                        Edit
                    </button>
                    </MenuItem>
                </div>

                <div class="px-1 py-1">
                    <MenuItem v-slot="{ active }">
                    <button
                        @click="deletePost"
                        :class="[
                        active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                        'group flex w-[100px] items-center rounded-md px-2 py-2 text-sm',
                        ]"
                    >
                        <TrashIcon
                        class="w-5 h-5 mr-2 text-red-800"
                        aria-hidden="true"
                        />
                        Delete
                    </button>
                    </MenuItem>
                </div>
                </MenuItems>
            </transition>
            </Menu>
        </div>
      </div>
    </div>

    <div class="mb-3">
      <Disclosure v-slot="{ open }">
        <div class="ck-content-output" v-if="!open" v-html="post.body.substring(0, 200)" />
        <template v-if="post.body.length > 200">
          <DisclosurePanel>
            <div class="ck-content" v-html="post.body" />
          </DisclosurePanel>
          <DisclosureButton
            class="flex items-center justify-end w-full px-4 py-2 text-sm font-medium text-left text-blue-500 rounded-lg hover:underline focus:outline-none focus-visible:ring"
          >
            {{ open ? "Read less" : "Read more..." }}
          </DisclosureButton>
        </template>
      </Disclosure>
    </div>
    <!-- <pre>{{ post.attachments }}</pre> -->

    <div class="grid gap-3 mb-3 " :class="post.attachments.length === 1 ? 'grid-cols-1' : 'grid-cols-2'">
      <template v-for="(attachment, index) of post.attachments.slice(0, 4)" :key="attachment.id">
        <div
            @click="previewAttachment(index)"
          class="relative flex flex-col items-center justify-center text-gray-500 bg-blue-200 rounded cursor-pointer group aspect-square"
        >
        <div v-if="index === 3 && post.attachments.length > 4" class="absolute top-0 bottom-0 left-0 right-0 z-10 flex items-center justify-center text-xl text-white bg-black/60">
            + {{ post.attachments.length - 4 }}
        </div>
          <!-- download -->
          <a
            :href="route('post.download', attachment)"
            class="absolute flex items-center justify-center w-8 h-8 text-white rounded opacity-0 cursor-pointer bg-black/20 group-hover:opacity-100 hover:bg-black/80 top-2 right-2"
          >
          <ArrowDownTrayIcon class="p-2"/>
          </a>

          <img
            v-if="isImage(attachment)"
            :src="attachment.url"
            class="object-cover rounded aspect-square"
          />

          <div v-else class="flex flex-col items-center justify-center">
            <!-- file -->
            <DocumentIcon class="w-12 h-12" />
            <small>{{ attachment.name }}</small>
          </div>
        </div>
      </template>
    </div>

    <div class="flex gap-2 text-gray-700">
      <button
        class="flex items-center justify-center flex-1 gap-1 px-4 py-2 bg-gray-100 rounded-full hover:bg-indigo-300"
      >
      <HandThumbUpIcon class="w-6 h-6" />
        Like
      </button>
      <button
        class="flex items-center justify-center flex-1 gap-1 px-4 py-2 bg-gray-100 rounded-full hover:bg-indigo-300"
      >
        <ChatBubbleBottomCenterTextIcon class="w-6 h-6"/>
        Comment
      </button>
    </div>
  </div>
</template>

<style scoped>
</style>
