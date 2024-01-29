<script setup>
import { computed, onMounted, ref, watch, onUpdated, reactive } from 'vue'
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'
import TextAreaInput from '@/Components/TextAreaInput.vue';
import PostUserHeader from '@/Components/app/PostUserHeader.vue';
import { XMarkIcon } from '@heroicons/vue/24/solid';
import { useForm } from '@inertiajs/vue3';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
// import BalloonEditor from '@ckeditor/ckeditor5-build-balloon';


const editor = ClassicEditor
const editorConfig = {
    toolbar: ['heading', 'bold', 'italic', '|', 'undo', '|',  'link', 'numberedList', 'bulletedList', 'blockQuote', '|', 'outdent', 'indent' ],
    balloonToolbar: ['heading', 'bold', 'italic', '|', 'undo', '|',  'link', 'numberedList', 'bulletedList', 'blockQuote', '|', 'outdent', 'indent' ]
}

const props = defineProps({
  post: {
    type: Object,
    required: true
  },
  modelValue: Boolean
})

const form = useForm({
  id: null,
  body: ''
})


const show = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value)
})

const emit = defineEmits(['update:modelValue'])

watch(() => props.post, () => {
  form.id = props.post.id
  form.body = props.post.body
})

// onUpdated(() => {
//   console.log('***************************************************');
//   console.log("Updated");
//   console.log('***************************************************');
// }),

function update() {
//   const form = useForm({
//     id: props.post.id,
//     body: props.post.body,
//   })

    if(form.id)
    {
        form.put(route('post.update', props.post.id), {
            preserveScroll: true,
            onSuccess: () => {
            show.value = false
            form.reset()
            }
        })
    } else {
        form.post(route('post.create'), {
            preserveScroll: true,
            onSuccess: () => {
                show.value = false
                form.reset()
            }
        })
    }


}

// onMounted(() => {
//   console.log('***************************************************');
//   console.log(props.post);
//   console.log('***************************************************');
// })

</script>

<template>
  <teleport to='body'>
    <TransitionRoot appear :show="show" as="template">
      <Dialog as="div" class="relative z-10">
        <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
          leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 bg-black/25" />
        </TransitionChild>

        <div class="fixed inset-0 overflow-y-auto">
          <div class="flex items-center justify-center min-h-full p-4 text-center">
            <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
              enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
              leave-to="opacity-0 scale-95">
              <DialogPanel
                class="w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <DialogTitle as="h3"
                  class="flex items-center justify-between px-4 py-3 text-lg font-medium leading-6 text-gray-900 bg-gray-200 rounded-lg">
                  {{ form.id ? 'EDIT POST' : 'CREATE NEW POST' }}
                  <button @click="show = false"
                    class="flex items-center justify-center px-2 py-2 text-sm transition rounded-full hover:bg-black/10">
                    <XMarkIcon class="w-4 h-4 " />
                  </button>
                </DialogTitle>
                <div class="px-4 py-3 mt-2">
                  <PostUserHeader :post="post" :show-time="false" class="mb-3" />
                  <ckeditor :editor="editor" v-model="form.body" :config="editorConfig"></ckeditor>
                  <!-- <TextAreaInput v-model="form.body" row="5" class="w-full mb-3" /> -->
                </div>

                <div class="px-4 py-3 mt-4">
                  <button type="button"
                    class="w-full px-3 py-2 text-sm font-semibold text-gray-700 bg-indigo-200 rounded-full shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    @click="update">
                    Save
                  </button>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </teleport>
</template>
