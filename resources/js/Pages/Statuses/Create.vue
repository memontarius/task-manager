<template>
    <Head :title="trans('New status')"/>
    <AuthenticatedLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ $t('New status') }}</h1>
        </template>
        <TransitionGroup  name="fade" tag="div">
            <FlashMessage class="msg_flash" v-for="message in flashMessages" :key="message.id" :message="message.text"/>
        </TransitionGroup>
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <form @submit.prevent="submit">
                <InputLabel for="name" value="Название статуса"/>
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name"/>
                <PrimaryButton
                    type="submit"
                    class="mt-8 block w-44"
                    :disabled="form.processing"
                >
                    Создать
                </PrimaryButton>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {trans} from "laravel-vue-i18n";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Head, useForm, usePage} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import {reactive, ref} from "vue";
import useFlashMessages from "@/Hooks/useFlashMessages";

const { messages: flashMessages, show: showFlashMessage } = useFlashMessages();

const form = useForm({
    name: ''
});

function submit() {
    form.post(route('statuses.store'), {
        onSuccess: () => {
            if (usePage().props.flash.message) {
                usePage().props.flash.message.forEach(n => showFlashMessage(n));
            }
            form.reset();
        }
    });
}
</script>

<style scoped>
</style>
