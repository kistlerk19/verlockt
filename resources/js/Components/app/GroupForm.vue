<script setup>

import Checkbox from "@/Components/Checkbox.vue";
import TextInput from "@/Components/TextInput.vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
// import CKEditor from '@ckeditor/ckeditor5-vue';

defineProps({
    form: Object
})

const editor = ClassicEditor;
const editorConfig = {
    toolbar: ['bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'heading', '|', 'outdent', 'indent', '|', 'link', '|', 'blockQuote'],
}

</script>

<template>
    <div class="mb-3">
        <label >Group Name</label>
        <TextInput
            type="text"
            class="block w-full mt-1 rounded-lg"
            v-model="form.name"
            required
            autofocus
        />
    </div>

    <div class="mb-3">
        <label >
            <Checkbox name="remember" v-model:checked="form.auto_approval"/>
            Enable Auto Approval
        </label>
    </div>

    <div class="mb-3">
        <label >About Group</label>
        <ckeditor  :editor="editor" v-model="form.description" :config="editorConfig"></ckeditor>
    </div>
</template>

<style scoped>

</style>
