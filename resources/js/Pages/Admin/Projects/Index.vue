<template>
  <AuthenticatedLayout>
    <template #header>Projects Manager</template>
    <Head title="Projects Manager - Kashif Khan Dev" />

    <div class="space-y-8 max-w-7xl mx-auto">
      <!-- Page Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b pb-6">
        <div>
          <h1 class="text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-50 flex items-center gap-2">
            <span>Projects Showcase Manager</span>
          </h1>
          <p class="text-sm text-muted-foreground mt-1">Full control over portfolio projects, tech stack tags, live demos, and hero showcase positioning.</p>
        </div>

        <Link
          :href="route('admin.projects.create')"
          class="h-10 px-4 text-xs font-bold rounded-lg bg-neutral-900 text-neutral-50 dark:bg-neutral-50 dark:text-neutral-900 hover:opacity-90 transition-all flex items-center gap-2 shadow-md shrink-0"
        >
          <Plus class="h-4 w-4" />
          <span>Add New Project</span>
        </Link>
      </div>

      <!-- Quick Metrics Grid -->
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border bg-card text-card-foreground p-5 shadow-sm">
          <span class="text-xs font-medium text-muted-foreground uppercase tracking-wider">Total Projects</span>
          <div class="text-2xl font-bold tracking-tight mt-1 text-foreground">{{ projects.length }}</div>
          <span class="text-[11px] text-muted-foreground mt-1 block">Active in portfolio database</span>
        </div>
        <div class="rounded-xl border bg-card text-card-foreground p-5 shadow-sm">
          <span class="text-xs font-medium text-muted-foreground uppercase tracking-wider">Featured Showcase</span>
          <div class="text-2xl font-bold tracking-tight mt-1 text-emerald-600 dark:text-emerald-400">
            {{ featuredCount }}
          </div>
          <span class="text-[11px] text-muted-foreground mt-1 block">Displayed on homepage hero</span>
        </div>
        <div class="rounded-xl border bg-card text-card-foreground p-5 shadow-sm">
          <span class="text-xs font-medium text-muted-foreground uppercase tracking-wider">Categories</span>
          <div class="text-2xl font-bold tracking-tight mt-1 text-foreground">{{ categoriesCount }}</div>
          <span class="text-[11px] text-muted-foreground mt-1 block">Distinct technology domains</span>
        </div>
        <div class="rounded-xl border bg-card text-card-foreground p-5 shadow-sm">
          <span class="text-xs font-medium text-muted-foreground uppercase tracking-wider">Live Demos</span>
          <div class="text-2xl font-bold tracking-tight mt-1 text-indigo-600 dark:text-indigo-400">
            {{ liveDemosCount }}
          </div>
          <span class="text-[11px] text-muted-foreground mt-1 block">Verified demo links</span>
        </div>
      </div>

      <!-- Data Table Card -->
      <div class="rounded-xl border bg-card text-card-foreground shadow-sm overflow-hidden">
        <!-- Table Control Toolbar -->
        <div class="p-4 border-b flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-muted/20">
          <div class="relative w-full sm:w-80">
            <Search class="absolute left-3 top-2.5 h-4 w-4 text-muted-foreground" />
            <input 
              v-model="searchQuery" 
              placeholder="Search projects by title, summary, or tech..." 
              class="w-full h-9 pl-9 pr-3 rounded-lg border bg-background text-xs text-foreground placeholder:text-muted-foreground focus:ring-1 focus:ring-ring outline-none"
            />
          </div>

          <div class="flex items-center gap-2">
            <span class="text-xs text-muted-foreground font-medium">Filter Category:</span>
            <select 
              v-model="selectedCategoryFilter"
              class="h-9 px-3 rounded-lg border bg-background text-xs text-foreground focus:ring-1 focus:ring-ring outline-none"
            >
              <option value="all">All Categories</option>
              <option value="Fullstack">Fullstack</option>
              <option value="Frontend">Frontend</option>
              <option value="Laravel & Vue">Laravel & Vue</option>
              <option value="AI">AI / ML</option>
              <option value="Mobile">Mobile</option>
            </select>
          </div>
        </div>

        <!-- Table View -->
        <div class="overflow-x-auto">
          <table class="w-full text-left text-xs">
            <thead class="bg-muted/50 border-b text-muted-foreground uppercase text-[10px] font-bold tracking-wider select-none">
              <tr>
                <th class="py-3.5 px-6">Project Info</th>
                <th class="py-3.5 px-4">Category</th>
                <th class="py-3.5 px-4">Tech Stack</th>
                <th class="py-3.5 px-4">Status</th>
                <th class="py-3.5 px-4 text-center">Order</th>
                <th class="py-3.5 px-6 text-right">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y border-t-0">
              <tr 
                v-for="proj in filteredProjects" 
                :key="proj.id" 
                class="hover:bg-muted/40 transition-colors text-xs group"
              >
                <td class="py-4 px-6 flex items-start space-x-4">
                  <div class="relative shrink-0 group">
                    <img 
                      :src="proj.image_path || 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=200&q=80'" 
                      class="w-14 h-14 rounded-lg object-cover border bg-muted shadow-sm transition-transform group-hover:scale-105" 
                      @error="handleImageError"
                    />
                  </div>
                  <div class="min-w-0 space-y-1">
                    <div class="flex items-center gap-2">
                      <h4 class="font-bold text-neutral-900 dark:text-neutral-50 text-sm truncate">{{ proj.title }}</h4>
                      <a 
                        v-if="proj.demo_url" 
                        :href="proj.demo_url" 
                        target="_blank" 
                        title="Open Live Demo"
                        class="text-muted-foreground hover:text-foreground transition-colors"
                      >
                        <ExternalLink class="h-3.5 w-3.5" />
                      </a>
                      <a 
                        v-if="proj.github_url" 
                        :href="proj.github_url" 
                        target="_blank" 
                        title="View GitHub Repository"
                        class="text-muted-foreground hover:text-foreground transition-colors"
                      >
                        <Github class="h-3.5 w-3.5" />
                      </a>
                    </div>
                    <p class="text-[11px] text-muted-foreground leading-relaxed line-clamp-2 max-w-md">{{ proj.summary }}</p>
                  </div>
                </td>
                <td class="py-4 px-4 font-semibold text-foreground">
                  <span class="px-2.5 py-1 rounded-md bg-muted/60 text-xs font-semibold border whitespace-nowrap">
                    {{ proj.category }}
                  </span>
                </td>
                <td class="py-4 px-4">
                  <div class="flex flex-wrap gap-1 max-w-xs">
                    <span 
                      v-for="(t, i) in (proj.tech_stack || [])" 
                      :key="i" 
                      class="px-2 py-0.5 rounded-md bg-neutral-100 dark:bg-neutral-800 text-[10px] font-medium border text-neutral-700 dark:text-neutral-300"
                    >
                      {{ t }}
                    </span>
                  </div>
                </td>
                <td class="py-4 px-4">
                  <button 
                    @click="toggleFeaturedStatus(proj)"
                    class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider inline-flex items-center gap-1.5 transition-all hover:scale-105"
                    :class="proj.is_featured 
                      ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' 
                      : 'bg-muted text-muted-foreground border hover:text-foreground'"
                  >
                    <span :class="['h-1.5 w-1.5 rounded-full', proj.is_featured ? 'bg-emerald-500' : 'bg-neutral-400']"></span>
                    {{ proj.is_featured ? 'Featured' : 'Standard' }}
                  </button>
                </td>
                <td class="py-4 px-4 text-center font-mono font-bold text-foreground">
                  <span class="px-2 py-1 rounded bg-muted font-bold text-xs">{{ proj.order }}</span>
                </td>
                <!-- 3-Dots Actions Menu -->
                <td class="py-4 px-6 text-right relative">
                  <div class="inline-block text-left relative">
                    <button 
                      @click.stop="toggleDropdown(proj.id)"
                      class="h-8 w-8 rounded-lg border bg-background hover:bg-muted text-muted-foreground hover:text-foreground transition-colors inline-flex items-center justify-center shadow-sm"
                      title="Actions Menu"
                    >
                      <MoreVertical class="h-4 w-4" />
                    </button>

                    <!-- Dropdown Popover Menu -->
                    <div 
                      v-if="activeDropdownId === proj.id"
                      @click.stop
                      class="absolute right-0 mt-2 w-44 rounded-xl border bg-popover p-1.5 shadow-xl z-50 text-left space-y-0.5 divide-y divide-border/40"
                    >
                      <div class="py-1 space-y-0.5">
                        <a 
                          :href="route('projects.show', proj.slug || proj.id)" 
                          target="_blank"
                          class="flex items-center gap-2 px-3 py-2 text-xs font-medium text-foreground hover:bg-muted rounded-lg transition-colors"
                          @click="activeDropdownId = null"
                        >
                          <Eye class="h-3.5 w-3.5 text-blue-500" />
                          <span>View Detail Page</span>
                        </a>
                        <Link 
                          :href="route('admin.projects.edit', proj.id)"
                          class="flex items-center gap-2 px-3 py-2 text-xs font-medium text-foreground hover:bg-muted rounded-lg transition-colors"
                          @click="activeDropdownId = null"
                        >
                          <Edit2 class="h-3.5 w-3.5 text-muted-foreground" />
                          <span>Edit Project</span>
                        </Link>
                      </div>

                      <div class="pt-1">
                        <button 
                          @click="deleteProject(proj); activeDropdownId = null;"
                          class="w-full flex items-center gap-2 px-3 py-2 text-xs font-medium text-rose-600 dark:text-rose-400 hover:bg-rose-500/10 rounded-lg transition-colors"
                        >
                          <Trash2 class="h-3.5 w-3.5" />
                          <span>Delete Project</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>

              <tr v-if="filteredProjects.length === 0">
                <td colspan="6" class="py-12 text-center text-muted-foreground text-xs">
                  No projects matching your search criteria.
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { 
  Plus, 
  Search, 
  ExternalLink, 
  Github, 
  MoreVertical,
  Eye,
  Edit2, 
  Trash2 
} from 'lucide-vue-next';
import { useToast } from '@/Composables/useToast';

const props = defineProps({
  projects: Array,
});

const { toast } = useToast();

const searchQuery = ref('');
const selectedCategoryFilter = ref('all');
const activeDropdownId = ref(null);

function toggleDropdown(id) {
  activeDropdownId.value = activeDropdownId.value === id ? null : id;
}

function closeDropdownOnOutsideClick() {
  if (activeDropdownId.value !== null) {
    activeDropdownId.value = null;
  }
}

onMounted(() => {
  window.addEventListener('click', closeDropdownOnOutsideClick);
});

onUnmounted(() => {
  window.removeEventListener('click', closeDropdownOnOutsideClick);
});

// Computed Filters & Stats
const filteredProjects = computed(() => {
  let list = props.projects || [];
  if (selectedCategoryFilter.value !== 'all') {
    list = list.filter(p => p.category === selectedCategoryFilter.value);
  }
  if (searchQuery.value.trim() !== '') {
    const q = searchQuery.value.toLowerCase();
    list = list.filter(p => 
      p.title.toLowerCase().includes(q) || 
      (p.summary && p.summary.toLowerCase().includes(q)) ||
      (p.tech_stack && p.tech_stack.some(t => t.toLowerCase().includes(q)))
    );
  }
  return list;
});

const featuredCount = computed(() => (props.projects || []).filter(p => p.is_featured).length);
const categoriesCount = computed(() => new Set((props.projects || []).map(p => p.category)).size);
const liveDemosCount = computed(() => (props.projects || []).filter(p => p.demo_url).length);

function handleImageError(e) {
  e.target.src = 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=200&q=80';
}

function toggleFeaturedStatus(project) {
  router.put(route('admin.projects.update', project.id), {
    ...project,
    is_featured: !project.is_featured
  }, {
    onSuccess: () => {
      toast({
        title: 'Status Updated',
        description: `"${project.title}" ${!project.is_featured ? 'featured on showcase' : 'set to standard'}.`,
        type: 'success'
      });
    }
  });
}

function deleteProject(project) {
  if (confirm(`Are you sure you want to delete "${project.title}"?`)) {
    router.delete(route('admin.projects.destroy', project.id), {
      onSuccess: () => {
        toast({
          title: 'Project Removed',
          description: `"${project.title}" deleted from database.`,
          type: 'error'
        });
      },
    });
  }
}
</script>
