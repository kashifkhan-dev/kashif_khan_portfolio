<template>
  <div class="relative w-full" ref="containerRef">
    <!-- Tag Chips Box & Search Input -->
    <div 
      @click="focusInput"
      class="p-3 rounded-lg border border-neutral-300 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900/60 min-h-[60px] flex flex-wrap items-center gap-2 focus-within:border-indigo-500 focus-within:ring-1 focus-within:ring-indigo-500 transition-all cursor-text"
    >
      <!-- Selected Tech Chips -->
      <span 
        v-for="(chip, index) in modelValue" 
        :key="index"
        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-neutral-200/80 dark:bg-neutral-800 text-neutral-900 dark:text-neutral-100 text-xs font-semibold border border-neutral-300 dark:border-neutral-700/60 shadow-xs group"
      >
        <span>{{ chip }}</span>
        <button 
          type="button" 
          @click.stop="removeTech(index)" 
          class="text-muted-foreground hover:text-rose-500 transition-colors"
          title="Remove technology"
        >
          <X class="h-3.5 w-3.5" />
        </button>
      </span>

      <!-- Searchable Input Field -->
      <input 
        ref="inputRef"
        v-model="searchQuery"
        @focus="isOpen = true"
        @keydown.enter.prevent="addCustomOrFirst"
        @keydown.comma.prevent="addCustomOrFirst"
        @keydown.backspace="handleBackspace"
        @keydown.escape="isOpen = false"
        placeholder="Type to search or add technology..."
        class="flex-1 min-w-[200px] bg-transparent text-xs text-neutral-900 dark:text-neutral-100 placeholder:text-muted-foreground border-0 outline-none focus:outline-none focus:ring-0 focus:border-0 py-1"
      />
    </div>

    <!-- Searchable Suggestions Popover Dropdown (Opens Upward Above Box) -->
    <transition
      enter-active-class="transition duration-100 ease-out"
      enter-from-class="transform scale-95 opacity-0 translate-y-1"
      enter-to-class="transform scale-100 opacity-100 translate-y-0"
      leave-active-class="transition duration-75 ease-in"
      leave-from-class="transform scale-100 opacity-100 translate-y-0"
      leave-to-class="transform scale-95 opacity-0 translate-y-1"
    >
      <div 
        v-if="isOpen"
        class="absolute left-0 right-0 bottom-full mb-2 z-50 rounded-xl border border-neutral-200 dark:border-neutral-800 bg-white/98 dark:bg-neutral-950/98 backdrop-blur-xl shadow-2xl p-3 space-y-2 max-h-72 overflow-y-auto"
      >
        <!-- Header -->
        <div class="flex items-center justify-between text-[11px] font-semibold text-muted-foreground border-b border-neutral-100 dark:border-neutral-800/80 pb-2">
          <span class="flex items-center gap-1.5 text-neutral-700 dark:text-neutral-300">
            <Sparkles class="h-3.5 w-3.5 text-indigo-500" />
            <span>Select Technologies</span>
          </span>
          <span class="text-[10px] text-muted-foreground">{{ filteredPresetOptions.length }} suggestions</span>
        </div>

        <!-- Custom Add Option (if typing new tech) -->
        <button
          v-if="searchQuery.trim() && !exactMatchExists"
          type="button"
          @mousedown.prevent="addTech(searchQuery.trim())"
          class="w-full px-3 py-2 rounded-lg text-xs font-semibold flex items-center gap-2 transition-all text-left bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/30 hover:bg-indigo-500/20"
        >
          <Plus class="h-3.5 w-3.5 shrink-0" />
          <span>Add custom technology <strong>"{{ searchQuery.trim() }}"</strong></span>
        </button>

        <!-- Preset Suggestions Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-1.5">
          <button
            v-for="tech in filteredPresetOptions"
            :key="tech"
            type="button"
            @mousedown.prevent="addTech(tech)"
            class="px-2.5 py-1.5 rounded-lg text-xs font-semibold flex items-center justify-between transition-all text-left border border-neutral-200 dark:border-neutral-800/80 bg-neutral-50 dark:bg-neutral-900/60 text-neutral-800 dark:text-neutral-200 hover:border-indigo-500/60 hover:bg-indigo-500/10 hover:text-indigo-600 dark:hover:text-indigo-300"
          >
            <span class="truncate">{{ tech }}</span>
            <Plus class="h-3 w-3 text-muted-foreground shrink-0 ml-1 opacity-60" />
          </button>
        </div>

        <!-- Empty state -->
        <div v-if="filteredPresetOptions.length === 0 && !searchQuery.trim()" class="py-4 text-center text-xs text-muted-foreground">
          All preset technologies selected! Type above to add a custom technology.
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { X, Plus, Sparkles } from 'lucide-vue-next';

const props = defineProps({
  modelValue: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(['update:modelValue']);

const containerRef = ref(null);
const inputRef = ref(null);
const searchQuery = ref('');
const isOpen = ref(false);

const PRESET_TECHNOLOGIES = [
  'Laravel 11', 'Vue 3', 'Tailwind CSS', 'TypeScript', 'JavaScript', 
  'PHP 8.3', 'Node.js', 'Express.js', 'React.js', 'Next.js', 
  'Nuxt.js', 'Python', 'Django', 'FastAPI', 'MySQL', 
  'PostgreSQL', 'MongoDB', 'Redis', 'Docker', 'AWS', 
  'Vercel', 'GraphQL', 'RESTful APIs', 'Inertia.js', 'OpenAI API'
];

const filteredPresetOptions = computed(() => {
  const selectedSet = new Set(props.modelValue);
  const q = searchQuery.value.toLowerCase().trim();

  return PRESET_TECHNOLOGIES.filter(tech => {
    if (selectedSet.has(tech)) return false;
    if (!q) return true;
    return tech.toLowerCase().includes(q);
  });
});

const exactMatchExists = computed(() => {
  const q = searchQuery.value.toLowerCase().trim();
  if (!q) return true;
  return props.modelValue.some(t => t.toLowerCase() === q) || 
         PRESET_TECHNOLOGIES.some(t => t.toLowerCase() === q);
});

function focusInput() {
  if (inputRef.value) {
    inputRef.value.focus();
    isOpen.value = true;
  }
}

function addTech(techName) {
  const clean = techName.trim();
  if (!clean) return;
  if (!props.modelValue.includes(clean)) {
    emit('update:modelValue', [...props.modelValue, clean]);
  }
  searchQuery.value = '';
  isOpen.value = true;
  if (inputRef.value) {
    inputRef.value.focus();
  }
}

function addCustomOrFirst() {
  const q = searchQuery.value.trim();
  if (!q) return;

  const presetMatch = PRESET_TECHNOLOGIES.find(t => t.toLowerCase() === q.toLowerCase());
  if (presetMatch) {
    addTech(presetMatch);
  } else {
    addTech(q);
  }
}

function removeTech(index) {
  const updated = [...props.modelValue];
  updated.splice(index, 1);
  emit('update:modelValue', updated);
  isOpen.value = true;
  if (inputRef.value) {
    inputRef.value.focus();
  }
}

function handleBackspace() {
  if (!searchQuery.value && props.modelValue.length > 0) {
    removeTech(props.modelValue.length - 1);
  }
}

function handleClickOutside(e) {
  if (containerRef.value && e.composedPath && !e.composedPath().includes(containerRef.value)) {
    isOpen.value = false;
  }
}

onMounted(() => {
  document.addEventListener('mousedown', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('mousedown', handleClickOutside);
});
</script>
