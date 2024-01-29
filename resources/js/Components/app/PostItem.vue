<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { PencilIcon, EllipsisVerticalIcon } from '@heroicons/vue/20/solid';
import { ChatBubbleBottomCenterTextIcon, HandThumbUpIcon, TrashIcon } from "@heroicons/vue/24/solid";
import {isImage} from '@/helpers.js'

import PostUserHeader from "@/Components/app/PostUserHeader.vue";
import { router } from "@inertiajs/vue3";

const emit = defineEmits(['editClick'])

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

</script>

<template>
  <div class="p-4 mb-3 bg-gray-100 border rounded-md shadow hover:bg-gray-300">
    <div class="flex items-center justify-between mb-3">
      <PostUserHeader :post="post" />
      <div class="justify-self-end">
        <div class="text-right top-16">
            <Menu as="div" class="relative inline-block text-left">
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

    <div class="grid grid-cols-2 gap-3 mb-3 lg:grid-cols-3">
      <template v-for="attachment of post.attachments" :key="attachment.id">
        <div
          class="relative flex flex-col items-center justify-center text-gray-500 bg-blue-200 rounded group aspect-square"
        >
          <!-- download -->
          <button
            class="absolute flex items-center justify-center w-8 h-8 text-gray-100 bg-gray-400 rounded opacity-0 cursor-pointer group-hover:opacity-100 hover:bg-gray-700 top-2 right-2"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              fill="currentColor"
              class="w-4 h-4"
            >
              <path
                fill-rule="evenodd"
                d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z"
                clip-rule="evenodd"
              />
            </svg>
          </button>

          <img
            v-if="isImage(attachment)"
            :src="attachment.url"
            class="object-cover rounded aspect-square"
          />

          <template v-else>
            <!-- file -->
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              fill="currentColor"
              class="w-12 h-12"
            >
              <path
                d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z"
              />
              <path
                d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"
              />
            </svg>
            <small>{{ attachment.name }}</small>
          </template>
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
