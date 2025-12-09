<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3'
import { onMounted, computed } from 'vue'
import { initFlowbite } from 'flowbite'

defineProps({
    canLogin: {
        type: Boolean,
        default: false,
    },
    canRegister: {
        type: Boolean,
        default: false,
    },
})

const page = usePage()
const currentRoute = computed(() => page.url)

// Check if a route is active
const isActive = (path) => {
    if (path === '/') {
        return currentRoute.value === '/'
    }
    return currentRoute.value.startsWith(path)
}

// Initialize Flowbite components and theme toggle on mount
onMounted(() => {
    initFlowbite()

    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon')
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon')
    const themeToggleBtn = document.getElementById('theme-toggle')

    if (!themeToggleBtn) return

    // Show correct icon based on local storage
    if (
        localStorage.getItem('color-theme') === 'dark' ||
        (!('color-theme' in localStorage) &&
            window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        themeToggleLightIcon.classList.remove('hidden')
    } else {
        themeToggleDarkIcon.classList.remove('hidden')
    }

    themeToggleBtn.addEventListener('click', function () {
        themeToggleDarkIcon.classList.toggle('hidden')
        themeToggleLightIcon.classList.toggle('hidden')

        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark')
                localStorage.setItem('color-theme', 'dark')
            } else {
                document.documentElement.classList.remove('dark')
                localStorage.setItem('color-theme', 'light')
            }
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark')
                localStorage.setItem('color-theme', 'light')
            } else {
                document.documentElement.classList.add('dark')
                localStorage.setItem('color-theme', 'dark')
            }
        }
    })
})

const logoutForm = useForm({})
function logout() {
    logoutForm.post(route('logout'))
}

const currentYear = new Date().getFullYear()
</script>

<template>
    <div class="bg-white dark:bg-gray-900 min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white border-gray-200 dark:bg-gray-900">
            <div class="max-w-7xl flex flex-wrap items-center justify-between mx-auto p-4">
                <!-- Logo -->
                <Link href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img class="w-24 h-16 mr-2" src="/images/Spark.png" alt="Spark logo" />
                </Link>

                <!-- Right Side -->
                <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                    <template v-if="canLogin">
                        <!-- If user logged in -->
                        <template v-if="$page.props.auth.user">
                            <Link
                                :href="route('dashboard')"
                                class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none 
                                    focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 text-center 
                                    dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                            >
                                Dashboard
                            </Link>
                            <button
                                @click="logout"
                                class="ml-2 text-gray-900 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none 
                                    focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 text-center 
                                    dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800"
                            >
                                Logout
                            </button>
                        </template>

                        <!-- If guest -->
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none 
                                    focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 text-center 
                                    dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="ml-2 text-gray-900 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none 
                                    focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 text-center 
                                    dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800"
                            >
                                Register
                            </Link>
                        </template>
                    </template>

                    <!-- Mobile toggle button -->
                    <button
                        data-collapse-toggle="navbar-cta"
                        type="button"
                        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 
                            rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 
                            focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        aria-controls="navbar-cta"
                        aria-expanded="false"
                    >
                        <span class="sr-only">Open main menu</span>
                        <svg
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
                    </button>
                </div>

                <!-- Navbar items -->
                <div
                    class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1"
                    id="navbar-cta"
                >
                    <ul
                        class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg 
                            bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 
                            md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700"
                    >
                        <li>
                            <Link
                                href="/"
                                :class="[
                                    'block py-2 px-3 md:p-0 rounded-sm transition-colors',
                                    isActive('/')
                                        ? 'text-white bg-primary-700 md:bg-transparent md:text-primary-700 md:dark:text-primary-500'
                                        : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 dark:text-white md:dark:hover:text-primary-500'
                                ]"
                                :aria-current="isActive('/') ? 'page' : null"
                            >
                                Home
                            </Link>
                        </li>
                        <li>
                            <a
                                href="#"
                                :class="[
                                    'block py-2 px-3 md:p-0 rounded-sm transition-colors',
                                    isActive('/about')
                                        ? 'text-white bg-primary-700 md:bg-transparent md:text-primary-700 md:dark:text-primary-500'
                                        : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 dark:text-white md:dark:hover:text-primary-500'
                                ]"
                            >
                                About
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                :class="[
                                    'block py-2 px-3 md:p-0 rounded-sm transition-colors',
                                    isActive('/services')
                                        ? 'text-white bg-primary-700 md:bg-transparent md:text-primary-700 md:dark:text-primary-500'
                                        : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 dark:text-white md:dark:hover:text-primary-500'
                                ]"
                            >
                                Services
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                :class="[
                                    'block py-2 px-3 md:p-0 rounded-sm transition-colors',
                                    isActive('/contact')
                                        ? 'text-white bg-primary-700 md:bg-transparent md:text-primary-700 md:dark:text-primary-500'
                                        : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 dark:text-white md:dark:hover:text-primary-500'
                                ]"
                            >
                                Contact
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow relative">
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

        <!-- Footer -->
        <footer class="bg-white rounded-lg shadow-sm m-4 dark:bg-gray-800">
            <div class="w-full mx-auto max-w-7xl p-4 md:flex md:items-center md:justify-between">
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">
                    © {{ currentYear }} <a href="/" class="hover:underline">Spark™</a>. All Rights Reserved.
                </span>
                <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                    <li>
                        <a href="#" class="hover:underline me-4 md:me-6">About</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline">Contact</a>
                    </li>
                </ul>
            </div>
        </footer>
    </div>
</template>

