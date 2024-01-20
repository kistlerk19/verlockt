<script setup>
    defineProps({
        name: String,
        avatar: String,
    })
</script>

<template>
    <div class="mb-3 rounded-md cursor-pointer hover:bg-gray-200">
        <div class="flex items-start gap-1 px-2 py-2">
            <img :src="avatar" alt="" class="w-[32px] rounded-full gap-3"/>
            <div>
                <h3 class="font-bold">{{ name }}</h3>
            </div>
        </div>

    </div>
</template>



<style>

</style>
