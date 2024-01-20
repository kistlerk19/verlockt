<script setup>
import PostItem from "@/Components/app/PostItem.vue";

const post1 = {
  user: {
    id: 1,
    avatar: 'https://randomuser.me/api/portraits/men/79.jpg',
    name: "Cédric Lethiais",
  },
  group: {
    id: 1,
    name: 'Normandies'
  },
  attachments: [
    {
        id: 1,
        name: 'test.png',
        url: 'https://picsum.photos/1000',
        mime: 'image/png',
    },
    {
        id: 4,
        name: 'test1.png',
        url: 'https://picsum.photos/1000',
        mime: 'image/png',
    },
    {
        id: 2,
        name: 'test.pdf',
        url: '#',
        mime: 'application/pdf',
    },
    {
        id: 3,
        name: 'test.docx',
        url: '#',
        mime: 'application/msword',
    },
  ],
  body: `<p>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eaque hic similique cupiditate quos aut! Mollitia obcaecati quae unde reprehenderit tenetur necessitatibus eligendi quasi aliquid. Obcaecati sed vitae dolor laboriosam aliquam.
        </p>
        <p>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eaque hic similique cupiditate quos aut! Mollitia obcaecati quae unde reprehenderit tenetur necessitatibus eligendi quasi aliquid. Obcaecati sed vitae dolor laboriosam aliquam.
        </p>
        <p>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eaque hic similique cupiditate quos aut! Mollitia obcaecati quae unde reprehenderit tenetur necessitatibus eligendi quasi aliquid. Obcaecati sed vitae dolor laboriosam aliquam.
        </p>`,
  created_at: '2024-01-20 00:41',
};
const post2 = {
  user: {
    id: 2,
    avatar: 'https://randomuser.me/api/portraits/men/53.jpg',
    name: "Charles Leclerc",
  },
  group: null,
  body: `<p>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eaque hic similique cupiditate quos aut! Mollitia obcaecati quae unde reprehenderit tenetur necessitatibus eligendi quasi aliquid. Obcaecati sed vitae dolor laboriosam aliquam.
        </p>
        <p>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eaque hic similique cupiditate quos aut! Mollitia obcaecati quae unde reprehenderit tenetur necessitatibus eligendi quasi aliquid. Obcaecati sed vitae dolor laboriosam aliquam.
        </p>
        <p>
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eaque hic similique cupiditate quos aut! Mollitia obcaecati quae unde reprehenderit tenetur necessitatibus eligendi quasi aliquid. Obcaecati sed vitae dolor laboriosam aliquam.
        </p>`,
  created_at: '2024-01-20 00:41',
};
</script>

<template>
  <div class="overflow-auto">
    <PostItem :post="post1" />
    <PostItem :post="post1" />
    <PostItem :post="post1" />
    <PostItem :post="post2" />
  </div>
</template>
