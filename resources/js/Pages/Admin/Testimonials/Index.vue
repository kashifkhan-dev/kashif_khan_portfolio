<template>
  <AuthenticatedLayout>
    <template #header>Client Testimonials</template>
    <Head title="Client Testimonials & Endorsements - Admin" />

    <div class="space-y-6">
      <!-- Top Action Bar -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-neutral-200 dark:border-neutral-800 pb-5">
        <div>
          <h1 class="text-2xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-50 flex items-center gap-3">
            <Quote class="h-6 w-6 text-indigo-500" />
            <span>Client Testimonials &amp; Endorsements</span>
            <span class="px-2.5 py-0.5 rounded-[6px] text-xs font-semibold bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-700">
              {{ activeCount }} Active &bull; {{ testimonials.length }} Total
            </span>
          </h1>
          <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
            Curate executive recommendations, client quotes, and LinkedIn endorsements displayed in your portfolio slider.
          </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
          <button
            type="button"
            @click="openCreateModal"
            class="h-9 px-4 rounded-[6px] bg-neutral-900 text-neutral-50 dark:bg-neutral-50 dark:text-neutral-900 text-xs font-bold hover:opacity-90 transition-all shadow-md flex items-center gap-2 cursor-pointer"
          >
            <Plus class="h-3.5 w-3.5" />
            <span>Add Endorsement</span>
          </button>
        </div>
      </div>

      <!-- Testimonial Cards Grid -->
      <div v-if="!testimonials.length" class="py-16 text-center rounded-[8px] border border-dashed border-neutral-300 dark:border-neutral-800 p-8 space-y-3">
        <Quote class="h-10 w-10 text-neutral-400 dark:text-neutral-600 mx-auto" />
        <h3 class="text-sm font-bold text-neutral-800 dark:text-neutral-200">No testimonials yet</h3>
        <p class="text-xs text-neutral-500 max-w-sm mx-auto">
          Add recommendations from past clients, founders, and engineering leaders to showcase social proof.
        </p>
        <button
          type="button"
          @click="openCreateModal"
          class="inline-flex items-center gap-1.5 px-4 py-2 rounded-[6px] bg-neutral-900 text-white dark:bg-white dark:text-black text-xs font-bold shadow hover:opacity-90 transition-all mt-2 cursor-pointer"
        >
          <Plus class="h-3.5 w-3.5" />
          <span>Add First Testimonial</span>
        </button>
      </div>

      <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div
          v-for="item in testimonials"
          :key="item.id"
          class="rounded-[8px] border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 p-5 space-y-4 shadow-xs hover:border-neutral-300 dark:hover:border-neutral-700 transition-all flex flex-col justify-between"
        >
          <!-- Top Row: Client Info & Status Badge -->
          <div class="space-y-3">
            <div class="flex items-start justify-between gap-3">
              <!-- Avatar & Bio -->
              <div class="flex items-center gap-3 min-w-0">
                <div class="w-12 h-12 rounded-[6px] overflow-hidden border border-neutral-200 dark:border-neutral-800 bg-neutral-100 dark:bg-neutral-900 shrink-0">
                  <img
                    v-if="item.client_avatar"
                    :src="item.client_avatar"
                    :alt="item.client_name"
                    class="w-full h-full object-cover"
                  />
                  <div v-else class="w-full h-full flex items-center justify-center font-bold text-xs bg-indigo-500 text-white">
                    {{ getInitials(item.client_name) }}
                  </div>
                </div>

                <div class="min-w-0 flex-1">
                  <div class="flex items-center gap-2">
                    <h3 class="text-sm font-bold text-neutral-900 dark:text-neutral-100 truncate">
                      {{ item.client_name }}
                    </h3>
                    <a
                      v-if="item.linkedin_url"
                      :href="item.linkedin_url"
                      target="_blank"
                      class="text-neutral-400 hover:text-blue-500 transition-colors"
                      title="View LinkedIn Profile"
                    >
                      <Linkedin class="h-3.5 w-3.5" />
                    </a>
                  </div>
                  <p class="text-xs text-neutral-500 dark:text-neutral-400 truncate">
                    {{ item.client_role || 'Client' }}
                    <span v-if="item.company" class="font-medium text-neutral-700 dark:text-neutral-300">
                      &bull; {{ item.company }}
                    </span>
                  </p>
                </div>
              </div>

              <!-- Active Status Switch -->
              <button
                @click="toggleActive(item)"
                class="px-2.5 py-1 rounded-[4px] text-[11px] font-bold border transition-colors cursor-pointer shrink-0"
                :class="item.is_active 
                  ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800' 
                  : 'bg-neutral-100 text-neutral-500 dark:bg-neutral-900 dark:text-neutral-500 border-neutral-200 dark:border-neutral-800'"
              >
                {{ item.is_active ? 'Active' : 'Hidden' }}
              </button>
            </div>

            <!-- Star Rating & Project Tag -->
            <div class="flex items-center justify-between gap-2 pt-1 border-t border-neutral-100 dark:border-neutral-900">
              <!-- Stars -->
              <div class="flex items-center gap-1 text-amber-400">
                <Star
                  v-for="s in 5"
                  :key="s"
                  class="h-3.5 w-3.5"
                  :class="s <= (item.rating || 5) ? 'fill-amber-400 text-amber-400' : 'text-neutral-300 dark:text-neutral-700'"
                />
              </div>

              <!-- Project Reference -->
              <span
                v-if="item.project_reference"
                class="px-2 py-0.5 rounded-[4px] text-[10px] font-medium bg-neutral-100 text-neutral-600 dark:bg-neutral-900 dark:text-neutral-400 border border-neutral-200 dark:border-neutral-800 truncate max-w-[200px]"
              >
                Project: {{ item.project_reference }}
              </span>
            </div>

            <!-- Quote Body -->
            <div class="relative pl-3 border-l-2 border-indigo-500/60 dark:border-indigo-500/40 my-2">
              <p class="text-xs text-neutral-700 dark:text-neutral-300 italic leading-relaxed">
                &ldquo;{{ item.quote }}&rdquo;
              </p>
            </div>
          </div>

          <!-- Bottom Action Buttons -->
          <div class="flex items-center justify-between pt-3 border-t border-neutral-100 dark:border-neutral-900 text-xs">
            <span class="text-[11px] text-neutral-400">
              Order: #{{ item.order || 0 }}
            </span>

            <div class="flex items-center gap-2">
              <button
                @click="openEditModal(item)"
                class="px-2.5 py-1 rounded-[6px] border border-neutral-200 dark:border-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-900 transition-colors flex items-center gap-1 cursor-pointer"
              >
                <Edit3 class="h-3.5 w-3.5" />
                <span>Edit</span>
              </button>

              <button
                @click="openDeleteModal(item)"
                class="p-1.5 rounded-[6px] border border-red-200 dark:border-red-900/40 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/40 transition-colors cursor-pointer"
                title="Delete Testimonial"
              >
                <Trash2 class="h-3.5 w-3.5" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Create / Edit Modal -->
    <div
      v-if="isModalOpen"
      class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs"
    >
      <div class="relative w-full max-w-xl rounded-[8px] border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 shadow-2xl p-6 space-y-5 max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800 pb-3">
          <div class="flex items-center gap-2">
            <Quote class="h-5 w-5 text-indigo-500" />
            <h2 class="text-base font-bold text-neutral-900 dark:text-neutral-50">
              {{ isEditing ? 'Edit Client Testimonial' : 'Add Client Recommendation' }}
            </h2>
          </div>
          <button
            @click="closeModal"
            class="text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-200 text-lg leading-none cursor-pointer"
          >
            &times;
          </button>
        </div>

        <form @submit.prevent="submitModalForm" class="space-y-4">
          <!-- Client Name & Role -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="space-y-1">
              <label class="block text-xs font-bold text-neutral-800 dark:text-neutral-200">
                Client / Leader Name <span class="text-red-500">*</span>
              </label>
              <input
                v-model="form.client_name"
                type="text"
                placeholder="e.g., Sarah Jenkins"
                class="w-full h-9 px-3 rounded-[6px] border border-neutral-200 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/60 text-xs text-neutral-900 dark:text-neutral-50 focus:outline-none focus:border-neutral-600 dark:focus:border-neutral-500"
                :class="{ 'border-red-500': form.errors.client_name }"
              />
              <p v-if="form.errors.client_name" class="text-xs text-red-500">{{ form.errors.client_name }}</p>
            </div>

            <div class="space-y-1">
              <label class="block text-xs font-bold text-neutral-800 dark:text-neutral-200">
                Role / Title
              </label>
              <input
                v-model="form.client_role"
                type="text"
                placeholder="e.g., VP of Engineering"
                class="w-full h-9 px-3 rounded-[6px] border border-neutral-200 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/60 text-xs text-neutral-900 dark:text-neutral-50 focus:outline-none focus:border-neutral-600 dark:focus:border-neutral-500"
              />
            </div>
          </div>

          <!-- Company & Project Reference -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="space-y-1">
              <label class="block text-xs font-bold text-neutral-800 dark:text-neutral-200">
                Company / Organization
              </label>
              <input
                v-model="form.company"
                type="text"
                placeholder="e.g., CloudScale Networks"
                class="w-full h-9 px-3 rounded-[6px] border border-neutral-200 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/60 text-xs text-neutral-900 dark:text-neutral-50 focus:outline-none focus:border-neutral-600 dark:focus:border-neutral-500"
              />
            </div>

            <div class="space-y-1">
              <label class="block text-xs font-bold text-neutral-800 dark:text-neutral-200">
                Project Reference
              </label>
              <input
                v-model="form.project_reference"
                type="text"
                placeholder="e.g., Nexus SaaS Dashboard"
                class="w-full h-9 px-3 rounded-[6px] border border-neutral-200 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/60 text-xs text-neutral-900 dark:text-neutral-50 focus:outline-none focus:border-neutral-600 dark:focus:border-neutral-500"
              />
            </div>
          </div>

          <!-- Star Rating & LinkedIn URL -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="space-y-1">
              <label class="block text-xs font-bold text-neutral-800 dark:text-neutral-200">
                Star Rating
              </label>
              <div class="flex items-center gap-1.5 h-9">
                <button
                  v-for="star in 5"
                  :key="star"
                  type="button"
                  @click="form.rating = star"
                  class="p-1 hover:scale-110 transition-transform cursor-pointer"
                >
                  <Star
                    class="h-5 w-5"
                    :class="star <= form.rating ? 'fill-amber-400 text-amber-400' : 'text-neutral-300 dark:text-neutral-700'"
                  />
                </button>
                <span class="text-xs font-bold ml-2 text-neutral-700 dark:text-neutral-300">{{ form.rating }} / 5</span>
              </div>
            </div>

            <div class="space-y-1">
              <label class="block text-xs font-bold text-neutral-800 dark:text-neutral-200">
                LinkedIn Profile URL
              </label>
              <input
                v-model="form.linkedin_url"
                type="text"
                placeholder="https://linkedin.com/in/..."
                class="w-full h-9 px-3 rounded-[6px] border border-neutral-200 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/60 text-xs text-neutral-900 dark:text-neutral-50 focus:outline-none focus:border-neutral-600 dark:focus:border-neutral-500"
              />
            </div>
          </div>

          <!-- Client Avatar / Photo -->
          <div class="space-y-1.5">
            <label class="block text-xs font-bold text-neutral-800 dark:text-neutral-200">
              Client Avatar (Photo URL or Upload)
            </label>
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-[6px] overflow-hidden border border-neutral-200 dark:border-neutral-800 bg-neutral-100 dark:bg-neutral-900 shrink-0">
                <img
                  v-if="modalAvatarPreview"
                  :src="modalAvatarPreview"
                  class="w-full h-full object-cover"
                />
                <div v-else class="w-full h-full flex items-center justify-center text-xs font-bold bg-neutral-800 text-white">
                  ?
                </div>
              </div>

              <input
                v-model="form.client_avatar"
                type="text"
                placeholder="Image URL: https://images.unsplash.com/..."
                class="flex-1 h-9 px-3 rounded-[6px] border border-neutral-200 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/60 text-xs text-neutral-900 dark:text-neutral-50 focus:outline-none focus:border-neutral-600 dark:focus:border-neutral-500"
              />

              <input
                type="file"
                accept="image/*"
                @change="handleAvatarUpload"
                class="hidden"
                ref="avatarFileInput"
              />
              <button
                type="button"
                @click="$refs.avatarFileInput.click()"
                class="h-9 px-3 rounded-[6px] border border-neutral-200 dark:border-neutral-800 bg-neutral-100 dark:bg-neutral-800 text-xs font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-700 transition-colors shrink-0 cursor-pointer"
              >
                Upload File
              </button>
            </div>
          </div>

          <!-- Endorsement Quote -->
          <div class="space-y-1.5">
            <label class="block text-xs font-bold text-neutral-800 dark:text-neutral-200">
              Recommendation Quote <span class="text-red-500">*</span>
            </label>
            <textarea
              v-model="form.quote"
              rows="4"
              placeholder="What did the client or executive say about your engineering delivery, technical ownership, communication, or speed?"
              class="w-full p-3 rounded-[6px] border border-neutral-200 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/60 text-xs text-neutral-900 dark:text-neutral-50 focus:outline-none focus:border-neutral-600 dark:focus:border-neutral-500"
              :class="{ 'border-red-500': form.errors.quote }"
            ></textarea>
            <p v-if="form.errors.quote" class="text-xs text-red-500">{{ form.errors.quote }}</p>
          </div>

          <!-- Order & Active Checkbox -->
          <div class="flex items-center justify-between pt-2 border-t border-neutral-100 dark:border-neutral-900">
            <div class="flex items-center gap-2">
              <label class="text-xs font-bold text-neutral-800 dark:text-neutral-200">Display Order:</label>
              <input
                v-model.number="form.order"
                type="number"
                min="0"
                class="w-16 h-8 px-2 rounded-[6px] border border-neutral-200 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/60 text-xs text-neutral-900 dark:text-neutral-50 text-center"
              />
            </div>

            <label class="flex items-center gap-2.5 cursor-pointer select-none">
              <input
                v-model="form.is_active"
                type="checkbox"
                class="h-5 w-5 rounded-[4px] border-2 border-neutral-400 dark:border-neutral-500 bg-white dark:bg-neutral-900 text-blue-600 dark:text-blue-500 checked:bg-blue-600 dark:checked:bg-blue-500 checked:border-blue-600 dark:checked:border-blue-500 focus:ring-0 focus:ring-offset-0 cursor-pointer transition-all shadow-xs shrink-0"
              />
              <span class="text-xs font-bold text-neutral-800 dark:text-neutral-200">Active (Visible in Carousel)</span>
            </label>
          </div>

          <!-- Modal Actions -->
          <div class="flex items-center justify-end gap-3 pt-3 border-t border-neutral-200 dark:border-neutral-800">
            <button
              type="button"
              @click="closeModal"
              class="h-9 px-4 rounded-[6px] border border-neutral-200 dark:border-neutral-800 text-xs font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-900 transition-colors cursor-pointer"
            >
              Cancel
            </button>
            <button
              type="submit"
              :disabled="form.processing"
              class="h-9 px-5 rounded-[6px] bg-neutral-900 text-neutral-50 dark:bg-neutral-50 dark:text-neutral-900 text-xs font-bold hover:opacity-90 transition-all shadow flex items-center gap-2 cursor-pointer disabled:opacity-50"
            >
              <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
              <Save v-else class="h-4 w-4" />
              <span>{{ isEditing ? 'Save Changes' : 'Add Testimonial' }}</span>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <DeleteConfirmModal
      :isOpen="isDeleteModalOpen"
      title="Delete Client Testimonial"
      :message="`Are you sure you want to delete the recommendation from '${testimonialToDelete?.client_name}'?`"
      :isLoading="isDeleting"
      @close="isDeleteModalOpen = false"
      @confirm="confirmDelete"
    />
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteConfirmModal from '@/Components/DeleteConfirmModal.vue';
import {
  Quote,
  Plus,
  Star,
  Edit3,
  Trash2,
  Linkedin,
  Save,
  Loader2,
} from 'lucide-vue-next';

const props = defineProps({
  testimonials: {
    type: Array,
    default: () => [],
  },
});

const activeCount = computed(() => {
  return props.testimonials.filter(t => t.is_active).length;
});

// Modal state
const isModalOpen = ref(false);
const isEditing = ref(false);
const editingId = ref(null);
const localAvatarPreview = ref(null);

const form = useForm({
  client_name: '',
  client_role: '',
  company: '',
  company_logo: '',
  client_avatar: '',
  avatar_file: null,
  linkedin_url: '',
  quote: '',
  rating: 5,
  project_reference: '',
  order: 0,
  is_active: true,
});

const modalAvatarPreview = computed(() => {
  if (localAvatarPreview.value) return localAvatarPreview.value;
  if (form.client_avatar) return form.client_avatar;
  return null;
});

function handleAvatarUpload(e) {
  const file = e.target.files[0];
  if (!file) return;
  form.avatar_file = file;
  localAvatarPreview.value = URL.createObjectURL(file);
}

function openCreateModal() {
  isEditing.value = false;
  editingId.value = null;
  localAvatarPreview.value = null;
  form.reset();
  form.clearErrors();
  form.rating = 5;
  form.is_active = true;
  form.order = props.testimonials.length + 1;
  isModalOpen.value = true;
}

function openEditModal(item) {
  isEditing.value = true;
  editingId.value = item.id;
  localAvatarPreview.value = null;
  form.clearErrors();
  form.client_name = item.client_name || '';
  form.client_role = item.client_role || '';
  form.company = item.company || '';
  form.company_logo = item.company_logo || '';
  form.client_avatar = item.client_avatar || '';
  form.avatar_file = null;
  form.linkedin_url = item.linkedin_url || '';
  form.quote = item.quote || '';
  form.rating = item.rating || 5;
  form.project_reference = item.project_reference || '';
  form.order = item.order || 0;
  form.is_active = Boolean(item.is_active);
  isModalOpen.value = true;
}

function closeModal() {
  isModalOpen.value = false;
  form.reset();
}

function submitModalForm() {
  if (isEditing.value) {
    form.transform((data) => ({
      ...data,
      _method: 'put',
    })).post(route('admin.testimonials.update', editingId.value), {
      preserveScroll: true,
      onSuccess: () => closeModal(),
    });
  } else {
    form.post(route('admin.testimonials.store'), {
      preserveScroll: true,
      onSuccess: () => closeModal(),
    });
  }
}

function toggleActive(item) {
  router.patch(route('admin.testimonials.toggle-active', item.id), {}, {
    preserveScroll: true,
  });
}

function getInitials(name) {
  if (!name) return 'CL';
  const parts = name.trim().split(/\s+/);
  if (parts.length >= 2) {
    return `${parts[0][0]}${parts[1][0]}`.toUpperCase();
  }
  return name.substring(0, 2).toUpperCase();
}

// Delete modal state
const isDeleteModalOpen = ref(false);
const testimonialToDelete = ref(null);
const isDeleting = ref(false);

function openDeleteModal(item) {
  testimonialToDelete.value = item;
  isDeleteModalOpen.value = true;
}

function confirmDelete() {
  if (!testimonialToDelete.value) return;
  isDeleting.value = true;
  router.delete(route('admin.testimonials.destroy', testimonialToDelete.value.id), {
    preserveScroll: true,
    onSuccess: () => {
      isDeleting.value = false;
      isDeleteModalOpen.value = false;
      testimonialToDelete.value = null;
    },
    onError: () => {
      isDeleting.value = false;
    },
  });
}
</script>
