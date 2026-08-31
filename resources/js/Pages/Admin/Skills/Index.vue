<template>
  <AuthenticatedLayout>
    <template #header>Skills Matrix Manager</template>
    <Head title="Skills Manager - Admin" />

    <div class="space-y-6 max-w-7xl mx-auto">
      <div class="flex items-center justify-between">
        <p class="text-xs text-slate-400">Manage technical skills, category groupings, and proficiency percentages.</p>
        <button
          @click="openCreateModal"
          class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs shadow-lg transition-colors"
        >
          + Add New Skill
        </button>
      </div>

      <!-- Skills Grid by Category -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div v-for="cat in categories" :key="cat" class="glass-panel p-6 rounded-2xl space-y-4">
          <div class="flex items-center justify-between border-b border-slate-800 pb-3">
            <h4 class="font-bold text-white text-sm">{{ cat }}</h4>
            <span class="text-xs text-indigo-400 font-mono font-bold">{{ getSkillsForCat(cat).length }}</span>
          </div>

          <div class="space-y-3">
            <div
              v-for="skill in getSkillsForCat(cat)"
              :key="skill.id"
              class="p-3 rounded-xl bg-slate-900/60 border border-slate-800 space-y-2 group"
            >
              <div class="flex items-center justify-between">
                <span class="font-bold text-xs text-white">{{ skill.name }}</span>
                <div class="space-x-2 text-[11px]">
                  <button @click="openEditModal(skill)" class="text-indigo-400 hover:text-indigo-300">Edit</button>
                  <button @click="deleteSkill(skill)" class="text-rose-400 hover:text-rose-300">Del</button>
                </div>
              </div>

              <div class="flex items-center space-x-2">
                <div class="flex-1 h-1.5 rounded-full bg-slate-950 overflow-hidden">
                  <div class="h-full bg-indigo-500 rounded-full" :style="{ width: skill.proficiency + '%' }"></div>
                </div>
                <span class="text-[10px] text-slate-400 font-mono">{{ skill.proficiency }}%</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- MODAL -->
      <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md">
        <div class="glass-panel p-8 rounded-3xl max-w-md w-full space-y-6 border border-slate-700 shadow-2xl relative">
          <button @click="closeModal" class="absolute top-4 right-4 text-slate-400 hover:text-white p-2">&times;</button>
          <h3 class="text-xl font-extrabold text-white">{{ isEditing ? 'Edit Skill' : 'Add New Skill' }}</h3>

          <form @submit.prevent="submitForm" class="space-y-4">
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">Skill Name</label>
              <input v-model="form.name" type="text" required class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs" />
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-1">Category</label>
              <select v-model="form.category" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-800 text-white text-xs">
                <option value="Frontend">Frontend</option>
                <option value="Backend">Backend</option>
                <option value="Database/DevOps">Database/DevOps</option>
                <option value="Tools">Tools</option>
              </select>
            </div>

            <div>
              <div class="flex justify-between text-xs font-semibold text-slate-300 mb-1">
                <span>Proficiency Level</span>
                <span class="text-indigo-400 font-mono">{{ form.proficiency }}%</span>
              </div>
              <input v-model="form.proficiency" type="range" min="1" max="100" class="w-full accent-indigo-500 cursor-pointer" />
            </div>

            <div class="pt-4 border-t border-slate-800 flex justify-end space-x-3">
              <button type="button" @click="closeModal" class="px-4 py-2 rounded-xl glass-card text-xs text-slate-400 hover:text-white">Cancel</button>
              <button type="submit" :disabled="form.processing" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold">
                {{ isEditing ? 'Save Changes' : 'Create Skill' }}
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
  skills: Array,
});

const notificationStore = useNotificationStore();
const categories = ['Frontend', 'Backend', 'Database/DevOps', 'Tools'];

const isModalOpen = ref(false);
const isEditing = ref(false);
const editingSkillId = ref(null);

const form = useForm({
  name: '',
  category: 'Frontend',
  proficiency: 90,
  icon: 'Code',
  is_featured: true,
  order: 0,
});

function getSkillsForCat(cat) {
  return (props.skills || []).filter(s => s.category === cat);
}

function openCreateModal() {
  isEditing.value = false;
  editingSkillId.value = null;
  form.reset();
  isModalOpen.value = true;
}

function openEditModal(skill) {
  isEditing.value = true;
  editingSkillId.value = skill.id;
  form.name = skill.name;
  form.category = skill.category;
  form.proficiency = skill.proficiency;
  form.icon = skill.icon || 'Code';
  form.is_featured = !!skill.is_featured;
  form.order = skill.order || 0;
  isModalOpen.value = true;
}

function closeModal() {
  isModalOpen.value = false;
}

function submitForm() {
  if (isEditing.value) {
    form.put(route('admin.skills.update', editingSkillId.value), {
      onSuccess: () => {
        closeModal();
        notificationStore.addToast({ title: 'Success', message: 'Skill updated successfully!' });
      },
    });
  } else {
    form.post(route('admin.skills.store'), {
      onSuccess: () => {
        closeModal();
        notificationStore.addToast({ title: 'Success', message: 'Skill created successfully!' });
      },
    });
  }
}

function deleteSkill(skill) {
  if (confirm(`Delete skill "${skill.name}"?`)) {
    router.delete(route('admin.skills.destroy', skill.id), {
      onSuccess: () => {
        notificationStore.addToast({ title: 'Deleted', message: 'Skill removed.', type: 'info' });
      },
    });
  }
}
</script>
