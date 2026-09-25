<template>
  <GuestLayout :canLogin="true" :settings="settings" :hideHeader="true" :hideFooter="true">
    <Head title="Projects - Software Architecture & Full-Stack Applications" />

    <main class="min-h-dvh flex flex-col relative z-10 bg-background text-foreground transition-colors duration-300">
      <!-- Top Flickering Grid Background (Exact Stipple Fade from portfolio) -->
      <div class="absolute inset-0 top-0 left-0 right-0 h-[120px] overflow-hidden z-0 pointer-events-none">
        <FlickeringGrid
          class="h-full w-full"
          :squareSize="2"
          :gridGap="2"
          style="mask-image: linear-gradient(to bottom, black 20%, transparent 100%); -webkit-mask-image: linear-gradient(to bottom, black 20%, transparent 100%);"
        />
      </div>

      <!-- Main Centered Layout Container matching portfolio/src/app/blog/page.tsx -->
      <div class="relative z-10 max-w-2xl mx-auto py-12 pb-28 sm:py-24 px-6 flex flex-col w-full">
        <section id="projects">
          <!-- Page Header -->
          <BlurFade :delay="BLUR_FADE_DELAY">
            <div class="mb-6">
              <h1 class="text-2xl font-semibold tracking-tight mb-2 text-foreground flex items-center">
                <span>Projects</span>
                <span class="ml-2 bg-card border border-border rounded-md px-2 py-0.5 text-muted-foreground text-xs font-mono font-normal">
                  {{ filteredProjects.length }} {{ filteredProjects.length === 1 ? 'project' : 'projects' }}
                </span>
              </h1>
              <p class="text-sm text-muted-foreground">
                A curated collection of full-stack platforms, cloud architectures, and open-source applications.
              </p>
            </div>
          </BlurFade>

          <!-- Search & Category Filters (Minimalist Shadcn Bar) -->
          <BlurFade :delay="BLUR_FADE_DELAY * 1.5">
            <div class="flex flex-col gap-3 mb-8">
              <!-- Search Bar -->
              <div class="relative w-full">
                <Search class="h-3.5 w-3.5 text-muted-foreground absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" />
                <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Filter by name, tech stack, or keywords..."
                  class="w-full h-9 pl-9 pr-3 rounded-lg bg-card/60 border border-border text-foreground text-xs placeholder:text-muted-foreground outline-none focus:outline-none ring-0 focus:ring-0 focus-visible:ring-0 focus:border-neutral-400 dark:focus:border-neutral-600 transition-colors shadow-2xs"
                />
              </div>

              <!-- Category Pills -->
              <div v-if="availableCategories.length > 2" class="flex flex-wrap items-center gap-1.5 pt-0.5">
                <button
                  v-for="cat in availableCategories"
                  :key="cat"
                  @click="activeCategory = cat"
                  type="button"
                  class="px-2.5 py-1 rounded-md text-[11px] font-medium transition-all cursor-pointer"
                  :class="activeCategory === cat
                    ? 'bg-foreground text-background font-semibold shadow-xs'
                    : 'bg-card border border-border/80 text-muted-foreground hover:text-foreground hover:bg-muted/60'"
                >
                  {{ cat }}
                </button>
              </div>
            </div>
          </BlurFade>

          <!-- Numbered Project List (Exact styling from Blog Index) -->
          <div v-if="paginatedProjects.length > 0" class="flex flex-col gap-6">
            <div class="flex flex-col gap-3.5">
              <BlurFade
                v-for="(project, id) in paginatedProjects"
                :key="project.slug || project.id"
                :delay="BLUR_FADE_DELAY * 2 + id * 0.05"
              >
                <div class="p-3.5 rounded-xl border border-border/80 bg-card/60 hover:bg-card/90 hover:border-border transition-all duration-200 group shadow-2xs">
                  <div class="flex items-start gap-x-3">
                    <!-- Project Number Prefix -->
                    <span class="text-xs font-mono tabular-nums font-medium mt-[3px] text-muted-foreground group-hover:text-foreground transition-colors shrink-0">
                      {{ String((currentPage - 1) * PAGE_SIZE + id + 1).padStart(2, '0') }}.
                    </span>

                    <div class="flex flex-col gap-y-1.5 flex-1 min-w-0">
                      <!-- Project Title & Link -->
                      <div class="flex items-start justify-between gap-3">
                        <Link
                          :href="route('projects.show', project.slug || project.id)"
                          class="tracking-tight text-lg font-medium text-foreground group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors inline-flex items-center cursor-pointer"
                        >
                          <span>{{ project.title }}</span>
                          <ChevronRight
                            class="ml-1 inline-block size-4 stroke-[2.5] text-indigo-600 dark:text-indigo-400 opacity-0 -translate-x-2 transition-all duration-200 group-hover:opacity-100 group-hover:translate-x-0"
                            aria-hidden="true"
                          />
                        </Link>

                        <!-- Quick External Action Icons -->
                        <div class="flex items-center gap-1.5 shrink-0 opacity-70 group-hover:opacity-100 transition-opacity">
                          <a
                            v-if="project.demo_url"
                            :href="project.demo_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="p-1 rounded-md text-muted-foreground hover:text-foreground hover:bg-muted/80 transition-colors"
                            title="Live Demo"
                          >
                            <Globe class="size-3.5" />
                          </a>
                          <a
                            v-if="project.github_url"
                            :href="project.github_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="p-1 rounded-md text-muted-foreground hover:text-foreground hover:bg-muted/80 transition-colors"
                            title="Source Code"
                          >
                            <Github class="size-3.5" />
                          </a>
                        </div>
                      </div>

                      <!-- Project Summary -->
                      <p class="text-xs text-muted-foreground leading-relaxed line-clamp-2">
                        {{ project.summary || project.description }}
                      </p>

                      <!-- Metadata: Category & Tech Stack Chips -->
                      <div class="flex flex-wrap items-center gap-1.5 pt-1">
                        <span class="text-[10px] font-mono font-semibold border border-border/80 px-2 py-0.5 rounded-md bg-muted/60 text-foreground">
                          {{ project.category }}
                        </span>

                        <span
                          v-for="tech in (project.tech_stack || []).slice(0, 4)"
                          :key="tech"
                          class="text-[10px] font-mono border border-border/60 px-1.5 py-0.5 rounded-md bg-card text-muted-foreground"
                        >
                          {{ tech }}
                        </span>

                        <span v-if="(project.tech_stack || []).length > 4" class="text-[10px] text-muted-foreground font-mono">
                          +{{ project.tech_stack.length - 4 }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </BlurFade>
            </div>

            <!-- Pagination Controls -->
            <BlurFade v-if="totalPages > 1" :delay="BLUR_FADE_DELAY * 3">
              <div class="flex gap-3 flex-row items-center justify-between mt-6 pt-4 border-t border-border/40 select-none">
                <div class="text-xs text-muted-foreground font-mono">
                  Page {{ currentPage }} of {{ totalPages }}
                </div>
                <div class="flex gap-2 sm:justify-end">
                  <button
                    type="button"
                    :disabled="currentPage <= 1"
                    @click="goToPage(currentPage - 1)"
                    class="px-3 py-1.5 text-xs font-medium rounded-md border border-border bg-card text-foreground hover:bg-muted disabled:opacity-40 disabled:cursor-not-allowed transition-colors cursor-pointer"
                  >
                    Previous
                  </button>
                  <button
                    type="button"
                    :disabled="currentPage >= totalPages"
                    @click="goToPage(currentPage + 1)"
                    class="px-3 py-1.5 text-xs font-medium rounded-md border border-border bg-card text-foreground hover:bg-muted disabled:opacity-40 disabled:cursor-not-allowed transition-colors cursor-pointer"
                  >
                    Next
                  </button>
                </div>
              </div>
            </BlurFade>
          </div>

          <!-- Empty State -->
          <div v-else class="py-12 text-left">
            <p class="text-sm text-muted-foreground">No projects match the current filter.</p>
            <button
              v-if="searchQuery || activeCategory !== 'All'"
              @click="resetFilters"
              class="mt-3 text-xs font-semibold text-primary underline underline-offset-4 cursor-pointer"
            >
              Reset filters
            </button>
          </div>
        </section>
      </div>
    </main>

    <!-- Floating Bottom Navigation Dock (Exact navbar.tsx from portfolio) -->
    <MagicDock :settings="settings" />
  </GuestLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import FlickeringGrid from '@/Components/FlickeringGrid.vue';
import BlurFade from '@/Components/BlurFade.vue';
import MagicDock from '@/Components/MagicDock.vue';
import { ChevronRight, Search, Globe, Github } from 'lucide-vue-next';

const BLUR_FADE_DELAY = 0.04;

const props = defineProps({
  projects: {
    type: Array,
    default: () => [],
  },
  settings: Object,
});

const PAGE_SIZE = 6;
const currentPage = ref(1);
const searchQuery = ref('');
const activeCategory = ref('All');

const availableCategories = computed(() => {
  const cats = new Set();
  props.projects.forEach(p => {
    if (p.category) cats.add(p.category);
  });
  return ['All', ...Array.from(cats)];
});

const filteredProjects = computed(() => {
  let list = [...props.projects];

  // Filter by category
  if (activeCategory.value !== 'All') {
    list = list.filter(p => p.category === activeCategory.value);
  }

  // Filter by search query
  if (searchQuery.value.trim()) {
    const q = searchQuery.value.toLowerCase();
    list = list.filter(p => {
      const matchTitle = (p.title || '').toLowerCase().includes(q);
      const matchDesc = (p.summary || p.description || '').toLowerCase().includes(q);
      const matchTech = Array.isArray(p.tech_stack) && p.tech_stack.some(t => t.toLowerCase().includes(q));
      return matchTitle || matchDesc || matchTech;
    });
  }

  // Preserve order or sort by order/latest
  return list.sort((a, b) => (a.order || 0) - (b.order || 0));
});

const totalPages = computed(() => {
  return Math.ceil(filteredProjects.value.length / PAGE_SIZE) || 1;
});

const paginatedProjects = computed(() => {
  const start = (currentPage.value - 1) * PAGE_SIZE;
  return filteredProjects.value.slice(start, start + PAGE_SIZE);
});

function goToPage(page) {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
}

function resetFilters() {
  searchQuery.value = '';
  activeCategory.value = 'All';
  currentPage.value = 1;
}
</script>
