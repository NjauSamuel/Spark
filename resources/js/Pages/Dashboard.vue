<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    stats: {
        type: Object,
        required: true,
    },
    recentContacts: {
        type: Array,
        default: () => [],
    },
    recentTasks: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-white"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Stats Cards -->
                <div class="mb-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div
                        class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow-sm"
                    >
                        <div class="p-6">
                            <div
                                class="flex items-center justify-between"
                            >
                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-600 dark:text-gray-400"
                                    >
                                        Total Contacts
                                    </p>
                                    <p
                                        class="mt-2 text-3xl font-bold text-gray-900 dark:text-white"
                                    >
                                        {{ stats.contacts_count }}
                                    </p>
                                </div>
                                <div
                                    class="rounded-full bg-primary-100 dark:bg-primary-900 p-3"
                                >
                                    <svg
                                        class="h-6 w-6 text-primary-600 dark:text-primary-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow-sm"
                    >
                        <div class="p-6">
                            <div
                                class="flex items-center justify-between"
                            >
                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-600 dark:text-gray-400"
                                    >
                                        Total Tasks
                                    </p>
                                    <p
                                        class="mt-2 text-3xl font-bold text-gray-900 dark:text-white"
                                    >
                                        {{ stats.tasks_count }}
                                    </p>
                                </div>
                                <div
                                    class="rounded-full bg-green-100 dark:bg-green-900 p-3"
                                >
                                    <svg
                                        class="h-6 w-6 text-green-600 dark:text-green-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow-sm"
                    >
                        <div class="p-6">
                            <div
                                class="flex items-center justify-between"
                            >
                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-600 dark:text-gray-400"
                                    >
                                        Pending Tasks
                                    </p>
                                    <p
                                        class="mt-2 text-3xl font-bold text-yellow-600 dark:text-yellow-400"
                                    >
                                        {{ stats.tasks_pending }}
                                    </p>
                                </div>
                                <div
                                    class="rounded-full bg-yellow-100 dark:bg-yellow-900 p-3"
                                >
                                    <svg
                                        class="h-6 w-6 text-yellow-600 dark:text-yellow-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow-sm"
                    >
                        <div class="p-6">
                            <div
                                class="flex items-center justify-between"
                            >
                                <div>
                                    <p
                                        class="text-sm font-medium text-gray-600 dark:text-gray-400"
                                    >
                                        Completed Tasks
                                    </p>
                                    <p
                                        class="mt-2 text-3xl font-bold text-green-600 dark:text-green-400"
                                    >
                                        {{ stats.tasks_completed }}
                                    </p>
                                </div>
                                <div
                                    class="rounded-full bg-green-100 dark:bg-green-900 p-3"
                                >
                                    <svg
                                        class="h-6 w-6 text-green-600 dark:text-green-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="grid gap-6 lg:grid-cols-2">
                    <!-- Recent Contacts -->
                    <div
                        class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow-sm"
                    >
                        <div class="border-b border-gray-200 dark:border-gray-700 p-6">
                            <div
                                class="flex items-center justify-between"
                            >
                                <h3
                                    class="text-lg font-semibold text-gray-900 dark:text-white"
                                >
                                    Recent Contacts
                                </h3>
                                <Link
                                    :href="route('contacts.index')"
                                    class="text-sm font-medium text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300"
                                >
                                    View all
                                </Link>
                            </div>
                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            <div
                                v-for="contact in recentContacts"
                                :key="contact.id"
                                class="p-6"
                            >
                                <div
                                    class="flex items-center justify-between"
                                >
                                    <div>
                                        <p
                                            class="font-medium text-gray-900 dark:text-white"
                                        >
                                            {{ contact.name }}
                                        </p>
                                        <p
                                            class="text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            {{ contact.email }}
                                        </p>
                                    </div>
                                    <span
                                        class="inline-flex rounded-full px-2 py-1 text-xs font-semibold"
                                        :class="{
                                            'bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300':
                                                contact.status === 'new',
                                            'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300':
                                                contact.status === 'active',
                                            'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300':
                                                contact.status === 'lost',
                                        }"
                                    >
                                        {{
                                            contact.status.charAt(0).toUpperCase() +
                                            contact.status.slice(1)
                                        }}
                                    </span>
                                </div>
                            </div>
                            <div
                                v-if="recentContacts.length === 0"
                                class="p-6 text-center text-gray-500 dark:text-gray-400"
                            >
                                No contacts yet. Create your first contact!
                            </div>
                        </div>
                    </div>

                    <!-- Recent Tasks -->
                    <div
                        class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow-sm"
                    >
                        <div class="border-b border-gray-200 dark:border-gray-700 p-6">
                            <div
                                class="flex items-center justify-between"
                            >
                                <h3
                                    class="text-lg font-semibold text-gray-900 dark:text-white"
                                >
                                    Recent Tasks
                                </h3>
                                <Link
                                    :href="route('tasks.index')"
                                    class="text-sm font-medium text-primary-600 hover:text-primary-800 dark:text-primary-400 dark:hover:text-primary-300"
                                >
                                    View all
                                </Link>
                            </div>
                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            <div
                                v-for="task in recentTasks"
                                :key="task.id"
                                class="p-6"
                            >
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p
                                            class="font-medium text-gray-900 dark:text-white"
                                        >
                                            {{ task.title }}
                                        </p>
                                        <p
                                            class="mt-1 text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            Contact:
                                            {{
                                                task.contact?.name ||
                                                'N/A'
                                            }}
                                        </p>
                                        <p
                                            class="mt-1 text-xs text-gray-400 dark:text-gray-500"
                                        >
                                            Due:
                                            {{
                                                new Date(
                                                    task.due_date
                                                ).toLocaleDateString()
                                            }}
                                        </p>
                                    </div>
                                    <span
                                        class="ml-4 inline-flex rounded-full px-2 py-1 text-xs font-semibold"
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
                                                        word.charAt(0).toUpperCase() +
                                                        word.slice(1)
                                                )
                                                .join(' ')
                                        }}
                                    </span>
                                </div>
                            </div>
                            <div
                                v-if="recentTasks.length === 0"
                                class="p-6 text-center text-gray-500 dark:text-gray-400"
                            >
                                No tasks yet. Create your first task!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
