<script setup>
import { Link } from '@inertiajs/vue3';
    defineProps({
        group: Object,
    })

</script>

<template>
    <div class="mb-3 rounded-md cursor-pointer hover:bg-gray-200">
        <!-- <Link :href="route('group.info', group.slug)" class="flex items-start gap-1 px-2 py-2">
            <img :src="group.thumbnail_url" alt="" class="w-[32px] h-[32px] object-cover rounded-full gap-3"/>
            <div class="flex-1">
                <div class="flex justify-between">
                    <h3 class="text-lg font-bold">{{ group.name }}</h3>
                    {{ group.status === 'approved' ? (group.role === 'admin' ? group.role : '') : 'pending' }}
                </div>
                <div class="text-xs text-gray-500">
                    {{  group.description  }}
                </div>
            </div>
        </Link> -->

        <Link :href="route('group.info', group.slug)" class="flex items-start gap-1 px-2 py-2">
            <img :src="group.thumbnail_url" class="w-[32px] rounded-full"/>
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <h3 class="font-black">{{ group.name }}</h3>
                </div>
<!--                <div class="text-xs text-gray-500" v-html="group.description"></div>-->
                <span class="text-xs">
                    {{ group.status === 'approved' ? (group.role === 'admin' ? group.role : '') : 'not approved' }}
                </span>
            </div>
        </Link>

    </div>
</template>



<style scoped>

</style>
