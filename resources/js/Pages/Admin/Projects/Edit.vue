<template>
  <AuthenticatedLayout>
    <template #header>Edit Project</template>
    <Head title="Edit Project - Kashif Khan Dev" />

    <div class="space-y-8 pb-16 animate-in fade-in-50 duration-300">
      
      <!-- Top Action Bar -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b pb-5">
        <div class="space-y-1">
          <Link 
            :href="route('admin.projects.index')" 
            class="inline-flex items-center gap-1.5 text-xs text-muted-foreground hover:text-foreground font-semibold transition-colors mb-1"
          >
            <ArrowLeft class="h-3.5 w-3.5" />
            <span>Back to Projects Showcase Manager</span>
          </Link>
          <h1 class="text-2xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-50 flex items-center gap-2">
            <Edit3 class="h-6 w-6 text-indigo-500" />
            <span>Edit Project Specifications</span>
          </h1>
          <p class="text-xs text-muted-foreground">Modify project metadata, category tags, tech stack chips, media URLs, and showcase positioning.</p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
          <Link 
            :href="route('admin.projects.index')" 
            class="h-9 px-4 rounded-lg border bg-background text-xs font-semibold text-foreground hover:bg-muted transition-colors flex items-center justify-center"
          >
            Cancel
          </Link>
          <button 
            type="button"
            @click="submitForm"
            :disabled="form.processing" 
            class="h-9 px-5 rounded-lg bg-neutral-900 text-neutral-50 dark:bg-neutral-50 dark:text-neutral-900 text-xs font-bold hover:opacity-90 transition-all shadow-md flex items-center gap-2"
          >
            <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
            <Save v-else class="h-4 w-4" />
            <span>Save Changes</span>
          </button>
        </div>
      </div>

      <!-- 2-Column Executive Card Layout -->
      <form @submit.prevent="submitForm" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- LEFT COLUMN: Primary Content & Stack (2 Cols Wide) -->
        <div class="lg:col-span-2 space-y-6">
          
          <!-- Card 1: Project Identity & Documentation -->
          <div class="rounded-xl border border-neutral-200 dark:border-neutral-800/80 bg-card text-card-foreground shadow-sm p-6 space-y-5">
            <div class="flex items-center gap-2 border-b border-neutral-200 dark:border-neutral-800/80 pb-3 text-sm font-bold text-neutral-900 dark:text-neutral-50">
              <FileText class="h-4 w-4 text-indigo-500" />
              <span>Project Identity & Content</span>
            </div>

            <!-- Project Title -->
            <div class="space-y-1.5">
              <label class="font-semibold text-foreground text-xs">
                Project Title <span class="text-rose-500">*</span>
              </label>
              <input 
                v-model="form.title" 
                type="text" 
                placeholder="e.g. Nexus SaaS Telemetry Dashboard"
                required 
                class="w-full h-10 px-3.5 rounded-lg border border-neutral-300 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/60 text-neutral-900 dark:text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all" 
              />
            </div>

            <!-- Row 2: Category, Featured Hero & Display Order Side-by-Side -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
              <!-- Category Domain -->
              <div class="space-y-1.5">
                <label class="font-semibold text-foreground text-xs">Category Domain</label>
                <ShadcnSelect 
                  v-model="form.category" 
                  :options="categoryOptions" 
                  placeholder="Select category domain..."
                />
              </div>

              <!-- Featured Hero -->
              <div class="space-y-1.5">
                <label class="font-semibold text-foreground text-xs">Featured Hero</label>
                <button 
                  type="button"
                  @click="form.is_featured = !form.is_featured"
                  :class="[
                    'w-full h-10 px-3 rounded-lg border transition-all flex items-center justify-between font-semibold text-xs cursor-pointer select-none',
                    form.is_featured 
                      ? 'border-indigo-500/50 bg-indigo-500/10 text-indigo-400 dark:text-indigo-300' 
                      : 'border-neutral-300 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/60 text-muted-foreground hover:text-foreground'
                  ]"
                >
                  <span>{{ form.is_featured ? 'Featured Hero' : 'Standard' }}</span>
                  <div 
                    :class="[
                      'relative inline-flex h-5 w-9 shrink-0 rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out',
                      form.is_featured ? 'bg-indigo-600' : 'bg-neutral-300 dark:bg-neutral-700'
                    ]"
                  >
                    <span 
                      :class="[
                        'pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out',
                        form.is_featured ? 'translate-x-4' : 'translate-x-0'
                      ]"
                    />
                  </div>
                </button>
              </div>

              <!-- Display Order -->
              <div class="space-y-1.5">
                <label class="font-semibold text-foreground text-xs">Display Order</label>
                <div class="h-10 px-2 rounded-lg border border-neutral-300 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/60 flex items-center justify-between gap-1">
                  <button 
                    type="button" 
                    @click="form.order = Math.max(0, (parseInt(form.order) || 0) - 1)" 
                    class="h-7 w-7 flex items-center justify-center rounded text-neutral-500 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-200/60 dark:hover:bg-neutral-800 transition-colors select-none shrink-0"
                    title="Decrease Order"
                  >
                    <Minus class="h-3.5 w-3.5" />
                  </button>
                  <input 
                    v-model.number="form.order" 
                    type="number" 
                    min="0"
                    class="w-full h-8 text-center bg-transparent text-neutral-900 dark:text-neutral-100 text-xs font-mono font-bold outline-none border-none focus:outline-none focus:ring-0 focus:border-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" 
                  />
                  <button 
                    type="button" 
                    @click="form.order = (parseInt(form.order) || 0) + 1" 
                    class="h-7 w-7 flex items-center justify-center rounded text-neutral-500 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-200/60 dark:hover:bg-neutral-800 transition-colors select-none shrink-0"
                    title="Increase Order"
                  >
                    <Plus class="h-3.5 w-3.5" />
                  </button>
                </div>
              </div>
            </div>

            <!-- Short Summary -->
            <div class="space-y-1.5">
              <label class="font-semibold text-foreground text-xs">Short Summary</label>
              <textarea 
                v-model="form.summary" 
                rows="3"
                placeholder="e.g. Concise overview snippet displayed on portfolio card previews..."
                class="w-full p-3.5 rounded-lg border border-neutral-300 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/60 text-neutral-900 dark:text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all leading-relaxed" 
              ></textarea>
            </div>

            <!-- Technologies & Frameworks Tag Manager -->
            <div class="space-y-1.5">
              <label class="font-semibold text-foreground text-xs flex items-center justify-between">
                <span>Technologies & Frameworks</span>
                <span class="text-[11px] text-muted-foreground font-normal">Search preset tech or type custom</span>
              </label>
              <TechStackSelector v-model="techChips" />
            </div>

            <!-- Detailed Project Overview (Rich Text Editor) -->
            <div class="space-y-1.5">
              <label class="font-semibold text-foreground text-xs">Detailed Project Overview</label>
              <RichTextEditor 
                v-model="form.description" 
                placeholder="e.g. Comprehensive breakdown of project features, database architecture, key accomplishments, and performance optimizations..."
              />
            </div>
          </div>
        </div>

        <!-- RIGHT COLUMN: Media & Links (1 Col Wide) -->
        <div class="lg:col-span-1 space-y-6">
          
          <!-- Card 2: Cover Media & Deployment Links -->
          <div class="rounded-xl border border-neutral-200 dark:border-neutral-800/80 bg-card text-card-foreground shadow-sm p-6 space-y-5">
            <div class="flex items-center gap-2 border-b border-neutral-200 dark:border-neutral-800/80 pb-3 text-sm font-bold text-neutral-900 dark:text-neutral-50">
              <ImageIcon class="h-4 w-4 text-indigo-500" />
              <span>Media & External Links</span>
            </div>

            <!-- Cover Image Local Uploader & Preview -->
            <div class="space-y-2">
              <label class="font-semibold text-foreground text-xs flex items-center justify-between">
                <span>Project Cover Image</span>
                <span class="text-[11px] text-muted-foreground font-normal">PNG, JPG, WEBP (Max 5MB)</span>
              </label>

              <!-- Hidden File Input -->
              <input 
                ref="fileInputRef" 
                type="file" 
                accept="image/*" 
                class="hidden" 
                @change="handleFileChange" 
              />

              <!-- Drag & Drop / Preview Box -->
              <div 
                @click="triggerFileSelect"
                @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @drop.prevent="handleFileDrop"
                :class="[
                  'relative min-h-[200px] w-full rounded-xl border-2 border-dashed transition-all duration-200 flex flex-col items-center justify-center overflow-hidden cursor-pointer group',
                  isDragging 
                    ? 'border-indigo-500 bg-indigo-500/10' 
                    : 'border-neutral-300 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/40 hover:border-indigo-500/50 hover:bg-neutral-100/50 dark:hover:bg-neutral-900/60'
                ]"
              >
                <!-- Preview Image if set -->
                <template v-if="previewUrl">
                  <img 
                    :src="previewUrl" 
                    alt="Project Cover Preview" 
                    class="absolute inset-0 w-full h-full object-cover transition-transform group-hover:scale-105 duration-300"
                    @error="handleImageError"
                  />
                  <div class="absolute inset-0 bg-neutral-950/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 backdrop-blur-xs">
                    <button 
                      type="button" 
                      @click.stop="triggerFileSelect"
                      class="px-3 py-1.5 rounded-lg bg-white/90 dark:bg-neutral-900/90 text-neutral-900 dark:text-neutral-100 text-xs font-bold shadow-md hover:bg-white transition-all flex items-center gap-1.5"
                    >
                      <UploadCloud class="h-3.5 w-3.5 text-indigo-500" />
                      <span>Change Image</span>
                    </button>
                    <button 
                      type="button" 
                      @click.stop="removeImage"
                      class="px-3 py-1.5 rounded-lg bg-rose-600/90 text-white text-xs font-bold shadow-md hover:bg-rose-600 transition-all flex items-center gap-1.5"
                    >
                      <X class="h-3.5 w-3.5" />
                      <span>Remove</span>
                    </button>
                  </div>
                </template>

                <!-- Upload Placeholder -->
                <template v-else>
                  <div class="p-6 text-center space-y-2 pointer-events-none">
                    <div class="w-12 h-12 rounded-full bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mx-auto border border-indigo-200 dark:border-indigo-800/60 shadow-xs group-hover:scale-110 transition-transform">
                      <UploadCloud class="h-6 w-6" />
                    </div>
                    <div>
                      <p class="text-xs font-bold text-neutral-900 dark:text-neutral-100">
                        Click to upload <span class="text-neutral-500 font-normal">or drag & drop</span>
                      </p>
                      <p class="text-[11px] text-neutral-500 mt-0.5">e.g. High resolution portfolio image from local computer</p>
                    </div>
                  </div>
                </template>
              </div>
            </div>

            <div class="border-t border-neutral-200 dark:border-neutral-800 pt-4 space-y-4">
              <!-- Live Demo URL -->
              <div class="space-y-1.5">
                <label class="font-semibold text-foreground text-xs flex items-center gap-1.5">
                  <Globe class="h-3.5 w-3.5 text-indigo-500" />
                  <span>Live Demo Website URL</span>
                </label>
                <input 
                  v-model="form.demo_url" 
                  type="url" 
                  placeholder="e.g. https://myproject.com" 
                  class="w-full h-10 px-3.5 rounded-lg border border-neutral-300 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/60 text-neutral-900 dark:text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none" 
                />
              </div>

              <!-- GitHub URL -->
              <div class="space-y-1.5">
                <label class="font-semibold text-foreground text-xs flex items-center gap-1.5">
                  <Github class="h-3.5 w-3.5 text-indigo-500" />
                  <span>GitHub Repository URL</span>
                </label>
                <input 
                  v-model="form.github_url" 
                  type="url" 
                  placeholder="e.g. https://github.com/user/repo" 
                  class="w-full h-10 px-3.5 rounded-lg border border-neutral-300 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/60 text-neutral-900 dark:text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none" 
                />
              </div>
            </div>

          </div>

        </div>

      </form>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import RichTextEditor from '@/Components/RichTextEditor.vue';
import ShadcnSelect from '@/Components/ShadcnSelect.vue';
import TechStackSelector from '@/Components/TechStackSelector.vue';

const categoryOptions = [
  { label: 'Fullstack Application', value: 'Fullstack' },
  { label: 'Frontend Experience', value: 'Frontend' },
  { label: 'Laravel & Vue Architecture', value: 'Laravel & Vue' },
  { label: 'AI & Machine Learning', value: 'AI' },
  { label: 'Mobile Application', value: 'Mobile' },
];
import { 
  ArrowLeft, 
  Edit3, 
  X, 
  Image as ImageIcon, 
  Globe, 
  Github, 
  Loader2, 
  Save, 
  FileText, 
  Code2, 
  Sparkles,
  Plus,
  Minus,
  UploadCloud
} from 'lucide-vue-next';
import { useToast } from '@/Composables/useToast';

const props = defineProps({
  project: Object,
});

const { toast } = useToast();

const techChips = ref([...(props.project.tech_stack || [])]);
const newTechInput = ref('');

const fileInputRef = ref(null);
const isDragging = ref(false);
const previewUrl = ref(props.project?.image_path || '');

const form = useForm({
  title: props.project.title || '',
  category: props.project.category || 'Fullstack',
  summary: props.project.summary || '',
  description: props.project.description || '',
  image_path: props.project.image_path || '',
  image_file: null,
  tech_stack: props.project.tech_stack || [],
  demo_url: props.project.demo_url || '',
  github_url: props.project.github_url || '',
  is_featured: !!props.project.is_featured,
  order: props.project.order || 0,
});

function triggerFileSelect() {
  fileInputRef.value?.click();
}

function handleFileChange(e) {
  const file = e.target.files?.[0];
  if (file) {
    processFile(file);
  }
}

function handleFileDrop(e) {
  isDragging.value = false;
  const file = e.dataTransfer?.files?.[0];
  if (file) {
    processFile(file);
  }
}

function processFile(file) {
  if (!file.type.startsWith('image/')) {
    toast({ title: 'Invalid File', description: 'Please select an image file.', type: 'error' });
    return;
  }
  form.image_file = file;
  previewUrl.value = URL.createObjectURL(file);
}

function removeImage() {
  form.image_file = null;
  form.image_path = '';
  previewUrl.value = '';
  if (fileInputRef.value) {
    fileInputRef.value.value = '';
  }
}

function addTechChip() {
  const val = newTechInput.value.replace(/,/g, '').trim();
  if (val && !techChips.value.includes(val)) {
    techChips.value.push(val);
  }
  newTechInput.value = '';
}

function removeTechChip(index) {
  techChips.value.splice(index, 1);
}

function handleImageError(e) {
  e.target.src = 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=200&q=80';
}

function submitForm() {
  if (newTechInput.value.trim()) {
    addTechChip();
  }
  form.tech_stack = [...techChips.value];

  form.transform((data) => ({
    ...data,
    _method: 'put',
  })).post(route('admin.projects.update', props.project.id), {
    onSuccess: () => {
      toast({
        title: 'Project Saved',
        description: `"${form.title}" updated successfully.`,
        type: 'success'
      });
    },
  });
}
</script>
