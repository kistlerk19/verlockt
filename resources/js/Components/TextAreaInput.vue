<script setup>
import { onMounted, ref } from "vue";

const props = defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    placeholder: String,
    autoResize: {
        type: Boolean,
        default: true
    }
});


const emit = defineEmits(['update:modelValue']);

const input = ref(null);

const adjustHeight = () => {
    if(props.autoResize)
    {
        input.value.style.height = 'auto';
        input.value.style.height = input.value.scrollHeight + 'px';
    }
}

onMounted(() => {
    adjustHeight()
});

defineExpose({ focus: () => input.value.focus() });

function onInputChange ($event)
{
    emit('update:modelValue', $event.target.value)

    adjustHeight()
}
</script>

<template>
  <textarea
    class="text-gray-700 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
    :value="modelValue"
    @input="onInputChange"
    ref="input"
    :placeholder="placeholder"
  />
</template>
