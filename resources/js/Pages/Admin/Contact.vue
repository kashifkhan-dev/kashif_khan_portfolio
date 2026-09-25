<template>
  <AuthenticatedLayout>
    <template #header>Contact Section Manager</template>
    <Head title="Contact Section Manager - Admin" />

    <div class="space-y-6">
      <!-- Page Title Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-border pb-5">
        <div>
          <h1 class="text-2xl font-bold tracking-tight text-foreground">
            Contact Section Manager
          </h1>
          <p class="text-xs text-muted-foreground mt-1">
            Customize the landing page contact headline, subtitle, direct email, and meeting booking link.
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

      <!-- Main Grid: Form Controls (Left) + Clean Live Canvas (Right) -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- LEFT: Administrative Input Controls (6 Cols) -->
        <div class="lg:col-span-6 space-y-5">
          
          <!-- Card 1: Headline Pitch & Subtext -->
          <div class="rounded-xl border border-border bg-card p-5 space-y-4 shadow-xs">
            <div class="flex items-center gap-2 border-b border-border pb-3 text-sm font-semibold text-foreground">
              <Sparkles class="h-4 w-4 text-primary" />
              <span>Headline &amp; Subtitle</span>
            </div>

            <div class="space-y-1.5">
              <label class="font-medium text-foreground text-xs">
                Section Headline Title
              </label>
              <input 
                v-model="form.contact_headline_title" 
                type="text" 
                placeholder="Get in Touch"
                class="w-full h-9 px-3 rounded-lg border border-input bg-background text-foreground text-xs placeholder:text-muted-foreground focus:ring-1 focus:ring-ring outline-none transition-colors" 
              />
            </div>

            <div class="space-y-1.5">
              <label class="font-medium text-foreground text-xs">
                Subtitle / Pitch
              </label>
              <textarea 
                v-model="form.contact_subtitle" 
                rows="3" 
                placeholder="e.g. Wanna chat? Let's {cal} or drop an {email}. I will be ignoring all soliciting."
                class="w-full p-3 rounded-lg border border-input bg-background text-foreground text-xs leading-relaxed placeholder:text-muted-foreground focus:ring-1 focus:ring-ring outline-none transition-colors"
              ></textarea>
              <p class="text-[11px] text-muted-foreground">
                Tip: Use <code class="font-mono text-primary font-semibold">{cal}</code> to insert your meeting link and <code class="font-mono text-primary font-semibold">{email}</code> to insert your email link anywhere. Leave blank to use the default message.
              </p>
            </div>
          </div>

          <!-- Card 2: Channels & Booking -->
          <div class="rounded-xl border border-border bg-card p-5 space-y-4 shadow-xs">
            <div class="flex items-center gap-2 border-b border-border pb-3 text-sm font-semibold text-foreground">
              <Mail class="h-4 w-4 text-primary" />
              <span>Direct Channels &amp; Booking</span>
            </div>

            <div class="space-y-1.5">
              <label class="font-medium text-foreground text-xs">
                Direct Email Address
              </label>
              <input 
                v-model="form.contact_email" 
                type="email" 
                placeholder="kashifkhannee@gmail.com"
                class="w-full h-9 px-3 rounded-lg border border-input bg-background text-foreground text-xs font-mono placeholder:text-muted-foreground focus:ring-1 focus:ring-ring outline-none transition-colors" 
              />
            </div>

            <div class="space-y-1.5">
              <label class="font-medium text-foreground text-xs">
                Meeting URL (Cal.com / Calendly)
              </label>
              <input 
                v-model="form.cal_url" 
                type="text" 
                placeholder="https://cal.com/kashif-khan"
                class="w-full h-9 px-3 rounded-lg border border-input bg-background text-foreground text-xs font-mono placeholder:text-muted-foreground focus:ring-1 focus:ring-ring outline-none transition-colors" 
              />
            </div>


          </div>

          <!-- Save Button -->
          <div class="flex justify-end pt-1">
            <button
              @click="submitForm"
              :disabled="isSubmitting"
              class="h-9 px-6 rounded-lg bg-primary hover:bg-primary/90 text-primary-foreground font-semibold text-xs transition-all shadow-xs cursor-pointer disabled:opacity-50 flex items-center gap-2"
            >
              <Loader2 v-if="isSubmitting" class="h-3.5 w-3.5 animate-spin" />
              <Save v-else class="h-3.5 w-3.5" />
              <span>{{ isSubmitting ? 'Saving Changes...' : 'Save Changes' }}</span>
            </button>
          </div>

        </div>

        <!-- RIGHT: Interactive Live Canvas Preview matching Welcome.vue (6 Cols) -->
        <div class="lg:col-span-6 sticky top-20">
          <div class="rounded-xl border border-border bg-card p-5 space-y-5 shadow-xs overflow-hidden">
            
            <div class="flex items-center justify-between border-b border-border pb-3">
              <div class="flex items-center gap-2">
                <span class="size-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-semibold text-foreground">Live Portfolio Preview</span>
              </div>

            </div>

            <!-- Preview Card matching Welcome.vue Section 9 -->
            <div class="border border-border rounded-xl p-8 relative bg-background text-center shadow-xs">
              <!-- Floating Pill Badge on Top Edge -->
              <div class="absolute -top-3.5 border border-border bg-primary text-primary-foreground z-10 rounded-xl px-4 py-1 left-1/2 -translate-x-1/2 shadow-xs select-none">
                <span class="text-xs font-medium">Contact</span>
              </div>

              <!-- Content Body -->
              <div class="relative flex flex-col items-center gap-3 text-center z-10 pt-2">
                <h3 class="text-2xl sm:text-3xl font-bold tracking-tight text-foreground">
                  {{ form.contact_headline_title || 'Get in Touch' }}
                </h3>

                <p v-if="form.contact_subtitle" class="mx-auto max-w-md text-muted-foreground text-xs leading-relaxed" v-html="previewFormattedSubtitle">
                </p>

                <p v-else class="mx-auto max-w-md text-muted-foreground text-xs leading-relaxed">
                  Wanna chat? Let's
                  <a
                    :href="form.cal_url || 'https://cal.com/kashif-khan'"
                    target="_blank"
                    class="text-blue-500 hover:underline font-medium"
                  >
                    schedule a meet!
                  </a>
                  or drop an
                  <a
                    :href="`mailto:${form.contact_email || 'kashifkhannee@gmail.com'}`"
                    class="text-blue-500 hover:underline font-medium"
                  >
                    email
                  </a>. I will be ignoring all soliciting.
                </p>
              </div>

              <!-- Direct Channel Pills -->
              <div class="mt-6 pt-5 border-t border-border/60 flex flex-wrap items-center justify-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-muted/40 border border-border text-[11px] font-mono text-muted-foreground">
                  <span class="size-1.5 rounded-full bg-emerald-500"></span>
                  {{ form.contact_email || 'kashifkhannee@gmail.com' }}
                </span>

              </div>
            </div>


          </div>
        </div>

      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useToast } from '@/Composables/useToast';
import {
  Sparkles,
  Mail,
  Save,
  Loader2,
} from 'lucide-vue-next';

const props = defineProps({
  settings: Object,
});

const { toast } = useToast();
const isSubmitting = ref(false);

const form = useForm({
  contact_headline_title: props.settings?.contact_headline_title || 'Get in Touch',
  contact_subtitle: props.settings?.contact_subtitle || '',
  contact_email: props.settings?.contact_email || 'kashifkhannee@gmail.com',
  cal_url: props.settings?.cal_url || 'https://cal.com/kashif-khan',
});

const previewFormattedSubtitle = computed(() => {
  if (!form.contact_subtitle) return '';
  let text = form.contact_subtitle;
  const calLink = `<a href="${form.cal_url || 'https://cal.com/kashif-khan'}" target="_blank" class="text-blue-500 hover:underline font-medium">schedule a meet!</a>`;
  const emailLink = `<a href="mailto:${form.contact_email || 'kashifkhannee@gmail.com'}" class="text-blue-500 hover:underline font-medium">email</a>`;
  text = text.replace(/\{cal\}/gi, calLink);
  text = text.replace(/\{email\}/gi, emailLink);
  return text;
});

async function submitForm() {
  isSubmitting.value = true;
  try {
    await axios.post(route('admin.contact.update'), {
      contact_headline_title: form.contact_headline_title,
      contact_subtitle: form.contact_subtitle,
      contact_email: form.contact_email,
      cal_url: form.cal_url,
    });
    toast({
      title: 'Contact Section Saved',
      description: 'Your contact section settings have been updated live.',
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
