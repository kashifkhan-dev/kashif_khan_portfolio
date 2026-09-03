<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition-opacity duration-300 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition-opacity duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="isOpen" class="fixed inset-0 z-50 overflow-y-auto bg-black/90 backdrop-blur-xl p-4 sm:p-6 lg:p-10 flex flex-col items-center">
        <div class="w-full max-w-7xl my-auto space-y-8 bg-neutral-950 border border-neutral-800 rounded-2xl p-6 sm:p-10 shadow-2xl relative max-h-[90vh] overflow-y-auto custom-scrollbar">
          
          <!-- Modal Header -->
          <div class="flex items-center justify-between pb-6 border-b border-neutral-800/80 sticky top-0 bg-neutral-950 z-20 pt-2">
            <div>
              <h2 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight">Full Project Showcase</h2>
              <p class="text-neutral-400 text-xs sm:text-sm mt-1">Explore all {{ projects?.length || 0 }} web applications, enterprise platforms, and open-source projects.</p>
            </div>
            <button
              @click="$emit('close')"
              class="w-10 h-10 rounded-xl bg-neutral-900 border border-neutral-800 text-neutral-400 hover:text-white flex items-center justify-center transition-colors cursor-pointer shrink-0 ml-4"
              aria-label="Close modal"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>

          <!-- Category Filter Bar -->
          <div class="flex items-center justify-between flex-wrap gap-4 pt-2">
            <div class="flex flex-wrap items-center gap-2">
              <button
                v-for="cat in categories"
                :key="cat"
                @click="selectedCategory = cat"
                class="px-4 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-all cursor-pointer"
                :class="selectedCategory === cat
                  ? 'bg-white text-black shadow-md'
                  : 'bg-neutral-900 text-neutral-300 hover:text-white border border-neutral-800'"
              >
                {{ cat }}
              </button>
            </div>

            <!-- Search Input -->
            <div class="relative w-full sm:w-64">
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search projects or tech..."
                class="w-full pl-9 pr-4 py-2 rounded-xl bg-neutral-900 border border-neutral-800 text-white text-xs sm:text-sm focus:outline-none focus:border-white transition-colors"
              />
              <svg class="w-4 h-4 text-neutral-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
            </div>
          </div>

          <!-- Projects Grid -->
          <div v-if="filteredList.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-4">
            <div
              v-for="project in filteredList"
              :key="project.id"
              class="bg-neutral-900/60 border border-neutral-800 rounded-xl overflow-hidden hover:border-neutral-700 transition-all flex flex-col justify-between group shadow-lg"
            >
              <div>
                <!-- Image -->
                <div
                  @click="selectProject(project)"
                  class="relative h-48 w-full overflow-hidden bg-black cursor-pointer"
                >
                  <img
                    :src="project.image_path || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80'"
                    :alt="project.title"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-85 group-hover:opacity-100"
                  />
                  <div class="absolute top-3 left-3 flex items-center space-x-2">
                    <span v-if="project.is_featured" class="px-2 py-0.5 rounded bg-white text-black text-[10px] font-extrabold uppercase">
                      Featured
                    </span>
                    <span class="px-2 py-0.5 rounded bg-black/80 text-neutral-200 text-[10px] font-mono border border-neutral-800">
                      {{ project.category }}
                    </span>
                  </div>
                </div>

                <!-- Body -->
                <div class="p-5 space-y-3">
                  <h4
                    @click="selectProject(project)"
                    class="text-lg font-bold text-white hover:text-neutral-300 transition-colors cursor-pointer truncate"
                  >
                    {{ project.title }}
                  </h4>
                  <p class="text-neutral-300 text-xs sm:text-sm leading-relaxed line-clamp-2">
                    {{ project.summary || project.description }}
                  </p>

                  <!-- Tech Tags -->
                  <div class="flex flex-wrap gap-1.5 pt-1">
                    <span
                      v-for="(tech, i) in (project.tech_stack || [])"
                      :key="i"
                      class="px-2 py-0.5 rounded bg-neutral-950 text-neutral-300 text-[11px] font-mono border border-neutral-800/80"
                    >
                      {{ tech }}
                    </span>
                  </div>
                </div>
              </div>

              <!-- Footer -->
              <div class="px-5 py-3.5 flex items-center justify-between border-t border-neutral-800/80 bg-neutral-950/40">
                <button
                  @click="selectProject(project)"
                  class="text-xs font-bold text-white hover:underline flex items-center space-x-1"
                >
                  <span>Details</span>
                  <span>→</span>
                </button>
                <div class="flex items-center space-x-2.5">
                  <a
                    v-if="project.github_url"
                    :href="project.github_url"
                    target="_blank"
                    class="text-neutral-400 hover:text-white text-xs font-mono transition-colors"
                  >
                    GitHub
                  </a>
                  <a
                    v-if="project.demo_url"
                    :href="project.demo_url"
                    target="_blank"
                    class="px-2.5 py-1 rounded bg-white text-black font-bold text-xs hover:bg-neutral-200 transition-colors"
                  >
                    Demo
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Empty State -->
          <div v-else class="py-16 text-center text-neutral-400">
            <p class="text-base font-semibold">No matching projects found.</p>
            <button @click="selectedCategory = 'All'; searchQuery = ''" class="mt-3 text-xs text-white underline cursor-pointer">
              Reset Filters
            </button>
          </div>

        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  isOpen: Boolean,
  projects: Array,
  categories: Array,
});

const emit = defineEmits(['close', 'select-project']);

const selectedCategory = ref('All');
const searchQuery = ref('');

const filteredList = computed(() => {
  let list = props.projects || [];

  if (selectedCategory.value !== 'All') {
    list = list.filter(p => p.category === selectedCategory.value);
  }

  if (searchQuery.value.trim()) {
    const q = searchQuery.value.toLowerCase();
    list = list.filter(p =>
      p.title.toLowerCase().includes(q) ||
      (p.summary && p.summary.toLowerCase().includes(q)) ||
      (p.description && p.description.toLowerCase().includes(q)) ||
      (p.tech_stack && p.tech_stack.some(t => t.toLowerCase().includes(q)))
    );
  }

  return list;
});

function selectProject(project) {
  emit('select-project', project);
}
</script>
