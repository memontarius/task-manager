<template>
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ content }}</h1>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        content: String
    },
    setup(props) {
        return {
            content: props.content
        }
    }
}
</script>
