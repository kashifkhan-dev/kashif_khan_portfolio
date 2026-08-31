<template>
  <div class="rounded-xl border bg-card text-card-foreground shadow-sm">
    <div class="p-6 pb-2 border-b">
      <h3 class="text-base font-bold">Recent Activity</h3>
      <p class="text-xs text-muted-foreground">Real-time log of events across your workspaces.</p>
    </div>
    <div class="p-6">
      <div class="space-y-6">
        <div 
          v-for="(event, idx) in activities" 
          :key="event.id"
          class="flex items-start gap-4 relative group"
        >
          <!-- Vertical timeline line -->
          <div 
            v-if="idx < activities.length - 1"
            class="absolute left-[17px] top-8 bottom-0 w-0.5 bg-neutral-100 dark:bg-neutral-800"
          ></div>

          <!-- Event Icon Circle -->
          <div 
            class="h-8 w-8 rounded-lg border flex items-center justify-center shrink-0 z-10 transition-colors"
            :style="{ 
              backgroundColor: event.bgColor, 
              color: event.color,
              borderColor: event.borderColor
            }"
          >
            <component :is="event.icon" class="h-4 w-4" />
          </div>

          <!-- Event Details -->
          <div class="flex-1 min-w-0 space-y-1">
            <div class="flex justify-between items-baseline gap-2">
              <h4 class="text-xs font-semibold text-neutral-900 dark:text-neutral-50 truncate group-hover:text-primary transition-colors">
                {{ event.title }}
              </h4>
              <span class="text-[10px] text-muted-foreground shrink-0 font-medium">{{ event.time }}</span>
            </div>
            <p class="text-[11px] text-muted-foreground leading-relaxed">{{ event.description }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { 
  UserPlus, 
  CheckCircle2, 
  CreditCard, 
  RotateCw, 
  MessageSquare 
} from 'lucide-vue-next';

const activities = ref([
  {
    id: 1,
    title: 'New contact inquiry received',
    description: 'Marcus Aurelius (marcus@rome.com) sent a message regarding Full Stack Development.',
    time: '2 minutes ago',
    icon: UserPlus,
    bgColor: 'rgba(59, 130, 246, 0.08)',
    color: '#3b82f6',
    borderColor: 'rgba(59, 130, 246, 0.15)'
  },
  {
    id: 2,
    title: 'Project build successful',
    description: 'Kashif Khan Portfolio codebase compiled cleanly with zero warnings.',
    time: '15 minutes ago',
    icon: CheckCircle2,
    bgColor: 'rgba(16, 185, 129, 0.08)',
    color: '#10b981',
    borderColor: 'rgba(16, 185, 129, 0.15)'
  },
  {
    id: 3,
    title: 'Skill matrix updated',
    description: 'Added Tailwind CSS, Vue 3, and Laravel 11 to primary tech stack.',
    time: '45 minutes ago',
    icon: CreditCard,
    bgColor: 'rgba(6, 182, 212, 0.08)',
    color: '#06b6d4',
    borderColor: 'rgba(6, 182, 212, 0.15)'
  },
  {
    id: 4,
    title: 'Experience record added',
    description: 'Kashif Khan updated Senior Full Stack Developer role timeline.',
    time: '2 hours ago',
    icon: RotateCw,
    bgColor: 'rgba(245, 158, 11, 0.08)',
    color: '#f59e0b',
    borderColor: 'rgba(245, 158, 11, 0.15)'
  },
  {
    id: 5,
    title: 'Portfolio message read',
    description: 'Admin read contact inquiry #104 from Sarah Connor.',
    time: '3 hours ago',
    icon: MessageSquare,
    bgColor: 'rgba(168, 85, 247, 0.08)',
    color: '#a855f7',
    borderColor: 'rgba(168, 85, 247, 0.15)'
  }
]);
</script>
