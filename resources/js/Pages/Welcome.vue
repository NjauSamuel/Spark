<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'

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
})

const page = usePage()
const isAuthenticated = !!page.props.auth?.user

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden')
    document.getElementById('docs-card')?.classList.add('!row-span-1')
    document.getElementById('docs-card-content')?.classList.add('!flex-row')
    document.getElementById('background')?.classList.add('!hidden')
}
</script>

<template>
    <MainLayout :canLogin="canLogin" :canRegister="canRegister">
        <Head title="Welcome" />

        <section class="bg-white dark:bg-gray-900">
            <div class="grid max-w-7xl px-4 py-8 mx-auto lg:gap-12 xl:gap-0 lg:py-16 lg:grid-cols-12">
                <div class="mr-auto place-self-center lg:col-span-7 xl:col-span-8">
                    <h1
                        class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white"
                    >
                        Building digital products & brands.
                    </h1>
                    <p
                        class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400"
                    >
                        Here at Spark we focus on markets where technology, innovation, and capital can unlock long-term value and drive economic growth.
                    </p>
                    <form action="#" class="">
                        <div class="flex items-center mb-3">
                            <div class="relative w-auto mr-3">
                                <label
                                    for="member_email"
                                    class="hidden mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                    >Email address</label
                                >
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg
                                        class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"
                                        ></path>
                                        <path
                                            d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"
                                        ></path>
                                    </svg>
                                </div>
                                <input
                                    class="block md:w-96 w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Enter your email"
                                    type="email"
                                    name="member[email]"
                                    id="member_email"
                                    required=""
                                />
                            </div>
                            <div>
                                <input
                                    type="submit"
                                    value="Try for free"
                                    class="px-5 py-3 text-sm font-medium text-center text-white rounded-lg cursor-pointer bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                    name="member_submit"
                                    id="member_submit"
                                />
                            </div>
                        </div>
                        <div class="text-sm text-left text-gray-500 dark:text-gray-300">
                            Instant signup. No credit card required.
                            <a href="#" class="text-primary-600 hover:underline dark:text-primary-500"
                                >Terms of Service</a
                            >
                            and
                            <a class="text-primary-600 hover:underline dark:text-primary-500" href="#"
                                >Privacy Policy</a
                            >.
                        </div>
                    </form>
                </div>
                <div class="hidden lg:mt-0 lg:col-span-5 xl:col-span-4 lg:flex">
                    <img
                        src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/hero/mobile-app.svg"
                        alt="phone illustration"
                    />
                </div>
            </div>
        </section>

        <section class="bg-white dark:bg-gray-900">
            <div
                class="gap-8 items-center py-8 px-4 mx-auto max-w-7xl xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6"
            >
                <img
                    class="w-full dark:hidden"
                    src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/cta/cta-dashboard-mockup.svg"
                    alt="dashboard image"
                />
                <img
                    class="w-full hidden dark:block"
                    src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/cta/cta-dashboard-mockup-dark.svg"
                    alt="dashboard image"
                />
                <div class="mt-4 md:mt-0">
                    <h2
                        class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white"
                    >
                        Let's create more tools and ideas that brings us together.
                    </h2>
                    <p class="mb-6 font-light text-gray-500 md:text-lg dark:text-gray-400">
                        Spark helps you connect with friends and communities of people who share your interests. Connecting with your friends and family as well as discovering new ones is easy with features like Groups.
                    </p>
                    <Link
                        :href="route('dashboard')"
                        class="inline-flex items-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-primary-900"
                    >
                        {{ isAuthenticated ? 'Go to Dashboard' : 'Get started' }}
                        <svg
                            class="ml-2 -mr-1 w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </Link>
                </div>
            </div>
        </section>
    </MainLayout>
</template>
