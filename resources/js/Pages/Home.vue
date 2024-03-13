<script setup>
import {Head, Link} from '@inertiajs/vue3';
import {initFlowbite} from "flowbite";
import {onMounted} from "vue";
import Header from "@/Components/Header.vue";

defineProps({
    authUser: {
        type: Object
    },
    auth: {
        type: Object
    },
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <Head title="Главная"/>
    <Header/>
    <div class="font-display flex flex-wrap items-center justify-between max-w-screen-xl mx-auto p-4">
        <main>
            <div class="pt-24">
                <h1 class="max-w-2xl mb-4 text-4xl font-extrabold leading-none tracking-tight md:text-5xl xl:text-6xl dark:text-white">
                    Менеджер задач</h1>
                <p class="max-w-2xl mb-4 text-xl">Тут пишут таски</p>
            </div>
        </main>
    </div>
</template>

<style>
</style>
