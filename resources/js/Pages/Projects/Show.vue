<template>
  <GuestLayout :canLogin="true" :settings="settings" :hideHeader="true" :hideFooter="true">
    <Head>
      <title>{{ `${project.title} - Kashif Khan Projects` }}</title>
      <meta name="description" :content="project.summary || 'Project case study and software architecture by Kashif Khan.'" />
      <meta property="og:title" :content="project.title" />
      <meta property="og:description" :content="project.summary || ''" />
      <meta v-if="project.image_path" property="og:image" :content="project.image_path" />
    </Head>

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

      <!-- Main Centered Layout Container matching Articles/Show.vue -->
      <div class="relative z-10 max-w-2xl mx-auto py-12 pb-28 sm:py-24 px-6 flex flex-col w-full">
        <section id="project-detail">
          
          <!-- Back to Projects Button -->
          <BlurFade :delay="BLUR_FADE_DELAY">
            <div class="flex justify-start gap-4 items-center">
              <Link
                :href="route('projects.index')"
                class="text-sm text-muted-foreground hover:text-foreground transition-colors border border-border rounded-lg px-2.5 py-1 inline-flex items-center gap-1.5 mb-6 group cursor-pointer select-none"
                aria-label="Back to Projects"
              >
                <ChevronLeft class="size-3.5 group-hover:-translate-x-0.5 transition-transform" />
                <span>Back to Projects</span>
              </Link>
            </div>
          </BlurFade>

          <!-- Project Header & Meta -->
          <BlurFade :delay="BLUR_FADE_DELAY * 2">
            <div class="flex flex-col gap-3">
              <div class="flex flex-wrap items-center gap-2">
                <span
                  v-if="project.is_featured"
                  class="px-2 py-0.5 rounded-md bg-foreground text-background text-[10px] font-mono font-bold uppercase tracking-wider"
                >
                  Featured
                </span>
                <span class="px-2 py-0.5 rounded-md bg-muted/60 text-muted-foreground text-[10px] font-mono border border-border/80">
                  {{ project.category }}
                </span>
              </div>

              <h1 class="title font-semibold text-3xl md:text-4xl tracking-tighter leading-tight text-foreground">
                {{ project.title }}
              </h1>

              <p v-if="project.summary" class="text-sm sm:text-base text-muted-foreground leading-relaxed">
                {{ project.summary }}
              </p>

              <!-- Action Links (Live Demo & GitHub Repo) -->
              <div class="flex flex-wrap items-center gap-2.5 pt-1">
                <a
                  v-if="project.demo_url"
                  :href="project.demo_url"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="h-8 px-3 rounded-md bg-primary hover:bg-primary/90 text-primary-foreground text-xs font-semibold inline-flex items-center gap-1.5 shadow-2xs transition-colors"
                >
                  <Globe class="size-3.5" />
                  <span>Launch Live Demo</span>
                  <ArrowUpRight class="size-3 opacity-70" />
                </a>

                <a
                  v-if="project.github_url"
                  :href="project.github_url"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="h-8 px-3 rounded-md border border-border bg-card hover:bg-muted text-foreground text-xs font-semibold inline-flex items-center gap-1.5 shadow-2xs transition-colors"
                >
                  <Github class="size-3.5" />
                  <span>Source Code</span>
                </a>
              </div>
            </div>

            <!-- Masked Gradient Divider (Exact match to portfolio) -->
            <div class="my-6 flex w-full items-center">
              <div
                class="flex-1 h-px bg-border"
                style="mask-image: linear-gradient(90deg, transparent, black 8%, black 92%, transparent); -webkit-mask-image: linear-gradient(90deg, transparent, black 8%, black 92%, transparent);"
              />
            </div>
          </BlurFade>

          <!-- Main Cover Image -->
          <BlurFade :delay="BLUR_FADE_DELAY * 2.5">
            <div
              v-if="project.image_path"
              class="mb-8 rounded-xl overflow-hidden border border-border bg-muted aspect-video shadow-xs"
            >
              <img :src="project.image_path" :alt="project.title" class="w-full h-full object-cover object-top" />
            </div>
          </BlurFade>

          <!-- Project Description / Case Study Body -->
          <BlurFade :delay="BLUR_FADE_DELAY * 3">
            <article
              class="prose max-w-full text-pretty font-sans leading-relaxed text-muted-foreground dark:prose-invert prose-headings:text-foreground prose-headings:font-semibold prose-headings:tracking-tight prose-a:text-foreground prose-a:underline prose-a:underline-offset-4 prose-code:text-foreground prose-code:bg-muted prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded prose-pre:border prose-pre:border-border prose-pre:bg-muted/50"
              v-html="project.description || project.summary || '<p>No detailed overview provided for this project.</p>'"
            ></article>

            <!-- Tech Stack Tags Bar -->
            <div v-if="project.tech_stack && project.tech_stack.length" class="flex flex-wrap gap-1.5 mt-8 pt-6 border-t border-border/40">
              <span
                v-for="tech in project.tech_stack"
                :key="tech"
                class="text-xs font-mono font-medium border border-border px-2.5 py-0.5 rounded-md bg-muted/40 text-muted-foreground"
              >
                {{ tech }}
              </span>
            </div>
          </BlurFade>

          <!-- Related Projects -->
          <BlurFade v-if="relatedProjects && relatedProjects.length" :delay="BLUR_FADE_DELAY * 4">
            <div class="mt-12 pt-8 border-t border-border/60 space-y-4">
              <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-foreground">More Projects</h3>
                <Link
                  :href="route('projects.index')"
                  class="text-xs font-medium text-muted-foreground hover:text-foreground transition-colors"
                >
                  View All &rarr;
                </Link>
              </div>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <Link
                  v-for="rel in relatedProjects.slice(0, 2)"
                  :key="rel.id"
                  :href="route('projects.show', rel.slug || rel.id)"
                  class="group flex flex-col gap-1 p-3.5 rounded-lg border border-border bg-card/60 hover:bg-muted/40 transition-colors"
                >
                  <span class="text-xs font-medium text-foreground group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors flex items-center justify-between">
                    <span>{{ rel.title }}</span>
                    <ChevronRight class="size-3 text-indigo-600 dark:text-indigo-400 opacity-60 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all" />
                  </span>
                  <p class="text-[11px] text-muted-foreground line-clamp-1">
                    {{ rel.summary || rel.category }}
                  </p>
                </Link>
              </div>
            </div>
          </BlurFade>

        </section>
      </div>
    </main>

    <!-- Floating Bottom Navigation Dock (Exact navbar.tsx from portfolio) -->
    <MagicDock :settings="settings" />
  </GuestLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import FlickeringGrid from '@/Components/FlickeringGrid.vue';
import BlurFade from '@/Components/BlurFade.vue';
import MagicDock from '@/Components/MagicDock.vue';
import { 
  ChevronLeft, 
  ChevronRight, 
  Globe, 
  Github, 
  ArrowUpRight 
} from 'lucide-vue-next';

const BLUR_FADE_DELAY = 0.04;

defineProps({
  project: {
    type: Object,
    required: true,
  },
  relatedProjects: {
    type: Array,
    default: () => [],
  },
  settings: Object,
});
</script>
