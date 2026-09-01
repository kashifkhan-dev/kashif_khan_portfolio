<template>
  <AuthenticatedLayout>
    <template #header>Profile & Site Settings</template>
    <Head title="Site Settings - Admin" />

    <div class="space-y-8 max-w-4xl mx-auto">
      <div class="glass-panel p-8 rounded-3xl border border-slate-800 space-y-6">
        <div>
          <h3 class="text-lg font-bold text-white">Live Hero & Bio Customizer</h3>
          <p class="text-xs text-slate-400">Update headline titles, status badges, social links, and public bio text live on your portfolio landing page.</p>
        </div>

        <form @submit.prevent="submitForm" class="space-y-6">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1.5">Hero Headline Title</label>
              <input v-model="form.hero_title" type="text" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1.5">Availability Status Badge</label>
              <input v-model="form.availability_status" type="text" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
            </div>
          </div>

          <div>
            <label class="block text-xs font-semibold text-slate-300 mb-1.5">Hero Subtitle Paragraph</label>
            <textarea v-model="form.hero_subtitle" rows="3" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs leading-relaxed"></textarea>
          </div>

          <div>
            <label class="block text-xs font-semibold text-slate-300 mb-1.5">Full Bio Paragraph</label>
            <textarea v-model="form.bio" rows="4" class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs leading-relaxed"></textarea>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-slate-800">
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1.5">GitHub Profile URL</label>
              <input v-model="form.github_url" type="text" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1.5">LinkedIn Profile URL</label>
              <input v-model="form.linkedin_url" type="text" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1.5">Twitter / X URL</label>
              <input v-model="form.twitter_url" type="text" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1.5">Years Experience Stat</label>
              <input v-model="form.years_experience" type="text" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1.5">Completed Projects Stat</label>
              <input v-model="form.completed_projects" type="text" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1.5">Satisfied Clients Stat</label>
              <input v-model="form.satisfied_clients" type="text" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
            </div>
          </div>

          <div class="pt-6 border-t border-slate-800 flex justify-end">
            <button
              type="submit"
              :disabled="isSubmitting"
              class="px-6 py-3.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold text-xs shadow-xl shadow-indigo-600/30 transition-all flex items-center space-x-2 disabled:opacity-50 cursor-pointer"
            >
              <svg v-if="isSubmitting" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span>{{ isSubmitting ? 'Saving Settings...' : 'Save All Profile Settings' }}</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useToast } from '@/Composables/useToast';

const props = defineProps({
  settings: Object,
});

const { toast } = useToast();
const isSubmitting = ref(false);

const form = useForm({
  hero_title: props.settings?.hero_title || '',
  hero_subtitle: props.settings?.hero_subtitle || '',
  bio: props.settings?.bio || '',
  availability_status: props.settings?.availability_status || '',
  github_url: props.settings?.github_url || '',
  linkedin_url: props.settings?.linkedin_url || '',
  twitter_url: props.settings?.twitter_url || '',
  resume_url: props.settings?.resume_url || '',
  years_experience: props.settings?.years_experience || '5+',
  completed_projects: props.settings?.completed_projects || '24+',
  satisfied_clients: props.settings?.satisfied_clients || '18+',
});

async function submitForm() {
  isSubmitting.value = true;
  try {
    await axios.post(route('admin.settings.update'), {
      hero_title: form.hero_title,
      hero_subtitle: form.hero_subtitle,
      bio: form.bio,
      availability_status: form.availability_status,
      github_url: form.github_url,
      linkedin_url: form.linkedin_url,
      twitter_url: form.twitter_url,
      resume_url: form.resume_url,
      years_experience: form.years_experience,
      completed_projects: form.completed_projects,
      satisfied_clients: form.satisfied_clients,
    });
    toast({
      title: 'Settings Saved',
      description: 'Your site settings have been updated live.',
      type: 'success',
    });
  } catch (error) {
    toast({
      title: 'Save Failed',
      description: 'An error occurred while saving settings.',
      type: 'error',
    });
  } finally {
    isSubmitting.value = false;
  }
}
</script>
