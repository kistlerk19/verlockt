<script setup>


import FollowingItem from '@/Components/app/FollowingItem.vue';
import TextInput from '@/Components/TextInput.vue';

import { ref } from 'vue';

    const searchKey = ref('')

</script>

<template>
    <div class="px-3 py-4 bg-gray-100 border rounded-lg ">
        <h2 class="mb-4 text-xl font-bold">Following</h2>
        <TextInput :model-value="searchKey" placeholder="Search" class="w-full"/>
        <div class="py-8">
            <div v-if="false" class="flex text-center text-gray-400">
                You do not have friends yet.
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
            </div>
        </div>
    </div>

</template>
