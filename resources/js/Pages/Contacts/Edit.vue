<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    contact: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.contact.name,
    email: props.contact.email,
    status: props.contact.status,
});

const submit = () => {
    form.put(route('contacts.update', props.contact.id));
};
</script>

<template>
    <Head title="Edit Contact" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-white"
            >
                Edit Contact
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow-sm"
                >
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <InputLabel
                                    for="name"
                                    value="Name"
                                />

                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.name"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    for="email"
                                    value="Email"
                                />

                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    required
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.email"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    for="status"
                                    value="Status"
                                />

                                <select
                                    id="status"
                                    v-model="form.status"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    required
                                >
                                    <option value="new" class="dark:bg-gray-700 dark:text-white">New</option>
                                    <option value="active" class="dark:bg-gray-700 dark:text-white">Active</option>
                                    <option value="lost" class="dark:bg-gray-700 dark:text-white">Lost</option>
                                </select>

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.status"
                                />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton
                                    :disabled="form.processing"
                                >
                                    Update Contact
                                </PrimaryButton>

                                <Link
                                    :href="route('contacts.index')"
                                    class="text-sm text-gray-600 dark:text-gray-400 underline hover:text-gray-900 dark:hover:text-gray-200"
                                >
                                    Cancel
                                </Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

