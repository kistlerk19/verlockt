<script setup>
import { ref, computed, reactive } from "vue";
import { Head, usePage, router, useForm } from "@inertiajs/vue3";
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TabItem from "./Partials/TabItem.vue";
import Edit from "./Edit.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { XMarkIcon, ArrowUpTrayIcon, CameraIcon } from "@heroicons/vue/24/solid";

const props = defineProps({
    errors: Object,
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    success: {
        type: String,
    },
    user: {
        type: Object,
    },
});
const imageForm = useForm({
    cover: null,
    avatar: null,
});

const coverImageSrc = ref("");
const avatarImageSrc = ref("");
const authUser = usePage().props.auth.user;
const isMyProfile = computed(() => authUser && authUser.id === props.user.id);
const showNotification = ref(true);

function onCoverChange(event) {
    imageForm.cover = event.target.files[0];

    if (imageForm.cover) {
        const reader = new FileReader();
        reader.onload = () => {
            coverImageSrc.value = reader.result;
        };

        reader.readAsDataURL(imageForm.cover);
    }
}
function onAvatarChange(event) {
    imageForm.avatar = event.target.files[0];

    if (imageForm.avatar) {
        const reader = new FileReader();
        reader.onload = () => {
            avatarImageSrc.value = reader.result;
        };

        reader.readAsDataURL(imageForm.avatar);
    }
}

function submitCoverImage() {
    imageForm.post(route("profile.image.update"), {
        preserveScroll: true,
        onSuccess: (user) => {
            showNotification.value = true
            resetCoverImage();
            setTimeout(() => {
                showNotification.value = false;
            }, 5000);
        },
    });
}
function submitAvatarImage() {
    imageForm.post(route("profile.image.update"), {
        preserveScroll: true,
        onSuccess: (user) => {
            showNotification.value = true
            resetAvatarImage();
            setTimeout(() => {
                showNotification.value = false;
            }, 5000);
        },
    });
}
function resetCoverImage() {
    imageForm.cover = null;
    coverImageSrc.value = null;
}
function resetAvatarImage() {
    imageForm.avatar = null;
    avatarImageSrc.value = null;
}
</script>

<template>
    <AuthenticatedLayout>
        <!-- max-w-[800px] -->
        <div class="container h-full mx-auto overflow-auto">
            <!-- Success Notification -->
            <div v-show="showNotification && success"
                class="px-3 py-2 my-2 mt-2 text-sm font-medium text-gray-100 bg-blue-300 rounded">
                {{ success }}
            </div>
            <div v-if="errors.cover" class="px-3 py-2 my-2 mt-2 text-sm font-medium text-gray-100 bg-red-400 rounded">
                {{ errors.cover }}
            </div>

            <div class="relative group">

                <img class="object-cover rounded-md h-[200px] w-full" :src="coverImageSrc || user.cover_url" alt="" />
                <div class="absolute top-2 right-2">
                    <button v-if="!coverImageSrc"
                        class="flex items-center px-2 py-1 text-xs text-gray-700 rounded opacity-0 group-hover:opacity-100 bg-gray-50 hover:bg-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-2 h-2 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                        </svg>

                        Update Cover
                        <input @change="onCoverChange" type="file"
                            class="absolute top-0 bottom-0 left-0 right-0 opacity-0 cursor-pointer" />
                    </button>
                    <div v-else class="flex gap-2">
                        <button @click="resetCoverImage"
                            class="flex items-center px-2 py-1 text-xs text-gray-700 rounded opacity-0 group-hover:opacity-100 bg-gray-50 hover:bg-gray-300">
                            <XMarkIcon class="w-3 h-3 mr-2" />
                            Cancel
                        </button>
                        <button @click="submitCoverImage"
                            class="flex items-center px-2 py-1 text-xs text-gray-100 bg-gray-700 rounded opacity-0 group-hover:opacity-100 hover:bg-gray-900">
                            <ArrowUpTrayIcon class="w-3 h-3 mr-2" />
                            Update
                        </button>
                    </div>
                </div>

                <div class="flex">

                    <div
                        class="relative flex overflow-hidden items-center justify-center group/avatar w-[128px] h-[128px] -mt-[64px] ml-[54px]">
                        <img class="object-cover w-full h-full rounded-full" :src="avatarImageSrc || user.avatar_url"
                            alt="" />
                        <div class="absolute top-0 bottom-0 left-0 right-0 ">
                            <button v-if="!avatarImageSrc"
                                class="absolute top-0 bottom-0 left-0 right-0 flex items-center justify-center text-xs text-gray-300 rounded-full opacity-0 bg-black/80 group-hover/avatar:opacity-100">
                                <CameraIcon class="w-8 h-8" />
                                <!-- Update Avatar -->
                                <input @change="onAvatarChange" type="file"
                                    class="absolute top-0 bottom-0 left-0 right-0 opacity-0 cursor-pointer" />
                            </button>
                            <div v-else class="absolute flex gap-2 right-1 top-1">
                                <button @click="resetAvatarImage"
                                    class="flex items-center p-2 text-xs text-gray-700 bg-red-700 rounded-full opacity-0 group-hover:opacity-100 hover:bg-red-900/80">
                                    <XMarkIcon class="w-5 h-5" />
                                    <!-- Cancel Avatar -->
                                </button>
                                <button @click="submitAvatarImage"
                                    class="flex items-center p-2 text-xs text-gray-100 rounded-full opacity-0 bg-emerald-700 group-hover:opacity-100 hover:bg-emerald-700/80">
                                    <ArrowUpTrayIcon class="w-5 h-5" />
                                    <!-- Avatar Update -->
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between flex-1 p-2">
                        <h2 class="text-lg font-bold">
                            {{ user.name }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <TabGroup>
                    <TabList class="flex pl-[200px] pt-2">
                        <Tab v-slot="{ selected }">
                            <TabItem text="Posts" as="template" :selected="selected" />
                        </Tab>
                        <Tab v-slot="{ selected }">
                            <TabItem text="Following" as="template" :selected="selected" />
                        </Tab>
                        <Tab v-slot="{ selected }">
                            <TabItem text="Followers" as="template" :selected="selected" />
                        </Tab>
                        <Tab v-slot="{ selected }">
                            <TabItem text="Media" as="template" :selected="selected" />
                        </Tab>
                        <Tab v-if="isMyProfile" v-slot="{ selected }">
                            <TabItem text="My Profile" as="template" :selected="selected" />
                        </Tab>
                    </TabList>

                    <TabPanels class="mt-2">
                        <TabPanel class="p-3 bg-white rounded shadow"> Posts </TabPanel>
                        <TabPanel class="p-3 bg-white rounded shadow"> Following </TabPanel>
                        <TabPanel class="p-3 bg-white rounded shadow"> Followers </TabPanel>
                        <TabPanel class="p-3 bg-white rounded shadow"> Media </TabPanel>
                        <TabPanel v-if="isMyProfile" class="p-4">
                            <Edit :must-verify-email="mustVerifyEmail" :status="status" />
                        </TabPanel>
                    </TabPanels>
                </TabGroup>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


