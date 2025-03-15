<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const guard = page.props.auth.guard;

const currentNameInput = ref(null);
const currentEmailInput = ref(null);
const currentLogoInput = ref(null);
const currentWebsiteLinkInput = ref(null);

const company = page.props.company

if(company) {
    var url = (guard == 'admin') ? route('company.admin.update', { 'id': company?.id}) : route('company.update', { 'id': company?.id});
} else {
    var url = (guard == 'admin') ? route('company.admin.store') : route('company.store');
}

const form = useForm({
    name: company?.name ?? '',
    email: company?.email ?? '',
    logo: company?.logo ?? '',
    website_link: company?.website_link ?? '',
});

const createOrUpdateCompany = () => {
    if(company) {
        form.patch(url, {
            preserveScroll: true,
            // onSuccess: () => form.reset(),
            // onError: () => {
            //     if (form.errors.name) {
            //         form.reset('name', 'email', 'logo', 'website_link');
            //         passwordInput.value.focus();
            //     }
            // },
        });
    } else {
        form.post(url, {
            preserveScroll: true,
            // onSuccess: () => form.reset(),
            // onError: () => {
            //     if (form.errors.name) {
            //         form.reset('name', 'email', 'logo', 'website_link');
            //         passwordInput.value.focus();
            //     }
            // },
        });
    }
};

defineProps({
    title: {
        type: String,
    },
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ title }} Company
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Your company details
            </p>
        </header>

        <form @submit.prevent="createOrUpdateCompany" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Company Name" />

                <TextInput
                    id="name"
                    ref="currentNameInput"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                />

                <InputError
                    :message="form.errors.name"
                    class="mt-2"
                />
            </div>

            <div>
                <InputLabel for="email" value="Company Email" />

                <TextInput
                    id="email"
                    ref="currentEmailInput"
                    v-model="form.email"
                    type="text"
                    class="mt-1 block w-full"
                />

                <InputError
                    :message="form.errors.email"
                    class="mt-2"
                />
            </div>

            <div>
                <InputLabel for="logo" value="Company Logo" />

                <TextInput
                    id="logo"
                    ref="currentLogoInput"
                    v-model="form.logo"
                    type="text"
                    class="mt-1 block w-full"
                />

                <InputError
                    :message="form.errors.logo"
                    class="mt-2"
                />
            </div>

            <div>
                <InputLabel for="website_link" value="Company Website" />

                <TextInput
                    id="website_link"
                    ref="currentWebsiteLinkInput"
                    v-model="form.website_link"
                    type="text"
                    class="mt-1 block w-full"
                />

                <InputError
                    :message="form.errors.website_link"
                    class="mt-2"
                />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">{{ title }}</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
