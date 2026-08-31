<template>
  <div class="fixed bottom-5 right-5 z-50 flex flex-col space-y-3 max-w-sm w-full pointer-events-none">
    <transition-group name="toast">
      <div
        v-for="toast in notificationStore.toasts"
        :key="toast.id"
        class="pointer-events-auto p-4 rounded-xl shadow-2xl backdrop-blur-md border flex items-start space-x-3 transition-all duration-300 transform"
        :class="{
          'bg-slate-900/90 border-emerald-500/40 text-emerald-300': toast.type === 'success',
          'bg-slate-900/90 border-rose-500/40 text-rose-300': toast.type === 'error',
          'bg-slate-900/90 border-indigo-500/40 text-indigo-300': toast.type === 'info',
        }"
      >
        <div class="flex-1">
          <h4 v-if="toast.title" class="font-semibold text-sm text-white mb-0.5">{{ toast.title }}</h4>
          <p class="text-xs text-slate-300 leading-relaxed">{{ toast.message }}</p>
        </div>
        <button
          @click="notificationStore.removeToast(toast.id)"
          class="text-slate-400 hover:text-white p-1 rounded-md transition-colors"
        >
          &times;
        </button>
      </div>
    </transition-group>
  </div>
</template>

<script setup>
import { useNotificationStore } from '@/stores/useNotificationStore';

const notificationStore = useNotificationStore();
</script>

<style scoped>
.toast-enter-active,
.toast-leave-active {
  transition: all 0.3s ease;
}
.toast-enter-from {
  opacity: 0;
  transform: translateY(20px) scale(0.95);
}
.toast-leave-to {
  opacity: 0;
  transform: translateX(100px);
}
</style>
