<template>
    <div class="min-h-screen bg-gray-100">
        <Head :title="trans('Labels')"/>
        <Header/>
        <SubHeader :content="trans('Labels')"/>
        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <TransitionGroup  name="fade" tag="div">
                <FlashMessage class="msg_flash text-red-800 border-red-300 bg-red-50 dark:bg-red-800 dark:text-red-400 dark:border-red-800"
                              v-for="message in flashMessages" :key="message.id" :message="message.text"/>
            </TransitionGroup>
            <div v-if="labelList.length > 0" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
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
                    <tr v-for=" (labels, index) in labelList" class="border-b border-dashed text-left">
                        <td>{{ index + 1 }} </td>
                        <td>{{ labels.name }}</td>
                        <td>{{ labels.description }}</td>
                        <td>{{ labels.created_date }}</td>
                        <td v-if="$page.props.auth.user" style="text-align: right">
                            <Link :href="route('labels.edit', labels.id)"
                                class="font-medium text-blue-600 hover:text-blue-800 hover:underline mr-2">
                                <FontAwesomeIcon :icon="faPenToSquare" />
                            </Link>
                            <a
                                :href="route('labels.destroy', labels.id)"
                                class="font-medium text-red-600 hover:text-red-800 hover:underline inline-block hover:cursor-pointer"
                                @click.prevent="deleteLabel(labels.id)"
                            >
                                <FontAwesomeIcon :icon="faTrashCan" />
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="$page.props.auth.user" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <LinkAsButton :href="route('labels.create')">
                    Создать метку
                </LinkAsButton>
            </div>
        </div>
    </div>
</template>

<script setup>
import {Head, Link, router, usePage} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import SubHeader from "@/Components/SubHeader.vue";
import LinkAsButton from "@/Components/LinkAsButton.vue";
import {trans} from "laravel-vue-i18n";
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {faPenToSquare, faTrashCan} from '@fortawesome/free-regular-svg-icons';
import FlashMessage from "@/Components/FlashMessage.vue";
import useFlashMessages from "@/Hooks/useFlashMessages";
import {computed, onMounted, ref} from "vue";

const props = defineProps({
    labels: { type: Object }
});

const { messages: flashMessages, show: showFlashMessage } = useFlashMessages();
const { page } = usePage();
const labelList = ref(props.labels.data);

function deleteLabel(id) {
    router.delete(route('labels.destroy', id), {
        preserveScroll: true,
        onSuccess: () => {
            const messages = usePage().props.flash.message ?? [];

            if (messages.length > 0) {
                messages.forEach(n => showFlashMessage(n));
            }
            else {
                labelList.value = labelList.value.filter(l => l.id != id);
            }
        }
    });
}

</script>

<style scoped>
</style>
