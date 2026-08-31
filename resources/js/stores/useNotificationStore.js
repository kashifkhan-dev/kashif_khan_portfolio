import { defineStore } from 'pinia';

export const useNotificationStore = defineStore('notification', {
  state: () => ({
    toasts: [],
  }),

  actions: {
    addToast({ title, message, type = 'success', duration = 4000 }) {
      const id = Date.now() + Math.random();
      this.toasts.push({ id, title, message, type });

      setTimeout(() => {
        this.removeToast(id);
      }, duration);
    },
    removeToast(id) {
      this.toasts = this.toasts.filter(toast => toast.id !== id);
    },
  },
});
