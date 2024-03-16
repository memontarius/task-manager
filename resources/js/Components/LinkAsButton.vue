<template>
    <Link
        :href="href"
        class="font-sans text-white bg-amber-700 hover:bg-amber-800 focus:ring-2 focus:ring-amber-700 focus:ring-offset-2 transition ease-in-out duration-150 font-medium rounded-lg text-sm px-4 py-2 md:px-5 md:py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
    >
        <slot />
    </Link>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    href: {
        type: String,
        required: true,
    }
});
</script>
