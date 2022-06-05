<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetActionSection from '@/Jetstream/ActionSection.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue';
import JetDangerButton from '@/Jetstream/DangerButton.vue';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
import JetSectionBorder from '@/Jetstream/SectionBorder.vue';

const props = defineProps({
    tokens: Array,
    availablePermissions: Array,
    defaultPermissions: Array,
});

const createApiTokenForm = useForm({
    name: '',
    permissions: props.defaultPermissions,
});

const updateApiTokenForm = useForm({
    permissions: [],
});

const deleteApiTokenForm = useForm();

const displayingToken = ref(false);
const managingPermissionsFor = ref(null);
const apiTokenBeingDeleted = ref(null);

const createApiToken = () => {
    createApiTokenForm.post(route('api-tokens.store'), {
        preserveScroll: true,
        onSuccess: () => {
            displayingToken.value = true;
            createApiTokenForm.reset();
        },
    });
};

const manageApiTokenPermissions = (token) => {
    updateApiTokenForm.permissions = token.abilities;
    managingPermissionsFor.value = token;
};

const updateApiToken = () => {
    updateApiTokenForm.put(route('api-tokens.update', managingPermissionsFor.value), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (managingPermissionsFor.value = null),
    });
};

const confirmApiTokenDeletion = (token) => {
    apiTokenBeingDeleted.value = token;
};

const deleteApiToken = () => {
    deleteApiTokenForm.delete(route('api-tokens.destroy', apiTokenBeingDeleted.value), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (apiTokenBeingDeleted.value = null),
    });
};
</script>

<template>
    <div>
        <!-- Generate API Token -->
        <JetFormSection @submitted="createApiToken">
            <template #title>
                {{$t('system.auth.api.create.title')}}
            </template>

            <template #description>
                {{$t('system.auth.api.create.description')}}
            </template>

            <template #form>
                <!-- Token Name -->
                <div class="col-span-6 sm:col-span-4">
                    <JetLabel for="name" :value="$t('system.auth.api.token.name')" />
                    <JetInput
                        id="name"
                        v-model="createApiTokenForm.name"
                        type="text"
                        class="mt-1 block w-full"
                        autofocus
                    />
                    <JetInputError :message="createApiTokenForm.errors.name" class="mt-2" />
                </div>

                <!-- Token Permissions -->
                <div v-if="availablePermissions.length > 0" class="col-span-6">
                    <JetLabel for="permissions" :value="$t('system.auth.api.token.permissions')" />

                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div v-for="permission in availablePermissions" :key="permission">
                            <label class="flex items-center">
                                <JetCheckbox v-model:checked="createApiTokenForm.permissions" :value="permission" />
                                <span class="ml-2 text-sm text-gray-600">{{ permission }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </template>

            <template #actions>
                <JetActionMessage :on="createApiTokenForm.recentlySuccessful" class="mr-3">
                    {{$t('system.global.message.created')}}
                </JetActionMessage>

                <JetButton :class="{ 'opacity-25': createApiTokenForm.processing }" :disabled="createApiTokenForm.processing">
                    {{$t('system.global.action.create')}}
                </JetButton>
            </template>
        </JetFormSection>

        <div v-if="tokens.length > 0">
            <JetSectionBorder />

            <!-- Manage API Tokens -->
            <div class="mt-10 sm:mt-0">
                <JetActionSection>
                    <template #title>
                        {{$t('system.auth.api.manage.title')}}
                    </template>

                    <template #description>
                        {{$t('system.auth.api.manage.description')}}
                    </template>

                    <!-- API Token List -->
                    <template #content>
                        <div class="space-y-6">
                            <div v-for="token in tokens" :key="token.id" class="flex items-center justify-between">
                                <div>
                                    {{ token.name }}
                                </div>

                                <div class="flex items-center">
                                    <div v-if="token.last_used_ago" class="text-sm text-gray-400">
                                        {{$t('system.auth.api.lastUsed', [token.last_used_ago])}}
                                    </div>

                                    <button
                                        v-if="availablePermissions.length > 0"
                                        class="cursor-pointer ml-6 text-sm text-gray-400 underline"
                                        @click="manageApiTokenPermissions(token)"
                                    >
                                        {{$t('system.auth.api.token.permissions')}}
                                    </button>

                                    <button class="cursor-pointer ml-6 text-sm text-red-500" @click="confirmApiTokenDeletion(token)">
                                        {{$t('system.global.action.delete')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </JetActionSection>
            </div>
        </div>

        <!-- Token Value Modal -->
        <JetDialogModal :show="displayingToken" @close="displayingToken = false">
            <template #title>
                {{$t('system.auth.api.token.view.title')}}
            </template>

            <template #content>
                <div>
                    {{$t('system.auth.api.token.view.description')}}
                </div>

                <div v-if="$page.props.jetstream.flash.token" class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500">
                    {{ $page.props.jetstream.flash.token }}
                </div>
            </template>

            <template #footer>
                <JetSecondaryButton @click="displayingToken = false">
                    {{$t('system.global.action.close')}}
                </JetSecondaryButton>
            </template>
        </JetDialogModal>

        <!-- API Token Permissions Modal -->
        <JetDialogModal :show="managingPermissionsFor != null" @close="managingPermissionsFor = null">
            <template #title>
                {{$t('system.auth.api.token.permissions')}}
            </template>

            <template #content>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div v-for="permission in availablePermissions" :key="permission">
                        <label class="flex items-center">
                            <JetCheckbox v-model:checked="updateApiTokenForm.permissions" :value="permission" />
                            <span class="ml-2 text-sm text-gray-600">{{ permission }}</span>
                        </label>
                    </div>
                </div>
            </template>

            <template #footer>
                <JetSecondaryButton @click="managingPermissionsFor = null">
                    {{$t('system.global.action.cancel')}}
                </JetSecondaryButton>

                <JetButton
                    class="ml-3"
                    :class="{ 'opacity-25': updateApiTokenForm.processing }"
                    :disabled="updateApiTokenForm.processing"
                    @click="updateApiToken"
                >
                    {{$t('system.global.action.save')}}
                </JetButton>
            </template>
        </JetDialogModal>

        <!-- Delete Token Confirmation Modal -->
        <JetConfirmationModal :show="apiTokenBeingDeleted != null" @close="apiTokenBeingDeleted = null">
            <template #title>
                {{$t('system.auth.api.delete.title')}}
            </template>

            <template #content>
                {{$t('system.auth.api.delete.description')}}
            </template>

            <template #footer>
                <JetSecondaryButton @click="apiTokenBeingDeleted = null">
                    {{$t('system.global.action.cancel')}}
                </JetSecondaryButton>

                <JetDangerButton
                    class="ml-3"
                    :class="{ 'opacity-25': deleteApiTokenForm.processing }"
                    :disabled="deleteApiTokenForm.processing"
                    @click="deleteApiToken"
                >
                    {{$t('system.global.action.delete')}}
                </JetDangerButton>
            </template>
        </JetConfirmationModal>
    </div>
</template>
