<template>
  <AuthenticatedLayout>
    <template #header>Contact Section Manager</template>
    <Head title="Contact Section Manager - Admin" />

    <div class="space-y-8">
      <!-- Page Title Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-800 pb-6">
        <div>
          <h1 class="text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-50">
            Contact Section Manager
          </h1>
          <p class="text-sm text-muted-foreground mt-1">
            Customize the landing page contact pitch, email, location badge, response time, and form card UI live.
          </p>
        </div>

        <button
          @click="submitForm"
          :disabled="isSubmitting"
          class="h-10 px-5 rounded-[8px] bg-white hover:bg-neutral-200 text-black font-bold text-xs transition-all shadow-sm cursor-pointer disabled:opacity-50 flex items-center space-x-2 shrink-0"
        >
          <svg v-if="isSubmitting" class="animate-spin h-3.5 w-3.5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          <span>{{ isSubmitting ? 'Saving Changes...' : 'Save Contact Section' }}</span>
        </button>
      </div>

      <!-- Main Grid: Form Controls (Left) + Interactive Live Canvas (Right) -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- LEFT: Administrative Input Controls (5 Cols) -->
        <div class="lg:col-span-5 space-y-6">
          
          <!-- Section 1: Main Pitch & Subtext -->
          <div class="rounded-xl border border-neutral-800 bg-neutral-900/40 p-5 space-y-4 shadow-sm">
            <div class="flex items-center space-x-2 border-b border-neutral-800 pb-3">
              <span class="w-2 h-2 rounded-full bg-indigo-400"></span>
              <h3 class="text-xs font-bold text-white uppercase tracking-wider">Headline Pitch &amp; Subtitle</h3>
            </div>

            <div>
              <label class="block text-xs font-semibold text-neutral-300 mb-1.5">Contact Section Headline Title</label>
              <input 
                v-model="form.contact_headline_title" 
                type="text" 
                placeholder="Let's build something extraordinary together."
                class="w-full h-10 px-3.5 rounded-[8px] border border-neutral-800 bg-neutral-900/60 text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-white focus:outline-none transition-colors" 
              />
            </div>

            <div>
              <label class="block text-xs font-semibold text-neutral-300 mb-1.5">Contact Section Subtitle Paragraph</label>
              <textarea 
                v-model="form.contact_subtitle" 
                rows="3" 
                placeholder="Have a project in mind, a software engineering role to discuss, or just want to talk tech? Drop a message or connect directly."
                class="w-full p-3.5 rounded-[8px] border border-neutral-800 bg-neutral-900/60 text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-white focus:outline-none transition-colors leading-relaxed"
              ></textarea>
            </div>
          </div>

          <!-- Section 2: Contact Info Badges & Metadata -->
          <div class="rounded-xl border border-neutral-800 bg-neutral-900/40 p-5 space-y-4 shadow-sm">
            <div class="flex items-center space-x-2 border-b border-neutral-800 pb-3">
              <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
              <h3 class="text-xs font-bold text-white uppercase tracking-wider">Contact Detail Badges</h3>
            </div>

            <div>
              <label class="block text-xs font-semibold text-neutral-300 mb-1.5">Direct Email Address</label>
              <input 
                v-model="form.contact_email" 
                type="email" 
                placeholder="kashif.khan@example.com"
                class="w-full h-10 px-3.5 rounded-[8px] border border-neutral-800 bg-neutral-900/60 text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-white focus:outline-none transition-colors font-mono text-[11px]" 
              />
            </div>

            <div>
              <label class="block text-xs font-semibold text-neutral-300 mb-1.5">Location &amp; Work Terms</label>
              <input 
                v-model="form.contact_location" 
                type="text" 
                placeholder="Worldwide (Remote / On-site)"
                class="w-full h-10 px-3.5 rounded-[8px] border border-neutral-800 bg-neutral-900/60 text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-white focus:outline-none transition-colors" 
              />
            </div>

            <div>
              <label class="block text-xs font-semibold text-neutral-300 mb-1.5">Response Time Badge Text</label>
              <input 
                v-model="form.contact_response_time" 
                type="text" 
                placeholder="Typical Response Time: < 24 Hours"
                class="w-full h-10 px-3.5 rounded-[8px] border border-neutral-800 bg-neutral-900/60 text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-white focus:outline-none transition-colors" 
              />
            </div>
          </div>

          <!-- Section 3: Form Card UI Settings -->
          <div class="rounded-xl border border-neutral-800 bg-neutral-900/40 p-5 space-y-4 shadow-sm">
            <div class="flex items-center space-x-2 border-b border-neutral-800 pb-3">
              <span class="w-2 h-2 rounded-full bg-amber-400"></span>
              <h3 class="text-xs font-bold text-white uppercase tracking-wider">Form UI Header &amp; CTA</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-neutral-300 mb-1.5">Form Card Title</label>
                <input 
                  v-model="form.contact_form_title" 
                  type="text" 
                  placeholder="Send a Message"
                  class="w-full h-10 px-3.5 rounded-[8px] border border-neutral-800 bg-neutral-900/60 text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-white focus:outline-none transition-colors" 
                />
              </div>

              <div>
                <label class="block text-xs font-semibold text-neutral-300 mb-1.5">Submit Button Text</label>
                <input 
                  v-model="form.contact_submit_btn_text" 
                  type="text" 
                  placeholder="SEND MESSAGE"
                  class="w-full h-10 px-3.5 rounded-[8px] border border-neutral-800 bg-neutral-900/60 text-neutral-100 text-xs placeholder:text-neutral-500 focus:border-white focus:outline-none transition-colors font-mono" 
                />
              </div>
            </div>
          </div>

        </div>

        <!-- RIGHT: Interactive Live Canvas Preview (7 Cols) -->
        <div class="lg:col-span-7 sticky top-24">
          <div class="rounded-2xl border border-neutral-800 bg-neutral-950 p-6 sm:p-8 space-y-6 shadow-2xl overflow-hidden relative">
            
            <!-- Canvas Live Indicator Badge -->
            <div class="flex items-center justify-between border-b border-neutral-800/80 pb-4">
              <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-300">Live Landing Page Canvas Preview</span>
              </div>
              <span class="text-[10px] font-mono text-neutral-500">2-Column Layout</span>
            </div>

            <!-- Preview Contact Section Grid -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start pt-2">
              
              <!-- LEFT COLUMN: Pitch & Info Cards -->
              <div class="md:col-span-6 space-y-6">
                
                <!-- Headline Title -->
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-tight">
                  {{ form.contact_headline_title || "Let's build something extraordinary together." }}
                </h2>

                <!-- Subtitle Paragraph -->
                <p class="text-neutral-400 text-xs sm:text-sm leading-relaxed">
                  {{ form.contact_subtitle || "Have a project in mind, a software engineering role to discuss, or just want to talk tech? Drop a message or connect directly." }}
                </p>

                <!-- Info Cards -->
                <div class="space-y-2.5 pt-1">
                  <!-- Email Pill -->
                  <div class="p-3 rounded-lg bg-neutral-900/80 border border-neutral-800/80 flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-md bg-neutral-800 border border-neutral-700 text-neutral-300 flex items-center justify-center shrink-0">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                      </svg>
                    </div>
                    <div class="min-w-0">
                      <p class="text-[9px] font-mono uppercase tracking-widest text-neutral-400 font-semibold">Direct Email</p>
                      <p class="text-xs font-bold text-white truncate font-mono">{{ form.contact_email || "kashif.khan@example.com" }}</p>
                    </div>
                  </div>

                  <!-- Location Pill -->
                  <div class="p-3 rounded-lg bg-neutral-900/80 border border-neutral-800/80 flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-md bg-neutral-800 border border-neutral-700 text-emerald-400 flex items-center justify-center shrink-0">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                      </svg>
                    </div>
                    <div class="min-w-0">
                      <p class="text-[9px] font-mono uppercase tracking-widest text-neutral-400 font-semibold">Location &amp; Work</p>
                      <p class="text-xs font-bold text-white truncate">{{ form.contact_location || "Worldwide (Remote / On-site)" }}</p>
                    </div>
                  </div>
                </div>

                <!-- Response Time Badge -->
                <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-md bg-neutral-900 border border-neutral-800 text-[11px] text-neutral-300 font-mono">
                  <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                  <span>{{ form.contact_response_time || "Typical Response Time: < 24 Hours" }}</span>
                </div>

              </div>

              <!-- RIGHT COLUMN: Contact Message Form Card Preview -->
              <div class="md:col-span-6">
                <div class="p-5 rounded-xl border border-neutral-800 bg-neutral-900/50 space-y-4 shadow-lg">
                  <h3 class="text-base font-bold text-white tracking-tight">
                    {{ form.contact_form_title || "Send a Message" }}
                  </h3>

                  <!-- Disabled Preview Inputs -->
                  <div class="grid grid-cols-2 gap-3">
                    <div>
                      <label class="block text-[10px] font-mono text-neutral-400 uppercase tracking-wider mb-1">Your Name</label>
                      <div class="h-9 px-3 rounded-md border border-neutral-800 bg-neutral-950 text-neutral-500 text-xs flex items-center">
                        John Doe
                      </div>
                    </div>

                    <div>
                      <label class="block text-[10px] font-mono text-neutral-400 uppercase tracking-wider mb-1">Your Email</label>
                      <div class="h-9 px-3 rounded-md border border-neutral-800 bg-neutral-950 text-neutral-500 text-xs flex items-center">
                        john@example.com
                      </div>
                    </div>
                  </div>

                  <div>
                    <label class="block text-[10px] font-mono text-neutral-400 uppercase tracking-wider mb-1">Subject</label>
                    <div class="h-9 px-3 rounded-md border border-neutral-800 bg-neutral-950 text-neutral-500 text-xs flex items-center">
                      Project Inquiry
                    </div>
                  </div>

                  <div>
                    <label class="block text-[10px] font-mono text-neutral-400 uppercase tracking-wider mb-1">Message</label>
                    <div class="h-16 p-3 rounded-md border border-neutral-800 bg-neutral-950 text-neutral-500 text-xs">
                      Your message...
                    </div>
                  </div>

                  <button
                    type="button"
                    disabled
                    class="w-full h-10 rounded-md bg-white text-black font-bold text-xs uppercase tracking-wider flex items-center justify-center shadow-md opacity-90 cursor-not-allowed"
                  >
                    {{ form.contact_submit_btn_text || "SEND MESSAGE" }}
                  </button>
                </div>
              </div>

            </div>

          </div>
        </div>

      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useToast } from '@/Composables/useToast';

const props = defineProps({
  settings: Object,
});

const { toast } = useToast();
const isSubmitting = ref(false);

const form = useForm({
  contact_headline_title: props.settings?.contact_headline_title || "Let's build something extraordinary together.",
  contact_subtitle: props.settings?.contact_subtitle || "Have a project in mind, a software engineering role to discuss, or just want to talk tech? Drop a message or connect directly.",
  contact_email: props.settings?.contact_email || "kashif.khan@example.com",
  contact_location: props.settings?.contact_location || "Worldwide (Remote / On-site)",
  contact_response_time: props.settings?.contact_response_time || "Typical Response Time: < 24 Hours",
  contact_form_title: props.settings?.contact_form_title || "Send a Message",
  contact_submit_btn_text: props.settings?.contact_submit_btn_text || "SEND MESSAGE",
});

async function submitForm() {
  isSubmitting.value = true;
  try {
    await axios.post(route('admin.contact.update'), {
      contact_headline_title: form.contact_headline_title,
      contact_subtitle: form.contact_subtitle,
      contact_email: form.contact_email,
      contact_location: form.contact_location,
      contact_response_time: form.contact_response_time,
      contact_form_title: form.contact_form_title,
      contact_submit_btn_text: form.contact_submit_btn_text,
    });
    toast({
      title: 'Contact Section Saved',
      description: 'Contact pitch and form settings updated live.',
      type: 'success',
    });
  } catch (error) {
    toast({
      title: 'Save Failed',
      description: 'An error occurred while saving contact section settings.',
      type: 'error',
    });
  } finally {
    isSubmitting.value = false;
  }
}
</script>
