<script setup>
import {Head} from "@inertiajs/vue3";
import {trans} from "laravel-vue-i18n";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {faPenToSquare} from "@fortawesome/free-solid-svg-icons";
import LinkAsButton from "@/Components/LinkAsButton.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

defineProps({
    'label': {
        type: Object,
        default: null
    }
});
</script>

<template>
    <Head :title="trans('Review Label')"/>
    <AuthenticatedLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ $t('Review Label') }}</h1>
        </template>
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="flex">
                <div class="mr-2 font-semibold">Имя:</div>
                <div>{{ label.name }}</div>
            </div>
            <div class="flex">
                <div class="mr-2 font-semibold">Описание:</div>
                <div>{{ label.description }}</div>
            </div>
            <LinkAsButton
                :href="route('labels.edit', label.id)"
                class="mt-7">
                <FontAwesomeIcon :icon="faPenToSquare" class="mr-1" />
                Редактировать
            </LinkAsButton>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
