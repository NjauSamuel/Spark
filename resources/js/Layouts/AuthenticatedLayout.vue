<script setup>
import { ref, onMounted, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { initFlowbite } from 'flowbite';

const showingNavigationDropdown = ref(false);
const page = usePage();
const currentRoute = computed(() => page.url);
const isDarkMode = ref(false);

// Check if a route is active
const isActive = (path) => {
    if (path === '/dashboard') {
        return currentRoute.value === '/dashboard';
    }
    return currentRoute.value.startsWith(path);
};

// Computed property for logo source based on dark mode
const logoSource = computed(() => {
    return isDarkMode.value ? '/images/SparkDark.png' : '/images/Spark.png';
});

// Function to check dark mode state
const checkDarkMode = () => {
    isDarkMode.value = document.documentElement.classList.contains('dark');
};

// Initialize Flowbite components and theme toggle on mount
onMounted(() => {
    initFlowbite();

    // Check initial dark mode state
    checkDarkMode();

    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
    const themeToggleBtn = document.getElementById('theme-toggle');

    if (!themeToggleBtn) return;

    // Show correct icon based on local storage
    if (
        localStorage.getItem('color-theme') === 'dark' ||
        (!('color-theme' in localStorage) &&
            window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        themeToggleLightIcon.classList.remove('hidden');
    } else {
        themeToggleDarkIcon.classList.remove('hidden');
    }

    themeToggleBtn.addEventListener('click', function () {
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');

        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }
        
        // Update dark mode state after toggle
        checkDarkMode();
    });

    // Watch for dark mode changes via MutationObserver
    const observer = new MutationObserver(() => {
        checkDarkMode();
    });

    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class']
    });
});
</script>

<template>
    <div class="bg-white dark:bg-gray-900 min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white border-b border-gray-200 dark:bg-gray-900 dark:border-gray-700">
            <div class="max-w-7xl flex flex-wrap items-center justify-between mx-auto p-4">
                <!-- Logo -->
                <Link :href="route('welcome')" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img class="w-24 h-16 mr-2" :src="logoSource" alt="Spark logo" />
                </Link>

                <!-- Right Side -->
                <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse items-center">
                    <!-- User Dropdown (Desktop) -->
                    <div class="hidden md:flex items-center space-x-3">
                        <div class="relative">
                            <button
                                type="button"
                                class="flex items-center text-sm font-medium text-gray-900 dark:text-white focus:outline-none"
                                id="user-menu-button"
                                data-dropdown-toggle="user-dropdown"
                            >
                                <span class="mr-2">{{ $page.props.auth.user.name }}</span>
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div
                                id="user-dropdown"
                                class="hidden z-50 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600 absolute right-0 mt-2 w-48"
                            >
                                <div class="px-4 py-3">
                                    <span class="block text-sm text-gray-900 dark:text-white">{{ $page.props.auth.user.name }}</span>
                                    <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ $page.props.auth.user.email }}</span>
                                </div>
                                <ul class="py-2" aria-labelledby="user-menu-button">
                                    <li>
                                        <Link
                                            :href="route('profile.edit')"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                        >
                                            Profile
                                        </Link>
                                    </li>
                                    <li>
                                        <Link
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                        >
                                            Log Out
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile toggle button -->
                    <button
                        @click="showingNavigationDropdown = !showingNavigationDropdown"
                        type="button"
                        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        aria-controls="navbar-cta"
                        :aria-expanded="showingNavigationDropdown"
                    >
                        <span class="sr-only">Open main menu</span>
                        <svg
                            v-if="!showingNavigationDropdown"
                            class="w-5 h-5"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 17 14"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M1 1h15M1 7h15M1 13h15"
                            />
                        </svg>
                        <svg
                            v-else
                            class="w-5 h-5"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 14 14"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                            />
                        </svg>
                    </button>
                </div>

                <!-- Navbar items -->
                <div
                    :class="showingNavigationDropdown ? '' : 'hidden'"
                    class="items-center justify-between w-full md:flex md:w-auto md:order-1"
                    id="navbar-cta"
                >
                    <ul
                        class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700"
                    >
                        <li>
                            <Link
                                :href="route('dashboard')"
                                :class="[
                                    'block py-2 px-3 md:p-0 rounded-sm transition-colors',
                                    isActive('/dashboard')
                                        ? 'text-white bg-primary-700 md:bg-transparent md:text-primary-700 md:dark:text-primary-500'
                                        : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 dark:text-white md:dark:hover:text-primary-500'
                                ]"
                                :aria-current="isActive('/dashboard') ? 'page' : null"
                            >
                                Dashboard
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('contacts.index')"
                                :class="[
                                    'block py-2 px-3 md:p-0 rounded-sm transition-colors',
                                    isActive('/contacts')
                                        ? 'text-white bg-primary-700 md:bg-transparent md:text-primary-700 md:dark:text-primary-500'
                                        : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 dark:text-white md:dark:hover:text-primary-500'
                                ]"
                                :aria-current="isActive('/contacts') ? 'page' : null"
                            >
                                Contacts
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('tasks.index')"
                                :class="[
                                    'block py-2 px-3 md:p-0 rounded-sm transition-colors',
                                    isActive('/tasks')
                                        ? 'text-white bg-primary-700 md:bg-transparent md:text-primary-700 md:dark:text-primary-500'
                                        : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 dark:text-white md:dark:hover:text-primary-500'
                                ]"
                                :aria-current="isActive('/tasks') ? 'page' : null"
                            >
                                Tasks
                            </Link>
                        </li>
                        <!-- Mobile User Menu -->
                        <li class="md:hidden">
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                                <div class="px-3 mb-3">
                                    <div class="text-base font-medium text-gray-900 dark:text-white">
                                        {{ $page.props.auth.user.name }}
                                    </div>
                                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ $page.props.auth.user.email }}
                                    </div>
                                </div>
                                <Link
                                    :href="route('profile.edit')"
                                    class="block py-2 px-3 rounded-sm text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                >
                                    Profile
                                </Link>
                                <Link
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="block w-full text-left py-2 px-3 rounded-sm text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                >
                                    Log Out
                                </Link>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header
            class="bg-white dark:bg-gray-800 shadow"
            v-if="$slots.header"
        >
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow relative bg-gray-100 dark:bg-gray-900">
            <!-- Theme Toggle Button -->
            <button
                id="theme-toggle"
                type="button"
                class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700
                    focus:outline-none focus:ring-4 ring-4 ring-gray-200 dark:ring-gray-700 focus:ring-gray-200 dark:focus:ring-gray-700
                    rounded-lg text-sm p-2.5 absolute top-3 right-6 z-10"
            >
                <!-- Dark icon -->
                <svg
                    id="theme-toggle-dark-icon"
                    class="hidden w-5 h-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                >
                    <path
                        d="M17.293 13.293A8 8 0 016.707 2.707a8.001
                        8.001 0 1010.586 10.586z"
                    ></path>
                </svg>
                <!-- Light icon -->
                <svg
                    id="theme-toggle-light-icon"
                    class="hidden w-5 h-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                >
                    <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M10 2a1 1 0 011 1v1a1 1 0
                        11-2 0V3a1 1 0 011-1zm4 8a4 4
                        0 11-8 0 4 4 0 018 0z"
                    ></path>
                </svg>
            </button>
            <slot />
        </main>
    </div>
</template>
