<script setup>
import { onMounted, ref, watch } from "vue";

const props = defineProps({
    modelValue: {
        type: String,
        required: false,
    },
    placeholder: String,
    autoResize: {
        type: Boolean,
        default: true
    }
});

watch(() => props.modelValue,() => {
    setTimeout(() => {
        adjustHeight()
    }, 10)
})

const emit = defineEmits(['update:modelValue']);

const input = ref(null);

const adjustHeight = () => {
    if(props.autoResize)
    {
        input.value.style.height = 'auto';
        input.value.style.height = (input.value.scrollHeight + 1) + 'px';
    }
}

onMounted(() => {
    adjustHeight()
});

defineExpose({ focus: () => input.value.focus() });

function onInputChange ($event)
{
    emit('update:modelValue', $event.target.value)
}
</script>

<template>
  <textarea
    class="text-gray-700 border-gray-300 rounded-lg shadow-sm "
    :value="modelValue"
    @input="onInputChange"
    ref="input"
    :placeholder="placeholder"
  />
</template>
