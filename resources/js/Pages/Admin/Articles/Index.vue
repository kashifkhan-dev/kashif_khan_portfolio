<template>
  <AuthenticatedLayout>
    <template #header>Articles CMS</template>
    <Head title="Technical Articles & Blog CMS - Admin" />

    <div class="space-y-6">
      <!-- Top Action Bar -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-neutral-200 dark:border-neutral-800 pb-5">
        <div>
          <h1 class="text-2xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-50 flex items-center gap-3">
            <BookOpen class="h-6 w-6 text-indigo-500" />
            <span>Technical Articles &amp; Blog CMS</span>
            <span class="px-2.5 py-0.5 rounded-[6px] text-xs font-semibold bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-700">
              {{ publishedCount }} Published &bull; {{ articles.length }} Total
            </span>
          </h1>
          <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
            Author and publish senior-level architecture writeups, performance case studies, and engineering tutorials.
          </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
          <a
            :href="route('articles.index')"
            target="_blank"
            class="h-9 px-3.5 rounded-[6px] border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 text-xs font-semibold text-neutral-700 dark:text-neutral-300 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors flex items-center gap-1.5 shadow-xs cursor-pointer"
            title="View public articles hub in a new tab"
          >
            <ExternalLink class="h-3.5 w-3.5" />
            <span>Public Hub</span>
          </a>

          <Link
            :href="route('admin.articles.create')"
            class="h-9 px-4 rounded-[6px] bg-neutral-900 text-neutral-50 dark:bg-neutral-50 dark:text-neutral-900 text-xs font-bold hover:opacity-90 transition-all shadow-md flex items-center gap-2 cursor-pointer"
          >
            <PenSquare class="h-3.5 w-3.5" />
            <span>Write New Article</span>
          </Link>
        </div>
      </div>

      <!-- Filters & Search Toolbar -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white dark:bg-card p-2.5 rounded-[6px] border border-slate-200 dark:border-neutral-800 shadow-xs">
        <!-- Status Tabs -->
        <div class="flex items-center gap-1.5">
          <button
            @click="activeFilter = 'all'"
            class="px-3 py-1.5 rounded-[6px] text-xs font-semibold transition-all cursor-pointer"
            :class="activeFilter === 'all' 
              ? 'bg-slate-900 text-white dark:bg-white dark:text-neutral-950 font-bold shadow-xs' 
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 dark:text-neutral-400 dark:hover:text-neutral-50'"
          >
            All ({{ articles.length }})
          </button>
          <button
            @click="activeFilter = 'published'"
            class="px-3 py-1.5 rounded-[6px] text-xs font-semibold transition-all cursor-pointer"
            :class="activeFilter === 'published' 
              ? 'bg-slate-900 text-white dark:bg-white dark:text-neutral-950 font-bold shadow-xs' 
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 dark:text-neutral-400 dark:hover:text-neutral-50'"
          >
            Published ({{ publishedCount }})
          </button>
          <button
            @click="activeFilter = 'draft'"
            class="px-3 py-1.5 rounded-[6px] text-xs font-semibold transition-all cursor-pointer"
            :class="activeFilter === 'draft' 
              ? 'bg-slate-900 text-white dark:bg-white dark:text-neutral-950 font-bold shadow-xs' 
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 dark:text-neutral-400 dark:hover:text-neutral-50'"
          >
            Drafts ({{ articles.length - publishedCount }})
          </button>
        </div>

        <!-- Search input -->
        <div class="relative w-full sm:w-72">
          <Search class="h-3.5 w-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-neutral-400 pointer-events-none" />
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search articles by title or tag..."
            class="w-full h-8 pl-8 pr-3 rounded-[6px] border border-slate-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 text-xs text-slate-900 dark:text-neutral-100 placeholder:text-slate-400 dark:placeholder:text-neutral-500 focus:outline-none focus:border-slate-900 dark:focus:border-neutral-500 transition-colors"
          />
        </div>
      </div>

      <!-- Empty State -->
      <div v-if="!filteredArticles.length" class="py-16 text-center rounded-[8px] border border-dashed border-neutral-300 dark:border-neutral-800 p-8 space-y-3">
        <BookOpen class="h-10 w-10 text-neutral-400 dark:text-neutral-600 mx-auto" />
        <h3 class="text-sm font-bold text-neutral-800 dark:text-neutral-200">No articles found</h3>
        <p class="text-xs text-neutral-500 max-w-sm mx-auto">
          {{ searchQuery ? 'Try adjusting your search query or switching tabs.' : 'Start sharing your technical engineering thoughts by creating your first article.' }}
        </p>
        <Link
          v-if="!searchQuery"
          :href="route('admin.articles.create')"
          class="inline-flex items-center gap-1.5 px-4 py-2 rounded-[6px] bg-neutral-900 text-white dark:bg-white dark:text-black text-xs font-bold shadow hover:opacity-90 transition-all mt-2 cursor-pointer"
        >
          <PenSquare class="h-3.5 w-3.5" />
          <span>Write an Article</span>
        </Link>
      </div>

      <!-- Articles Grid/List Table -->
      <div v-else class="rounded-[8px] border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 shadow-sm overflow-hidden divide-y divide-neutral-200 dark:divide-neutral-800">
        <div
          v-for="article in filteredArticles"
          :key="article.id"
          class="p-4 sm:p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-neutral-50/70 dark:hover:bg-neutral-900/40 transition-colors group"
        >
          <!-- Left: Cover & Info -->
          <div class="flex items-start gap-4 min-w-0 flex-1">
            <!-- Cover image thumbnail -->
            <div class="w-20 h-16 sm:w-24 sm:h-18 rounded-[6px] overflow-hidden bg-neutral-100 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 shrink-0 relative">
              <img
                v-if="article.cover_image"
                :src="article.cover_image"
                :alt="article.title"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
              />
              <div v-else class="w-full h-full flex items-center justify-center text-neutral-400">
                <FileText class="h-6 w-6" />
              </div>
            </div>

            <!-- Meta details -->
            <div class="space-y-1.5 min-w-0 flex-1">
              <div class="flex flex-wrap items-center gap-2">
                <!-- Status Badge -->
                <span
                  class="px-2 py-0.5 rounded-[4px] text-[10px] font-bold tracking-wide uppercase inline-flex items-center gap-1"
                  :class="article.is_published 
                    ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-400 border border-emerald-300 dark:border-emerald-800' 
                    : 'bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-400 border border-amber-300 dark:border-amber-800'"
                >
                  <span class="w-1.5 h-1.5 rounded-full" :class="article.is_published ? 'bg-emerald-500' : 'bg-amber-500'"></span>
                  <span>{{ article.is_published ? 'Published' : 'Draft' }}</span>
                </span>

                <!-- Read time -->
                <span class="text-[11px] text-neutral-500 dark:text-neutral-400 flex items-center gap-1">
                  <Clock class="h-3 w-3" />
                  <span>{{ article.read_time || 5 }} min read</span>
                </span>

                <!-- Views count -->
                <span class="text-[11px] text-neutral-500 dark:text-neutral-400 flex items-center gap-1">
                  <Eye class="h-3 w-3" />
                  <span>{{ article.views_count || 0 }} views</span>
                </span>

                <!-- Published date -->
                <span v-if="article.published_at" class="text-[11px] text-neutral-400">
                  &bull; {{ formatDate(article.published_at) }}
                </span>
              </div>

              <!-- Article Title -->
              <h2 class="text-sm sm:text-base font-bold text-neutral-900 dark:text-neutral-100 line-clamp-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                <Link :href="route('admin.articles.edit', article.id)">
                  {{ article.title }}
                </Link>
              </h2>

              <!-- Excerpt -->
              <p class="text-xs text-neutral-500 dark:text-neutral-400 line-clamp-1 max-w-2xl">
                {{ article.excerpt || 'No summary excerpt provided.' }}
              </p>

              <!-- Tags Chips -->
              <div v-if="article.tags && article.tags.length" class="flex flex-wrap items-center gap-1.5 pt-1">
                <span
                  v-for="tag in article.tags"
                  :key="tag"
                  class="px-2 py-0.5 rounded-[4px] text-[10px] font-medium bg-neutral-100 text-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-700/60"
                >
                  {{ tag }}
                </span>
              </div>
            </div>
          </div>

          <!-- Right: Actions & Toggle -->
          <div class="flex items-center justify-between md:justify-end gap-2.5 shrink-0 pt-2 md:pt-0 border-t md:border-t-0 border-neutral-100 dark:border-neutral-900">
            <!-- Publish Toggle Switch -->
            <button
              @click="togglePublish(article)"
              type="button"
              class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1.5 rounded-[6px] border transition-colors cursor-pointer"
              :class="article.is_published 
                ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800/80 hover:bg-emerald-100' 
                : 'bg-neutral-100 dark:bg-neutral-900 text-neutral-600 dark:text-neutral-400 border-neutral-200 dark:border-neutral-800 hover:bg-neutral-200'"
              :title="article.is_published ? 'Click to unpublish' : 'Click to publish'"
            >
              <CheckCircle2 v-if="article.is_published" class="h-3.5 w-3.5 text-emerald-500" />
              <CircleDashed v-else class="h-3.5 w-3.5 text-neutral-400" />
              <span>{{ article.is_published ? 'Live' : 'Draft' }}</span>
            </button>

            <!-- Public View Link -->
            <a
              :href="route('articles.show', article.slug)"
              target="_blank"
              class="p-2 rounded-[6px] border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 text-neutral-500 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors cursor-pointer"
              title="Preview Article"
            >
              <ExternalLink class="h-3.5 w-3.5" />
            </a>

            <!-- Edit Button -->
            <Link
              :href="route('admin.articles.edit', article.id)"
              class="p-2 rounded-[6px] border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 text-neutral-500 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors cursor-pointer"
              title="Edit Article"
            >
              <Edit3 class="h-3.5 w-3.5" />
            </Link>

            <!-- Delete Button -->
            <button
              @click="openDeleteModal(article)"
              class="p-2 rounded-[6px] border border-red-200 dark:border-red-900/40 bg-red-50/50 dark:bg-red-950/30 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50 transition-colors cursor-pointer"
              title="Delete Article"
            >
              <Trash2 class="h-3.5 w-3.5" />
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <DeleteConfirmModal
      :isOpen="isDeleteModalOpen"
      title="Delete Technical Article"
      :message="`Are you sure you want to delete '${articleToDelete?.title}'? This action cannot be undone.`"
      :isLoading="isDeleting"
      @close="isDeleteModalOpen = false"
      @confirm="confirmDelete"
    />
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteConfirmModal from '@/Components/DeleteConfirmModal.vue';
import {
  BookOpen,
  PenSquare,
  Search,
  ExternalLink,
  Edit3,
  Trash2,
  Clock,
  Eye,
  FileText,
  CheckCircle2,
  CircleDashed,
} from 'lucide-vue-next';

const props = defineProps({
  articles: {
    type: Array,
    default: () => [],
  },
});

const searchQuery = ref('');
const activeFilter = ref('all');

const publishedCount = computed(() => {
  return props.articles.filter(a => a.is_published).length;
});

const filteredArticles = computed(() => {
  let list = props.articles;

  if (activeFilter.value === 'published') {
    list = list.filter(a => a.is_published);
  } else if (activeFilter.value === 'draft') {
    list = list.filter(a => !a.is_published);
  }

  if (searchQuery.value.trim()) {
    const q = searchQuery.value.toLowerCase();
    list = list.filter(a => {
      const matchTitle = a.title?.toLowerCase().includes(q);
      const matchExcerpt = a.excerpt?.toLowerCase().includes(q);
      const matchTag = a.tags?.some(t => t.toLowerCase().includes(q));
      return matchTitle || matchExcerpt || matchTag;
    });
  }

  return list;
});

function togglePublish(article) {
  router.patch(route('admin.articles.toggle-publish', article.id), {}, {
    preserveScroll: true,
  });
}

function formatDate(dateStr) {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric',
  });
}

// Delete modal state
const isDeleteModalOpen = ref(false);
const articleToDelete = ref(null);
const isDeleting = ref(false);

function openDeleteModal(article) {
  articleToDelete.value = article;
  isDeleteModalOpen.value = true;
}

function confirmDelete() {
  if (!articleToDelete.value) return;
  isDeleting.value = true;
  router.delete(route('admin.articles.destroy', articleToDelete.value.id), {
    onSuccess: () => {
      isDeleting.value = false;
      isDeleteModalOpen.value = false;
      articleToDelete.value = null;
    },
    onError: () => {
      isDeleting.value = false;
    },
  });
}
</script>
