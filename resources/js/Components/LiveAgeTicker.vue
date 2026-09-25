<template>
  <div class="inline-flex items-center gap-1.5 text-xs font-mono text-neutral-500 dark:text-neutral-400 select-none">
    <span>been here for</span>
    <span class="tabular-nums font-semibold text-neutral-700 dark:text-neutral-300">
      {{ ageFormatted }}
    </span>
    <span>years</span>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  birthDate: {
    type: String,
    default: '2001-08-15', // Default ~24 years old
  }
});

const ageFormatted = ref('24.000000000');
let animationFrameId = null;

function updateAge() {
  const birthTime = new Date(props.birthDate).getTime();
  const now = Date.now();
  const diffYears = (now - birthTime) / (1000 * 60 * 60 * 24 * 365.242199);
  ageFormatted.value = diffYears.toFixed(9);
  animationFrameId = requestAnimationFrame(updateAge);
}

onMounted(() => {
  updateAge();
});

onUnmounted(() => {
  if (animationFrameId) {
    cancelAnimationFrame(animationFrameId);
  }
});
</script>
