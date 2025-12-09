<script setup>
    import { Head, Link, useForm } from '@inertiajs/vue3';

    import { onMounted } from 'vue'
    import { initFlowbite } from 'flowbite'

    // Initialize Flowbite components and theme toggle on mount
    onMounted(() => {
        initFlowbite();

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
        });
    });

    defineProps({
        canLogin: {
            type: Boolean,
        },
        canRegister: {
            type: Boolean,
        },
        laravelVersion: {
            type: String,
            required: true,
        },
        phpVersion: {
            type: String,
            required: true,
        },
    });

    function handleImageError() {
        document.getElementById('screenshot-container')?.classList.add('!hidden');
        document.getElementById('docs-card')?.classList.add('!row-span-1');
        document.getElementById('docs-card-content')?.classList.add('!flex-row');
        document.getElementById('background')?.classList.add('!hidden');
    }

    const logoutForm = useForm({});
    function logout() {
        logoutForm.post(route('logout'));
    }

    const currentYear = new Date().getFullYear();

</script>

<template>
    <Head title="Welcome" />
    <div class="bg-white dark:bg-gray-900 pb-4">
        <div>                <!-- Navbar -->
            <nav class="bg-white border-gray-200 dark:bg-gray-900">
                <div class="max-w-7xl flex flex-wrap items-center justify-between mx-auto p-4">
                    
                    <!-- Logo -->
                    <Link href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                        <img class="w-24 h-16 mr-2" src="/images/Spark.png" alt="Spark logo"/>
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
                                        dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                    Dashboard
                                </Link>
                                <button 
                                    @click="logout" 
                                    class="ml-2 text-gray-900 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none 
                                        focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 text-center 
                                        dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800">
                                    Logout
                                </button>
                            </template>

                            <!-- If guest -->
                            <template v-else>
                                <Link 
                                    :href="route('login')" 
                                    class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none 
                                        focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 text-center 
                                        dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                    Log in
                                </Link>

                                <Link 
                                    v-if="canRegister" 
                                    :href="route('register')" 
                                    class="ml-2 text-gray-900 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none 
                                        focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 text-center 
                                        dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-800">
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
                            aria-controls="navbar-cta" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                                    stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Navbar items -->
                    <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-cta">
                        <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg 
                                bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 
                                md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                            <li>
                                <Link href="/" class="block py-2 px-3 md:p-0 text-white bg-primary-700 rounded-sm md:bg-transparent md:text-primary-700 md:dark:text-primary-500" aria-current="page">Home</Link>
                            </li>
                            <li>
                                <a href="#" class="block py-2 px-3 md:p-0 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 dark:text-white md:dark:hover:text-primary-500">About</a>
                            </li>
                            <li>
                                <a href="#" class="block py-2 px-3 md:p-0 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 dark:text-white md:dark:hover:text-primary-500">Services</a>
                            </li>
                            <li>
                                <a href="#" class="block py-2 px-3 md:p-0 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-700 dark:text-white md:dark:hover:text-primary-500">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <section class="bg-white dark:bg-gray-900 relative">
                <button id="theme-toggle" type="button"
                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700
                        focus:outline-none focus:ring-4 ring-4 ring-gray-200 dark:ring-gray-700 focus:ring-gray-200 dark:focus:ring-gray-700
                        rounded-lg text-sm p-2.5 absolute top-3 right-6">
                    <!-- Dark icon -->
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor"
                        viewBox="0 0 20 20"><path
                        d="M17.293 13.293A8 8 0 016.707 2.707a8.001
                        8.001 0 1010.586 10.586z"></path></svg>
                    <!-- Light icon -->
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor"
                        viewBox="0 0 20 20"><path fill-rule="evenodd" clip-rule="evenodd"
                        d="M10 2a1 1 0 011 1v1a1 1 0
                        11-2 0V3a1 1 0 011-1zm4 8a4 4
                        0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>
                <div class="grid max-w-7xl px-4 py-8 mx-auto lg:gap-12 xl:gap-0 lg:py-16 lg:grid-cols-12">
                    <div class="mr-auto place-self-center lg:col-span-7 xl:col-span-8">
                        <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">Building digital products & brands.</h1>
                        <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">Here at Inertia we focus on markets where technology, innovation, and capital can unlock long-term value and drive economic growth.</p>
                        <form action="#" class="">
                            <div class="flex items-center mb-3">
                                <div class="relative w-auto mr-3">
                                    <label for="member_email" class="hidden mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email address</label>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                                    </div>
                                    <input class="block md:w-96 w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter your email" type="email" name="member[email]" id="member_email" required="">
                                </div>
                                <div>
                                    <input type="submit" value="Try for free" class="px-5 py-3 text-sm font-medium text-center text-white rounded-lg cursor-pointer bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" name="member_submit" id="member_submit">
                                </div>
                            </div>
                            <div class="text-sm text-left text-gray-500 dark:text-gray-300">Instant signup. No credit card required. <a href="#" class="text-primary-600 hover:underline dark:text-primary-500">Terms of Service</a> and <a class="text-primary-600 hover:underline dark:text-primary-500" href="#">Privacy Policy</a>.</div>
                        </form>
                    </div>
                    <div class="hidden lg:mt-0 lg:col-span-5 xl:col-span-4 lg:flex">
                        <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/hero/mobile-app.svg" alt="phone illustration">
                    </div>                
                </div>
            </section>

            <section class="bg-white dark:bg-gray-900">
                <div class="gap-8 items-center py-8 px-4 mx-auto max-w-7xl xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6">
                    <img class="w-full dark:hidden" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/cta/cta-dashboard-mockup.svg" alt="dashboard image">
                    <img class="w-full hidden dark:block" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/cta/cta-dashboard-mockup-dark.svg" alt="dashboard image">
                    <div class="mt-4 md:mt-0">
                        <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Let's create more tools and ideas that brings us together.</h2>
                        <p class="mb-6 font-light text-gray-500 md:text-lg dark:text-gray-400">Inertia helps you connect with friends and communities of people who share your interests. Connecting with your friends and family as well as discovering new ones is easy with features like Groups.</p>
                        <a href="#" class="inline-flex items-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-primary-900">
                            Get started
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </a>
                    </div>
                </div>
            </section>

            <footer class="bg-white rounded-lg shadow-sm m-4 dark:bg-gray-800">            
                <div class="w-full mx-auto max-w-7xl p-4 md:flex md:items-center md:justify-between">
                    <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ currentYear }} <a href="/" class="hover:underline">Inertia™</a>. All Rights Reserved.
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
    </div>
</template>
