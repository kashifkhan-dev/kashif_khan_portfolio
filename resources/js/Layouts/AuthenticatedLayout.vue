<template>
  <div class="flex min-h-screen bg-[#030712] text-slate-100 font-sans selection:bg-blue-600 selection:text-white">
    <!-- Collapsible Desktop Sidebar (Shadcn Dashboard style) -->
    <aside
      :class="[
        'hidden lg:flex flex-col border-r border-slate-800 bg-[#0B0F17] text-slate-200 duration-300 ease-in-out h-screen sticky top-0 z-30',
        isCollapsed ? 'w-16' : 'w-64'
      ]"
    >
      <!-- Logo section -->
      <div
        :class="[
          'h-16 flex items-center border-b border-slate-800 shrink-0 transition-all duration-300 overflow-hidden',
          isCollapsed ? 'justify-center px-0' : 'px-4 gap-3'
        ]"
      >
        <Link href="/" class="h-9 w-9 rounded-xl bg-blue-600 flex items-center justify-center shrink-0 shadow-lg text-white font-bold text-sm">
          KK
        </Link>
        <span v-if="!isCollapsed" class="font-bold text-sm text-white tracking-tight truncate">
          Portfolio Admin CMS
        </span>
      </div>

      <!-- Navigation Links -->
      <div :class="['flex-1 px-3 py-4 space-y-1.5', isCollapsed ? 'overflow-visible' : 'overflow-y-auto']">
        <Link
          v-for="item in navItems"
          :key="item.name"
          :href="item.route"
          :class="[
            'flex items-center rounded-xl text-xs font-semibold transition-all group relative',
            isCollapsed ? 'justify-center h-10 w-10 mx-auto px-0' : 'gap-3 px-3 py-2.5',
            item.active
              ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20'
              : 'text-slate-400 hover:text-white hover:bg-slate-900/80'
          ]"
        >
          <component :is="item.icon" class="h-4 w-4 shrink-0" />
          <span v-if="!isCollapsed" class="truncate">{{ item.name }}</span>

          <!-- Tooltip for collapsed state -->
          <div
            v-if="isCollapsed"
            class="absolute left-14 scale-0 group-hover:scale-100 transition-all rounded-md px-2.5 py-1 bg-slate-900 text-white border border-slate-800 text-xs font-semibold whitespace-nowrap shadow-xl z-50 pointer-events-none"
          >
            {{ item.name }}
          </div>
        </Link>
      </div>

      <!-- Bottom Profile & Collapse Toggle -->
      <div class="border-t border-slate-800 p-3 shrink-0">
        <div v-if="!isCollapsed" class="flex items-center justify-between gap-2">
          <div class="flex items-center gap-3 min-w-0">
            <div class="w-8 h-8 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-xs font-bold text-white shrink-0">
              {{ $page.props.auth.user.name.charAt(0) }}
            </div>
            <div class="flex-1 min-w-0">
              <h4 class="text-xs font-bold truncate text-white">{{ $page.props.auth.user.name }}</h4>
              <p class="text-[10px] text-slate-400 truncate">{{ $page.props.auth.user.email }}</p>
            </div>
          </div>
          <button
            @click="isCollapsed = !isCollapsed"
            class="h-7 w-7 rounded-lg glass-card flex items-center justify-center text-slate-400 hover:text-white hover:border-slate-700 shrink-0"
          >
            &larr;
          </button>
        </div>

        <div v-else class="flex flex-col items-center gap-2">
          <div class="w-8 h-8 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-xs font-bold text-white shrink-0">
            {{ $page.props.auth.user.name.charAt(0) }}
          </div>
          <button
            @click="isCollapsed = !isCollapsed"
            class="h-8 w-8 rounded-lg glass-card flex items-center justify-center text-slate-400 hover:text-white hover:border-slate-700"
          >
            &rarr;
          </button>
        </div>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
      <!-- Header Bar -->
      <header class="h-16 border-b border-slate-800 bg-[#0B0F17]/80 backdrop-blur-md sticky top-0 z-20 px-4 lg:px-8 flex items-center justify-between">
        <div class="flex items-center space-x-4">
          <h2 class="text-sm font-bold text-white">
            <slot name="header">Admin CMS</slot>
          </h2>
        </div>

        <div class="flex items-center space-x-4">
          <!-- View Live Portfolio Button -->
          <Link
            href="/"
            target="_blank"
            class="px-3 py-1.5 rounded-lg glass-card text-xs font-semibold text-slate-300 hover:text-white flex items-center space-x-1"
          >
            <span>Live Portfolio</span>
            <span>&rarr;</span>
          </Link>

          <!-- User Menu Dropdown -->
          <div class="relative flex items-center space-x-3 pl-3 border-l border-slate-800">
            <span class="text-xs text-slate-300 font-medium hidden sm:inline">{{ $page.props.auth.user.name }}</span>
            <Link
              :href="route('logout')"
              method="post"
              as="button"
              class="text-xs text-rose-400 hover:text-rose-300 font-semibold"
            >
              Log Out
            </Link>
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

    <!-- Global Toast Notifications -->
    <ToastNotification />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import ToastNotification from '@/Components/ToastNotification.vue';
import {
  LayoutDashboard,
  FolderGit2,
  Cpu,
  Briefcase,
  Mail,
  Sliders,
  ExternalLink
} from 'lucide-vue-next';

const isCollapsed = ref(false);

const navItems = computed(() => [
  { name: 'Dashboard', route: route('admin.dashboard'), active: route().current('admin.dashboard'), icon: LayoutDashboard },
  { name: 'Projects Manager', route: route('admin.projects.index'), active: route().current('admin.projects.*'), icon: FolderGit2 },
  { name: 'Skills Matrix', route: route('admin.skills.index'), active: route().current('admin.skills.*'), icon: Cpu },
  { name: 'Experience Timeline', route: route('admin.experiences.index'), active: route().current('admin.experiences.*'), icon: Briefcase },
  { name: 'Inquiries Inbox', route: route('admin.messages.index'), active: route().current('admin.messages.*'), icon: Mail },
  { name: 'Site Settings', route: route('admin.settings.index'), active: route().current('admin.settings.*'), icon: Sliders },
  { name: 'Public Portfolio', route: route('home'), active: false, icon: ExternalLink },
]);
</script>
