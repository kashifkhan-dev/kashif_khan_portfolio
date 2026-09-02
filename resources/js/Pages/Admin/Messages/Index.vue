<template>
  <AuthenticatedLayout>
    <template #header>Inquiries Inbox</template>
    <Head title="Inquiries Inbox - Admin" />

    <div class="space-y-8">
      <!-- Page Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-neutral-800 pb-6">
        <div>
          <h1 class="text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-50">
            Inquiries Inbox
          </h1>
          <p class="text-sm text-muted-foreground mt-1">View and manage messages sent through the portfolio landing page contact form.</p>
        </div>
      </div>

      <div v-if="!messages || !messages.length" class="p-12 text-center border border-dashed border-neutral-800 rounded-[8px] bg-neutral-900/20 text-neutral-400 text-xs">
        No inquiries received yet.
      </div>

      <div v-else class="rounded-[8px] border border-neutral-800 bg-neutral-900/40 overflow-hidden shadow-sm">
        <table class="w-full text-left text-xs">
          <thead class="bg-neutral-900/80 border-b border-neutral-800 text-neutral-400 uppercase text-[10px] font-bold tracking-wider select-none">
            <tr>
              <th class="py-3.5 px-6">Sender</th>
              <th class="py-3.5 px-4">Subject</th>
              <th class="py-3.5 px-4">Date</th>
              <th class="py-3.5 px-4">Status</th>
              <th class="py-3.5 px-6 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-neutral-800/80">
            <tr
              v-for="msg in messages"
              :key="msg.id"
              class="hover:bg-neutral-900/60 transition-colors group"
              :class="{ 'font-bold text-white': !msg.is_read }"
            >
              <td class="py-4 px-6">
                <span class="block text-sm text-white font-bold group-hover:text-neutral-100 transition-colors">{{ msg.sender_name }}</span>
                <span class="block text-[11px] text-neutral-400 font-mono mt-0.5">{{ msg.sender_email }}</span>
              </td>
              <td class="py-4 px-4">
                <span class="block text-neutral-200 line-clamp-1 max-w-xs font-semibold">{{ msg.subject || 'No Subject' }}</span>
                <span class="block text-[11px] text-neutral-400 line-clamp-1 max-w-xs font-normal mt-0.5">{{ msg.body }}</span>
              </td>
              <td class="py-4 px-4 font-mono text-neutral-400 text-[11px]">
                {{ new Date(msg.created_at).toLocaleDateString() }}
              </td>
              <td class="py-4 px-4">
                <button
                  @click="toggleReadStatus(msg)"
                  class="px-2.5 py-1 rounded-[8px] text-[10px] font-semibold uppercase tracking-wider transition-colors cursor-pointer"
                  :class="msg.is_read ? 'bg-neutral-900 text-neutral-400 border border-neutral-800' : 'bg-neutral-800 text-white border border-neutral-700'"
                >
                  {{ msg.is_read ? 'Read' : 'New' }}
                </button>
              </td>
              <td class="py-4 px-6 text-right space-x-1">
                <button @click="viewMessage(msg)" class="px-2.5 py-1 rounded-[8px] text-neutral-300 hover:text-white hover:bg-neutral-800 font-medium transition-colors cursor-pointer">View Body</button>
                <a :href="`mailto:${msg.sender_email}?subject=Re: ${encodeURIComponent(msg.subject || 'Portfolio Inquiry')}`" class="px-2.5 py-1 rounded-[8px] text-emerald-400 hover:text-emerald-300 hover:bg-emerald-950/30 font-medium transition-colors inline-block">Reply</a>
                <button @click="openDeleteModal(msg)" class="px-2.5 py-1 rounded-[8px] text-neutral-400 hover:text-rose-400 hover:bg-rose-950/30 font-medium transition-colors cursor-pointer">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- MESSAGE DIALOG -->
      <teleport to="body">
        <div v-if="selectedMsg" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/80 backdrop-blur-md animate-in fade-in-50">
          <div class="rounded-[8px] border border-neutral-800 bg-neutral-950 text-neutral-50 shadow-2xl p-6 max-w-lg w-full space-y-6 relative max-h-[90vh] flex flex-col overflow-hidden">
            <button @click="selectedMsg = null" class="absolute top-4 right-4 text-neutral-400 hover:text-white p-1.5 rounded-[8px] hover:bg-neutral-900 transition-colors z-10">
              <X class="h-4 w-4" />
            </button>
            <div class="space-y-1 pr-6">
              <h3 class="text-lg font-bold text-white">{{ selectedMsg.subject || 'No Subject' }}</h3>
              <p class="text-xs text-neutral-400 font-mono">From: {{ selectedMsg.sender_name }} ({{ selectedMsg.sender_email }})</p>
            </div>

            <div class="p-4 rounded-[8px] bg-neutral-900 border border-neutral-800 text-xs text-neutral-200 leading-relaxed whitespace-pre-line overflow-y-auto max-h-60">
              {{ selectedMsg.body }}
            </div>

            <div class="pt-4 border-t border-neutral-800 flex items-center justify-between">
              <a
                :href="`mailto:${selectedMsg.sender_email}?subject=Re: ${encodeURIComponent(selectedMsg.subject || 'Portfolio Inquiry')}`"
                class="h-9 px-4 rounded-[8px] bg-white hover:bg-neutral-200 text-black text-xs font-bold transition-all shadow-md inline-flex items-center"
              >
                Reply via Email
              </a>
              <button @click="selectedMsg = null" class="h-9 px-4 rounded-[8px] border border-neutral-800 bg-neutral-900 text-xs font-semibold text-neutral-300 hover:bg-neutral-800 hover:text-white transition-colors cursor-pointer">Close</button>
            </div>
          </div>
        </div>
      </teleport>

      <!-- Reusable Executive Delete Confirmation Modal -->
      <DeleteConfirmModal
        :is-open="isDeleteModalOpen"
        title="Delete Inbox Message"
        :item-title="msgToDelete ? `Message from ${msgToDelete.sender_name}` : ''"
        :loading="isDeleting"
        @close="isDeleteModalOpen = false"
        @confirm="confirmDelete"
      />
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteConfirmModal from '@/Components/DeleteConfirmModal.vue';
import { X } from 'lucide-vue-next';
import { useToast } from '@/Composables/useToast';

const props = defineProps({
  messages: Array,
});

const { toast } = useToast();
const selectedMsg = ref(null);

// Delete Modal State
const isDeleteModalOpen = ref(false);
const msgToDelete = ref(null);
const isDeleting = ref(false);

function openDeleteModal(msg) {
  msgToDelete.value = msg;
  isDeleteModalOpen.value = true;
}

function confirmDelete() {
  if (!msgToDelete.value) return;
  isDeleting.value = true;
  const targetId = msgToDelete.value.id;
  router.delete(route('admin.messages.destroy', targetId), {
    onSuccess: () => {
      isDeleting.value = false;
      isDeleteModalOpen.value = false;
      if (selectedMsg.value?.id === targetId) {
        selectedMsg.value = null;
      }
      toast({ title: 'Deleted', description: 'Message removed from inbox.', type: 'error' });
      msgToDelete.value = null;
    },
    onError: () => {
      isDeleting.value = false;
    }
  });
}

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
</script>
