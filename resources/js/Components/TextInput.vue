<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

defineProps({
    placeholder: String
})

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="text-gray-700 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 "
        v-model="model"
        ref="input"
        :placeholder="placeholder"
    />
</template>
