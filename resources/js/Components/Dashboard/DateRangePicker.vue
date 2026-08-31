<template>
  <div class="relative">
    <button
      @click="isOpen = !isOpen"
      class="h-9 px-3 rounded-lg border bg-card text-xs font-semibold text-foreground flex items-center gap-2 hover:bg-muted transition-colors shadow-sm"
    >
      <Calendar class="h-3.5 w-3.5 text-muted-foreground" />
      <span>{{ selectedRangeLabel }}</span>
      <ChevronDown class="h-3 w-3 text-muted-foreground ml-1" />
    </button>

    <div
      v-if="isOpen"
      class="absolute right-0 mt-2 w-64 rounded-xl border bg-popover p-2 shadow-2xl z-50 text-xs space-y-1"
    >
      <div class="px-2 py-1 text-[10px] uppercase font-bold text-muted-foreground tracking-wider">Select Range</div>
      <button
        v-for="range in ranges"
        :key="range.id"
        @click="selectRange(range)"
        :class="[
          'w-full text-left px-2.5 py-1.5 rounded-lg flex items-center justify-between font-medium transition-colors',
          selectedRangeId === range.id ? 'bg-neutral-100 dark:bg-neutral-800 text-foreground font-bold' : 'text-muted-foreground hover:bg-muted hover:text-foreground'
        ]"
      >
        <span>{{ range.label }}</span>
        <Check v-if="selectedRangeId === range.id" class="h-3.5 w-3.5 text-primary" />
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Calendar, ChevronDown, Check } from 'lucide-vue-next';

const emit = defineEmits(['change']);

const isOpen = ref(false);
const selectedRangeId = ref('august');

const ranges = [
  { id: 'august', label: 'Aug 1, 2026 - Aug 18, 2026' },
  { id: '7d', label: 'Last 7 Days' },
  { id: '30d', label: 'Last 30 Days' },
  { id: 'this-month', label: 'This Month' },
  { id: 'last-month', label: 'Last Month' },
];

const selectedRangeLabel = computed(() => {
  const match = ranges.find(r => r.id === selectedRangeId.value);
  return match ? match.label : 'Select Date';
});

const selectRange = (range) => {
  selectedRangeId.value = range.id;
  isOpen.value = false;
  emit('change', range);
};
</script>
