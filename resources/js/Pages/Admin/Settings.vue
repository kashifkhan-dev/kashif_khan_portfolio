<template>
  <AuthenticatedLayout>
    <template #header>Settings</template>
    <Head title="Settings - Admin" />

    <div class="space-y-6 max-w-5xl">
      <!-- Page Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-border pb-5">
        <div>
          <h1 class="text-2xl font-bold tracking-tight text-foreground">
            Settings
          </h1>
          <p class="text-xs text-muted-foreground mt-1">
            Manage your social links, developer profiles, and downloadable resume.
          </p>
        </div>

        <div class="flex items-center gap-3">
          <button
            type="button"
            @click="submitForm"
            :disabled="form.processing"
            class="h-9 px-5 rounded-lg bg-primary hover:bg-primary/90 text-primary-foreground font-semibold text-xs transition-all shadow-xs cursor-pointer disabled:opacity-50 flex items-center gap-2"
          >
            <Loader2 v-if="form.processing" class="h-3.5 w-3.5 animate-spin" />
            <Save v-else class="h-3.5 w-3.5" />
            <span>{{ form.processing ? 'Saving...' : 'Save Settings' }}</span>
          </button>
        </div>
      </div>

      <!-- Quick Context Info Banner -->
      <div class="p-4 rounded-xl border border-border/80 bg-muted/30 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs">
        <div class="flex items-center gap-2.5">
          <User class="h-4 w-4 text-muted-foreground shrink-0" />
          <span class="text-muted-foreground">
            Looking to update your <strong class="text-foreground font-semibold">Profile Photo, Name, Tagline, or About Me</strong>?
          </span>
        </div>
        <Link
          :href="route('admin.hero.index')"
          class="inline-flex items-center gap-1 font-semibold text-primary hover:underline underline-offset-4 shrink-0 cursor-pointer"
        >
          <span>Go to Hero &amp; About Editor</span>
          <ArrowRight class="h-3 w-3" />
        </Link>
      </div>

      <form @submit.prevent="submitForm" class="space-y-6">
        
        <!-- CARD 1: Social & Professional Links -->
        <div class="rounded-xl border border-border bg-card p-6 space-y-5 shadow-xs">
          <div class="flex items-center gap-2.5 border-b border-border pb-3">
            <Share2 class="h-4 w-4 text-primary" />
            <h3 class="text-sm font-bold text-foreground">Social &amp; Professional Profiles</h3>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <!-- GitHub URL -->
            <div class="space-y-1.5">
              <label class="block text-xs font-semibold text-foreground flex items-center gap-1.5">
                <Github class="h-3.5 w-3.5 text-muted-foreground" />
                <span>GitHub Profile URL</span>
              </label>
              <input 
                v-model="form.github_url" 
                type="text" 
                placeholder="e.g. https://github.com/KashifKhan456"
                class="w-full h-9 px-3.5 rounded-lg border border-input bg-background text-foreground text-xs placeholder:text-muted-foreground focus:ring-1 focus:ring-ring focus:border-ring outline-none transition-colors" 
              />
              <p class="text-[11px] text-muted-foreground">Used for GitHub links and contributions on your portfolio.</p>
            </div>

            <!-- LinkedIn URL -->
            <div class="space-y-1.5">
              <label class="block text-xs font-semibold text-foreground flex items-center gap-1.5">
                <Linkedin class="h-3.5 w-3.5 text-muted-foreground" />
                <span>LinkedIn Profile URL</span>
              </label>
              <input 
                v-model="form.linkedin_url" 
                type="text" 
                placeholder="e.g. https://linkedin.com/in/kashifkhan"
                class="w-full h-9 px-3.5 rounded-lg border border-input bg-background text-foreground text-xs placeholder:text-muted-foreground focus:ring-1 focus:ring-ring focus:border-ring outline-none transition-colors" 
              />
              <p class="text-[11px] text-muted-foreground">Connects your profile icon on the floating dock.</p>
            </div>

            <!-- Twitter / X URL -->
            <div class="space-y-1.5">
              <label class="block text-xs font-semibold text-foreground flex items-center gap-1.5">
                <Twitter class="h-3.5 w-3.5 text-muted-foreground" />
                <span>Twitter / X Profile URL</span>
              </label>
              <input 
                v-model="form.twitter_url" 
                type="text" 
                placeholder="e.g. https://x.com/kashifkhan"
                class="w-full h-9 px-3.5 rounded-lg border border-input bg-background text-foreground text-xs placeholder:text-muted-foreground focus:ring-1 focus:ring-ring focus:border-ring outline-none transition-colors" 
              />
              <p class="text-[11px] text-muted-foreground">Displayed on the bottom floating navigation dock.</p>
            </div>
          </div>
        </div>

        <!-- CARD 2: Resume / CV Document & Link Manager -->
        <div class="rounded-xl border border-border bg-card p-6 space-y-5 shadow-xs">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-border pb-3">
            <div class="flex items-center gap-2.5">
              <FileText class="h-4 w-4 text-primary" />
              <div>
                <h3 class="text-sm font-bold text-foreground">Resume / CV Document</h3>
                <p class="text-[11px] text-muted-foreground mt-0.5">Visitors can view and download your resume from the Hero section and Magic Dock.</p>
              </div>
            </div>

            <!-- Method Switcher Pills -->
            <div class="flex items-center p-1 rounded-lg border border-border bg-muted/50 self-start sm:self-auto">
              <button
                type="button"
                @click="resumeMode = 'upload'"
                class="px-3 py-1 text-xs font-semibold rounded-md transition-all cursor-pointer"
                :class="resumeMode === 'upload' ? 'bg-background text-foreground shadow-2xs' : 'text-muted-foreground hover:text-foreground'"
              >
                Upload File
              </button>
              <button
                type="button"
                @click="resumeMode = 'url'"
                class="px-3 py-1 text-xs font-semibold rounded-md transition-all cursor-pointer"
                :class="resumeMode === 'url' ? 'bg-background text-foreground shadow-2xs' : 'text-muted-foreground hover:text-foreground'"
              >
                Custom URL
              </button>
            </div>
          </div>

          <!-- OPTION A: File Upload Mode -->
          <div v-if="resumeMode === 'upload'" class="space-y-4">
            <!-- Dropzone Area -->
            <div 
              @click="$refs.resumeInput.click()"
              @dragover.prevent="isDragging = true"
              @dragleave.prevent="isDragging = false"
              @drop.prevent="handleFileDrop"
              class="border-2 border-dashed rounded-xl p-6 text-center cursor-pointer transition-all duration-200"
              :class="isDragging 
                ? 'border-primary bg-primary/5' 
                : 'border-border/80 hover:border-foreground/40 hover:bg-muted/30'"
            >
              <input 
                ref="resumeInput" 
                type="file" 
                accept=".pdf,.doc,.docx" 
                class="hidden" 
                @change="handleFileSelect" 
              />

              <div class="flex flex-col items-center gap-2">
                <div class="p-3 rounded-full bg-muted border border-border/80 text-foreground">
                  <UploadCloud class="h-5 w-5 text-primary" />
                </div>
                <div>
                  <p class="text-xs font-semibold text-foreground">
                    <span class="text-primary hover:underline">Click to upload</span> or drag and drop your document
                  </p>
                  <p class="text-[11px] text-muted-foreground mt-0.5">
                    Supported formats: PDF, DOC, DOCX (Max 10MB)
                  </p>
                </div>
              </div>
            </div>

            <!-- Selected File Badge -->
            <div v-if="selectedFileName" class="p-3 rounded-lg border border-primary/30 bg-primary/5 flex items-center justify-between gap-3 text-xs">
              <div class="flex items-center gap-2 text-foreground font-medium truncate">
                <CheckCircle2 class="h-4 w-4 text-emerald-500 shrink-0" />
                <span class="truncate">Ready to upload: <strong>{{ selectedFileName }}</strong></span>
              </div>
              <button 
                type="button" 
                @click="clearSelectedFile"
                class="text-xs text-rose-500 hover:text-rose-600 font-semibold cursor-pointer shrink-0"
              >
                Cancel
              </button>
            </div>

            <!-- Current Active File Link Banner -->
            <div v-if="form.resume_url && !selectedFileName" class="p-3.5 rounded-lg border border-border/80 bg-card flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
              <div class="flex items-center gap-2.5 truncate">
                <FileText class="h-4 w-4 text-indigo-500 shrink-0" />
                <div class="truncate">
                  <span class="font-medium text-foreground">Active Resume:</span>
                  <span class="text-muted-foreground ml-1.5 font-mono text-[11px] truncate">{{ form.resume_url }}</span>
                </div>
              </div>
              <div class="flex items-center gap-2 shrink-0">
                <a 
                  :href="form.resume_url" 
                  target="_blank" 
                  rel="noopener noreferrer"
                  class="px-2.5 py-1 rounded-md border border-border bg-muted hover:bg-muted/80 text-[11px] font-semibold text-foreground inline-flex items-center gap-1.5 transition-colors"
                >
                  <span>Preview File</span>
                  <ExternalLink class="h-3 w-3 text-muted-foreground" />
                </a>
              </div>
            </div>
          </div>

          <!-- OPTION B: Custom URL Mode -->
          <div v-else class="space-y-3">
            <div class="space-y-1.5">
              <label class="block text-xs font-semibold text-foreground flex items-center gap-1.5">
                <LinkIcon class="h-3.5 w-3.5 text-muted-foreground" />
                <span>External Cloud / Web Resume Link</span>
              </label>
              <input 
                v-model="form.resume_url" 
                type="text" 
                placeholder="e.g. https://drive.google.com/file/... or https://notion.so/..."
                class="w-full h-9 px-3.5 rounded-lg border border-input bg-background text-foreground text-xs placeholder:text-muted-foreground focus:ring-1 focus:ring-ring focus:border-ring outline-none transition-colors font-mono" 
              />
              <p class="text-[11px] text-muted-foreground">
                Paste a public sharing link from Google Drive, Dropbox, Notion, or your own hosting.
              </p>
            </div>

            <div v-if="form.resume_url" class="flex justify-end pt-1">
              <a 
                :href="form.resume_url" 
                target="_blank" 
                rel="noopener noreferrer"
                class="text-xs font-medium text-primary hover:underline inline-flex items-center gap-1"
              >
                <span>Test link in new tab</span>
                <ExternalLink class="h-3 w-3" />
              </a>
            </div>
          </div>

          <!-- Where it appears indicator -->
          <div class="pt-3 border-t border-border/60 flex flex-wrap items-center justify-between gap-2 text-[11px] text-muted-foreground">
            <div class="flex items-center gap-1.5">
              <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
              <span>Enabled on: <strong>Hero Section</strong> button and <strong>Magic Dock</strong> icon.</span>
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
import { useToast } from '@/Composables/useToast';
import { 
  Save, 
  Loader2, 
  Share2, 
  Github, 
  Linkedin, 
  Twitter, 
  FileText, 
  User, 
  ArrowRight,
  UploadCloud,
  CheckCircle2,
  ExternalLink,
  Link as LinkIcon
} from 'lucide-vue-next';

const props = defineProps({
  settings: Object,
});

const { toast } = useToast();
const resumeInput = ref(null);
const isDragging = ref(false);
const selectedFileName = ref('');

// Start in upload mode if file starts with /storage, otherwise if url starts with http/https start in url mode
const initialUrl = props.settings?.resume_url || '';
const resumeMode = ref(initialUrl.startsWith('http') && !initialUrl.includes('/storage/') ? 'url' : 'upload');

const form = useForm({
  github_url: props.settings?.github_url || '',
  linkedin_url: props.settings?.linkedin_url || '',
  twitter_url: props.settings?.twitter_url || '',
  resume_url: initialUrl,
  resume_file: null,
});

function handleFileSelect(e) {
  const file = e.target.files?.[0];
  if (file) {
    applyFile(file);
  }
}

function handleFileDrop(e) {
  isDragging.value = false;
  const file = e.dataTransfer.files?.[0];
  if (file) {
    applyFile(file);
  }
}

function applyFile(file) {
  form.resume_file = file;
  selectedFileName.value = `${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
  toast({
    title: 'File Selected',
    description: `Selected "${file.name}". Click "Save Settings" to upload and apply.`,
    type: 'info',
  });
}

function clearSelectedFile() {
  form.resume_file = null;
  selectedFileName.value = '';
  if (resumeInput.value) {
    resumeInput.value.value = '';
  }
}

function submitForm() {
  form.post(route('admin.settings.update'), {
    preserveScroll: true,
    forceFormData: true,
    onSuccess: (page) => {
      form.resume_file = null;
      selectedFileName.value = '';
      if (resumeInput.value) {
        resumeInput.value.value = '';
      }
      if (page.props?.settings?.resume_url) {
        form.resume_url = page.props.settings.resume_url;
      }
    },
    onError: (errors) => {
      toast({
        title: 'Save Failed',
        description: errors.resume_file || 'An error occurred while saving settings.',
        type: 'error',
      });
    },
  });
}
</script>
