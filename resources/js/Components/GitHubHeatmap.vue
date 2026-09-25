<template>
  <div class="flex flex-col gap-y-4 w-full">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <h2 class="text-xl font-bold tracking-tight text-foreground">GitHub Activity</h2>
      <a
        v-if="githubUrl"
        :href="githubUrl"
        target="_blank"
        rel="noopener noreferrer"
        class="text-xs text-muted-foreground hover:text-foreground transition-colors flex items-center gap-1 font-mono group"
      >
        <span>@{{ githubUsername }}</span>
        <svg class="w-3 h-3 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M7 17L17 7M17 7H7M17 7V17"/>
        </svg>
      </a>
    </div>

    <!-- Heatmap Container without heavy border/card, directly matching screenshot -->
    <div ref="heatmapRef" class="w-full relative group">
      <!-- Scrollable Wrapper for smaller screens -->
      <div class="w-full overflow-x-auto pb-1 no-scrollbar">
        <div class="min-w-[620px] sm:min-w-full flex flex-col">
          <!-- Months Row positioned above columns -->
          <div class="relative h-4 w-full text-[11px] font-mono text-muted-foreground mb-1 select-none">
            <span
              v-for="item in monthPositions"
              :key="item.name + item.colIndex"
              class="absolute -translate-x-1"
              :style="{ left: `${(item.colIndex / totalWeeksCount) * 100}%` }"
            >
              {{ item.name }}
            </span>
          </div>

          <!-- Squares Grid: 52 columns x 7 days -->
          <div class="flex justify-between gap-[3px] sm:gap-1 w-full">
            <div
              v-for="(week, wIdx) in weeks"
              :key="wIdx"
              class="flex flex-col gap-[3px] sm:gap-1 flex-1"
            >
              <div
                v-for="(day, dIdx) in week"
                :key="dIdx"
                @mouseenter="onHoverDay(day, $event)"
                @mouseleave="hoveredDay = null"
                class="aspect-square w-full rounded-[2px] transition-all duration-150 cursor-pointer hover:scale-125 hover:z-10"
                :class="getDayClass(day.level)"
              ></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom Metric & Legend -->
      <div class="flex items-center justify-between pt-3 text-[11px] font-mono text-muted-foreground">
        <span>{{ totalContributions.toLocaleString() }} contributions in the last year</span>

        <div class="flex items-center gap-1.5 select-none">
          <span>Less</span>
          <div class="flex gap-1 items-center">
            <span class="size-2.5 rounded-[2px] bg-[#ebedf0] dark:bg-[#161b22]"></span>
            <span class="size-2.5 rounded-[2px] bg-[#9be9a8] dark:bg-[#0e4429]"></span>
            <span class="size-2.5 rounded-[2px] bg-[#40c463] dark:bg-[#006d32]"></span>
            <span class="size-2.5 rounded-[2px] bg-[#30a14e] dark:bg-[#26a641]"></span>
            <span class="size-2.5 rounded-[2px] bg-[#216e39] dark:bg-[#39d353]"></span>
          </div>
          <span>More</span>
        </div>
      </div>

      <!-- Floating Hover Tooltip -->
      <div
        v-if="hoveredDay"
        class="absolute z-30 pointer-events-none px-2.5 py-1 rounded bg-neutral-900 text-white dark:bg-neutral-100 dark:text-neutral-900 text-[11px] font-mono shadow-lg -translate-x-1/2 -translate-y-full transition-all duration-75 whitespace-nowrap"
        :style="{ left: `${tooltipPos.x}px`, top: `${tooltipPos.y - 8}px` }"
      >
        <span class="font-semibold">{{ hoveredDay.count === 0 ? 'No' : hoveredDay.count }} contributions</span>
        <span class="opacity-75"> on {{ hoveredDay.dateStr }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  githubUrl: {
    type: String,
    default: 'https://github.com/KashifKhan456',
  },
  username: {
    type: String,
    default: 'KashifKhan456',
  }
});

const githubUsername = computed(() => {
  if (props.username) return props.username;
  const parts = props.githubUrl.split('/');
  return parts[parts.length - 1] || 'KashifKhan456';
});

const heatmapRef = ref(null);
const totalContributions = ref(2736);
const hoveredDay = ref(null);
const tooltipPos = ref({ x: 0, y: 0 });

const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
const totalWeeksCount = 52;

// Deterministic seedable random to create consistent realistic commit activity matching screenshot
function createRealisticWeeks() {
  const weeksData = [];
  const now = new Date();
  let cumulativeCount = 0;

  for (let w = totalWeeksCount - 1; w >= 0; w--) {
    const week = [];
    for (let d = 0; d < 7; d++) {
      const dayOffset = (w * 7) + (6 - d);
      const date = new Date(now.getTime() - dayOffset * 24 * 60 * 60 * 1000);
      
      // Deterministic activity based on week/day hash
      const pseudoHash = Math.sin((w * 7) + d + 77) * 10000;
      const rand = pseudoHash - Math.floor(pseudoHash);
      
      let level = 0;
      let count = 0;
      const isWeekend = d === 0 || d === 6;
      const threshold = isWeekend ? 0.42 : 0.20;

      if (rand > threshold) {
        if (rand > 0.86) {
          level = 4;
          count = Math.floor(rand * 12) + 8;
        } else if (rand > 0.68) {
          level = 3;
          count = Math.floor(rand * 7) + 4;
        } else if (rand > 0.46) {
          level = 2;
          count = Math.floor(rand * 4) + 2;
        } else {
          level = 1;
          count = Math.floor(rand * 2) + 1;
        }
      }

      cumulativeCount += count;

      const dateStr = date.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
      });

      week.push({ level, count, dateStr, date });
    }
    weeksData.push(week);
  }

  totalContributions.value = cumulativeCount;
  return weeksData;
}

const weeks = ref(createRealisticWeeks());

// Calculate month positions aligned with columns
const monthPositions = computed(() => {
  const positions = [];
  let lastMonth = -1;
  weeks.value.forEach((week, wIdx) => {
    const firstDay = week[0];
    if (firstDay && firstDay.date) {
      const m = firstDay.date.getMonth();
      if (m !== lastMonth) {
        positions.push({
          name: monthNames[m],
          colIndex: wIdx,
        });
        lastMonth = m;
      }
    }
  });
  return positions;
});

function getDayClass(level) {
  switch (level) {
    case 1:
      return 'bg-[#9be9a8] dark:bg-[#0e4429]';
    case 2:
      return 'bg-[#40c463] dark:bg-[#006d32]';
    case 3:
      return 'bg-[#30a14e] dark:bg-[#26a641]';
    case 4:
      return 'bg-[#216e39] dark:bg-[#39d353]';
    default:
      return 'bg-[#ebedf0] dark:bg-[#161b22]';
  }
}

function onHoverDay(day, event) {
  hoveredDay.value = day;
  const parent = heatmapRef.value;
  if (parent) {
    const parentRect = parent.getBoundingClientRect();
    const elRect = event.currentTarget.getBoundingClientRect();
    tooltipPos.value = {
      x: elRect.left - parentRect.left + (elRect.width / 2),
      y: elRect.top - parentRect.top,
    };
  }
}
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar {
  display: none;
}
.no-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>
