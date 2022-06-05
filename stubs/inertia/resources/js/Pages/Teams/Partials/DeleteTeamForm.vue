<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import JetActionSection from '@/Jetstream/ActionSection.vue';
import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue';
import JetDangerButton from '@/Jetstream/DangerButton.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';

const props = defineProps({
    team: Object,
});

const confirmingTeamDeletion = ref(false);
const form = useForm();

const confirmTeamDeletion = () => {
    confirmingTeamDeletion.value = true;
};

const deleteTeam = () => {
    form.delete(route('teams.destroy', props.team), {
        errorBag: 'deleteTeam',
    });
};
</script>

<template>
    <JetActionSection>
        <template #title>
            {{$t('system.auth.team.delete.title')}}
        </template>

        <template #description>
            {{$t('system.auth.team.delete.description')}}
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                {{$t('system.auth.team.delete.warning')}}
            </div>

            <div class="mt-5">
                <JetDangerButton @click="confirmTeamDeletion">
                    {{$t('system.auth.team.delete.label')}}
                </JetDangerButton>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <JetConfirmationModal :show="confirmingTeamDeletion" @close="confirmingTeamDeletion = false">
                <template #title>
                    {{$t('system.auth.team.delete.title')}}
                </template>

                <template #content>
                    {{$t('system.auth.team.delete.areYouSure')}}
                </template>

                <template #footer>
                    <JetSecondaryButton @click="confirmingTeamDeletion = false">
                        {{$t('system.global.action.cancel')}}
                    </JetSecondaryButton>

                    <JetDangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteTeam"
                    >
                        {{$t('system.auth.team.delete.label')}}
                    </JetDangerButton>
                </template>
            </JetConfirmationModal>
        </template>
    </JetActionSection>
</template>
