<template>
  <div ref="containerRef" :class="['h-full w-full relative', className]" v-bind="$attrs">
    <canvas
      ref="canvasRef"
      class="pointer-events-none absolute inset-0"
      :style="{
        width: `${canvasSize.width}px`,
        height: `${canvasSize.height}px`,
      }"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  squareSize: {
    type: Number,
    default: 2,
  },
  gridGap: {
    type: Number,
    default: 2,
  },
  flickerChance: {
    type: Number,
    default: 0.3,
  },
  color: {
    type: String,
    default: '',
  },
  width: {
    type: Number,
    default: null,
  },
  height: {
    type: Number,
    default: null,
  },
  className: {
    type: String,
    default: '',
  },
  maxOpacity: {
    type: Number,
    default: 0.3,
  },
});

const containerRef = ref(null);
const canvasRef = ref(null);
const isInView = ref(false);
const canvasSize = ref({ width: 0, height: 0 });

let animationFrameId = null;
let resizeObserver = null;
let intersectionObserver = null;
let themeObserver = null;
let gridParams = { cols: 0, rows: 0, squares: new Float32Array(0), dpr: 1 };
let resolvedRgbaPrefix = 'rgba(0, 0, 0, ';

function resolveColorPrefix() {
  if (typeof window === 'undefined') return 'rgba(0, 0, 0, ';
  
  const isDark = document.documentElement.classList.contains('dark');
  if (props.color) {
    if (props.color.startsWith('#')) {
      const c = props.color.slice(1);
      const r = parseInt(c.substring(0, 2), 16) || 0;
      const g = parseInt(c.substring(2, 4), 16) || 0;
      const b = parseInt(c.substring(4, 6), 16) || 0;
      return `rgba(${r}, ${g}, ${b}, `;
    }
    return props.color;
  }
  
  return isDark ? 'rgba(255, 255, 255, ' : 'rgba(0, 0, 0, ';
}

function setupCanvas(canvas, width, height) {
  const dpr = window.devicePixelRatio || 1;
  canvas.width = width * dpr;
  canvas.height = height * dpr;
  canvas.style.width = `${width}px`;
  canvas.style.height = `${height}px`;

  const totalStep = props.squareSize + props.gridGap;
  const cols = Math.floor(width / totalStep);
  const rows = Math.floor(height / totalStep);

  const squares = new Float32Array(cols * rows);
  for (let i = 0; i < squares.length; i++) {
    squares[i] = Math.random() * props.maxOpacity;
  }

  return { cols, rows, squares, dpr };
}

function updateSquares(squares, deltaTime) {
  for (let i = 0; i < squares.length; i++) {
    if (Math.random() < props.flickerChance * deltaTime) {
      squares[i] = Math.random() * props.maxOpacity;
    }
  }
}

function drawGrid(ctx, width, height, cols, rows, squares, dpr) {
  ctx.clearRect(0, 0, width, height);

  const totalStep = props.squareSize + props.gridGap;
  const sqSizeDpr = props.squareSize * dpr;

  for (let i = 0; i < cols; i++) {
    for (let j = 0; j < rows; j++) {
      const opacity = squares[i * rows + j];
      ctx.fillStyle = `${resolvedRgbaPrefix}${opacity})`;
      ctx.fillRect(
        i * totalStep * dpr,
        j * totalStep * dpr,
        sqSizeDpr,
        sqSizeDpr
      );
    }
  }
}

onMounted(() => {
  const canvas = canvasRef.value;
  const container = containerRef.value;
  if (!canvas || !container) return;

  const ctx = canvas.getContext('2d');
  if (!ctx) return;

  resolvedRgbaPrefix = resolveColorPrefix();

  themeObserver = new MutationObserver(() => {
    resolvedRgbaPrefix = resolveColorPrefix();
  });
  themeObserver.observe(document.documentElement, {
    attributes: true,
    attributeFilter: ['class'],
  });

  const updateCanvasSize = () => {
    const newWidth = props.width || container.clientWidth || 300;
    const newHeight = props.height || container.clientHeight || 100;
    canvasSize.value = { width: newWidth, height: newHeight };
    gridParams = setupCanvas(canvas, newWidth, newHeight);
  };

  updateCanvasSize();

  let lastTime = performance.now();
  const animate = (time) => {
    if (!isInView.value) return;

    const deltaTime = Math.min((time - lastTime) / 1000, 0.1);
    lastTime = time;

    updateSquares(gridParams.squares, deltaTime);
    drawGrid(
      ctx,
      canvas.width,
      canvas.height,
      gridParams.cols,
      gridParams.rows,
      gridParams.squares,
      gridParams.dpr
    );
    animationFrameId = requestAnimationFrame(animate);
  };

  resizeObserver = new ResizeObserver(() => {
    updateCanvasSize();
  });
  resizeObserver.observe(container);

  intersectionObserver = new IntersectionObserver(
    ([entry]) => {
      isInView.value = entry.isIntersecting;
      if (isInView.value) {
        lastTime = performance.now();
        cancelAnimationFrame(animationFrameId);
        animationFrameId = requestAnimationFrame(animate);
      } else {
        cancelAnimationFrame(animationFrameId);
      }
    },
    { threshold: 0 }
  );
  intersectionObserver.observe(canvas);
});

onUnmounted(() => {
  if (animationFrameId) cancelAnimationFrame(animationFrameId);
  if (resizeObserver) resizeObserver.disconnect();
  if (intersectionObserver) intersectionObserver.disconnect();
  if (themeObserver) themeObserver.disconnect();
});
</script>
