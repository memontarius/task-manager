<template>
    <Link :href="href"
          class="font-medium text-blue-600 hover:text-blue-800 hover:underline mr-2">
        <slot/>
    </Link>
</template>
<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    href: String
})
</script>
