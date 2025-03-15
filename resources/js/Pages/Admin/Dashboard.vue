<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
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
    <Head title="Dashboard" />

    <AuthenticatedLayout :dashboard="homepage" :profile="profileLink" :company="companyLink" :logout="logoutLink">
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Admin Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
