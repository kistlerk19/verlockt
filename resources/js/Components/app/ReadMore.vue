<script setup>
import {Disclosure, DisclosurePanel, DisclosureButton} from "@headlessui/vue";

const props = defineProps({
    content: String,
    contentClass: String
})

</script>


<template>
    <Disclosure v-slot="{ open }">
        <div class="ck-content-output" :class="contentClass" v-if="!open" v-html="content.substring(0, 200)" />

        <template v-if="props.content && props.content.length > 200">
            <DisclosurePanel>
                <div class="ck-content-output" :class="contentClass" v-html="content" />
            </DisclosurePanel>
            <DisclosureButton
                class="flex items-center justify-end w-full px-4 py-2 text-sm font-medium text-left text-blue-500 rounded-lg hover:underline focus:outline-none focus-visible:ring">
                {{ open ? "Read less" : "Read more..." }}
            </DisclosureButton>
        </template>
    </Disclosure>
</template>

