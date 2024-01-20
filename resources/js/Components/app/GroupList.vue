<script setup>

import GroupItem from '@/Components/app/GroupItem.vue';
import TextInput from '@/Components/TextInput.vue';
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { ref } from 'vue';

    const searchKey = ref('')

</script>

<template>
    <div class="px-3 py-3 overflow-hidden bg-gray-100 border rounded-lg lg:flex lg:flex-col lg:h-full">
        <div class="block lg:hidden">
            <Disclosure v-slot="{ open }">
                <DisclosureButton class="w-full">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold">Groups</h2>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" :class="open && 'rotate-90 transform'" class="w-6 h-6 transition-all">
                        <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
                      </svg>
                    </div>

                </DisclosureButton>
                <DisclosurePanel>
                    <TextInput :model-value="searchKey" placeholder="Search" class="w-full mt-4"/>
                    <div class="lg:flex-1 lg:h-full h-[300px] mt-3 overflow-auto">
                        <div v-if="false" class="p-3 text-center text-gray-400">
                            You are not part of any group yet.
                        </div>
                        <div v-else >
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="Laravel"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                            <GroupItem
                                image="https://picsum.photos/100"
                                title="VueJS DEVS"
                                description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                            />
                        </div>
                    </div>
                </DisclosurePanel>

            </Disclosure>
        </div>


        <div class="flex-col flex-1 hidden overflow-hidden lg:flex">
            <h2 class="mb-4 text-xl font-bold">Groups</h2>
        <TextInput :model-value="searchKey" placeholder="Search" class="w-full"/>
        <div class="lg:flex-1 lg:h-full h-[300px] mt-3 overflow-auto">
            <div v-if="false" class="p-3 text-center text-gray-400">
                You are not part of any group yet.
            </div>
            <div v-else >
                <GroupItem
                    image="https://picsum.photos/100"
                    title="Laravel"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
                <GroupItem
                    image="https://picsum.photos/100"
                    title="VueJS DEVS"
                    description="Lorem ipsum dolor sit amet consectetur adipisicing elit."
                />
            </div>
        </div>
        </div>
    </div>

</template>
