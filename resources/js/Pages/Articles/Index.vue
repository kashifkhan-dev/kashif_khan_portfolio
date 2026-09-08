<template>
  <GuestLayout :canLogin="true" :settings="settings">
    <Head title="Technical Articles & Architecture Writeups - Kashif Khan" />

    <div class="min-h-screen bg-white dark:bg-black text-slate-900 dark:text-neutral-100 transition-colors duration-300 py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header & Intro -->
        <div class="text-center space-y-4 max-w-3xl mx-auto pt-6">
          <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-[6px] bg-slate-100 dark:bg-neutral-900 border border-slate-200 dark:border-neutral-800 text-slate-800 dark:text-neutral-300 text-xs font-mono font-semibold">
            <BookOpen class="h-3.5 w-3.5 text-indigo-500" />
            <span>Engineering Blog &amp; Case Studies</span>
          </div>

          <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-[1.1]">
            Writing on Scalable Systems, Laravel &amp; Vue 3.
          </h1>

          <p class="text-base sm:text-lg text-slate-600 dark:text-neutral-400 leading-relaxed">
            In-depth architecture writeups, performance benchmarks, and real-world engineering patterns from production environments.
          </p>

          <!-- Search & Filter Controls -->
          <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
            <div class="relative w-full sm:w-80">
              <Search class="h-4 w-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-neutral-500" />
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search by keyword, topic, or stack..."
                class="w-full h-10 pl-10 pr-4 rounded-[6px] border border-slate-200 dark:border-neutral-800 bg-slate-50 dark:bg-neutral-900 text-xs text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-neutral-500 focus:outline-none focus:border-slate-900 dark:focus:border-white transition-colors"
              />
            </div>
          </div>

          <!-- Filter Topic Chips -->
          <div v-if="allTags && allTags.length" class="flex flex-wrap items-center justify-center gap-2 pt-2">
            <button
              @click="activeTag = 'all'"
              class="px-3 py-1 rounded-[6px] text-xs font-semibold transition-all cursor-pointer"
              :class="activeTag === 'all'
                ? 'bg-slate-900 text-white dark:bg-white dark:text-black shadow-xs'
                : 'bg-slate-100 dark:bg-neutral-900 text-slate-600 dark:text-neutral-400 hover:text-slate-900 dark:hover:text-white border border-slate-200/80 dark:border-neutral-800'"
            >
              All Topics
            </button>
            <button
              v-for="tag in allTags"
              :key="tag"
              @click="activeTag = tag"
              class="px-3 py-1 rounded-[6px] text-xs font-semibold transition-all cursor-pointer"
              :class="activeTag === tag
                ? 'bg-slate-900 text-white dark:bg-white dark:text-black shadow-xs'
                : 'bg-slate-100 dark:bg-neutral-900 text-slate-600 dark:text-neutral-400 hover:text-slate-900 dark:hover:text-white border border-slate-200/80 dark:border-neutral-800'"
            >
              {{ tag }}
            </button>
          </div>
        </div>

        <!-- Empty State -->
        <div v-if="!filteredArticles.length" class="py-20 text-center space-y-3">
          <BookOpen class="h-12 w-12 text-slate-300 dark:text-neutral-700 mx-auto" />
          <h3 class="text-base font-bold text-slate-700 dark:text-neutral-300">No articles match your search</h3>
          <p class="text-xs text-slate-500 dark:text-neutral-500">Try clearing filters or searching for another term.</p>
          <button
            @click="clearFilters"
            class="px-4 py-2 text-xs font-bold rounded-[6px] bg-slate-900 text-white dark:bg-white dark:text-black hover:opacity-90 transition-all cursor-pointer"
          >
            Clear Filters
          </button>
        </div>

        <div v-else class="space-y-12">
          <!-- Featured Lead Article Banner (First item when no active search) -->
          <div
            v-if="featuredArticle && !searchQuery && activeTag === 'all'"
            class="group rounded-[8px] border border-slate-200 dark:border-neutral-800 bg-slate-50/50 dark:bg-neutral-950 overflow-hidden shadow-sm hover:border-slate-300 dark:hover:border-neutral-700 transition-all"
          >
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">
              <!-- Cover Image (5 cols) -->
              <div class="lg:col-span-5 h-64 lg:h-auto overflow-hidden relative bg-neutral-900">
                <img
                  v-if="featuredArticle.cover_image"
                  :src="featuredArticle.cover_image"
                  :alt="featuredArticle.title"
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent lg:hidden"></div>
                <span class="absolute top-4 left-4 px-2.5 py-1 rounded-[4px] text-[11px] font-bold uppercase tracking-wider bg-slate-900/90 text-white dark:bg-white/90 dark:text-black shadow-md backdrop-blur-xs">
                  Featured Deep Dive
                </span>
              </div>

              <!-- Content (7 cols) -->
              <div class="lg:col-span-7 p-6 sm:p-8 lg:p-10 flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                  <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 dark:text-neutral-400">
                    <span class="flex items-center gap-1">
                      <Clock class="h-3.5 w-3.5" />
                      <span>{{ featuredArticle.read_time || 5 }} min read</span>
                    </span>
                    <span>&bull;</span>
                    <span>{{ formatDate(featuredArticle.published_at) }}</span>
                    <span>&bull;</span>
                    <span class="flex items-center gap-1">
                      <Eye class="h-3.5 w-3.5" />
                      <span>{{ featuredArticle.views_count || 0 }} reads</span>
                    </span>
                  </div>

                  <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                    <Link :href="route('articles.show', featuredArticle.slug)">
                      {{ featuredArticle.title }}
                    </Link>
                  </h2>

                  <p class="text-sm sm:text-base text-slate-600 dark:text-neutral-300 leading-relaxed line-clamp-3">
                    {{ featuredArticle.excerpt }}
                  </p>

                  <div v-if="featuredArticle.tags && featuredArticle.tags.length" class="flex flex-wrap gap-1.5 pt-1">
                    <span
                      v-for="tag in featuredArticle.tags"
                      :key="tag"
                      class="px-2.5 py-0.5 rounded-[4px] text-xs font-medium bg-white dark:bg-neutral-900 border border-slate-200 dark:border-neutral-800 text-slate-700 dark:text-neutral-300"
                    >
                      {{ tag }}
                    </span>
                  </div>
                </div>

                <div class="pt-4 border-t border-slate-200/80 dark:border-neutral-800/80">
                  <Link
                    :href="route('articles.show', featuredArticle.slug)"
                    class="inline-flex items-center gap-2 text-sm font-bold text-slate-900 dark:text-white group-hover:translate-x-1 transition-transform"
                  >
                    <span>Read Complete Case Study</span>
                    <ArrowRight class="h-4 w-4" />
                  </Link>
                </div>
              </div>
            </div>
          </div>

          <!-- Articles Grid (Remaining items) -->
          <div class="space-y-6">
            <h2 v-if="!searchQuery && activeTag === 'all' && gridArticles.length" class="text-xs font-sans font-semibold uppercase tracking-wider text-slate-500 dark:text-neutral-400">
              More Architecture Notes &amp; Tutorials
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <article
                v-for="article in (searchQuery || activeTag !== 'all' ? filteredArticles : gridArticles)"
                :key="article.id"
                class="rounded-[8px] border border-slate-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 overflow-hidden shadow-xs hover:border-slate-300 dark:hover:border-neutral-700 hover:shadow-md transition-all flex flex-col justify-between group"
              >
                <div>
                  <!-- Thumbnail -->
                  <div class="w-full h-48 overflow-hidden bg-neutral-100 dark:bg-neutral-900 relative">
                    <img
                      v-if="article.cover_image"
                      :src="article.cover_image"
                      :alt="article.title"
                      class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                    />
                    <div v-else class="w-full h-full flex items-center justify-center text-slate-400 dark:text-neutral-600">
                      <BookOpen class="h-8 w-8" />
                    </div>
                  </div>

                  <!-- Article Body -->
                  <div class="p-5 space-y-2.5">
                    <div class="flex items-center justify-between text-[11px] text-slate-500 dark:text-neutral-400">
                      <span class="flex items-center gap-1">
                        <Clock class="h-3 w-3" />
                        <span>{{ article.read_time || 5 }} min read</span>
                      </span>
                      <span>{{ formatDate(article.published_at) }}</span>
                    </div>

                    <h3 class="text-base font-bold text-slate-900 dark:text-white line-clamp-2 leading-snug group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                      <Link :href="route('articles.show', article.slug)">
                        {{ article.title }}
                      </Link>
                    </h3>

                    <p class="text-xs text-slate-600 dark:text-neutral-400 line-clamp-3 leading-relaxed">
                      {{ article.excerpt }}
                    </p>
                  </div>
                </div>

                <!-- Footer: Tags & Read Link -->
                <div class="p-5 pt-0 space-y-3">
                  <div v-if="article.tags && article.tags.length" class="flex flex-wrap gap-1">
                    <span
                      v-for="t in article.tags.slice(0, 3)"
                      :key="t"
                      class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 dark:bg-neutral-900 border border-slate-200/60 dark:border-neutral-800 text-slate-600 dark:text-neutral-400"
                    >
                      {{ t }}
                    </span>
                  </div>

                  <Link
                    :href="route('articles.show', article.slug)"
                    class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors"
                  >
                    <span>Read Article</span>
                    <ArrowRight class="h-3.5 w-3.5 group-hover:translate-x-1 transition-transform" />
                  </Link>
                </div>
              </article>
            </div>
          </div>
        </div>

        <!-- Back to Portfolio Link / CTA -->
        <div class="pt-6 text-center">
          <Link
            href="/"
            class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-slate-900 dark:text-neutral-400 dark:hover:text-white transition-colors"
          >
            <ArrowLeft class="h-4 w-4" />
            <span>Back to Portfolio Showcase</span>
          </Link>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {
  BookOpen,
  Search,
  Clock,
  Eye,
  ArrowRight,
  ArrowLeft,
} from 'lucide-vue-next';

const props = defineProps({
  articles: {
    type: Array,
    default: () => [],
  },
  allTags: {
    type: Array,
    default: () => [],
  },
  settings: {
    type: Object,
    default: () => ({}),
  },
});

const searchQuery = ref('');
const activeTag = ref('all');

const filteredArticles = computed(() => {
  let list = props.articles;

  if (activeTag.value !== 'all') {
    list = list.filter(a => a.tags && a.tags.includes(activeTag.value));
  }

  if (searchQuery.value.trim()) {
    const q = searchQuery.value.toLowerCase();
    list = list.filter(a => {
      const matchTitle = a.title?.toLowerCase().includes(q);
      const matchExcerpt = a.excerpt?.toLowerCase().includes(q);
      const matchContent = a.content?.toLowerCase().includes(q);
      const matchTag = a.tags?.some(t => t.toLowerCase().includes(q));
      return matchTitle || matchExcerpt || matchContent || matchTag;
    });
  }

  return list;
});

const featuredArticle = computed(() => {
  return props.articles.length > 0 ? props.articles[0] : null;
});

const gridArticles = computed(() => {
  return props.articles.length > 1 ? props.articles.slice(1) : [];
});

function clearFilters() {
  searchQuery.value = '';
  activeTag.value = 'all';
}

function formatDate(dateStr) {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric',
  });
}
</script>
