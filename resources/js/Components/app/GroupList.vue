<script setup>

import GroupItem from '@/Components/app/GroupItem.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';

    const searchKey = ref('')

</script>

<template>
    <div class="px-3">
        <h2 class="mb-4 text-2xl font-bold">My Groups</h2>
        <TextInput :model-value="searchKey" placeholder="Search for groups"/>
        <div class="py-8">
            <div v-if="false" class="flex text-center text-gray-400">
                You are not in any group.
            </div>
            <div v-else>
                <GroupItem
                    image="https://picsum.photos/100"
                    title="Laravel"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
            </div>
        </div>
    </div>

</template>
