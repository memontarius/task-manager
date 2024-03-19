<script setup>
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <header>

        <nav class="bg-white border-b border-gray-100 shadow-sm">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('home')">
                            <ApplicationLogo
                                class="block h-9 w-auto fill-current text-gray-800"
                            />
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <NavLink :href="route('home')" :active="route().current('none')">
                            {{ $t('Tasks') }}
                        </NavLink>
                        <NavLink :href="route('statuses.index')" :active="route().current('statuses.index')">
                            {{ $t('Statuses') }}
                        </NavLink>
                        <NavLink :href="route('home')" :active="route().current('none')">
                            {{ $t('Tags') }}
                        </NavLink>
                    </div>

                    <div v-if="$page.props.auth.user" class="hidden sm:flex sm:items-center sm:ms-6">
                        <!-- Settings Dropdown -->
                        <div class="ms-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}
                                                <svg
                                                    class="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">{{ $t('Profile') }}</DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        {{ $t('Log Out') }}
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden order-10">
                        <button
                            @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                        >
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path
                                    :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>

                    <div v-if="!$page.props.auth.user" class="flex items-center md:order-2 space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <Link
                            :href="route('login')"
                            class="font-sans text-white bg-amber-700 hover:bg-amber-800 focus:ring-2 focus:ring-amber-700 focus:ring-offset-2 transition ease-in-out duration-150 font-medium rounded-lg text-sm px-4 py-2 md:px-5 md:py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                        >{{ $t('Log in') }}
                        </Link>

                        <Link
                            :href="route('register')"
                            class="font-sans text-white bg-amber-700 hover:bg-amber-800 hover:bg-amber-800 focus:ring-2 focus:ring-amber-700 focus:ring-offset-2 transition ease-in-out duration-150  font-medium rounded-lg text-sm px-4 py-2 md:px-5 md:py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                        >{{ $t('Sign up') }}
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div
                :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                class="sm:hidden"
            >
                <div class="pt-2 pb-3 space-y-1">
                    <ResponsiveNavLink :href="route('home')" :active="route().current('tasks')">
                        {{ $t('Tasks') }}
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('statuses.index')" :active="route().current('statuses.index')">
                        {{ $t('Statuses') }}
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('home')" :active="route().current('marks')">
                        {{ $t('Tags') }}
                    </ResponsiveNavLink>
                </div>

                <!--Responsive Settings Options-->
                <div v-if="$page.props.auth.user" class="pt-4 pb-1 border-t border-gray-200">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800">
                            {{ $page.props.auth.user.name }}
                        </div>
                        <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.edit')">
                            {{ $t('Profile') }}
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                            {{ $t('Log Out') }}
                        </ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>

<style scoped>

</style>
