<template>
  <GuestLayout :canLogin="canLogin" :settings="settings">
    <Head title="Kashif Khan - Portfolio & Full-Stack Showcase" />

    <!-- 1. HERO SECTION -->
    <section id="about" class="relative pt-16 pb-24 lg:pt-24 lg:pb-32 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-7 space-y-6 text-left">
          <!-- Availability Badge -->
          <div class="inline-flex items-center space-x-2.5 px-4 py-1.5 rounded-full glass-card border-emerald-500/30 text-emerald-400 text-xs font-semibold shadow-inner">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
            <span>{{ settings.availability_status || 'Available for Freelance & Full-time Roles' }}</span>
          </div>

          <!-- Headline -->
          <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.15]">
            Architecting <span class="gradient-text">Modern Web Apps</span> & Scalable Systems.
          </h1>

          <!-- Subtitle / Bio -->
          <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl font-normal">
            {{ settings.hero_subtitle || 'Building enterprise SaaS platforms, responsive web applications, and interactive dashboards with Laravel, Vue 3, Inertia.js, and Tailwind CSS.' }}
          </p>

          <!-- CTAs -->
          <div class="pt-4 flex flex-wrap items-center gap-4">
            <a
              href="#projects"
              class="px-6 py-3.5 rounded-xl bg-white hover:bg-slate-200 text-slate-950 font-bold text-sm shadow-xl shadow-white/10 transition-all transform hover:-translate-y-0.5 flex items-center space-x-2"
            >
              <span>Explore Selected Work</span>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
            <a
              href="#contact"
              class="px-6 py-3.5 rounded-xl glass-panel text-slate-200 hover:text-white font-semibold text-sm hover:border-slate-700 transition-all shadow-md"
            >
              Get In Touch
            </a>
          </div>

          <!-- Social Handles -->
          <div class="pt-6 flex items-center space-x-5 text-slate-400">
            <span class="text-xs uppercase tracking-wider font-semibold text-slate-500">Connect:</span>
            <a :href="settings.github_url || '#'" target="_blank" class="hover:text-blue-400 transition-colors">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>
            </a>
            <a :href="settings.linkedin_url || '#'" target="_blank" class="hover:text-blue-400 transition-colors">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>
            </a>
            <a :href="settings.twitter_url || '#'" target="_blank" class="hover:text-blue-400 transition-colors">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
          </div>
        </div>

        <!-- Metrics Side Card -->
        <div class="lg:col-span-5 relative">
          <div class="glass-panel p-8 rounded-3xl relative z-10 shadow-2xl border border-slate-800 space-y-6 animate-float">
            <div class="flex items-center space-x-4 pb-4 border-b border-slate-800">
              <div class="w-14 h-14 rounded-2xl bg-slate-900 border border-slate-700 p-0.5 shadow-lg">
                <div class="w-full h-full bg-slate-950 rounded-[14px] flex items-center justify-center font-bold text-xl text-white">
                  KK
                </div>
              </div>
              <div>
                <h3 class="font-bold text-white text-lg">Kashif Khan</h3>
                <p class="text-xs text-blue-400 font-medium">Senior Software Engineer</p>
              </div>
            </div>

            <!-- Stats grid -->
            <div class="grid grid-cols-3 gap-4 text-center">
              <div class="p-3 rounded-2xl bg-slate-900/60 border border-slate-800">
                <span class="block text-2xl font-black text-white">{{ settings.years_experience || '5+' }}</span>
                <span class="text-[11px] text-slate-400 font-medium">Years Exp.</span>
              </div>
              <div class="p-3 rounded-2xl bg-slate-900/60 border border-slate-800">
                <span class="block text-2xl font-black text-blue-400">{{ settings.completed_projects || '24+' }}</span>
                <span class="text-[11px] text-slate-400 font-medium">Projects</span>
              </div>
              <div class="p-3 rounded-2xl bg-slate-900/60 border border-slate-800">
                <span class="block text-2xl font-black text-emerald-400">{{ settings.satisfied_clients || '18+' }}</span>
                <span class="text-[11px] text-slate-400 font-medium">Clients</span>
              </div>
            </div>

            <!-- Code snippet feature card -->
            <div class="p-4 rounded-2xl bg-slate-900/80 border border-slate-800/80 font-mono text-xs text-slate-300 space-y-1.5">
              <div class="flex items-center space-x-2 pb-2 border-b border-slate-800 text-[11px] text-slate-400">
                <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                <span class="ml-2 font-sans font-medium text-slate-400">portfolio_stack.config.ts</span>
              </div>
              <p class="text-blue-400"><span class="text-cyan-400">const</span> stack = {</p>
              <p class="pl-4">backend: <span class="text-emerald-400">'Laravel 11'</span>,</p>
              <p class="pl-4">frontend: <span class="text-emerald-400">'Vue 3 + Inertia'</span>,</p>
              <p class="pl-4">styling: <span class="text-emerald-400">'Tailwind + Shadcn'</span>,</p>
              <p class="pl-4">database: <span class="text-emerald-400">'MySQL'</span>,</p>
              <p>};</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 2. PROJECTS SECTION -->
    <section id="projects" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-slate-800/60">
      <div class="text-center space-y-4 mb-12">
        <h2 class="text-xs uppercase tracking-widest font-bold text-blue-400">Portfolio Showcase</h2>
        <h3 class="text-3xl sm:text-4xl font-extrabold text-white">Featured Projects & Applications</h3>
        <p class="text-slate-400 text-sm max-w-2xl mx-auto">Explore recent applications, cloud dashboards, and interactive digital products built with Laravel, Vue 3, and modern frontend tools.</p>

        <!-- Category Filters -->
        <div class="pt-6 flex flex-wrap items-center justify-center gap-2">
          <button
            v-for="cat in portfolioStore.availableCategories"
            :key="cat"
            @click="portfolioStore.setProjectCategory(cat)"
            class="px-4 py-2 rounded-xl text-xs font-semibold transition-all duration-200"
            :class="portfolioStore.activeProjectCategory === cat
              ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30'
              : 'glass-card text-slate-400 hover:text-white hover:border-slate-700'"
          >
            {{ cat }}
          </button>
        </div>
      </div>

      <!-- Projects Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="project in filteredProjects"
          :key="project.id"
          class="glass-card rounded-2xl overflow-hidden group flex flex-col transition-all duration-300 hover:-translate-y-1.5"
        >
          <!-- Thumbnail Image -->
          <Link :href="route('projects.show', project.slug || project.id)" class="relative h-48 overflow-hidden bg-slate-900 block">
            <img
              :src="project.image_path || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80'"
              :alt="project.title"
              class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent opacity-80"></div>
            <span
              v-if="project.is_featured"
              class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-blue-600/90 text-white text-[10px] font-bold tracking-wider uppercase shadow-md backdrop-blur-md"
            >
              Featured
            </span>
            <span class="absolute bottom-3 left-3 px-2.5 py-1 rounded-lg bg-slate-900/80 text-blue-300 text-xs font-medium backdrop-blur-md border border-slate-700/50">
              {{ project.category }}
            </span>
          </Link>

          <!-- Content Body -->
          <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
            <div>
              <Link :href="route('projects.show', project.slug || project.id)">
                <h4 class="text-xl font-bold text-white group-hover:text-blue-400 transition-colors line-clamp-1">
                  {{ project.title }}
                </h4>
              </Link>
              <p class="text-slate-300 text-xs mt-2 line-clamp-2 leading-relaxed">
                {{ project.summary || project.description }}
              </p>
            </div>

            <!-- Tech Stack Badges -->
            <div class="flex flex-wrap gap-1.5 pt-2">
              <span
                v-for="(tech, i) in (project.tech_stack || [])"
                :key="i"
                class="px-2 py-0.5 rounded-md bg-slate-900 text-slate-300 text-[11px] border border-slate-800"
              >
                {{ tech }}
              </span>
            </div>

            <!-- Actions Buttons -->
            <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between">
              <Link
                :href="route('projects.show', project.slug || project.id)"
                class="text-xs font-semibold text-blue-400 hover:text-blue-300 flex items-center space-x-1"
              >
                <span>View Details</span>
                <span>&rarr;</span>
              </Link>
              <div class="flex items-center space-x-3">
                <a
                  v-if="project.github_url"
                  :href="project.github_url"
                  target="_blank"
                  class="text-slate-400 hover:text-white text-xs font-medium"
                >
                  GitHub
                </a>
                <a
                  v-if="project.demo_url"
                  :href="project.demo_url"
                  target="_blank"
                  class="px-3 py-1.5 rounded-lg bg-blue-600/20 text-blue-300 hover:bg-blue-600 hover:text-white text-xs font-semibold transition-colors"
                >
                  Live Demo
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. SKILLS MATRIX SECTION -->
    <section id="skills" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-slate-800/80">
      <div class="text-center space-y-4 mb-16">
        <h2 class="text-xs uppercase tracking-widest font-bold text-blue-400">Technical Expertise</h2>
        <h3 class="text-3xl sm:text-4xl font-extrabold text-white">Core Skills & Proficiency</h3>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
          v-for="cat in skillCategories"
          :key="cat"
          class="glass-panel p-6 rounded-2xl space-y-6"
        >
          <div class="flex items-center justify-between border-b border-slate-800 pb-3">
            <h4 class="font-bold text-white text-base">{{ cat }}</h4>
            <span class="text-xs text-blue-400 font-medium">{{ getSkillsForCategory(cat).length }} Skills</span>
          </div>

          <div class="space-y-4">
            <div v-for="skill in getSkillsForCategory(cat)" :key="skill.id" class="space-y-1.5">
              <div class="flex justify-between text-xs">
                <span class="font-medium text-slate-200">{{ skill.name }}</span>
                <span class="text-slate-400 font-mono">{{ skill.proficiency }}%</span>
              </div>
              <div class="w-full h-2 rounded-full bg-slate-900 overflow-hidden">
                <div
                  class="h-full bg-gradient-to-r from-blue-500 to-emerald-400 rounded-full transition-all duration-1000"
                  :style="{ width: skill.proficiency + '%' }"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. EXPERIENCE & EDUCATION TIMELINE SECTION -->
    <section id="experience" class="py-24 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto border-t border-slate-800/80">
      <div class="text-center space-y-4 mb-16">
        <h2 class="text-xs uppercase tracking-widest font-bold text-blue-400">Career Journey</h2>
        <h3 class="text-3xl sm:text-4xl font-extrabold text-white">Experience & Education</h3>
      </div>

      <div class="relative border-l-2 border-slate-800 ml-4 md:ml-32 space-y-12">
        <div v-for="exp in experiences" :key="exp.id" class="relative pl-8 md:pl-10 group">
          <!-- Timeline point dot -->
          <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full bg-slate-950 border-2 border-blue-500 group-hover:bg-blue-500 transition-colors"></div>

          <!-- Date badge -->
          <span class="md:absolute md:-left-32 md:top-1 text-xs font-semibold text-blue-400 bg-blue-950/40 px-3 py-1 rounded-full border border-blue-800/40 inline-block mb-2 md:mb-0">
            {{ exp.period }}
          </span>

          <!-- Card Box -->
          <div class="glass-card p-6 rounded-2xl space-y-3">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
              <h4 class="text-lg font-bold text-white">{{ exp.role }}</h4>
              <span class="text-xs text-slate-400 font-medium">{{ exp.company }} &bull; {{ exp.location }}</span>
            </div>
            <p class="text-xs text-slate-300 leading-relaxed">{{ exp.description }}</p>

            <ul v-if="exp.highlights && exp.highlights.length" class="space-y-1 pt-2">
              <li v-for="(item, idx) in exp.highlights" :key="idx" class="text-xs text-slate-400 flex items-start space-x-2">
                <span class="text-blue-400 font-bold">&check;</span>
                <span>{{ item }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- 5. CONTACT & INQUIRIES SECTION -->
    <section id="contact" class="py-24 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto border-t border-slate-800/80">
      <div class="glass-panel p-8 sm:p-12 rounded-3xl space-y-8 relative overflow-hidden">
        <div class="text-center space-y-3">
          <h2 class="text-xs uppercase tracking-widest font-bold text-blue-400">Get In Touch</h2>
          <h3 class="text-3xl font-extrabold text-white">Let's Work Together</h3>
          <p class="text-xs sm:text-sm text-slate-400 max-w-md mx-auto">Have a project in mind or looking for a full-stack engineer? Send me a message and I'll get back to you promptly.</p>
        </div>

        <form @submit.prevent="submitContactForm" class="space-y-6">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-2">Your Name</label>
              <input
                v-model="form.sender_name"
                type="text"
                required
                placeholder="John Doe"
                class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white text-sm focus:outline-none focus:border-blue-500 transition-colors"
              />
              <span v-if="form.errors.sender_name" class="text-xs text-rose-400 mt-1 block">{{ form.errors.sender_name }}</span>
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-300 mb-2">Email Address</label>
              <input
                v-model="form.sender_email"
                type="email"
                required
                placeholder="john@example.com"
                class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white text-sm focus:outline-none focus:border-blue-500 transition-colors"
              />
              <span v-if="form.errors.sender_email" class="text-xs text-rose-400 mt-1 block">{{ form.errors.sender_email }}</span>
            </div>
          </div>

          <div>
            <label class="block text-xs font-semibold text-slate-300 mb-2">Subject</label>
            <input
              v-model="form.subject"
              type="text"
              placeholder="Project Inquiry / Job Opportunity"
              class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white text-sm focus:outline-none focus:border-blue-500 transition-colors"
            />
          </div>

          <div>
            <label class="block text-xs font-semibold text-slate-300 mb-2">Message</label>
            <textarea
              v-model="form.body"
              rows="5"
              required
              placeholder="Tell me about your project, timeline, or requirements..."
              class="w-full px-4 py-3 rounded-xl bg-slate-900/90 border border-slate-800 text-white text-sm focus:outline-none focus:border-blue-500 transition-colors"
            ></textarea>
            <span v-if="form.errors.body" class="text-xs text-rose-400 mt-1 block">{{ form.errors.body }}</span>
          </div>

          <button
            type="submit"
            :disabled="form.processing"
            class="w-full py-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm shadow-xl shadow-blue-600/20 transition-all disabled:opacity-50"
          >
            <span v-if="form.processing">Sending Message...</span>
            <span v-else>Send Inquiry Message</span>
          </button>
        </form>
      </div>
    </section>
  </GuestLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { usePortfolioStore } from '@/stores/usePortfolioStore';
import { useNotificationStore } from '@/stores/useNotificationStore';

const props = defineProps({
  projects: Array,
  skills: Array,
  experiences: Array,
  settings: Object,
  canLogin: Boolean,
});

const portfolioStore = usePortfolioStore();
const notificationStore = useNotificationStore();

const form = useForm({
  sender_name: '',
  sender_email: '',
  subject: '',
  body: '',
});

// Category filtering for Projects
const filteredProjects = computed(() => {
  if (portfolioStore.activeProjectCategory === 'All') {
    return props.projects;
  }
  return props.projects.filter(p => p.category === portfolioStore.activeProjectCategory);
});

// Skill categories
const skillCategories = ['Frontend', 'Backend', 'Database/DevOps', 'Tools'];

function getSkillsForCategory(cat) {
  return (props.skills || []).filter(s => s.category === cat);
}

// Contact form submission
function submitContactForm() {
  form.post(route('contact.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
      notificationStore.addToast({
        title: 'Message Sent!',
        message: 'Thank you for reaching out. Your message has been stored in my inbox.',
        type: 'success',
      });
    },
    onError: () => {
      notificationStore.addToast({
        title: 'Form Error',
        message: 'Please check your form inputs and try again.',
        type: 'error',
      });
    },
  });
}
</script>
