<template>
  <GuestLayout :canLogin="true" :settings="settings">
    <Head :title="`${project.title} - Project Case Study & Showcase`" />

    <div class="min-h-screen pt-4 sm:pt-8 pb-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6 bg-black">
      
      <!-- Clean Top Bar Navigation & Desktop Action Buttons -->
      <div class="flex items-center justify-between">
        <Link 
          :href="route('projects.index')" 
          class="inline-flex items-center space-x-2 text-xs font-semibold text-neutral-400 hover:text-white transition-colors group"
        >
          <ArrowLeft class="w-4 h-4 transition-transform group-hover:-translate-x-1" />
          <span>Back to All Projects</span>
        </Link>

        <!-- Action Buttons on Desktop ONLY -->
        <div class="hidden sm:flex items-center space-x-3">
          <a
            v-if="project.demo_url"
            :href="project.demo_url"
            target="_blank"
            class="px-4 py-2 rounded-sm bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold flex items-center space-x-2 transition-all shadow-md"
          >
            <ExternalLink class="w-4 h-4" />
            <span>Launch Live Demo</span>
          </a>
          <a
            v-if="project.github_url"
            :href="project.github_url"
            target="_blank"
            class="px-3.5 py-2 rounded-sm bg-neutral-900 hover:bg-neutral-800 border border-neutral-800 text-xs font-semibold text-neutral-300 hover:text-white flex items-center space-x-2 transition-all"
          >
            <Github class="w-4 h-4 text-neutral-400" />
            <span>Repository</span>
          </a>
        </div>
      </div>

      <!-- Hero Title Header -->
      <div class="space-y-5 max-w-4xl pt-2">
        <div class="flex flex-wrap items-center gap-2">
          <span 
            v-if="project.is_featured"
            class="px-2.5 py-1 rounded-sm bg-white text-black text-xs font-bold uppercase"
          >
            Featured Project
          </span>
          <span class="px-2.5 py-1 rounded-sm bg-neutral-900 text-neutral-300 text-xs font-mono border border-neutral-800">
            {{ project.category }}
          </span>
        </div>

        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
          {{ project.title }}
        </h1>

        <p v-if="project.summary" class="text-base sm:text-lg text-neutral-300 leading-relaxed">
          {{ project.summary }}
        </p>

        <!-- Action Buttons on Mobile ONLY -->
        <div class="flex sm:hidden items-center space-x-3 pt-1">
          <a
            v-if="project.demo_url"
            :href="project.demo_url"
            target="_blank"
            class="px-4 py-2 rounded-sm bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold flex items-center space-x-2 transition-all shadow-md"
          >
            <ExternalLink class="w-4 h-4" />
            <span>Live Demo</span>
          </a>
          <a
            v-if="project.github_url"
            :href="project.github_url"
            target="_blank"
            class="px-3.5 py-2 rounded-sm bg-neutral-900 hover:bg-neutral-800 border border-neutral-800 text-xs font-semibold text-neutral-300 hover:text-white flex items-center space-x-2 transition-all"
          >
            <Github class="w-4 h-4 text-neutral-400" />
            <span>Repository</span>
          </a>
        </div>

        <!-- Inline Tech Stack Chips -->
        <div v-if="project.tech_stack && project.tech_stack.length" class="flex flex-wrap items-center gap-1.5 pt-1">
          <span
            v-for="(tech, i) in project.tech_stack"
            :key="i"
            class="px-2.5 py-1 rounded-sm bg-neutral-900 text-neutral-300 text-xs font-mono border border-neutral-800"
          >
            {{ tech }}
          </span>
        </div>
      </div>

      <!-- Main Showcase Cover Image -->
      <div class="relative w-full h-[320px] sm:h-[480px] rounded-xl overflow-hidden border border-neutral-800 bg-neutral-950 shadow-2xl group">
        <img
          :src="project.image_path || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&q=80'"
          :alt="project.title"
          class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105"
          @error="handleImageError"
        />
        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60"></div>
      </div>

      <!-- Full-Width Main Project Overview Section -->
      <div class="space-y-6 pt-4">
        <div class="border-b border-neutral-800 pb-3">
          <h2 class="text-xs uppercase tracking-widest font-bold text-blue-400 flex items-center space-x-2">
            <FileText class="w-4 h-4 text-blue-400" />
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
      <div v-if="relatedProjects && relatedProjects.length" class="pt-16 border-t border-neutral-800 space-y-8">
        <div class="flex items-center justify-between">
          <div>
            <h2 class="text-xs uppercase tracking-widest font-bold text-blue-400">Explore More Work</h2>
            <h3 class="text-2xl font-extrabold text-white mt-1">Related Projects</h3>
          </div>
          <Link
            :href="route('projects.index')"
            class="text-xs font-semibold text-blue-400 hover:text-blue-300"
          >
            View All Projects &rarr;
          </Link>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div
            v-for="rel in relatedProjects"
            :key="rel.id"
            class="bg-neutral-950 border border-neutral-800 rounded-md overflow-hidden hover:border-neutral-700 transition-all flex flex-col justify-between group shadow-lg"
          >
            <div>
              <!-- Image Header -->
              <Link
                :href="route('projects.show', rel.slug || rel.id)"
                class="relative h-56 w-full overflow-hidden bg-black cursor-pointer block"
              >
                <img
                  :src="rel.image_path || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80'"
                  :alt="rel.title"
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-85 group-hover:opacity-100"
                  @error="handleImageError"
                />
                <div class="absolute top-4 left-4 flex flex-wrap items-center gap-2">
                  <span
                    v-if="rel.is_featured"
                    class="px-2.5 py-1 rounded-md bg-white text-black text-xs font-bold uppercase"
                  >
                    Featured
                  </span>
                  <span class="px-2.5 py-1 rounded-md bg-black/80 text-neutral-200 text-xs font-mono border border-neutral-800">
                    {{ rel.category }}
                  </span>
                </div>
              </Link>

              <!-- Content Body -->
              <div class="p-7 space-y-4">
                <Link :href="route('projects.show', rel.slug || rel.id)" class="block">
                  <h4 class="text-xl sm:text-2xl font-bold text-white hover:text-neutral-300 transition-colors cursor-pointer line-clamp-1">
                    {{ rel.title }}
                  </h4>
                </Link>
                <p class="text-neutral-300 text-sm sm:text-base leading-relaxed line-clamp-3">
                  {{ rel.summary || rel.description }}
                </p>

                <!-- Tech Pills -->
                <div class="flex flex-wrap gap-2 pt-2">
                  <span
                    v-for="(tech, i) in (rel.tech_stack || [])"
                    :key="i"
                    class="px-2.5 py-1 rounded-md bg-neutral-900 text-neutral-200 text-xs font-mono border border-neutral-800"
                  >
                    {{ tech }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Card Actions / Footer -->
            <div class="px-7 py-5 flex items-center justify-between border-t border-neutral-800/80 bg-neutral-950/60 mt-auto">
              <Link
                :href="route('projects.show', rel.slug || rel.id)"
                class="text-sm font-bold text-white hover:text-neutral-300 transition-colors flex items-center space-x-1.5 cursor-pointer"
              >
                <span>View Details</span>
                <span>→</span>
              </Link>
              <div class="flex items-center space-x-3 text-sm">
                <a
                  v-if="rel.github_url"
                  :href="rel.github_url"
                  target="_blank"
                  class="text-neutral-300 hover:text-white font-mono text-xs flex items-center space-x-1.5 transition-colors"
                >
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                  </svg>
                  <span>GitHub</span>
                </a>
                <a
                  v-if="rel.demo_url"
                  :href="rel.demo_url"
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

<style scoped>
:deep(.prose-custom) {
  color: #d4d4d4;
  font-size: 0.95rem;
  line-height: 1.8;
}
:deep(.prose-custom h1) {
  font-size: 1.85rem;
  font-weight: 800;
  color: #ffffff;
  margin-top: 1.75rem;
  margin-bottom: 0.75rem;
  line-height: 1.3;
  letter-spacing: -0.02em;
}
:deep(.prose-custom h2) {
  font-size: 1.4rem;
  font-weight: 700;
  color: #ffffff;
  margin-top: 1.5rem;
  margin-bottom: 0.75rem;
  border-bottom: 1px solid #262626;
  padding-bottom: 0.35rem;
  letter-spacing: -0.01em;
}
:deep(.prose-custom h3) {
  font-size: 1.15rem;
  font-weight: 600;
  color: #e5e5e5;
  margin-top: 1.25rem;
  margin-bottom: 0.5rem;
}
:deep(.prose-custom p) {
  margin-bottom: 1rem;
  color: #a3a3a3;
}
:deep(.prose-custom ul) {
  list-style-type: disc;
  padding-left: 1.5rem;
  margin-bottom: 1.25rem;
  margin-top: 0.5rem;
}
:deep(.prose-custom ol) {
  list-style-type: decimal;
  padding-left: 1.5rem;
  margin-bottom: 1.25rem;
  margin-top: 0.5rem;
}
:deep(.prose-custom li) {
  margin-bottom: 0.35rem;
  color: #d4d4d4;
}
:deep(.prose-custom strong) {
  color: #ffffff;
  font-weight: 700;
}
:deep(.prose-custom pre) {
  background-color: #0a0a0a;
  border: 1px solid #262626;
  border-radius: 0.75rem;
  padding: 1.25rem;
  overflow-x: auto;
  margin-top: 1rem;
  margin-bottom: 1.25rem;
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
  font-size: 0.85rem;
  color: #38bdf8;
  line-height: 1.6;
}
:deep(.prose-custom code) {
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
  font-size: 0.85rem;
  color: #38bdf8;
  background-color: #171717;
  padding: 0.15rem 0.4rem;
  border-radius: 0.25rem;
  border: 1px solid #262626;
}
:deep(.prose-custom pre code) {
  background-color: transparent;
  padding: 0;
  border: none;
  color: inherit;
}
:deep(.prose-custom a) {
  color: #60a5fa;
  text-decoration: underline;
}
</style>
