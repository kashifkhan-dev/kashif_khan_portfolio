<template>
  <AuthenticatedLayout>
    <template #header>Hero &amp; Profile Section</template>
    <Head title="Hero & About Editor - Admin" />

    <div class="space-y-6">
      <!-- Page Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-border pb-5">
        <div>
          <h1 class="text-2xl font-bold tracking-tight text-foreground">
            Hero &amp; About Section
          </h1>
          <p class="text-xs text-muted-foreground mt-1">
            Manage your greeting headline, bio tagline, profile photo, and "About Me" summary.
          </p>
        </div>

        <div class="flex items-center gap-3">
          <button
            type="button"
            @click="submitForm"
            :disabled="isSubmitting"
            class="h-9 px-5 rounded-lg bg-primary hover:bg-primary/90 text-primary-foreground font-semibold text-xs transition-all shadow-xs cursor-pointer disabled:opacity-50 flex items-center gap-2"
          >
            <Loader2 v-if="isSubmitting" class="h-3.5 w-3.5 animate-spin" />
            <Save v-else class="h-3.5 w-3.5" />
            <span>{{ isSubmitting ? 'Saving...' : 'Save Changes' }}</span>
          </button>
        </div>
      </div>

      <!-- Main Layout: Form Controls (Left) + Clean Live Canvas (Right) -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- LEFT COLUMN: Form Inputs (7 Cols) -->
        <div class="lg:col-span-7 space-y-5">
          <form @submit.prevent="submitForm" class="space-y-5">

            <!-- Card 1: Identity & Avatar Upload -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-4 shadow-xs">
              <div class="flex items-center gap-2 border-b border-border pb-3 text-sm font-semibold text-foreground">
                <User class="h-4 w-4 text-primary" />
                <span>Identity &amp; Profile Photo</span>
              </div>

              <!-- Full Name Field -->
              <div class="space-y-1.5">
                <label class="font-medium text-foreground text-xs">
                  Display Name <span class="text-rose-500">*</span>
                </label>
                <input
                  v-model="form.hero_title_1"
                  type="text"
                  required
                  placeholder="e.g. Kashif Khan"
                  class="w-full h-9 px-3 rounded-lg border border-input bg-background text-foreground text-xs placeholder:text-muted-foreground focus:ring-1 focus:ring-ring focus:border-ring outline-none transition-colors"
                />
              </div>

              <!-- Avatar Uploader Row -->
              <div class="space-y-2 pt-2 border-t border-border">
                <label class="font-medium text-foreground text-xs">
                  Profile Photo
                </label>

                <!-- Hidden Native File Input -->
                <input
                  ref="fileInputRef"
                  type="file"
                  accept="image/png,image/jpeg,image/webp,image/gif,image/svg+xml"
                  class="hidden"
                  @change="handleFileChange"
                />

                <div class="flex flex-col sm:flex-row items-center gap-4 p-4 rounded-xl border border-dashed border-border bg-muted/20">
                  <!-- Avatar Circle Preview / Trigger -->
                  <div
                    @click="triggerFileSelect"
                    class="relative size-20 rounded-full border-2 border-dashed border-border hover:border-primary shrink-0 overflow-hidden flex items-center justify-center bg-card cursor-pointer group shadow-xs transition-colors"
                    title="Click to choose a photo from your computer"
                  >
                    <img
                      v-if="currentAvatarSrc && !avatarPreviewError"
                      :src="currentAvatarSrc"
                      alt="Avatar Preview"
                      class="w-full h-full object-cover group-hover:opacity-80 transition-opacity"
                      @error="avatarPreviewError = true"
                    />
                    <span v-else class="text-lg font-bold text-foreground">
                      {{ previewInitials }}
                    </span>

                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                      <Camera class="h-5 w-5 text-white" />
                    </div>
                  </div>

                  <!-- Upload Action Controls -->
                  <div class="flex-1 space-y-2 w-full text-center sm:text-left">
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                      <button
                        type="button"
                        @click="triggerFileSelect"
                        class="h-8 px-3 rounded-md bg-secondary hover:bg-secondary/80 text-secondary-foreground text-xs font-medium transition-colors flex items-center gap-1.5 cursor-pointer shadow-2xs"
                      >
                        <UploadCloud class="h-3.5 w-3.5" />
                        <span>Upload from Computer</span>
                      </button>

                      <button
                        v-if="selectedFile || form.avatar_url"
                        type="button"
                        @click="clearAvatar"
                        class="h-8 px-2.5 rounded-md hover:bg-destructive/10 text-destructive text-xs font-medium transition-colors flex items-center gap-1 cursor-pointer"
                        title="Remove photo"
                      >
                        <X class="h-3.5 w-3.5" />
                        <span>Remove</span>
                      </button>
                    </div>

                    <p v-if="selectedFile" class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium">
                      ✓ Ready to upload: {{ selectedFile.name }} ({{ formatFileSize(selectedFile.size) }})
                    </p>
                    <p v-else class="text-[11px] text-muted-foreground">
                      Supports JPG, PNG, WEBP (Max 5MB). Click avatar or button to browse files.
                    </p>
                  </div>
                </div>

                <!-- Or manual URL toggle / input -->
                <div class="pt-1">
                  <div class="flex items-center gap-2">
                    <button
                      type="button"
                      @click="showUrlInput = !showUrlInput"
                      class="text-[11px] text-muted-foreground hover:text-foreground underline underline-offset-4 cursor-pointer transition-colors"
                    >
                      {{ showUrlInput ? 'Hide Image URL input' : 'Or paste an external Image URL instead' }}
                    </button>
                  </div>

                  <div v-if="showUrlInput" class="mt-2">
                    <input
                      v-model="form.avatar_url"
                      type="url"
                      placeholder="https://example.com/avatar.jpg"
                      class="w-full h-8 px-3 rounded-md border border-input bg-background text-foreground text-xs font-mono placeholder:text-muted-foreground focus:ring-1 focus:ring-ring outline-none"
                    />
                  </div>
                </div>
              </div>
            </div>

            <!-- Card 2: Headline Tagline / Bio -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-3 shadow-xs">
              <div class="flex items-center gap-2 border-b border-border pb-3 text-sm font-semibold text-foreground">
                <Sparkles class="h-4 w-4 text-primary" />
                <span>Headline Tagline / Bio</span>
              </div>

              <div class="space-y-1.5">
                <label class="font-medium text-foreground text-xs">
                  Hero Tagline
                </label>
                <textarea
                  v-model="form.hero_subtitle"
                  rows="3"
                  placeholder="Full Stack Software Engineer building scalable web applications, API integrations, and robust platforms..."
                  class="w-full p-3 rounded-lg border border-input bg-background text-foreground text-xs leading-relaxed placeholder:text-muted-foreground focus:ring-1 focus:ring-ring outline-none transition-colors"
                ></textarea>
              </div>
            </div>

            <!-- Card 3: About Me Section -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-3 shadow-xs">
              <div class="flex items-center gap-2 border-b border-border pb-3 text-sm font-semibold text-foreground">
                <FileText class="h-4 w-4 text-primary" />
                <span>"About Me" Detailed Summary</span>
              </div>

              <div class="space-y-1.5">
                <label class="font-medium text-foreground text-xs">
                  About Section Text
                </label>
                <textarea
                  v-model="form.about_text"
                  rows="5"
                  placeholder="Full Stack Software Engineer with deep expertise in architecting and shipping scalable, high-performance web applications..."
                  class="w-full p-3 rounded-lg border border-input bg-background text-foreground text-xs leading-relaxed placeholder:text-muted-foreground focus:ring-1 focus:ring-ring outline-none transition-colors"
                ></textarea>
                <p class="text-[11px] text-muted-foreground">
                  You can include HTML tags like <code class="text-[11px] font-mono">&lt;a href="#work" class="underline"&gt;link&lt;/a&gt;</code> to create jump links.
                </p>
              </div>
            </div>

            <!-- Bottom Action Bar -->
            <div class="flex justify-end pt-1">
              <button
                type="submit"
                :disabled="isSubmitting"
                class="h-9 px-6 rounded-lg bg-primary hover:bg-primary/90 text-primary-foreground font-semibold text-xs transition-all shadow-xs cursor-pointer disabled:opacity-50 flex items-center gap-2"
              >
                <Loader2 v-if="isSubmitting" class="h-3.5 w-3.5 animate-spin" />
                <Save v-else class="h-3.5 w-3.5" />
                <span>{{ isSubmitting ? 'Saving Changes...' : 'Save Changes' }}</span>
              </button>
            </div>
          </form>
        </div>

        <!-- RIGHT COLUMN: Elegant Clean Live Portfolio Preview (5 Cols sticky) -->
        <div class="lg:col-span-5 sticky top-20">
          <div class="rounded-xl border border-border bg-card p-5 space-y-5 shadow-xs overflow-hidden">

            <!-- Card Header -->
            <div class="flex items-center justify-between border-b border-border pb-3">
              <div class="flex items-center gap-2">
                <span class="size-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-semibold text-foreground">Live Portfolio Preview</span>
              </div>
              <span class="text-[10px] font-medium px-2 py-0.5 rounded-full bg-muted text-muted-foreground">
                Magic UI Layout
              </span>
            </div>

            <!-- Preview Card reproducing Welcome.vue Hero & About -->
            <div class="space-y-6 p-4 rounded-xl border border-border/60 bg-background/50">

              <!-- Hero Preview -->
              <div class="flex items-start justify-between gap-4">
                <div class="space-y-1.5 flex-1 min-w-0">
                  <h3 class="text-xl font-bold tracking-tight text-foreground">
                    Hi, I'm {{ previewFirstName }} 👋
                  </h3>
                  <p class="text-xs text-muted-foreground leading-relaxed line-clamp-4">
                    {{ form.hero_subtitle || 'Full Stack Software Engineer building scalable web applications...' }}
                  </p>
                </div>

                <!-- Avatar Circle -->
                <div class="size-16 shrink-0 border border-border rounded-full shadow-sm ring-2 ring-muted overflow-hidden flex items-center justify-center bg-card select-none">
                  <img
                    v-if="currentAvatarSrc && !avatarPreviewError"
                    :src="currentAvatarSrc"
                    :alt="form.hero_title_1"
                    class="w-full h-full object-cover"
                    @error="avatarPreviewError = true"
                  />
                  <span v-else class="text-base font-bold text-foreground">
                    {{ previewInitials }}
                  </span>
                </div>
              </div>

              <!-- About Preview -->
              <div class="space-y-1.5 pt-4 border-t border-border/60">
                <h4 class="text-xs font-bold text-foreground uppercase tracking-wider">About</h4>
                <div class="text-xs text-muted-foreground leading-relaxed">
                  <p v-if="hasHtmlAbout" v-html="previewAboutText" class="line-clamp-5"></p>
                  <p v-else class="whitespace-pre-line line-clamp-5">{{ previewAboutText }}</p>
                </div>
              </div>

            </div>

            <div class="p-3 rounded-lg bg-muted/40 border border-border text-muted-foreground text-xs flex items-center gap-2">
              <Sparkles class="h-3.5 w-3.5 text-primary shrink-0" />
              <span>Preview updates automatically as you type or select a local photo.</span>
            </div>

          </div>
        </div>

      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useToast } from '@/Composables/useToast';
import {
  User,
  Camera,
  UploadCloud,
  X,
  FileText,
  Sparkles,
  Save,
  Loader2,
} from 'lucide-vue-next';

const props = defineProps({
  settings: Object,
});

const { toast } = useToast();
const isSubmitting = ref(false);
const avatarPreviewError = ref(false);
const showUrlInput = ref(false);

const fileInputRef = ref(null);
const selectedFile = ref(null);
const localPreviewUrl = ref('');

const defaultAbout = 'Full Stack Software Engineer with deep expertise in architecting and shipping scalable, high-performance web applications, cloud infrastructure, and modern AI automation platforms. In the past, I pursued a degree in software engineering, and developed production platforms at multiple technology companies.';

const form = ref({
  hero_title_1: props.settings?.hero_title_1 || 'Kashif Khan',
  hero_subtitle: props.settings?.hero_subtitle || 'Full Stack Software Engineer building scalable web applications, API integrations, and robust platforms using Laravel, Vue.js, React, Node.js, and modern AI automation tools.',
  avatar_url: props.settings?.avatar_url || props.settings?.profile_image || '',
  about_text: props.settings?.about_text || props.settings?.bio || defaultAbout,
  availability_status: props.settings?.availability_status || 'Available for Full-time Roles & Contracts',
});

// Watch settings updates from server
watch(
  () => props.settings,
  (newSettings) => {
    if (newSettings) {
      if (newSettings.hero_title_1) form.value.hero_title_1 = newSettings.hero_title_1;
      if (newSettings.hero_subtitle) form.value.hero_subtitle = newSettings.hero_subtitle;
      if (newSettings.avatar_url) form.value.avatar_url = newSettings.avatar_url;
      if (newSettings.about_text || newSettings.bio) form.value.about_text = newSettings.about_text || newSettings.bio;
      if (newSettings.availability_status) form.value.availability_status = newSettings.availability_status;
    }
  },
  { deep: true }
);

function triggerFileSelect() {
  fileInputRef.value?.click();
}

function handleFileChange(e) {
  const file = e.target.files?.[0];
  if (file) {
    if (!file.type.startsWith('image/')) {
      toast({
        title: 'Invalid File',
        description: 'Please select an image file (PNG, JPG, WEBP, or GIF).',
        type: 'error',
      });
      return;
    }
    if (file.size > 5 * 1024 * 1024) {
      toast({
        title: 'File Too Large',
        description: 'Image size must be less than 5MB.',
        type: 'error',
      });
      return;
    }
    selectedFile.value = file;
    localPreviewUrl.value = URL.createObjectURL(file);
    avatarPreviewError.value = false;
  }
}

function clearAvatar() {
  selectedFile.value = null;
  localPreviewUrl.value = '';
  form.value.avatar_url = '';
  if (fileInputRef.value) {
    fileInputRef.value.value = '';
  }
}

function formatFileSize(bytes) {
  if (!bytes) return '';
  const kb = bytes / 1024;
  if (kb < 1024) return `${kb.toFixed(1)} KB`;
  return `${(kb / 1024).toFixed(1)} MB`;
}

const currentAvatarSrc = computed(() => {
  if (localPreviewUrl.value) return localPreviewUrl.value;
  return form.value.avatar_url || props.settings?.avatar_url || props.settings?.profile_image || '';
});

watch(currentAvatarSrc, () => {
  avatarPreviewError.value = false;
});

const previewFirstName = computed(() => {
  let name = (form.value.hero_title_1 || 'Kashif Khan').trim();
  name = name.replace(/^(hey|hi|hello),?\s*(i'm|i am)?\s*/i, '').trim();
  const parts = name.split(/\s+/);
  return parts[0] || 'Kashif';
});

const previewInitials = computed(() => {
  let name = (form.value.hero_title_1 || 'Kashif Khan').trim();
  name = name.replace(/^(hey|hi|hello),?\s*(i'm|i am)?\s*/i, '').trim();
  const parts = name.split(/\s+/);
  if (parts.length >= 2) {
    return `${parts[0][0]}${parts[1][0]}`.toUpperCase();
  }
  return name.substring(0, 2).toUpperCase() || 'KK';
});

const previewAboutText = computed(() => {
  return form.value.about_text || defaultAbout;
});

const hasHtmlAbout = computed(() => {
  return typeof form.value.about_text === 'string' && /<[a-z][\s\S]*>/i.test(form.value.about_text);
});

function submitForm() {
  isSubmitting.value = true;

  const payload = new FormData();
  payload.append('hero_title_1', form.value.hero_title_1 || '');
  payload.append('hero_subtitle', form.value.hero_subtitle || '');
  payload.append('about_text', form.value.about_text || '');
  payload.append('availability_status', form.value.availability_status || '');

  if (selectedFile.value) {
    payload.append('avatar_file', selectedFile.value);
  } else {
    payload.append('avatar_url', form.value.avatar_url || '');
  }

  router.post(route('admin.hero.update'), payload, {
    forceFormData: true,
    preserveScroll: true,
    onSuccess: (page) => {
      selectedFile.value = null;
      localPreviewUrl.value = '';
      if (fileInputRef.value) {
        fileInputRef.value.value = '';
      }
      avatarPreviewError.value = false;

      // Ensure form avatar_url syncs immediately with updated props
      const updatedSettings = page.props?.settings;
      if (updatedSettings?.avatar_url) {
        form.value.avatar_url = updatedSettings.avatar_url;
      }
    },
    onError: () => {
      toast({
        title: 'Update Failed',
        description: 'Please review the inputs and try again.',
        type: 'error',
      });
    },
    onFinish: () => {
      isSubmitting.value = false;
    },
  });
}
</script>
