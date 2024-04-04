<script setup>
import Header from "@/Components/Header.vue";
import Footer from "@/Components/Footer.vue";
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <Header/>
            <!-- Page Heading -->
            <div class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </div>

            <!-- Page Content -->
            <main>
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                        <slot />
                    </div>
                </div>
            </main>
            <Footer/>
        </div>
    </div>
</template>
