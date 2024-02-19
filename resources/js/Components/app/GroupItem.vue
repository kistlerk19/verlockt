<script setup>
    defineProps({
        group: Object,
    })
</script>

<template>
    <div class="mb-3 rounded-md cursor-pointer hover:bg-gray-200">
        <div class="flex items-start gap-1 px-2 py-2">
            <img :src="group.thumbnail_url" alt="" class="w-[32px] rounded-full gap-3"/>
            <div class="flex-1">
                <div class="flex justify-between">
                    <h3 class="text-lg font-bold">{{ group.name }}</h3>
                    {{ group.status === 'approved' ? (group.role === 'admin' ? group.role : '') : 'pending' }}
                </div>
                <div class="text-xs text-gray-500">
                    {{  group.description  }}
                </div>
            </div>
        </div>

    </div>
</template>



<style>

</style>
