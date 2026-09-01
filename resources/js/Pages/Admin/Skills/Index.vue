<template>
  <AuthenticatedLayout>
    <template #header>Skills Ticker Manager</template>
    <Head title="Skills Manager - Admin" />

    <div class="space-y-6 max-w-6xl mx-auto">
      <!-- Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-800 pb-6">
        <div>
          <div class="flex items-center space-x-3">
            <h1 class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-neutral-50">Skills &amp; Tech Stack</h1>
            <span class="px-2 py-0.5 text-[11px] font-mono font-medium rounded-[8px] bg-neutral-800 text-neutral-300 border border-neutral-700">
              {{ skills.length }} Active
            </span>
          </div>
          <p class="text-xs text-muted-foreground mt-1">Manage technical skills and icons displayed live in the landing page ticker marquee.</p>
        </div>

        <div class="flex items-center space-x-3">
          <!-- Search Filter Bar -->
          <div class="relative flex items-center w-48 sm:w-60">
            <Search class="h-3.5 w-3.5 absolute left-3 text-neutral-400 pointer-events-none" />
            <input
              v-model="pageSearchQuery"
              type="text"
              placeholder="Filter skills..."
              class="w-full h-9 pl-9 pr-3 rounded-[8px] border border-neutral-800 bg-neutral-900/60 text-white text-xs focus:outline-none focus:border-white transition-colors"
            />
          </div>

          <!-- Add Button -->
          <button
            @click="openCreateModal"
            class="h-9 px-3.5 text-xs font-bold rounded-[8px] bg-white hover:bg-neutral-200 text-black transition-all flex items-center gap-2 shadow-sm shrink-0 cursor-pointer"
          >
            <Plus class="h-4 w-4" />
            <span>Add Skill</span>
          </button>
        </div>
      </div>

      <!-- Skills Cards Grid -->
      <div v-if="filteredPageSkills.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3.5">
        <div
          v-for="skill in filteredPageSkills"
          :key="skill.id"
          class="p-3.5 rounded-[8px] border border-neutral-800/80 bg-neutral-900/40 hover:bg-neutral-900/90 hover:border-neutral-700 transition-all shadow-sm flex items-center justify-between group"
        >
          <div class="flex items-center space-x-3 min-w-0">
            <div class="w-10 h-10 rounded-[8px] bg-neutral-950 border border-neutral-800 flex items-center justify-center shrink-0 group-hover:border-neutral-700 transition-colors shadow-inner">
              <TechIcon :name="skill.icon || 'api'" class="w-5 h-5" />
            </div>
            <div class="min-w-0 space-y-0.5">
              <h4 class="font-semibold text-xs text-neutral-200 group-hover:text-white truncate transition-colors">{{ skill.name }}</h4>
              <span class="text-[10px] font-mono text-neutral-400 uppercase tracking-wider block truncate">{{ skill.icon || 'api' }}</span>
            </div>
          </div>

          <div class="flex items-center space-x-1 shrink-0 ml-2">
            <button
              @click="openEditModal(skill)"
              title="Edit Skill"
              class="p-1.5 rounded-[8px] text-neutral-400 hover:text-white hover:bg-neutral-800 transition-colors cursor-pointer"
            >
              <Edit3 class="h-3.5 w-3.5" />
            </button>
            <button
              @click="deleteSkill(skill)"
              title="Delete Skill"
              class="p-1.5 rounded-[8px] text-neutral-400 hover:text-rose-400 hover:bg-rose-950/40 transition-colors cursor-pointer"
            >
              <Trash2 class="h-3.5 w-3.5" />
            </button>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="p-12 text-center border border-dashed border-neutral-800 rounded-[8px] bg-neutral-900/20 space-y-3">
        <p class="text-xs text-neutral-400">No skills match your filter.</p>
        <button
          @click="pageSearchQuery = ''"
          class="text-xs text-white underline hover:no-underline cursor-pointer"
        >
          Clear filter
        </button>
      </div>

      <!-- MODAL DIALOG -->
      <teleport to="body">
        <div v-if="isModalOpen" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/80 backdrop-blur-md animate-in fade-in-50">
          <div class="rounded-[8px] border border-neutral-800 bg-neutral-950 text-neutral-50 shadow-2xl p-6 max-w-lg w-full space-y-6 relative max-h-[90vh] flex flex-col overflow-hidden">
            <!-- Close Button -->
            <button @click="closeModal" class="absolute top-4 right-4 text-neutral-400 hover:text-white p-1.5 rounded-[8px] hover:bg-neutral-900 transition-colors z-10">
              <X class="h-4 w-4" />
            </button>
            
            <div class="shrink-0">
              <h3 class="text-lg font-bold text-white">{{ isEditing ? 'Edit Skill' : 'Add New Skill' }}</h3>
              <p class="text-xs text-neutral-400 mt-0.5">Enter skill name and pick a tech icon from the 3,000+ icon library below.</p>
            </div>

            <form @submit.prevent="submitForm" class="space-y-5 text-xs flex-1 overflow-y-auto pr-1">
              <!-- Skill Name Input -->
              <div class="space-y-1.5">
                <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">Skill Name</label>
                <input 
                  v-model="form.name" 
                  type="text" 
                  required 
                  placeholder="e.g. React.js, Bootstrap, Docker"
                  class="w-full h-9 px-3 rounded-[8px] border border-neutral-800 bg-neutral-900 text-white text-xs focus:ring-1 focus:ring-white focus:border-white outline-none transition-colors" 
                />
              </div>

              <!-- Visual Icon Selector Grid -->
              <div class="space-y-2">
                <div class="flex items-center justify-between">
                  <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">Select Tech Icon</label>
                  <div class="flex items-center space-x-2">
                    <span class="text-[10px] text-neutral-400 font-mono">Selected: {{ form.icon }}</span>
                    <TechIcon :name="form.icon" class="w-4 h-4" />
                  </div>
                </div>

                <!-- Icon Search Filter -->
                <div class="relative flex items-center">
                  <Search class="h-4 w-4 absolute left-3 text-neutral-400 pointer-events-none" />
                  <input
                    v-model="iconSearchQuery"
                    type="text"
                    placeholder="Search 3,000+ tech icons (e.g. bootstrap, flutter, go, rust)..."
                    class="w-full h-9 pl-9 pr-3 rounded-[8px] border border-neutral-800 bg-neutral-900 text-white text-xs focus:outline-none focus:border-white transition-colors"
                  />
                </div>

                <!-- Icons Grid Picker -->
                <div class="grid grid-cols-4 sm:grid-cols-6 gap-2 p-2 rounded-[8px] border border-neutral-800 bg-neutral-900/60 max-h-48 overflow-y-auto">
                  <button
                    v-for="opt in filteredIcons"
                    :key="opt.value"
                    type="button"
                    @click="form.icon = opt.value"
                    class="p-2.5 rounded-[8px] border flex flex-col items-center justify-center space-y-1 transition-all cursor-pointer group"
                    :class="form.icon === opt.value ? 'bg-white text-black border-white shadow-lg' : 'bg-neutral-900 border-neutral-800 text-neutral-300 hover:border-neutral-600 hover:text-white'"
                    :title="opt.label"
                  >
                    <TechIcon :name="opt.value" class="w-5 h-5 shrink-0" />
                    <span class="text-[9px] font-medium truncate max-w-full leading-none mt-1">{{ opt.label }}</span>
                  </button>

                  <!-- Dynamic Custom Search Fallback Button -->
                  <button
                    v-if="iconSearchQuery && !exactMatchFound"
                    type="button"
                    @click="form.icon = iconSearchQuery.toLowerCase().trim()"
                    class="col-span-full p-3 rounded-[8px] border border-dashed border-neutral-700 bg-neutral-900 hover:bg-neutral-800 text-neutral-200 flex items-center justify-center space-x-2 transition-all cursor-pointer"
                  >
                    <TechIcon :name="iconSearchQuery.toLowerCase().trim()" class="w-5 h-5" />
                    <span class="font-bold text-xs">Use custom icon "{{ iconSearchQuery }}" from library</span>
                  </button>
                </div>
              </div>

              <!-- Custom Icon Link Toggle -->
              <div class="pt-1 border-t border-neutral-800/80">
                <button
                  type="button"
                  @click="useCustomInput = !useCustomInput"
                  class="text-[11px] text-neutral-400 hover:text-white flex items-center space-x-1.5 transition-colors cursor-pointer"
                >
                  <LinkIcon class="h-3 w-3" />
                  <span>{{ useCustomInput ? 'Hide Custom Image Input' : '+ Use Custom Image URL (PNG, SVG)' }}</span>
                </button>

                <div v-if="useCustomInput" class="mt-2 space-y-1 animate-in fade-in-50">
                  <input
                    v-model="form.icon"
                    type="text"
                    placeholder="https://example.com/icon.png"
                    class="w-full h-9 px-3 rounded-[8px] border border-neutral-800 bg-neutral-900 text-white text-xs focus:outline-none focus:border-white"
                  />
                  <p class="text-[10px] text-neutral-400">Paste any direct image URL (PNG, SVG, WebP).</p>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="pt-4 border-t border-neutral-800 flex justify-end gap-2 shrink-0">
                <button 
                  type="button" 
                  @click="closeModal" 
                  class="h-9 px-4 rounded-[8px] border border-neutral-800 bg-neutral-900 text-xs font-semibold text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors cursor-pointer"
                >
                  Cancel
                </button>
                <button 
                  type="submit" 
                  :disabled="form.processing" 
                  class="h-9 px-5 rounded-[8px] bg-white hover:bg-neutral-200 text-black text-xs font-extrabold transition-all shadow-md cursor-pointer disabled:opacity-50"
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
import { ref, computed } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TechIcon from '@/Components/TechIcon.vue';
import { Plus, X, Edit3, Trash2, Search, Link as LinkIcon } from 'lucide-vue-next';
import { useToast } from '@/Composables/useToast';

const props = defineProps({
  skills: Array,
});

const { toast } = useToast();

const pageSearchQuery = ref('');

const availableIcons = [
  { label: 'React.js', value: 'react' },
  { label: 'Next.js', value: 'next' },
  { label: 'Vue.js', value: 'vue' },
  { label: 'Laravel', value: 'laravel' },
  { label: 'Tailwind', value: 'tailwind' },
  { label: 'Bootstrap', value: 'bootstrap' },
  { label: 'TypeScript', value: 'typescript' },
  { label: 'JavaScript', value: 'javascript' },
  { label: 'Inertia.js', value: 'inertia' },
  { label: 'Node.js', value: 'node' },
  { label: 'PHP', value: 'php' },
  { label: 'MySQL', value: 'mysql' },
  { label: 'PostgreSQL', value: 'postgres' },
  { label: 'Redis', value: 'redis' },
  { label: 'MongoDB', value: 'mongodb' },
  { label: 'Docker', value: 'docker' },
  { label: 'Kubernetes', value: 'kubernetes' },
  { label: 'AWS', value: 'aws' },
  { label: 'Git', value: 'git' },
  { label: 'GitHub', value: 'github' },
  { label: 'Vite', value: 'vite' },
  { label: 'Python', value: 'python' },
  { label: 'Flutter', value: 'flutter' },
  { label: 'Go', value: 'go' },
  { label: 'Rust', value: 'rust' },
  { label: 'Java', value: 'java' },
  { label: 'Figma', value: 'figma' },
  { label: 'Firebase', value: 'firebase' },
  { label: 'Supabase', value: 'supabase' },
  { label: 'API / REST', value: 'api' },
];

const isModalOpen = ref(false);
const isEditing = ref(false);
const editingSkillId = ref(null);
const iconSearchQuery = ref('');
const useCustomInput = ref(false);

const form = useForm({
  name: '',
  category: 'Frontend',
  proficiency: 90,
  icon: 'react',
  is_featured: true,
  order: 0,
});

const filteredPageSkills = computed(() => {
  if (!pageSearchQuery.value) return props.skills;
  const q = pageSearchQuery.value.toLowerCase().trim();
  return props.skills.filter(s => 
    s.name.toLowerCase().includes(q) || (s.icon && s.icon.toLowerCase().includes(q))
  );
});

const filteredIcons = computed(() => {
  if (!iconSearchQuery.value) return availableIcons;
  const q = iconSearchQuery.value.toLowerCase().trim();
  return availableIcons.filter(opt => 
    opt.label.toLowerCase().includes(q) || opt.value.toLowerCase().includes(q)
  );
});

const exactMatchFound = computed(() => {
  if (!iconSearchQuery.value) return true;
  const q = iconSearchQuery.value.toLowerCase().trim();
  return availableIcons.some(opt => opt.value.toLowerCase() === q);
});

function openCreateModal() {
  isEditing.value = false;
  editingSkillId.value = null;
  form.reset();
  form.icon = 'react';
  iconSearchQuery.value = '';
  useCustomInput.value = false;
  isModalOpen.value = true;
}

function openEditModal(skill) {
  isEditing.value = true;
  editingSkillId.value = skill.id;
  form.name = skill.name;
  form.category = skill.category || 'Frontend';
  form.proficiency = skill.proficiency || 90;
  form.icon = skill.icon || 'react';
  form.is_featured = !!skill.is_featured;
  form.order = skill.order || 0;
  iconSearchQuery.value = '';
  useCustomInput.value = false;
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
          description: `${form.name} updated successfully.`,
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
          description: `${form.name} created successfully.`,
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
