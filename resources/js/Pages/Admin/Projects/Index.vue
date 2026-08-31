<template>
  <AuthenticatedLayout>
    <template #header>Projects Manager</template>
    <Head title="Projects Manager - Admin" />

    <div class="space-y-6 max-w-7xl mx-auto">
      <!-- Header Actions -->
      <div class="flex items-center justify-between">
        <p class="text-xs text-slate-400">Add, edit, reorder, or feature portfolio showcase projects.</p>
        <button
          @click="openCreateModal"
          class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs shadow-lg transition-colors flex items-center space-x-2"
        >
          <span>+ Add New Project</span>
        </button>
      </div>

      <!-- Projects Data Table -->
      <div class="glass-panel rounded-2xl overflow-hidden border border-slate-800">
        <table class="w-full text-left text-xs text-slate-300">
          <thead class="bg-slate-900/80 text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-800">
            <tr>
              <th class="py-4 px-6">Project</th>
              <th class="py-4 px-4">Category</th>
              <th class="py-4 px-4">Tech Stack</th>
              <th class="py-4 px-4">Status</th>
              <th class="py-4 px-4 text-center">Order</th>
              <th class="py-4 px-6 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/80">
            <tr v-for="proj in projects" :key="proj.id" class="hover:bg-slate-900/40 transition-colors">
              <td class="py-4 px-6 flex items-center space-x-4">
                <img :src="proj.image_path || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=200&q=80'" class="w-12 h-12 rounded-xl object-cover border border-slate-800" />
                <div>
                  <h4 class="font-bold text-white text-sm">{{ proj.title }}</h4>
                  <span class="text-[11px] text-slate-400 font-mono line-clamp-1 max-w-xs">{{ proj.summary }}</span>
                </div>
              </td>
              <td class="py-4 px-4 font-semibold text-indigo-400">{{ proj.category }}</td>
              <td class="py-4 px-4">
                <div class="flex flex-wrap gap-1 max-w-xs">
                  <span v-for="(t, i) in (proj.tech_stack || [])" :key="i" class="px-2 py-0.5 rounded bg-slate-900 text-[10px] border border-slate-800">
                    {{ t }}
                  </span>
                </div>
              </td>
              <td class="py-4 px-4">
                <span
                  class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase"
                  :class="proj.is_featured ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : 'bg-slate-800 text-slate-400'"
                >
                  {{ proj.is_featured ? 'Featured' : 'Standard' }}
                </span>
              </td>
              <td class="py-4 px-4 text-center font-mono font-bold">{{ proj.order }}</td>
              <td class="py-4 px-6 text-right space-x-3">
                <button @click="openEditModal(proj)" class="text-indigo-400 hover:text-indigo-300 font-semibold text-xs">Edit</button>
                <button @click="deleteProject(proj)" class="text-rose-400 hover:text-rose-300 font-semibold text-xs">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- CREATE / EDIT MODAL -->
      <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md">
        <div class="glass-panel p-8 rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-y-auto space-y-6 border border-slate-700 shadow-2xl relative">
          <button @click="closeModal" class="absolute top-4 right-4 text-slate-400 hover:text-white p-2">&times;</button>
          <h3 class="text-xl font-extrabold text-white">{{ isEditing ? 'Edit Project' : 'Create New Project' }}</h3>

          <form @submit.prevent="submitForm" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Project Title</label>
                <input v-model="form.title" type="text" required class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Category</label>
                <select v-model="form.category" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs">
                  <option value="Fullstack">Fullstack</option>
                  <option value="Frontend">Frontend</option>
                  <option value="Laravel & Vue">Laravel & Vue</option>
                  <option value="AI">AI / ML</option>
                  <option value="Mobile">Mobile</option>
                </select>
              </div>
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">Image URL</label>
              <input v-model="form.image_path" type="text" placeholder="https://images.unsplash.com/..." class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">Summary (Short)</label>
              <input v-model="form.summary" type="text" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">Detailed Description</label>
              <textarea v-model="form.description" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs"></textarea>
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">Tech Stack (comma separated)</label>
              <input v-model="techStackInput" type="text" placeholder="Laravel 11, Vue 3, Inertia.js, Tailwind CSS" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Live Demo URL</label>
                <input v-model="form.demo_url" type="url" placeholder="https://..." class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">GitHub Repo URL</label>
                <input v-model="form.github_url" type="url" placeholder="https://github.com/..." class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
              </div>
            </div>

            <div class="flex items-center justify-between pt-2">
              <label class="flex items-center space-x-2 text-xs text-slate-300 cursor-pointer">
                <input v-model="form.is_featured" type="checkbox" class="rounded bg-slate-900 border-slate-800 text-indigo-600 focus:ring-0" />
                <span>Feature on Hero Showcase</span>
              </label>

              <div class="flex items-center space-x-2">
                <label class="text-xs text-slate-400">Display Order:</label>
                <input v-model="form.order" type="number" class="w-16 px-2 py-1 rounded-lg bg-slate-900 border border-slate-800 text-white text-xs text-center" />
              </div>
            </div>

            <div class="pt-4 border-t border-slate-800 flex justify-end space-x-3">
              <button type="button" @click="closeModal" class="px-4 py-2 rounded-xl glass-card text-xs text-slate-400 hover:text-white">Cancel</button>
              <button type="submit" :disabled="form.processing" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold">
                {{ isEditing ? 'Save Changes' : 'Create Project' }}
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
  projects: Array,
});

const notificationStore = useNotificationStore();

const isModalOpen = ref(false);
const isEditing = ref(false);
const editingProjectId = ref(null);
const techStackInput = ref('');

const form = useForm({
  title: '',
  category: 'Fullstack',
  summary: '',
  description: '',
  image_path: '',
  tech_stack: [],
  demo_url: '',
  github_url: '',
  is_featured: false,
  order: 0,
});

function openCreateModal() {
  isEditing.value = false;
  editingProjectId.value = null;
  form.reset();
  techStackInput.value = '';
  isModalOpen.value = true;
}

function openEditModal(project) {
  isEditing.value = true;
  editingProjectId.value = project.id;
  form.title = project.title;
  form.category = project.category;
  form.summary = project.summary || '';
  form.description = project.description || '';
  form.image_path = project.image_path || '';
  form.demo_url = project.demo_url || '';
  form.github_url = project.github_url || '';
  form.is_featured = !!project.is_featured;
  form.order = project.order || 0;
  techStackInput.value = (project.tech_stack || []).join(', ');
  isModalOpen.value = true;
}

function closeModal() {
  isModalOpen.value = false;
}

function submitForm() {
  form.tech_stack = techStackInput.value
    ? techStackInput.value.split(',').map(s => s.trim()).filter(Boolean)
    : [];

  if (isEditing.value) {
    form.put(route('admin.projects.update', editingProjectId.value), {
      onSuccess: () => {
        closeModal();
        notificationStore.addToast({ title: 'Success', message: 'Project updated successfully!' });
      },
    });
  } else {
    form.post(route('admin.projects.store'), {
      onSuccess: () => {
        closeModal();
        notificationStore.addToast({ title: 'Success', message: 'Project created successfully!' });
      },
    });
  }
}

function deleteProject(project) {
  if (confirm(`Are you sure you want to delete "${project.title}"?`)) {
    router.delete(route('admin.projects.destroy', project.id), {
      onSuccess: () => {
        notificationStore.addToast({ title: 'Deleted', message: 'Project removed.', type: 'info' });
      },
    });
  }
}
</script>
