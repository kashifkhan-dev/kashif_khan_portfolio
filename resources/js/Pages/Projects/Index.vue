<template>
  <GuestLayout :canLogin="true" :settings="settings">
    <Head title="All Projects & Software Portfolio - Kashif Khan" />

    <div class="min-h-screen pt-4 sm:pt-16 lg:pt-24 pb-12 sm:pb-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6 sm:space-y-10 lg:space-y-12 bg-black">
      
      <!-- Top Navigation & Breadcrumb -->
      <div class="flex items-center justify-between border-b border-neutral-800 pb-6">
        <Link 
          :href="route('home')" 
          class="inline-flex items-center space-x-2 text-xs sm:text-sm font-semibold text-neutral-400 hover:text-white transition-colors group"
        >
          <span class="group-hover:-translate-x-1 transition-transform font-mono">←</span>
          <span>Back to Overview</span>
        </Link>

        <span class="text-xs font-mono text-neutral-500 uppercase tracking-widest">
          {{ filteredProjects.length }} {{ filteredProjects.length === 1 ? 'Project' : 'Projects' }} Found
        </span>
      </div>

      <!-- Page Header -->
      <div class="space-y-4 max-w-3xl">
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
          All Engineering Projects
        </h1>
        <p class="text-neutral-400 text-base sm:text-lg leading-relaxed">
          A complete repository of full-stack platforms, microservices, cloud telemetry systems, and interactive applications built with Laravel, Vue 3, React, and modern web architectures.
        </p>
      </div>

      <!-- Filter & Search Control Bar -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-4 border-t border-neutral-900">
        <!-- Category Filters -->
        <div class="flex flex-wrap items-center gap-2">
          <button
            v-for="cat in availableCategories"
            :key="cat"
            @click="activeCategory = cat"
            class="px-4 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-all cursor-pointer"
            :class="activeCategory === cat
              ? 'bg-white text-black font-bold shadow-md'
              : 'bg-neutral-900 text-neutral-300 hover:text-white hover:bg-neutral-800 border border-neutral-800'"
          >
            {{ cat }}
          </button>
        </div>

        <!-- Search Bar -->
        <div class="relative w-full sm:w-72">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search title, tech stack..."
            class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-neutral-900 border border-neutral-800 text-white text-xs sm:text-sm focus:outline-none focus:border-white transition-colors"
          />
          <svg class="w-4 h-4 text-neutral-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </div>
      </div>

      <!-- Projects Grid -->
      <div v-if="filteredProjects.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 pt-4">
        <div
          v-for="project in filteredProjects"
          :key="project.id"
          class="bg-neutral-950 border border-neutral-800 rounded-xl overflow-hidden hover:border-neutral-700 transition-all flex flex-col justify-between group shadow-lg"
        >
          <div>
            <!-- Image Header -->
            <Link
              :href="route('projects.show', project.slug || project.id)"
              class="relative h-56 w-full overflow-hidden bg-black cursor-pointer block"
            >
              <img
                :src="project.image_path || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80'"
                :alt="project.title"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-85 group-hover:opacity-100"
                @error="handleImageError"
              />
              <div class="absolute top-4 left-4 flex items-center space-x-2">
                <span
                  v-if="project.is_featured"
                  class="px-2.5 py-1 rounded-md bg-white text-black text-xs font-bold uppercase"
                >
                  Featured
                </span>
                <span class="px-2.5 py-1 rounded-md bg-black/80 text-neutral-200 text-xs font-mono border border-neutral-800">
                  {{ project.category }}
                </span>
              </div>
            </Link>

            <!-- Content Body -->
            <div class="p-7 space-y-4">
              <Link :href="route('projects.show', project.slug || project.id)" class="block">
                <h3 class="text-xl font-bold text-white hover:text-neutral-300 transition-colors cursor-pointer">
                  {{ project.title }}
                </h3>
              </Link>
              <p class="text-neutral-300 text-xs sm:text-sm leading-relaxed line-clamp-3">
                {{ project.summary || project.description }}
              </p>

              <!-- Tech Stack Tags -->
              <div class="flex flex-wrap gap-2 pt-2">
                <span
                  v-for="(tech, i) in (project.tech_stack || [])"
                  :key="i"
                  class="px-2.5 py-1 rounded-md bg-neutral-900 text-neutral-300 text-xs font-mono border border-neutral-800"
                >
                  {{ tech }}
                </span>
              </div>
            </div>
          </div>

          <!-- Card Actions -->
          <div class="px-7 py-5 flex items-center justify-between border-t border-neutral-800/80 bg-neutral-950/60 mt-auto">
            <Link
              :href="route('projects.show', project.slug || project.id)"
              class="text-xs font-bold text-white hover:text-neutral-300 transition-colors flex items-center space-x-1.5 cursor-pointer"
            >
              <span>View Details</span>
              <span>→</span>
            </Link>

            <div class="flex items-center space-x-3 text-xs">
              <a
                v-if="project.github_url"
                :href="project.github_url"
                target="_blank"
                class="text-neutral-300 hover:text-white font-mono flex items-center space-x-1 transition-colors"
              >
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                </svg>
                <span>GitHub</span>
              </a>
              <a
                v-if="project.demo_url"
                :href="project.demo_url"
                target="_blank"
                class="px-3.5 py-2 rounded-sm bg-white text-black font-bold text-xs hover:bg-neutral-200 transition-colors flex items-center space-x-1.5"
              >
                <span>Demo</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty State -->
      <div v-else class="py-24 text-center space-y-4">
        <p class="text-neutral-400 text-base">No projects found matching your search or category filter.</p>
        <button
          @click="activeCategory = 'All'; searchQuery = ''"
          class="px-5 py-2.5 rounded-lg bg-neutral-900 border border-neutral-800 text-white text-xs font-semibold hover:bg-neutral-800 transition-colors cursor-pointer"
        >
          Reset Search Filters
        </button>
      </div>

    </div>

    <!-- Project Detail Modal -->
    <ProjectModal
      :isOpen="isModalOpen"
      :project="selectedProject"
      @close="isModalOpen = false"
    />
  </GuestLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ProjectModal from '@/Components/ProjectModal.vue';

const props = defineProps({
  projects: Array,
  settings: Object,
});

const activeCategory = ref('All');
const searchQuery = ref('');
const isModalOpen = ref(false);
const selectedProject = ref(null);

const availableCategories = computed(() => {
  const cats = new Set(['All']);
  (props.projects || []).forEach(p => {
    if (p.category) cats.add(p.category);
  });
  return Array.from(cats);
});

const filteredProjects = computed(() => {
  let list = props.projects || [];

  if (activeCategory.value !== 'All') {
    list = list.filter(p => p.category === activeCategory.value);
  }

  if (searchQuery.value.trim()) {
    const q = searchQuery.value.toLowerCase();
    list = list.filter(p =>
      p.title.toLowerCase().includes(q) ||
      (p.summary && p.summary.toLowerCase().includes(q)) ||
      (p.description && p.description.toLowerCase().includes(q)) ||
      (p.tech_stack && p.tech_stack.some(t => String(t).toLowerCase().includes(q)))
    );
  }

  return list;
});

function openModal(project) {
  selectedProject.value = project;
  isModalOpen.value = true;
}

function handleImageError(e) {
  e.target.src = 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80';
}
</script>
