<script setup>
import { ref, computed, reactive } from "vue";
import { Head, usePage, router, useForm } from "@inertiajs/vue3";
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TabItem from "./Partials/TabItem.vue";
import Edit from "./Edit.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { XMarkIcon, ArrowUpTrayIcon } from "@heroicons/vue/24/solid";

const props = defineProps({
  errors: Object,
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
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

const authUser = usePage().props.auth.user;

const isMyProfile = computed(() => authUser && authUser.id === props.user.id);

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

function submitCoverImage() {
  imageForm.post(route("profile.image.update"), {
    onSuccess: (user) => {
      console.log("====================================");
      console.log(user);
      console.log("====================================");
    },
  });
}
function cancelCoverImage() {
  imageForm.cover = null;
  coverImageSrc.value = null;
}
</script>

<template>
  <AuthenticatedLayout>
    <!-- <pre>{{ errors }}</pre> -->
    <!-- max-w-[800px] -->
    <div class="container h-full mx-auto overflow-auto">
      <div
        v-show="status === 'cover-image-updated'"
        class="mt-2 text-sm font-medium text-green-600 dark:text-green-400"
      >
        Your cover image has been updated.
      </div>
      <!-- <pre>{{ user }}</pre> -->
      <div class="relative group">
        <img
          class="object-cover rounded-md h-[200px] w-full"
          :src="coverImageSrc || user.cover_url || '/images/default_cover.jpg'"
          alt=""
        />
        <div class="absolute top-2 right-2">
          <button
            v-if="!coverImageSrc"
            class="flex items-center px-2 py-1 text-xs text-gray-700 rounded opacity-0 group-hover:opacity-100 bg-gray-50 hover:bg-gray-300"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-2 h-2 mr-2"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z"
              />
            </svg>

            Update Cover
            <input
              @change="onCoverChange"
              type="file"
              class="absolute top-0 bottom-0 left-0 right-0 opacity-0 cursor-pointer"
            />
          </button>
          <div v-else class="flex gap-2">
            <button
              @click="cancelCoverImage"
              class="flex items-center px-2 py-1 text-xs text-gray-700 rounded opacity-0 group-hover:opacity-100 bg-gray-50 hover:bg-gray-300"
            >
              <XMarkIcon class="w-3 h-3 mr-2" />
              Cancel
            </button>
            <button
              @click="submitCoverImage"
              class="flex items-center px-2 py-1 text-xs text-gray-100 bg-gray-700 rounded opacity-0 group-hover:opacity-100 hover:bg-gray-900"
            >
              <ArrowUpTrayIcon class="w-3 h-3 mr-2" />
              Update
            </button>
          </div>
        </div>

        <div class="flex">
          <img
            class="ml-[54px] rounded-full w-[128px] h-[128px] -mt-[64px]"
            :src="user.avatar_url || '/images/default_pfp.png'"
            alt=""
          />
          <div class="flex items-center justify-between flex-1 p-2">
            <h2 class="text-lg font-bold">
              {{ user.name }}
            </h2>
            <PrimaryButton v-if="isMyProfile" class="mr-8">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-4 h-4 mr-2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"
                />
              </svg>

              Edit Profile
            </PrimaryButton>
          </div>
        </div>
      </div>
      <div class="mt-4">
        <TabGroup>
          <TabList class="flex pl-[200px] pt-2">
            <Tab v-if="isMyProfile" v-slot="{ selected }">
              <TabItem text="About" as="template" :selected="selected" />
            </Tab>
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
          </TabList>

          <TabPanels class="mt-2">
            <TabPanel v-if="isMyProfile" class="p-4">
              <Edit :must-verify-email="mustVerifyEmail" :status="status" />
            </TabPanel>
            <TabPanel class="p-3 bg-white rounded shadow"> Posts </TabPanel>
            <TabPanel class="p-3 bg-white rounded shadow"> Following </TabPanel>
            <TabPanel class="p-3 bg-white rounded shadow"> Followers </TabPanel>
            <TabPanel class="p-3 bg-white rounded shadow"> Media </TabPanel>
          </TabPanels>
        </TabGroup>
      </div>
    </div>
  </AuthenticatedLayout>
</template>


