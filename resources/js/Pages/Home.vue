<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GroupList from "@/Components/app/GroupList.vue";
import FollowingList from "@/Components/app/FollowingList.vue";
import CreatePost from "@/Components/app/CreatePost.vue";
import PostList from "@/Components/app/PostList.vue";

defineProps({
    posts: Object
})
</script>

<template>
  <Head title="Home" />
  <AuthenticatedLayout>
    <!-- <pre>{{ posts }}</pre> -->
    <div class="grid h-full gap-3 p-4 lg:grid-cols-12">
      <div class="h-full overflow-hidden lg:col-span-3 lg:order-1">
        <GroupList />
      </div>
      <div class="h-full overflow-hidden lg:col-span-3 lg:order-3">
        <FollowingList />
      </div>
      <div
        class="flex flex-col h-full overflow-hidden lg:col-span-6 lg:order-2"
      >
        <CreatePost />
        <PostList :posts="posts.data" class="flex-1" />
      </div>
    </div>
  </AuthenticatedLayout>
</template>
