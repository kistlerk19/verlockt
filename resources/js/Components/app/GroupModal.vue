<script setup>
import { computed, ref } from "vue";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from "@headlessui/vue";
import { XMarkIcon } from "@heroicons/vue/24/solid";
import { useForm } from "@inertiajs/vue3";
import Checkbox from "@/Components/Checkbox.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import TextInput from "@/Components/TextInput.vue";
import axiosClient from '@/axiosClient.js';

const props = defineProps({
    modelValue: Boolean,
});


const formErrors = ref({});
const extWarning = ref(false);

const form = useForm({
    name: "",
    auto_approval: true,
    description: "",
});

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit("update:modelValue", value),
});

const emit = defineEmits(["update:modelValue", "hide", "create"]);

const closeModal = () => {
    show.value = false;
    emit('hide')
    resetModal();
};

const resetModal = () => {
    form.reset();
    formErrors.value = {}
};

function save() {
    axiosClient.post(route('group.create'), form)
        .then(({ data }) => {
            closeModal()
            emit('create', data)
        })
    // form.post(route('group.create'), {
    //     onSuccess(res) {
    //         console.log(res);
    //         show.value = false
    //         closeModal()
    //     },
    //     onError(err){
    //         console.log(err);
    //     }
    // })
}
</script>

<template>
    <teleport to="body">
        <TransitionRoot appear :show="show" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-50">
                <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
                    leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-black/25" />
                </TransitionChild>
                <pre>{{ formErrors.attachments }}</pre>
                <div class="fixed inset-0 w-screen overflow-y-auto">
                    <div class="flex items-center justify-center min-h-full p-4 text-center">
                        <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95">
                            <DialogPanel
                                class="w-full max-w-[800px] p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                                <DialogTitle as="h3"
                                    class="flex items-center justify-between w-full px-4 py-3 text-lg font-medium leading-6 text-gray-900 bg-gray-200 rounded-lg">
                                    create new group
                                    <button @click="closeModal"
                                        class="flex items-center justify-center px-2 py-2 text-sm transition rounded-full hover:bg-black/10">
                                        <XMarkIcon class="w-4 h-4" />
                                    </button>
                                </DialogTitle>
                                <!-- Form -->
                                <!-- <pre>{{ form }}</pre> -->
                                <div class="px-4 py-3 mt-2">
                                    <div class="mb-3">
                                        <label>Group Name</label>
                                        <TextInput type="text" class="block w-full mt-1 rounded-lg" v-model="form.name"
                                            required autofocus />
                                    </div>
                                    <div class="mb-3">
                                        <label>
                                            <Checkbox name="remember" v-model:checked="form.auto_approval" />
                                            Enable Auto Approval
                                        </label>
                                    </div>
                                    <div class="mb-3">
                                        <label>About Group</label>
                                        <TextAreaInput v-model="form.description" class="w-full shadow-2xl" />
                                    </div>
                                </div>

                                <div class="flex justify-end gap-2 px-4 py-3 mt-4">
                                    <button type="button"
                                        class="relative flex items-center justify-center px-3 py-2 text-sm font-semibold text-gray-900 border-none rounded-full shadow-2xl bg-indigo-50 hover:bg-gray-200">
                                        cancel
                                    </button>
                                    <button type="button"
                                        class="px-3 py-2 text-sm font-semibold text-gray-700 bg-indigo-200 rounded-full shadow-2xl hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                        @click="save">
                                        save
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </teleport>
</template>
