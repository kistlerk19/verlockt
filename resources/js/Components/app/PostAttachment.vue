<script setup>
import { ArrowDownTrayIcon, DocumentIcon } from "@heroicons/vue/24/outline";
import { isImage } from "@/helpers.js";

defineProps({
    attachments: Array
})

defineEmits(['attachmentClick'])
</script>
<template>
  <template v-for="(attachment, index) of attachments.slice(0, 4)" :key="attachment.id">
    <div @click="$emit('attachmentClick', index)"
         class="relative flex flex-col items-center justify-center text-gray-500 bg-blue-200 rounded cursor-pointer group aspect-square">
      <div v-if="index === 3 && attachments.length > 4"
           class="absolute top-0 bottom-0 left-0 right-0 z-10 flex items-center justify-center text-xl text-white bg-black/60">
        + {{ attachments.length - 4 }}
      </div>
      <!-- download -->
      <a @click.stop :href="route('post.download', attachment)"
         class="absolute flex items-center justify-center w-8 h-8 text-white rounded opacity-0 cursor-pointer bg-black/20 group-hover:opacity-100 hover:bg-black/80 top-2 right-2">
        <ArrowDownTrayIcon class="p-2"/>
      </a>

      <img v-if="isImage(attachment)" :src="attachment.url"
           class="object-cover rounded nowrap aspect-square"/>

      <div v-else class="flex flex-col items-center justify-center">
        <!-- file -->
        <DocumentIcon class="w-12 h-12"/>
        <small>{{ attachment.name }}</small>
      </div>

    </div>
  </template>
</template>
