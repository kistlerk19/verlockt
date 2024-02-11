<script setup>
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';
import { PencilIcon, EllipsisVerticalIcon } from '@heroicons/vue/24/solid';
import { TrashIcon } from '@heroicons/vue/24/outline';
import { usePage } from "@inertiajs/vue3";

defineProps({
    user: Object
})

const authUser = usePage().props.auth.user;

defineEmits(['edit', 'delete']);
</script>

<template>
    <Menu as="div" class="relative inline-block text-left">
        <div>
            <MenuButton
                class="z-10 flex items-center justify-center px-2 py-2 text-sm transition rounded-full hover:bg-black/10">
                <EllipsisVerticalIcon class="w-5 h-5 rounded-full " />
            </MenuButton>
        </div>

        <transition enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0">
            <MenuItems
                class="absolute right-0 z-10 mt-2 origin-top-right bg-white divide-y divide-gray-100 shadow-lg rounded-2xl w-30 ring-1 ring-black/5 focus:outline-none">
                <div class="px-1 py-1">
                    <MenuItem v-if="user.id === authUser.id" v-slot="{ active }">
                    <button @click="$emit('edit')" :class="[
                        active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                        'group flex w-[100px] items-center rounded-full px-2 py-2 text-sm',
                    ]">
                        <PencilIcon class="w-5 h-5 mr-2" aria-hidden="true" />
                        Edit
                    </button>
                    </MenuItem>
                </div>

                <div class="px-1 py-1">
                    <MenuItem  v-if="user.id === authUser.id" v-slot="{ active }">
                    <button @click="$emit('delete')" :class="[
                        active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                        'group flex w-[100px] items-center rounded-full px-2 py-2 text-sm',
                    ]">
                        <TrashIcon class="w-5 h-5 mr-2 text-red-800" aria-hidden="true" />
                        Delete
                    </button>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>


<style lang="scss" scoped>

</style>
