<template>
    <div class="min-h-screen bg-gray-100">
        <Head title="Статусы"/>
        <Header/>
        <SubHeader content="Статусы"/>
        <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div v-if="statuses.length > 0" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <table class="w-full">
                    <thead class="border-b-2 border-gray-700 pb-8">
                        <tr>
                            <th class="text-start py-2">ID</th>
                            <th class="text-start py-2">Название</th>
                            <th class="text-start py-2 w-1/5">Дата создания</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="status in statuses" class="border-b border-dashed text-left">
                        <td>{{ status.id }}</td>
                        <td>{{ status.name }}</td>
                        <td>{{ status.created_date }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="$page.props.auth.user" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <LinkAsButton :href="route('statuses.create')">
                    Создать статус
                </LinkAsButton>
            </div>
        </div>
    </div>
</template>

<script>
import {Head, Link} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import SubHeader from "@/Components/SubHeader.vue";
import UpdatePasswordForm from "@/Pages/Profile/Partials/UpdatePasswordForm.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import LinkAsButton from "@/Components/LinkAsButton.vue";
import NavLink from "@/Components/NavLink.vue";

export default {
    components: {
        NavLink,
        LinkAsButton,
        Link,
        SecondaryButton,
        PrimaryButton,
        UpdatePasswordForm, SubHeader, Header, Head
    },
    props: {
        statuses: { type: Object }
    },
    setup(props) {
        return {
            'statuses': props.statuses.data,
        }
    }
}
</script>

<style scoped>
</style>
