<template>
  <div class="min-h-screen bg-[#030712] text-slate-100 selection:bg-blue-600 selection:text-white flex flex-col font-sans relative overflow-x-hidden">
    <!-- Ambient background light glows (Clean Sapphire Blue & Emerald) -->
    <div class="fixed top-0 left-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none -z-10 animate-glow"></div>
    <div class="fixed bottom-0 right-1/4 w-[30rem] h-[30rem] bg-emerald-600/10 rounded-full blur-3xl pointer-events-none -z-10 animate-glow" style="animation-delay: 2s"></div>

    <!-- Navigation Bar -->
    <header class="sticky top-0 z-40 glass-panel border-b border-slate-800/80 transition-all duration-300">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        <!-- Logo -->
        <Link href="/" class="flex items-center space-x-3 group">
          <div class="w-10 h-10 rounded-xl bg-slate-800 p-0.5 border border-slate-700 shadow-lg group-hover:border-blue-500 transition-colors duration-300">
            <div class="w-full h-full bg-slate-950 rounded-[10px] flex items-center justify-center font-bold text-white text-base">
              KK
            </div>
          </div>
          <div class="flex flex-col">
            <span class="font-bold text-lg text-white group-hover:text-blue-400 transition-colors tracking-tight">Kashif Khan</span>
            <span class="text-[10px] text-slate-400 tracking-wider uppercase font-medium">Software Engineer</span>
          </div>
        </Link>

        <!-- Desktop Navigation Links -->
        <nav class="hidden md:flex items-center space-x-8">
          <a href="#about" class="text-sm text-slate-300 hover:text-blue-400 font-medium transition-colors">About</a>
          <a href="#projects" class="text-sm text-slate-300 hover:text-blue-400 font-medium transition-colors">Projects</a>
          <a href="#skills" class="text-sm text-slate-300 hover:text-blue-400 font-medium transition-colors">Skills Matrix</a>
          <a href="#experience" class="text-sm text-slate-300 hover:text-blue-400 font-medium transition-colors">Experience</a>
          <a href="#contact" class="text-sm text-slate-300 hover:text-blue-400 font-medium transition-colors">Contact</a>
        </nav>

        <!-- Actions -->
        <div class="flex items-center space-x-4">
          <Link
            v-if="canLogin"
            :href="route('login')"
            class="px-4 py-2 text-xs font-semibold rounded-xl glass-card text-slate-300 hover:text-white hover:border-slate-700 transition-all shadow-sm"
          >
            Admin Panel
          </Link>
          <a
            href="#contact"
            class="px-5 py-2.5 text-xs font-bold rounded-xl bg-white hover:bg-slate-200 text-slate-950 shadow-lg shadow-white/10 transition-all transform hover:-translate-y-0.5"
          >
            Hire Me
          </a>
        </div>
      </div>
    </header>

    <!-- Main Body Content -->
    <main class="flex-grow">
      <slot />
    </main>

    <!-- Toast Notifications -->
    <ToastNotification />

    <!-- Footer -->
    <footer class="glass-panel border-t border-slate-800/80 py-12 mt-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center space-x-3">
          <div class="w-8 h-8 rounded-lg bg-blue-600/20 border border-blue-500/30 flex items-center justify-center text-blue-400 font-bold text-sm">
            KK
          </div>
          <p class="text-xs text-slate-400">
            &copy; {{ new Date().getFullYear() }} Kashif Khan. Built with Laravel 11, Vue 3 & Tailwind CSS.
          </p>
        </div>
        <div class="flex items-center space-x-6">
          <a :href="settings?.github_url || '#'" target="_blank" class="text-slate-400 hover:text-blue-400 text-xs transition-colors">GitHub</a>
          <a :href="settings?.linkedin_url || '#'" target="_blank" class="text-slate-400 hover:text-blue-400 text-xs transition-colors">LinkedIn</a>
          <a :href="settings?.twitter_url || '#'" target="_blank" class="text-slate-400 hover:text-blue-400 text-xs transition-colors">Twitter / X</a>
          <a href="#top" class="text-xs text-slate-400 hover:text-white flex items-center space-x-1">
            <span>Back to top</span>
            <span>&uarr;</span>
          </a>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import ToastNotification from '@/Components/ToastNotification.vue';

defineProps({
  canLogin: Boolean,
  settings: Object,
});
</script>
