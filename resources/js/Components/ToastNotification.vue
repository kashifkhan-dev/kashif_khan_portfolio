<template>
  <div class="fixed top-4 left-1/2 -translate-x-1/2 sm:left-auto sm:translate-x-0 sm:right-4 sm:bottom-4 sm:top-auto z-50 flex flex-col gap-2 w-full max-w-sm pointer-events-none px-4 sm:px-0">
    <transition-group name="toast-slide">
      <div
        v-for="t in toasts"
        :key="t.id"
        class="pointer-events-auto w-full flex gap-3 p-4 rounded-xl border bg-card/90 backdrop-blur-md shadow-lg text-sm leading-relaxed transition-all duration-300"
        :class="getBorderClass(t.type)"
      >
        <!-- Icon based on type -->
        <component 
          :is="getIcon(t.type)" 
          class="h-4 w-4 shrink-0 mt-0.5" 
          :class="getIconColorClass(t.type)"
        />

        <!-- Title & Description -->
        <div class="flex-1 space-y-1">
          <h4 class="font-bold text-neutral-900 dark:text-neutral-50">{{ t.title }}</h4>
          <p v-if="t.description" class="text-[13px] text-muted-foreground">{{ t.description }}</p>
        </div>

        <!-- Close Button -->
        <button 
          class="h-4 w-4 shrink-0 flex items-center justify-center rounded text-muted-foreground hover:bg-neutral-100 dark:hover:bg-neutral-800 hover:text-neutral-900 dark:hover:text-neutral-50 transition-colors"
          @click="dismiss(t.id)"
        >
          <X class="h-3 w-3" />
        </button>
      </div>
    </transition-group>
  </div>
</template>

<script setup>
import { useToast } from '@/Composables/useToast';
import { 
  CheckCircle2, 
  AlertCircle, 
  AlertTriangle, 
  Info, 
  X 
} from 'lucide-vue-next';

const { toasts, dismiss } = useToast();

const getIcon = (type) => {
  switch (type) {
    case 'success': return CheckCircle2;
    case 'warning': return AlertCircle;
    case 'error': return AlertTriangle;
    default: return Info;
  }
};

const getIconColorClass = (type) => {
  switch (type) {
    case 'success': return 'text-emerald-600 dark:text-emerald-400';
    case 'warning': return 'text-amber-500 dark:text-amber-400';
    case 'error': return 'text-rose-600 dark:text-rose-400';
    default: return 'text-indigo-600 dark:text-indigo-400';
  }
};

const getBorderClass = (type) => {
  switch (type) {
    case 'success': return 'border-emerald-500/20 dark:border-emerald-500/10';
    case 'warning': return 'border-amber-500/20 dark:border-amber-500/10';
    case 'error': return 'border-rose-500/20 dark:border-rose-500/10';
    default: return 'border-border';
  }
};
</script>

<style scoped>
.toast-slide-enter-active,
.toast-slide-leave-active {
  transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.toast-slide-enter-from {
  opacity: 0;
  transform: translateY(-1rem) scale(0.95);
}

.toast-slide-leave-to {
  opacity: 0;
  transform: translateY(-1rem) scale(0.95);
}

@media (min-width: 640px) {
  .toast-slide-enter-from {
    transform: translateY(1rem) scale(0.95);
  }
  .toast-slide-leave-to {
    transform: translateY(1rem) scale(0.95);
  }
}

.toast-slide-leave-active {
  position: absolute;
  width: 100%;
}
</style>
