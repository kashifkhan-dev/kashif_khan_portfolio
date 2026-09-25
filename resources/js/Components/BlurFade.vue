<template>
  <component
    :is="as"
    ref="rootRef"
    :class="className"
    :style="motionStyle"
  >
    <slot />
  </component>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
  as: {
    type: String,
    default: 'div',
  },
  className: {
    type: [String, Object, Array],
    default: '',
  },
  duration: {
    type: Number,
    default: 0.4,
  },
  delay: {
    type: Number,
    default: 0,
  },
  yOffset: {
    type: Number,
    default: 6,
  },
  blur: {
    type: String,
    default: '6px',
  },
  inView: {
    type: Boolean,
    default: false,
  },
  inViewMargin: {
    type: String,
    default: '-50px',
  },
});

const rootRef = ref(null);
const isVisible = ref(false);
let observer = null;

onMounted(() => {
  // Check if reduced motion is requested
  if (typeof window !== 'undefined' && window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    isVisible.value = true;
    return;
  }

  if (props.inView && typeof window !== 'undefined' && 'IntersectionObserver' in window) {
    observer = new IntersectionObserver(
      (entries) => {
        if (entries[0]?.isIntersecting) {
          isVisible.value = true;
          if (observer) {
            observer.disconnect();
            observer = null;
          }
        }
      },
      {
        rootMargin: props.inViewMargin,
        threshold: 0.05,
      }
    );
    if (rootRef.value) {
      observer.observe(rootRef.value);
    }
  } else {
    // Initial mount / refresh cascade: ensure initial hidden frame is committed before triggering
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        isVisible.value = true;
      });
    });
  }
});

onBeforeUnmount(() => {
  if (observer) {
    observer.disconnect();
    observer = null;
  }
});

const motionStyle = computed(() => {
  const totalDelay = (0.04 + (props.delay || 0)).toFixed(3);
  return {
    opacity: isVisible.value ? 1 : 0,
    transform: isVisible.value ? 'translateY(0)' : `translateY(${-props.yOffset}px)`,
    filter: isVisible.value ? 'blur(0px)' : `blur(${props.blur})`,
    transitionProperty: 'opacity, transform, filter',
    transitionDuration: `${props.duration}s`,
    transitionDelay: `${totalDelay}s`,
    transitionTimingFunction: 'cubic-bezier(0, 0, 0.2, 1)',
    willChange: isVisible.value ? 'auto' : 'opacity, transform, filter',
  };
});
</script>
