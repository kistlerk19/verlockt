<script setup>
import { Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
    defineProps({
        user: Object,
        approveButton: {
            type: Boolean,
            default: false
        }
    })

    defineEmits(['approve'])
</script>

<template>
    <div class="border-2 border-transparent rounded-md cursor-pointer hover:bg-gray-200">
        <Link :href="route('profile', user.username)" class="flex items-start gap-1 px-2 py-2">
            <img :src="user.avatar_url" alt="" class="w-[32px] h-[32px] rounded-full gap-3"/>
            <div class="flex justify-between flex-1">
                <h3 class="font-bold">{{ user.name }}</h3>
                <div class="flex gap-1">
                    <PrimaryButton v-if="approveButton" @click.prevent.stop="$emit('approve', user)">Approve</PrimaryButton>
                    <button v-if="approveButton" class="px-3 py-2 text-sm font-semibold text-blue-300 bg-red-400 rounded-lg shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600" @click.prevent.stop="$emit('reject', user)">
                        Reject
                    </button>
                </div>
            </div>
        </Link>

    </div>
</template>



<style>

</style>
