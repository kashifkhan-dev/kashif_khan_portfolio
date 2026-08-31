<template>
  <div class="rounded-xl border bg-card text-card-foreground p-6 overflow-hidden hover:shadow-md transition-all duration-300 group hover:-translate-y-[2px]">
    <div class="flex items-center justify-between space-y-0 pb-2">
      <span class="text-xs font-medium text-muted-foreground uppercase tracking-wider">{{ title }}</span>
      <div class="h-8 w-8 rounded-lg bg-neutral-50 dark:bg-neutral-900 border flex items-center justify-center text-muted-foreground group-hover:text-foreground transition-colors">
        <component :is="icon" class="h-4 w-4" />
      </div>
    </div>
    <div class="flex items-end justify-between mt-2">
      <div>
        <div class="text-2xl font-bold tracking-tight text-foreground">{{ value }}</div>
        <div class="flex items-center gap-1.5 mt-1 text-xs">
          <span 
            :class="[
              'font-medium flex items-center gap-0.5',
              isPositive ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'
            ]"
          >
            <TrendingUp v-if="isPositive" class="h-3 w-3" />
            <TrendingDown v-else class="h-3 w-3" />
            {{ change }}
          </span>
          <span class="text-muted-foreground">{{ comparisonText }}</span>
        </div>
      </div>

      <!-- Small Sparkline SVG Trend -->
      <div class="w-16 h-8 opacity-80 group-hover:opacity-100 transition-opacity">
        <svg class="w-full h-full" viewBox="0 0 100 30">
          <defs>
            <linearGradient :id="`sparkline-grad-${title.replace(/\s+/g, '')}`" x1="0" y1="0" x2="0" y2="1">
              <stop offset="0%" :stop-color="isPositive ? '#10b981' : '#f43f5e'" stop-opacity="0.25" />
              <stop offset="100%" :stop-color="isPositive ? '#10b981' : '#f43f5e'" stop-opacity="0.0" />
            </linearGradient>
          </defs>
          <path
            :d="sparklinePath"
            fill="none"
            :stroke="isPositive ? '#10b981' : '#f43f5e'"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          />
          <path
            :d="sparklineFillPath"
            :fill="`url(#sparkline-grad-${title.replace(/\s+/g, '')})`"
            stroke="none"
          />
        </svg>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { TrendingUp, TrendingDown } from 'lucide-vue-next';

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  value: {
    type: [String, Number],
    required: true
  },
  change: {
    type: String,
    required: true
  },
  comparisonText: {
    type: String,
    required: true
  },
  isPositive: {
    type: Boolean,
    default: true
  },
  icon: {
    type: [Object, Function],
    required: true
  },
  sparklineData: {
    type: Array,
    default: () => [10, 15, 8, 20, 18, 25, 22, 28]
  }
});

const sparklinePath = computed(() => {
  if (props.sparklineData.length < 2) return '';
  const min = Math.min(...props.sparklineData);
  const max = Math.max(...props.sparklineData);
  const range = max - min === 0 ? 1 : max - min;
  
  return props.sparklineData.map((val, idx) => {
    const x = (idx / (props.sparklineData.length - 1)) * 100;
    const y = 30 - ((val - min) / range) * 26 - 2;
    return `${idx === 0 ? 'M' : 'L'} ${x.toFixed(1)} ${y.toFixed(1)}`;
  }).join(' ');
});

const sparklineFillPath = computed(() => {
  if (props.sparklineData.length < 2) return '';
  const path = sparklinePath.value;
  return `${path} L 100 30 L 0 30 Z`;
});
</script>
