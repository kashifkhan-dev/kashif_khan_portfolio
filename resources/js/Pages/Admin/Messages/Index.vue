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
          <div class="px-3.5 py-2.5 border-b border-neutral-800 bg-neutral-900/60 space-y-2.5 sm:space-y-0 sm:flex sm:items-center sm:justify-between text-xs">
            <!-- Left Side: Checkbox, Refresh & Wrapped Filter Tabs -->
            <div class="flex flex-wrap items-center gap-2">
              <div class="flex items-center gap-2 shrink-0">
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
              </div>

              <!-- Filter Tabs (Flex Wrapped, No Scrollbar) -->
              <div class="flex flex-wrap items-center gap-1">
                <button 
                  @click="activeTab = 'primary'" 
                  class="px-2.5 py-1 rounded-[6px] font-semibold transition-colors flex items-center gap-1.5 cursor-pointer text-xs"
                  :class="activeTab === 'primary' ? 'bg-neutral-800 text-white border border-neutral-700' : 'text-neutral-400 hover:text-white'"
                >
                  <Inbox class="h-3.5 w-3.5" />
                  <span>Primary ({{ messages.length }})</span>
                </button>

                <button 
                  @click="activeTab = 'unread'" 
                  class="px-2.5 py-1 rounded-[6px] font-semibold transition-colors flex items-center gap-1.5 cursor-pointer text-xs"
                  :class="activeTab === 'unread' ? 'bg-neutral-800 text-white border border-neutral-700' : 'text-neutral-400 hover:text-white'"
                >
                  <MailUnread class="h-3.5 w-3.5" />
                  <span>Unread ({{ unreadCount }})</span>
                </button>

                <button 
                  @click="activeTab = 'starred'" 
                  class="px-2.5 py-1 rounded-[6px] font-semibold transition-colors flex items-center gap-1.5 cursor-pointer text-xs"
                  :class="activeTab === 'starred' ? 'bg-neutral-800 text-white border border-neutral-700' : 'text-neutral-400 hover:text-white'"
                >
                  <Star class="h-3.5 w-3.5 text-amber-400 fill-amber-400" />
                  <span>Starred ({{ starredIds.length }})</span>
                </button>
              </div>
            </div>

            <!-- Right Side: Page Count & Open Gmail Quick Link -->
            <div class="flex items-center justify-between sm:justify-end gap-3 shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-neutral-800/60">
              <button 
                @click="openGmailInbox"
                class="px-2.5 py-1 rounded-[6px] bg-red-950/40 hover:bg-red-900/60 border border-red-800/60 text-red-300 hover:text-white text-xs font-semibold transition-all flex items-center gap-1.5 cursor-pointer shadow-sm"
                title="Open Gmail Inbox in a new browser tab"
              >
                <ExternalLink class="h-3.5 w-3.5 text-red-400" />
                <span>Open Gmail</span>
              </button>

              <div class="text-[11px] text-neutral-500 font-mono">
                1–{{ filteredMessages.length }} of {{ filteredMessages.length }}
              </div>
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
              class="transition-all cursor-pointer group hover:bg-neutral-900/80"
              :class="!msg.is_read ? 'bg-neutral-900/40 font-bold' : 'bg-neutral-950 text-neutral-300'"
            >
              <!-- Mobile Item View (< sm) -->
              <div class="sm:hidden p-3.5 space-y-2">
                <div class="flex items-start justify-between gap-2">
                  <div class="flex items-center gap-2.5 min-w-0">
                    <input 
                      type="checkbox" 
                      :value="msg.id" 
                      v-model="selectedIds"
                      @click.stop 
                      class="rounded border-neutral-700 bg-neutral-900 text-indigo-500 focus:ring-0 h-4 w-4 cursor-pointer shrink-0" 
                    />
                    <button 
                      @click.stop="toggleStar(msg.id)" 
                      class="text-neutral-600 hover:text-amber-400 transition-colors shrink-0"
                    >
                      <Star class="h-4 w-4" :class="starredIds.includes(msg.id) ? 'text-amber-400 fill-amber-400' : 'text-neutral-600'" />
                    </button>
                    <span class="text-xs font-bold text-white truncate">{{ msg.sender_name }}</span>
                  </div>

                  <span class="text-[10px] text-neutral-500 font-mono shrink-0">{{ formatDate(msg.created_at) }}</span>
                </div>

                <div class="pl-6.5 text-xs line-clamp-1" :class="!msg.is_read ? 'font-bold text-neutral-100' : 'text-neutral-300'">
                  <span class="text-neutral-500 font-medium">Subject:</span> {{ msg.subject || 'No Subject' }}
                </div>

                <div class="pl-6.5 flex items-center justify-between gap-2">
                  <span class="text-[11px] text-neutral-500 line-clamp-1 font-normal flex-1">
                    {{ getLatestSnippet(msg) }}
                  </span>
                  <span v-if="msg.replied_at" class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-emerald-950 text-emerald-400 border border-emerald-800 shrink-0">
                    Replied
                  </span>
                </div>
              </div>

              <!-- Desktop Item View (>= sm) -->
              <div class="hidden sm:flex px-4 py-3 items-center gap-3.5">
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
                      @click.stop="openInGmail(msg)" 
                      class="p-1 rounded hover:bg-neutral-800 text-neutral-400 hover:text-red-400 transition-colors"
                      title="Open in Gmail to Reply"
                    >
                      <ExternalLink class="h-3.5 w-3.5 text-red-400" />
                    </button>

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

            <!-- DIRECT GMAIL REPLY ACTION CARD -->
            <div id="reply-composer" class="rounded-[8px] border border-neutral-800 bg-neutral-900/80 p-8 shadow-xl text-center space-y-4 mt-6">
              <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-red-500/10 border border-red-500/20 text-red-400">
                <Mail class="h-6 w-6" />
              </div>
              
              <div class="max-w-md mx-auto space-y-1">
                <h4 class="text-sm font-bold text-white">Reply Directly via Gmail</h4>
                <p class="text-xs text-neutral-400 leading-relaxed">
                  Manage all client conversations seamlessly from your Gmail inbox. Click below to compose your reply to <strong class="text-white font-mono">{{ selectedMsg.sender_email }}</strong>.
                </p>
              </div>

              <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                <button 
                  @click="openInGmail(selectedMsg)"
                  class="h-10 px-6 rounded-[6px] bg-red-600 hover:bg-red-500 text-white text-xs font-extrabold transition-all shadow-md flex items-center gap-2 cursor-pointer"
                >
                  <ExternalLink class="h-4 w-4" />
                  <span>Open in Gmail Web</span>
                </button>

                <a 
                  :href="`mailto:${selectedMsg.sender_email}?subject=Re: ${encodeURIComponent(selectedMsg.subject || 'Portfolio Inquiry')}`"
                  class="h-10 px-5 rounded-[6px] border border-neutral-700 bg-neutral-800 hover:bg-neutral-700 text-white text-xs font-semibold transition-colors flex items-center gap-2 cursor-pointer"
                >
                  <Mail class="h-4 w-4 text-neutral-400" />
                  <span>Open Mail App</span>
                </a>
              </div>
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

function openGmailInbox() {
  window.open('https://mail.google.com/mail/u/0/#inbox', '_blank');
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
