<template>
    <Link :href="href"
          :class="classes">
        <slot/>
    </Link>
</template>
<script setup>
import {Link} from "@inertiajs/vue3";
import {computed} from "vue";

const props = defineProps({
    href: String,
    active: {
        type: Boolean,
        default: true
    }
})

const classes = computed(() =>
    props.active
        ? 'font-medium text-blue-600 hover:text-blue-800 hover:underline mr-2'
        : 'font-medium text-gray-500 hover:text-gray-500 mr-2'
);
</script>
