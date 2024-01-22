<script setup>
    defineProps({
        selected: Boolean,
        text: String,
    })
</script>

<template>
    <button
                :class="[
                  'rounded px-3 py-2.5 text-sm font-medium leading-5',
                  'focus:outline-none',
                  selected
                    ? 'shadow-lg text-blue-500 border-b border-b-2 border-indigo-500 bg-indigo-200'
                    : 'text-gray-700',
                ]"
              >
                {{text}}
              </button>
</template>
