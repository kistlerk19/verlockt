<script setup>
import { ref } from "vue";

const postCreating = ref(false);
</script>

<template>
  <div class="py-6">
    <div @click="postCreating = true" class="px-2 py-3 text-gray-500 border border-gray-400 rounded-md">
      Create New Post
    </div>

    <div v-if="postCreating">
      <div class="flex items-center justify-end mt-6 gap-x-6">
        <button
          type="button"
          class="text-sm font-semibold leading-6 text-gray-900"
        >
          Cancel
        </button>
        <button
          type="submit"
          class="relative rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
        >
          Attach Files
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
