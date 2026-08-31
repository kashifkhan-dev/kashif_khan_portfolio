<template>
  <AuthenticatedLayout>
    <template #header>Inquiries Inbox</template>
    <Head title="Inquiries Inbox - Admin" />

    <div class="space-y-6 max-w-7xl mx-auto">
      <div class="flex items-center justify-between">
        <p class="text-xs text-slate-400">View and manage messages sent through the portfolio landing page contact form.</p>
        <span class="text-xs font-semibold text-indigo-400 bg-indigo-950/60 px-3 py-1 rounded-full border border-indigo-800">
          Total Messages: {{ messages.length }}
        </span>
      </div>

      <div v-if="!messages || !messages.length" class="glass-panel p-12 text-center text-slate-400 text-xs rounded-2xl">
        No inquiries received yet.
      </div>

      <div v-else class="glass-panel rounded-2xl overflow-hidden border border-slate-800">
        <table class="w-full text-left text-xs text-slate-300">
          <thead class="bg-slate-900/80 text-slate-400 uppercase text-[10px] tracking-wider border-b border-slate-800">
            <tr>
              <th class="py-4 px-6">Sender</th>
              <th class="py-4 px-4">Subject</th>
              <th class="py-4 px-4">Date</th>
              <th class="py-4 px-4">Status</th>
              <th class="py-4 px-6 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/80">
            <tr
              v-for="msg in messages"
              :key="msg.id"
              class="hover:bg-slate-900/40 transition-colors"
              :class="{ 'font-bold text-white': !msg.is_read }"
            >
              <td class="py-4 px-6">
                <span class="block text-sm text-white font-bold">{{ msg.sender_name }}</span>
                <span class="block text-[11px] text-slate-400 font-mono">{{ msg.sender_email }}</span>
              </td>
              <td class="py-4 px-4">
                <span class="block text-slate-200 line-clamp-1 max-w-xs">{{ msg.subject || 'No Subject' }}</span>
                <span class="block text-[11px] text-slate-400 line-clamp-1 max-w-xs font-normal">{{ msg.body }}</span>
              </td>
              <td class="py-4 px-4 font-mono text-slate-400 text-[11px]">
                {{ new Date(msg.created_at).toLocaleDateString() }}
              </td>
              <td class="py-4 px-4">
                <button
                  @click="toggleReadStatus(msg)"
                  class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase transition-colors"
                  :class="msg.is_read ? 'bg-slate-800 text-slate-400' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30'"
                >
                  {{ msg.is_read ? 'Read' : 'New' }}
                </button>
              </td>
              <td class="py-4 px-6 text-right space-x-3">
                <button @click="viewMessage(msg)" class="text-indigo-400 hover:text-indigo-300 font-semibold">View Body</button>
                <a :href="`mailto:${msg.sender_email}?subject=Re: ${encodeURIComponent(msg.subject || 'Portfolio Inquiry')}`" class="text-emerald-400 hover:text-emerald-300 font-semibold">Reply</a>
                <button @click="deleteMessage(msg)" class="text-rose-400 hover:text-rose-300 font-semibold">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- MESSAGE DIALOG -->
      <div v-if="selectedMsg" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md">
        <div class="glass-panel p-8 rounded-3xl max-w-lg w-full space-y-6 border border-slate-700 shadow-2xl relative">
          <button @click="selectedMsg = null" class="absolute top-4 right-4 text-slate-400 hover:text-white p-2">&times;</button>
          <div class="space-y-1">
            <h3 class="text-xl font-extrabold text-white">{{ selectedMsg.subject || 'No Subject' }}</h3>
            <p class="text-xs text-slate-400 font-mono">From: {{ selectedMsg.sender_name }} ({{ selectedMsg.sender_email }})</p>
          </div>

          <div class="p-4 rounded-xl bg-slate-900 border border-slate-800 text-xs text-slate-200 leading-relaxed whitespace-pre-line">
            {{ selectedMsg.body }}
          </div>

          <div class="pt-4 border-t border-slate-800 flex items-center justify-between">
            <a
              :href="`mailto:${selectedMsg.sender_email}?subject=Re: ${encodeURIComponent(selectedMsg.subject || 'Portfolio Inquiry')}`"
              class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold"
            >
              Reply via Email
            </a>
            <button @click="selectedMsg = null" class="px-4 py-2 rounded-xl glass-card text-xs text-slate-400 hover:text-white">Close</button>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useNotificationStore } from '@/stores/useNotificationStore';

const props = defineProps({
  messages: Array,
});

const notificationStore = useNotificationStore();
const selectedMsg = ref(null);

function viewMessage(msg) {
  selectedMsg.value = msg;
  if (!msg.is_read) {
    toggleReadStatus(msg);
  }
}

function toggleReadStatus(msg) {
  router.patch(route('admin.messages.toggle-read', msg.id), {}, {
    preserveScroll: true,
  });
}

function deleteMessage(msg) {
  if (confirm(`Delete message from ${msg.sender_name}?`)) {
    router.delete(route('admin.messages.destroy', msg.id), {
      onSuccess: () => {
        if (selectedMsg.value?.id === msg.id) {
          selectedMsg.value = null;
        }
        notificationStore.addToast({ title: 'Deleted', message: 'Message removed from inbox.', type: 'info' });
      },
    });
  }
}
</script>
