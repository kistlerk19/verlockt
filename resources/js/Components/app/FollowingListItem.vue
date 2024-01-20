
<script setup>
    import { ref } from 'vue';
    import FollowingItem from '@/Components/app/FollowingItem.vue';
    import TextInput from '@/Components/TextInput.vue';

    const searchKey = ref('')
</script>

<template>
        <TextInput :model-value="searchKey" placeholder="Search" class="w-full mt-4"/>
        <div class="flex-1 h-[300px] mt-3 overflow-auto">
            <div v-if="false" class="p-3 text-center text-gray-400">
                You are not part of any group yet.
            </div>
            <div v-else >
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/79.jpg"
                    name="Charles Leclerc"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/73.jpg"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/12.jpg"
                    name="Charles Leclerc"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/23.jpg"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/21.jpg"
                    name="Charles Leclerc"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/34.jpg"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/54.jpg"
                    name="Charles Leclerc"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/33.jpg"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/53.jpg"
                    name="Charles Leclerc"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/73.jpg"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/12.jpg"
                    name="Charles Leclerc"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/23.jpg"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/21.jpg"
                    name="Charles Leclerc"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/34.jpg"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/54.jpg"
                    name="Charles Leclerc"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/33.jpg"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/79.jpg"
                    name="Charles Leclerc"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/73.jpg"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/12.jpg"
                    name="Charles Leclerc"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/23.jpg"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/21.jpg"
                    name="Charles Leclerc"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/34.jpg"
                    name="Jeffery Dahmer"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/54.jpg"
                    name="Charles Leclerc"
                />
                <FollowingItem
                    avatar="https://randomuser.me/api/portraits/men/33.jpg"
                    name="Jeffery Dahmer"
                />
            </div>
        </div>
</template>
