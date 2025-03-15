<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NavLink from '@/Components/NavLink.vue';
import { Head, Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage();
const guard = page.props.auth.guard;

const homepage = (guard == 'admin') ? route('admin.dashboard') : route('dashboard');
const profileLink = (guard == 'admin') ? route('profile.admin.edit') : route('profile.edit');
const companyLink = (guard == 'admin') ? route('company.admin.index') : route('company.index');
const logoutLink = (guard == 'admin') ? route('admin.logout') : route('logout');

const companyCreate = (guard == 'admin') ? route('company.admin.create') : route('company.create');

const companies = ref(page.props.companies)

</script>

<template>
    <Head title="Company" />

    <AuthenticatedLayout :dashboard="homepage" :profile="profileLink" :company="companyLink" :logout="logoutLink">
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Company
            </h2>
        </template>

        <div class="py-12">
            
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <Link
                    :href="companyCreate"
                    :class="'inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900'"
                >
                    Create
                </Link>
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Company Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Website Link
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="company in companies" :key="company.id"
                                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white flex items-center">
                                        <img :src="company.logo" :alt="company.name" class="w-10 h-10 object-fit border rounded mr-4">
                                        {{ company.name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ company.email }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ company.website_link }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <NavLink
                                            :href="(guard == 'admin') ? route('company.admin.edit', { 'id': company.id}) : route('company.edit', { 'id': company.id})"
                                        >
                                            Edit
                                        </NavLink>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
