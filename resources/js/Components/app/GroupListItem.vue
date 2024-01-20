
<script setup>
    import { ref } from 'vue';
    import GroupItem from '@/Components/app/GroupItem.vue';
    import TextInput from '@/Components/TextInput.vue';

    const searchKey = ref('')
</script>

<template>
        <TextInput :model-value="searchKey" placeholder="Search" class="w-full mt-4"/>
        <div class="flex-1 h-[300px] mt-3 overflow-auto">
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
</template>
