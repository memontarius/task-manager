<script setup>

import {Link} from "@inertiajs/vue3";
import {computed, toRaw} from "vue";

const props = defineProps({
    page: Number,
    perPage: Number,
    total: Number,
    params: Object
});

const totalPages = Math.ceil(props.total / props.perPage);
const queryParams = toRaw(props.params);
const clamp = (num, min, max) => Math.min(Math.max(num, min), Math.max(min, max));

const endOffset = clamp(3 - props.page, 0, 2) + 2;
const startOffset = clamp(props.page - (totalPages - 2), 0, 2) + 2;

const start = clamp(props.page - startOffset, 2, totalPages - 1);
const end = clamp(props.page + endOffset, 1, totalPages - 1);

function resolvePageLinkClasses(pageNumber) {
    const classes = pageNumber == props.page
        ? "z-10 flex items-center justify-center px-4 h-10 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"
        : "flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white";
    return classes;
}

function getPaginatePageUrl(numberPage) {
    const params = {...queryParams};
    params.page = numberPage;
    return route(route().current(), params);
}

function getPreviousPage() {
    return getPaginatePageUrl(queryParams.page > 1 ? parseInt(queryParams.page) - 1 : queryParams.page);
}

function getNextPage() {
    return getPaginatePageUrl(queryParams.page < totalPages ? parseInt(queryParams.page) + 1 : queryParams.page);
}

const paginationPages = computed(() => {
    const pages = [];

    for (let i = start; i <= end; i++) {
        pages.push({
            number: i,
            url: getPaginatePageUrl(i)
        });
    }

    return pages;
});


</script>

<template>
    <nav v-if="totalPages > 1" class="mt-8 text-center">
        <ul class="inline-flex items-center -space-x-px h-10 text-base">
            <li>
                <Link :href="getPreviousPage()"
                      class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <span class="sr-only">Previous</span>
                    <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 1 1 5l4 4"/>
                    </svg>
                </Link>
            </li>

            <li>
                <Link :href="getPaginatePageUrl(1)"
                      :class="resolvePageLinkClasses(1)">
                    1
                </Link>
            </li>

            <li v-if="start > 2">
                <div class="m-4 cursor-default">...</div>
            </li>

            <li v-for="paginatingItem in paginationPages">
                <Link :href="paginatingItem.url"
                      :class="resolvePageLinkClasses(paginatingItem.number)">
                    {{ paginatingItem.number }}
                </Link>
            </li>

            <li v-if="end < totalPages - 1">
                <div class="m-4 cursor-default" >...</div>
            </li>

            <li v-if="totalPages > 1">
                <Link :href="getPaginatePageUrl(totalPages)"
                      :class="resolvePageLinkClasses(totalPages)">
                    {{totalPages}}
                </Link>
            </li>

            <li>
                <Link :href="getNextPage()"
                      class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <span class="sr-only">Next</span>
                    <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m1 9 4-4-4-4"/>
                    </svg>
                </Link>
            </li>
        </ul>
    </nav>
</template>

<style scoped>

</style>
