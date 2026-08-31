import { defineStore } from 'pinia';

export const usePortfolioStore = defineStore('portfolio', {
  state: () => ({
    activeProjectCategory: 'All',
    activeSkillCategory: 'All',
    selectedProject: null,
    isProjectModalOpen: false,
    isDarkMode: true,
  }),

  getters: {
    availableCategories: (state) => ['All', 'Fullstack', 'Frontend', 'Laravel & Vue', 'AI'],
  },

  actions: {
    setProjectCategory(category) {
      this.activeProjectCategory = category;
    },
    setSkillCategory(category) {
      this.activeSkillCategory = category;
    },
    openProjectModal(project) {
      this.selectedProject = project;
      this.isProjectModalOpen = true;
    },
    closeProjectModal() {
      this.isProjectModalOpen = false;
      this.selectedProject = null;
    },
    toggleDarkMode() {
      this.isDarkMode = !this.isDarkMode;
      if (this.isDarkMode) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    },
  },
});
