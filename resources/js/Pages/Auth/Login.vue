<script setup>
    import { Head, Link, useForm } from '@inertiajs/vue3'
    import { ref, computed, onMounted } from 'vue'

    defineProps({
        canResetPassword: Boolean,
        status: String,
    })

    const form = useForm({
        email: '',
        password: '',
        remember: false,
    })

    const submit = () => {
        form.post(route('login'), {
            onFinish: () => form.reset('password'),
        })
    }

    const isDarkMode = ref(false)

    // Computed property for logo source based on dark mode
    const logoSource = computed(() => {
        return isDarkMode.value ? '/images/SparkDark.png' : '/images/Spark.png'
    })

    // Function to check dark mode state
    const checkDarkMode = () => {
        isDarkMode.value = document.documentElement.classList.contains('dark')
    }

    // Initialize dark mode check on mount
    onMounted(() => {
        checkDarkMode()

        // Watch for dark mode changes via MutationObserver
        const observer = new MutationObserver(() => {
            checkDarkMode()
        })

        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        })
    })
</script>

<template>
    <Head title="Log in" />

    <section class="bg-gray-50 dark:bg-gray-900">
        <div
            class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0"
        >
            <!-- Logo -->
            <Link
                href="/"
                class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white"
            >
                <img
                    class="w-24 h-16 mr-2"
                    :src="logoSource"
                    alt="Spark logo"
                />
            </Link>

            <!-- Card -->
            <div
                class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
            >
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1
                        class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
                    >
                        Sign in to your account
                    </h1>

                    <!-- Status message -->
                    <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                        {{ status }}
                    </div>

                    <!-- Form -->
                    <form @submit.prevent="submit" class="space-y-4 md:space-y-6">
                        <!-- Email -->
                        <div>
                            <label
                                for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Your email</label
                            >
                            <input
                                id="email"
                                type="email"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="username"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="name@company.com"
                            />
                            <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <!-- Password -->
                        <div>
                            <label
                                for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Password</label
                            >
                            <input
                                id="password"
                                type="password"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            />
                            <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">
                                {{ form.errors.password }}
                            </p>
                        </div>

                        <!-- Remember + Forgot password -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input
                                        id="remember"
                                        type="checkbox"
                                        v-model="form.remember"
                                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800"
                                    />
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="remember" class="text-gray-500 dark:text-gray-300"
                                        >Remember me</label
                                    >
                                </div>
                            </div>

                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500"
                            >
                                Forgot password?
                            </Link>
                        </div>

                        <!-- Submit -->
                        <button
                            type="submit"
                            class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                            :disabled="form.processing"
                            :class="{ 'opacity-25': form.processing }"
                        >
                            Sign in
                        </button>

                        <!-- Register link -->
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            Don't have an account yet?
                            <Link
                                href="/register"
                                class="font-medium text-primary-600 hover:underline dark:text-primary-500"
                            >
                                Sign up
                            </Link>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>
