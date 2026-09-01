<template>
  <div class="flex min-h-screen bg-background text-foreground">
    <!-- Collapsible Desktop Sidebar (Exact match to dashboard/resources/js/components/layout/Sidebar.vue) -->
    <aside
      :class="[
        'hidden lg:flex flex-col border-r bg-card text-card-foreground duration-300 ease-in-out h-screen sticky top-0 z-30',
        isCollapsed ? 'w-16' : 'w-64'
      ]"
    >
      <!-- Logo section -->
      <div 
        :class="[
          'h-16 flex items-center border-b shrink-0 transition-all duration-300 overflow-hidden',
          isCollapsed ? 'justify-center px-0' : 'px-4 gap-3'
        ]"
      >
        <div class="h-9 w-9 rounded-full bg-neutral-900 dark:bg-neutral-50 flex items-center justify-center shrink-0 overflow-hidden">
          <svg class="h-5 w-5 text-white dark:text-neutral-900" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <span v-if="!isCollapsed" class="font-semibold text-sm tracking-tight truncate">Kashif Khan Dev</span>
      </div>

      <!-- Navigation links -->
      <div :class="['flex-1 px-3 py-4 space-y-1', isCollapsed ? 'overflow-visible' : 'overflow-y-auto']">
        <Link
          v-for="item in navItems"
          :key="item.name"
          :href="item.route"
          :class="[
            'flex items-center rounded-md text-sm font-medium transition-all group relative',
            isCollapsed ? 'justify-center h-10 w-10 mx-auto px-0' : 'gap-3 px-3 py-2',
            item.active 
              ? 'bg-neutral-100 text-neutral-900 dark:bg-neutral-800 dark:text-neutral-50' 
              : 'text-neutral-500 hover:text-neutral-900 hover:bg-neutral-50 dark:text-neutral-400 dark:hover:text-neutral-50 dark:hover:bg-neutral-800'
          ]"
        >
          <component :is="item.icon" class="h-4 w-4 shrink-0" />
          <span v-if="!isCollapsed" class="truncate">{{ item.name }}</span>

          <!-- Tooltip for collapsed state -->
          <div 
            v-if="isCollapsed"
            class="absolute left-14 scale-0 group-hover:scale-100 transition-all rounded-md px-2 py-1 bg-white text-neutral-900 border border-neutral-200 dark:bg-neutral-900 dark:text-neutral-50 dark:border-neutral-800 text-xs font-semibold whitespace-nowrap shadow-lg z-50 pointer-events-none"
          >
            {{ item.name }}
          </div>
        </Link>
      </div>

      <!-- User Profile & Collapsible button -->
      <div class="border-t p-3 shrink-0 overflow-hidden">
        <div v-if="!isCollapsed" class="flex items-center justify-between gap-2">
          <div class="flex items-center gap-3 min-w-0">
            <div class="h-8 w-8 rounded-full bg-neutral-800 flex items-center justify-center text-white text-xs font-semibold shrink-0">
              {{ userInitials }}
            </div>
            <div class="flex-1 min-w-0">
              <h4 class="text-xs font-semibold truncate text-neutral-900 dark:text-neutral-50">{{ $page.props.auth.user.name }}</h4>
              <p class="text-[10px] text-muted-foreground truncate">{{ $page.props.auth.user.email }}</p>
            </div>
          </div>
          <button
            @click="isCollapsed = !isCollapsed"
            class="h-7 w-7 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 flex items-center justify-center text-muted-foreground hover:text-foreground shrink-0 transition-colors"
          >
            <ChevronLeft class="h-4 w-4" />
          </button>
        </div>

        <div v-else class="flex flex-col items-center gap-2">
          <div class="h-8 w-8 rounded-full bg-neutral-800 flex items-center justify-center text-white text-xs font-semibold shrink-0">
            {{ userInitials }}
          </div>
          <button
            @click="isCollapsed = !isCollapsed"
            class="h-8 w-8 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 flex items-center justify-center text-muted-foreground hover:text-foreground transition-colors"
          >
            <ChevronRight class="h-4 w-4" />
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
      <!-- Header Bar (Exact match to dashboard/resources/js/components/layout/Header.vue) -->
      <header class="h-16 border-b bg-background/95 backdrop-blur sticky top-0 z-40 flex items-center justify-between px-4 lg:px-6 shrink-0">
        <div class="flex items-center gap-3">
          <!-- Breadcrumbs -->
          <nav class="hidden md:flex items-center space-x-2 text-sm font-medium">
            <span class="text-muted-foreground">App</span>
            <ChevronRight class="h-3 w-3 text-muted-foreground" />
            <span class="text-foreground capitalize">{{ currentRouteTitle }}</span>
          </nav>
          <h1 class="md:hidden text-base font-semibold capitalize">{{ currentRouteTitle }}</h1>
        </div>

        <!-- Right-side actions -->
        <div class="flex items-center gap-2">
          <!-- Global Search Button -->
          <button
            class="relative h-9 w-9 md:w-60 md:justify-start px-3 text-muted-foreground text-sm font-normal rounded-lg border bg-background hover:bg-muted flex items-center transition-colors"
          >
            <Search class="h-4 w-4 md:mr-2 shrink-0" />
            <span class="hidden md:inline-flex">Search dashboard...</span>
            <kbd class="hidden md:inline-flex absolute right-1.5 top-1/2 -translate-y-1/2 h-5 pointer-events-none items-center justify-center gap-1 rounded border bg-muted px-1.5 font-mono text-[10px] font-medium opacity-100 select-none">
              ⌘K
            </kbd>
          </button>

          <!-- Notifications Dropdown Button -->
          <div class="relative">
            <button
              @click="showNotifications = !showNotifications"
              class="h-9 w-9 rounded-lg hover:bg-muted flex items-center justify-center relative text-muted-foreground hover:text-foreground transition-colors"
            >
              <Bell class="h-4 w-4" />
              <span class="absolute top-2.5 right-2.5 h-2 w-2 rounded-full bg-indigo-600 dark:bg-indigo-400"></span>
            </button>

            <!-- Notifications Menu -->
            <div
              v-if="showNotifications"
              class="absolute right-0 mt-2 w-80 rounded-lg border bg-popover text-popover-foreground shadow-lg p-2 z-50 space-y-1"
            >
              <div class="flex items-center justify-between px-3 py-2 border-b pb-2 mb-1">
                <span class="font-semibold text-xs text-foreground">Notifications</span>
                <span class="text-[10px] font-medium text-neutral-500 hover:text-neutral-900 dark:hover:text-white cursor-pointer">Mark all as read</span>
              </div>
              <div class="space-y-1">
                <div class="flex flex-col gap-1 p-2 rounded-md hover:bg-muted cursor-pointer transition-colors text-xs">
                  <div class="flex justify-between items-start gap-2">
                    <span class="font-medium text-foreground text-xs leading-none">New contact inquiry</span>
                    <span class="text-[9px] text-muted-foreground shrink-0">2m ago</span>
                  </div>
                  <p class="text-[11px] text-muted-foreground leading-normal">Marcus Aurelius sent a new message.</p>
                </div>
              </div>
            </div>
          </div>

          <!-- User Avatar Menu -->
          <div class="relative">
            <button
              @click="showUserMenu = !showUserMenu"
              class="h-9 w-9 rounded-full flex items-center justify-center bg-neutral-100 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-100 text-xs font-semibold border border-transparent hover:border-neutral-300 dark:hover:border-neutral-700 transition-all"
            >
              {{ userInitials }}
            </button>

            <div
              v-if="showUserMenu"
              class="absolute right-0 mt-2 w-56 rounded-lg border bg-popover text-popover-foreground shadow-lg p-2 z-50 text-xs space-y-1"
            >
              <div class="flex flex-col gap-1 px-3 py-2 border-b mb-1">
                <span class="font-semibold text-xs text-foreground">{{ $page.props.auth.user.name }}</span>
                <span class="text-[10px] text-muted-foreground">{{ $page.props.auth.user.email }}</span>
              </div>
              <Link
                :href="route('home')"
                target="_blank"
                class="block px-3 py-1.5 rounded-md hover:bg-muted text-foreground transition-colors"
              >
                Public Portfolio &rarr;
              </Link>
              <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="w-full text-left px-3 py-1.5 rounded-md text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/20 font-medium transition-colors"
              >
                Log out
              </Link>
            </div>
          </div>
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-grow p-4 lg:p-8 overflow-y-auto">
        <div class="max-w-7xl mx-auto w-full">
          <slot />
        </div>
      </main>
    </div>

    <!-- Global Toast Container -->
    <ToastNotification />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import ToastNotification from '@/Components/ToastNotification.vue';
import {
  LayoutDashboard,
  Sparkles,
  FolderGit2,
  Cpu,
  Briefcase,
  Mail,
  Sliders,
  ChevronRight,
  ChevronLeft,
  Search,
  Bell
} from 'lucide-vue-next';

const page = usePage();
const isCollapsed = ref(false);
const showNotifications = ref(false);
const showUserMenu = ref(false);

const userInitials = computed(() => {
  const name = page.props.auth.user?.name || 'KK';
  const parts = name.trim().split(/\s+/);
  if (parts.length >= 2) {
    return `${parts[0][0]}${parts[1][0]}`.toUpperCase();
  }
  return name.substring(0, 2).toUpperCase();
});

const currentRouteTitle = computed(() => {
  if (route().current('admin.dashboard')) return 'Admin Dashboard';
  if (route().current('admin.hero.*')) return 'Hero Section Editor';
  if (route().current('admin.projects.*')) return 'Projects Manager';
  if (route().current('admin.skills.*')) return 'Skills Matrix';
  if (route().current('admin.experiences.*')) return 'Experience Timeline';
  if (route().current('admin.messages.*')) return 'Inquiries Inbox';
  if (route().current('admin.settings.*')) return 'Site Settings';
  return 'Dashboard';
});

const navItems = computed(() => [
  { name: 'Dashboard', route: route('admin.dashboard'), active: route().current('admin.dashboard'), icon: LayoutDashboard },
  { name: 'Hero Section', route: route('admin.hero.index'), active: route().current('admin.hero.*'), icon: Sparkles },
  { name: 'Projects Manager', route: route('admin.projects.index'), active: route().current('admin.projects.*'), icon: FolderGit2 },
  { name: 'Skills Matrix', route: route('admin.skills.index'), active: route().current('admin.skills.*'), icon: Cpu },
  { name: 'Experience Timeline', route: route('admin.experiences.index'), active: route().current('admin.experiences.*'), icon: Briefcase },
  { name: 'Inquiries Inbox', route: route('admin.messages.index'), active: route().current('admin.messages.*'), icon: Mail },
  { name: 'Site Settings', route: route('admin.settings.index'), active: route().current('admin.settings.*'), icon: Sliders },
]);
</script>
