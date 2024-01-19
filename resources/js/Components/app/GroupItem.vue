<script setup>
    defineProps({
        image: String,
        title: String,
        description: String,
    })
</script>

<template>
    <div class="mb-3 rounded-md cursor-pointer hover:bg-gray-100">
        <div class="flex items-start gap-1 px-2 py-2">
            <img :src="image" alt="" class="w-[32px] rounded-full gap-3"/>
            <div>
                <h3 class="text-lg font-bold">{{ title }}</h3>
                <div class="text-xs text-gray-500">
                    {{  description  }}
                </div>
            </div>
        </div>

    </div>
</template>



<style>

</style>
