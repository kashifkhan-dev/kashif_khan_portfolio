import { ref, computed } from 'vue';

const theme = ref('dark');
const isInitialized = ref(false);

export function useTheme() {
  function initTheme() {
    if (typeof window === 'undefined') return;
    
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'light' || savedTheme === 'dark') {
      theme.value = savedTheme;
    } else {
      // Default to dark mode for executive Vercel aesthetic
      theme.value = 'dark';
    }
    applyTheme();
    isInitialized.value = true;
  }

  function applyTheme() {
    if (typeof window === 'undefined') return;

    const root = document.documentElement;
    if (theme.value === 'dark') {
      root.classList.add('dark');
      root.classList.remove('light');
    } else {
      root.classList.remove('dark');
      root.classList.add('light');
    }
    localStorage.setItem('theme', theme.value);
  }

  function toggleTheme() {
    theme.value = theme.value === 'dark' ? 'light' : 'dark';
    applyTheme();
  }

  function setTheme(newTheme) {
    if (['dark', 'light'].includes(newTheme)) {
      theme.value = newTheme;
      applyTheme();
    }
  }

  const isDark = computed(() => theme.value === 'dark');

  return {
    theme,
    isDark,
    isInitialized,
    initTheme,
    toggleTheme,
    setTheme,
  };
}
