<template>
  <AuthenticatedLayout>
    <template #header>Experience & Education Timeline</template>
    <Head title="Timeline Manager - Admin" />

    <div class="space-y-6 max-w-7xl mx-auto">
      <div class="flex items-center justify-between">
        <p class="text-xs text-slate-400">Manage employment career timeline and education history.</p>
        <button
          @click="openCreateModal"
          class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs shadow-lg transition-colors"
        >
          + Add Timeline Entry
        </button>
      </div>

      <div class="glass-panel rounded-2xl overflow-hidden border border-slate-800">
        <table class="w-full text-left text-xs text-slate-300">
          <thead class="bg-slate-900/80 text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-800">
            <tr>
              <th class="py-4 px-6">Role / Degree</th>
              <th class="py-4 px-4">Organization</th>
              <th class="py-4 px-4">Period</th>
              <th class="py-4 px-4">Type</th>
              <th class="py-4 px-6 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/80">
            <tr v-for="exp in experiences" :key="exp.id" class="hover:bg-slate-900/40 transition-colors">
              <td class="py-4 px-6">
                <h4 class="font-bold text-white text-sm">{{ exp.role }}</h4>
                <p class="text-[11px] text-slate-400 line-clamp-1 max-w-sm">{{ exp.description }}</p>
              </td>
              <td class="py-4 px-4 font-semibold text-slate-200">{{ exp.company }}</td>
              <td class="py-4 px-4 font-mono text-indigo-400">{{ exp.period }}</td>
              <td class="py-4 px-4">
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase" :class="exp.type === 'work' ? 'bg-purple-500/20 text-purple-300 border border-purple-500/30' : 'bg-blue-500/20 text-blue-300 border border-blue-500/30'">
                  {{ exp.type }}
                </span>
              </td>
              <td class="py-4 px-6 text-right space-x-3">
                <button @click="openEditModal(exp)" class="text-indigo-400 hover:text-indigo-300 font-semibold">Edit</button>
                <button @click="deleteExperience(exp)" class="text-rose-400 hover:text-rose-300 font-semibold">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- MODAL -->
      <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md">
        <div class="glass-panel p-8 rounded-3xl max-w-xl w-full max-h-[90vh] overflow-y-auto space-y-6 border border-slate-700 shadow-2xl relative">
          <button @click="closeModal" class="absolute top-4 right-4 text-slate-400 hover:text-white p-2">&times;</button>
          <h3 class="text-xl font-extrabold text-white">{{ isEditing ? 'Edit Entry' : 'Add Timeline Entry' }}</h3>

          <form @submit.prevent="submitForm" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Company / Institution</label>
                <input v-model="form.company" type="text" required class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Role / Degree Title</label>
                <input v-model="form.role" type="text" required class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
              <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Period (e.g. 2023 - 2025)</label>
                <input v-model="form.period" type="text" required class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Location</label>
                <input v-model="form.location" type="text" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Type</label>
                <select v-model="form.type" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs">
                  <option value="work">Work Experience</option>
                  <option value="education">Education</option>
                </select>
              </div>
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">Description Paragraph</label>
              <textarea v-model="form.description" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs"></textarea>
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">Key Highlights (comma separated bullet points)</label>
              <input v-model="highlightsInput" type="text" placeholder="Led team of 5, Improved query speed by 40%" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
            </div>

            <div class="pt-4 border-t border-slate-800 flex justify-end space-x-3">
              <button type="button" @click="closeModal" class="px-4 py-2 rounded-xl glass-card text-xs text-slate-400 hover:text-white">Cancel</button>
              <button type="submit" :disabled="form.processing" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold">
                {{ isEditing ? 'Save Changes' : 'Create Entry' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useNotificationStore } from '@/stores/useNotificationStore';

const props = defineProps({
  experiences: Array,
});

const notificationStore = useNotificationStore();

const isModalOpen = ref(false);
const isEditing = ref(false);
const editingExpId = ref(null);
const highlightsInput = ref('');

const form = useForm({
  company: '',
  role: '',
  period: '',
  location: '',
  description: '',
  highlights: [],
  type: 'work',
  order: 0,
});

function openCreateModal() {
  isEditing.value = false;
  editingExpId.value = null;
  form.reset();
  highlightsInput.value = '';
  isModalOpen.value = true;
}

function openEditModal(exp) {
  isEditing.value = true;
  editingExpId.value = exp.id;
  form.company = exp.company;
  form.role = exp.role;
  form.period = exp.period;
  form.location = exp.location || '';
  form.description = exp.description || '';
  form.type = exp.type || 'work';
  form.order = exp.order || 0;
  highlightsInput.value = (exp.highlights || []).join(', ');
  isModalOpen.value = true;
}

function closeModal() {
  isModalOpen.value = false;
}

function submitForm() {
  form.highlights = highlightsInput.value
    ? highlightsInput.value.split(',').map(s => s.trim()).filter(Boolean)
    : [];

  if (isEditing.value) {
    form.put(route('admin.experiences.update', editingExpId.value), {
      onSuccess: () => {
        closeModal();
        notificationStore.addToast({ title: 'Success', message: 'Experience entry updated!' });
      },
    });
  } else {
    form.post(route('admin.experiences.store'), {
      onSuccess: () => {
        closeModal();
        notificationStore.addToast({ title: 'Success', message: 'Experience entry created!' });
      },
    });
  }
}

function deleteExperience(exp) {
  if (confirm(`Delete timeline entry "${exp.role}"?`)) {
    router.delete(route('admin.experiences.destroy', exp.id), {
      onSuccess: () => {
        notificationStore.addToast({ title: 'Deleted', message: 'Timeline record deleted.', type: 'info' });
      },
    });
  }
}
</script>
