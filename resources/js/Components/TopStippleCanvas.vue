<template>
  <div class="absolute inset-x-0 top-0 h-[120px] overflow-hidden pointer-events-none z-0">
    <div
      class="h-full w-full"
      style="mask-image: linear-gradient(to bottom, black 20%, transparent 100%); -webkit-mask-image: linear-gradient(to bottom, black 20%, transparent 100%);"
    >
      <canvas ref="canvasRef" class="w-full h-full pointer-events-none block"></canvas>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
  isDark: {
    type: Boolean,
    default: true,
  }
});

const canvasRef = ref(null);
let animationId = null;

function renderStipple() {
  const canvas = canvasRef.value;
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  if (!ctx) return;

  const dpr = window.devicePixelRatio || 1;
  const width = canvas.parentElement.clientWidth;
  const height = canvas.parentElement.clientHeight;

  canvas.width = width * dpr;
  canvas.height = height * dpr;
  ctx.scale(dpr, dpr);

  ctx.clearRect(0, 0, width, height);

  // Generate fine stippled dot matrix like Aryan Karma's top canvas
  const dotSpacing = 8; // Dense fine grid
  const cols = Math.ceil(width / dotSpacing);
  const rows = Math.ceil(height / dotSpacing);

  const dotColor = props.isDark ? 'rgba(255, 255, 255,' : 'rgba(0, 0, 0,';

  for (let r = 0; r < rows; r++) {
    for (let c = 0; c < cols; c++) {
      // Deterministic jitter and random density
      const seed = Math.sin(c * 12.9898 + r * 78.233) * 43758.5453;
      const rand = seed - Math.floor(seed);

      // Higher chance of dot appearing towards top
      const rowRatio = 1 - (r / rows);
      if (rand < (0.35 + rowRatio * 0.45)) {
        const x = c * dotSpacing + (rand - 0.5) * 3;
        const y = r * dotSpacing + ((seed * 10) % 3 - 1.5);
        const radius = rand > 0.8 ? 1.0 : 0.7;
        const alpha = (0.15 + rand * 0.45) * Math.pow(rowRatio, 0.5);

        ctx.fillStyle = `${dotColor}${alpha.toFixed(3)})`;
        ctx.beginPath();
        ctx.arc(x, y, radius, 0, Math.PI * 2);
        ctx.fill();
      }
    }
  }
}

watch(() => props.isDark, () => {
  renderStipple();
});

function handleResize() {
  renderStipple();
}

onMounted(() => {
  renderStipple();
  window.addEventListener('resize', handleResize);
});

onUnmounted(() => {
  window.removeEventListener('resize', handleResize);
});
</script>
