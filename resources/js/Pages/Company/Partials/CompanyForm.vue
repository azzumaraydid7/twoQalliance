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
const company = page.props.company

const currentNameInput = ref(null);
const currentEmailInput = ref(null);
const currentWebsiteLinkInput = ref(null);
const currentLogoInput = ref(null);
const urlFile = ref(company?.logo ?? null);

const form = useForm({
    name: company?.name ?? '',
    email: company?.email ?? '',
    logo: company?.logo ?? '',
    website_link: company?.website_link ?? '',
});

const previewImage = (e) => {
    form.logo = e.target.files[0];
    urlFile.value = URL.createObjectURL(form.logo);
};

if(company) {
    var id = company.id
    var url = (guard == 'admin') ? route('company.admin.update', { 'id': id }) : route('company.update', { 'id': id });
} else {
    var url = (guard == 'admin') ? route('company.admin.store') : route('company.store');
}

const createOrUpdateCompany = () => {
    form.post(url, {
        forceFormData: true,
        preserveScroll: true,
    });
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

        <form @submit.prevent="createOrUpdateCompany" class="flex space-x-4 w-full">
            <div class="mt-6 space-y-6 w-full">
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
    
                    <input
                        id="logo"
                        name="logo"
                        type="file"
                        @change="previewImage"
                        ref="currentLogoInput"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mt-1 block w-full"
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
            </div>
            <div id="preview" class="border rounded mt-4 w-full max-h-96 ">
                <img v-if="urlFile" :src="urlFile" class="object-cover w-full h-full rounded"/>
            </div>
        </form>
    </section>
</template>
