<template>
  <div class="relative w-full" ref="containerRef">
    <!-- Dropdown Trigger Button -->
    <button
      type="button"
      @click="toggleDropdown"
      :class="[
        'w-full px-3.5 rounded-md border border-slate-300 dark:border-neutral-800 bg-white dark:bg-neutral-900/60 text-slate-900 dark:text-neutral-100 text-xs font-medium flex items-center justify-between transition-all focus:outline-none focus:border-slate-900 dark:focus:border-indigo-500 focus:ring-1 focus:ring-slate-900 dark:focus:ring-indigo-500 cursor-pointer',
        triggerClass || 'h-10',
        isOpen ? 'border-slate-900 dark:border-indigo-500 ring-1 ring-slate-900 dark:ring-indigo-500' : ''
      ]"
    >
      <span class="truncate flex items-center gap-2">
        <span v-if="selectedLabel" class="font-semibold">{{ selectedLabel }}</span>
        <span v-else class="text-slate-400 dark:text-neutral-500">{{ placeholder }}</span>
      </span>
      <ChevronDown 
        :class="[
          'h-4 w-4 text-slate-500 dark:text-neutral-400 transition-transform duration-200 shrink-0 ml-2',
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
        class="absolute left-0 right-0 top-full mt-1.5 z-[9999] rounded-md border border-slate-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 shadow-2xl p-1.5 space-y-1"
      >
        <!-- Search Filter Header -->
        <div v-if="isSearchable" class="p-1 border-b border-slate-100 dark:border-neutral-800/80">
          <div class="relative">
            <Search class="h-3.5 w-3.5 absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-neutral-500 pointer-events-none" />
            <input
              ref="searchInputRef"
              v-model="searchQuery"
              type="text"
              :placeholder="searchPlaceholder"
              class="w-full h-8 pl-8 pr-7 rounded-md border border-slate-200 dark:border-neutral-700 bg-slate-50 dark:bg-neutral-800/90 text-slate-900 dark:text-neutral-100 text-xs placeholder:text-slate-400 dark:placeholder:text-neutral-500 focus:outline-none focus:ring-1 focus:ring-slate-900 dark:focus:ring-indigo-500 transition-colors"
              @click.stop
              @keydown.enter.prevent="handleEnter"
            />
            <button
              v-if="searchQuery"
              type="button"
              @click.stop="searchQuery = ''"
              class="absolute right-2 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-neutral-200 p-0.5 cursor-pointer"
            >
              <X class="h-3 w-3" />
            </button>
          </div>
        </div>

        <!-- Scrollable Options List -->
        <div class="max-h-60 overflow-y-auto space-y-0.5 pr-0.5">
          <button
            v-for="opt in filteredOptions"
            :key="opt.value"
            type="button"
            @click="selectOption(opt.value)"
            :class="[
              'w-full px-3 py-2 rounded-md text-xs flex items-center justify-between transition-all text-left cursor-pointer',
              modelValue === opt.value 
                ? 'bg-slate-100 dark:bg-neutral-800/90 text-slate-900 dark:text-neutral-50 font-bold border border-slate-200 dark:border-neutral-700/60 shadow-xs' 
                : 'text-slate-700 dark:text-neutral-300 font-medium hover:bg-slate-50 dark:hover:bg-neutral-800/60 hover:text-slate-900 dark:hover:text-neutral-50'
            ]"
          >
            <div class="flex items-center gap-2 truncate">
              <span>{{ opt.label }}</span>
            </div>
            <Check v-if="modelValue === opt.value" class="h-3.5 w-3.5 shrink-0 ml-2 text-indigo-500 dark:text-indigo-400" />
          </button>

          <!-- Custom Category Option (if user searches a custom name that doesn't exist) -->
          <button
            v-if="allowCustom && searchQuery.trim() && !hasExactMatch"
            type="button"
            @click="selectOption(searchQuery.trim())"
            class="w-full px-3 py-2 rounded-md text-xs flex items-center justify-between text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 font-semibold cursor-pointer border border-dashed border-indigo-300 dark:border-indigo-800 mt-1"
          >
            <div class="flex items-center gap-1.5 truncate">
              <Plus class="h-3.5 w-3.5 shrink-0" />
              <span>Use custom: "<strong>{{ searchQuery.trim() }}</strong>"</span>
            </div>
          </button>

          <!-- Empty State -->
          <div v-if="filteredOptions.length === 0 && (!allowCustom || !searchQuery.trim())" class="py-4 text-center text-xs text-muted-foreground">
            No matching categories found.
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed, nextTick, onMounted, onUnmounted } from 'vue';
import { ChevronDown, Check, Search, X, Plus } from 'lucide-vue-next';

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
  searchable: {
    type: Boolean,
    default: true,
  },
  searchPlaceholder: {
    type: String,
    default: 'Search category...',
  },
  allowCustom: {
    type: Boolean,
    default: true,
  },
});

const emit = defineEmits(['update:modelValue']);

const isOpen = ref(false);
const containerRef = ref(null);
const searchInputRef = ref(null);
const searchQuery = ref('');

const isSearchable = computed(() => {
  return props.searchable || (props.options && props.options.length > 5);
});

const formattedOptions = computed(() => {
  return props.options.map(opt => {
    if (typeof opt === 'string') {
      return { label: opt, value: opt };
    }
    return opt;
  });
});

const filteredOptions = computed(() => {
  if (!searchQuery.value.trim()) return formattedOptions.value;
  const q = searchQuery.value.toLowerCase().trim();
  return formattedOptions.value.filter(opt => {
    const l = (opt.label || '').toLowerCase();
    const v = String(opt.value || '').toLowerCase();
    return l.includes(q) || v.includes(q);
  });
});

const hasExactMatch = computed(() => {
  const q = searchQuery.value.toLowerCase().trim();
  return formattedOptions.value.some(opt => {
    return (opt.label || '').toLowerCase() === q || String(opt.value || '').toLowerCase() === q;
  });
});

const selectedLabel = computed(() => {
  const found = formattedOptions.value.find(o => o.value === props.modelValue);
  return found ? found.label : (props.modelValue || '');
});

function toggleDropdown() {
  isOpen.value = !isOpen.value;
  if (isOpen.value) {
    searchQuery.value = '';
    if (isSearchable.value) {
      nextTick(() => {
        searchInputRef.value?.focus();
      });
    }
  }
}

function selectOption(val) {
  emit('update:modelValue', val);
  isOpen.value = false;
  searchQuery.value = '';
}

function handleEnter() {
  if (filteredOptions.value.length > 0) {
    selectOption(filteredOptions.value[0].value);
  } else if (props.allowCustom && searchQuery.value.trim()) {
    selectOption(searchQuery.value.trim());
  }
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
