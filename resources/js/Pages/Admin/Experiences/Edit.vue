<template>
  <AuthenticatedLayout>
    <template #header>Edit Timeline Entry</template>
    <Head title="Edit Timeline Entry - Kashif Khan Dev" />

    <div class="admin-page-container">
      
      <!-- Top Action Bar -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-neutral-800 pb-5">
        <div class="space-y-1">
          <Link 
            :href="route('admin.experiences.index')" 
            class="inline-flex items-center gap-1.5 text-xs text-neutral-400 hover:text-white font-semibold transition-colors mb-1"
          >
            <ArrowLeft class="h-3.5 w-3.5" />
            <span>Back to Timeline Experiences</span>
          </Link>
          <h1 class="text-2xl font-extrabold tracking-tight text-white flex items-center gap-2">
            <Briefcase class="h-6 w-6 text-indigo-400" />
            <span>Edit Timeline Entry</span>
          </h1>
          <p class="text-xs text-neutral-400">Update company role details, period timeline, location, rich text breakdown, and key accomplishments.</p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
          <Link 
            :href="route('admin.experiences.index')" 
            class="h-9 px-4 rounded-[6px] border border-neutral-800 bg-neutral-900 text-xs font-semibold text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors flex items-center justify-center cursor-pointer"
          >
            Cancel
          </Link>
          <button 
            type="button"
            @click="submitForm"
            :disabled="form.processing" 
            class="h-9 px-5 rounded-[6px] bg-white hover:bg-neutral-200 text-black text-xs font-extrabold transition-all shadow-md flex items-center gap-2 cursor-pointer disabled:opacity-50"
          >
            <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
            <Save v-else class="h-4 w-4" />
            <span>Save Changes</span>
          </button>
        </div>
      </div>

      <!-- Main Form Container -->
      <form @submit.prevent="submitForm" class="space-y-6">
        <div class="rounded-[10px] border border-neutral-800 bg-neutral-950 p-6 space-y-6 shadow-xl">
          
          <div class="flex items-center gap-2 border-b border-neutral-800 pb-3 text-sm font-bold text-white">
            <FileText class="h-4 w-4 text-indigo-400" />
            <span>Experience Details</span>
          </div>

          <!-- Line 1: Company, Role & Category Type (3 Columns) -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Company / Institution -->
            <div class="space-y-1.5">
              <div class="flex items-center justify-between h-5">
                <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">
                  Company / Institution <span class="text-rose-500">*</span>
                </label>
              </div>
              <input 
                v-model="form.company" 
                type="text" 
                required 
                placeholder="e.g. Apex Cloud Systems"
                class="w-full h-10 px-3.5 rounded-[6px] border border-neutral-800 bg-neutral-900 text-white text-xs placeholder:text-neutral-500 focus:ring-1 focus:ring-white focus:border-white outline-none transition-colors" 
              />
            </div>

            <!-- Role / Degree Title -->
            <div class="space-y-1.5">
              <div class="flex items-center justify-between h-5">
                <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">
                  Role / Degree Title <span class="text-rose-500">*</span>
                </label>
              </div>
              <input 
                v-model="form.role" 
                type="text" 
                required 
                placeholder="e.g. Lead Full-Stack Engineer"
                class="w-full h-10 px-3.5 rounded-[6px] border border-neutral-800 bg-neutral-900 text-white text-xs placeholder:text-neutral-500 focus:ring-1 focus:ring-white focus:border-white outline-none transition-colors" 
              />
            </div>

            <!-- Category Type -->
            <div class="space-y-1.5">
              <div class="flex items-center justify-between h-5">
                <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">
                  Category Type <span class="text-rose-500">*</span>
                </label>
              </div>
              <ShadcnSelect
                v-model="form.type"
                :options="typeOptions"
                placeholder="Select category..."
                trigger-class="h-10"
              />
            </div>
          </div>

          <!-- Line 2: From & To Dates (2 Columns) -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Start Date Picker (From) -->
            <div class="space-y-1.5">
              <div class="flex items-center justify-between h-5">
                <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">
                  From (Start Date) <span class="text-rose-500">*</span>
                </label>
              </div>
              <ShadcnDatePicker 
                v-model="startPeriod" 
                placeholder="Select date" 
              />
            </div>

            <!-- End Date Picker (To) -->
            <div class="space-y-1.5">
              <div class="flex items-center justify-between h-5">
                <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">
                  To (End Date) <span class="text-rose-500">*</span>
                </label>
                <label class="inline-flex items-center gap-1.5 cursor-pointer">
                  <input 
                    type="checkbox" 
                    v-model="isCurrent"
                    class="rounded border-neutral-700 bg-neutral-900 text-indigo-500 focus:ring-0 h-3 w-3 cursor-pointer" 
                  />
                  <span class="text-[10px] text-neutral-400 font-semibold select-none hover:text-neutral-200 transition-colors">Present</span>
                </label>
              </div>
              <ShadcnDatePicker 
                v-model="endPeriod" 
                :disabled="isCurrent"
                :placeholder="isCurrent ? 'Present' : 'Select date'" 
              />
            </div>
          </div>

          <!-- Line 3: Job Type & Location (2 Columns below dates) -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Work Mode / Job Type -->
            <div class="space-y-1.5">
              <div class="flex items-center justify-between h-5">
                <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">
                  Job Type / Work Mode
                </label>
              </div>
              <ShadcnSelect
                v-model="form.work_type"
                :options="workTypeOptions"
                placeholder="Select work mode..."
                trigger-class="h-10"
              />
            </div>

            <!-- Location -->
            <div class="space-y-1.5">
              <div class="flex items-center justify-between h-5">
                <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">Location</label>
              </div>
              <input 
                v-model="form.location" 
                type="text" 
                placeholder="e.g. Peshawar, PK"
                class="w-full h-10 px-3.5 rounded-[6px] border border-neutral-800 bg-neutral-900 text-white text-xs placeholder:text-neutral-500 focus:ring-1 focus:ring-white focus:border-white outline-none transition-colors" 
              />
            </div>
          </div>

          <!-- Description Paragraph (Rich Text Editor) -->
          <div class="space-y-1.5">
            <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">Description Paragraph</label>
            <RichTextEditor 
              v-model="form.description" 
              placeholder="Architected enterprise SaaS solutions using Laravel, Vue 3..."
            />
          </div>

          <!-- Technologies Used (Comma Separated) -->
          <div class="space-y-1.5">
            <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">Technologies Used (comma separated)</label>
            <input 
              v-model="technologiesInput" 
              type="text" 
              placeholder="e.g. Laravel, Vue.js, Tailwind CSS, Stripe, AWS S3, Redis" 
              class="w-full h-10 px-3.5 rounded-[6px] border border-neutral-800 bg-neutral-900 text-white text-xs placeholder:text-neutral-500 focus:ring-1 focus:ring-white focus:border-white outline-none transition-colors" 
            />
            <p class="text-[11px] text-neutral-500">Only technologies typed here will appear as tech pills on your portfolio page. Leave empty if none.</p>
          </div>

          <!-- Key Highlights (Comma Separated) -->
          <div class="space-y-1.5">
            <label class="font-semibold text-neutral-300 uppercase tracking-wider text-[10px]">Key Highlights (comma separated)</label>
            <input 
              v-model="highlightsInput" 
              type="text" 
              placeholder="Led engineering team of 5, Improved query execution speed by 40%" 
              class="w-full h-10 px-3.5 rounded-[6px] border border-neutral-800 bg-neutral-900 text-white text-xs placeholder:text-neutral-500 focus:ring-1 focus:ring-white focus:border-white outline-none transition-colors" 
            />
            <p class="text-[11px] text-neutral-500">Separate key highlights with commas. They will be rendered as bullet points in your portfolio timeline.</p>
          </div>

        </div>

        <!-- Form Action Footer -->
        <div class="flex justify-end gap-3 pt-2">
          <Link 
            :href="route('admin.experiences.index')" 
            class="h-10 px-5 rounded-[6px] border border-neutral-800 bg-neutral-900 text-xs font-semibold text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors flex items-center justify-center cursor-pointer"
          >
            Cancel
          </Link>
          <button 
            type="submit"
            :disabled="form.processing" 
            class="h-10 px-6 rounded-[6px] bg-white hover:bg-neutral-200 text-black text-xs font-extrabold transition-all shadow-md flex items-center gap-2 cursor-pointer disabled:opacity-50"
          >
            <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
            <Save v-else class="h-4 w-4" />
            <span>Save Changes</span>
          </button>
        </div>
      </form>

    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, watch } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ShadcnSelect from '@/Components/ShadcnSelect.vue';
import ShadcnDatePicker from '@/Components/ShadcnDatePicker.vue';
import RichTextEditor from '@/Components/RichTextEditor.vue';
import { ArrowLeft, Briefcase, FileText, Save, Loader2 } from 'lucide-vue-next';
import { useToast } from '@/Composables/useToast';

const props = defineProps({
  experience: {
    type: Object,
    required: true,
  },
});

const { toast } = useToast();

// Parse initial period "From - To"
let initialFrom = '';
let initialTo = '';
let initialCurrent = false;

if (props.experience.period) {
  const parts = props.experience.period.split('-').map(s => s.trim());
  if (parts.length >= 2) {
    initialFrom = parts[0];
    initialTo = parts[1];
    if (initialTo.toLowerCase() === 'present') {
      initialCurrent = true;
    }
  } else {
    initialFrom = props.experience.period;
  }
}

const startPeriod = ref(initialFrom);
const endPeriod = ref(initialTo);
const isCurrent = ref(initialCurrent);

watch(isCurrent, (val) => {
  if (val) {
    endPeriod.value = 'Present';
  } else if (endPeriod.value === 'Present') {
    endPeriod.value = '';
  }
});

const highlightsInput = ref(
  Array.isArray(props.experience.highlights) 
    ? props.experience.highlights.join(', ') 
    : (props.experience.highlights || '')
);

const technologiesInput = ref(
  Array.isArray(props.experience.technologies)
    ? props.experience.technologies.join(', ')
    : (props.experience.technologies || '')
);

const form = useForm({
  company: props.experience.company || '',
  role: props.experience.role || '',
  period: props.experience.period || '',
  location: props.experience.location || '',
  work_type: props.experience.work_type || 'Remote',
  type: props.experience.type || 'work',
  description: props.experience.description || '',
  highlights: props.experience.highlights || [],
  technologies: props.experience.technologies || [],
});

const typeOptions = [
  { value: 'work', label: 'Work Experience' },
  { value: 'education', label: 'Education / Certification' },
];

const workTypeOptions = [
  { value: 'Remote', label: 'Remote' },
  { value: 'Onsite', label: 'Onsite' },
  { value: 'Hybrid', label: 'Hybrid' },
  { value: 'Full-time', label: 'Full-time' },
  { value: 'Part-time', label: 'Part-time' },
  { value: 'Contract', label: 'Contract' },
  { value: 'Freelance', label: 'Freelance' },
];

function submitForm() {
  const fromStr = startPeriod.value.trim();
  const toStr = isCurrent.value ? 'Present' : endPeriod.value.trim();

  if (fromStr && toStr) {
    form.period = `${fromStr} - ${toStr}`;
  } else if (fromStr) {
    form.period = fromStr;
  } else {
    form.period = toStr;
  }

  if (highlightsInput.value) {
    form.highlights = highlightsInput.value
      .split(',')
      .map(item => item.trim())
      .filter(item => item.length > 0);
  } else {
    form.highlights = [];
  }

  if (technologiesInput.value) {
    form.technologies = technologiesInput.value
      .split(',')
      .map(item => item.trim())
      .filter(item => item.length > 0);
  } else {
    form.technologies = [];
  }

  form.put(route('admin.experiences.update', props.experience.id), {
    onSuccess: () => {
      toast({
        type: 'success',
        title: 'Timeline Entry Updated',
        description: 'The experience record has been updated successfully.',
      });
    },
  });
}
</script>
