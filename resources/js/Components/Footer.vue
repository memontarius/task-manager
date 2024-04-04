<script setup>
import {usePage} from "@inertiajs/vue3";
import {computed} from "vue";

const visitorsCount = computed(() => usePage().props.visitorsCount);

</script>

<template>
 <footer class="h-16 footer max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 text-sm text-gray-400 flex items-center">
     Посетителей за последнюю минуту: {{ visitorsCount }}
 </footer>
</template>

<style scoped>
</style>
