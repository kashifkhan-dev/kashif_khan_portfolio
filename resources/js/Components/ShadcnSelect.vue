<template>
  <div class="relative w-full" ref="containerRef">
    <!-- Dropdown Trigger Button -->
    <button
      type="button"
      @click="isOpen = !isOpen"
      :class="[
        'w-full px-3.5 rounded-[6px] border border-neutral-300 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/60 text-neutral-900 dark:text-neutral-100 text-xs font-medium flex items-center justify-between transition-all focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 cursor-pointer',
        triggerClass || 'h-10',
        isOpen ? 'border-indigo-500 ring-1 ring-indigo-500' : ''
      ]"
    >
      <span class="truncate flex items-center gap-2">
        <span v-if="selectedLabel" class="font-semibold">{{ selectedLabel }}</span>
        <span v-else class="text-neutral-500 dark:text-neutral-500">{{ placeholder }}</span>
      </span>
      <ChevronDown 
        :class="[
          'h-4 w-4 text-neutral-400 transition-transform duration-200 shrink-0 ml-2',
          isOpen ? 'rotate-180 text-foreground' : ''
        ]" 
      />
    </button>

    <!-- Dropdown Popover Menu -->
    <transition
      enter-active-class="transition duration-100 ease-out"
      enter-from-class="transform scale-95 opacity-0 -translate-y-1"
      enter-to-class="transform scale-100 opacity-100 translate-y-0"
      leave-active-class="transition duration-75 ease-in"
      leave-from-class="transform scale-100 opacity-100 translate-y-0"
      leave-to-class="transform scale-95 opacity-0 -translate-y-1"
    >
      <div
        v-if="isOpen"
        class="absolute left-0 right-0 top-full mt-1.5 z-[9999] rounded-[8px] border border-neutral-200 dark:border-neutral-800 bg-white/95 dark:bg-neutral-950/95 backdrop-blur-md shadow-2xl p-1.5 space-y-0.5 max-h-60 overflow-y-auto"
      >
        <button
          v-for="opt in formattedOptions"
          :key="opt.value"
          type="button"
          @click="selectOption(opt.value)"
          :class="[
            'w-full px-3 py-2 rounded-[6px] text-xs flex items-center justify-between transition-all text-left cursor-pointer',
            modelValue === opt.value 
              ? 'bg-neutral-200/80 dark:bg-neutral-800/90 text-neutral-950 dark:text-neutral-50 font-bold border border-neutral-300 dark:border-neutral-700/60 shadow-xs' 
              : 'text-neutral-700 dark:text-neutral-300 font-medium hover:bg-neutral-100 dark:hover:bg-neutral-800/60 hover:text-neutral-950 dark:hover:text-neutral-50'
          ]"
        >
          <div class="flex items-center gap-2 truncate">
            <span>{{ opt.label }}</span>
          </div>
          <Check v-if="modelValue === opt.value" class="h-3.5 w-3.5 shrink-0 ml-2 text-indigo-500 dark:text-indigo-400" />
        </button>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { ChevronDown, Check } from 'lucide-vue-next';

const props = defineProps({
  modelValue: [String, Number],
  options: {
    type: Array,
    required: true,
  },
  placeholder: {
    type: String,
    default: 'Select an option...',
  },
  triggerClass: {
    type: String,
    default: '',
  },
});

const emit = defineEmits(['update:modelValue']);

const isOpen = ref(false);
const containerRef = ref(null);

const formattedOptions = computed(() => {
  return props.options.map(opt => {
    if (typeof opt === 'string') {
      return { label: opt, value: opt };
    }
    return opt;
  });
});

const selectedLabel = computed(() => {
  const found = formattedOptions.value.find(o => o.value === props.modelValue);
  return found ? found.label : '';
});

function selectOption(val) {
  emit('update:modelValue', val);
  isOpen.value = false;
}

function handleClickOutside(e) {
  if (containerRef.value && !containerRef.value.contains(e.target)) {
    isOpen.value = false;
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});
</script>
