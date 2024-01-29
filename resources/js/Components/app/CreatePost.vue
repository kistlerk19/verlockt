<script setup>
import { ref } from "vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import PostModal from "@/Components/app/PostModal.vue";
import { useForm, usePage } from "@inertiajs/vue3";


const authUser = usePage().props.auth.user;
const showModal = ref(false);
const newPost = ref({
    id: null,
    body: '',
    user: authUser
})

// const newPostForm = useForm({
//     body: ''
// })

// function submit(){
//     newPostForm.post(route('post.create'), {
//         onSuccess: () => {
//             newPostForm.reset()
//         }
//     })
// }

function showCreatePost()
{
    showModal.value = true
}

</script>

<template>
  <div class="p-4 mb-4 bg-gray-100 rounded">
    <div
      @click="showCreatePost"
      rows="1"
      class="w-full px-3 py-2 mb-3 text-gray-500 border-2 border-gray-300 rounded-md shadow-lg focus:border-indigo-500 focus:ring-indigo-500"
    >Click to create post</div>

    <div>
      <!-- <div class="flex items-center justify-end mt-6 gap-x-6">
        <button
          @click="showCreatePost"
          type="button"
          class="text-sm font-semibold leading-6 text-gray-900 rounded-full"
        >
          Cancel
        </button>
        <button
          type="button"
          class="relative rounded-full border-none px-2.5 py-1.5 text-sm font-semibold text-gray-900 hover:bg-gray-50"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="w-12 h-6"
          >
            <path
              fill-rule="evenodd"
              d="M18.97 3.659a2.25 2.25 0 0 0-3.182 0l-10.94 10.94a3.75 3.75 0 1 0 5.304 5.303l7.693-7.693a.75.75 0 0 1 1.06 1.06l-7.693 7.693a5.25 5.25 0 1 1-7.424-7.424l10.939-10.94a3.75 3.75 0 1 1 5.303 5.304L9.097 18.835l-.008.008-.007.007-.002.002-.003.002A2.25 2.25 0 0 1 5.91 15.66l7.81-7.81a.75.75 0 0 1 1.061 1.06l-7.81 7.81a.75.75 0 0 0 1.054 1.068L18.97 6.84a2.25 2.25 0 0 0 0-3.182Z"
              clip-rule="evenodd"
            />
          </svg>

          <input
            type="file"
            class="absolute top-0 bottom-0 left-0 right-0 opacity-0"
          />
        </button>
        <button
        @click="submit"
          type="submit"
          class="px-3 py-2 text-sm font-semibold text-gray-700 bg-indigo-200 rounded-full shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
        >
          Submit
        </button>
      </div> -->
    </div>

    <PostModal :post="newPost" v-model="showModal" />
  </div>
</template>
