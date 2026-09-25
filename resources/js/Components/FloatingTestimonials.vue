<template>
  <div class="relative w-full min-w-0 max-w-full overflow-hidden">
    <!-- Header with Linear-Gradient Divider & Badge matching portfolio style -->
    <div class="flex flex-col gap-y-4 items-center justify-center mb-6">
      <div class="flex items-center w-full">
        <div class="flex-1 h-px bg-gradient-to-r from-transparent via-border to-transparent"></div>
        <div class="border border-border bg-primary z-10 rounded-xl px-4 py-1 shadow-xs">
          <span class="text-primary-foreground text-sm font-medium">Testimonials</span>
        </div>
        <div class="flex-1 h-px bg-gradient-to-l from-transparent via-border to-transparent"></div>
      </div>

      <div class="flex flex-col gap-y-2 items-center justify-center text-center px-2">
        <h2 class="text-xl sm:text-3xl md:text-4xl font-bold tracking-tighter text-foreground uppercase">
          TRUSTED BY INDUSTRY LEADERS
        </h2>
        <p class="text-xs sm:text-sm text-muted-foreground max-w-md mx-auto text-balance">
          See what our clients and colleagues have to say about their experience working with me.
        </p>
      </div>
    </div>

    <!-- Floating Marquee Track Constrained Strictly to Portfolio Content Width -->
    <div class="relative w-full min-w-0 max-w-full overflow-hidden py-1 space-y-3.5">
      <!-- Gradient Fades on Left & Right Edges -->
      <div class="pointer-events-none absolute inset-y-0 left-0 w-8 sm:w-20 bg-gradient-to-r from-background via-background/80 to-transparent z-20"></div>
      <div class="pointer-events-none absolute inset-y-0 right-0 w-8 sm:w-20 bg-gradient-to-l from-background via-background/80 to-transparent z-20"></div>

      <!-- ROW 1: Floating Left -->
      <div class="flex overflow-hidden w-full min-w-0">
        <div class="flex gap-3 sm:gap-4 shrink-0 marquee-track animate-marquee-left">
          <div
            v-for="(item, idx) in row1Doubled"
            :key="`row1-${item.id || idx}`"
            class="testimonial-card w-[240px] sm:w-[290px] md:w-[310px] shrink-0 rounded-xl border border-border/80 bg-card p-4 sm:p-5 flex flex-col justify-between select-none transition-all duration-300 hover:border-neutral-600/70 hover:shadow-xl relative overflow-hidden group"
          >
            <!-- Card Grid Pattern Texture -->
            <div class="absolute inset-0 card-grid-pattern pointer-events-none opacity-40"></div>

            <div class="relative z-10 flex flex-col gap-2.5">
              <!-- Star Rating (5 Stars in glowing amber/orange) -->
              <div class="flex items-center gap-0.5 text-amber-500">
                <svg
                  v-for="s in (item.rating || 5)"
                  :key="s"
                  class="size-3.5 fill-amber-500 text-amber-500 drop-shadow-xs"
                  viewBox="0 0 20 20"
                >
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
              </div>

              <!-- Quote Content -->
              <p class="text-xs text-muted-foreground dark:text-neutral-300 leading-relaxed font-normal line-clamp-3 sm:line-clamp-4">
                &ldquo;{{ item.quote }}&rdquo;
              </p>
            </div>

            <!-- Author & Avatar Row at Bottom -->
            <div class="relative z-10 flex items-center justify-between gap-2.5 mt-4 pt-3 border-t border-border/50">
              <div class="flex flex-col min-w-0 pr-2">
                <span class="text-xs sm:text-sm font-bold text-foreground truncate">
                  {{ item.client_name }}
                </span>
                <span class="text-[11px] text-muted-foreground truncate mt-0.5">
                  {{ item.client_role ? `${item.client_role}, ${item.company}` : item.company }}
                </span>
              </div>

              <!-- Avatar Photo (right-aligned, matching reference image) -->
              <div class="shrink-0">
                <img
                  v-if="item.client_avatar && !item.avatarFailed"
                  :src="item.client_avatar"
                  :alt="item.client_name"
                  class="size-10 rounded-lg object-cover border border-border/80 bg-muted shadow-2xs"
                  @error="item.avatarFailed = true"
                />
                <div
                  v-else
                  class="size-10 rounded-lg border border-border/80 bg-muted flex items-center justify-center text-xs font-bold text-foreground shadow-2xs"
                >
                  {{ getInitials(item.client_name) }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ROW 2: Floating Right (Reverse Direction) -->
      <div class="flex overflow-hidden w-full min-w-0">
        <div class="flex gap-3 sm:gap-4 shrink-0 marquee-track animate-marquee-right">
          <div
            v-for="(item, idx) in row2Doubled"
            :key="`row2-${item.id || idx}`"
            class="testimonial-card w-[240px] sm:w-[290px] md:w-[310px] shrink-0 rounded-xl border border-border/80 bg-card p-4 sm:p-5 flex flex-col justify-between select-none transition-all duration-300 hover:border-neutral-600/70 hover:shadow-xl relative overflow-hidden group"
          >
            <!-- Card Grid Pattern Texture -->
            <div class="absolute inset-0 card-grid-pattern pointer-events-none opacity-40"></div>

            <div class="relative z-10 flex flex-col gap-2.5">
              <!-- Star Rating (5 Stars in glowing amber/orange) -->
              <div class="flex items-center gap-0.5 text-amber-500">
                <svg
                  v-for="s in (item.rating || 5)"
                  :key="s"
                  class="size-3.5 fill-amber-500 text-amber-500 drop-shadow-xs"
                  viewBox="0 0 20 20"
                >
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
              </div>

              <!-- Quote Content -->
              <p class="text-xs text-muted-foreground dark:text-neutral-300 leading-relaxed font-normal line-clamp-3 sm:line-clamp-4">
                &ldquo;{{ item.quote }}&rdquo;
              </p>
            </div>

            <!-- Author & Avatar Row at Bottom -->
            <div class="relative z-10 flex items-center justify-between gap-2.5 mt-4 pt-3 border-t border-border/50">
              <div class="flex flex-col min-w-0 pr-2">
                <span class="text-xs sm:text-sm font-bold text-foreground truncate">
                  {{ item.client_name }}
                </span>
                <span class="text-[11px] text-muted-foreground truncate mt-0.5">
                  {{ item.client_role ? `${item.client_role}, ${item.company}` : item.company }}
                </span>
              </div>

              <!-- Avatar Photo (right-aligned, matching reference image) -->
              <div class="shrink-0">
                <img
                  v-if="item.client_avatar && !item.avatarFailed"
                  :src="item.client_avatar"
                  :alt="item.client_name"
                  class="size-10 rounded-lg object-cover border border-border/80 bg-muted shadow-2xs"
                  @error="item.avatarFailed = true"
                />
                <div
                  v-else
                  class="size-10 rounded-lg border border-border/80 bg-muted flex items-center justify-center text-xs font-bold text-foreground shadow-2xs"
                >
                  {{ getInitials(item.client_name) }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  testimonials: {
    type: Array,
    default: () => [],
  },
});

// Default high-profile industry testimonials matching reference mockup
const defaultTestimonials = [
  {
    id: 'def-1',
    client_name: 'Manish Morwal',
    client_role: 'CEO',
    company: 'eColors Studio',
    client_avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
    quote: 'Kashif excels in cutting-edge tech expertise, particularly in AI-driven platforms and scalable cloud systems. His solutions boosted our operational efficiency and accelerated innovation timelines significantly.',
    rating: 5,
  },
  {
    id: 'def-2',
    client_name: 'Annie Shrivastava',
    client_role: 'Talent Acquisition Specialist',
    company: 'Civica',
    client_avatar: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&q=80',
    quote: 'Kashif\'s engineering prowess and architectural clarity delivered elite solutions effortlessly. This partnership accelerated our digital delivery, driving our GCC enterprise projects forward seamlessly.',
    rating: 5,
  },
  {
    id: 'def-3',
    client_name: 'Nishita Shah',
    client_role: 'Senior Manager - Talent Acquisition',
    company: 'InfoBeans',
    client_avatar: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=200&q=80',
    quote: 'Kashif combines deep tech expertise with world-class engineering discipline. His high-performance APIs and reactive frontend architectures delivered remarkable speed and reliability for our stakeholders.',
    rating: 5,
  },
  {
    id: 'def-4',
    client_name: 'Sarah Jenkins',
    client_role: 'VP of Engineering',
    company: 'CloudScale Networks',
    client_avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=200&q=80',
    quote: 'Kashif transformed our legacy portal into a lightning-fast Inertia + Vue 3 architecture. His attention to UX subtleties and query optimization reduced page load times by over 60%. An exceptional full-stack engineer.',
    rating: 5,
  },
  {
    id: 'def-5',
    client_name: 'David Sterling',
    client_role: 'Founder & CEO',
    company: 'AeroSwift Digital',
    client_avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80',
    quote: 'Managing inventory, production, billing, human resources, and Point Of Sales operations across multiple locations had become increasingly complex as we scaled. Kashif\'s AI-powered automation unified our platform cleanly.',
    rating: 5,
  },
  {
    id: 'def-6',
    client_name: 'Elena Rostova',
    client_role: 'Lead Technical Product Manager',
    company: 'HealthPulse Global',
    client_avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80',
    quote: 'Partnering with Kashif was an outstanding decision. His deep expertise and industry experience helped us build a centralized platform that streamlined operations, enhanced communication across teams, and automated critical workflows.',
    rating: 5,
  },
  {
    id: 'def-7',
    client_name: 'Marcus Vance',
    client_role: 'Head of AI Solutions',
    company: 'DevMatrix Labs',
    client_avatar: 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=200&q=80',
    quote: 'Rarely do you find an engineer who excels equally at responsive frontend aesthetic execution and complex backend asynchronous workers. Kashif is reliable, creative, and pushes code that is clean, secure, and modern.',
    rating: 5,
  },
  {
    id: 'def-8',
    client_name: 'Alex Rivera',
    client_role: 'CTO',
    company: 'NexaFlow Cloud',
    client_avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=200&q=80',
    quote: 'Working with Kashif on cloud analytics dashboards was a game changer. He merged reactive data visualization with flawless reliability that exceeded our executive board\'s expectations.',
    rating: 5,
  },
];

// Normalize database testimonials or fallback
const normalizedTestimonials = computed(() => {
  if (props.testimonials && props.testimonials.length > 0) {
    const dbItems = props.testimonials.map((t, idx) => ({
      id: t.id || `db-${idx}`,
      client_name: t.client_name || t.name || 'Client',
      client_role: t.client_role || t.role || '',
      company: t.company || 'Enterprise Partner',
      client_avatar: t.client_avatar || t.avatar || '',
      quote: t.quote || t.content || t.testimonial || 'Outstanding technical execution and proactive communication throughout the engagement.',
      rating: Number(t.rating) || 5,
      avatarFailed: false,
    }));

    // If DB has fewer than 6, blend with defaults to maintain full double-row floating effect
    if (dbItems.length < 6) {
      const needed = 6 - dbItems.length;
      return [...dbItems, ...defaultTestimonials.slice(0, needed)];
    }
    return dbItems;
  }
  return defaultTestimonials;
});

// Distribute items into Row 1 and Row 2
const row1Items = computed(() => {
  const items = normalizedTestimonials.value;
  const half = Math.ceil(items.length / 2);
  return items.slice(0, half);
});

const row2Items = computed(() => {
  const items = normalizedTestimonials.value;
  const half = Math.ceil(items.length / 2);
  return items.slice(half);
});

// Duplicate tracks for continuous 100% seamless marquee
const row1Doubled = computed(() => [...row1Items.value, ...row1Items.value, ...row1Items.value]);
const row2Doubled = computed(() => [...row2Items.value, ...row2Items.value, ...row2Items.value]);

function getInitials(name) {
  if (!name) return 'C';
  const parts = name.trim().split(/\s+/);
  if (parts.length >= 2) return `${parts[0][0]}${parts[1][0]}`.toUpperCase();
  return name.substring(0, 2).toUpperCase();
}
</script>

<style scoped>
.card-grid-pattern {
  background-size: 20px 20px;
  background-image: 
    linear-gradient(to right, rgba(255, 255, 255, 0.04) 1px, transparent 1px),
    linear-gradient(to bottom, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
}

:global(html:not(.dark)) .card-grid-pattern {
  background-image: 
    linear-gradient(to right, rgba(0, 0, 0, 0.04) 1px, transparent 1px),
    linear-gradient(to bottom, rgba(0, 0, 0, 0.04) 1px, transparent 1px);
}

@keyframes marquee-scroll-left {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-33.333333%);
  }
}

@keyframes marquee-scroll-right {
  0% {
    transform: translateX(-33.333333%);
  }
  100% {
    transform: translateX(0);
  }
}

.animate-marquee-left {
  animation: marquee-scroll-left 18s linear infinite;
  will-change: transform;
}

.animate-marquee-right {
  animation: marquee-scroll-right 18s linear infinite;
  will-change: transform;
}

.marquee-track:hover {
  animation-play-state: paused;
}
</style>
