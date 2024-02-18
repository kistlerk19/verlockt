<script setup>

import GroupListItem from '@/Components/app/GroupListItem.vue';
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";

</script>

<template>
    <div class="h-full px-3 py-3 overflow-hidden bg-gray-100 border rounded-lg lg:flex lg:flex-col">
        <div class="block lg:hidden">
            <Disclosure v-slot="{ open }">
                <DisclosureButton class="w-full">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold">Groups</h2>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" :class="open && 'rotate-90 transform'" class="w-6 h-6 transition-all">
                        <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
                      </svg>
                    </div>

                </DisclosureButton>
                <DisclosurePanel>
                    <GroupListItem />
                </DisclosurePanel>

            </Disclosure>
        </div>


        <div class="flex-col hidden h-full overflow-hidden lg:flex">
            <div class="flex justify-between ">
                <h2 class="mb-4 text-xl font-bold">Groups</h2>
                <!-- <button @click="newGroupModal = true" class="px-3 text-sm text-white bg-indigo-400 rounded-full hover:bg-indigo-500">new group</button> -->
            </div>
            <GroupListItem  />
        </div>
    </div>

</template>
