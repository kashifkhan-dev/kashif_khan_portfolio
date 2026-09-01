<template>
  <AuthenticatedLayout>
    <template #header>Skills Matrix Manager</template>
    <Head title="Skills Manager - Admin" />

    <div class="space-y-8 max-w-7xl mx-auto">
      <!-- Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b pb-6">
        <div>
          <h1 class="text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-50">Skills Matrix</h1>
          <p class="text-sm text-muted-foreground mt-1">Manage technical skills, category groupings, and proficiency percentages.</p>
        </div>

        <button
          @click="openCreateModal"
          class="h-9 px-4 text-xs font-bold rounded-lg bg-neutral-900 text-neutral-50 dark:bg-neutral-50 dark:text-neutral-900 hover:opacity-90 transition-all flex items-center gap-2 shadow-sm shrink-0"
        >
          <Plus class="h-4 w-4" />
          <span>Add New Skill</span>
        </button>
      </div>

      <!-- Skills Grid by Category -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div 
          v-for="cat in categories" 
          :key="cat" 
          class="rounded-xl border bg-card text-card-foreground shadow-sm p-6 space-y-4 flex flex-col justify-between"
        >
          <div>
            <div class="flex items-center justify-between border-b pb-3 mb-4">
              <h4 class="font-bold text-neutral-900 dark:text-neutral-50 text-sm">{{ cat }}</h4>
              <span class="text-xs text-muted-foreground font-mono font-bold">{{ getSkillsForCat(cat).length }}</span>
            </div>

            <div class="space-y-3">
              <div
                v-for="skill in getSkillsForCat(cat)"
                :key="skill.id"
                class="p-3 rounded-lg border bg-muted/40 space-y-2 hover:bg-muted/70 transition-colors"
              >
                <div class="flex items-center justify-between">
                  <span class="font-bold text-xs text-neutral-900 dark:text-neutral-50">{{ skill.name }}</span>
                  <div class="space-x-2 text-[11px]">
                    <button @click="openEditModal(skill)" class="font-semibold text-neutral-900 dark:text-neutral-100 hover:underline">Edit</button>
                    <button @click="deleteSkill(skill)" class="font-semibold text-rose-600 dark:text-rose-400 hover:underline">Del</button>
                  </div>
                </div>

                <div class="flex items-center space-x-2">
                  <div class="flex-1 h-1.5 rounded-full bg-muted overflow-hidden">
                    <div class="h-full bg-neutral-900 dark:bg-neutral-50 rounded-full transition-all" :style="{ width: skill.proficiency + '%' }"></div>
                  </div>
                  <span class="text-[10px] text-muted-foreground font-mono font-bold">{{ skill.proficiency }}%</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- MODAL DIALOG (Teleported to body) -->
      <teleport to="body">
        <div v-if="isModalOpen" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/80 backdrop-blur-md animate-in fade-in-50">
          <div class="rounded-xl border bg-card text-card-foreground shadow-2xl p-6 max-w-md w-full space-y-6 relative">
            <button @click="closeModal" class="absolute top-4 right-4 text-muted-foreground hover:text-foreground p-1.5 rounded-lg hover:bg-muted transition-colors">
              <X class="h-4 w-4" />
            </button>
            
            <div>
              <h3 class="text-lg font-bold text-neutral-900 dark:text-neutral-50">{{ isEditing ? 'Edit Skill' : 'Add New Skill' }}</h3>
              <p class="text-xs text-muted-foreground mt-0.5">Configure skill name, category, and proficiency level.</p>
            </div>

            <form @submit.prevent="submitForm" class="space-y-4 text-xs">
              <div class="space-y-1">
                <label class="font-semibold text-muted-foreground">Skill Name</label>
                <input 
                  v-model="form.name" 
                  type="text" 
                  required 
                  class="w-full h-9 px-3 rounded-lg border bg-background text-foreground text-xs focus:ring-1 focus:ring-ring outline-none" 
                />
              </div>

              <div class="space-y-1">
                <label class="font-semibold text-muted-foreground">Category</label>
                <select 
                  v-model="form.category" 
                  class="w-full h-9 px-3 rounded-lg border bg-background text-foreground text-xs focus:ring-1 focus:ring-ring outline-none"
                >
                  <option value="Frontend">Frontend</option>
                  <option value="Backend">Backend</option>
                  <option value="Database/DevOps">Database/DevOps</option>
                  <option value="Tools">Tools</option>
                </select>
              </div>

              <div class="space-y-1">
                <div class="flex justify-between font-semibold text-muted-foreground mb-1">
                  <span>Proficiency Level</span>
                  <span class="text-foreground font-mono font-bold">{{ form.proficiency }}%</span>
                </div>
                <input v-model="form.proficiency" type="range" min="1" max="100" class="w-full accent-neutral-900 dark:accent-neutral-50 cursor-pointer" />
              </div>

              <div class="pt-4 border-t flex justify-end gap-2">
                <button 
                  type="button" 
                  @click="closeModal" 
                  class="h-9 px-4 rounded-lg border bg-background text-xs font-semibold text-foreground hover:bg-muted transition-colors"
                >
                  Cancel
                </button>
                <button 
                  type="submit" 
                  :disabled="form.processing" 
                  class="h-9 px-4 rounded-lg bg-neutral-900 text-neutral-50 dark:bg-neutral-50 dark:text-neutral-900 text-xs font-bold hover:opacity-90 transition-all shadow-sm"
                >
                  {{ isEditing ? 'Save Changes' : 'Create Skill' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </teleport>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Plus, X } from 'lucide-vue-next';
import { useToast } from '@/Composables/useToast';

const props = defineProps({
  skills: Array,
});

const { toast } = useToast();
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
        toast({
          title: 'Skill Updated',
          description: `${form.name} skill updated successfully.`,
          type: 'success'
        });
      },
    });
  } else {
    form.post(route('admin.skills.store'), {
      onSuccess: () => {
        closeModal();
        toast({
          title: 'Skill Created',
          description: `${form.name} skill created successfully.`,
          type: 'success'
        });
      },
    });
  }
}

function deleteSkill(skill) {
  if (confirm(`Delete skill "${skill.name}"?`)) {
    router.delete(route('admin.skills.destroy', skill.id), {
      onSuccess: () => {
        toast({
          title: 'Skill Deleted',
          description: `Skill "${skill.name}" removed.`,
          type: 'error'
        });
      },
    });
  }
}
</script>
