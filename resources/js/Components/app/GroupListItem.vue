
<script setup>
import { ref } from 'vue';
import GroupItem from '@/Components/app/GroupItem.vue';
import TextInput from '@/Components/TextInput.vue';
import GroupModal from '@/Components/app/GroupModal.vue';

const searchKey = ref('')
const newGroupModal = ref(false)

const props = defineProps({
    groups: Array
})

function onGroupCreate(group){
    props.groups.unshift(group)
}
</script>

<template>
    <div class="flex gap-1 mt-4">
        <TextInput :model-value="searchKey" placeholder="Search" class="w-full rounded-full" />
        <button @click="newGroupModal = true"
            class="px-2 py-1 text-xs text-white bg-indigo-400 rounded-full w-[120px] shadow-2xl  hover:bg-indigo-500">new group</button>

    </div>
    <div class="flex-1 h-[300px] mt-3 overflow-auto">
        <div v-if="false" class="p-3 text-center text-gray-400">
            You are not part of any group yet.
        </div>
        <div v-else>
            <!-- <GroupItem v-for="group of groups" :group="group"/> -->
            <GroupItem v-for="(group, index) of groups" :key="index" :group="group" />
        </div>

        <GroupModal v-model="newGroupModal" @create="onGroupCreate"/>
    </div>
</template>
