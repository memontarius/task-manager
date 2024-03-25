<template>
    <Head :title="trans('Edit task')"/>
    <AuthenticatedLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ $t('Edit task') }}</h1>
        </template>
        <TransitionGroup name="fade" tag="div">
            <FlashMessage class="msg_flash" v-for="message in flashMessages" :key="message.id" :message="message.text"/>
        </TransitionGroup>
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <form @submit.prevent="submit">
                <InputLabel for="name" value="Название задачи"/>
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

                <InputLabel class="mt-4" for="description" value="Описание задачи"/>
                <TextInput
                    id="description"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.description"
                    autofocus
                    autocomplete="description"
                />
                <InputError class="mt-2" :message="form.errors.description"/>

                <InputLabel class="mt-4" for="status_id" value="Статус"/>
                <select
                    class="mt-2"
                    name="status_id"
                    id="status_id"
                    v-model="form.status_id"
                >
                    <option v-for="status in sortedStatuses" :value="status.id" :key="status.id">{{
                            status.name
                        }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.status_id"/>

                <InputLabel class="mt-4" for="assigned_to_id" value="Исполнитель"/>
                <select
                    class="mt-2"
                    name="assigned_to_id"
                    id="assigned_to_id"
                    v-model="form.assigned_to_id">
                    <option v-for="user in users" :value="user.id" :key="user.id">{{ user.name }}</option>
                </select>
                <InputError class="mt-2" :message="form.errors.assigned_to_id"/>

                <InputLabel class="mt-4" for="label_id" value="Метки"/>
                <select
                    class="mt-2 select-multiple"
                    multiple="multiple"
                    name="label_id"
                    v-model="form.label_id">
                    <option
                        class="bg-none"
                        v-for="label in labels" :value="label.id" :key="label.id">{{ label.name }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.label_id"/>

                <PrimaryButton
                    type="submit"
                    class="mt-8 block w-44"
                    :disabled="form.processing"
                >
                    Применить изменения
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
import useFlashMessages from "@/Hooks/useFlashMessages";

const {messages: flashMessages, show: showFlashMessage} = useFlashMessages();

const props = defineProps({
    task: {
        type: Object,
        default: null
    },
    statuses: {
        type: Object,
        default: null
    },
    users: {
        type: Object,
        default: null
    },
    labels: Object
})

const sortedStatuses = [...props.statuses];
sortedStatuses.sort((s1, s2) => s1.id > s2.id ? 1 : -1);

const form = useForm({
    name: props.task.data.name,
    description: props.task.data.description ?? '',
    status_id: props.task.data.status_id,
    assigned_to_id: props.task.data.assigned_to_id,
    label_id: props.task.data.labels.map((t) => t.id),
});

function submit() {
    if (!form.isDirty) {
        return;
    }

    form.patch(route('tasks.update', { 'id': props.task.data.id }), {
        onSuccess: () => {
            if (usePage().props.flash.message) {
                usePage().props.flash.message.forEach(n => showFlashMessage(n));
            }
        }
    });
}

</script>

<style scoped>
select {
    min-width: 50%;
}

.select-multiple {
    background: none;
    padding-right: 12px;
}
</style>
