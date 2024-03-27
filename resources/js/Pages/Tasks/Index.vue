<script setup>
import SubHeader from "@/Components/SubHeader.vue";
import {Head, Link, router, usePage} from "@inertiajs/vue3";
import LinkAsButton from "@/Components/LinkAsButton.vue";
import Header from "@/Components/Header.vue";
import {computed, ref, toRaw} from "vue";
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {faPenToSquare, faTrashCan} from '@fortawesome/free-regular-svg-icons';
import useFlashMessages from "@/Hooks/useFlashMessages.js";
import FlashMessage from "@/Components/FlashMessage.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    tasks: Object,
    page: Number,
    perPage: Number,
    total: Number,
    params: Object
});

const { messages: flashMessages, show: showFlashMessage } = useFlashMessages();
const { page } = usePage();
const tasksList = ref(props.tasks.data);

function deleteTask(taskId) {
    router.delete(`/tasks/${taskId}`, {
        preserveScroll: true,
        onSuccess: () => {
            const messages = usePage().props.flash.message ?? [];

            if (messages.length > 0) {
                messages.forEach(n => showFlashMessage(n));
            }
            else {
                tasksList.value = tasksList.value.filter(s => s.id != taskId);
            }
        }
    })
}

</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <Head title="Задачи"/>
        <Header/>
        <SubHeader content="Задачи"/>
        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <TransitionGroup  name="fade" tag="div">
                <FlashMessage class="msg_flash text-red-800 border-red-300 bg-red-50 dark:bg-red-800 dark:text-red-400 dark:border-red-800"
                              v-for="message in flashMessages" :key="message.id" :message="message.text"/>
            </TransitionGroup>
            <div v-if="tasksList.length > 0" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <table class="w-full">
                    <thead class="border-b-2 border-gray-700 pb-8">
                    <tr>
                        <th class="text-start py-2">ID</th>
                        <th class="text-start py-2">Название</th>
                        <th class="text-start py-2">Описание</th>
                        <th class="text-start py-2 w-1/5">Дата создания</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="task in tasksList" class="border-b border-dashed text-left">
                        <td>{{ task.id }}</td>
                        <td>
                            <Link :href="route('tasks.show', task.id)"
                                  class="font-medium text-blue-600 hover:text-blue-800 hover:underline mr-2">
                            {{ task.name }}
                            </Link>
                        </td>
                        <td>{{ task.description }}</td>
                        <td>{{ task.created_date }}</td>
                        <td v-if="$page.props.auth.user" style="text-align: right">
                            <Link :href="route('tasks.edit', task.id)"
                                  class="font-medium text-blue-600 hover:text-blue-800 hover:underline">
                                <FontAwesomeIcon :icon="faPenToSquare" />
                            </Link>
                            <a
                                :href="route('tasks.destroy', task.id)"
                                class="font-medium text-red-600 hover:text-red-800 hover:underline inline-block hover:cursor-pointer ml-2"
                                @click.prevent="deleteTask(task.id)"
                            >
                                <FontAwesomeIcon :icon="faTrashCan" />
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <Pagination :page="props.page" :per-page="perPage" :total="total" :params="params" />
            </div>
            <div v-if="$page.props.auth.user" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <LinkAsButton :href="route('tasks.create')">
                    Создать задачу
                </LinkAsButton>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
