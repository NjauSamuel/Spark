<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';

const props = defineProps({
    tasks: {
        type: Object,
        required: true,
    },
    contacts: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const searchForm = useForm({
    search: props.filters.search || '',
    status: props.filters.status || '',
    contact_id: props.filters.contact_id || '',
});

const search = () => {
    const params = {};
    if (searchForm.search) {
        params.search = searchForm.search;
    }
    if (searchForm.status) {
        params.status = searchForm.status;
    }
    if (searchForm.contact_id) {
        params.contact_id = searchForm.contact_id;
    }
    
    router.get(route('tasks.index'), params, {
        preserveState: true,
        preserveScroll: true,
        replace: false,
    });
};

const deleteTask = (task) => {
    if (confirm('Are you sure you want to delete this task?')) {
        router.delete(route('tasks.destroy', task.id));
    }
};
</script>

<template>
    <Head title="Tasks" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800 dark:text-white"
                >
                    Tasks
                </h2>
                <Link :href="route('tasks.create')">
                    <PrimaryButton>Create Task</PrimaryButton>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Filters -->
                <div
                    class="mb-6 overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow-sm"
                >
                    <div class="p-6">
                        <form @submit.prevent="search" class="space-y-4">
                            <div class="grid gap-4 sm:grid-cols-4">
                                <div>
                                    <label
                                        for="search"
                                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >
                                        Search
                                    </label>
                                    <input
                                        id="search"
                                        v-model="searchForm.search"
                                        type="text"
                                        placeholder="Task title..."
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    />
                                </div>
                                <div>
                                    <label
                                        for="contact_id"
                                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >
                                        Contact
                                    </label>
                                    <select
                                        id="contact_id"
                                        v-model="searchForm.contact_id"
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    >
                                        <option value="">All Contacts</option>
                                        <option
                                            v-for="contact in contacts"
                                            :key="contact.id"
                                            :value="contact.id"
                                        >
                                            {{ contact.name }}
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label
                                        for="status"
                                        class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >
                                        Status
                                    </label>
                                    <select
                                        id="status"
                                        v-model="searchForm.status"
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    >
                                        <option value="">All Statuses</option>
                                        <option value="pending">Pending</option>
                                        <option value="in_progress">
                                            In Progress
                                        </option>
                                        <option value="completed">
                                            Completed
                                        </option>
                                    </select>
                                </div>
                                <div class="flex items-end">
                                    <PrimaryButton
                                        type="submit"
                                        :disabled="searchForm.processing"
                                    >
                                        Filter
                                    </PrimaryButton>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tasks Table -->
                <div
                    class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow-sm"
                >
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                    >
                                        Title
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                    >
                                        Contact
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                    >
                                        Due Date
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                    >
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                <tr
                                    v-for="task in tasks.data"
                                    :key="task.id"
                                >
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white"
                                    >
                                        {{ task.title }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400"
                                    >
                                        {{ task.contact?.name || 'N/A' }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400"
                                    >
                                        {{
                                            new Date(
                                                task.due_date
                                            ).toLocaleDateString()
                                        }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm"
                                    >
                                        <span
                                            class="inline-flex rounded-full px-2 py-1 text-xs font-semibold"
                                            :class="{
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300':
                                                    task.status === 'pending',
                                                'bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300':
                                                    task.status === 'in_progress',
                                                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300':
                                                    task.status === 'completed',
                                            }"
                                        >
                                            {{
                                                task.status
                                                    .replace('_', ' ')
                                                    .split(' ')
                                                    .map(
                                                        (word) =>
                                                            word
                                                                .charAt(0)
                                                                .toUpperCase() +
                                                            word.slice(1)
                                                    )
                                                    .join(' ')
                                            }}
                                        </span>
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium"
                                    >
                                        <Link
                                            :href="
                                                route('tasks.edit', task.id)
                                            "
                                            class="mr-3 text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300"
                                        >
                                            Edit
                                        </Link>
                                        <button
                                            @click="deleteTask(task)"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="tasks.data.length === 0">
                                    <td
                                        colspan="5"
                                        class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400"
                                    >
                                        No tasks found. Create your first task!
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div
                        v-if="tasks.links.length > 3"
                        class="border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 sm:px-6"
                    >
                        <div class="flex items-center justify-between">
                            <div class="flex flex-1 justify-between sm:hidden">
                                <Link
                                    v-if="tasks.links[0].url"
                                    :href="tasks.links[0].url"
                                    class="rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-white px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600"
                                >
                                    Previous
                                </Link>
                                <Link
                                    v-if="
                                        tasks.links[
                                            tasks.links.length - 1
                                        ].url
                                    "
                                    :href="
                                        tasks.links[
                                            tasks.links.length - 1
                                        ].url
                                    "
                                    class="ml-3 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-white px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600"
                                >
                                    Next
                                </Link>
                            </div>
                            <div
                                class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between"
                            >
                                <div>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        Showing
                                        <span class="font-medium">{{
                                            tasks.from
                                        }}</span>
                                        to
                                        <span class="font-medium">{{
                                            tasks.to
                                        }}</span>
                                        of
                                        <span class="font-medium">{{
                                            tasks.total
                                        }}</span>
                                        results
                                    </p>
                                </div>
                                <div>
                                    <nav
                                        class="isolate inline-flex -space-x-px rounded-md shadow-sm"
                                        aria-label="Pagination"
                                    >
                                        <Link
                                            v-for="(link, index) in tasks.links"
                                            :key="index"
                                            :href="link.url || '#'"
                                            v-html="link.label"
                                            class="relative inline-flex items-center border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-white px-4 py-2 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:z-20"
                                            :class="{
                                                'z-10 border-primary-500 bg-primary-50 dark:bg-primary-900 text-primary-600 dark:text-primary-300':
                                                    link.active,
                                                'pointer-events-none opacity-50':
                                                    !link.url,
                                            }"
                                        />
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

