<script setup>
import { ref } from "vue";

const postCreating = ref(false);
</script>

<template>
  <div class="p-4 mb-4 bg-gray-100 rounded">
    <div @click="postCreating = true" class="px-2 py-3 text-gray-400 border border-2 border-gray-200 rounded-lg">
      click here to create new post
    </div>

    <div v-if="postCreating">
      <div class="flex items-center justify-end mt-6 gap-x-6">
        <button
            @click="postCreating = false"
          type="button"
          class="text-sm font-semibold leading-6 text-gray-900"
        >
          Cancel
        </button>
        <button
          type="submit"
          class="relative rounded-md border-none px-2.5 py-1.5 text-sm font-semibold text-gray-900 hover:bg-gray-50"
        >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-12 h-6">
            <path fill-rule="evenodd" d="M18.97 3.659a2.25 2.25 0 0 0-3.182 0l-10.94 10.94a3.75 3.75 0 1 0 5.304 5.303l7.693-7.693a.75.75 0 0 1 1.06 1.06l-7.693 7.693a5.25 5.25 0 1 1-7.424-7.424l10.939-10.94a3.75 3.75 0 1 1 5.303 5.304L9.097 18.835l-.008.008-.007.007-.002.002-.003.002A2.25 2.25 0 0 1 5.91 15.66l7.81-7.81a.75.75 0 0 1 1.061 1.06l-7.81 7.81a.75.75 0 0 0 1.054 1.068L18.97 6.84a2.25 2.25 0 0 0 0-3.182Z" clip-rule="evenodd" />
          </svg>

          <input
            type="file"
            class="absolute top-0 bottom-0 left-0 right-0 opacity-0"
          />
        </button>
        <button
          type="submit"
          class="px-3 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
        >
          Submit
        </button>
      </div>
    </div>
  </div>
</template>
