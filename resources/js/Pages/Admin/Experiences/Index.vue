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

        <Link
          :href="route('admin.experiences.create')"
          class="h-9 px-4 text-xs font-bold rounded-[6px] bg-white hover:bg-neutral-200 text-black transition-all inline-flex items-center justify-center gap-2 shadow-sm shrink-0 cursor-pointer self-start sm:self-auto"
        >
          <Plus class="h-4 w-4" />
          <span>Add Timeline Entry</span>
        </Link>
      </div>

      <!-- Timeline Data Container -->
      <div class="rounded-[10px] border border-neutral-800 bg-neutral-900/40 shadow-sm overflow-hidden">
        
        <!-- Mobile Card List View (< md screens) -->
        <div class="block md:hidden divide-y divide-neutral-800 border-t-0">
          <div 
            v-for="exp in experiences" 
            :key="exp.id"
            :class="[
              activeDropdownId === exp.id ? 'relative z-50 bg-neutral-900/95' : 'hover:bg-neutral-900/40',
              'p-4 space-y-3 transition-colors text-xs'
            ]"
          >
            <!-- Top Row: Role, Organization & Actions -->
            <div class="flex items-start justify-between gap-3">
              <div class="space-y-1 min-w-0 flex-1">
                <h4 class="font-bold text-white text-sm tracking-tight truncate">{{ exp.role }}</h4>
                <div class="flex items-center gap-2 flex-wrap text-xs text-neutral-300 font-semibold">
                  <span class="text-neutral-200">{{ exp.company }}</span>
                  <span class="text-neutral-500">•</span>
                  <span class="text-neutral-400 font-normal text-[11px]">{{ exp.period }}</span>
                </div>
              </div>

              <!-- 3-Dots Actions Menu -->
              <div class="relative shrink-0">
                <button 
                  @click.stop="toggleDropdown(exp.id)"
                  class="h-8 w-8 rounded-[6px] border border-neutral-800 bg-neutral-900/60 hover:bg-neutral-800 text-neutral-400 hover:text-white transition-colors inline-flex items-center justify-center shadow-sm cursor-pointer"
                  title="Actions Menu"
                >
                  <MoreVertical class="h-4 w-4" />
                </button>

                <!-- Dropdown Popover Menu -->
                <div 
                  v-if="activeDropdownId === exp.id"
                  @click.stop
                  class="absolute right-0 mt-2 w-40 rounded-[8px] border border-neutral-800 bg-neutral-950 p-1.5 shadow-2xl z-50 text-left space-y-0.5 divide-y divide-neutral-800/60"
                >
                  <div class="py-0.5 space-y-0.5">
                    <Link 
                      :href="route('admin.experiences.edit', exp.id)"
                      class="w-full flex items-center gap-2 px-3 py-2 text-xs font-medium text-neutral-200 hover:bg-neutral-900 rounded-[6px] transition-colors cursor-pointer"
                    >
                      <Edit2 class="h-3.5 w-3.5 text-neutral-400" />
                      <span>Edit Entry</span>
                    </Link>
                  </div>

                  <div class="pt-1">
                    <button 
                      @click="openDeleteModal(exp); activeDropdownId = null;"
                      class="w-full flex items-center gap-2 px-3 py-2 text-xs font-medium text-rose-400 hover:bg-rose-950/30 rounded-[6px] transition-colors cursor-pointer"
                    >
                      <Trash2 class="h-3.5 w-3.5" />
                      <span>Delete Entry</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Type Badge & Description -->
            <div class="flex items-center gap-2 pt-0.5">
              <span 
                class="px-2 py-0.5 rounded-[4px] text-[10px] font-semibold uppercase tracking-wider border"
                :class="exp.type === 'work' ? 'bg-neutral-800 text-neutral-200 border-neutral-700' : 'bg-neutral-900 text-neutral-400 border-neutral-800'"
              >
                {{ exp.type }}
              </span>
            </div>

            <div 
              v-if="exp.description" 
              class="text-xs text-neutral-400 leading-relaxed line-clamp-3 prose dark:prose-invert pt-1 border-t border-neutral-800/40"
              v-html="exp.description"
            ></div>
          </div>

          <div v-if="!experiences || !experiences.length" class="py-12 text-center text-neutral-400 text-sm">
            No timeline entries found.
          </div>
        </div>

        <!-- Desktop Table Container (>= md screens) -->
        <div class="hidden md:block overflow-x-auto overflow-y-visible">
          <table class="w-full text-left min-w-[700px]">
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
                <td class="py-4 px-6 align-middle">
                  <h4 class="font-bold text-white text-sm group-hover:text-neutral-100 transition-colors">{{ exp.role }}</h4>
                  <div class="text-xs sm:text-sm text-neutral-400 leading-relaxed line-clamp-2 max-w-2xl mt-1.5 prose dark:prose-invert" v-html="exp.description"></div>
                </td>
                <td class="py-4 px-4 font-semibold text-neutral-200 text-sm align-middle">{{ exp.company }}</td>
                <td class="py-4 px-4 font-sans text-neutral-400 text-xs whitespace-nowrap align-middle">{{ exp.period }}</td>
                <td class="py-5 px-4 align-middle">
                  <span 
                    class="px-2.5 py-1 rounded-[6px] text-xs font-semibold border uppercase tracking-wider whitespace-nowrap"
                    :class="exp.type === 'work' ? 'bg-neutral-800 text-neutral-200 border-neutral-700' : 'bg-neutral-900 text-neutral-400 border-neutral-800'"
                  >
                    {{ exp.type }}
                  </span>
                </td>
                <td class="py-5 px-6 text-right relative align-middle">
                  <div class="inline-block text-left relative">
                    <button 
                      @click.stop="toggleDropdown(exp.id)"
                      class="h-8 w-8 rounded-[6px] border border-neutral-800 bg-neutral-900/60 hover:bg-neutral-800 text-neutral-400 hover:text-white transition-colors inline-flex items-center justify-center shadow-sm cursor-pointer"
                      title="Actions Menu"
                    >
                      <MoreVertical class="h-4 w-4" />
                    </button>

                    <!-- Dropdown Popover Menu -->
                    <div 
                      v-if="activeDropdownId === exp.id"
                      @click.stop
                      class="absolute right-0 mt-2 w-40 rounded-[8px] border border-neutral-800 bg-neutral-950 p-1.5 shadow-2xl z-50 text-left space-y-0.5 divide-y divide-neutral-800/60"
                    >
                      <div class="py-0.5 space-y-0.5">
                        <Link 
                          :href="route('admin.experiences.edit', exp.id)"
                          class="w-full flex items-center gap-2 px-3 py-2 text-xs font-medium text-neutral-200 hover:bg-neutral-900 rounded-[6px] transition-colors cursor-pointer"
                        >
                          <Edit2 class="h-3.5 w-3.5 text-neutral-400" />
                          <span>Edit Entry</span>
                        </Link>
                      </div>

                      <div class="pt-1">
                        <button 
                          @click="openDeleteModal(exp); activeDropdownId = null;"
                          class="w-full flex items-center gap-2 px-3 py-2 text-xs font-medium text-rose-400 hover:bg-rose-950/30 rounded-[6px] transition-colors cursor-pointer"
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
      </div>

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
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteConfirmModal from '@/Components/DeleteConfirmModal.vue';
import { Plus, MoreVertical, Edit2, Trash2 } from 'lucide-vue-next';
import { useToast } from '@/Composables/useToast';

const props = defineProps({
  experiences: Array,
});

const { toast } = useToast();

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
</script>
