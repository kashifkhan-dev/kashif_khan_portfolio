<template>
  <teleport to="body">
    <transition
      enter-active-class="transition duration-150 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-100 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div 
        v-if="isOpen" 
        class="fixed inset-0 z-[99999] bg-slate-900/50 dark:bg-black/80 backdrop-blur-xs flex items-center justify-center p-4"
        @click.self="close"
      >
        <transition
          enter-active-class="transition duration-150 ease-out"
          enter-from-class="opacity-0 scale-95 translate-y-2"
          enter-to-class="opacity-100 scale-100 translate-y-0"
          leave-active-class="transition duration-100 ease-in"
          leave-from-class="opacity-100 scale-100 translate-y-0"
          leave-to-class="opacity-0 scale-95 translate-y-2"
        >
          <div 
            class="fixed left-[50%] top-[50%] z-[99999] grid w-[calc(100%-2.5rem)] max-w-md translate-x-[-50%] translate-y-[-50%] gap-4 border border-slate-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 p-5 sm:p-6 shadow-2xl rounded-[6px] text-left"
            @click.stop
          >
            <!-- Shadcn Alert Dialog Header -->
            <div class="flex flex-col space-y-2 text-center sm:text-left">
              <div class="flex items-center gap-2 text-red-500">
                <div class="p-2 rounded-full bg-red-500/10 border border-red-500/20 shrink-0">
                  <AlertTriangle class="h-4 w-4" />
                </div>
                <h2 class="text-base font-bold text-slate-900 dark:text-neutral-50 tracking-tight">
                  {{ title || 'Are you absolutely sure?' }}
                </h2>
              </div>
              <p class="text-xs text-slate-600 dark:text-neutral-400 leading-relaxed pt-1">
                This action cannot be undone. This will permanently delete 
                <strong class="text-slate-900 dark:text-neutral-100 font-semibold">"{{ itemTitle }}"</strong> 
                and remove all associated data from your active portfolio database.
              </p>
            </div>

            <!-- Shadcn Alert Dialog Footer -->
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2 pt-2 border-t border-slate-200 dark:border-neutral-800/60">
              <button
                type="button"
                @click="close"
                :disabled="loading"
                class="mt-2 sm:mt-0 inline-flex h-9 items-center justify-center rounded-[6px] border border-slate-300 dark:border-neutral-800 bg-white dark:bg-transparent px-4 py-2 text-xs font-semibold text-slate-700 dark:text-neutral-300 transition-colors hover:bg-slate-50 dark:hover:bg-neutral-800 hover:text-slate-900 dark:hover:text-white focus:outline-none focus:ring-1 focus:ring-slate-400 disabled:pointer-events-none disabled:opacity-50 cursor-pointer shadow-2xs"
              >
                Cancel
              </button>
              <button
                type="button"
                @click="confirm"
                :disabled="loading"
                class="inline-flex h-9 items-center justify-center gap-2 rounded-[6px] bg-red-600 px-4 py-2 text-xs font-bold text-white transition-colors hover:bg-red-700 focus:outline-none focus:ring-1 focus:ring-red-500 disabled:pointer-events-none disabled:opacity-50 cursor-pointer shadow-sm"
              >
                <Loader2 v-if="loading" class="h-3.5 w-3.5 animate-spin" />
                <span>{{ loading ? 'Deleting...' : 'Continue' }}</span>
              </button>
            </div>
          </div>
        </transition>
      </div>
    </transition>
  </teleport>
</template>

<script setup>
import { AlertTriangle, Loader2 } from 'lucide-vue-next';

const props = defineProps({
  isOpen: Boolean,
  title: {
    type: String,
    default: 'Are you absolutely sure?',
  },
  itemTitle: {
    type: String,
    default: '',
  },
  loading: Boolean,
});

const emit = defineEmits(['close', 'confirm']);

function close() {
  if (!props.loading) {
    emit('close');
  }
}

function confirm() {
  emit('confirm');
}
</script>
