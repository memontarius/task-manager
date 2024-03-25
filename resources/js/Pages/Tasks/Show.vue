<template>
    <Head :title="trans('Review Task')"/>
    <AuthenticatedLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ $t('Review Task') }}</h1>
        </template>
        <TransitionGroup name="fade" tag="div">
            <FlashMessage class="msg_flash" v-for="message in flashMessages" :key="message.id" :message="message.text"/>
        </TransitionGroup>
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div>
                <strong>Имя:</strong> {{ task.data.name }}
            </div>
            <div v-if="task.data.description">
                <strong>Описание:</strong> {{ task.data.description }}
            </div>
            <div>
                <strong>Статус:</strong> {{ task.data.status.name }}
            </div>
            <div>
                <strong>Создатель:</strong> {{ task.data.created_by }}
            </div>
            <div>
                <strong>Исполнитель:</strong> {{ task.data.assigned_to }}
            </div>
            <ul v-if="task.data.labels.length > 0" class="flex mt-2 text-teal-800">
                <li
                    v-for="label in task.data.labels"
                    class="mr-2">
                    <Link
                        :href="route('labels.show', label.id)"
                        class="p-1 pr-2 pl-2 border border-teal-200 rounded-md bg-teal-100 uppercase text-sm"
                    >
                        <FontAwesomeIcon :icon="faTag" class="mr-1 text-teal-300" />
                        {{ label.name }}
                    </Link>
                </li>
            </ul>
            <LinkAsButton
                :href="route('tasks.edit', task.data.id)"
                class="mt-7">
                <FontAwesomeIcon :icon="faPenToSquare" class="mr-1" />
                Редактировать
            </LinkAsButton>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {trans} from "laravel-vue-i18n";
import {Head, Link} from "@inertiajs/vue3";
import FlashMessage from "@/Components/FlashMessage.vue";
import useFlashMessages from "@/Hooks/useFlashMessages";
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {faTag, faPenToSquare} from '@fortawesome/free-solid-svg-icons';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import LinkAsButton from "@/Components/LinkAsButton.vue";

const {messages: flashMessages, show: showFlashMessage} = useFlashMessages();

const props = defineProps({
    task: {
        type: Object,
        default: null
    }
})
</script>
