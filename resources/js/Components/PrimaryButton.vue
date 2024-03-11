<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    href: String
})
</script>

<template>
    <Link v-if="href" :href="href"
        class="px-3 py-2 text-sm font-semibold text-blue-500 bg-indigo-200 rounded-lg shadow-sm hover:bg-indigo-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        <slot />
    </Link>
    <button v-else
        class="px-3 py-2 text-sm font-semibold text-blue-500 bg-indigo-200 rounded-lg shadow-sm hover:bg-indigo-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        <slot />
    </button>
</template>
