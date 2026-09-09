<template>
  <AuthenticatedLayout>
    <template #header>Client Testimonials</template>
    <Head title="Client Testimonials & Endorsements - Admin" />

    <div class="space-y-6">
      <!-- Top Action Bar -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-neutral-800 pb-5">
        <div>
          <h1 class="text-2xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-50 flex items-center gap-3">
            <Quote class="h-6 w-6 text-indigo-500" />
            <span>Client Testimonials &amp; Endorsements</span>
            <span class="px-2.5 py-0.5 rounded-[6px] text-xs font-semibold bg-white text-slate-700 dark:bg-neutral-900 dark:text-neutral-300 border border-slate-200 dark:border-neutral-800 shadow-2xs">
              {{ activeCount }} Active &bull; {{ testimonials.length }} Total
            </span>
          </h1>
          <p class="text-xs text-slate-500 dark:text-neutral-400 mt-1">
            Curate executive recommendations, client quotes, and LinkedIn endorsements displayed in your portfolio slider.
          </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
          <button
            type="button"
            @click="openCreateModal"
            class="h-9 px-4 rounded-[6px] bg-slate-900 text-white dark:bg-neutral-50 dark:text-neutral-900 text-xs font-bold hover:bg-slate-800 transition-all shadow-md flex items-center gap-2 cursor-pointer"
          >
            <Plus class="h-3.5 w-3.5" />
            <span>Add Endorsement</span>
          </button>
        </div>
      </div>

      <!-- Testimonial Cards Grid -->
      <div v-if="!testimonials.length" class="py-16 text-center rounded-[6px] border border-dashed border-slate-300 dark:border-neutral-800 p-8 space-y-3 bg-white dark:bg-card">
        <Quote class="h-10 w-10 text-slate-400 dark:text-neutral-600 mx-auto" />
        <h3 class="text-sm font-bold text-slate-800 dark:text-neutral-200">No testimonials yet</h3>
        <p class="text-xs text-slate-500 max-w-sm mx-auto">
          Add recommendations from past clients, founders, and engineering leaders to showcase social proof.
        </p>
        <button
          type="button"
          @click="openCreateModal"
          class="inline-flex items-center gap-1.5 px-4 py-2 rounded-[6px] bg-slate-900 text-white dark:bg-white dark:text-black text-xs font-bold shadow hover:bg-slate-800 transition-all mt-2 cursor-pointer"
        >
          <Plus class="h-3.5 w-3.5" />
          <span>Add First Testimonial</span>
        </button>
      </div>

      <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div
          v-for="item in testimonials"
          :key="item.id"
          class="rounded-[6px] border border-slate-200 dark:border-neutral-800 bg-white dark:bg-card p-6 shadow-xs hover:border-slate-300 dark:hover:border-neutral-700 hover:shadow-md transition-all flex flex-col justify-between group relative space-y-4"
        >
          <div class="space-y-3.5">
            <!-- Top Row: Client Info & Active Status -->
            <div class="flex items-start justify-between gap-3">
              <div class="flex items-center gap-3.5 min-w-0">
                <div class="w-11 h-11 rounded-full overflow-hidden border border-slate-200 dark:border-neutral-700 bg-white shrink-0 shadow-2xs">
                  <img
                    v-if="item.client_avatar"
                    :src="item.client_avatar"
                    :alt="item.client_name"
                    class="w-full h-full object-cover"
                  />
                  <div v-else class="w-full h-full flex items-center justify-center font-bold text-xs bg-slate-900 text-white dark:bg-white dark:text-slate-900">
                    {{ getInitials(item.client_name) }}
                  </div>
                </div>

                <div class="min-w-0 flex-1">
                  <div class="flex items-center gap-2">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-neutral-100 truncate">
                      {{ item.client_name }}
                    </h3>
                    <a
                      v-if="item.linkedin_url"
                      :href="item.linkedin_url"
                      target="_blank"
                      class="text-slate-400 hover:text-blue-600 transition-colors"
                      title="View LinkedIn Profile"
                    >
                      <Linkedin class="h-3.5 w-3.5" />
                    </a>
                  </div>
                  <p class="text-xs text-slate-500 dark:text-neutral-400 truncate">
                    {{ item.client_role || 'Client' }}
                    <span v-if="item.company" class="font-semibold text-slate-700 dark:text-neutral-300">
                      &bull; {{ item.company }}
                    </span>
                  </p>
                </div>
              </div>

              <!-- Active Status Badge -->
              <button
                @click="toggleActive(item)"
                class="px-2.5 py-1 rounded-full text-[11px] font-bold inline-flex items-center gap-1.5 transition-all cursor-pointer shrink-0 shadow-2xs"
                :class="item.is_active 
                  ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' 
                  : 'bg-slate-100 text-slate-500 dark:bg-neutral-900 dark:text-neutral-500 border border-slate-200 dark:border-neutral-800'"
              >
                <span :class="['h-1.5 w-1.5 rounded-full', item.is_active ? 'bg-emerald-500' : 'bg-slate-400 dark:bg-neutral-400']"></span>
                {{ item.is_active ? 'Active' : 'Hidden' }}
              </button>
            </div>

            <!-- Rating & Project Reference Bar -->
            <div class="flex items-center justify-between gap-2 pt-1 border-t border-slate-100 dark:border-neutral-800/80">
              <!-- Star Rating -->
              <div class="flex items-center gap-1 text-amber-400">
                <Star
                  v-for="s in 5"
                  :key="s"
                  class="h-3.5 w-3.5"
                  :class="s <= (item.rating || 5) ? 'fill-amber-400 text-amber-400' : 'text-slate-200 dark:text-neutral-700'"
                />
              </div>

              <!-- Project Reference -->
              <span
                v-if="item.project_reference"
                class="px-2.5 py-0.5 rounded-[6px] text-[11px] font-semibold bg-white dark:bg-neutral-900 text-slate-700 dark:text-neutral-300 border border-slate-200 dark:border-neutral-700/80 shadow-2xs truncate max-w-[220px]"
              >
                Project: {{ item.project_reference }}
              </span>
            </div>

            <!-- Quote Text with Decorative Icon -->
            <div class="relative py-1">
              <Quote class="h-6 w-6 text-indigo-500/15 dark:text-indigo-400/20 absolute -top-1 -left-1 pointer-events-none" />
              <p class="text-xs text-slate-700 dark:text-neutral-300 leading-relaxed pl-5 font-normal">
                &ldquo;{{ item.quote }}&rdquo;
              </p>
            </div>
          </div>

          <!-- Bottom Action Bar -->
          <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-neutral-800/80 text-xs">
            <span class="px-2 py-0.5 rounded-[4px] bg-white dark:bg-neutral-900 text-[11px] font-mono font-bold text-slate-500 dark:text-neutral-400 border border-slate-200 dark:border-neutral-800 shadow-2xs">
              Order: #{{ item.order || 0 }}
            </span>

            <div class="flex items-center gap-2">
              <button
                @click="openEditModal(item)"
                class="h-8 px-3 rounded-[6px] border border-slate-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 text-slate-700 dark:text-neutral-300 hover:bg-slate-50 dark:hover:bg-neutral-800 hover:text-slate-900 text-xs font-semibold flex items-center gap-1.5 transition-colors cursor-pointer shadow-2xs"
              >
                <Edit3 class="h-3.5 w-3.5" />
                <span>Edit</span>
              </button>

              <button
                @click="openDeleteModal(item)"
                class="h-8 w-8 rounded-[6px] border border-slate-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 text-slate-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 dark:hover:bg-red-950/40 transition-colors flex items-center justify-center cursor-pointer shadow-2xs"
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
    <Teleport to="body">
      <div
        v-if="isModalOpen"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-slate-950/60 backdrop-blur-xs overflow-y-auto"
        @click.self="closeModal"
        @keydown.esc="closeModal"
      >
        <div class="relative w-full max-w-2xl rounded-[6px] border border-slate-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 shadow-2xl overflow-hidden my-auto">
          <!-- Modal Header -->
          <div class="px-6 py-4 border-b border-slate-200 dark:border-neutral-800 flex items-center justify-between bg-white dark:bg-neutral-950">
            <div class="flex items-center gap-3">
              <div class="h-9 w-9 rounded-[6px] bg-slate-900 text-white dark:bg-white dark:text-slate-950 flex items-center justify-center shadow-2xs shrink-0">
                <Quote class="h-4.5 w-4.5" />
              </div>
              <div>
                <h2 class="text-sm font-bold text-slate-900 dark:text-white leading-none">
                  {{ isEditing ? 'Edit Client Recommendation' : 'Add Client Recommendation' }}
                </h2>
                <p class="text-[11px] text-slate-500 dark:text-neutral-400 mt-1">
                  Executive praise, testimonials, and verified social proof.
                </p>
              </div>
            </div>

            <button
              type="button"
              @click="closeModal"
              class="h-8 w-8 rounded-[6px] border border-slate-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 text-slate-400 hover:text-slate-700 dark:hover:text-neutral-200 hover:bg-slate-50 dark:hover:bg-neutral-800 transition-colors flex items-center justify-center cursor-pointer shadow-2xs"
            >
              <X class="h-4 w-4" />
            </button>
          </div>

          <!-- Form Body -->
          <form @submit.prevent="submitModalForm" class="p-6 space-y-5 max-h-[calc(85vh-130px)] overflow-y-auto">
            <!-- SECTION 1: Client Profile Header & Avatar -->
            <div class="p-4 rounded-[6px] border border-slate-200 dark:border-neutral-800 bg-white dark:bg-neutral-900/40 space-y-3.5 shadow-2xs">
              <div class="flex items-start gap-4">
                <!-- Avatar Upload Slot -->
                <div class="flex flex-col items-center gap-1.5 shrink-0">
                  <div
                    @click="$refs.avatarFileInput.click()"
                    class="relative w-20 h-20 rounded-full border-2 border-dashed border-slate-300 hover:border-slate-900 dark:border-neutral-700 dark:hover:border-neutral-400 bg-slate-50 dark:bg-neutral-900 overflow-hidden cursor-pointer group transition-all flex items-center justify-center shadow-2xs"
                    title="Click to upload client photo"
                  >
                    <img
                      v-if="modalAvatarPreview"
                      :src="modalAvatarPreview"
                      alt="Client Avatar Preview"
                      class="w-full h-full object-cover group-hover:scale-105 transition-transform"
                    />
                    <div v-else class="flex flex-col items-center justify-center text-slate-400 group-hover:text-slate-700 dark:text-neutral-500 dark:group-hover:text-neutral-200 transition-colors">
                      <Camera class="h-6 w-6 stroke-[1.5]" />
                      <span class="text-[10px] font-semibold mt-1">Photo</span>
                    </div>

                    <!-- Hover Overlay -->
                    <div
                      v-if="modalAvatarPreview"
                      class="absolute inset-0 bg-black/50 backdrop-blur-[1px] opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white"
                    >
                      <Upload class="h-4 w-4 mb-0.5" />
                      <span class="text-[9px] font-bold uppercase tracking-wider">Change</span>
                    </div>
                  </div>

                  <input
                    type="file"
                    accept="image/*"
                    @change="handleAvatarUpload"
                    class="hidden"
                    ref="avatarFileInput"
                  />

                  <div class="flex items-center gap-2">
                    <button
                      type="button"
                      @click="showUrlInput = !showUrlInput"
                      class="text-[10px] font-medium text-slate-500 hover:text-slate-900 dark:text-neutral-400 dark:hover:text-white underline underline-offset-2 transition-colors cursor-pointer"
                    >
                      {{ showUrlInput ? 'Hide URL' : 'Paste URL' }}
                    </button>
                    <button
                      v-if="modalAvatarPreview"
                      type="button"
                      @click="removeAvatar"
                      class="text-[10px] font-medium text-red-500 hover:text-red-700 transition-colors cursor-pointer"
                    >
                      Remove
                    </button>
                  </div>
                </div>

                <!-- Primary Identity Fields -->
                <div class="flex-1 space-y-3">
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Client Name -->
                    <div class="space-y-1">
                      <label class="block text-xs font-bold text-slate-800 dark:text-neutral-200">
                        Client / Leader Name <span class="text-red-500">*</span>
                      </label>
                      <div class="relative">
                        <User class="h-3.5 w-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                        <input
                          v-model="form.client_name"
                          type="text"
                          placeholder="e.g., Sarah Jenkins"
                          class="w-full h-9 pl-10 pr-3 rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 text-xs text-slate-900 dark:text-neutral-50 placeholder:text-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 dark:focus:border-neutral-500"
                          :class="{ 'border-red-500': form.errors.client_name }"
                        />
                      </div>
                      <p v-if="form.errors.client_name" class="text-[11px] text-red-500">{{ form.errors.client_name }}</p>
                    </div>

                    <!-- Role / Title -->
                    <div class="space-y-1">
                      <label class="block text-xs font-bold text-slate-800 dark:text-neutral-200">
                        Role / Title
                      </label>
                      <div class="relative">
                        <Briefcase class="h-3.5 w-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                        <input
                          v-model="form.client_role"
                          type="text"
                          placeholder="e.g., VP of Engineering"
                          class="w-full h-9 pl-10 pr-3 rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 text-xs text-slate-900 dark:text-neutral-50 placeholder:text-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 dark:focus:border-neutral-500"
                        />
                      </div>
                    </div>
                  </div>

                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Company -->
                    <div class="space-y-1">
                      <label class="block text-xs font-bold text-slate-800 dark:text-neutral-200">
                        Company / Organization
                      </label>
                      <div class="relative">
                        <Building class="h-3.5 w-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                        <input
                          v-model="form.company"
                          type="text"
                          placeholder="e.g., CloudScale Networks"
                          class="w-full h-9 pl-10 pr-3 rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 text-xs text-slate-900 dark:text-neutral-50 placeholder:text-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 dark:focus:border-neutral-500"
                        />
                      </div>
                    </div>

                    <!-- LinkedIn URL -->
                    <div class="space-y-1">
                      <label class="block text-xs font-bold text-slate-800 dark:text-neutral-200">
                        LinkedIn Profile URL
                      </label>
                      <div class="relative">
                        <Linkedin class="h-3.5 w-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                        <input
                          v-model="form.linkedin_url"
                          type="text"
                          placeholder="https://linkedin.com/in/..."
                          class="w-full h-9 pl-10 pr-3 rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 text-xs text-slate-900 dark:text-neutral-50 placeholder:text-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 dark:focus:border-neutral-500"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Collapsible Image URL input -->
              <div v-if="showUrlInput" class="pt-2 border-t border-slate-100 dark:border-neutral-800">
                <label class="block text-[11px] font-bold text-slate-600 dark:text-neutral-400 mb-1">
                  Direct Avatar Image URL
                </label>
                <input
                  v-model="form.client_avatar"
                  type="text"
                  placeholder="https://images.unsplash.com/..."
                  class="w-full h-8 px-3 rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 text-xs text-slate-900 dark:text-neutral-50 placeholder:text-slate-400 focus:outline-none focus:border-slate-900"
                />
              </div>
            </div>

            <!-- SECTION 2: Project Reference & Interactive Star Rating -->
            <div class="space-y-4">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-end">
                <!-- Project Reference -->
                <div class="space-y-1">
                  <label class="block text-xs font-bold text-slate-800 dark:text-neutral-200">
                    Associated Project
                  </label>
                  <div class="relative">
                    <Folder class="h-3.5 w-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                    <input
                      v-model="form.project_reference"
                      type="text"
                      placeholder="e.g., Nexus SaaS Dashboard"
                      class="w-full h-9 pl-10 pr-3 rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 text-xs text-slate-900 dark:text-neutral-50 placeholder:text-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 dark:focus:border-neutral-500"
                    />
                  </div>
                </div>

                <!-- Star Rating Selector -->
                <div class="space-y-1">
                  <div class="flex items-center justify-between">
                    <label class="block text-xs font-bold text-slate-800 dark:text-neutral-200">
                      Client Star Rating
                    </label>
                    <span class="text-[11px] font-semibold text-amber-600 dark:text-amber-400">
                      {{ currentRatingLabel }}
                    </span>
                  </div>
                  <div class="h-9 px-3 rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 flex items-center justify-between">
                    <div class="flex items-center gap-1.5" @mouseleave="hoverRating = 0">
                      <button
                        v-for="star in 5"
                        :key="star"
                        type="button"
                        @mouseenter="hoverRating = star"
                        @click="form.rating = star"
                        class="p-0.5 hover:scale-120 transition-transform cursor-pointer"
                        :title="`Rate ${star} Stars`"
                      >
                        <Star
                          class="h-4.5 w-4.5 transition-colors"
                          :class="star <= (hoverRating || form.rating)
                            ? 'fill-amber-400 text-amber-400'
                            : 'text-slate-200 dark:text-neutral-700'"
                        />
                      </button>
                    </div>
                    <span class="text-xs font-mono font-bold text-slate-500 dark:text-neutral-400">
                      {{ form.rating }} / 5
                    </span>
                  </div>
                </div>
              </div>

              <!-- Recommendation Quote -->
              <div class="space-y-1">
                <div class="flex items-center justify-between">
                  <label class="block text-xs font-bold text-slate-800 dark:text-neutral-200">
                    Recommendation Quote <span class="text-red-500">*</span>
                  </label>
                  <span class="text-[11px] text-slate-400 font-medium">Rendered on live portfolio card</span>
                </div>
                <textarea
                  v-model="form.quote"
                  rows="4"
                  placeholder="What did the client or executive highlight regarding technical velocity, backend architecture, communication, or project execution?"
                  class="w-full p-3.5 rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 text-xs text-slate-900 dark:text-neutral-50 placeholder:text-slate-400 focus:outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900 leading-relaxed"
                  :class="{ 'border-red-500': form.errors.quote }"
                ></textarea>
                <p v-if="form.errors.quote" class="text-[11px] text-red-500">{{ form.errors.quote }}</p>
              </div>
            </div>

            <!-- SECTION 3: Live Visibility Toggle & Sort Order -->
            <div class="p-3.5 rounded-[6px] border border-slate-200 dark:border-neutral-800 bg-white dark:bg-neutral-900/40 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-2xs">
              <!-- Modern Toggle Switch -->
              <div class="flex items-center gap-3">
                <button
                  type="button"
                  @click="form.is_active = !form.is_active"
                  :class="form.is_active ? 'bg-slate-900 dark:bg-white' : 'bg-slate-200 dark:bg-neutral-800'"
                  class="relative inline-flex h-5 w-10 shrink-0 cursor-pointer rounded-full transition-colors duration-200 ease-in-out focus:outline-none p-0.5"
                  role="switch"
                  :aria-checked="form.is_active"
                >
                  <span
                    :class="form.is_active ? 'translate-x-5 bg-white dark:bg-slate-900' : 'translate-x-0 bg-white dark:bg-neutral-400'"
                    class="pointer-events-none inline-block h-4 w-4 transform rounded-full shadow-xs ring-0 transition duration-200 ease-in-out"
                  />
                </button>
                <div>
                  <span class="text-xs font-bold text-slate-900 dark:text-white block leading-none">
                    Active &bull; Visible in Carousel
                  </span>
                  <span class="text-[11px] text-slate-500 dark:text-neutral-400 mt-0.5 block">
                    Displayed prominently on your portfolio homepage.
                  </span>
                </div>
              </div>

              <!-- Order Input -->
              <div class="flex items-center gap-2 shrink-0 self-end sm:self-auto">
                <span class="text-xs font-bold text-slate-700 dark:text-neutral-300">Sort Order:</span>
                <input
                  v-model.number="form.order"
                  type="number"
                  min="0"
                  class="w-14 h-8 px-2 rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 text-xs text-slate-900 dark:text-neutral-50 text-center font-mono font-bold focus:outline-none focus:border-slate-900"
                />
              </div>
            </div>

            <!-- Modal Footer Actions -->
            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-200 dark:border-neutral-800">
              <button
                type="button"
                @click="closeModal"
                class="h-9 px-4 rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900 text-xs font-semibold text-slate-700 dark:text-neutral-300 hover:bg-slate-50 dark:hover:bg-neutral-800 transition-colors cursor-pointer shadow-2xs"
              >
                Cancel
              </button>
              <button
                type="submit"
                :disabled="form.processing"
                class="h-9 px-5 rounded-[6px] bg-slate-900 text-white dark:bg-neutral-50 dark:text-neutral-900 text-xs font-bold hover:bg-slate-800 transition-all shadow-md flex items-center gap-2 cursor-pointer disabled:opacity-50"
              >
                <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
                <Save v-else class="h-4 w-4" />
                <span>{{ isEditing ? 'Save Changes' : 'Create Endorsement' }}</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>

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
import { ref, computed, watch } from 'vue';
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
  User,
  Briefcase,
  Building,
  Camera,
  Upload,
  X,
  Folder,
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
const showUrlInput = ref(false);
const hoverRating = ref(0);

const ratingLabels = {
  5: '5.0 ★ Exceptional',
  4: '4.0 ★ Highly Recommended',
  3: '3.0 ★ Good Delivery',
  2: '2.0 ★ Fair',
  1: '1.0 ★ Needs Improvement',
};

const currentRatingLabel = computed(() => {
  const r = hoverRating.value || form.rating || 5;
  return ratingLabels[r] || `${r}.0 ★ Rated`;
});

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

function removeAvatar() {
  form.client_avatar = '';
  form.avatar_file = null;
  localAvatarPreview.value = null;
}

function openCreateModal() {
  isEditing.value = false;
  editingId.value = null;
  localAvatarPreview.value = null;
  showUrlInput.value = false;
  hoverRating.value = 0;
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
  showUrlInput.value = Boolean(item.client_avatar && !item.client_avatar.startsWith('/storage/'));
  hoverRating.value = 0;
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

watch(isModalOpen, (open) => {
  if (open) {
    document.body.style.overflow = 'hidden';
  } else {
    document.body.style.overflow = '';
  }
});

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
