<template>
  <div class="min-h-screen bg-black text-neutral-100 selection:bg-white selection:text-black flex flex-col font-sans relative">
    <!-- Navigation Bar -->
    <header
      :class="[
        'fixed top-0 left-0 right-0 z-50 transition-all duration-300',
        isScrolled
          ? 'bg-black/90 backdrop-blur-md border-b border-neutral-800 shadow-xl'
          : 'bg-transparent border-b border-neutral-800/60'
      ]"
    >
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        <!-- Logo -->
        <Link href="/" class="flex items-center space-x-3 group">
          <div class="w-10 h-10 rounded-md bg-white text-black font-extrabold text-base flex items-center justify-center group-hover:scale-105 transition-transform">
            KK
          </div>
          <div class="flex items-center space-x-2">
            <span class="font-bold text-lg text-white tracking-tight">Kashif Khan</span>
            <span class="text-xs text-neutral-400 font-sans">/ dev</span>
          </div>
        </Link>

        <!-- Navigation Links -->
        <nav class="hidden md:flex items-center space-x-8">
          <a
            v-for="link in navLinks"
            :key="link.href"
            :href="link.href"
            class="text-sm text-neutral-300 hover:text-white font-medium transition-colors"
            :class="{ 'text-white font-bold underline underline-offset-4': activeSection === link.id }"
          >
            {{ link.label }}
          </a>
        </nav>

        <!-- Actions -->
        <div class="flex items-center space-x-4">
          <Link
            v-if="canLogin"
            :href="route('login')"
            class="hidden sm:inline-flex px-4 py-2 text-sm font-semibold rounded-md bg-neutral-900 hover:bg-neutral-800 border border-neutral-800 text-neutral-200 hover:text-white transition-all"
          >
            Admin Dashboard
          </Link>
          <a
            href="#contact"
            class="px-5 py-2.5 text-sm font-bold rounded-md bg-white hover:bg-neutral-200 text-black shadow-lg transition-all transform hover:scale-[1.02]"
          >
            Get in Touch
          </a>

          <!-- Mobile Hamburger -->
          <button
            @click="mobileMenuOpen = !mobileMenuOpen"
            class="md:hidden p-2 text-neutral-400 hover:text-white"
            aria-label="Toggle menu"
          >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
        </div>
      </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <Teleport to="body">
      <div v-if="mobileMenuOpen" class="fixed inset-0 z-50 md:hidden">
        <div class="absolute inset-0 bg-black/90 backdrop-blur-md" @click="mobileMenuOpen = false"></div>
        <div class="absolute top-0 right-0 w-72 h-full bg-black border-l border-neutral-800 p-6 pt-20 space-y-6">
          <button @click="mobileMenuOpen = false" class="absolute top-5 right-5 text-neutral-400 hover:text-white text-lg">
            ✕
          </button>
          <nav class="flex flex-col space-y-5">
            <a
              v-for="link in navLinks"
              :key="link.href"
              :href="link.href"
              @click="mobileMenuOpen = false"
              class="text-base font-medium text-neutral-200 hover:text-white"
            >
              {{ link.label }}
            </a>
            <div class="border-t border-neutral-800 pt-5" v-if="canLogin">
              <Link :href="route('login')" class="text-base font-medium text-neutral-300 hover:text-white">
                Admin Dashboard
              </Link>
            </div>
          </nav>
        </div>
      </div>
    </Teleport>

    <!-- Main Content -->
    <main class="flex-grow pt-20">
      <slot />
    </main>

    <!-- Toast Notification -->
    <ToastNotification />

    <!-- Pure Black Footer -->
    <footer class="border-t border-neutral-800 py-10 bg-black relative">
      <div class="w-full max-w-[1500px] mx-auto px-6 sm:px-8 lg:px-12 flex flex-col md:flex-row items-center justify-between gap-6">
        <!-- Left: Logo & Copyright -->
        <div class="flex items-center space-x-3">
          <div class="w-7 h-7 rounded bg-white text-black font-bold text-xs flex items-center justify-center">
            KK
          </div>
          <span class="text-sm text-neutral-400 font-sans">
            &copy; {{ new Date().getFullYear() }} Kashif Khan &bull; Built with Laravel, Vue 3 &amp; Tailwind CSS.
          </span>
        </div>

        <!-- Right: Social Links + Upward Arrow (White BG Circle at Far Right) -->
        <div class="flex items-center space-x-6 sm:space-x-8 text-sm font-sans">
          <a :href="settings?.github_url || '#'" target="_blank" class="text-neutral-300 hover:text-white transition-colors">GitHub</a>
          <a :href="settings?.linkedin_url || '#'" target="_blank" class="text-neutral-300 hover:text-white transition-colors">LinkedIn</a>
          <a :href="settings?.twitter_url || '#'" target="_blank" class="text-neutral-300 hover:text-white transition-colors">Twitter / X</a>

          <!-- Back to Top Button (White Circle) -->
          <button
            @click="scrollToTop"
            aria-label="Back to Top"
            title="Back to Top"
            class="w-11 h-11 rounded-full bg-white hover:bg-neutral-200 text-black flex items-center justify-center transition-all shadow-xl transform hover:scale-110 shrink-0 ml-4 cursor-pointer"
          >
            <svg class="w-5 h-5 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
            </svg>
          </button>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import ToastNotification from '@/Components/ToastNotification.vue';

defineProps({
  canLogin: Boolean,
  settings: Object,
});

const navLinks = [
  { href: '#about', label: 'About', id: 'about' },
  { href: '#skills', label: 'Skills', id: 'skills' },
  { href: '#projects', label: 'Projects', id: 'projects' },
  { href: '#experience', label: 'Experience', id: 'experience' },
  { href: '#contact', label: 'Contact', id: 'contact' },
];

const isScrolled = ref(false);
const mobileMenuOpen = ref(false);
const activeSection = ref('about');

function handleScroll() {
  isScrolled.value = window.scrollY > 40;
  const sections = navLinks.map(l => l.id);
  for (let i = sections.length - 1; i >= 0; i--) {
    const el = document.getElementById(sections[i]);
    if (el && el.getBoundingClientRect().top <= 180) {
      activeSection.value = sections[i];
      break;
    }
  }
}

function scrollToTop() {
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true });
  handleScroll();
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>
