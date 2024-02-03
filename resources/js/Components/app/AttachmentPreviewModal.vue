<script setup>
import { computed } from "vue";
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from "@headlessui/vue";
import { isImage } from "@/helpers";
import { ChevronLeftIcon, ChevronRightIcon, DocumentIcon, XMarkIcon } from "@heroicons/vue/24/outline";


const props = defineProps({
  attachments: {
    type: Array,
    required: true,
  },
  index: Number,
  modelValue: Boolean,
});

const show = computed({
  get: () => props.modelValue,
  set: (value) => emit("update:modelValue", value),
});
const currentIndex = computed({
  get: () => props.index,
  set: (value) => emit("update:index", value),
});
const attachment = computed(() => {
    return props.attachments[currentIndex.value]
})
const emit = defineEmits(["update:modelValue", "update:index", "hide"]);

function prev(){
    if (currentIndex.value === 0) return;
    currentIndex.value--
}
function next(){
    if (currentIndex.value === props.attachments.length - 1) return;
    currentIndex.value++
}

const closeModal = () => {
  show.value = false;
  emit('hide')
};

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

        <div class="fixed inset-0 overflow-y-auto">
          <div
            class="items-center justify-center w-screen h-screen"
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
                class="flex flex-col w-full p-6 overflow-hidden text-left align-middle transition-all transform bg-white rounded shadow-xl"
              >
              <button
                @click="closeModal"
                class="absolute z-30 flex items-center justify-center px-2 py-2 text-sm transition rounded-full right-3 top-3 hover:bg-black/10"
                >
                <XMarkIcon class="w-4 h-4" />
                </button>
                <div class="relative h-full bg-slate-800 group">
                    <div @click="prev" class="absolute left-0 flex items-center w-16 h-full text-white opacity-0 cursor-pointer group-hover:opacity-100 bg-black/20">
                        <ChevronLeftIcon class="w-16"/>
                    </div>
                    <div @click="next" class="absolute right-0 flex items-center w-16 h-full text-white opacity-0 cursor-pointer group-hover:opacity-100 bg-black/20">
                        <ChevronRightIcon class="w-16"/>
                    </div>
                    <div class="flex items-center justify-center w-full h-full p-3">
                        <img
                            v-if="isImage(attachment)"
                            :src="attachment.url"
                            class="max-w-full max-h-full"
                        />

                        <div v-else class="flex flex-col items-center justify-center p-32 text-white">
                            <!-- file -->
                            <DocumentIcon class="w-12 h-12" />
                            <small>{{ attachment.name }}</small>
                        </div>
                    </div>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </teleport>
</template>
