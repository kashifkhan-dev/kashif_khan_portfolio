<template>
  <GuestLayout :canLogin="canLogin" :settings="settings">
    <Head title="Kashif Khan - Full-Stack Engineer" />

    <!-- 1. HERO SECTION -->
    <section id="about" class="min-h-[calc(100vh-80px)] flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto py-24 bg-black">
      <div class="w-full text-center space-y-8">
        <!-- Status Pill -->
        <div class="inline-flex items-center space-x-2.5 px-4 py-1.5 rounded-md bg-neutral-900 border border-neutral-800 text-neutral-300 text-sm font-sans font-medium">
          <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
          <span>{{ settings.availability_status || 'Available for Full-time Roles & Contracts' }}</span>
        </div>

        <!-- Headline -->
        <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight leading-[1.1] text-white">
          <span>{{ settings.hero_title_1 || "Hi, I'm Kashif Khan." }}</span> <br v-if="settings.hero_title_2 || !settings.hero_title_1" />
          <span class="text-neutral-300">{{ settings.hero_title_2 || "Full-Stack Web Engineer." }}</span>
        </h1>

        <!-- Subtitle -->
        <p class="text-lg sm:text-xl text-neutral-300 leading-relaxed max-w-3xl mx-auto">
          {{ settings.hero_subtitle || 'Specializing in React.js, Next.js, Vue 3, Laravel, Tailwind CSS, and modern web applications. Over 5+ years of experience building fast, reliable digital products.' }}
        </p>

        <!-- CTA Buttons -->
        <div class="pt-4 flex flex-wrap items-center justify-center gap-5">
          <a
            :href="settings.hero_cta_primary_link || '#projects'"
            class="px-8 py-4 rounded-md bg-white hover:bg-neutral-200 text-black font-bold text-base shadow-xl transition-all transform hover:scale-[1.02]"
          >
            {{ settings.hero_cta_primary_text || 'View My Projects' }}
          </a>
          <a
            :href="settings.hero_cta_secondary_link || '#contact'"
            class="px-8 py-4 rounded-md bg-neutral-900 hover:bg-neutral-800 border border-neutral-800 text-neutral-200 font-semibold text-base transition-all"
          >
            {{ settings.hero_cta_secondary_text || 'Get in Touch' }}
          </a>
        </div>
      </div>
    </section>

    <!-- 2. CLEAN MINIMALIST TECH STACK SECTION -->
    <section id="skills" class="py-16 bg-black overflow-hidden relative">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-3 mb-10">
        <h2 class="text-xs font-mono uppercase tracking-widest text-neutral-400">Technical Capability</h2>
        <h3 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">Skills &amp; Technologies</h3>
        <p class="text-neutral-300 text-sm sm:text-base max-w-xl mx-auto">Frameworks, languages, and modern tools I engineer solutions with.</p>
      </div>

      <!-- Infinite Logo Ticker Ribbon (Borderless Canvas) -->
      <div class="relative w-full overflow-hidden py-4">
        <div class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-black to-transparent z-10 pointer-events-none"></div>
        <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-black to-transparent z-10 pointer-events-none"></div>

        <div class="animate-marquee space-x-10">
          <div
            v-for="(item, idx) in marqueeItems"
            :key="idx"
            class="text-neutral-300 hover:text-white text-base sm:text-lg font-bold font-sans tracking-tight flex items-center space-x-3 shrink-0 transition-colors cursor-default"
          >
            <TechIcon :name="item.icon || 'api'" class="w-6 h-6 opacity-90" />
            <span>{{ item.name }}</span>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. PROJECTS SHOWCASE -->
    <section id="projects" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto bg-black">
      <div class="text-center space-y-4 mb-16">
        <h2 class="text-sm font-mono uppercase tracking-widest text-neutral-400">Portfolio</h2>
        <h3 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight">Featured Projects</h3>
        <p class="text-neutral-300 text-base sm:text-lg max-w-lg mx-auto">A selection of recent web applications and platforms.</p>

        <!-- Category Filters -->
        <div class="pt-6 flex flex-wrap items-center justify-center gap-3">
          <button
            v-for="cat in portfolioStore.availableCategories"
            :key="cat"
            @click="portfolioStore.setProjectCategory(cat)"
            class="px-5 py-2 rounded-md text-sm font-medium transition-all"
            :class="portfolioStore.activeProjectCategory === cat
              ? 'bg-white text-black font-bold shadow-md'
              : 'bg-neutral-900 text-neutral-300 hover:text-white hover:bg-neutral-800 border border-neutral-800'"
          >
            {{ cat }}
          </button>
        </div>
      </div>

      <!-- Project Grid (Top 3 Curated Projects) -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="project in (projects || []).slice(0, 3)"
          :key="project.id"
          class="bg-neutral-950 border border-neutral-800 rounded-md overflow-hidden hover:border-neutral-700 transition-all flex flex-col justify-between group shadow-lg"
        >
          <div>
            <!-- Image Header -->
            <Link
              :href="route('projects.show', project.slug || project.id)"
              class="relative h-56 w-full overflow-hidden bg-black cursor-pointer block"
            >
              <img
                :src="project.image_path || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80'"
                :alt="project.title"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-85 group-hover:opacity-100"
              />
              <div class="absolute top-4 left-4 flex items-center space-x-2">
                <span
                  v-if="project.is_featured"
                  class="px-2.5 py-1 rounded-md bg-white text-black text-xs font-bold uppercase"
                >
                  Featured
                </span>
                <span class="px-2.5 py-1 rounded-md bg-black/80 text-neutral-200 text-xs font-mono border border-neutral-800">
                  {{ project.category }}
                </span>
              </div>
            </Link>

            <!-- Content Body -->
            <div class="p-7 space-y-4">
              <Link :href="route('projects.show', project.slug || project.id)" class="block">
                <h4 class="text-xl sm:text-2xl font-bold text-white hover:text-neutral-300 transition-colors cursor-pointer">
                  {{ project.title }}
                </h4>
              </Link>
              <p class="text-neutral-300 text-sm sm:text-base leading-relaxed line-clamp-3">
                {{ project.summary || project.description }}
              </p>

              <!-- Tech Pills -->
              <div class="flex flex-wrap gap-2 pt-2">
                <span
                  v-for="(tech, i) in (project.tech_stack || [])"
                  :key="i"
                  class="px-2.5 py-1 rounded-md bg-neutral-900 text-neutral-200 text-xs font-mono border border-neutral-800"
                >
                  {{ tech }}
                </span>
              </div>
            </div>
          </div>

          <!-- Card Actions / Footer -->
          <div class="px-7 py-5 flex items-center justify-between border-t border-neutral-800/80 bg-neutral-950/60 mt-auto">
            <Link
              :href="route('projects.show', project.slug || project.id)"
              class="text-sm font-bold text-white hover:text-neutral-300 transition-colors flex items-center space-x-1.5 cursor-pointer"
            >
              <span>View Details</span>
              <span>→</span>
            </Link>
            <div class="flex items-center space-x-3 text-sm">
              <a
                v-if="project.github_url"
                :href="project.github_url"
                target="_blank"
                class="text-neutral-300 hover:text-white font-mono text-xs flex items-center space-x-1.5 transition-colors"
              >
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                </svg>
                <span>GitHub</span>
              </a>
              <a
                v-if="project.demo_url"
                :href="project.demo_url"
                target="_blank"
                class="px-3.5 py-2 rounded-sm bg-white text-black font-bold text-xs hover:bg-neutral-200 transition-colors flex items-center space-x-1.5"
              >
                <span>Demo</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Option C: Dedicated /projects Page CTA Link -->
      <div v-if="(projects || []).length > 3" class="mt-10 text-center">
        <Link
          :href="route('projects.index')"
          class="px-6 py-2.5 rounded-md bg-white hover:bg-neutral-200 text-black font-bold text-xs sm:text-sm shadow-lg transition-all inline-flex items-center space-x-2 cursor-pointer group hover:scale-105 transform"
        >
          <span>Explore All Projects ({{ (projects || []).length }})</span>
          <span class="group-hover:translate-x-1 transition-transform font-mono">→</span>
        </Link>
      </div>
    </section>

    <!-- 4. NOTION / LINEAR NESTED COLLAPSIBLE EXPERIENCE SECTION -->
    <section id="experience" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto bg-black border-t border-neutral-800/60">
      <!-- Section Title -->
      <div class="mb-10">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Experience</h2>
      </div>

      <!-- Main Experience Accordion List (Borderless Canvas) -->
      <div class="space-y-10 divide-y divide-neutral-900">
        <div
          v-for="(company, cIdx) in companyExperiences"
          :key="company.id"
          :class="{ 'pt-10': cIdx > 0 }"
          class="space-y-6"
        >
          <!-- Company Header -->
          <div class="flex items-center space-x-3">
            <!-- Company Logo Badge -->
            <div
              class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs shrink-0 shadow-sm"
              :class="company.logoBg"
            >
              <span>{{ company.logoText }}</span>
            </div>

            <!-- Company Name & Active Status Dot -->
            <div class="flex items-center space-x-2">
              <h3 class="text-lg sm:text-xl font-bold text-white tracking-tight">
                {{ company.company }}
              </h3>
              <span
                v-if="company.isActive"
                class="w-2.5 h-2.5 rounded-full bg-cyan-400 animate-pulse"
                title="Current Employer"
              ></span>
            </div>
          </div>

          <!-- Nested Roles Under Company -->
          <div class="space-y-6 pl-2 sm:pl-4">
            <div
              v-for="(role, rIdx) in company.roles"
              :key="role.id"
              class="space-y-3 border-l-2 border-neutral-900 pl-4 sm:pl-6 transition-colors"
              :class="{ 'border-neutral-700': role.isOpen }"
            >
              <!-- Role Header Row -->
              <div
                @click="toggleRole(cIdx, rIdx)"
                class="flex items-start justify-between cursor-pointer group py-1 select-none"
              >
                <div class="flex items-start space-x-3">
                  <!-- Code Icon Badge -->
                  <div class="w-7 h-7 rounded-md bg-neutral-900 border border-neutral-800 text-neutral-400 group-hover:text-white group-hover:border-neutral-700 text-xs font-mono flex items-center justify-center shrink-0 mt-0.5 transition-colors">
                    <span>&lt;/&gt;</span>
                  </div>

                  <div>
                    <h4 class="text-base sm:text-lg font-bold text-white group-hover:text-neutral-200 transition-colors">
                      {{ role.role }}
                    </h4>
                    <p class="text-xs font-mono text-neutral-400 mt-0.5 flex items-center space-x-2">
                      <span>{{ role.employmentType }}</span>
                      <span>&bull;</span>
                      <span>{{ role.period }}</span>
                    </p>
                  </div>
                </div>

                <!-- Chevron Collapse Button -->
                <button
                  class="p-1.5 text-neutral-400 group-hover:text-white transition-colors"
                  :aria-label="role.isOpen ? 'Collapse details' : 'Expand details'"
                >
                  <svg
                    class="w-4 h-4 transform transition-transform duration-200"
                    :class="{ 'rotate-180': role.isOpen }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                  </svg>
                </button>
              </div>

              <!-- Expanded Role Details (Bullet Points & Rich Text Description & Tech Stack Tags) -->
              <div v-if="role.isOpen" class="pt-2 pb-2 space-y-4">
                <!-- Rich Text Description (if HTML) -->
                <div 
                  v-if="role.rawDescription" 
                  v-html="role.rawDescription" 
                  class="prose-experience"
                ></div>

                <!-- Bullet Highlights List (if highlights exist) -->
                <ul 
                  v-if="role.bullets && role.bullets.length" 
                  class="space-y-2.5 text-sm text-neutral-300 font-sans leading-relaxed pl-2 sm:pl-4 pt-1"
                >
                  <li
                    v-for="(bullet, bIdx) in role.bullets"
                    :key="bIdx"
                    class="flex items-start space-x-3"
                  >
                    <span class="w-1.5 h-1.5 rounded-full bg-neutral-500 mt-2 shrink-0"></span>
                    <span v-html="bullet"></span>
                  </li>
                </ul>

                <!-- Tech Stack Pills -->
                <div v-if="role.tags && role.tags.length" class="flex flex-wrap gap-2 pt-2">
                  <span
                    v-for="(tag, tIdx) in role.tags"
                    :key="tIdx"
                    class="px-2.5 py-1 rounded-md bg-neutral-900 border border-neutral-800 text-neutral-300 text-xs font-mono hover:border-neutral-700 transition-colors"
                  >
                    {{ tag }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 5. CREATIVE 2-COLUMN EXECUTIVE CONTACT SECTION -->
    <section id="contact" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-neutral-800 bg-black">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
        
        <!-- LEFT COLUMN: Engaging Contact Pitch & Info -->
        <div class="lg:col-span-6 space-y-8">
          <div class="space-y-4">
            <h2 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight leading-tight">
              {{ settings.contact_headline_title || "Let's build something extraordinary together." }}
            </h2>
            <p class="text-neutral-400 text-base sm:text-lg leading-relaxed">
              {{ settings.contact_subtitle || "Have a project in mind, a software engineering role to discuss, or just want to talk tech? Drop a message or connect directly." }}
            </p>
          </div>

          <!-- Contact Cards -->
          <div class="space-y-3 pt-1 max-w-md">
            <!-- Email Item -->
            <a
              :href="`mailto:${settings.contact_email || 'kashifkhan.dev@gmail.com'}`"
              class="p-4 rounded-md bg-neutral-950 border border-neutral-800 hover:border-neutral-700 flex items-center space-x-4 transition-all group w-full"
            >
              <div class="w-10 h-10 rounded-md bg-neutral-900 border border-neutral-800 text-white flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
              </div>
              <div>
                <div class="text-xs font-sans font-semibold text-neutral-400 uppercase tracking-wider">Direct Email</div>
                <div class="text-sm sm:text-base font-bold text-white font-sans group-hover:text-neutral-200 transition-colors">
                  {{ settings.contact_email || 'kashifkhan.dev@gmail.com' }}
                </div>
              </div>
            </a>

            <!-- Availability & Location Item -->
            <div class="p-4 rounded-md bg-neutral-950 border border-neutral-800 flex items-center space-x-4 w-full">
              <div class="w-10 h-10 rounded-md bg-neutral-900 border border-neutral-800 text-emerald-400 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
              </div>
              <div>
                <div class="text-xs font-sans font-semibold text-neutral-400 uppercase tracking-wider">Location &amp; Work</div>
                <div class="text-sm font-bold text-white">
                  {{ settings.contact_location || 'Worldwide (Remote / On-site)' }}
                </div>
              </div>
            </div>
          </div>

          <!-- Response Guarantee Pill -->
          <div class="inline-flex items-center space-x-2 px-4 py-2 rounded-md bg-neutral-900 border border-neutral-800 text-xs font-sans font-medium text-neutral-300">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>{{ settings.contact_response_time || 'Typical Response Time: < 24 Hours' }}</span>
          </div>
        </div>

        <!-- RIGHT COLUMN: Clean Compact Message Form -->
        <div class="lg:col-span-6">
          <div class="bg-neutral-950 border border-neutral-800 p-6 sm:p-8 rounded-md space-y-6 shadow-xl w-full">
            <div>
              <h3 class="text-xl sm:text-2xl font-extrabold text-white tracking-tight">
                {{ settings.contact_form_title || 'Send a Message' }}
              </h3>
            </div>

            <form @submit.prevent="submitContactForm" class="space-y-5">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs font-sans font-medium text-neutral-300 mb-1.5 uppercase tracking-wider">Your Name</label>
                  <input
                    v-model="form.sender_name"
                    type="text"
                    required
                    placeholder="John Doe"
                    class="w-full px-4 py-2.5 rounded-md bg-black border border-neutral-800 text-white text-sm focus:outline-none focus:border-white transition-colors"
                  />
                </div>
                <div>
                  <label class="block text-xs font-sans font-medium text-neutral-300 mb-1.5 uppercase tracking-wider">Your Email</label>
                  <input
                    v-model="form.sender_email"
                    type="email"
                    required
                    placeholder="john@example.com"
                    class="w-full px-4 py-2.5 rounded-md bg-black border border-neutral-800 text-white text-sm focus:outline-none focus:border-white transition-colors"
                  />
                </div>
              </div>

              <div>
                <label class="block text-xs font-sans font-medium text-neutral-300 mb-1.5 uppercase tracking-wider">Subject</label>
                <input
                  v-model="form.subject"
                  type="text"
                  placeholder="Project Inquiry"
                  class="w-full px-4 py-2.5 rounded-md bg-black border border-neutral-800 text-white text-sm focus:outline-none focus:border-white transition-colors"
                />
              </div>

              <div>
                <label class="block text-xs font-sans font-medium text-neutral-300 mb-1.5 uppercase tracking-wider">Message</label>
                <textarea
                  v-model="form.body"
                  rows="4"
                  required
                  placeholder="Your message..."
                  class="w-full px-4 py-2.5 rounded-md bg-black border border-neutral-800 text-white text-sm focus:outline-none focus:border-white transition-colors"
                ></textarea>
              </div>

              <button
                type="submit"
                :disabled="isSubmitting || form.processing"
                class="w-full py-3.5 rounded-md bg-white hover:bg-neutral-200 text-black font-bold text-sm uppercase tracking-wider transition-all disabled:opacity-75 flex items-center justify-center space-x-2 shadow-md cursor-pointer"
              >
                <!-- Inline Spinner Icon -->
                <svg
                  v-if="isSubmitting || form.processing"
                  class="animate-spin h-4 w-4 text-black shrink-0"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                <span v-if="isSubmitting || form.processing">Transmitting Message...</span>
                <span v-else>{{ settings.contact_submit_btn_text || 'Send Message' }}</span>
              </button>
            </form>
          </div>
        </div>

      </div>
    </section>

    <!-- Modal Popup -->
    <ProjectModal
      :isOpen="portfolioStore.isProjectModalOpen"
      :project="portfolioStore.selectedProject"
      @close="portfolioStore.closeProjectModal()"
    />
  </GuestLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import ProjectModal from '@/Components/ProjectModal.vue';
import TechIcon from '@/Components/TechIcon.vue';
import { usePortfolioStore } from '@/stores/usePortfolioStore';
import { useToast } from '@/Composables/useToast';

const isSubmitting = ref(false);
const { toast } = useToast();

const props = defineProps({
  projects: Array,
  skills: Array,
  experiences: Array,
  settings: Object,
  canLogin: Boolean,
});

const portfolioStore = usePortfolioStore();

function openModal(project) {
  portfolioStore.openProjectModal(project);
}

// Master Fallback Tech Stack
const fullTechStack = [
  { name: 'React.js', icon: 'react' },
  { name: 'Next.js', icon: 'next' },
  { name: 'Vue.js 3', icon: 'vue' },
  { name: 'Laravel 11', icon: 'laravel' },
  { name: 'Tailwind CSS', icon: 'tailwind' },
  { name: 'TypeScript', icon: 'typescript' },
  { name: 'Inertia.js', icon: 'inertia' },
  { name: 'Node.js', icon: 'node' },
  { name: 'PHP 8.2+', icon: 'php' },
  { name: 'MySQL', icon: 'mysql' },
  { name: 'Docker', icon: 'docker' },
  { name: 'Git & GitHub', icon: 'git' },
  { name: 'Vite', icon: 'vite' },
  { name: 'REST & GraphQL', icon: 'api' },
];

// Active Skills from database or fallback stack
const activeSkillsList = computed(() => {
  if (props.skills && props.skills.length > 0) {
    return props.skills.map(s => ({
      id: s.id,
      name: s.name,
      icon: s.icon ? s.icon.toLowerCase() : 'api',
      category: s.category || 'General',
      proficiency: s.proficiency,
    }));
  }
  return fullTechStack;
});

const marqueeItems = computed(() => [
  ...activeSkillsList.value,
  ...activeSkillsList.value,
  ...activeSkillsList.value
]);

const groupedSkills = computed(() => {
  if (props.skills && props.skills.length > 0) {
    return props.skills.reduce((acc, skill) => {
      const cat = skill.category || 'General';
      if (!acc[cat]) acc[cat] = [];
      acc[cat].push(skill);
      return acc;
    }, {});
  }
  return {};
});

// Notion / Linear Style Nested Collapsible Experience Data
const defaultExperiences = [
  {
    id: 'apex',
    company: 'Apex Cloud Systems',
    logoText: 'AC',
    logoBg: 'bg-neutral-900 border border-neutral-800 text-white',
    isActive: true,
    roles: [
      {
        id: 'lead-dev',
        role: 'Lead Full-Stack Engineer',
        employmentType: 'Full-time',
        period: '07.2024 — Present',
        isOpen: true,
        bullets: [
          'Develop scalable SaaS applications using modern web technologies including Laravel 11, Vue 3, and Inertia.js.',
          'Build cross-platform applications, custom API integrations, and real-time dashboard notification systems.',
          'Architect and develop full-stack solutions with high-performance MySQL databases and Redis queues.',
          'Design and implement RESTful APIs with PHP 8.2+, Node.js, Express, and microservices architecture.',
          'Build responsive, performant frontend applications with Vue 3, Tailwind CSS, and Pinia state management.',
          'Integrate third-party APIs, webhooks, and real-time features using WebSockets.',
          'Collaborate with cross-functional teams in a remote environment to drive architecture and design decisions.',
          'Optimize application performance, SQL query execution plans, and ensure overall code quality.'
        ],
        tags: [
          'Laravel 11', 'Vue.js 3', 'Inertia.js', 'Tailwind CSS', 'TypeScript',
          'MySQL', 'Redis', 'RESTful APIs', 'SaaS Development', 'Remote Work', 'WebSockets', 'Problem-solving'
        ]
      }
    ]
  },
  {
    id: 'digital-hub',
    company: 'Digital Innovations Hub',
    logoText: 'DH',
    logoBg: 'bg-neutral-900 border border-neutral-800 text-blue-400',
    isActive: false,
    roles: [
      {
        id: 'pos-dev',
        role: 'Senior Frontend & Laravel Specialist',
        employmentType: 'Full-time',
        period: '01.2022 — 01.2024',
        isOpen: false,
        bullets: [
          'Developed custom web portals, customer management systems, and interactive client dashboards.',
          'Built custom payment integrations with Stripe and automated billing workflows.'
        ],
        tags: ['React.js', 'Next.js', 'Laravel Breeze', 'Tailwind CSS', 'Stripe', 'PostgreSQL']
      }
    ]
  },
  {
    id: 'education',
    company: 'University of Computer Science',
    logoText: 'BS',
    logoBg: 'bg-neutral-900 border border-neutral-800 text-emerald-400',
    isActive: false,
    roles: [
      {
        id: 'web-inst',
        role: 'B.S. in Software Engineering',
        employmentType: 'Honor Graduate',
        period: '09.2018 — 06.2022',
        isOpen: false,
        bullets: [
          'Focused on Data Structures, Object-Oriented Design, Relational Database Systems, and Distributed Computing.',
          'Completed senior capstone project on automated application security auditing and web performance optimization.'
        ],
        tags: ['Software Architecture', 'Algorithms', 'Databases', 'Git', 'System Design']
      }
    ]
  }
];

const companyExperiences = ref(defaultExperiences);

// Known technology keywords for auto-tagging
const knownTechs = [
  'Laravel', 'Vue.js', 'Vue 3', 'Tailwind CSS', 'React.js', 'React', 'Next.js', 
  'TypeScript', 'JavaScript', 'Node.js', 'PHP', 'MySQL', 'PostgreSQL', 'Redis', 
  'Docker', 'AWS S3', 'AWS', 'Stripe', 'SendGrid', 'Inertia.js', 'WebSockets', 
  'RESTful APIs', 'GraphQL', 'Git', 'Vite', 'Express', 'Microservices'
];

function extractTechTags(exp) {
  let techs = exp.technologies;
  if (typeof techs === 'string' && techs.trim()) {
    try {
      techs = JSON.parse(techs);
    } catch (e) {
      techs = techs.split(',').map(s => s.trim()).filter(Boolean);
    }
  }
  if (Array.isArray(techs) && techs.length) return techs;

  // Strict rule: If no technologies entered in Admin, show NOTHING on frontend!
  return [];
}

// Dynamically bind DB experiences if provided from Laravel
if (props.experiences && props.experiences.length) {
  const dbCompanies = props.experiences.map((exp, idx) => {
    const logoInitials = exp.company
      ? exp.company.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase()
      : 'EXP';
      
    // Handle highlights array or string
    let highlightsArr = [];
    if (Array.isArray(exp.highlights)) {
      highlightsArr = exp.highlights;
    } else if (typeof exp.highlights === 'string' && exp.highlights.trim()) {
      try {
        highlightsArr = JSON.parse(exp.highlights);
      } catch (e) {
        highlightsArr = exp.highlights.split(',').map(s => s.trim()).filter(Boolean);
      }
    }

    const hasHtml = exp.description && /<[a-z][\s\S]*>/i.test(exp.description);
    const tagsList = extractTechTags(exp);

    // Format location + work type (e.g. "Peshawar • Remote")
    let empType = exp.location || '';
    if (exp.work_type) {
      empType = empType ? `${empType} • ${exp.work_type}` : exp.work_type;
    }
    if (!empType) empType = 'Full-time';

    return {
      id: exp.id || `db-exp-${idx}`,
      company: exp.company || 'Company Name',
      logoText: logoInitials,
      logoBg: 'bg-neutral-900 border border-neutral-800 text-white',
      isActive: idx === 0,
      roles: [
        {
          id: `role-${exp.id || idx}`,
          role: exp.role || exp.title || 'Software Engineer',
          employmentType: empType,
          period: exp.period || '2024 — Present',
          isOpen: idx === 0,
          rawDescription: hasHtml ? exp.description : null,
          bullets: highlightsArr.length 
            ? highlightsArr 
            : (!hasHtml && exp.description ? exp.description.split('. ').map(b => b.trim()).filter(Boolean) : []),
          tags: tagsList
        }
      ]
    };
  });
  companyExperiences.value = dbCompanies;
}

function toggleRole(companyIdx, roleIdx) {
  companyExperiences.value[companyIdx].roles[roleIdx].isOpen = !companyExperiences.value[companyIdx].roles[roleIdx].isOpen;
}

const form = useForm({
  sender_name: '',
  sender_email: '',
  subject: '',
  body: '',
});

const showAllProjects = ref(false);

const filteredProjects = computed(() => {
  if (portfolioStore.activeProjectCategory === 'All') {
    return props.projects || [];
  }
  return (props.projects || []).filter(p => p.category === portfolioStore.activeProjectCategory);
});

const displayedProjects = computed(() => {
  if (showAllProjects.value) {
    return filteredProjects.value;
  }
  return filteredProjects.value.slice(0, 3);
});

function submitContactForm() {
  if (isSubmitting.value) return;

  isSubmitting.value = true;

  axios.post(route('contact.store'), {
    sender_name: form.sender_name,
    sender_email: form.sender_email,
    subject: form.subject,
    body: form.body,
  })
  .then(() => {
    form.reset();
    toast({
      title: 'Message Sent Successfully!',
      description: 'Thank you for reaching out. Your message has been received.',
      type: 'success',
    });
  })
  .catch((err) => {
    toast({
      title: 'Form Error',
      description: err.response?.data?.message || 'Please check your inputs and try again.',
      type: 'error',
    });
  })
  .finally(() => {
    isSubmitting.value = false;
  });
}
</script>
