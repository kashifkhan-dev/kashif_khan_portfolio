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
          <div class="hidden sm:flex w-10 h-10 rounded-md bg-white text-black font-extrabold text-base items-center justify-center group-hover:scale-105 transition-transform">
            KK
          </div>
          <div class="flex items-center space-x-2">
            <span class="font-bold text-lg sm:text-xl text-white tracking-tight">Kashif Khan</span>
            <span class="text-sm sm:text-base text-neutral-300 font-sans font-medium">/ dev</span>
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
            class="hidden md:inline-flex px-5 py-2.5 text-sm font-bold rounded-md bg-white hover:bg-neutral-200 text-black shadow-lg transition-all transform hover:scale-[1.02]"
          >
            Get in Touch
          </a>

          <!-- Mobile Hamburger -->
          <button
            @click="mobileMenuOpen = !mobileMenuOpen"
            class="md:hidden p-2 rounded-lg text-neutral-300 hover:text-white hover:bg-neutral-900/80 transition-colors focus:outline-none"
            aria-label="Toggle menu"
          >
            <svg v-if="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
      </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <Teleport to="body">
      <div v-if="mobileMenuOpen" class="fixed inset-0 z-50 md:hidden">
        <!-- Backdrop Fade -->
        <Transition
          enter-active-class="transition-opacity duration-300 ease-out"
          enter-from-class="opacity-0"
          enter-to-class="opacity-100"
          leave-active-class="transition-opacity duration-200 ease-in"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
          appear
        >
          <div class="absolute inset-0 bg-black/80 backdrop-blur-md" @click="mobileMenuOpen = false"></div>
        </Transition>

        <!-- Drawer Slide in from Right (NexusCorp Style) -->
        <Transition
          enter-active-class="transition-transform duration-300 ease-out"
          enter-from-class="translate-x-full"
          enter-to-class="translate-x-0"
          leave-active-class="transition-transform duration-200 ease-in"
          leave-from-class="translate-x-0"
          leave-to-class="translate-x-full"
          appear
        >
          <div class="absolute top-0 right-0 w-80 max-w-[85vw] h-full bg-neutral-950 border-l border-neutral-800/80 p-6 pt-6 flex flex-col justify-between shadow-2xl z-10">
            <div>
              <!-- Header inside drawer -->
              <div class="flex items-center justify-between pb-6 border-b border-neutral-800/80">
                <div class="flex items-center space-x-3">
                  <div class="w-9 h-9 rounded-xl bg-white text-black font-extrabold text-sm flex items-center justify-center shadow-md">
                    KK
                  </div>
                  <div>
                    <div class="font-extrabold text-base text-white tracking-tight leading-none">Kashif Khan</div>
                    <div class="text-[11px] text-neutral-400 font-sans mt-0.5">Full-Stack Engineer</div>
                  </div>
                </div>
                <button
                  @click="mobileMenuOpen = false"
                  class="w-8 h-8 rounded-lg text-neutral-400 hover:text-white hover:bg-neutral-900 flex items-center justify-center transition-colors"
                  aria-label="Close menu"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                </button>
              </div>

              <!-- Navigation Links with Icons -->
              <nav class="flex flex-col space-y-1.5 pt-6">
                <a
                  v-for="link in navLinks"
                  :key="link.href"
                  :href="link.href"
                  @click="mobileMenuOpen = false"
                  class="text-sm font-semibold px-4 py-3 rounded-xl transition-all flex items-center space-x-3.5 group"
                  :class="activeSection === link.id
                    ? 'bg-neutral-800/90 text-white font-bold shadow-md border border-neutral-700/60'
                    : 'text-neutral-300 hover:text-white hover:bg-neutral-900/80'"
                >
                  <span class="w-5 h-5 flex items-center justify-center shrink-0 transition-colors" :class="activeSection === link.id ? 'text-white' : 'text-neutral-400 group-hover:text-white'">
                    <!-- User Icon for About -->
                    <svg v-if="link.id === 'about'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <!-- Code Icon for Skills -->
                    <svg v-else-if="link.id === 'skills'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                    <!-- Grid Icon for Projects -->
                    <svg v-else-if="link.id === 'projects'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    <!-- Briefcase Icon for Experience -->
                    <svg v-else-if="link.id === 'experience'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <!-- Mail Icon for Contact -->
                    <svg v-else-if="link.id === 'contact'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                  </span>
                  <span>{{ link.label }}</span>
                </a>

                <div class="border-t border-neutral-800/80 pt-4 mt-2" v-if="canLogin">
                  <Link
                    :href="route('login')"
                    @click="mobileMenuOpen = false"
                    class="text-sm font-semibold text-neutral-300 hover:text-white px-4 py-3 rounded-xl hover:bg-neutral-900 border border-neutral-800/60 flex items-center space-x-3.5 transition-all group"
                  >
                    <svg class="w-5 h-5 text-neutral-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Admin Dashboard</span>
                  </Link>
                </div>
              </nav>
            </div>

            <!-- Drawer Bottom CTA (Get in Touch Button) -->
            <div class="pt-6 border-t border-neutral-800/80">
              <a
                href="#contact"
                @click="mobileMenuOpen = false"
                class="w-full block text-center px-5 py-3.5 text-sm font-bold rounded-xl bg-white hover:bg-neutral-200 text-black shadow-xl transition-all active:scale-[0.98]"
              >
                Get in Touch
              </a>
            </div>
          </div>
        </Transition>
      </div>
    </Teleport>

    <!-- Main Content -->
    <main class="flex-grow pt-20">
      <slot />
    </main>

    <!-- Toast Notification -->
    <ToastNotification />

    <!-- Pure Black Footer -->
    <footer class="border-t border-neutral-800 py-8 sm:py-10 bg-black relative">
      <div class="w-full max-w-[1500px] mx-auto px-4 sm:px-8 lg:px-12 flex flex-col md:flex-row items-center justify-between gap-6">
        <!-- Left: Logo & Copyright -->
        <div class="flex items-center space-x-3 text-center sm:text-left">
          <div class="hidden sm:flex w-7 h-7 rounded bg-white text-black font-bold text-xs items-center justify-center shrink-0">
            KK
          </div>
          <span class="text-xs sm:text-sm text-neutral-400 font-sans leading-relaxed">
            &copy; {{ new Date().getFullYear() }} Kashif Khan &bull; Built with Laravel, Vue 3 &amp; Tailwind CSS.
          </span>
        </div>

        <!-- Right: Social Links + Upward Arrow -->
        <div class="w-full md:w-auto flex items-center justify-between md:justify-end space-x-4 sm:space-x-8 text-xs sm:text-sm font-sans">
          <div class="flex items-center space-x-4 sm:space-x-6">
            <a :href="settings?.github_url || '#'" target="_blank" class="text-neutral-300 hover:text-white transition-colors">GitHub</a>
            <a :href="settings?.linkedin_url || '#'" target="_blank" class="text-neutral-300 hover:text-white transition-colors">LinkedIn</a>
            <a :href="settings?.twitter_url || '#'" target="_blank" class="text-neutral-300 hover:text-white transition-colors">Twitter / X</a>
          </div>

          <!-- Back to Top Button (White Circle) -->
          <button
            @click="scrollToTop"
            aria-label="Back to Top"
            title="Back to Top"
            class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white hover:bg-neutral-200 text-black flex items-center justify-center transition-all shadow-xl transform hover:scale-110 shrink-0 cursor-pointer"
          >
            <svg class="w-4 h-4 sm:w-5 sm:h-5 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
            </svg>
          </button>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue';
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

watch(mobileMenuOpen, (val) => {
  if (val) {
    document.body.style.overflow = 'hidden';
  } else {
    document.body.style.overflow = '';
  }
});

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
