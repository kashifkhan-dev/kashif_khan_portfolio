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
              :disabled="form.processing"
              class="px-6 py-3.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold text-xs shadow-xl shadow-indigo-600/30 transition-all"
            >
              <span v-if="form.processing">Saving Settings...</span>
              <span v-else>Save All Profile Settings</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useNotificationStore } from '@/stores/useNotificationStore';

const props = defineProps({
  settings: Object,
});

const notificationStore = useNotificationStore();

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

function submitForm() {
  form.post(route('admin.settings.update'), {
    preserveScroll: true,
    onSuccess: () => {
      notificationStore.addToast({
        title: 'Settings Saved',
        message: 'Your profile details have been updated live on the landing page.',
        type: 'success',
      });
    },
  });
}
</script>
