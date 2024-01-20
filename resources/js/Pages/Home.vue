<script setup>
import GroupList from '@/Components/app/GroupList.vue'
import FollowingList from '@/Components/app/FollowingList.vue'
import CreatePost from '@/Components/app/CreatePost.vue';
import PostList from '@/Components/app/PostList.vue';


</script>

<template>
    <Head title="Home" />
    <div class="grid gap-3 p-4 lg:grid-cols-12">
        <div class="lg:col-span-3 lg:order-1">
            <GroupList />
        </div>
        <div class="lg:col-span-3 lg:order-3">
            <FollowingList />
        </div>
        <div class="lg:col-span-6 lg:order-2">
            <CreatePost />
            <PostList />
        </div>

    </div>
</template>
