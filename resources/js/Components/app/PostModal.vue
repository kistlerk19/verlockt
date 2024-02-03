<script setup>
import { computed, onMounted, ref, watch, onUpdated, reactive } from "vue";
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from "@headlessui/vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import PostUserHeader from "@/Components/app/PostUserHeader.vue";
import { DocumentIcon, XMarkIcon, PaperClipIcon } from "@heroicons/vue/24/solid";
import { useForm } from "@inertiajs/vue3";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { isImage } from "@/helpers";
import { ArrowUturnLeftIcon } from "@heroicons/vue/24/outline";
// import BalloonEditor from '@ckeditor/ckeditor5-build-balloon';

const editor = ClassicEditor;
const editorConfig = {
  toolbar: [ "heading", "bold", "italic", "|", "undo", "|", "link", "numberedList", "bulletedList", "blockQuote", "|", "outdent", "indent",
  ],
  balloonToolbar: [ "heading", "bold", "italic", "|", "undo", "|", "link", "numberedList", "bulletedList", "blockQuote", "|", "outdent", "indent",
  ],
};

const props = defineProps({
  post: {
    type: Object,
    required: true,
  },
  modelValue: Boolean,
});

const attachmentFiles = ref([]);

const form = useForm({
  body: "",
  attachments: [],
  deleted_file_ids: [],
  _method: 'POST'
});

const show = computed({
  get: () => props.modelValue,
  set: (value) => emit("update:modelValue", value),
});

const computedAttachments = computed(() => {
    return [...attachmentFiles.value, ...(props.post.attachments || [])];
})

const emit = defineEmits(["update:modelValue", "hide"]);

watch(
  () => props.post,
  () => {
    form.body = props.post.body || '';
  }
);

const closeModal = () => {
  show.value = false;
  emit('hide')
  resetModal();
};

const resetModal = () => {
  form.reset();
  attachmentFiles.value = [];
  if (props.post.attachments) {
        props.post.attachments.forEach(file => file.deleted = false)
    }
};

function update() {
  form.attachments = attachmentFiles.value.map((atFile) => atFile.file);

  if (props.post.id) {
    form._method = 'PUT'
    form.post(route("post.update", props.post.id), {
      preserveScroll: true,
      onSuccess: () => {
        closeModal();
      },
    });
  } else {
    form.post(route("post.create"), {
      preserveScroll: true,
      onSuccess: () => {
        closeModal();
      },
    });
  }
}

async function onFileAttached($event) {
  for (const file of $event.target.files) {
    const atFile = {
      file,
      url: await readFile(file),
    };
    attachmentFiles.value.push(atFile);
  }

  $event.target.value = null;
//   console.log(attachmentFiles.value);
}

async function readFile(file) {
  return new Promise((res, rej) => {
    if (isImage(file)) {
      const reader = new FileReader();

      reader.onload = () => {
        res(reader.result);
      };

      reader.onerror = rej;

      reader.readAsDataURL(file);
    } else {
      res(null);
    }
  });
}

function removeFile(atFile) {
    if(atFile.file){
        attachmentFiles.value = attachmentFiles.value.filter((f) => f !== atFile);
    } else {
        form.deleted_file_ids.push(atFile.id)
        atFile.deleted = true
    }
}

function undoDelete(atFile)
{
    atFile.deleted = false
    form.deleted_file_ids = form.deleted_file_ids.filter(id => atFile.id !== id)
}
</script>

<template>
  <teleport to="body">
    <TransitionRoot appear :show="show" as="template">
      <Dialog as="div" @close="closeModal" class="relative z-50">
        <TransitionChild
          as="template"
          enter="duration-300 ease-out"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="duration-200 ease-in"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <div class="fixed inset-0 bg-black/25" />
        </TransitionChild>

        <div class="fixed inset-0 w-screen overflow-y-auto">
          <div
            class="flex items-center justify-center min-h-full p-4 text-center"
          >
            <TransitionChild
              as="template"
              enter="duration-300 ease-out"
              enter-from="opacity-0 scale-95"
              enter-to="opacity-100 scale-100"
              leave="duration-200 ease-in"
              leave-from="opacity-100 scale-100"
              leave-to="opacity-0 scale-95"
            >
              <DialogPanel
                class="w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl"
              >
                <DialogTitle
                  as="h3"
                  class="flex items-center justify-between px-4 py-3 text-lg font-medium leading-6 text-gray-900 bg-gray-200 rounded-full"
                >
                  {{ post.id ? "EDIT POST" : "CREATE NEW POST" }}
                  <button
                    @click="closeModal"
                    class="flex items-center justify-center px-2 py-2 text-sm transition rounded-full hover:bg-black/10"
                  >
                    <XMarkIcon class="w-4 h-4" />
                  </button>
                </DialogTitle>
                <div class="px-4 py-3 mt-2">
                  <PostUserHeader
                    :post="post"
                    :show-time="false"
                    class="mb-3"
                  />
                  <ckeditor
                    :editor="editor"
                    v-model="form.body"
                    :config="editorConfig"
                  ></ckeditor>
                  <div
                    class="grid gap-3 my-3"
                    :class="
                    computedAttachments.length === 1
                        ? 'grid-cols-1'
                        : 'grid-cols-2'
                    "
                  >
                    <template
                      v-for="(atFile, index) of computedAttachments"
                      :key="atFile.id"
                    >
                    <div
                        class="relative flex flex-col items-center justify-center text-gray-500 bg-blue-200 rounded group aspect-square"
                      >
                      <div v-if="atFile.deleted" class="absolute bottom-0 left-0 right-0 z-10 flex items-center justify-between px-3 py-2 text-sm text-white bg-black">
                        To be deleted.
                        <ArrowUturnLeftIcon @click="undoDelete(atFile)" class="w-4 h-4 cursor-pointer"/>
                      </div>
                        <button
                          @click="removeFile(atFile)"
                          class="absolute flex items-center p-2 text-xs text-white rounded-full opacity-0 right-1 top-1 bg-red-700/40 group-hover:opacity-100 hover:bg-red-900/80"
                        >
                          <XMarkIcon class="w-5 h-5" />
                          <!-- Cancel Avatar -->
                        </button>
                        <img
                          v-if="isImage( atFile.file || atFile)"
                          :src="atFile.url"
                          class="object-contain rounded aspect-square" :class="atFile.deleted ? 'opacity-20' : ''"
                        />

                        <div class="flex flex-col items-center justify-center" :class="atFile.deleted ? 'opacity-20' : ''" v-else>
                          <!-- file -->
                          <DocumentIcon class="w-12 h-12 mb-3" />
                          <small class="text-center">{{
                            (atFile.file || atFile).name
                          }}</small>
                        </div>
                      </div>
                    </template>
                  </div>


                </div>

                <div class="flex gap-2 px-4 py-3 mt-4">
                  <button
                    type="button"
                    class="relative w-full justify-center items-center flex rounded-full border-none px-2.5 py-1.5 text-sm font-semibold text-gray-900 hover:bg-gray-50"
                  >
                    <PaperClipIcon class="w-6 h-6 mr-2" />

                    <input
                      @click.stop
                      @change="onFileAttached"
                      type="file"
                      multiple
                      class="absolute top-0 bottom-0 left-0 right-0 opacity-0"
                    />
                  </button>
                  <button
                    type="button"
                    class="w-full px-3 py-2 text-sm font-semibold text-gray-700 bg-indigo-200 rounded-full shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    @click="update"
                  >
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
