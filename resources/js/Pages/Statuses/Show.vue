<script setup>
import {Head} from "@inertiajs/vue3";
import {trans} from "laravel-vue-i18n";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    'status': {
        type: Object,
        default: null
    }
});
</script>

<template>
    <Head :title="trans('Status')"/>
    <AuthenticatedLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ $t('Status') }}</h1>
        </template>
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="flex">
                <div class="mr-2 font-semibold">Название статуса:</div>
                <div>{{ status.name }}</div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
