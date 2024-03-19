<template>
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ $props.content }}</h1>
        </div>
    </div>
</template>

<script>
import {ref} from "vue";

export default {
    props: {
        content: String
    }
}
</script>
