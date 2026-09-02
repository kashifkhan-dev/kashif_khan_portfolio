<template>
  <AuthenticatedLayout>
    <template #header>Experience &amp; Education Timeline</template>
    <Head title="Timeline Manager - Admin" />

    <div class="space-y-8">
      <!-- Page Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-800 pb-6">
        <div>
          <h1 class="text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-50">
            Experience Timeline
          </h1>
          <p class="text-sm text-muted-foreground mt-1">Manage employment career timeline and education history.</p>
        </div>

        <button
          @click="openCreateModal"
          class="h-9 px-4 text-xs font-bold rounded-[8px] bg-white hover:bg-neutral-200 text-black transition-all flex items-center gap-2 shadow-sm shrink-0 cursor-pointer"
        >
          <Plus class="h-4 w-4" />
          <span>Add Timeline Entry</span>
        </button>
      </div>

      <!-- Timeline Data Table -->
      <div class="rounded-[8px] border border-neutral-800 bg-neutral-900/40 shadow-sm">
        <table class="w-full text-left">
          <thead class="bg-neutral-900/80 border-b border-neutral-800 text-neutral-400 uppercase text-xs font-bold tracking-wider select-none">
            <tr>
              <th class="py-4 px-6">Role / Degree</th>
              <th class="py-4 px-4">Organization</th>
              <th class="py-4 px-4">Period</th>
              <th class="py-4 px-4">Type</th>
              <th class="py-4 px-6 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-neutral-800/80 text-xs">
            <tr v-for="exp in experiences" :key="exp.id" class="hover:bg-neutral-900/60 transition-colors group">
              <td class="py-4.5 px-6">
                <h4 class="font-bold text-white text-sm group-hover:text-neutral-100 transition-colors">{{ exp.role }}</h4>
                <p class="text-sm text-neutral-400 leading-relaxed line-clamp-2 max-w-2xl mt-1.5">{{ exp.description }}</p>
              </td>
              <td class="py-4.5 px-4 font-semibold text-neutral-200 text-sm">{{ exp.company }}</td>
              <td class="py-4.5 px-4 font-mono text-neutral-400 text-xs whitespace-nowrap">{{ exp.period }}</td>
              <td class="py-4.5 px-4">
                <span 
                  class="px-2.5 py-1 rounded-[8px] text-xs font-semibold border uppercase tracking-wider whitespace-nowrap"
                  :class="exp.type === 'work' ? 'bg-neutral-800 text-neutral-200 border-neutral-700' : 'bg-neutral-900 text-neutral-400 border-neutral-800'"
                >
                  {{ exp.type }}
                </span>
              </td>
              <td class="py-4.5 px-6 text-right relative">
                <div class="inline-block text-left relative">
                  <button 
                    @click.stop="toggleDropdown(exp.id)"
                    class="h-8 w-8 rounded-lg border border-neutral-800 bg-neutral-900/60 hover:bg-neutral-800 text-neutral-400 hover:text-white transition-colors inline-flex items-center justify-center shadow-sm cursor-pointer"
                    title="Actions Menu"
                  >
                    <MoreVertical class="h-4 w-4" />
                  </button>

                  <!-- Dropdown Popover Menu -->
                  <div 
                    v-if="activeDropdownId === exp.id"
                    @click.stop
                    class="absolute right-0 mt-2 w-40 rounded-xl border border-neutral-800 bg-neutral-950 p-1.5 shadow-2xl z-50 text-left space-y-0.5 divide-y divide-neutral-800/60"
                  >
                    <div class="py-0.5 space-y-0.5">
                      <button 
                        @click="openEditModal(exp); activeDropdownId = null;"
                        class="w-full flex items-center gap-2 px-3 py-2 text-xs font-medium text-neutral-200 hover:bg-neutral-900 rounded-lg transition-colors cursor-pointer"
                      >
                        <Edit2 class="h-3.5 w-3.5 text-neutral-400" />
                        <span>Edit Entry</span>
                      </button>
                    </div>

                    <div class="pt-1">
                      <button 
                        @click="openDeleteModal(exp); activeDropdownId = null;"
                        class="w-full flex items-center gap-2 px-3 py-2 text-xs font-medium text-rose-400 hover:bg-rose-950/30 rounded-lg transition-colors cursor-pointer"
                      >
                        <Trash2 class="h-3.5 w-3.5" />
                        <span>Delete Entry</span>
                      </button>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <tr v-if="!experiences || !experiences.length">
              <td colspan="5" class="py-12 text-center text-neutral-400 text-sm">
                No timeline entries found.
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- MODAL DIALOG -->
      <teleport to="body">
        <div v-if="isModalOpen" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/80 backdrop-blur-md animate-in fade-in-50">
          <div class="rounded-[8px] border border-neutral-800 bg-neutral-950 text-neutral-50 shadow-2xl p-6 max-w-xl w-full space-y-6 relative max-h-[90vh] flex flex-col overflow-hidden">
            <!-- Close Button -->
            <button @click="closeModal" class="absolute top-4 right-4 text-neutral-400 hover:text-white p-1.5 rounded-[8px] hover:bg-neutral-900 transition-colors z-10">
              <X class="h-4 w-4" />
            </button>
            
            <div class="shrink-0">
              <h3 class="text-lg font-bold text-white">{{ isEditing ? 'Edit Entry' : 'Add Timeline Entry' }}</h3>
              <p class="text-xs text-neutral-400 mt-0.5">Fill in career or education timeline details below.</p>
            </div>

            <form @submit.prevent="submitForm" class="space-y-4 text-xs flex-1 overflow-y-auto pr-1">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                  <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">Company / Institution</label>
                  <input 
                    v-model="form.company" 
                    type="text" 
                    required 
                    placeholder="e.g. Apex Cloud Systems"
                    class="w-full h-9 px-3 rounded-[8px] border border-neutral-800 bg-neutral-900 text-white text-xs focus:ring-1 focus:ring-white focus:border-white outline-none transition-colors" 
                  />
                </div>
                <div class="space-y-1.5">
                  <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">Role / Degree Title</label>
                  <input 
                    v-model="form.role" 
                    type="text" 
                    required 
                    placeholder="e.g. Lead Full-Stack Engineer"
                    class="w-full h-9 px-3 rounded-[8px] border border-neutral-800 bg-neutral-900 text-white text-xs focus:ring-1 focus:ring-white focus:border-white outline-none transition-colors" 
                  />
                </div>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="space-y-1.5">
                  <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">Period</label>
                  <input 
                    v-model="form.period" 
                    type="text" 
                    required 
                    placeholder="e.g. 2024 - Present"
                    class="w-full h-9 px-3 rounded-[8px] border border-neutral-800 bg-neutral-900 text-white text-xs focus:ring-1 focus:ring-white focus:border-white outline-none transition-colors" 
                  />
                </div>
                <div class="space-y-1.5">
                  <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">Location</label>
                  <input 
                    v-model="form.location" 
                    type="text" 
                    placeholder="e.g. San Francisco, CA"
                    class="w-full h-9 px-3 rounded-[8px] border border-neutral-800 bg-neutral-900 text-white text-xs focus:ring-1 focus:ring-white focus:border-white outline-none transition-colors" 
                  />
                </div>
                <div class="space-y-1.5">
                  <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">Type</label>
                  <select 
                    v-model="form.type" 
                    class="w-full h-9 px-3 rounded-[8px] border border-neutral-800 bg-neutral-900 text-white text-xs focus:ring-1 focus:ring-white focus:border-white outline-none transition-colors"
                  >
                    <option value="work">Work Experience</option>
                    <option value="education">Education</option>
                  </select>
                </div>
              </div>

              <div class="space-y-1.5">
                <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">Description Paragraph</label>
                <textarea 
                  v-model="form.description" 
                  rows="3" 
                  placeholder="Architected enterprise solutions..."
                  class="w-full p-3 rounded-[8px] border border-neutral-800 bg-neutral-900 text-white text-xs focus:ring-1 focus:ring-white focus:border-white outline-none transition-colors"
                ></textarea>
              </div>

              <div class="space-y-1.5">
                <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">Key Highlights (comma separated)</label>
                <input 
                  v-model="highlightsInput" 
                  type="text" 
                  placeholder="Led team of 5, Improved query speed by 40%" 
                  class="w-full h-9 px-3 rounded-[8px] border border-neutral-800 bg-neutral-900 text-white text-xs focus:ring-1 focus:ring-white focus:border-white outline-none transition-colors" 
                />
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
                  {{ isEditing ? 'Save Changes' : 'Create Entry' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </teleport>

      <!-- Reusable Executive Delete Confirmation Modal -->
      <DeleteConfirmModal
        :is-open="isDeleteModalOpen"
        title="Delete Timeline Entry"
        :item-title="expToDelete?.role || ''"
        :loading="isDeleting"
        @close="isDeleteModalOpen = false"
        @confirm="confirmDelete"
      />
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteConfirmModal from '@/Components/DeleteConfirmModal.vue';
import { Plus, X, MoreVertical, Edit2, Trash2 } from 'lucide-vue-next';
import { useToast } from '@/Composables/useToast';

const props = defineProps({
  experiences: Array,
});

const { toast } = useToast();

const isModalOpen = ref(false);
const isEditing = ref(false);
const editingExpId = ref(null);
const highlightsInput = ref('');
const activeDropdownId = ref(null);

// Delete Modal State
const isDeleteModalOpen = ref(false);
const expToDelete = ref(null);
const isDeleting = ref(false);

function openDeleteModal(exp) {
  expToDelete.value = exp;
  isDeleteModalOpen.value = true;
}

function confirmDelete() {
  if (!expToDelete.value) return;
  isDeleting.value = true;
  router.delete(route('admin.experiences.destroy', expToDelete.value.id), {
    onSuccess: () => {
      isDeleting.value = false;
      isDeleteModalOpen.value = false;
      toast({
        title: 'Entry Deleted',
        description: `Record "${expToDelete.value?.role || 'Entry'}" removed.`,
        type: 'error'
      });
      expToDelete.value = null;
    },
    onError: () => {
      isDeleting.value = false;
    }
  });
}

function toggleDropdown(id) {
  activeDropdownId.value = activeDropdownId.value === id ? null : id;
}

function closeDropdownOnOutsideClick() {
  if (activeDropdownId.value !== null) {
    activeDropdownId.value = null;
  }
}

onMounted(() => {
  window.addEventListener('click', closeDropdownOnOutsideClick);
});

onUnmounted(() => {
  window.removeEventListener('click', closeDropdownOnOutsideClick);
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
        toast({ title: 'Entry Updated', description: `${form.role} updated successfully.`, type: 'success' });
      },
    });
  } else {
    form.post(route('admin.experiences.store'), {
      onSuccess: () => {
        closeModal();
        toast({ title: 'Entry Created', description: `${form.role} created successfully.`, type: 'success' });
      },
    });
  }
}
</script>
