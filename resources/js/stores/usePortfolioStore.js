import { defineStore } from 'pinia';

export const usePortfolioStore = defineStore('portfolio', {
  state: () => ({
    activeProjectCategory: 'All',
    activeSkillCategory: 'All',
    skillSearchQuery: '',
    selectedProject: null,
    isProjectModalOpen: false,
    isDarkMode: true,
    isResumeModalOpen: false,
    resumeModalUrl: '',
    resumeModalTitle: 'Resume / Curriculum Vitae',
  }),

  getters: {
    availableCategories: (state) => ['All', 'Fullstack', 'Frontend', 'Laravel & Vue', 'AI'],
  },

  actions: {
    setProjectCategory(category) {
      this.activeProjectCategory = category;
    },
    setActiveCategory(category) {
      this.activeProjectCategory = category;
    },
    setSkillCategory(category) {
      this.activeSkillCategory = category;
    },
    setSkillSearchQuery(query) {
      this.skillSearchQuery = query;
    },
    openProjectModal(project) {
      this.selectedProject = project;
      this.isProjectModalOpen = true;
    },
    closeProjectModal() {
      this.isProjectModalOpen = false;
      this.selectedProject = null;
    },
    openResumeModal(url, title = 'Resume / Curriculum Vitae') {
      if (url) {
        this.resumeModalUrl = url;
      }
      if (title) {
        this.resumeModalTitle = title;
      }
      this.isResumeModalOpen = true;
    },
    closeResumeModal() {
      this.isResumeModalOpen = false;
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
