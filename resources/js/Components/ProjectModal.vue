<template>
  <Teleport to="body">
    <Transition name="modal-fade">
      <div
        v-if="isOpen && project"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
        @keydown.esc="close"
      >
        <!-- Backdrop -->
        <div
          class="fixed inset-0 bg-black/90 backdrop-blur-md transition-opacity"
          @click="close"
        ></div>

        <!-- Dialog Container (Standardized rounded-md) -->
        <div
          class="relative w-full max-w-3xl bg-neutral-950 border border-neutral-800 rounded-md shadow-2xl overflow-hidden z-10 text-neutral-100 focus:outline-none"
          tabindex="-1"
        >
          <!-- Close Button -->
          <button
            @click="close"
            class="absolute top-4 right-4 z-20 w-8 h-8 rounded-md bg-neutral-900 border border-neutral-800 hover:bg-neutral-800 text-neutral-300 hover:text-white flex items-center justify-center transition-colors"
            aria-label="Close modal"
          >
            ✕
          </button>

          <!-- Banner / Image Showcase -->
          <div class="relative h-64 sm:h-80 w-full overflow-hidden bg-black">
            <img
              :src="project.image_path || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&q=80'"
              :alt="project.title"
              class="w-full h-full object-cover object-center"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/40 to-transparent"></div>

            <div class="absolute bottom-4 left-6 right-6 flex flex-wrap items-center gap-2">
              <span
                v-if="project.is_featured"
                class="px-2.5 py-0.5 rounded-md bg-white text-black text-[10px] font-bold uppercase tracking-wider shadow"
              >
                Featured Project
              </span>
              <span
                v-if="project.category"
                class="px-2.5 py-0.5 rounded-md bg-black/90 text-neutral-300 text-[10px] font-mono border border-neutral-800"
              >
                {{ project.category }}
              </span>
            </div>
          </div>

          <!-- Content Body -->
          <div class="p-6 sm:p-8 space-y-6 max-h-[calc(85vh-200px)] overflow-y-auto bg-neutral-950">
            <div>
              <h3 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                {{ project.title }}
              </h3>
              <p class="text-neutral-400 text-sm mt-2 leading-relaxed">
                {{ project.description || project.summary }}
              </p>
            </div>

            <!-- Tech Stack Badges -->
            <div v-if="project.tech_stack && project.tech_stack.length" class="space-y-2">
              <h4 class="text-xs font-mono uppercase tracking-widest text-neutral-400">Technology Stack</h4>
              <div class="flex flex-wrap gap-2">
                <span
                  v-for="(tech, i) in project.tech_stack"
                  :key="i"
                  class="px-2.5 py-1 rounded-md bg-black border border-neutral-800 text-neutral-300 text-xs font-mono"
                >
                  {{ tech }}
                </span>
              </div>
            </div>

            <!-- Highlights / Key Features -->
            <div v-if="project.highlights && project.highlights.length" class="space-y-2">
              <h4 class="text-xs font-mono uppercase tracking-widest text-neutral-400">Key Highlights</h4>
              <ul class="space-y-1.5">
                <li
                  v-for="(item, idx) in project.highlights"
                  :key="idx"
                  class="text-xs text-neutral-300 flex items-start space-x-2"
                >
                  <span class="text-emerald-400 font-bold">✓</span>
                  <span>{{ item }}</span>
                </li>
              </ul>
            </div>

            <!-- Modal Footer Actions -->
            <div class="pt-4 border-t border-neutral-900 flex flex-wrap items-center justify-between gap-4">
              <div class="flex items-center space-x-3">
                <a
                  v-if="project.demo_url"
                  :href="project.demo_url"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="px-5 py-2.5 rounded-md bg-white hover:bg-neutral-200 text-black font-bold text-xs shadow transition-all flex items-center space-x-1.5"
                >
                  <span>Live Demo</span>
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                  </svg>
                </a>
                <a
                  v-if="project.github_url"
                  :href="project.github_url"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="px-4 py-2.5 rounded-md bg-black hover:bg-neutral-900 border border-neutral-800 text-neutral-200 text-xs font-mono transition-colors"
                >
                  GitHub Repository
                </a>
              </div>

              <Link
                v-if="project.slug || project.id"
                :href="route('projects.show', project.slug || project.id)"
                class="text-xs text-neutral-400 hover:text-white font-medium hover:underline flex items-center space-x-1"
                @click="close"
              >
                <span>Full Project Page</span>
                <span>→</span>
              </Link>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { watch } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  isOpen: Boolean,
  project: Object,
});

const emit = defineEmits(['close']);

function close() {
  emit('close');
}

watch(() => props.isOpen, (newVal) => {
  if (newVal) {
    document.body.style.overflow = 'hidden';
  } else {
    document.body.style.overflow = '';
  }
});
</script>

<style scoped>
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.2s ease, transform 0.2s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
  transform: scale(0.97);
}
</style>
