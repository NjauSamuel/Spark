<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    contacts: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    title: '',
    due_date: '',
    status: 'pending',
    contact_id: '',
});

const submit = () => {
    form.post(route('tasks.store'));
};
</script>

<template>
    <Head title="Create Task" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-white"
            >
                Create Task
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
                                    for="title"
                                    value="Title"
                                />

                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                    required
                                    autofocus
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.title"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    for="contact_id"
                                    value="Contact"
                                />

                                <select
                                    id="contact_id"
                                    v-model="form.contact_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    required
                                >
                                    <option value="" class="dark:bg-gray-700 dark:text-white">Select a contact</option>
                                    <option
                                        v-for="contact in contacts"
                                        :key="contact.id"
                                        :value="contact.id"
                                        class="dark:bg-gray-700 dark:text-white"
                                    >
                                        {{ contact.name }} ({{ contact.email }})
                                    </option>
                                </select>

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.contact_id"
                                />
                            </div>

                            <div>
                                <InputLabel
                                    for="due_date"
                                    value="Due Date"
                                />

                                <TextInput
                                    id="due_date"
                                    type="date"
                                    class="mt-1 block w-full"
                                    v-model="form.due_date"
                                    required
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.due_date"
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
                                    <option value="pending" class="dark:bg-gray-700 dark:text-white">Pending</option>
                                    <option value="in_progress" class="dark:bg-gray-700 dark:text-white">
                                        In Progress
                                    </option>
                                    <option value="completed" class="dark:bg-gray-700 dark:text-white">
                                        Completed
                                    </option>
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
                                    Create Task
                                </PrimaryButton>

                                <Link
                                    :href="route('tasks.index')"
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

