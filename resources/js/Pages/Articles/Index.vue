<template>
  <GuestLayout :canLogin="true" :settings="settings" :hideHeader="true" :hideFooter="true">
    <Head title="Blog - Thoughts on Software Engineering & Architecture" />

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
      <div class="relative z-10 w-full max-w-2xl min-w-0 mx-auto py-8 sm:py-16 md:py-24 pb-36 sm:pb-40 px-4 sm:px-6 flex flex-col">
        <section id="blog" class="w-full min-w-0">
          <!-- Page Header -->
          <BlurFade :delay="BLUR_FADE_DELAY">
            <div class="mb-8">
              <h1 class="text-2xl font-semibold tracking-tight mb-2 text-foreground flex items-center">
                <span>Blog</span>
                <span class="ml-2 bg-card border border-border rounded-md px-2 py-0.5 text-muted-foreground text-xs font-mono font-normal">
                  {{ sortedArticles.length }} {{ sortedArticles.length === 1 ? 'post' : 'posts' }}
                </span>
              </h1>
              <p class="text-sm text-muted-foreground">
                My thoughts on software development, life, and more.
              </p>
            </div>
          </BlurFade>

          <!-- Numbered Post List (Exact styling from portfolio) -->
          <div v-if="paginatedArticles.length > 0" class="flex flex-col gap-6">
            <div class="flex flex-col gap-5">
              <BlurFade
                v-for="(post, id) in paginatedArticles"
                :key="post.slug || post.id"
                :delay="BLUR_FADE_DELAY * 2 + id * 0.05"
              >
                <Link
                  :href="route('blog.show', post.slug || post.id)"
                  class="flex items-start gap-x-2 group cursor-pointer focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                >
                  <span class="text-xs font-mono tabular-nums font-medium mt-[5px] text-muted-foreground group-hover:text-foreground transition-colors">
                    {{ String((currentPage - 1) * PAGE_SIZE + id + 1).padStart(2, '0') }}.
                  </span>
                  <div class="flex flex-col gap-y-1.5 flex-1 min-w-0">
                    <p class="tracking-tight text-lg font-medium text-foreground">
                      <span class="group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors inline-flex items-center">
                        {{ post.title }}
                        <ChevronRight
                          class="ml-1 inline-block size-4 stroke-[2.5] text-indigo-600 dark:text-indigo-400 opacity-0 -translate-x-2 transition-all duration-200 group-hover:opacity-100 group-hover:translate-x-0"
                          aria-hidden="true"
                        />
                      </span>
                    </p>
                    <p class="text-xs text-muted-foreground">
                      {{ formatDate(post.published_at || post.created_at) }}
                    </p>
                  </div>
                </Link>
              </BlurFade>
            </div>

            <!-- Pagination Controls -->
            <BlurFade v-if="totalPages > 1" :delay="BLUR_FADE_DELAY * 3">
              <div class="flex gap-3 flex-row items-center justify-between mt-8 pt-4 border-t border-border/40 select-none">
                <div class="text-sm text-muted-foreground font-mono">
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
            <p class="text-sm text-muted-foreground">No posts found.</p>
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
import { ChevronRight } from 'lucide-vue-next';

const BLUR_FADE_DELAY = 0.04;

const props = defineProps({
  articles: {
    type: Array,
    default: () => [],
  },
  settings: Object,
});

const PAGE_SIZE = 5;
const currentPage = ref(1);

const sortedArticles = computed(() => {
  const list = [...props.articles];
  return list.sort((a, b) => {
    const dateA = new Date(a.published_at || a.created_at || 0).getTime();
    const dateB = new Date(b.published_at || b.created_at || 0).getTime();
    return dateB - dateA;
  });
});

const totalPages = computed(() => {
  return Math.ceil(sortedArticles.value.length / PAGE_SIZE) || 1;
});

const paginatedArticles = computed(() => {
  const start = (currentPage.value - 1) * PAGE_SIZE;
  return sortedArticles.value.slice(start, start + PAGE_SIZE);
});

function goToPage(page) {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
}

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
