<template>
  <AuthenticatedLayout>
    <template #header>Create Article</template>
    <Head title="Write Article - Admin" />

    <div class="space-y-6 max-w-6xl mx-auto">
      <!-- Top Action Bar -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-neutral-200 dark:border-neutral-800 pb-5">
        <div class="space-y-1">
          <Link
            :href="route('admin.articles.index')"
            class="inline-flex items-center gap-1.5 text-xs text-neutral-500 hover:text-neutral-900 dark:hover:text-neutral-100 font-semibold transition-colors mb-1"
          >
            <ArrowLeft class="h-3.5 w-3.5" />
            <span>Back to Articles CMS</span>
          </Link>
          <h1 class="text-2xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-50 flex items-center gap-2">
            <PenSquare class="h-6 w-6 text-indigo-500" />
            <span>Author Technical Article</span>
          </h1>
          <p class="text-xs text-neutral-500 dark:text-neutral-400">
            Compose in-depth architecture writeups, performance benchmarks, and software engineering deep dives.
          </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
          <Link
            :href="route('admin.articles.index')"
            class="h-9 px-4 rounded-[6px] border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 text-xs font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors flex items-center justify-center"
          >
            Cancel
          </Link>
          <button
            type="button"
            @click="submitForm"
            :disabled="form.processing"
            class="h-9 px-5 rounded-[6px] bg-neutral-900 text-neutral-50 dark:bg-neutral-50 dark:text-neutral-900 text-xs font-bold hover:opacity-90 transition-all shadow-md flex items-center gap-2 cursor-pointer disabled:opacity-50"
          >
            <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
            <Save v-else class="h-4 w-4" />
            <span>Publish / Save Article</span>
          </button>
        </div>
      </div>

      <!-- Form Grid -->
      <form @submit.prevent="submitForm" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content Area (2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Card: Title, Slug & Excerpt -->
          <div class="rounded-[8px] border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 p-6 space-y-5 shadow-xs">
            <!-- Title -->
            <div class="space-y-1.5">
              <label class="block text-xs font-bold text-neutral-800 dark:text-neutral-200">
                Article Title <span class="text-red-500">*</span>
              </label>
              <input
                v-model="form.title"
                @input="handleTitleInput"
                type="text"
                placeholder="e.g., Architecting High-Throughput Inertia.js SPAs with Vue 3 & Laravel 12"
                class="w-full h-10 px-3.5 rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 text-sm text-neutral-900 dark:text-neutral-50 placeholder:text-neutral-400 focus:outline-none focus:border-slate-900 dark:focus:border-neutral-500 transition-all"
                :class="{ 'border-red-500': form.errors.title }"
              />
              <p v-if="form.errors.title" class="text-xs text-red-500 mt-1">{{ form.errors.title }}</p>
            </div>

            <!-- Slug -->
            <div class="space-y-1.5">
              <div class="flex items-center justify-between">
                <label class="block text-xs font-bold text-neutral-800 dark:text-neutral-200">
                  URL Slug
                </label>
                <button
                  type="button"
                  @click="isSlugManual = !isSlugManual"
                  class="text-[11px] text-indigo-500 hover:text-indigo-400 font-medium"
                >
                  {{ isSlugManual ? 'Reset Auto-Slug' : 'Edit Slug Manually' }}
                </button>
              </div>
              <div class="flex items-center rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 overflow-hidden focus-within:border-slate-900 dark:focus-within:border-neutral-500 transition-all">
                <span class="px-3 text-xs text-neutral-500 border-r border-slate-300 dark:border-neutral-800 font-mono select-none">
                  /articles/
                </span>
                <input
                  v-model="form.slug"
                  :readonly="!isSlugManual"
                  type="text"
                  placeholder="auto-generated-from-title"
                  class="flex-1 h-9 px-3 bg-transparent text-xs font-mono text-neutral-900 dark:text-neutral-50 border-0 focus:ring-0 focus:outline-none"
                  :class="{ 'border-red-500': form.errors.slug }"
                />
              </div>
              <p v-if="form.errors.slug" class="text-xs text-red-500 mt-1">{{ form.errors.slug }}</p>
            </div>

            <!-- Excerpt -->
            <div class="space-y-1.5">
              <label class="block text-xs font-bold text-neutral-800 dark:text-neutral-200">
                Short Excerpt / Meta Description
              </label>
              <textarea
                v-model="form.excerpt"
                rows="3"
                placeholder="A concise 1-2 sentence executive summary of key takeaways and architectural challenges covered in this writeup."
                class="w-full p-3 rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 text-xs text-neutral-900 dark:text-neutral-50 placeholder:text-neutral-400 focus:outline-none focus:border-slate-900 dark:focus:border-neutral-500 transition-all"
                :class="{ 'border-red-500': form.errors.excerpt }"
              ></textarea>
              <p v-if="form.errors.excerpt" class="text-xs text-red-500 mt-1">{{ form.errors.excerpt }}</p>
            </div>
          </div>

          <!-- Card: Rich Content Editor -->
          <div class="rounded-[8px] border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 p-6 space-y-4 shadow-xs">
            <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800 pb-3">
              <div>
                <h3 class="text-sm font-bold text-neutral-900 dark:text-neutral-50 flex items-center gap-2">
                  <FileText class="h-4 w-4 text-indigo-500" />
                  <span>Article Content (Rich Text / HTML)</span>
                </h3>
                <p class="text-[11px] text-neutral-500">Supports headings, formatted code blocks, bold/italic, lists, quotes, and links.</p>
              </div>
            </div>

            <!-- RichTextEditor Component -->
            <RichTextEditor
              v-model="form.content"
              placeholder="Write your in-depth technical article here... Use formatting tools above to insert headings, code snippets, lists, and quotes."
            />
            <p v-if="form.errors.content" class="text-xs text-red-500 mt-1">{{ form.errors.content }}</p>
          </div>
        </div>

        <!-- Sidebar Options (1 Col) -->
        <div class="space-y-6">
          <!-- Card: Publishing Status & Metadata -->
          <div class="rounded-[8px] border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 p-5 space-y-5 shadow-xs">
            <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-500 dark:text-neutral-400 border-b border-neutral-200 dark:border-neutral-800 pb-3">
              Publishing Options
            </h3>

            <!-- Published Toggle -->
            <label class="flex items-center justify-between p-3 rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/40 cursor-pointer hover:border-slate-400 dark:hover:border-neutral-700 transition-colors select-none shadow-2xs">
              <div class="space-y-0.5">
                <span class="text-xs font-bold text-neutral-900 dark:text-neutral-50">Publish Live</span>
                <p class="text-[10px] text-neutral-500">Visible on public portfolio and articles hub</p>
              </div>
              <input
                v-model="form.is_published"
                type="checkbox"
                class="h-5 w-5 rounded-[4px] border-2 border-neutral-400 dark:border-neutral-500 bg-white dark:bg-neutral-900 text-blue-600 dark:text-blue-500 checked:bg-blue-600 dark:checked:bg-blue-500 checked:border-blue-600 dark:checked:border-blue-500 focus:ring-0 focus:ring-offset-0 cursor-pointer transition-all shadow-xs shrink-0"
              />
            </label>

            <!-- Estimated Read Time -->
            <div class="space-y-1.5">
              <div class="flex items-center justify-between">
                <label class="block text-xs font-bold text-neutral-800 dark:text-neutral-200">
                  Read Time (Minutes)
                </label>
                <button
                  type="button"
                  @click="calculateReadTime"
                  class="text-[11px] text-indigo-500 hover:text-indigo-400 font-medium cursor-pointer"
                >
                  Auto-Calculate
                </button>
              </div>
              <div class="flex items-center rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 px-3 focus-within:border-slate-900 dark:focus-within:border-neutral-500 transition-all">
                <Clock class="h-3.5 w-3.5 text-neutral-400 mr-2 shrink-0" />
                <input
                  v-model.number="form.read_time"
                  type="number"
                  min="1"
                  max="120"
                  class="w-full h-9 bg-transparent text-xs text-neutral-900 dark:text-neutral-50 border-0 focus:ring-0 focus:outline-none p-0"
                />
              </div>
            </div>

            <!-- Display Order -->
            <div class="space-y-1.5">
              <label class="block text-xs font-bold text-neutral-800 dark:text-neutral-200">
                Priority Display Order
              </label>
              <input
                v-model.number="form.order"
                type="number"
                min="0"
                class="w-full h-9 px-3 rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 text-xs text-neutral-900 dark:text-neutral-50 focus:outline-none focus:border-slate-900 dark:focus:border-neutral-500"
              />
              <p class="text-[10px] text-neutral-400">Lower numbers appear first.</p>
            </div>
          </div>

          <!-- Card: Cover Image -->
          <div class="rounded-[8px] border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 p-5 space-y-4 shadow-xs">
            <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-500 dark:text-neutral-400 border-b border-neutral-200 dark:border-neutral-800 pb-3">
              Cover Image
            </h3>

            <!-- Cover Image Preview -->
            <div class="w-full h-36 rounded-[6px] overflow-hidden border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900 relative">
              <img
                v-if="coverPreviewUrl"
                :src="coverPreviewUrl"
                alt="Cover Preview"
                class="w-full h-full object-cover"
              />
              <div v-else class="w-full h-full flex flex-col items-center justify-center text-neutral-400 p-4 text-center">
                <ImageIcon class="h-8 w-8 mb-1.5 text-neutral-400" />
                <span class="text-xs">No cover image selected</span>
              </div>
            </div>

            <!-- Image File Upload -->
            <div class="space-y-1.5">
              <label class="block text-xs font-bold text-neutral-800 dark:text-neutral-200">
                Upload Image File
              </label>
              <input
                type="file"
                accept="image/*"
                @change="handleFileUpload"
                class="w-full text-xs text-neutral-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-[4px] file:border-0 file:text-xs file:font-semibold file:bg-neutral-900 file:text-white dark:file:bg-neutral-100 dark:file:text-black hover:file:opacity-80 cursor-pointer"
              />
            </div>

            <div class="text-center text-[10px] text-neutral-400 font-bold">— OR USE EXTERNAL URL —</div>

            <!-- Image URL -->
            <div class="space-y-1.5">
              <label class="block text-xs font-bold text-neutral-800 dark:text-neutral-200">
                Image Web URL
              </label>
              <input
                v-model="form.cover_image"
                type="text"
                placeholder="https://images.unsplash.com/..."
                class="w-full h-9 px-3 rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 text-xs text-neutral-900 dark:text-neutral-50 focus:outline-none focus:border-slate-900 dark:focus:border-neutral-500"
              />
            </div>
          </div>

          <!-- Card: Topics & Tags -->
          <div class="rounded-[8px] border border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 p-5 space-y-4 shadow-xs">
            <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-500 dark:text-neutral-400 border-b border-neutral-200 dark:border-neutral-800 pb-3">
              Topics &amp; Tags
            </h3>

            <!-- Custom Tag Input -->
            <div class="flex items-center gap-2">
              <input
                v-model="tagInput"
                @keydown.enter.prevent="addCustomTag"
                type="text"
                placeholder="Add tag and press Enter..."
                class="flex-1 h-8 px-3 rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 text-xs text-neutral-900 dark:text-neutral-50 focus:outline-none focus:border-slate-900 dark:focus:border-neutral-500"
              />
              <button
                type="button"
                @click="addCustomTag"
                class="h-8 px-3 rounded-[6px] bg-neutral-800 text-white text-xs font-semibold hover:bg-neutral-700 transition-colors"
              >
                Add
              </button>
            </div>

            <!-- Selected Tags -->
            <div class="flex flex-wrap items-center gap-1.5 min-h-[32px]">
              <span
                v-for="tag in form.tags"
                :key="tag"
                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-[4px] text-xs font-medium bg-indigo-50 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800"
              >
                <span>{{ tag }}</span>
                <button
                  type="button"
                  @click="removeTag(tag)"
                  class="hover:text-red-500 cursor-pointer ml-0.5"
                >
                  &times;
                </button>
              </span>
              <span v-if="!form.tags.length" class="text-[11px] text-neutral-400 italic">No tags selected yet.</span>
            </div>

            <!-- Quick Sugggestions -->
            <div class="space-y-1.5 pt-2 border-t border-neutral-100 dark:border-neutral-900">
              <span class="text-[10px] text-neutral-400 uppercase font-bold">Suggested:</span>
              <div class="flex flex-wrap gap-1">
                <button
                  v-for="sugg in suggestedTags"
                  :key="sugg"
                  type="button"
                  @click="toggleSuggestedTag(sugg)"
                  class="px-2 py-0.5 rounded text-[10px] transition-colors"
                  :class="form.tags.includes(sugg) 
                    ? 'bg-neutral-900 text-white dark:bg-neutral-100 dark:text-neutral-900 font-bold' 
                    : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-200'"
                >
                  + {{ sugg }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import RichTextEditor from '@/Components/RichTextEditor.vue';
import {
  PenSquare,
  ArrowLeft,
  Save,
  Loader2,
  FileText,
  Clock,
  Image as ImageIcon,
} from 'lucide-vue-next';

const form = useForm({
  title: '',
  slug: '',
  excerpt: '',
  content: '',
  cover_image: '',
  cover_image_file: null,
  read_time: 5,
  tags: ['Laravel', 'Vue 3', 'Architecture'],
  is_published: true,
  order: 0,
});

const isSlugManual = ref(false);
const tagInput = ref('');
const localFilePreview = ref(null);

const suggestedTags = [
  'Laravel 12',
  'Vue 3',
  'Inertia.js',
  'Tailwind CSS',
  'Architecture',
  'Performance',
  'Redis',
  'MySQL',
  'DevOps',
  'Microservices',
  'Security',
];

function generateSlug(text) {
  return text
    .toString()
    .toLowerCase()
    .trim()
    .replace(/\s+/g, '-')
    .replace(/[^\w\-]+/g, '')
    .replace(/\-\-+/g, '-');
}

function handleTitleInput() {
  if (!isSlugManual.value) {
    form.slug = generateSlug(form.title);
  }
}

function calculateReadTime() {
  const text = (form.content || '').replace(/<[^>]*>/g, '');
  const words = text.trim().split(/\s+/).filter(Boolean).length;
  form.read_time = Math.max(1, Math.ceil(words / 200)) || 5;
}

const coverPreviewUrl = computed(() => {
  if (localFilePreview.value) return localFilePreview.value;
  if (form.cover_image) return form.cover_image;
  return null;
});

function handleFileUpload(e) {
  const file = e.target.files[0];
  if (!file) return;
  form.cover_image_file = file;
  localFilePreview.value = URL.createObjectURL(file);
}

function addCustomTag() {
  const val = tagInput.value.trim();
  if (val && !form.tags.includes(val)) {
    form.tags.push(val);
    tagInput.value = '';
  }
}

function toggleSuggestedTag(tag) {
  if (form.tags.includes(tag)) {
    form.tags = form.tags.filter(t => t !== tag);
  } else {
    form.tags.push(tag);
  }
}

function removeTag(tag) {
  form.tags = form.tags.filter(t => t !== tag);
}

function submitForm() {
  calculateReadTime();
  form.post(route('admin.articles.store'), {
    preserveScroll: true,
  });
}
</script>
