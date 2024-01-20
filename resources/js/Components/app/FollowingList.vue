<script setup>


import FollowingItem from '@/Components/app/FollowingItem.vue';
import TextInput from '@/Components/TextInput.vue';

import { ref } from 'vue';

    const searchKey = ref('')

</script>

<template>
    <div class="flex flex-col px-3 py-3 overflow-hidden bg-gray-100 border rounded-lg lg:h-full">
        <h2 class="mb-4 text-xl font-bold">Following</h2>
        <TextInput :model-value="searchKey" placeholder="Search" class="w-full"/>
        <div class="lg:flex-1 h-[300px] mt-3 overflow-auto">
            <div v-if="false" class="p-3 text-center text-gray-400">
                You are not following anyone yet.
            </div>
            <div v-else>
                <FollowingItem
                    image="https://picsum.photos/100"
                    name="Charles Leclerc"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    image="https://picsum.photos/100"
                    name="Jeffery Dahmer"
                />
            </div>
        </div>
    </div>

</template>
