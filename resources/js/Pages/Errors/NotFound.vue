<template>
  <div class="min-h-screen bg-background text-foreground flex flex-col justify-between relative overflow-hidden transition-colors duration-300 select-none">
    <Head title="404 - Page Not Found" />

    <!-- Ambient Subtle Radial Glow Background -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
      <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[550px] bg-gradient-to-b from-indigo-500/10 via-purple-500/5 to-transparent dark:from-indigo-500/15 dark:via-purple-500/10 blur-3xl opacity-70"></div>
      <div class="absolute -top-32 -right-32 w-96 h-96 bg-blue-500/10 dark:bg-blue-600/15 rounded-full blur-3xl"></div>
      <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-purple-500/10 dark:bg-purple-600/15 rounded-full blur-3xl"></div>
      
      <!-- Subtle Grid Pattern -->
      <div class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:24px_24px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_30%,#000_70%,transparent_100%)]"></div>
    </div>

    <!-- Top Navigation Header -->
    <header class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
      <Link :href="route('home')" class="flex items-center gap-2.5 group cursor-pointer">
        <div class="h-8 w-8 rounded-lg bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 font-extrabold text-sm flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform">
          KK
        </div>
        <span class="font-bold text-sm tracking-tight text-foreground group-hover:text-primary transition-colors">
          Kashif Khan Dev
        </span>
      </Link>

      <div class="flex items-center gap-3">
        <!-- Theme Toggle Button -->
        <button
          @click="toggleTheme"
          class="h-9 w-9 rounded-md border border-border bg-card/60 hover:bg-accent/80 text-foreground flex items-center justify-center transition-colors backdrop-blur-sm cursor-pointer shadow-xs"
          :title="isDark ? 'Switch to light mode' : 'Switch to dark mode'"
        >
          <Sun v-if="isDark" class="h-4 w-4 text-amber-400 transition-transform rotate-0" />
          <Moon v-else class="h-4 w-4 text-neutral-600 transition-transform rotate-0" />
        </button>

        <Link
          :href="route('home')"
          class="hidden sm:inline-flex items-center gap-1.5 text-xs font-medium text-muted-foreground hover:text-foreground transition-colors px-3 py-1.5 rounded-md hover:bg-muted/60"
        >
          <span>Portfolio Home</span>
          <ArrowUpRight class="h-3.5 w-3.5" />
        </Link>
      </div>
    </header>

    <!-- Main Content Area -->
    <main class="relative z-10 flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
      <div class="max-w-2xl w-full text-center space-y-8">
        
        <!-- Status Pill Badge -->
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-mono font-medium border border-border/80 bg-muted/50 text-foreground/90 backdrop-blur-md shadow-2xs">
          <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
          </span>
          <span class="text-muted-foreground font-semibold">Error 404</span>
          <span class="text-border">|</span>
          <span>Destination Not Found</span>
        </div>

        <!-- Big 404 Graphic Heading -->
        <div class="relative">
          <h1 class="text-8xl sm:text-9xl md:text-[11rem] font-black tracking-tighter bg-clip-text text-transparent bg-gradient-to-b from-foreground via-foreground/90 to-muted-foreground/30 leading-none py-2">
            404
          </h1>
          <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-20 dark:opacity-30 blur-2xl">
            <span class="text-8xl sm:text-9xl md:text-[11rem] font-black tracking-tighter text-indigo-500">
              404
            </span>
          </div>
        </div>

        <!-- Heading & Explanation -->
        <div class="space-y-3 max-w-lg mx-auto">
          <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-foreground">
            This page has been relocated or removed
          </h2>
          <p class="text-sm sm:text-base text-muted-foreground leading-relaxed">
            The resource, route, or section you requested is no longer available. Check the URL or use one of the destinations below.
          </p>
        </div>

        <!-- Primary Actions -->
        <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
          <!-- Back button -->
          <button
            @click="goBack"
            class="h-10 px-4 rounded-md border border-border bg-card hover:bg-accent text-foreground text-xs font-semibold flex items-center gap-2 shadow-2xs hover:shadow-xs transition-all cursor-pointer"
          >
            <ArrowLeft class="h-3.5 w-3.5" />
            <span>Go Back</span>
          </button>

          <!-- Return to Dashboard if logged in / Admin -->
          <Link
            v-if="$page.props.auth?.user"
            :href="route('admin.dashboard')"
            class="h-10 px-5 rounded-md bg-primary hover:bg-primary/90 text-primary-foreground text-xs font-semibold flex items-center gap-2 shadow-sm hover:shadow transition-all cursor-pointer"
          >
            <LayoutDashboard class="h-3.5 w-3.5" />
            <span>Return to Dashboard</span>
          </Link>

          <!-- Back to Home -->
          <Link
            v-else
            :href="route('home')"
            class="h-10 px-5 rounded-md bg-primary hover:bg-primary/90 text-primary-foreground text-xs font-semibold flex items-center gap-2 shadow-sm hover:shadow transition-all cursor-pointer"
          >
            <Home class="h-3.5 w-3.5" />
            <span>Return to Home</span>
          </Link>
        </div>

        <!-- Quick Directory Navigation Cards -->
        <div class="pt-8 border-t border-border/60 grid grid-cols-1 sm:grid-cols-3 gap-3 text-left">
          
          <!-- Card 1: Dashboard or Home -->
          <Link
            :href="$page.props.auth?.user ? route('admin.dashboard') : route('home')"
            class="group p-3.5 rounded-lg border border-border/80 bg-card/60 hover:bg-accent/50 hover:border-border transition-all duration-200 cursor-pointer shadow-2xs"
          >
            <div class="flex items-center justify-between text-muted-foreground group-hover:text-foreground transition-colors mb-2">
              <div class="p-1.5 rounded-md bg-muted border border-border/60">
                <component :is="$page.props.auth?.user ? LayoutDashboard : Home" class="h-4 w-4 text-foreground" />
              </div>
              <ChevronRight class="h-3.5 w-3.5 opacity-60 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all" />
            </div>
            <div class="font-bold text-xs text-foreground group-hover:text-primary transition-colors">
              {{ $page.props.auth?.user ? 'Admin Dashboard' : 'Portfolio Home' }}
            </div>
            <p class="text-[11px] text-muted-foreground mt-0.5 line-clamp-1">
              {{ $page.props.auth?.user ? 'Metrics, CMS & content overview' : 'Landing showcase & experience' }}
            </p>
          </Link>

          <!-- Card 2: Projects Showcase -->
          <Link
            :href="route('projects.index')"
            class="group p-3.5 rounded-lg border border-border/80 bg-card/60 hover:bg-accent/50 hover:border-border transition-all duration-200 cursor-pointer shadow-2xs"
          >
            <div class="flex items-center justify-between text-muted-foreground group-hover:text-foreground transition-colors mb-2">
              <div class="p-1.5 rounded-md bg-muted border border-border/60">
                <FolderGit2 class="h-4 w-4 text-foreground" />
              </div>
              <ChevronRight class="h-3.5 w-3.5 opacity-60 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all" />
            </div>
            <div class="font-bold text-xs text-foreground group-hover:text-primary transition-colors">
              Projects Archive
            </div>
            <p class="text-[11px] text-muted-foreground mt-0.5 line-clamp-1">
              Explore full-stack apps & codebase
            </p>
          </Link>

          <!-- Card 3: Articles / Engineering CMS -->
          <Link
            :href="route('blog.index')"
            class="group p-3.5 rounded-lg border border-border/80 bg-card/60 hover:bg-accent/50 hover:border-border transition-all duration-200 cursor-pointer shadow-2xs"
          >
            <div class="flex items-center justify-between text-muted-foreground group-hover:text-foreground transition-colors mb-2">
              <div class="p-1.5 rounded-md bg-muted border border-border/60">
                <BookOpen class="h-4 w-4 text-foreground" />
              </div>
              <ChevronRight class="h-3.5 w-3.5 opacity-60 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all" />
            </div>
            <div class="font-bold text-xs text-foreground group-hover:text-primary transition-colors">
              Articles & Blog
            </div>
            <p class="text-[11px] text-muted-foreground mt-0.5 line-clamp-1">
              Engineering writeups & architecture
            </p>
          </Link>

        </div>

      </div>
    </main>

    <!-- Bottom Footer -->
    <footer class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-muted-foreground border-t border-border/40">
      <div class="flex items-center gap-2">
        <span>© {{ currentYear }} Kashif Khan.</span>
        <span>All systems operational.</span>
      </div>

      <div class="flex items-center gap-4 text-[11px] font-mono">
        <span class="inline-flex items-center gap-1.5">
          <kbd class="px-1.5 py-0.5 rounded border border-border bg-muted/80 text-[10px] text-foreground font-semibold">Alt</kbd>
          <span>+</span>
          <kbd class="px-1.5 py-0.5 rounded border border-border bg-muted/80 text-[10px] text-foreground font-semibold">←</kbd>
          <span class="text-muted-foreground ml-0.5">to step back</span>
        </span>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { onMounted, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { useTheme } from '@/Composables/useTheme';
import { 
  Sun, 
  Moon, 
  ArrowLeft, 
  ArrowUpRight, 
  Home, 
  LayoutDashboard, 
  FolderGit2, 
  BookOpen, 
  ChevronRight 
} from 'lucide-vue-next';

defineProps({
  status: {
    type: Number,
    default: 404,
  },
});

const { isDark, toggleTheme, initTheme } = useTheme();

onMounted(() => {
  initTheme();
});

const currentYear = computed(() => new Date().getFullYear());

function goBack() {
  if (window.history.length > 1) {
    window.history.back();
  } else {
    window.location.href = '/';
  }
}
</script>
