<template>
  <AuthenticatedLayout>
    <template #header>Dashboard Overview</template>
    <Head title="Admin Dashboard - Kashif Khan Portfolio" />

    <div class="space-y-8">
      <!-- Top Overview Stat Cards Grid (Shadcn UI style) -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="p-6 rounded-2xl bg-[#0B0F17] border border-slate-800 space-y-2">
          <div class="flex items-center justify-between text-slate-400">
            <span class="text-xs font-semibold uppercase tracking-wider">Total Projects</span>
            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
          </div>
          <div class="flex items-baseline justify-between">
            <span class="text-3xl font-extrabold text-white">{{ stats.total_projects }}</span>
            <Link :href="route('admin.projects.index')" class="text-xs font-semibold text-blue-400 hover:underline">Manage &rarr;</Link>
          </div>
        </div>

        <div class="p-6 rounded-2xl bg-[#0B0F17] border border-slate-800 space-y-2">
          <div class="flex items-center justify-between text-slate-400">
            <span class="text-xs font-semibold uppercase tracking-wider">Skills Listed</span>
            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
          </div>
          <div class="flex items-baseline justify-between">
            <span class="text-3xl font-extrabold text-white">{{ stats.total_skills }}</span>
            <Link :href="route('admin.skills.index')" class="text-xs font-semibold text-emerald-400 hover:underline">Manage &rarr;</Link>
          </div>
        </div>

        <div class="p-6 rounded-2xl bg-[#0B0F17] border border-slate-800 space-y-2">
          <div class="flex items-center justify-between text-slate-400">
            <span class="text-xs font-semibold uppercase tracking-wider">Timeline Entries</span>
            <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <div class="flex items-baseline justify-between">
            <span class="text-3xl font-extrabold text-white">{{ stats.total_experiences }}</span>
            <Link :href="route('admin.experiences.index')" class="text-xs font-semibold text-cyan-400 hover:underline">Manage &rarr;</Link>
          </div>
        </div>

        <div class="p-6 rounded-2xl bg-[#0B0F17] border border-slate-800 space-y-2">
          <div class="flex items-center justify-between text-slate-400">
            <span class="text-xs font-semibold uppercase tracking-wider">Unread Inquiries</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
              {{ stats.unread_messages }} New
            </span>
          </div>
          <div class="flex items-baseline justify-between">
            <span class="text-3xl font-extrabold text-white">{{ stats.total_messages }}</span>
            <Link :href="route('admin.messages.index')" class="text-xs font-semibold text-amber-400 hover:underline">Inbox &rarr;</Link>
          </div>
        </div>
      </div>

      <!-- Quick Action Controls & Shortcuts -->
      <div class="p-6 rounded-2xl bg-[#0B0F17] border border-slate-800 flex flex-wrap items-center justify-between gap-4">
        <div>
          <h3 class="text-base font-bold text-white">CMS Quick Actions</h3>
          <p class="text-xs text-slate-400">Directly add content or customize live landing page settings.</p>
        </div>
        <div class="flex items-center gap-3">
          <Link :href="route('admin.projects.index')" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow-md">
            + New Project
          </Link>
          <Link :href="route('admin.settings.index')" class="px-4 py-2.5 rounded-xl glass-card text-slate-200 hover:text-white text-xs font-semibold">
            Customize Site Profile
          </Link>
        </div>
      </div>

      <!-- Recent Content Tables Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Inquiries Panel -->
        <div class="p-6 rounded-2xl bg-[#0B0F17] border border-slate-800 space-y-4">
          <div class="flex items-center justify-between border-b border-slate-800 pb-3">
            <h3 class="font-bold text-white text-sm">Recent Contact Messages</h3>
            <Link :href="route('admin.messages.index')" class="text-xs text-blue-400 font-semibold hover:underline">View All</Link>
          </div>

          <div v-if="!recent_messages.length" class="text-center py-8 text-xs text-slate-500">
            No contact messages received yet.
          </div>

          <div v-else class="space-y-3">
            <div v-for="msg in recent_messages" :key="msg.id" class="p-3.5 rounded-xl bg-slate-900/60 border border-slate-800 flex items-center justify-between">
              <div>
                <div class="flex items-center space-x-2">
                  <span class="font-bold text-white text-xs">{{ msg.sender_name }}</span>
                  <span v-if="!msg.is_read" class="w-2 h-2 rounded-full bg-amber-400"></span>
                </div>
                <p class="text-[11px] text-slate-400 line-clamp-1 mt-0.5">{{ msg.subject || msg.body }}</p>
              </div>
              <span class="text-[10px] text-slate-500 font-mono">{{ new Date(msg.created_at).toLocaleDateString() }}</span>
            </div>
          </div>
        </div>

        <!-- Recent Projects Panel -->
        <div class="p-6 rounded-2xl bg-[#0B0F17] border border-slate-800 space-y-4">
          <div class="flex items-center justify-between border-b border-slate-800 pb-3">
            <h3 class="font-bold text-white text-sm">Recent Projects</h3>
            <Link :href="route('admin.projects.index')" class="text-xs text-blue-400 font-semibold hover:underline">Manage All</Link>
          </div>

          <div v-if="!recent_projects.length" class="text-center py-8 text-xs text-slate-500">
            No projects added yet.
          </div>

          <div v-else class="space-y-3">
            <div v-for="p in recent_projects" :key="p.id" class="p-3.5 rounded-xl bg-slate-900/60 border border-slate-800 flex items-center justify-between">
              <div class="flex items-center space-x-3">
                <img :src="p.image_path || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=200&q=80'" class="w-10 h-10 rounded-lg object-cover border border-slate-800" />
                <div>
                  <h4 class="font-bold text-white text-xs">{{ p.title }}</h4>
                  <span class="text-[10px] text-blue-400 font-medium">{{ p.category }}</span>
                </div>
              </div>
              <span v-if="p.is_featured" class="px-2 py-0.5 rounded-full bg-blue-600/30 text-blue-300 text-[10px] font-bold">Featured</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
  stats: Object,
  recent_messages: Array,
  recent_projects: Array,
});
</script>
