<template>
  <div ref="containerRef" class="relative w-full select-none">
    <!-- Trigger Input Box -->
    <div 
      @click="togglePopover"
      class="w-full h-10 px-3.5 rounded-[6px] border border-neutral-800 bg-neutral-900 text-white text-xs flex items-center justify-between transition-all"
      :class="[
        disabled ? 'opacity-40 cursor-not-allowed bg-neutral-900/50' : 'cursor-pointer hover:border-neutral-700 group',
        isOpen ? 'border-white ring-1 ring-white' : ''
      ]"
    >
      <div class="flex items-center gap-2.5 overflow-hidden">
        <Calendar class="h-4 w-4 text-neutral-400 group-hover:text-neutral-200 shrink-0 transition-colors" />
        <span v-if="displayValue" class="font-medium text-neutral-100 truncate">{{ displayValue }}</span>
        <span v-else class="text-neutral-500 truncate">{{ placeholder }}</span>
      </div>

      <div class="flex items-center gap-1">
        <button 
          v-if="modelValue && !disabled" 
          type="button" 
          @click.stop="clearValue" 
          class="p-0.5 rounded hover:text-white hover:bg-neutral-800 text-neutral-400 transition-colors"
          title="Clear date"
        >
          <X class="h-3.5 w-3.5" />
        </button>
        <ChevronDown class="h-3.5 w-3.5 text-neutral-400 group-hover:text-neutral-200 shrink-0 transition-colors" />
      </div>
    </div>

    <!-- Shadcn Custom Calendar Popover -->
    <div 
      v-if="isOpen && !disabled" 
      class="absolute left-0 mt-1.5 w-72 p-3 rounded-[8px] border border-neutral-800 bg-neutral-950 shadow-2xl z-50 animate-in fade-in-50 duration-150"
    >
      <!-- Popover Header: Month & Year Controls -->
      <div class="flex items-center justify-between pb-2 mb-2 border-b border-neutral-800/80">
        <button 
          type="button" 
          @click="prevMonth"
          class="h-7 w-7 rounded-[6px] hover:bg-neutral-900 text-neutral-400 hover:text-white flex items-center justify-center transition-colors cursor-pointer"
        >
          <ChevronLeft class="h-4 w-4" />
        </button>

        <div class="flex items-center gap-1">
          <!-- Month Dropdown -->
          <select 
            v-model="currentMonth" 
            class="bg-transparent text-white text-xs font-semibold rounded px-1.5 py-1 outline-none cursor-pointer hover:bg-neutral-900 transition-colors border-none"
          >
            <option v-for="(m, idx) in monthNames" :key="idx" :value="idx" class="bg-neutral-950 text-white">
              {{ m }}
            </option>
          </select>

          <!-- Year Dropdown -->
          <select 
            v-model="currentYear" 
            class="bg-transparent text-white text-xs font-semibold rounded px-1.5 py-1 outline-none cursor-pointer hover:bg-neutral-900 transition-colors border-none"
          >
            <option v-for="y in yearOptions" :key="y" :value="y" class="bg-neutral-950 text-white">
              {{ y }}
            </option>
          </select>
        </div>

        <button 
          type="button" 
          @click="nextMonth"
          class="h-7 w-7 rounded-[6px] hover:bg-neutral-900 text-neutral-400 hover:text-white flex items-center justify-center transition-colors cursor-pointer"
        >
          <ChevronRight class="h-4 w-4" />
        </button>
      </div>

      <!-- Days of Week Header -->
      <div class="grid grid-cols-7 text-center mb-1 text-[11px] font-semibold text-neutral-400 select-none">
        <span>Su</span>
        <span>Mo</span>
        <span>Tu</span>
        <span>We</span>
        <span>Th</span>
        <span>Fr</span>
        <span>Sa</span>
      </div>

      <!-- Calendar Days Grid -->
      <div class="grid grid-cols-7 gap-1 text-xs">
        <button
          v-for="(dayObj, idx) in calendarDays"
          :key="idx"
          type="button"
          @click="selectDay(dayObj)"
          class="h-8 w-8 rounded-[6px] flex items-center justify-center text-xs transition-all cursor-pointer"
          :class="[
            !dayObj.isCurrentMonth ? 'text-neutral-600 hover:text-neutral-400' : 'text-neutral-200',
            dayObj.isSelected ? 'bg-white text-black font-extrabold shadow-sm' : 'hover:bg-neutral-800 hover:text-white',
            dayObj.isToday && !dayObj.isSelected ? 'border border-neutral-700 text-indigo-400 font-bold' : ''
          ]"
        >
          {{ dayObj.day }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue';
import { Calendar, ChevronLeft, ChevronRight, ChevronDown, X } from 'lucide-vue-next';

const props = defineProps({
  modelValue: {
    type: String,
    default: '',
  },
  placeholder: {
    type: String,
    default: 'Select date',
  },
  disabled: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(['update:modelValue']);

const containerRef = ref(null);
const isOpen = ref(false);

const monthNames = [
  'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
  'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'
];

const today = new Date();
const currentMonth = ref(today.getMonth());
const currentYear = ref(today.getFullYear());
const selectedDay = ref(null);

const yearOptions = computed(() => {
  const years = [];
  const start = 1990;
  const end = today.getFullYear() + 15;
  for (let y = start; y <= end; y++) {
    years.push(y);
  }
  return years;
});

const displayValue = computed(() => {
  return props.modelValue || '';
});

function parseValue(val) {
  if (!val) return;
  // Format e.g., "Sept 2026" or "Sept 15, 2026"
  const match = val.match(/([A-Za-z]+)\s+(\d{1,2}),?\s+(\d{4})/);
  if (match) {
    const monthIdx = monthNames.findIndex(m => m.toLowerCase().startsWith(match[1].toLowerCase().slice(0, 3)));
    if (monthIdx !== -1) currentMonth.value = monthIdx;
    selectedDay.value = parseInt(match[2], 10);
    currentYear.value = parseInt(match[3], 10);
    return;
  }
  
  // Format e.g., "Sept 2026"
  const matchShort = val.match(/([A-Za-z]+)\s+(\d{4})/);
  if (matchShort) {
    const monthIdx = monthNames.findIndex(m => m.toLowerCase().startsWith(matchShort[1].toLowerCase().slice(0, 3)));
    if (monthIdx !== -1) currentMonth.value = monthIdx;
    currentYear.value = parseInt(matchShort[2], 10);
  }
}

watch(() => props.modelValue, (newVal) => {
  parseValue(newVal);
}, { immediate: true });

function togglePopover() {
  if (props.disabled) return;
  isOpen.value = !isOpen.value;
}

function prevMonth() {
  if (currentMonth.value === 0) {
    currentMonth.value = 11;
    currentYear.value--;
  } else {
    currentMonth.value--;
  }
}

function nextMonth() {
  if (currentMonth.value === 11) {
    currentMonth.value = 0;
    currentYear.value++;
  } else {
    currentMonth.value++;
  }
}

const calendarDays = computed(() => {
  const days = [];
  const year = currentYear.value;
  const month = currentMonth.value;

  const firstDayIndex = new Date(year, month, 1).getDay();
  const totalDaysInMonth = new Date(year, month + 1, 0).getDate();
  const prevMonthTotalDays = new Date(year, month, 0).getDate();

  // Previous month trailing days
  for (let i = firstDayIndex - 1; i >= 0; i--) {
    days.push({
      day: prevMonthTotalDays - i,
      isCurrentMonth: false,
      isSelected: false,
      isToday: false,
      year: month === 0 ? year - 1 : year,
      month: month === 0 ? 11 : month - 1,
    });
  }

  // Current month days
  for (let d = 1; d <= totalDaysInMonth; d++) {
    const isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
    
    // Check if selected
    let isSelected = false;
    if (props.modelValue) {
      const formatted = `${monthNames[month]} ${d}, ${year}`;
      const formattedShort = `${monthNames[month]} ${year}`;
      if (props.modelValue === formatted || (selectedDay.value === d && props.modelValue.includes(monthNames[month]))) {
        isSelected = true;
      }
    }

    days.push({
      day: d,
      isCurrentMonth: true,
      isSelected,
      isToday,
      year,
      month,
    });
  }

  // Next month leading days to complete 35 or 42 grid cells
  const remaining = (42 - days.length) % 7;
  for (let n = 1; n <= remaining; n++) {
    days.push({
      day: n,
      isCurrentMonth: false,
      isSelected: false,
      isToday: false,
      year: month === 11 ? year + 1 : year,
      month: month === 11 ? 0 : month + 1,
    });
  }

  return days;
});

function selectDay(dayObj) {
  selectedDay.value = dayObj.day;
  currentMonth.value = dayObj.month;
  currentYear.value = dayObj.year;

  const formattedDate = `${monthNames[dayObj.month]} ${dayObj.day}, ${dayObj.year}`;
  emit('update:modelValue', formattedDate);
  isOpen.value = false;
}

function clearValue() {
  selectedDay.value = null;
  emit('update:modelValue', '');
}

function handleClickOutside(e) {
  if (containerRef.value && !containerRef.value.contains(e.target)) {
    isOpen.value = false;
  }
}

onMounted(() => {
  window.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  window.removeEventListener('click', handleClickOutside);
});
</script>
