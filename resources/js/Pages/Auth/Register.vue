<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>
    <Head title="Register" />

    <section class="bg-gray-50 dark:bg-gray-900 h-screen">
        <div
            class="flex flex-col items-center justify-center px-6 py-8 mx-auto"
        >
            <!-- Logo -->
            <Link
                href="/"
                class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white"
            >
                <img
                    class="w-24 h-16 mr-2"
                    src="/images/Spark.png"
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
                        Create an account
                    </h1>

                    <!-- Form -->
                    <form @submit.prevent="submit" class="space-y-4 md:space-y-6">
                        <!-- Name -->
                        <div>
                            <label
                                for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Your name</label
                            >
                            <input
                                id="name"
                                type="text"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="John Doe"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            />
                            <p v-if="form.errors.name" class="mt-2 text-sm text-red-600">
                                {{ form.errors.name }}
                            </p>
                        </div>

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
                                autocomplete="username"
                                placeholder="name@company.com"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
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
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            />
                            <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">
                                {{ form.errors.password }}
                            </p>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label
                                for="password_confirmation"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Confirm password</label
                            >
                            <input
                                id="password_confirmation"
                                type="password"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            />
                            <p
                                v-if="form.errors.password_confirmation"
                                class="mt-2 text-sm text-red-600"
                            >
                                {{ form.errors.password_confirmation }}
                            </p>
                        </div>                        

                        <!-- Submit -->
                        <button
                            type="submit"
                            class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                            :disabled="form.processing"
                            :class="{ 'opacity-25': form.processing }"
                        >
                            Create an account
                        </button>

                        <!-- Already have account -->
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            Already have an account?
                            <Link
                                :href="route('login')"
                                class="font-medium text-primary-600 hover:underline dark:text-primary-500"
                            >
                                Login here
                            </Link>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>
