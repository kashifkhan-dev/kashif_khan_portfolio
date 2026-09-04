<template>
  <AuthenticatedLayout>
    <template #header>Inquiries Inbox</template>
    <Head title="Inquiries Inbox - Admin" />

    <div class="space-y-5">
      
      <!-- Top Page Header -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-neutral-800 pb-4">
        <div>
          <h1 class="text-2xl font-extrabold tracking-tight text-white flex items-center gap-3">
            <Mail class="h-6 w-6 text-red-500" />
            <span>Gmail Inquiries</span>
            <span class="px-2.5 py-0.5 rounded-[6px] text-xs font-semibold bg-neutral-900 text-neutral-400 border border-neutral-800">
              {{ unreadCount }} unread
            </span>
          </h1>
          <p class="text-xs text-neutral-400 mt-1">Manage client messages and reply directly via Gmail SMTP mailer.</p>
        </div>

        <!-- Top Search Bar -->
        <div class="flex items-center gap-3">
          <div class="relative w-full sm:w-80">
            <Search class="h-4 w-4 absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400" />
            <input 
              v-model="searchQuery" 
              type="text" 
              placeholder="Search mail by sender, email, or subject..." 
              class="w-full h-9 pl-9 pr-3 rounded-[6px] border border-neutral-800 bg-neutral-900 text-white text-xs placeholder:text-neutral-500 focus:outline-none focus:border-neutral-600 transition-colors" 
            />
          </div>
        </div>
      </div>

      <!-- MAIN GMAIL CANVAS -->
      <div class="rounded-[10px] border border-neutral-800 bg-neutral-950 shadow-2xl overflow-hidden min-h-[620px] flex flex-col">
        
        <!-- GMAIL INBOX LIST VIEW -->
        <div v-if="currentView === 'list'" class="flex-1 flex flex-col">
          
          <!-- Gmail Action Toolbar / Tabs -->
          <div class="px-4 py-2.5 border-b border-neutral-800 bg-neutral-900/60 flex items-center justify-between text-xs">
            <div class="flex items-center gap-3">
              <!-- Select All Checkbox -->
              <label class="flex items-center gap-2 cursor-pointer text-neutral-400 hover:text-white select-none">
                <input 
                  type="checkbox" 
                  :checked="isAllSelected" 
                  @change="toggleSelectAll" 
                  class="rounded border-neutral-700 bg-neutral-900 text-indigo-500 focus:ring-0 h-4 w-4 cursor-pointer" 
                />
              </label>

              <button 
                @click="refreshList" 
                class="p-1.5 rounded hover:bg-neutral-800 text-neutral-400 hover:text-white transition-colors cursor-pointer" 
                title="Refresh Inbox"
              >
                <RotateCw class="h-4 w-4" />
              </button>

              <div class="h-4 w-px bg-neutral-800"></div>

              <!-- Filter Tabs -->
              <div class="flex items-center gap-1">
                <button 
                  @click="activeTab = 'primary'" 
                  class="px-3 py-1 rounded-[6px] font-semibold transition-colors flex items-center gap-1.5 cursor-pointer"
                  :class="activeTab === 'primary' ? 'bg-neutral-800 text-white border border-neutral-700' : 'text-neutral-400 hover:text-white'"
                >
                  <Inbox class="h-3.5 w-3.5" />
                  <span>Primary ({{ messages.length }})</span>
                </button>

                <button 
                  @click="activeTab = 'unread'" 
                  class="px-3 py-1 rounded-[6px] font-semibold transition-colors flex items-center gap-1.5 cursor-pointer"
                  :class="activeTab === 'unread' ? 'bg-neutral-800 text-white border border-neutral-700' : 'text-neutral-400 hover:text-white'"
                >
                  <MailUnread class="h-3.5 w-3.5" />
                  <span>Unread ({{ unreadCount }})</span>
                </button>

                <button 
                  @click="activeTab = 'starred'" 
                  class="px-3 py-1 rounded-[6px] font-semibold transition-colors flex items-center gap-1.5 cursor-pointer"
                  :class="activeTab === 'starred' ? 'bg-neutral-800 text-white border border-neutral-700' : 'text-neutral-400 hover:text-white'"
                >
                  <Star class="h-3.5 w-3.5 text-amber-400 fill-amber-400" />
                  <span>Starred ({{ starredIds.length }})</span>
                </button>
              </div>
            </div>

            <!-- Page Count Info -->
            <div class="text-[11px] text-neutral-500 font-mono">
              1–{{ filteredMessages.length }} of {{ filteredMessages.length }}
            </div>
          </div>

          <!-- Empty Inbox State -->
          <div v-if="!filteredMessages.length" class="flex-1 flex flex-col items-center justify-center p-16 text-center text-neutral-500">
            <Inbox class="h-12 w-12 text-neutral-700 mb-3" />
            <h3 class="text-sm font-bold text-neutral-300">Your inbox is empty</h3>
            <p class="text-xs text-neutral-500 mt-1">No email messages match your filter query.</p>
          </div>

          <!-- Gmail Table Rows -->
          <div v-else class="divide-y divide-neutral-800/60 overflow-y-auto max-h-[580px]">
            <div 
              v-for="msg in filteredMessages" 
              :key="msg.id"
              @click="openMessageDetail(msg)"
              class="px-4 py-3 flex items-center gap-3.5 transition-all cursor-pointer group hover:bg-neutral-900/80"
              :class="!msg.is_read ? 'bg-neutral-900/40 font-bold' : 'bg-neutral-950 text-neutral-300'"
            >
              <!-- Checkbox -->
              <input 
                type="checkbox" 
                :value="msg.id" 
                v-model="selectedIds"
                @click.stop 
                class="rounded border-neutral-700 bg-neutral-900 text-indigo-500 focus:ring-0 h-4 w-4 cursor-pointer shrink-0" 
              />

              <!-- Star Icon -->
              <button 
                @click.stop="toggleStar(msg.id)" 
                class="text-neutral-600 hover:text-amber-400 transition-colors shrink-0"
                title="Star message"
              >
                <Star 
                  class="h-4 w-4" 
                  :class="starredIds.includes(msg.id) ? 'text-amber-400 fill-amber-400' : 'text-neutral-600'" 
                />
              </button>

              <!-- Sender Name -->
              <div class="w-44 shrink-0 truncate">
                <span 
                  class="text-xs" 
                  :class="!msg.is_read ? 'font-black text-white' : 'font-semibold text-neutral-300'"
                >
                  {{ msg.sender_name }}
                </span>
              </div>

              <!-- Subject & Body Snippet Inline -->
              <div class="flex-1 min-w-0 flex items-center gap-2 truncate">
                <span 
                  class="text-xs shrink-0 truncate max-w-[240px]"
                  :class="!msg.is_read ? 'font-bold text-neutral-100' : 'text-neutral-300'"
                >
                  <span class="text-neutral-500 font-medium">Subject:</span> {{ msg.subject || 'No Subject' }}
                </span>
                <span class="text-neutral-600 text-xs">—</span>
                <span class="text-xs text-neutral-500 truncate font-normal">
                  {{ getLatestSnippet(msg) }}
                </span>
              </div>

              <!-- Status Tag (Replied) -->
              <span 
                v-if="msg.replied_at" 
                class="px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-950 text-emerald-400 border border-emerald-800 shrink-0"
              >
                Replied
              </span>

              <!-- Hover Quick Action Buttons & Date -->
              <div class="flex items-center gap-2 shrink-0">
                <div class="hidden group-hover:flex items-center gap-1">
                  <button 
                    @click.stop="toggleReadStatus(msg)" 
                    class="p-1 rounded hover:bg-neutral-800 text-neutral-400 hover:text-white transition-colors"
                    :title="msg.is_read ? 'Mark as Unread' : 'Mark as Read'"
                  >
                    <MailOpen v-if="!msg.is_read" class="h-3.5 w-3.5" />
                    <Mail class="h-3.5 w-3.5 text-neutral-400" v-else />
                  </button>

                  <button 
                    @click.stop="openDeleteModal(msg)" 
                    class="p-1 rounded hover:bg-neutral-800 text-neutral-400 hover:text-rose-400 transition-colors"
                    title="Delete message"
                  >
                    <Trash2 class="h-3.5 w-3.5" />
                  </button>
                </div>

                <span class="text-xs text-neutral-500 font-mono group-hover:hidden">
                  {{ formatDate(msg.created_at) }}
                </span>
              </div>

            </div>
          </div>

        </div>

        <!-- GMAIL THREAD / DETAIL VIEW -->
        <div v-else-if="currentView === 'detail' && selectedMsg" class="flex-1 flex flex-col bg-neutral-950">
          
          <!-- Gmail Action Bar -->
          <div class="px-5 py-3 border-b border-neutral-800 bg-neutral-900/60 flex items-center justify-between">
            <div class="flex items-center gap-3">
              <button 
                @click="closeDetailView" 
                class="h-8 px-3 rounded-[6px] border border-neutral-800 bg-neutral-900 text-neutral-300 hover:text-white hover:bg-neutral-800 text-xs font-semibold transition-colors flex items-center gap-1.5 cursor-pointer"
                title="Back to inbox list"
              >
                <ArrowLeft class="h-4 w-4" />
                <span>Back to Inbox</span>
              </button>

              <div class="h-4 w-px bg-neutral-800"></div>

              <button 
                @click="toggleReadStatus(selectedMsg)" 
                class="p-1.5 rounded-[6px] hover:bg-neutral-800 text-neutral-400 hover:text-white transition-colors cursor-pointer"
                :title="selectedMsg.is_read ? 'Mark as Unread' : 'Mark as Read'"
              >
                <MailOpen class="h-4 w-4" />
              </button>

              <button 
                @click="openDeleteModal(selectedMsg)" 
                class="p-1.5 rounded-[6px] hover:bg-neutral-800 text-neutral-400 hover:text-rose-400 transition-colors cursor-pointer"
                title="Delete Email"
              >
                <Trash2 class="h-4 w-4" />
              </button>

              <button 
                @click="toggleStar(selectedMsg.id)" 
                class="p-1.5 rounded-[6px] hover:bg-neutral-800 transition-colors cursor-pointer"
                title="Star Email"
              >
                <Star 
                  class="h-4 w-4" 
                  :class="starredIds.includes(selectedMsg.id) ? 'text-amber-400 fill-amber-400' : 'text-neutral-400'" 
                />
              </button>
            </div>

            <span class="text-xs text-neutral-500 font-mono">Inquiry #{{ selectedMsg.id }}</span>
          </div>

          <!-- Clean Gmail Thread Canvas -->
          <div class="p-6 md:p-8 flex-1 overflow-y-auto space-y-6">
            
            <!-- Email Subject Header -->
            <div class="flex items-center justify-between pb-4 border-b border-neutral-800">
              <h2 class="text-xl font-extrabold text-white tracking-tight flex items-center gap-2">
                <span class="text-neutral-400 font-semibold text-sm">Subject:</span>
                <span>{{ selectedMsg.subject || 'No Subject' }}</span>
              </h2>
              <span class="px-2.5 py-1 rounded-[6px] text-xs font-bold bg-neutral-900 text-neutral-400 border border-neutral-800">
                Inbox
              </span>
            </div>

            <!-- Main Email View (Gmail Thread) -->
            <div class="space-y-6">
              
              <!-- Sender Details Bar -->
              <div class="flex items-start justify-between gap-4">
                <div class="flex items-center gap-3.5">
                  <div 
                    class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-black text-white shadow-md shrink-0"
                    :class="getAvatarGradient(selectedMsg.sender_name)"
                  >
                    {{ getInitials(selectedMsg.sender_name) }}
                  </div>
                  <div>
                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                      <span>{{ selectedMsg.sender_name }}</span>
                      <span class="text-xs text-neutral-400 font-mono font-normal">&lt;{{ selectedMsg.sender_email }}&gt;</span>
                    </h3>
                    <p class="text-xs text-neutral-500 font-mono mt-0.5">
                      to me
                    </p>
                  </div>
                </div>

                <div class="text-right space-y-1">
                  <span class="text-xs text-neutral-400 font-mono block">
                    {{ formatFullDate(selectedMsg.created_at) }}
                  </span>
                  <button 
                    @click="scrollToReply" 
                    class="inline-flex items-center gap-1 text-xs text-indigo-400 hover:text-indigo-300 font-semibold cursor-pointer"
                  >
                    <Reply class="h-3.5 w-3.5" />
                    <span>Reply</span>
                  </button>
                </div>
              </div>

              <!-- Message Body Text (Clean borderless Gmail typography) -->
              <div class="sm:pl-14 text-sm text-neutral-200 leading-relaxed whitespace-pre-line font-sans">
                {{ selectedMsg.body }}
              </div>
            </div>

            <!-- Sent Reply Gmail Thread Cards (All Historical Replies) -->
            <div 
              v-for="(reply, idx) in messageReplies" 
              :key="idx" 
              class="pt-6 border-t border-neutral-800/80 space-y-4"
            >
              <!-- Admin Reply Details Bar -->
              <div class="flex items-start justify-between gap-4">
                <div class="flex items-center gap-3.5">
                  <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-700 flex items-center justify-center text-xs font-black text-white shadow-md shrink-0">
                    YOU
                  </div>
                  <div>
                    <h3 class="text-sm font-bold text-white flex items-center gap-2">
                      <span>You</span>
                      <span class="text-xs text-neutral-400 font-mono font-normal">to {{ selectedMsg.sender_name }}</span>
                      <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-emerald-950 text-emerald-400 border border-emerald-800/80">
                        {{ messageReplies.length > 1 ? `Reply #${idx + 1}` : 'Replied' }}
                      </span>
                    </h3>
                    <p class="text-xs text-neutral-500 font-mono mt-0.5">
                      from &lt;{{ selectedMsg.sender_email }}&gt;
                    </p>
                  </div>
                </div>

                <span class="text-xs text-neutral-400 font-mono" v-if="reply.created_at">
                  {{ formatFullDate(reply.created_at) }}
                </span>
              </div>

              <!-- Sent Reply Body Text -->
              <div class="sm:pl-14 text-sm text-neutral-200 leading-relaxed whitespace-pre-line font-sans border-l-2 border-emerald-500/40 pl-3 py-1">
                {{ reply.body }}
              </div>
            </div>

            <!-- GMAIL COMPOSER BOX -->
            <div id="reply-composer" class="rounded-[8px] border border-neutral-800 bg-neutral-900 shadow-xl overflow-hidden mt-6">
              
              <!-- Composer Top Bar -->
              <div class="px-4 py-3 bg-neutral-950 border-b border-neutral-800 flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs font-bold text-white">
                  <Reply class="h-4 w-4 text-indigo-400" />
                  <span>Reply</span>
                </div>
                <span class="text-xs text-neutral-400 font-mono">
                  To: {{ selectedMsg.sender_name }} &lt;{{ selectedMsg.sender_email }}&gt;
                </span>
              </div>

              <!-- Compose Form -->
              <form @submit.prevent="sendGmailReply" class="p-4 space-y-3">
                <!-- Informational Banner for Gmail Replies -->
                <div class="p-3 rounded-[6px] border border-blue-900/40 bg-blue-950/20 text-blue-300 text-xs flex items-center gap-2.5">
                  <Info class="h-4 w-4 shrink-0 text-blue-400" />
                  <span>
                    Sending a reply here emails the client directly. Client follow-up replies will be delivered directly to your <strong>Gmail Inbox</strong>.
                  </span>
                </div>

                <textarea 
                  v-model="replyForm.reply_body"
                  rows="4"
                  required
                  placeholder="Write your email reply here..."
                  class="w-full p-4 rounded-[6px] border border-neutral-800 bg-neutral-950 text-white text-xs placeholder:text-neutral-500 focus:outline-none focus:border-neutral-600 transition-colors leading-relaxed resize-none"
                ></textarea>

                <!-- Composer Bottom Toolbar -->
                <div class="flex items-center justify-between pt-1">
                  <!-- Helper Status Text (Left) -->
                  <span class="text-[11px] text-neutral-500 font-mono flex items-center gap-1.5">
                    <ShieldCheck class="h-3.5 w-3.5 text-emerald-400" />
                    <span>Delivered via Gmail SMTP mailer</span>
                  </span>

                  <!-- Action Buttons (Right) -->
                  <div class="flex items-center gap-2">
                    <button 
                      type="button" 
                      @click="openInGmail(selectedMsg)" 
                      class="h-9 px-3.5 rounded-[6px] border border-neutral-800 bg-neutral-900 hover:bg-neutral-800 text-xs font-semibold text-neutral-300 hover:text-white transition-colors cursor-pointer flex items-center gap-1.5"
                      title="Open client conversation directly in Gmail Web"
                    >
                      <ExternalLink class="h-3.5 w-3.5 text-blue-400" />
                      <span>Open in Gmail</span>
                    </button>

                    <button 
                      type="button" 
                      @click="replyForm.reply_body = ''" 
                      class="h-9 px-3.5 rounded-[6px] border border-neutral-800 bg-neutral-900 text-xs font-semibold text-neutral-400 hover:text-white transition-colors cursor-pointer"
                    >
                      Discard
                    </button>

                    <button 
                      type="submit" 
                      :disabled="replyForm.processing || !replyForm.reply_body.trim()"
                      class="h-9 px-6 rounded-[6px] bg-blue-600 hover:bg-blue-500 text-white text-xs font-extrabold transition-all shadow-md flex items-center gap-2 cursor-pointer disabled:opacity-50"
                    >
                      <Loader2 v-if="replyForm.processing" class="h-4 w-4 animate-spin" />
                      <Send v-else class="h-4 w-4" />
                      <span>{{ replyForm.processing ? 'Sending...' : 'Send Reply' }}</span>
                    </button>
                  </div>
                </div>
              </form>
            </div>

          </div>

        </div>

      </div>

      <!-- Reusable Executive Delete Confirmation Modal -->
      <DeleteConfirmModal
        :is-open="isDeleteModalOpen"
        title="Delete Inquiry Email"
        :item-title="msgToDelete ? `Email from ${msgToDelete.sender_name}` : ''"
        :loading="isDeleting"
        @close="isDeleteModalOpen = false"
        @confirm="confirmDelete"
      />

    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteConfirmModal from '@/Components/DeleteConfirmModal.vue';
import { 
  Mail, 
  Search, 
  Inbox, 
  Trash2, 
  MailOpen, 
  Send, 
  ShieldCheck, 
  Loader2,
  ArrowLeft,
  RotateCw,
  Star,
  Mail as MailUnread,
  Reply,
  Info,
  ExternalLink
} from 'lucide-vue-next';
import { useToast } from '@/Composables/useToast';

const props = defineProps({
  messages: {
    type: Array,
    default: () => [],
  },
});

const { toast } = useToast();

const currentView = ref('list'); // 'list' or 'detail'
const activeTab = ref('primary'); // 'primary', 'unread', 'starred'
const searchQuery = ref('');
const selectedMsg = ref(null);

const selectedIds = ref([]);
const starredIds = ref([]);

const unreadCount = computed(() => {
  return props.messages.filter(m => !m.is_read).length;
});

const isAllSelected = computed(() => {
  return filteredMessages.value.length > 0 && selectedIds.value.length === filteredMessages.value.length;
});

const filteredMessages = computed(() => {
  return props.messages.filter(msg => {
    // Search query filter
    const q = searchQuery.value.toLowerCase().trim();
    const matchSearch = !q || (
      (msg.sender_name && msg.sender_name.toLowerCase().includes(q)) ||
      (msg.sender_email && msg.sender_email.toLowerCase().includes(q)) ||
      (msg.subject && msg.subject.toLowerCase().includes(q)) ||
      (msg.body && msg.body.toLowerCase().includes(q))
    );

    // Tab filter
    if (activeTab.value === 'unread') {
      return matchSearch && !msg.is_read;
    }
    if (activeTab.value === 'starred') {
      return matchSearch && starredIds.value.includes(msg.id);
    }
    return matchSearch;
  });
});

const messageReplies = computed(() => {
  if (!selectedMsg.value) return [];
  if (Array.isArray(selectedMsg.value.replies) && selectedMsg.value.replies.length > 0) {
    return selectedMsg.value.replies;
  }
  if (selectedMsg.value.reply_body) {
    return [{
      body: selectedMsg.value.reply_body,
      created_at: selectedMsg.value.replied_at
    }];
  }
  return [];
});

const replyForm = useForm({
  reply_body: '',
});

function toggleSelectAll(e) {
  if (e.target.checked) {
    selectedIds.value = filteredMessages.value.map(m => m.id);
  } else {
    selectedIds.value = [];
  }
}

function toggleStar(id) {
  if (starredIds.value.includes(id)) {
    starredIds.value = starredIds.value.filter(i => i !== id);
  } else {
    starredIds.value.push(id);
  }
}

function refreshList() {
  router.reload({ preserveScroll: true });
}

function openMessageDetail(msg) {
  selectedMsg.value = msg;
  currentView.value = 'detail';
  replyForm.reply_body = '';

  if (!msg.is_read) {
    toggleReadStatus(msg);
  }
}

function closeDetailView() {
  currentView.value = 'list';
  selectedMsg.value = null;
}

function toggleReadStatus(msg) {
  router.patch(route('admin.messages.toggle-read', msg.id), {}, {
    preserveScroll: true,
  });
}

function scrollToReply() {
  const el = document.getElementById('reply-composer');
  if (el) {
    el.scrollIntoView({ behavior: 'smooth' });
  }
}

function sendGmailReply() {
  if (!selectedMsg.value || !replyForm.reply_body.trim()) return;

  replyForm.post(route('admin.messages.reply', selectedMsg.value.id), {
    preserveScroll: true,
    showProgress: false,
    onSuccess: () => {
      replyForm.reply_body = '';
      const updated = props.messages.find(m => m.id === selectedMsg.value.id);
      if (updated) {
        selectedMsg.value = updated;
      }
      toast({
        type: 'success',
        title: 'Gmail Delivered',
        description: `Response sent to ${selectedMsg.value.sender_email}.`,
      });
    },
    onError: (errors) => {
      toast({
        type: 'error',
        title: 'Delivery Error',
        description: errors.reply_body || 'Check your Gmail SMTP settings in .env.',
      });
    }
  });
}

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
        closeDetailView();
      }
      toast({ title: 'Deleted', description: 'Email removed from inbox.', type: 'error' });
      msgToDelete.value = null;
    },
    onError: () => {
      isDeleting.value = false;
    }
  });
}

function getInitials(name) {
  if (!name) return 'IN';
  const parts = name.trim().split(/\s+/);
  if (parts.length >= 2) {
    return `${parts[0][0]}${parts[1][0]}`.toUpperCase();
  }
  return name.substring(0, 2).toUpperCase();
}

function getAvatarGradient(name) {
  const gradients = [
    'bg-gradient-to-br from-indigo-500 to-purple-600',
    'bg-gradient-to-br from-blue-500 to-cyan-600',
    'bg-gradient-to-br from-emerald-500 to-teal-600',
    'bg-gradient-to-br from-amber-500 to-orange-600',
    'bg-gradient-to-br from-rose-500 to-pink-600',
    'bg-gradient-to-br from-violet-500 to-indigo-600',
  ];
  let hash = 0;
  for (let i = 0; i < (name || '').length; i++) {
    hash = name.charCodeAt(i) + ((hash << 5) - hash);
  }
  return gradients[Math.abs(hash) % gradients.length];
}

function formatDate(dateStr) {
  if (!dateStr) return '';
  const date = new Date(dateStr);
  return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
}

function getLatestSnippet(msg) {
  if (!msg) return '';
  if (Array.isArray(msg.replies) && msg.replies.length > 0) {
    const lastReply = msg.replies[msg.replies.length - 1];
    const prefix = lastReply.sender === 'client' ? 'Client: ' : 'You: ';
    return `${prefix}${lastReply.body}`;
  }
  return msg.body;
}

function openInGmail(msg) {
  if (!msg || !msg.sender_email) return;
  const to = encodeURIComponent(msg.sender_email);
  const subject = encodeURIComponent(`Re: ${msg.subject || 'Portfolio Inquiry'}`);
  const url = `https://mail.google.com/mail/?view=cm&fs=1&to=${to}&su=${subject}`;
  window.open(url, '_blank');
}

function formatFullDate(dateStr) {
  if (!dateStr) return '';
  const date = new Date(dateStr);
  return date.toLocaleDateString('en-US', { 
    month: 'short', 
    day: 'numeric', 
    year: 'numeric',
    hour: '2-digit', 
    minute: '2-digit' 
  });
}
</script>
