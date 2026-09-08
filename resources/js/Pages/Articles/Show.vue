<template>
  <GuestLayout :canLogin="true" :settings="settings">
    <Head>
      <title>{{ `${article.title} - Kashif Khan Dev` }}</title>
      <meta name="description" :content="article.excerpt || 'Technical software engineering article by Kashif Khan.'" />
    </Head>

    <div class="min-h-screen bg-white dark:bg-black text-slate-900 dark:text-neutral-100 transition-colors duration-300 py-12">
      <article class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <!-- Top Back Navigation -->
        <div class="flex items-center justify-between border-b border-slate-200 dark:border-neutral-800 pb-4">
          <Link
            :href="route('articles.index')"
            class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-neutral-400 hover:text-slate-900 dark:hover:text-white transition-colors"
          >
            <ArrowLeft class="h-4 w-4" />
            <span>All Articles &amp; Case Studies</span>
          </Link>

          <!-- Draft Indicator for Admin Preview -->
          <span
            v-if="!article.is_published"
            class="px-2.5 py-0.5 rounded text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-400 border border-amber-300 dark:border-amber-800"
          >
            Draft Preview Mode
          </span>
        </div>

        <!-- Article Header -->
        <header class="space-y-6">
          <!-- Tags -->
          <div v-if="article.tags && article.tags.length" class="flex flex-wrap items-center gap-2">
            <span
              v-for="tag in article.tags"
              :key="tag"
              class="px-2.5 py-1 rounded-[4px] text-xs font-semibold bg-slate-100 dark:bg-neutral-900 text-slate-800 dark:text-neutral-200 border border-slate-200/80 dark:border-neutral-800"
            >
              {{ tag }}
            </span>
          </div>

          <!-- Title -->
          <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-[1.15]">
            {{ article.title }}
          </h1>

          <!-- Excerpt -->
          <p v-if="article.excerpt" class="text-base sm:text-lg text-slate-600 dark:text-neutral-300 leading-relaxed font-sans">
            {{ article.excerpt }}
          </p>

          <!-- Author, Date & Meta Bar -->
          <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-slate-200 dark:border-neutral-800 text-xs text-slate-500 dark:text-neutral-400">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-[6px] bg-slate-900 dark:bg-white text-white dark:text-black flex items-center justify-center font-bold text-xs shrink-0 shadow-xs">
                KK
              </div>
              <div>
                <span class="font-bold text-slate-900 dark:text-white text-sm">Kashif Khan</span>
                <div class="flex items-center gap-2 mt-0.5 text-[11px]">
                  <span>{{ formatDate(article.published_at || article.created_at) }}</span>
                  <span>&bull;</span>
                  <span class="flex items-center gap-1">
                    <Clock class="h-3 w-3" />
                    <span>{{ article.read_time || 5 }} min read</span>
                  </span>
                  <span>&bull;</span>
                  <span class="flex items-center gap-1">
                    <Eye class="h-3 w-3" />
                    <span>{{ article.views_count || 0 }} reads</span>
                  </span>
                </div>
              </div>
            </div>

            <!-- Share Buttons -->
            <div class="flex items-center gap-2">
              <button
                @click="copyArticleLink"
                class="px-3 py-1.5 rounded-[6px] border border-slate-200 dark:border-neutral-800 hover:bg-slate-50 dark:hover:bg-neutral-900 text-xs font-semibold text-slate-700 dark:text-neutral-300 transition-colors flex items-center gap-1.5 cursor-pointer"
                title="Copy Link to Clipboard"
              >
                <Check v-if="linkCopied" class="h-3.5 w-3.5 text-emerald-500" />
                <Share2 v-else class="h-3.5 w-3.5" />
                <span>{{ linkCopied ? 'Copied!' : 'Share' }}</span>
              </button>
            </div>
          </div>
        </header>

        <!-- Cover Banner Image -->
        <div v-if="article.cover_image" class="w-full h-72 sm:h-96 lg:h-[460px] rounded-[8px] overflow-hidden shadow-lg border border-slate-200 dark:border-neutral-800 bg-neutral-900">
          <img
            :src="article.cover_image"
            :alt="article.title"
            class="w-full h-full object-cover"
          />
        </div>

        <!-- Article Prose Content -->
        <div
          class="article-content prose dark:prose-invert max-w-none text-slate-800 dark:text-neutral-200 leading-relaxed space-y-6"
          v-html="article.content"
        ></div>

        <!-- Author Signature Card -->
        <div class="p-6 sm:p-8 rounded-[8px] border border-slate-200 dark:border-neutral-800 bg-slate-50/60 dark:bg-neutral-950 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 shadow-xs">
          <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-[6px] bg-slate-900 text-white dark:bg-white dark:text-black flex items-center justify-center font-extrabold text-base shrink-0 shadow-md">
              KK
            </div>
            <div class="space-y-1">
              <h3 class="font-extrabold text-base text-slate-900 dark:text-white">Authored by Kashif Khan</h3>
              <p class="text-xs text-slate-600 dark:text-neutral-400 max-w-md">
                Senior Full-Stack Architect specializing in high-performance Laravel, Vue 3, Inertia.js, and cloud systems.
              </p>
            </div>
          </div>

          <div class="flex items-center gap-3 shrink-0">
            <a
              href="/#contact"
              class="px-4 py-2 rounded-[6px] bg-slate-900 text-white dark:bg-white dark:text-black font-bold text-xs hover:opacity-90 transition-all shadow-md"
            >
              Get in Touch
            </a>
            <a
              :href="settings?.linkedin_url || 'https://linkedin.com'"
              target="_blank"
              class="p-2 rounded-[6px] border border-slate-200 dark:border-neutral-800 text-slate-600 hover:text-slate-900 dark:text-neutral-400 dark:hover:text-white transition-colors"
            >
              <Linkedin class="h-4 w-4" />
            </a>
            <a
              :href="settings?.github_url || 'https://github.com'"
              target="_blank"
              class="p-2 rounded-[6px] border border-slate-200 dark:border-neutral-800 text-slate-600 hover:text-slate-900 dark:text-neutral-400 dark:hover:text-white transition-colors"
            >
              <Github class="h-4 w-4" />
            </a>
          </div>
        </div>

        <!-- Related Articles -->
        <section v-if="relatedArticles && relatedArticles.length" class="pt-8 space-y-6 border-t border-slate-200 dark:border-neutral-800">
          <h2 class="text-xs font-sans font-semibold uppercase tracking-wider text-slate-500 dark:text-neutral-400">
            More Technical Case Studies
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <article
              v-for="rel in relatedArticles"
              :key="rel.id"
              class="rounded-md border border-slate-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 overflow-hidden shadow-xs hover:border-slate-300 dark:hover:border-neutral-700 hover:shadow-md transition-all flex flex-col justify-between group"
            >
              <div>
                <!-- Thumbnail -->
                <div class="w-full h-44 overflow-hidden bg-neutral-100 dark:bg-neutral-900 relative">
                  <img
                    v-if="rel.cover_image"
                    :src="rel.cover_image"
                    :alt="rel.title"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                  />
                  <div v-else class="w-full h-full flex items-center justify-center text-slate-400 dark:text-neutral-600">
                    <BookOpen class="h-8 w-8" />
                  </div>
                </div>

                <!-- Content -->
                <div class="p-5 space-y-2.5">
                  <div class="flex items-center justify-between text-[11px] text-slate-500 dark:text-neutral-400">
                    <span class="flex items-center gap-1">
                      <Clock class="h-3 w-3" />
                      <span>{{ rel.read_time || 5 }} min read</span>
                    </span>
                    <span>{{ formatDate(rel.published_at || rel.created_at) }}</span>
                  </div>

                  <h3 class="text-base font-bold text-slate-900 dark:text-white line-clamp-2 leading-snug group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                    <Link :href="route('articles.show', rel.slug)">
                      {{ rel.title }}
                    </Link>
                  </h3>

                  <p class="text-xs text-slate-600 dark:text-neutral-400 line-clamp-3 leading-relaxed">
                    {{ rel.excerpt }}
                  </p>
                </div>
              </div>

              <!-- Card Footer -->
              <div class="p-5 pt-0 space-y-3 border-t border-slate-100 dark:border-neutral-900/80">
                <div v-if="rel.tags && rel.tags.length" class="flex flex-wrap gap-1 pt-3">
                  <span
                    v-for="t in rel.tags.slice(0, 3)"
                    :key="t"
                    class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 dark:bg-neutral-900 border border-slate-200/60 dark:border-neutral-800 text-slate-600 dark:text-neutral-400"
                  >
                    {{ t }}
                  </span>
                </div>

                <Link
                  :href="route('articles.show', rel.slug)"
                  class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors pt-1"
                >
                  <span>Read Full Article</span>
                  <ArrowRight class="h-3.5 w-3.5 group-hover:translate-x-1 transition-transform" />
                </Link>
              </div>
            </article>
          </div>
        </section>
      </article>
    </div>
  </GuestLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {
  ArrowLeft,
  ArrowRight,
  Clock,
  Eye,
  Share2,
  Check,
  Linkedin,
  Github,
  BookOpen,
} from 'lucide-vue-next';

const props = defineProps({
  article: {
    type: Object,
    required: true,
  },
  relatedArticles: {
    type: Array,
    default: () => [],
  },
  settings: {
    type: Object,
    default: () => ({}),
  },
});

const linkCopied = ref(false);

function copyArticleLink() {
  if (navigator.clipboard) {
    navigator.clipboard.writeText(window.location.href);
    linkCopied.value = true;
    setTimeout(() => {
      linkCopied.value = false;
    }, 2500);
  }
}

function formatDate(dateStr) {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('en-US', {
    month: 'long',
    day: 'numeric',
    year: 'numeric',
  });
}
</script>

<style>
/* Custom clean styling for rich text article content */
.article-content h2 {
  font-size: 1.625rem;
  font-weight: 800;
  letter-spacing: -0.025em;
  margin-top: 2rem;
  margin-bottom: 0.75rem;
  color: inherit;
}

.article-content h3 {
  font-size: 1.25rem;
  font-weight: 700;
  letter-spacing: -0.015em;
  margin-top: 1.5rem;
  margin-bottom: 0.5rem;
  color: inherit;
}

.article-content p {
  margin-bottom: 1.25rem;
  line-height: 1.8;
  font-size: 1.05rem;
}

.article-content pre {
  background-color: #0f172a;
  color: #f8fafc;
  padding: 1.25rem;
  border-radius: 0.75rem;
  overflow-x: auto;
  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
  font-size: 0.875rem;
  line-height: 1.6;
  margin: 1.5rem 0;
  border: 1px solid rgba(255, 255, 255, 0.1);
}

.article-content code {
  background-color: rgba(99, 102, 241, 0.1);
  color: #6366f1;
  padding: 0.15rem 0.4rem;
  border-radius: 0.375rem;
  font-size: 0.875em;
  font-family: ui-monospace, SFMono-Regular, monospace;
}

.dark .article-content code {
  background-color: rgba(99, 102, 241, 0.2);
  color: #a5b4fc;
}

.article-content pre code {
  background-color: transparent;
  color: inherit;
  padding: 0;
}

.article-content ul, .article-content ol {
  padding-left: 1.5rem;
  margin-bottom: 1.25rem;
}

.article-content ul {
  list-style-type: disc;
}

.article-content ol {
  list-style-type: decimal;
}

.article-content li {
  margin-bottom: 0.5rem;
  line-height: 1.7;
}

.article-content blockquote {
  border-left: 4px solid #6366f1;
  padding-left: 1.25rem;
  font-style: italic;
  margin: 1.5rem 0;
  color: rgba(100, 116, 139, 1);
}

.dark .article-content blockquote {
  color: rgba(148, 163, 184, 1);
}
</style>
