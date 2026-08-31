<template>
  <div class="rounded-xl border bg-card text-card-foreground shadow-sm">
    <div class="p-6 pb-2">
      <h3 class="text-lg font-bold">Traffic Sources</h3>
      <p class="text-xs text-muted-foreground">Breakdown of visitors by origin channel.</p>
    </div>
    <div class="p-6">
      <div class="flex flex-col sm:flex-row items-center justify-center gap-8 mt-2">
        <!-- Interactive Donut Chart -->
        <div class="relative w-44 h-44 shrink-0 flex items-center justify-center">
          <svg class="w-full h-full -rotate-90" viewBox="0 0 100 100">
            <!-- Background base circle -->
            <circle
              cx="50"
              cy="50"
              r="38"
              fill="transparent"
              stroke="hsl(var(--muted))"
              stroke-width="10"
            />
            <!-- Segment circles -->
            <circle
              v-for="(seg, idx) in segments"
              :key="seg.name"
              cx="50"
              cy="50"
              r="38"
              fill="transparent"
              :stroke="seg.color"
              stroke-width="10"
              :stroke-dasharray="`${seg.dashLength} ${circumference}`"
              :stroke-dashoffset="seg.dashOffset"
              stroke-linecap="butt"
              class="transition-all duration-300 cursor-pointer"
              :class="[
                hoveredIndex === null || hoveredIndex === idx ? 'opacity-100' : 'opacity-40',
                hoveredIndex === idx ? 'stroke-[11.5px]' : ''
              ]"
              @mouseenter="setHovered(idx)"
              @mouseleave="clearHovered"
            />
          </svg>

          <!-- Text inside the donut hole -->
          <div class="absolute flex flex-col items-center justify-center text-center">
            <span class="text-2xl font-bold tracking-tight text-neutral-900 dark:text-neutral-50">
              {{ activeData.value }}%
            </span>
            <span class="text-[10px] uppercase font-semibold tracking-wider text-muted-foreground">
              {{ activeData.name }}
            </span>
          </div>
        </div>

        <!-- Legend -->
        <div class="flex-1 w-full space-y-3">
          <div 
            v-for="(source, idx) in sources" 
            :key="source.name"
            class="flex items-center justify-between p-2 rounded-lg transition-colors cursor-pointer border border-transparent"
            :class="{
              'bg-neutral-50 dark:bg-neutral-900 border-neutral-100 dark:border-neutral-800': hoveredIndex === idx
            }"
            @mouseenter="setHovered(idx)"
            @mouseleave="clearHovered"
          >
            <div class="flex items-center gap-2.5">
              <span class="h-2.5 w-2.5 rounded-full" :style="{ backgroundColor: source.color }"></span>
              <span class="text-xs font-semibold text-neutral-700 dark:text-neutral-300">{{ source.name }}</span>
            </div>
            <div class="text-xs font-bold text-neutral-900 dark:text-neutral-50">
              {{ source.value }}%
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const hoveredIndex = ref(null);

const sources = ref([
  { name: 'Direct', value: 42, color: '#18181b' },
  { name: 'Search', value: 28, color: '#4f46e5' },
  { name: 'Social', value: 18, color: '#06b6d4' },
  { name: 'Referral', value: 12, color: '#10b981' }
]);

const circumference = 2 * Math.PI * 38;

const segments = computed(() => {
  let accumulatedPercent = 0;
  return sources.value.map((source) => {
    const dashLength = (source.value / 100) * circumference;
    const dashOffset = -((accumulatedPercent / 100) * circumference);
    accumulatedPercent += source.value;
    return {
      ...source,
      dashLength,
      dashOffset
    };
  });
});

const hoveredItem = computed(() => {
  if (hoveredIndex.value !== null) {
    return sources.value[hoveredIndex.value];
  }
  return null;
});

const activeData = computed(() => {
  if (hoveredItem.value) {
    return hoveredItem.value;
  }
  return sources.value[0];
});

const setHovered = (idx) => {
  hoveredIndex.value = idx;
};

const clearHovered = () => {
  hoveredIndex.value = null;
};
</script>
