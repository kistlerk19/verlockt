<script setup>
import GroupList from '@/Components/app/GroupList.vue'
import FollowingList from '@/Components/app/FollowingList.vue'
import CreatePost from '@/Components/app/CreatePost.vue';
import PostList from '@/Components/app/PostList.vue';


</script>

<template>
    <Head title="Home" />
    <div class="grid grid-cols-12 gap-3">
        <div class="col-span-3 p-y-6">
        <GroupList />

        </div>
        <div class="col-span-6">
            <CreatePost />
            <PostList />
        </div>
        <div class="col-span-3 p-y-6">
            <FollowingList />
        </div>
    </div>
</template>
