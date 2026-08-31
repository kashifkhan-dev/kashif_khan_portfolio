import { ref } from 'vue';

const toasts = ref([]);

export function useToast() {
  const toast = ({ title, description, type = 'info', duration = 3000 }) => {
    const id = Math.random().toString(36).substring(2, 9);
    const newToast = { id, title, description, type, duration };
    toasts.value.push(newToast);

    if (duration > 0) {
      setTimeout(() => {
        dismiss(id);
      }, duration);
    }

    return id;
  };

  const dismiss = (id) => {
    toasts.value = toasts.value.filter(t => t.id !== id);
  };

  return {
    toasts,
    toast,
    dismiss
  };
}
