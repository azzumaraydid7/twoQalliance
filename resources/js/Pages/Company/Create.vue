<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CompanyForm from './Partials/CompanyForm.vue';
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const guard = page.props.auth.guard;

const homepage = (guard == 'admin') ? route('admin.dashboard') : route('dashboard');
const profileLink = (guard == 'admin') ? route('profile.admin.edit') : route('profile.edit');
const companyLink = (guard == 'admin') ? route('company.admin.index') : route('company.index');
const logoutLink = (guard == 'admin') ? route('admin.logout') : route('logout');

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
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                >
                    <CompanyForm class="max-w-xl" :title="'Create'"/>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
