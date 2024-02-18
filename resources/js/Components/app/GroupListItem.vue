
<script setup>
import { ref } from 'vue';
import GroupItem from '@/Components/app/GroupItem.vue';
import TextInput from '@/Components/TextInput.vue';
import GroupModal from '@/Components/app/GroupModal.vue';

const searchKey = ref('')
const newGroupModal = ref(false)
</script>

<template>
    <div class="flex gap-1 mt-4">
        <TextInput :model-value="searchKey" placeholder="Search" class="w-full rounded-full" />
        <button @click="newGroupModal = true"
            class="px-2 py-1 text-xs text-white bg-indigo-400 rounded-full w-[120px]  hover:bg-indigo-500">new group</button>

    </div>
    <div class="flex-1 h-[300px] mt-3 overflow-auto">
        <div v-if="false" class="p-3 text-center text-gray-400">
            You are not part of any group yet.
        </div>
        <div v-else>
            <GroupItem image="https://picsum.photos/100" title="Laravel"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="VueJS DEVS"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit." />
        </div>

        <GroupModal v-model="newGroupModal" />
    </div>
</template>
