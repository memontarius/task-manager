<script setup>
import {Head} from "@inertiajs/vue3";
import {trans} from "laravel-vue-i18n";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    'label': {
        type: Object,
        default: null
    }
});
</script>

<template>
    <Head :title="trans('Label')"/>
    <AuthenticatedLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ $t('Label') }}</h1>
        </template>
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="flex">
                <div class="mr-2 font-semibold mb-4">Название метки:</div>
                <div>{{ label.name }}</div>
            </div>
            <div class="flex">
                <div class="mr-2 font-semibold">Описание метки:</div>
                <div>{{ label.description }}</div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
