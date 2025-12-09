<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    contacts: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const searchForm = useForm({
    search: props.filters.search || '',
    status: props.filters.status || '',
});

const search = () => {
    const params = {};
    if (searchForm.search) {
        params.search = searchForm.search;
    }
    if (searchForm.status) {
        params.status = searchForm.status;
    }
    
    router.get(route('contacts.index'), params, {
        preserveState: true,
        preserveScroll: true,
        replace: false,
    });
};

const deleteContact = (contact) => {
    if (confirm('Are you sure you want to delete this contact?')) {
        router.delete(route('contacts.destroy', contact.id));
    }
};
</script>

<template>
    <Head title="Contacts" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800 dark:text-white"
                >
                    Contacts
                </h2>
                <Link :href="route('contacts.create')">
                    <PrimaryButton>Create Contact</PrimaryButton>
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
                            <div class="grid gap-4 sm:grid-cols-3">
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
                                        placeholder="Name or email..."
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                                    />
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
                                        <option value="new">New</option>
                                        <option value="active">Active</option>
                                        <option value="lost">Lost</option>
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

                <!-- Contacts Table -->
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
                                        Name
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                    >
                                        Email
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                    >
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300"
                                    >
                                        Created
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
                                    v-for="contact in contacts.data"
                                    :key="contact.id"
                                >
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white"
                                    >
                                        {{ contact.name }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400"
                                    >
                                        {{ contact.email }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm"
                                    >
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
                                                contact.status
                                                    .charAt(0)
                                                    .toUpperCase() +
                                                contact.status.slice(1)
                                            }}
                                        </span>
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400"
                                    >
                                        {{
                                            new Date(
                                                contact.created_at
                                            ).toLocaleDateString()
                                        }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium"
                                    >
                                        <Link
                                            :href="
                                                route(
                                                    'contacts.edit',
                                                    contact.id
                                                )
                                            "
                                            class="mr-3 text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300"
                                        >
                                            Edit
                                        </Link>
                                        <button
                                            @click="deleteContact(contact)"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="contacts.data.length === 0">
                                    <td
                                        colspan="5"
                                        class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400"
                                    >
                                        No contacts found. Create your first
                                        contact!
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div
                        v-if="contacts.links.length > 3"
                        class="border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 py-3 sm:px-6"
                    >
                        <div class="flex items-center justify-between">
                            <div class="flex flex-1 justify-between sm:hidden">
                                <Link
                                    v-if="contacts.links[0].url"
                                    :href="contacts.links[0].url"
                                    class="rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-white px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600"
                                >
                                    Previous
                                </Link>
                                <Link
                                    v-if="
                                        contacts.links[
                                            contacts.links.length - 1
                                        ].url
                                    "
                                    :href="
                                        contacts.links[
                                            contacts.links.length - 1
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
                                            contacts.from
                                        }}</span>
                                        to
                                        <span class="font-medium">{{
                                            contacts.to
                                        }}</span>
                                        of
                                        <span class="font-medium">{{
                                            contacts.total
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
                                            v-for="(link, index) in contacts.links"
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

