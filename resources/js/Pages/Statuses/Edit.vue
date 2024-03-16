<template>
    <Head :title="trans('Statuses')" />
    <AuthenticatedLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ $t('Statuses') }}</h1>
        </template>

        <p>This edit statuses</p>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import {trans} from "laravel-vue-i18n";

export default {
    methods: {trans},
    components: {Head, AuthenticatedLayout}

}
</script>

<style lang="scss" scoped>

</style>
