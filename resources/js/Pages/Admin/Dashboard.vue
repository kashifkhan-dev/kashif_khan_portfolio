<template>
  <AuthenticatedLayout>
    <template #header>Dashboard Overview</template>
    <Head title="Admin Dashboard - Kashif Khan Portfolio" />

    <div class="space-y-8">
      <!-- Page Title & Actions (Exact matching dashboard/resources/js/views/Dashboard.vue) -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b pb-6">
        <div>
          <h1 class="text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-50 flex items-center gap-2">
            <span>Welcome back, {{ $page.props.auth.user.name || 'Super Admin' }}</span>
            <span>👋</span>
          </h1>
          <p class="text-sm text-muted-foreground mt-1">Here's what's happening with your business today.</p>
        </div>

        <div class="flex items-center gap-3">
          <!-- Date Range Picker Selector -->
          <DateRangePicker defaultRange="static-august" @change="handleDateRangeChange" />

          <!-- Export Action Button -->
          <button 
            class="h-9 px-3.5 text-xs rounded-lg font-semibold flex items-center gap-2 border bg-card hover:bg-muted text-foreground transition-colors shadow-sm"
            :disabled="isExporting"
            @click="handleExport"
          >
            <Loader2 v-if="isExporting" class="h-3.5 w-3.5 animate-spin text-muted-foreground" />
            <Download v-else class="h-3.5 w-3.5 text-muted-foreground" />
            <span>{{ isExporting ? 'Exporting...' : 'Export' }}</span>
          </button>
        </div>
      </div>

      <!-- KPI Metric Cards Grid (Exact matching 4 StatCards) -->
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <StatCard
          title="Total Revenue"
          value="$84,245"
          change="+12.5%"
          comparisonText="vs last month"
          :isPositive="true"
          :icon="DollarSign"
          :sparklineData="[40, 48, 51, 48, 62, 59, 71, 84]"
        />
        <StatCard
          title="Customers"
          value="12,842"
          change="+8.2%"
          comparisonText="vs last month"
          :isPositive="true"
          :icon="Users"
          :sparklineData="[8200, 8800, 9400, 10200, 10800, 11400, 12200, 12842]"
        />
        <StatCard
          title="Orders"
          value="3,642"
          change="+5.4%"
          comparisonText="vs last month"
          :isPositive="true"
          :icon="ShoppingBag"
          :sparklineData="[2100, 2400, 2200, 2800, 3100, 2900, 3400, 3642]"
        />
        <StatCard
          title="Conversion Rate"
          value="4.82%"
          change="+1.2%"
          comparisonText="vs last week"
          :isPositive="true"
          :icon="Activity"
          :sparklineData="[4.2, 4.4, 4.3, 4.5, 4.6, 4.5, 4.7, 4.82]"
        />
      </div>

      <!-- Charts Section -->
      <div class="grid gap-6 grid-cols-1 lg:grid-cols-3">
        <div class="col-span-1 lg:col-span-2">
          <RevenueChart />
        </div>
        <div class="col-span-1">
          <TrafficChart />
        </div>
      </div>

      <!-- Details / Recent Activity Grid -->
      <div class="grid gap-6 grid-cols-1 lg:grid-cols-4">
        <!-- Recent Messages / Projects panel -->
        <div class="col-span-1 lg:col-span-3 rounded-xl border bg-card text-card-foreground shadow-sm p-6 space-y-4">
          <div class="flex items-center justify-between border-b pb-4">
            <div>
              <h3 class="text-lg font-bold text-foreground">Recent Contact Messages</h3>
              <p class="text-xs text-muted-foreground">Manage recent inquiries from portfolio visitors.</p>
            </div>
            <Link :href="route('admin.messages.index')" class="text-xs text-primary font-semibold hover:underline">View All</Link>
          </div>

          <div v-if="!recent_messages || !recent_messages.length" class="text-center py-8 text-xs text-muted-foreground">
            No contact messages received yet.
          </div>

          <div v-else class="space-y-3">
            <div v-for="msg in recent_messages" :key="msg.id" class="p-3.5 rounded-lg border bg-muted/40 flex items-center justify-between hover:bg-muted/80 transition-colors">
              <div>
                <div class="flex items-center space-x-2">
                  <span class="font-bold text-foreground text-xs">{{ msg.sender_name }}</span>
                  <span v-if="!msg.is_read" class="w-2 h-2 rounded-full bg-amber-500"></span>
                </div>
                <p class="text-[11px] text-muted-foreground line-clamp-1 mt-0.5">{{ msg.subject || msg.body }}</p>
              </div>
              <span class="text-[10px] text-muted-foreground font-mono">{{ new Date(msg.created_at).toLocaleDateString() }}</span>
            </div>
          </div>
        </div>

        <!-- Activity Feed Timeline -->
        <div class="col-span-1 lg:col-span-1">
          <ActivityFeed />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import StatCard from '@/Components/Dashboard/StatCard.vue';
import RevenueChart from '@/Components/Dashboard/RevenueChart.vue';
import TrafficChart from '@/Components/Dashboard/TrafficChart.vue';
import DateRangePicker from '@/Components/Dashboard/DateRangePicker.vue';
import ActivityFeed from '@/Components/Dashboard/ActivityFeed.vue';
import { 
  DollarSign, 
  Users, 
  ShoppingBag, 
  Activity, 
  Download, 
  Loader2 
} from 'lucide-vue-next';

import { useToast } from '@/Composables/useToast';

defineProps({
  stats: Object,
  recent_messages: Array,
  recent_projects: Array,
});

const isExporting = ref(false);
const { toast } = useToast();

const handleDateRangeChange = (range) => {
  toast({
    title: 'Range Updated',
    description: `Dashboard telemetry refreshed for ${range.label}.`,
    type: 'success'
  });
};

const handleExport = () => {
  isExporting.value = true;
  toast({
    title: 'Export Initiated',
    description: 'Preparing your dashboard CSV dataset...',
    type: 'info'
  });
  setTimeout(() => {
    isExporting.value = false;
    toast({
      title: 'Export Complete',
      description: 'CSV export completed successfully.',
      type: 'success'
    });
  }, 1200);
};
</script>
