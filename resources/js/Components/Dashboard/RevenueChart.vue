<template>
  <div class="rounded-xl border bg-card text-card-foreground shadow-sm">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-2 sm:space-y-0 p-6 pb-6 border-b">
      <div>
        <h3 class="text-lg font-bold text-foreground">Revenue Analytics</h3>
        <p class="text-xs text-muted-foreground">Compare revenue metrics against the previous period.</p>
      </div>

      <div class="flex items-center gap-4">
        <!-- Legend -->
        <div class="hidden sm:flex items-center gap-3 text-xs">
          <div class="flex items-center gap-1.5">
            <span class="h-2 w-2 rounded-full bg-neutral-900 dark:bg-neutral-50"></span>
            <span class="text-muted-foreground font-medium">Current Period</span>
          </div>
          <div class="flex items-center gap-1.5">
            <span class="h-2.5 w-2.5 rounded-full border border-dashed border-neutral-400 bg-transparent"></span>
            <span class="text-muted-foreground font-medium">Previous Period</span>
          </div>
        </div>

        <!-- Period Toggle -->
        <div class="flex p-1 rounded-lg bg-muted text-xs font-semibold">
          <button
            @click="activePeriod = 'weekly'"
            :class="[
              'px-3 py-1 rounded-md transition-all',
              activePeriod === 'weekly' ? 'bg-background text-foreground shadow-sm font-bold' : 'text-muted-foreground hover:text-foreground'
            ]"
          >
            Weekly
          </button>
          <button
            @click="activePeriod = 'monthly'"
            :class="[
              'px-3 py-1 rounded-md transition-all',
              activePeriod === 'monthly' ? 'bg-background text-foreground shadow-sm font-bold' : 'text-muted-foreground hover:text-foreground'
            ]"
          >
            Monthly
          </button>
        </div>
      </div>
    </div>

    <div class="p-6">
      <!-- Total metric header -->
      <div class="flex flex-wrap items-baseline gap-4 mb-6">
        <div>
          <span class="text-sm font-medium text-muted-foreground">Total Revenue</span>
          <div class="text-3xl font-bold tracking-tight mt-1 text-foreground">{{ totalRevenue }}</div>
        </div>
        <div class="text-xs flex items-center gap-1 font-medium text-emerald-600 dark:text-emerald-400">
          <span>+12.5%</span>
          <span class="text-muted-foreground">vs prev period</span>
        </div>
      </div>

      <!-- Interactive Chart Area -->
      <div 
        ref="chartContainer"
        class="relative w-full h-80 cursor-crosshair select-none"
        @mousemove="handleMouseMove"
        @mouseleave="handleMouseLeave"
      >
        <svg class="w-full h-full" :viewBox="`0 0 ${width} ${height}`">
          <!-- Gradients -->
          <defs>
            <linearGradient id="revenue-current-gradient" x1="0" y1="0" x2="0" y2="1">
              <stop offset="0%" stop-color="var(--chart-primary, #ffffff)" stop-opacity="0.12" />
              <stop offset="100%" stop-color="var(--chart-primary, #ffffff)" stop-opacity="0.0" />
            </linearGradient>
          </defs>

          <!-- Horizontal Grid Lines -->
          <g class="text-neutral-200 dark:text-neutral-800">
            <line 
              v-for="i in 4" 
              :key="i"
              x1="45" 
              :y1="getGridY(i)" 
              :x2="width - 20" 
              :y2="getGridY(i)" 
              stroke="currentColor" 
              stroke-width="1"
              stroke-dasharray="2,4"
            />
          </g>

          <!-- Previous Period Path (Dashed Line) -->
          <path
            :d="prevPeriodPath"
            fill="none"
            stroke="hsl(var(--muted-foreground) / 0.4)"
            stroke-dasharray="4,4"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          />

          <!-- Current Period Gradient Area -->
          <path
            :d="currentPeriodFillPath"
            fill="url(#revenue-current-gradient)"
            stroke="none"
          />

          <!-- Current Period Path (Solid Line) -->
          <path
            :d="currentPeriodPath"
            fill="none"
            stroke="hsl(var(--primary))"
            stroke-width="2.5"
            stroke-linecap="round"
            stroke-linejoin="round"
          />

          <!-- X and Y Axes Text Labels -->
          <g class="text-[10px] fill-neutral-400 font-mono">
            <text 
              v-for="(label, idx) in yLabels" 
              :key="idx"
              x="35"
              :y="getGridY(idx + 1) + 4.5"
              text-anchor="end"
            >
              {{ label }}
            </text>
          </g>

          <g class="text-[10px] fill-neutral-400 font-medium">
            <text
              v-for="(point, idx) in chartData"
              :key="idx"
              :x="getX(idx)"
              :y="height - 10"
              text-anchor="middle"
            >
              {{ point.label }}
            </text>
          </g>

          <!-- Active Hover States (Vertical Line, Markers) -->
          <g v-if="hoverIndex !== null" class="transition-all duration-75">
            <line
              :x1="getX(hoverIndex)"
              y1="20"
              :x2="getX(hoverIndex)"
              :y2="height - 30"
              stroke="hsl(var(--border))"
              stroke-width="1.5"
            />
            <circle
              :cx="getX(hoverIndex)"
              :cy="getPrevY(hoverIndex)"
              r="4"
              fill="hsl(var(--background))"
              stroke="hsl(var(--muted-foreground) / 0.6)"
              stroke-width="1.5"
            />
            <circle
              :cx="getX(hoverIndex)"
              :cy="getCurrentY(hoverIndex)"
              r="5"
              fill="hsl(var(--primary))"
              stroke="hsl(var(--background))"
              stroke-width="2"
            />
          </g>
        </svg>

        <!-- Custom Tooltip Div -->
        <div
          v-if="hoverIndex !== null && chartData[hoverIndex]"
          class="absolute z-30 pointer-events-none rounded-lg border bg-popover p-3 shadow-md text-popover-foreground text-xs min-w-[150px] transition-all duration-75"
          :style="{
            left: `${getTooltipLeft()}px`,
            top: `${getTooltipTop()}px`
          }"
        >
          <div class="font-semibold border-b pb-1.5 mb-1.5 text-neutral-900 dark:text-neutral-50">{{ chartData[hoverIndex].labelName }}</div>
          <div class="space-y-1">
            <div class="flex items-center justify-between gap-4">
              <span class="text-muted-foreground flex items-center gap-1.5">
                <span class="h-2 w-2 rounded-full bg-neutral-900 dark:bg-neutral-50"></span>
                Current:
              </span>
              <span class="font-bold text-neutral-900 dark:text-neutral-50">{{ formatCurrency(chartData[hoverIndex].current) }}</span>
            </div>
            <div class="flex items-center justify-between gap-4">
              <span class="text-muted-foreground flex items-center gap-1.5">
                <span class="h-2.5 w-2.5 rounded-full border border-dashed border-neutral-400 bg-transparent"></span>
                Previous:
              </span>
              <span class="font-medium">{{ formatCurrency(chartData[hoverIndex].previous) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';

const activePeriod = ref('monthly');
const chartContainer = ref(null);
const width = ref(600);
const height = ref(320);

const handleResize = () => {
  if (chartContainer.value) {
    width.value = chartContainer.value.clientWidth;
    height.value = chartContainer.value.clientHeight;
  }
};

onMounted(() => {
  handleResize();
  window.addEventListener('resize', handleResize);
  document.documentElement.style.setProperty('--chart-primary', 'hsl(var(--primary))');
});

onUnmounted(() => {
  window.removeEventListener('resize', handleResize);
});

watch(activePeriod, () => {
  setTimeout(handleResize, 50);
});

const monthlyData = [
  { label: 'Jan', labelName: 'January', current: 4800, previous: 4200 },
  { label: 'Feb', labelName: 'February', current: 5900, previous: 4500 },
  { label: 'Mar', labelName: 'March', current: 5200, previous: 5000 },
  { label: 'Apr', labelName: 'April', current: 6300, previous: 5300 },
  { label: 'May', labelName: 'May', current: 7100, previous: 5800 },
  { label: 'Jun', labelName: 'June', current: 6500, previous: 6200 },
  { label: 'Jul', labelName: 'July', current: 8200, previous: 7000 },
  { label: 'Aug', labelName: 'August', current: 8424, previous: 7500 },
  { label: 'Sep', labelName: 'September', current: 7800, previous: 7400 },
  { label: 'Oct', labelName: 'October', current: 8900, previous: 7800 },
  { label: 'Nov', labelName: 'November', current: 9200, previous: 8100 },
  { label: 'Dec', labelName: 'December', current: 10500, previous: 9000 }
];

const weeklyData = [
  { label: 'Mon', labelName: 'Monday', current: 1200, previous: 1100 },
  { label: 'Tue', labelName: 'Tuesday', current: 1500, previous: 1300 },
  { label: 'Wed', labelName: 'Wednesday', current: 1800, previous: 1400 },
  { label: 'Thu', labelName: 'Thursday', current: 1400, previous: 1600 },
  { label: 'Fri', labelName: 'Friday', current: 2200, previous: 1900 },
  { label: 'Sat', labelName: 'Saturday', current: 2500, previous: 2100 },
  { label: 'Sun', labelName: 'Sunday', current: 2100, previous: 2200 }
];

const chartData = computed(() => {
  return activePeriod.value === 'monthly' ? monthlyData : weeklyData;
});

const totalRevenue = computed(() => {
  const sum = chartData.value.reduce((acc, curr) => acc + curr.current, 0);
  return formatCurrency(sum * 10);
});

const maxVal = computed(() => {
  const allVals = chartData.value.flatMap(d => [d.current, d.previous]);
  const peak = Math.max(...allVals);
  return Math.ceil(peak / 1000) * 1000;
});

const minVal = computed(() => {
  const allVals = chartData.value.flatMap(d => [d.current, d.previous]);
  const low = Math.min(...allVals);
  return Math.max(0, Math.floor(low / 1000) * 1000 - 500);
});

const yLabels = computed(() => {
  const span = maxVal.value - minVal.value;
  const steps = 3;
  const step = span / steps;
  return Array.from({ length: 4 }, (_, i) => formatCurrency(maxVal.value - step * i));
});

const getGridY = (index) => {
  const graphHeight = height.value - 60;
  return 20 + ((index - 1) / 3) * graphHeight;
};

const getX = (idx) => {
  const graphWidth = width.value - 60;
  return 55 + (idx / (chartData.value.length - 1)) * graphWidth;
};

const getY = (val) => {
  const graphHeight = height.value - 60;
  const range = maxVal.value - minVal.value;
  const pct = (val - minVal.value) / range;
  return height.value - 40 - pct * graphHeight;
};

const getCurrentY = (idx) => getY(chartData.value[idx].current);
const getPrevY = (idx) => getY(chartData.value[idx].previous);

const currentPeriodPath = computed(() => {
  if (chartData.value.length < 2) return '';
  return chartData.value.map((point, idx) => {
    const x = getX(idx);
    const y = getY(point.current);
    return `${idx === 0 ? 'M' : 'L'} ${x} ${y}`;
  }).join(' ');
});

const currentPeriodFillPath = computed(() => {
  if (chartData.value.length < 2) return '';
  const firstX = getX(0);
  const lastX = getX(chartData.value.length - 1);
  const bottomY = height.value - 40;
  return `${currentPeriodPath.value} L ${lastX} ${bottomY} L ${firstX} ${bottomY} Z`;
});

const prevPeriodPath = computed(() => {
  if (chartData.value.length < 2) return '';
  return chartData.value.map((point, idx) => {
    const x = getX(idx);
    const y = getY(point.previous);
    return `${idx === 0 ? 'M' : 'L'} ${x} ${y}`;
  }).join(' ');
});

const hoverIndex = ref(null);

const handleMouseMove = (event) => {
  if (!chartContainer.value) return;
  const rect = chartContainer.value.getBoundingClientRect();
  const x = event.clientX - rect.left;
  const graphWidth = width.value - 60;
  const pct = (x - 55) / graphWidth;
  const index = Math.round(pct * (chartData.value.length - 1));
  
  if (index >= 0 && index < chartData.value.length) {
    hoverIndex.value = index;
  } else {
    hoverIndex.value = null;
  }
};

const handleMouseLeave = () => {
  hoverIndex.value = null;
};

const getTooltipLeft = () => {
  const x = getX(hoverIndex.value);
  if (x > width.value - 170) {
    return x - 170;
  }
  return x + 15;
};

const getTooltipTop = () => {
  const y = getCurrentY(hoverIndex.value);
  if (y > height.value - 120) {
    return y - 100;
  }
  return Math.max(10, y - 40);
};

const formatCurrency = (val) => {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    maximumFractionDigits: 0
  }).format(val);
};
</script>
