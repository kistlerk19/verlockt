

<template>
  <AuthenticatedLayout>
    <div class="container h-full mx-auto overflow-auto">
      <div class="relative">
        <img
          class="object-cover rounded-md h-[200px] w-full"
          src="/images/cover.jpg"
          alt=""
        />
        <div class="flex">
          <img
            class="ml-[54px] rounded-full w-[128px] h-[128px] -mt-[64px]"
            src="/images/pfp.png"
            alt=""
          />
          <div class="flex items-center justify-between flex-1 p-2">
            <h2 class="text-lg font-bold">{{ user.name }}</h2>
            <PrimaryButton class="mr-8">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
              </svg>

              Edit Profile
            </PrimaryButton>
          </div>
        </div>
      </div>
      <div class="mt-4">
        <TabGroup>
          <TabList class="flex pl-[200px] pt-2">
            <Tab
              v-slot="{ selected }"
            >
              <TabItem text="About" as="template" :selected="selected" />
            </Tab>
            <Tab
              v-slot="{ selected }"
            >
              <TabItem text="Posts" as="template" :selected="selected" />
            </Tab>
            <Tab
              v-slot="{ selected }"
            >
              <TabItem text="Following" as="template" :selected="selected" />
            </Tab>
            <Tab
              v-slot="{ selected }"
            >
            <TabItem text="Followers" as="template" :selected="selected" />
            </Tab>
            <Tab
              v-slot="{ selected }"
            >
            <TabItem text="Media" as="template" :selected="selected" />
            </Tab>
          </TabList>

          <TabPanels class="mt-2">
            <TabPanel
              class="p-4"
            >
              <Edit :must-verify-email="mustVerifyEmail" :status="status" />
            </TabPanel>
            <TabPanel
              class="p-3 bg-white rounded shadow"
            >
              Posts
            </TabPanel>
            <TabPanel
              class="p-3 bg-white rounded shadow"
            >
              Following
            </TabPanel>
            <TabPanel
              class="p-3 bg-white rounded shadow"
            >
              Followers
            </TabPanel>
            <TabPanel
              class="p-3 bg-white rounded shadow"
            >
              Media
            </TabPanel>
          </TabPanels>
        </TabGroup>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

  <script setup>
import { ref } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TabItem from "./Partials/TabItem.vue";
import Edit from "./Edit.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const user = usePage().props.auth.user;

</script>
