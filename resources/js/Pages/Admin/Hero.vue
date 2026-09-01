<template>
  <AuthenticatedLayout>
    <template #header>Hero Section Editor</template>
    <Head title="Hero Section Editor - Admin" />

    <div class="space-y-8 max-w-5xl mx-auto">
      <!-- Top Title Header -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h2 class="text-2xl font-extrabold text-foreground tracking-tight">Hero Section Manager</h2>
          <p class="text-xs text-muted-foreground mt-1">Customize your portfolio's hero headline, availability badge, description text, and call-to-action buttons in real-time.</p>
        </div>
      </div>

      <!-- LIVE PREVIEW CARD -->
      <div class="rounded-2xl border border-neutral-800 bg-neutral-950 p-6 sm:p-8 space-y-6 shadow-2xl relative overflow-hidden">
        <div class="flex items-center justify-between border-b border-neutral-800 pb-4">
          <div class="flex items-center space-x-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span class="text-xs font-mono font-semibold uppercase tracking-wider text-neutral-400">Live Landing Page Preview</span>
          </div>
          <span class="text-[10px] font-mono px-2 py-0.5 rounded bg-neutral-900 border border-neutral-800 text-neutral-400">Hero Canvas</span>
        </div>

        <div class="py-6 text-center space-y-6 max-w-3xl mx-auto">
          <!-- Status Pill Preview -->
          <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-md bg-neutral-900 border border-neutral-800 text-neutral-300 text-xs font-mono">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>{{ form.availability_status || 'Available for Full-time Roles & Contracts' }}</span>
          </div>

          <!-- Headline Preview -->
          <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight text-white">
            <span>{{ form.hero_title_1 || "Hi, I'm Kashif Khan." }}</span> <br v-if="form.hero_title_2" />
            <span class="text-neutral-300">{{ form.hero_title_2 || "Full-Stack Web Engineer." }}</span>
          </h1>

          <!-- Subtitle Preview -->
          <p class="text-sm sm:text-base text-neutral-400 leading-relaxed max-w-2xl mx-auto font-sans">
            {{ form.hero_subtitle || "Specializing in React.js, Next.js, Vue 3, Laravel, Tailwind CSS, and modern web applications. Over 5+ years of experience building fast, reliable digital products." }}
          </p>

          <!-- Buttons Preview -->
          <div class="pt-2 flex flex-wrap items-center justify-center gap-4">
            <span class="px-6 py-2.5 rounded-md bg-white text-black font-bold text-xs shadow-md">
              {{ form.hero_cta_primary_text || 'View My Projects' }}
            </span>
            <span class="px-6 py-2.5 rounded-md bg-neutral-900 border border-neutral-800 text-neutral-200 font-semibold text-xs">
              {{ form.hero_cta_secondary_text || 'Get in Touch' }}
            </span>
          </div>
        </div>
      </div>

      <!-- FORM CONTAINER -->
      <div class="rounded-2xl border border-neutral-800 bg-neutral-950 p-6 sm:p-8 space-y-6 shadow-xl">
        <form @submit.prevent="submitForm" class="space-y-6">
          
          <!-- Availability Status Badge -->
          <div>
            <label class="block text-xs font-sans font-bold uppercase tracking-wider text-neutral-300 mb-2">
              Availability Status Badge
            </label>
            <input
              v-model="form.availability_status"
              type="text"
              placeholder="Available for Full-time Roles & Contracts"
              class="w-full px-4 py-3 rounded-md bg-neutral-900 border border-neutral-800 text-white text-sm focus:border-white focus:ring-0 transition-colors"
            />
            <p class="text-[11px] text-neutral-500 mt-1">Displayed in the top status pill above the main headline.</p>
          </div>

          <!-- Hero Headline (Line 1 & Line 2) -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
              <label class="block text-xs font-sans font-bold uppercase tracking-wider text-neutral-300 mb-2">
                Headline Line 1
              </label>
              <input
                v-model="form.hero_title_1"
                type="text"
                placeholder="Hi, I'm Kashif Khan."
                class="w-full px-4 py-3 rounded-md bg-neutral-900 border border-neutral-800 text-white text-sm focus:border-white focus:ring-0 transition-colors"
              />
            </div>

            <div>
              <label class="block text-xs font-sans font-bold uppercase tracking-wider text-neutral-300 mb-2">
                Headline Line 2
              </label>
              <input
                v-model="form.hero_title_2"
                type="text"
                placeholder="Full-Stack Web Engineer."
                class="w-full px-4 py-3 rounded-md bg-neutral-900 border border-neutral-800 text-white text-sm focus:border-white focus:ring-0 transition-colors"
              />
            </div>
          </div>

          <!-- Subtitle / Bio Paragraph -->
          <div>
            <label class="block text-xs font-sans font-bold uppercase tracking-wider text-neutral-300 mb-2">
              Hero Description Paragraph
            </label>
            <textarea
              v-model="form.hero_subtitle"
              rows="4"
              placeholder="Specializing in React.js, Next.js, Vue 3, Laravel, Tailwind CSS, and modern web applications..."
              class="w-full px-4 py-3 rounded-md bg-neutral-900 border border-neutral-800 text-white text-sm leading-relaxed focus:border-white focus:ring-0 transition-colors"
            ></textarea>
          </div>

          <!-- CTA Buttons Grid -->
          <div class="pt-4 border-t border-neutral-800 space-y-6">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider font-mono">Action Buttons Configuration</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <!-- Primary CTA -->
              <div class="p-4 rounded-md bg-neutral-900/60 border border-neutral-800 space-y-4">
                <span class="text-xs font-bold text-neutral-300 block">Primary Action Button (White BG)</span>
                <div>
                  <label class="block text-[11px] text-neutral-400 mb-1">Button Label</label>
                  <input
                    v-model="form.hero_cta_primary_text"
                    type="text"
                    placeholder="View My Projects"
                    class="w-full px-3.5 py-2 rounded-md bg-neutral-900 border border-neutral-800 text-white text-xs"
                  />
                </div>
                <div>
                  <label class="block text-[11px] text-neutral-400 mb-1">Target Section Link / URL</label>
                  <input
                    v-model="form.hero_cta_primary_link"
                    type="text"
                    placeholder="#projects"
                    class="w-full px-3.5 py-2 rounded-md bg-neutral-900 border border-neutral-800 text-white text-xs font-mono"
                  />
                </div>
              </div>

              <!-- Secondary CTA -->
              <div class="p-4 rounded-md bg-neutral-900/60 border border-neutral-800 space-y-4">
                <span class="text-xs font-bold text-neutral-300 block">Secondary Action Button (Dark BG)</span>
                <div>
                  <label class="block text-[11px] text-neutral-400 mb-1">Button Label</label>
                  <input
                    v-model="form.hero_cta_secondary_text"
                    type="text"
                    placeholder="Get in Touch"
                    class="w-full px-3.5 py-2 rounded-md bg-neutral-900 border border-neutral-800 text-white text-xs"
                  />
                </div>
                <div>
                  <label class="block text-[11px] text-neutral-400 mb-1">Target Section Link / URL</label>
                  <input
                    v-model="form.hero_cta_secondary_link"
                    type="text"
                    placeholder="#contact"
                    class="w-full px-3.5 py-2 rounded-md bg-neutral-900 border border-neutral-800 text-white text-xs font-mono"
                  />
                </div>
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="pt-6 border-t border-neutral-800 flex justify-end">
            <button
              type="submit"
              :disabled="isSubmitting"
              class="px-6 py-3 rounded-md bg-white hover:bg-neutral-200 text-black font-extrabold text-sm shadow-xl transition-all transform hover:scale-[1.02] flex items-center space-x-2 disabled:opacity-50 cursor-pointer"
            >
              <svg v-if="isSubmitting" class="animate-spin h-4 w-4 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span>{{ isSubmitting ? 'Saving Changes...' : 'Save Hero Content' }}</span>
            </button>
          </div>
        </form>
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
  availability_status: props.settings?.availability_status || 'Available for Full-time Roles & Contracts',
  hero_title_1: props.settings?.hero_title_1 || "Hi, I'm Kashif Khan.",
  hero_title_2: props.settings?.hero_title_2 || "Full-Stack Web Engineer.",
  hero_subtitle: props.settings?.hero_subtitle || "Specializing in React.js, Next.js, Vue 3, Laravel, Tailwind CSS, and modern web applications. Over 5+ years of experience building fast, reliable digital products.",
  hero_cta_primary_text: props.settings?.hero_cta_primary_text || 'View My Projects',
  hero_cta_primary_link: props.settings?.hero_cta_primary_link || '#projects',
  hero_cta_secondary_text: props.settings?.hero_cta_secondary_text || 'Get in Touch',
  hero_cta_secondary_link: props.settings?.hero_cta_secondary_link || '#contact',
});

async function submitForm() {
  isSubmitting.value = true;
  try {
    await axios.post(route('admin.hero.update'), {
      availability_status: form.availability_status,
      hero_title_1: form.hero_title_1,
      hero_title_2: form.hero_title_2,
      hero_subtitle: form.hero_subtitle,
      hero_cta_primary_text: form.hero_cta_primary_text,
      hero_cta_primary_link: form.hero_cta_primary_link,
      hero_cta_secondary_text: form.hero_cta_secondary_text,
      hero_cta_secondary_link: form.hero_cta_secondary_link,
    });
    toast({
      title: 'Hero Content Updated',
      description: 'Your hero section changes have been updated live on your portfolio.',
      type: 'success',
    });
  } catch (error) {
    toast({
      title: 'Update Failed',
      description: 'Failed to update hero settings. Please check your inputs.',
      type: 'error',
    });
  } finally {
    isSubmitting.value = false;
  }
}
</script>
