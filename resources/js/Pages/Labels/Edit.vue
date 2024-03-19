<template>
    <Head :title="trans('Edit label')" />
    <AuthenticatedLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ $t('Edit label') }}</h1>
        </template>
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <form @submit.prevent="submit">
                <InputLabel for="name" value="Название метки"/>
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full mb-4"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name"/>
                <InputLabel for="description" value="Описание метки"/>
                <TextInput
                    id="description"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.description"
                    required
                    autofocus
                    autocomplete="description"
                />
                <InputError class="mt-2" :message="form.errors.description"/>
                <PrimaryButton
                    type="submit"
                    class="mt-8 block w-44"
                    :disabled="form.processing"
                >
                    Редактировать
                </PrimaryButton>
            </form>
        </div>
        <TransitionGroup  name="fade" tag="div">
            <FlashMessage class="msg_flash" v-for="message in flashMessages" :key="message.id" :message="message.text"/>
        </TransitionGroup>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm, usePage} from "@inertiajs/vue3";
import {trans} from "laravel-vue-i18n";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {onMounted, reactive} from "vue";
import useFlashMessages from "@/Hooks/useFlashMessages";

const { messages: flashMessages, show: showFlashMessage } = useFlashMessages();

const props = defineProps({
    'label': {
        type: Object,
        default: null
    }
})

const form = useForm({
    name: props.label.name,
    description: props.label.description
});

function submit() {
    if (form.isDirty) {
        form.put(route('labels.update', {'id': props.label.id}), {
            onSuccess: () => {
                if (usePage().props.flash.message) {
                    usePage().props.flash.message.forEach(n => showFlashMessage(n));
                }
            }
        });
    }
}
</script>

<style scoped>
</style>
