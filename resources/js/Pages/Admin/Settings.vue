<template>
  <AuthenticatedLayout>
    <template #header>Settings</template>
    <Head title="Settings - Admin" />

    <div class="space-y-8">
      <!-- Page Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-800 pb-6">
        <div>
          <h1 class="text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-50">
            Settings
          </h1>
          <p class="text-sm text-muted-foreground mt-1">Manage your professional social profile links, downloadable resume URL, and portfolio telemetry stats.</p>
        </div>
      </div>

      <form @submit.prevent="submitForm" class="space-y-6">
        <!-- Section 1: Social & Professional Links -->
        <div class="rounded-xl border border-neutral-800 bg-neutral-900/40 p-6 space-y-5 shadow-sm">
          <h3 class="text-sm font-bold text-white border-b border-neutral-800 pb-3">Social &amp; Professional Links</h3>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
              <label class="block text-xs font-semibold text-neutral-300 mb-1.5">GitHub Profile URL</label>
              <input 
                v-model="form.github_url" 
                type="text" 
                placeholder="e.g. https://github.com/username"
                class="w-full h-10 px-3.5 rounded-[8px] border border-neutral-800 bg-neutral-900/60 text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-white focus:outline-none transition-colors" 
              />
            </div>

            <div>
              <label class="block text-xs font-semibold text-neutral-300 mb-1.5">LinkedIn Profile URL</label>
              <input 
                v-model="form.linkedin_url" 
                type="text" 
                placeholder="e.g. https://linkedin.com/in/username"
                class="w-full h-10 px-3.5 rounded-[8px] border border-neutral-800 bg-neutral-900/60 text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-white focus:outline-none transition-colors" 
              />
            </div>

            <div>
              <label class="block text-xs font-semibold text-neutral-300 mb-1.5">Twitter / X URL</label>
              <input 
                v-model="form.twitter_url" 
                type="text" 
                placeholder="e.g. https://x.com/username"
                class="w-full h-10 px-3.5 rounded-[8px] border border-neutral-800 bg-neutral-900/60 text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-white focus:outline-none transition-colors" 
              />
            </div>

            <div>
              <label class="block text-xs font-semibold text-neutral-300 mb-1.5">Resume PDF / Cloud Link</label>
              <input 
                v-model="form.resume_url" 
                type="text" 
                placeholder="e.g. /resume.pdf or Google Drive link"
                class="w-full h-10 px-3.5 rounded-[8px] border border-neutral-800 bg-neutral-900/60 text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-white focus:outline-none transition-colors font-mono text-[11px]" 
              />
            </div>
          </div>
        </div>

        <!-- Section 2: Portfolio Metrics & Telemetry -->
        <div class="rounded-xl border border-neutral-800 bg-neutral-900/40 p-6 space-y-5 shadow-sm">
          <h3 class="text-sm font-bold text-white border-b border-neutral-800 pb-3">Portfolio Metrics &amp; Telemetry</h3>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
              <label class="block text-xs font-semibold text-neutral-300 mb-1.5">Years Experience Stat</label>
              <input 
                v-model="form.years_experience" 
                type="text" 
                placeholder="e.g. 5+"
                class="w-full h-10 px-3.5 rounded-[8px] border border-neutral-800 bg-neutral-900/60 text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-white focus:outline-none transition-colors" 
              />
            </div>
            <div>
              <label class="block text-xs font-semibold text-neutral-300 mb-1.5">Completed Projects Stat</label>
              <input 
                v-model="form.completed_projects" 
                type="text" 
                placeholder="e.g. 24+"
                class="w-full h-10 px-3.5 rounded-[8px] border border-neutral-800 bg-neutral-900/60 text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-white focus:outline-none transition-colors" 
              />
            </div>
            <div>
              <label class="block text-xs font-semibold text-neutral-300 mb-1.5">Satisfied Clients Stat</label>
              <input 
                v-model="form.satisfied_clients" 
                type="text" 
                placeholder="e.g. 18+"
                class="w-full h-10 px-3.5 rounded-[8px] border border-neutral-800 bg-neutral-900/60 text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-white focus:outline-none transition-colors" 
              />
            </div>
          </div>
        </div>

        <!-- Section 3: Portfolio Display & Homepage Controls -->
        <div class="rounded-xl border border-neutral-800 bg-neutral-900/40 p-6 space-y-5 shadow-sm">
          <h3 class="text-sm font-bold text-white border-b border-neutral-800 pb-3">Portfolio Display &amp; Homepage Controls</h3>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-semibold text-neutral-300 mb-1.5">Max Featured Projects Shown on Homepage</label>
              <input 
                v-model.number="form.featured_projects_count" 
                type="number" 
                min="1"
                max="50"
                placeholder="e.g. 3"
                class="w-full h-10 px-3.5 rounded-[8px] border border-neutral-800 bg-neutral-900/60 text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-white focus:outline-none transition-colors font-mono" 
              />
              <p class="text-[11px] text-neutral-400 mt-1.5 leading-relaxed">
                Controls how many projects display in the Featured Projects section on the homepage before showing the "Explore All Projects" link.
              </p>
            </div>
          </div>
        </div>

        <div class="flex justify-end pt-2">
          <button
            type="submit"
            :disabled="isSubmitting"
            class="h-9 px-5 rounded-[8px] bg-white hover:bg-neutral-200 text-black font-bold text-xs transition-all shadow-sm cursor-pointer disabled:opacity-50 flex items-center space-x-2"
          >
            <svg v-if="isSubmitting" class="animate-spin h-3.5 w-3.5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>{{ isSubmitting ? 'Saving Settings...' : 'Save Profile Settings' }}</span>
          </button>
        </div>
      </form>
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
  github_url: props.settings?.github_url || '',
  linkedin_url: props.settings?.linkedin_url || '',
  twitter_url: props.settings?.twitter_url || '',
  resume_url: props.settings?.resume_url || '',
  years_experience: props.settings?.years_experience || '5+',
  completed_projects: props.settings?.completed_projects || '24+',
  satisfied_clients: props.settings?.satisfied_clients || '18+',
  featured_projects_count: props.settings?.featured_projects_count ? Number(props.settings.featured_projects_count) : 3,
});

async function submitForm() {
  isSubmitting.value = true;
  try {
    await axios.post(route('admin.settings.update'), {
      github_url: form.github_url,
      linkedin_url: form.linkedin_url,
      twitter_url: form.twitter_url,
      resume_url: form.resume_url,
      years_experience: form.years_experience,
      completed_projects: form.completed_projects,
      satisfied_clients: form.satisfied_clients,
      featured_projects_count: form.featured_projects_count,
    });
    toast({
      title: 'Settings Saved',
      description: 'Your profile settings have been updated live.',
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
