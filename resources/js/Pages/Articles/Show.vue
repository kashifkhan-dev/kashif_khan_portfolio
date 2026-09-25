<template>
  <GuestLayout :canLogin="true" :settings="settings" :hideHeader="true" :hideFooter="true">
    <Head>
      <title>{{ `${article.title} - Kashif Khan` }}</title>
      <meta name="description" :content="article.excerpt || article.summary || 'Technical software engineering article by Kashif Khan.'" />
      <meta property="og:title" :content="article.title" />
      <meta property="og:description" :content="article.excerpt || article.summary || ''" />
      <meta v-if="article.cover_image" property="og:image" :content="article.cover_image" />
    </Head>

    <main class="min-h-dvh flex flex-col relative z-10 bg-background text-foreground transition-colors duration-300 w-full overflow-x-hidden">
      <!-- Top Flickering Grid Background (Exact Stipple Fade from portfolio) -->
      <div class="absolute inset-0 top-0 left-0 right-0 h-[120px] overflow-hidden z-0 pointer-events-none">
        <FlickeringGrid
          class="h-full w-full"
          :squareSize="2"
          :gridGap="2"
          style="mask-image: linear-gradient(to bottom, black 20%, transparent 100%); -webkit-mask-image: linear-gradient(to bottom, black 20%, transparent 100%);"
        />
      </div>

      <!-- Main Centered Layout Container matching portfolio/src/app/blog/[slug]/page.tsx -->
      <div class="relative z-10 w-full max-w-2xl min-w-0 mx-auto py-8 sm:py-16 md:py-24 pb-36 sm:pb-44 px-4 sm:px-6 flex flex-col">
        <section id="blog-post" class="w-full min-w-0 max-w-full">
          <!-- Back to Blog Button -->
          <BlurFade :delay="BLUR_FADE_DELAY" class-name="w-full min-w-0 max-w-full">
            <div class="flex justify-start gap-4 items-center">
              <Link
                :href="route('blog.index')"
                class="text-sm text-muted-foreground hover:text-foreground transition-colors border border-border rounded-lg px-2.5 py-1 inline-flex items-center gap-1.5 mb-6 group cursor-pointer select-none"
                aria-label="Back to Blog"
              >
                <ChevronLeft class="size-3.5 group-hover:-translate-x-0.5 transition-transform" />
                <span>Back to Blog</span>
              </Link>
            </div>
          </BlurFade>

          <!-- Title and Metadata -->
          <BlurFade :delay="BLUR_FADE_DELAY * 2" class-name="w-full min-w-0 max-w-full">
            <div class="flex flex-col gap-3">
              <h1 class="title font-semibold text-2xl sm:text-3xl md:text-4xl tracking-tighter leading-tight text-foreground break-words">
                {{ article.title }}
              </h1>
              <div class="flex items-center gap-2 text-sm text-muted-foreground">
                <span>{{ formatDate(article.published_at || article.created_at) }}</span>
                <span v-if="article.read_time">&bull;</span>
                <span v-if="article.read_time">{{ article.read_time }} min read</span>
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

          <!-- Article Content Body -->
          <BlurFade :delay="BLUR_FADE_DELAY * 3" class-name="w-full min-w-0 max-w-full">
            <!-- Optional Cover Image -->
            <div
              v-if="article.cover_image"
              class="mb-8 rounded-xl overflow-hidden border border-border bg-muted aspect-video shadow-xs"
            >
              <img :src="article.cover_image" :alt="article.title" class="w-full h-full object-cover" />
            </div>

            <article
              class="prose prose-sm sm:prose-base max-w-full min-w-0 w-full text-pretty font-sans leading-relaxed text-muted-foreground dark:prose-invert prose-headings:text-foreground prose-headings:font-semibold prose-headings:tracking-tight prose-a:text-foreground prose-a:underline prose-a:underline-offset-4 break-words"
              v-html="article.content"
            ></article>

            <!-- Tags Bar -->
            <div v-if="articleTags.length" class="flex flex-wrap gap-1.5 mt-8 pt-6 border-t border-border/40">
              <span
                v-for="tag in articleTags"
                :key="tag"
                class="text-xs font-mono font-medium border border-border px-2.5 py-0.5 rounded-md bg-muted/40 text-muted-foreground"
              >
                #{{ tag }}
              </span>
            </div>
          </BlurFade>

          <!-- Previous / Next Navigation (Exact match to portfolio) -->
          <BlurFade v-if="previousArticle || nextArticle" :delay="BLUR_FADE_DELAY * 4" class-name="w-full min-w-0 max-w-full">
            <nav class="mt-12 pt-8 max-w-2xl border-t border-border/60">
              <div class="flex flex-col sm:flex-row justify-between gap-4">
                <Link
                  v-if="previousArticle"
                  :href="route('blog.show', previousArticle.slug || previousArticle.id)"
                  class="group flex-1 flex flex-col gap-1 p-4 rounded-lg border border-border hover:bg-muted/40 transition-colors"
                >
                  <span class="flex items-center gap-1 text-xs text-muted-foreground">
                    <ChevronLeft class="size-3" />
                    <span>Previous</span>
                  </span>
                  <span class="text-sm font-medium group-hover:text-foreground transition-colors whitespace-normal">
                    {{ previousArticle.title }}
                  </span>
                </Link>
                <div v-else class="hidden sm:block flex-1" />

                <Link
                  v-if="nextArticle"
                  :href="route('blog.show', nextArticle.slug || nextArticle.id)"
                  class="group flex-1 flex flex-col gap-1 p-4 rounded-lg border border-border hover:bg-muted/40 transition-colors text-right"
                >
                  <span class="flex items-center justify-end gap-1 text-xs text-muted-foreground">
                    <span>Next</span>
                    <ChevronRight class="size-3" />
                  </span>
                  <span class="text-sm font-medium group-hover:text-foreground transition-colors whitespace-normal">
                    {{ nextArticle.title }}
                  </span>
                </Link>
                <div v-else class="hidden sm:block flex-1" />
              </div>
            </nav>
          </BlurFade>
        </section>
      </div>
    </main>

    <!-- Floating Bottom Navigation Dock (Exact navbar.tsx from portfolio) -->
    <MagicDock :settings="settings" />
  </GuestLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import FlickeringGrid from '@/Components/FlickeringGrid.vue';
import BlurFade from '@/Components/BlurFade.vue';
import MagicDock from '@/Components/MagicDock.vue';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';

const BLUR_FADE_DELAY = 0.04;

const props = defineProps({
  article: {
    type: Object,
    required: true,
  },
  previousArticle: Object,
  nextArticle: Object,
  settings: Object,
});

const articleTags = computed(() => {
  const tags = props.article?.tags;
  if (Array.isArray(tags)) return tags;
  if (typeof tags === 'string' && tags.trim()) {
    try {
      const parsed = JSON.parse(tags);
      if (Array.isArray(parsed)) return parsed;
    } catch (e) {
      return tags.split(',').map(t => t.trim()).filter(Boolean);
    }
  }
  return [];
});

function formatDate(dateStr) {
  if (!dateStr) return '';
  const d = new Date(dateStr);
  return d.toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric',
  });
}
</script>

<style scoped>
:deep(.prose) {
  max-width: 100%;
  min-width: 0;
  overflow-wrap: break-word;
  word-wrap: break-word;
}

:deep(.prose pre) {
  max-width: 100% !important;
  width: 100% !important;
  min-width: 0 !important;
  overflow-x: auto !important;
  -webkit-overflow-scrolling: touch !important;
  padding: 0.875rem 1rem !important;
  border-radius: 0.75rem !important;
  background-color: hsl(var(--muted) / 0.6) !important;
  border: 1px solid hsl(var(--border)) !important;
  margin-top: 1.25rem !important;
  margin-bottom: 1.25rem !important;
}

:deep(.prose pre code) {
  display: block !important;
  width: max-content !important;
  min-width: 100% !important;
  white-space: pre !important;
  word-break: normal !important;
  overflow-wrap: normal !important;
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;
  font-size: 0.8rem !important;
  line-height: 1.6 !important;
  padding: 0 !important;
  background-color: transparent !important;
  border: none !important;
}

:deep(.prose code:not(pre code)) {
  word-break: break-word !important;
  white-space: normal !important;
  font-size: 0.825em !important;
  padding: 0.15rem 0.35rem !important;
  border-radius: 0.375rem !important;
  background-color: hsl(var(--muted)) !important;
  color: hsl(var(--foreground)) !important;
  border: 1px solid hsl(var(--border) / 0.6) !important;
}

:deep(.prose img) {
  max-width: 100% !important;
  height: auto !important;
  border-radius: 0.75rem !important;
}

:deep(.prose table) {
  display: block !important;
  width: 100% !important;
  overflow-x: auto !important;
  -webkit-overflow-scrolling: touch !important;
}

/* Custom sleek scrollbar for code blocks on mobile and desktop */
:deep(.prose pre::-webkit-scrollbar) {
  height: 6px;
}
:deep(.prose pre::-webkit-scrollbar-track) {
  background: transparent;
}
:deep(.prose pre::-webkit-scrollbar-thumb) {
  background: hsl(var(--muted-foreground) / 0.3);
  border-radius: 9999px;
}
:deep(.prose pre::-webkit-scrollbar-thumb:hover) {
  background: hsl(var(--muted-foreground) / 0.5);
}
</style>
