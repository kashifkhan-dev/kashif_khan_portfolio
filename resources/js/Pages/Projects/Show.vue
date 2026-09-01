<template>
  <GuestLayout :canLogin="true" :settings="settings">
    <Head :title="`${project.title} - Project Case Study & Showcase`" />

    <div class="min-h-screen pt-20 pb-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-12">
      
      <!-- Top Navigation & Breadcrumb -->
      <div class="flex items-center justify-between border-b border-slate-800/80 pb-6">
        <Link 
          :href="route('home') + '#projects'" 
          class="inline-flex items-center space-x-2 text-xs font-semibold text-slate-400 hover:text-white transition-colors group"
        >
          <ArrowLeft class="w-4 h-4 transition-transform group-hover:-translate-x-1" />
          <span>Back to Portfolio Projects</span>
        </Link>

        <div class="flex items-center space-x-3">
          <a
            v-if="project.github_url"
            :href="project.github_url"
            target="_blank"
            class="px-3.5 py-2 rounded-xl glass-card text-xs font-semibold text-slate-300 hover:text-white flex items-center space-x-2 transition-all"
          >
            <Github class="w-4 h-4 text-slate-400" />
            <span>Repository</span>
          </a>
          <a
            v-if="project.demo_url"
            :href="project.demo_url"
            target="_blank"
            class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow-lg shadow-blue-600/30 flex items-center space-x-2 transition-all"
          >
            <ExternalLink class="w-4 h-4" />
            <span>Launch Live Demo</span>
          </a>
        </div>
      </div>

      <!-- Hero Title Header -->
      <div class="space-y-4 max-w-4xl">
        <div class="flex items-center space-x-3">
          <span class="px-3 py-1 rounded-full bg-blue-600/20 text-blue-400 text-xs font-semibold border border-blue-500/30">
            {{ project.category }}
          </span>
          <span 
            v-if="project.is_featured"
            class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-xs font-semibold border border-emerald-500/30"
          >
            Featured Hero
          </span>
        </div>

        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
          {{ project.title }}
        </h1>

        <p v-if="project.summary" class="text-base sm:text-lg text-slate-300 leading-relaxed">
          {{ project.summary }}
        </p>

        <!-- Inline Tech Stack Chips -->
        <div v-if="project.tech_stack && project.tech_stack.length" class="flex flex-wrap items-center gap-2 pt-2">
          <span
            v-for="(tech, i) in project.tech_stack"
            :key="i"
            class="px-3 py-1 rounded-lg bg-slate-900/90 text-slate-300 text-xs font-medium border border-slate-800/80 shadow-sm"
          >
            {{ tech }}
          </span>
        </div>
      </div>

      <!-- Main Showcase Cover Image -->
      <div class="relative w-full h-[320px] sm:h-[480px] rounded-3xl overflow-hidden glass-panel border border-slate-800 shadow-2xl group">
        <img
          :src="project.image_path || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&q=80'"
          :alt="project.title"
          class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105"
          @error="handleImageError"
        />
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent opacity-60"></div>
      </div>

      <!-- Full-Width Main Project Overview Section -->
      <div class="space-y-6 pt-4">
        <div class="border-b border-slate-800/80 pb-3">
          <h2 class="text-xs uppercase tracking-widest font-bold text-blue-400 flex items-center space-x-2">
            <FileText class="w-4 h-4" />
            <span>Project Overview & Architecture</span>
          </h2>
        </div>

        <!-- Formatted HTML Rich Content -->
        <div 
          class="prose-custom pt-2" 
          v-html="project.description || project.summary || 'No detailed overview provided for this project.'"
        ></div>
      </div>

      <!-- RELATED PROJECTS SHOWCASE -->
      <div v-if="relatedProjects && relatedProjects.length" class="pt-16 border-t border-slate-800/80 space-y-8">
        <div class="flex items-center justify-between">
          <div>
            <h2 class="text-xs uppercase tracking-widest font-bold text-blue-400">Explore More Work</h2>
            <h3 class="text-2xl font-extrabold text-white mt-1">Related Projects</h3>
          </div>
          <Link
            :href="route('home') + '#projects'"
            class="text-xs font-semibold text-blue-400 hover:text-blue-300"
          >
            View All Projects &rarr;
          </Link>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <Link
            v-for="rel in relatedProjects"
            :key="rel.id"
            :href="route('projects.show', rel.slug || rel.id)"
            class="glass-card rounded-2xl overflow-hidden group flex flex-col transition-all duration-300 hover:-translate-y-1.5"
          >
            <div class="relative h-40 overflow-hidden bg-slate-900">
              <img
                :src="rel.image_path || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80'"
                :alt="rel.title"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              />
              <span class="absolute bottom-3 left-3 px-2.5 py-0.5 rounded-lg bg-slate-900/80 text-blue-300 text-[11px] font-medium backdrop-blur-md border border-slate-700/50">
                {{ rel.category }}
              </span>
            </div>
            <div class="p-5 space-y-2">
              <h4 class="text-base font-bold text-white group-hover:text-blue-400 transition-colors truncate">
                {{ rel.title }}
              </h4>
              <p class="text-slate-400 text-xs line-clamp-2 leading-relaxed">
                {{ rel.summary || rel.description }}
              </p>
            </div>
          </Link>
        </div>
      </div>

    </div>
  </GuestLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { 
  ArrowLeft, 
  ExternalLink, 
  Github, 
  FileText 
} from 'lucide-vue-next';

defineProps({
  project: Object,
  relatedProjects: Array,
  settings: Object,
});

function handleImageError(e) {
  e.target.src = 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&q=80';
}
</script>
