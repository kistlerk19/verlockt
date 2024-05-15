<script setup>
import { Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
defineProps({
  user: Object,
  approveButton: {
    type: Boolean,
    default: false,
  },
  showRoleDropdown: {
    type: Boolean,
    default: false,
  },
  disableRoleDropdown: {
    type: Boolean,
    default: false,
  },
});

defineEmits(["approve", "reject", "roleChange", "delete"]);
</script>

<template>
  <div class="border-2 border-transparent rounded-md hover:bg-gray-200">
    <div class="flex items-start gap-1 px-2 py-2">
      <Link :href="route('profile', user.username)">
        <img
          :src="user.avatar_url"
          alt=""
          class="w-[32px] h-[32px] rounded-full gap-3"
        />
      </Link>
      <div class="flex justify-between flex-1">
        <Link :href="route('profile', user.username)">
          <h3 class="font-bold hover:underline">{{ user.name }}</h3>
        </Link>
        <div v-if="approveButton" class="flex gap-1">
          <PrimaryButton @click.prevent.stop="$emit('approve', user)"
            >Approve</PrimaryButton
          >
          <button
            class="px-3 py-2 text-sm font-semibold text-blue-300 bg-red-400 rounded-lg shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
            @click.prevent.stop="$emit('reject', user)"
          >
            Reject
          </button>
        </div>
        <div v-if="showRoleDropdown">
          <div class="mt-2">
            <select
              @change="$emit('roleChange', user, $event.target.value)"
              :disabled="disableRoleDropdown"
              class="max-w-xs py-1 text-sm leading-6 text-gray-900 border-0 shadow-sm rounded-xl ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600"
            >
              <option :selected="user.role === 'admin'">admin</option>
              <option :selected="user.role === 'user'">user</option>
            </select>
            <button
                :disabled="disableRoleDropdown"
                @click="$emit('delete', user)"
              class="px-2 py-1 ml-3 text-sm font-semibold bg-red-500 shadow-sm disabled:bg-red-200 text-black-500 rounded-xl hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
            >
              delete
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>



<style>
</style>
