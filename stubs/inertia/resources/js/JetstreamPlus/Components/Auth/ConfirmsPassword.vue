<script setup>
import { ref, reactive, nextTick } from 'vue';
import JetButton from '@/Jetstream/Button.vue';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';

const emit = defineEmits(['confirmed']);

defineProps({
    title: {
        type: String,
    },
    content: {
        type: String,
    },
    passwordText: {
        type: String,
    },
    confirmButtonText: {
        type: String,
    },
    cancelButtonText: {
        type: String,
    },
});

/*Multi-lang*/
import {useI18n} from 'vue-i18n'
const {t} = useI18n()

const confirmingPassword = ref(false);

const form = reactive({
    password: '',
    error: '',
    processing: false,
});

const passwordInput = ref(null);

const startConfirmingPassword = () => {
    axios.get(route('password.confirmation')).then(response => {
        if (response.data.confirmed) {
            emit('confirmed');
        } else {
            confirmingPassword.value = true;

            setTimeout(() => passwordInput.value.focus(), 250);
        }
    });
};

const confirmPassword = () => {
    form.processing = true;

    axios.post(route('password.confirm'), {
        password: form.password,
    }).then(() => {
        form.processing = false;

        closeModal();
        nextTick().then(() => emit('confirmed'));

    }).catch(error => {
        form.processing = false;
        form.error = error.response.data.errors.password[0];
        passwordInput.value.focus();
    });
};

const closeModal = () => {
    confirmingPassword.value = false;
    form.password = '';
    form.error = '';
};
</script>

<template>
    <span>
        <span @click="startConfirmingPassword">
            <slot />
        </span>

        <JetDialogModal :show="confirmingPassword" @close="closeModal">
            <template #title>
                {{ title ? title : $t('system.auth.password.confirm.title') }}
            </template>

            <template #content>
                {{ content ? content : $t('system.auth.password.confirm.description') }}

                <div class="mt-4">
                    <JetInput
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        :placeholder="passwordText ? passwordText : $t('system.auth.password.label')"
                        @keyup.enter="confirmPassword"
                    />

                    <JetInputError :message="form.error" class="mt-2" />
                </div>
            </template>

            <template #footer>
                <JetSecondaryButton @click="closeModal">
                    {{ cancelButtonText ? cancelButtonText : $t('system.global.action.cancel') }}
                </JetSecondaryButton>

                <JetButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="confirmPassword"
                >
                    {{ confirmButtonText ? confirmButtonText : $t('system.global.action.confirm') }}
                </JetButton>
            </template>
        </JetDialogModal>
    </span>
</template>
