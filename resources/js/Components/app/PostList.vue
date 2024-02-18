<script setup>
import PostItem from "@/Components/app/PostItem.vue";
import PostModal from "@/Components/app/PostModal.vue";
import AttachmentPreviewModal from "@/Components/app/AttachmentPreviewModal.vue";
import { usePage } from "@inertiajs/vue3";
import { onMounted, ref, onUpdated } from "vue";
import axiosClient from '@/axiosClient.js';

const authUser = usePage().props.auth.user;

const page = usePage();


const allPosts = ref({
    data: page.props.posts.data,
    next: page.props.posts.links.next,
})

const props = defineProps({
    posts: Array,
});

const showEditModal = ref(false);
const showPreviewModal = ref(false);
const editPost = ref({});
const previewPostAttachment = ref({});
const loadMoreIntersect = ref(null)

function openEditModal(post) {
    editPost.value = post;
    showEditModal.value = true;
}
function openPreviewModal(post, index) {
    previewPostAttachment.value = {
        post,
        index,
    };
    showPreviewModal.value = true;
}

function onHideModal() {
    editPost.value = {
        id: null,
        body: "",
        user: authUser,
    };
}

function loadMore() {
    if (!allPosts.value.next) {
        return;
    }
    axiosClient.get(allPosts.value.next)
        .then(({ data }) => {
            allPosts.value.data = [...allPosts.value.data, ...data.data]
            allPosts.value.next = data.links.next
        })
}


onMounted(() => {
    const observer = new IntersectionObserver((entries) => entries.forEach(entry => entry.isIntersecting && loadMore()), {
        rootMargin: '-250px 0px 0px 0px'
    })
    observer.observe(loadMoreIntersect.value)
})

</script>

<template>
    <div class="overflow-auto">
        <PostItem v-for="post of allPosts.data" :key="post.id" :post="post" @editClick="openEditModal"
            @attachmentClick="openPreviewModal" />
        <div ref="loadMoreIntersect"></div>
        <PostModal :post="editPost" v-model="showEditModal" @hide="onHideModal" />
        <AttachmentPreviewModal :attachments="previewPostAttachment.post?.attachments || []"
            v-model:index="previewPostAttachment.index" v-model="showPreviewModal" />
    </div>
</template>
