<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Bar, Doughnut } from 'vue-chartjs';
import {
  Chart,
  BarElement,
  CategoryScale,
  LinearScale,
  Title,
  Tooltip,
  Legend,
  ArcElement
} from 'chart.js';

// Register Chart.js components
Chart.register(BarElement, CategoryScale, LinearScale, Title, Tooltip, Legend, ArcElement);

// Placeholder data for charts
const leadsPerRegion = {
  labels: ['North', 'South', 'East', 'West'],
  datasets: [{
    label: 'Leads',
    data: [120, 90, 60, 150],
    backgroundColor: ['#4F46E5', '#22D3EE', '#F59E42', '#10B981'],
  }],
};
const leadsPerBranch = {
  labels: [
    'Head Office', 'City Centre', 'Mukono', 'Nateete', 'Nakawa', 'Kawempe', 'Kabwohe', 'Kyaliwajjala', 'Nansana', 'Abayita Ababiri', 'Gayaza', 'Kikuubo', 'Kabalagala', 'Nakulabye', 'Bukoto', 'Wandegeya', 'Katwe', 'Lugazi', 'Kayunga', 'Entebbe Road', 'Bweyogerere',
    'Mbarara', 'Masaka', 'Kasese', 'Ishaka', 'Kabale', 'Hoima', 'Fortportal', 'Bushenyi', 'Buwenge', 'Kisoro', 'Bweyale', 'Isingiro', 'Ibanda', 'Kagadi', 'Masindi', 'Rukungiri',
    'Jinja', 'Mbale', 'Iganga', 'Soroti', 'Bugiri', 'Kamuli', 'Namayingo',
    'Lira', 'Arua', 'Gulu Branch', 'Pader'
  ],
  datasets: [{
    label: 'Leads',
    data: [
      80, 65, 40, 55, 60, 45, 30, 35, 50, 25, 20, 15, 18, 22, 28, 32, 27, 19, 21, 23, 17,
      70, 60, 55, 50, 45, 40, 38, 36, 34, 32, 30, 28, 26, 24, 22, 20,
      60, 55, 50, 45, 40, 35, 30,
      50, 45, 40, 35
    ],
    backgroundColor: [
      // Central
      '#4F46E5','#4F46E5','#4F46E5','#4F46E5','#4F46E5','#4F46E5','#4F46E5','#4F46E5','#4F46E5','#4F46E5','#4F46E5','#4F46E5','#4F46E5','#4F46E5','#4F46E5','#4F46E5','#4F46E5','#4F46E5','#4F46E5','#4F46E5','#4F46E5',
      // Western
      '#22D3EE','#22D3EE','#22D3EE','#22D3EE','#22D3EE','#22D3EE','#22D3EE','#22D3EE','#22D3EE','#22D3EE','#22D3EE','#22D3EE','#22D3EE','#22D3EE','#22D3EE','#22D3EE',
      // Eastern
      '#F59E42','#F59E42','#F59E42','#F59E42','#F59E42','#F59E42','#F59E42',
      // Northern
      '#10B981','#10B981','#10B981','#10B981'
    ],
  }],
};
const leadsByStage = {
  labels: ['New', 'Contacted', 'Approved', 'Rejected'],
  datasets: [{
    label: 'Count',
    data: [50, 70, 40, 20],
    backgroundColor: ['#22D3EE', '#F59E42', '#4F46E5', '#EF4444'],
  }],
};
const topPerformers = [
  { name: 'Alice', branch: 'Head Office', region: 'Central', leads: 45 },
  { name: 'Bob', branch: 'Mbarara', region: 'Western', leads: 38 },
  { name: 'Carol', branch: 'Jinja', region: 'Eastern', leads: 32 },
  { name: 'David', branch: 'Lira', region: 'Northern', leads: 28 },
  { name: 'Eve', branch: 'City Centre', region: 'Central', leads: 27 },
  { name: 'Frank', branch: 'Masaka', region: 'Western', leads: 26 },
  { name: 'Grace', branch: 'Mbale', region: 'Eastern', leads: 25 },
  { name: 'Helen', branch: 'Arua', region: 'Northern', leads: 24 },
  { name: 'Isaac', branch: 'Mukono', region: 'Central', leads: 23 },
  { name: 'Jack', branch: 'Kasese', region: 'Western', leads: 22 },
];

const chartOptions = {
  responsive: true,
  plugins: {
    legend: { display: true },
    title: { display: false },
  },
};

// Placeholder methods for refresh buttons
function refreshTopPerformers() {
  // Placeholder: Add logic to fetch or update top performers
}
function refreshLeadsPerRegion() {
  // Placeholder: Add logic to fetch or update leads per region
}
function refreshLeadsPerBranch() {
  // Placeholder: Add logic to fetch or update leads per branch
}
function refreshLeadsByStage() {
  // Placeholder: Add logic to fetch or update leads by stage
}
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Dashboard
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Top Performers per Branch (moved to first card) -->
        <div class="bg-gradient-to-br from-indigo-50 to-white dark:from-gray-900 dark:to-gray-800 shadow-xl sm:rounded-lg p-6 col-span-1 md:col-span-2 mb-8">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-indigo-700">Top Performers per Branch</h3>
            <button type="button" class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white text-xs font-semibold rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" @click="refreshTopPerformers">
              Refresh
            </button>
          </div>
          <p class="mb-2 text-sm text-gray-600 dark:text-gray-300">This leaderboard highlights the top 10 performers across all branches and regions, ranked by the number of leads handled.</p>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-100">
                <tr>
                  <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Rank</th>
                  <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                  <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Branch</th>
                  <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Region</th>
                  <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Lead Count</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(performer, idx) in topPerformers" :key="idx" :class="idx === 0 ? 'bg-indigo-50 font-bold' : ''">
                  <td class="px-4 py-2 whitespace-nowrap">{{ idx + 1 }}</td>
                  <td class="px-4 py-2 whitespace-nowrap font-medium">{{ performer.name }}</td>
                  <td class="px-4 py-2 whitespace-nowrap">{{ performer.branch }}</td>
                  <td class="px-4 py-2 whitespace-nowrap">{{ performer.region }}</td>
                  <td class="px-4 py-2 whitespace-nowrap text-indigo-700 font-semibold">{{ performer.leads }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- Leads per Region -->
        <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Leads per Region</h3>
            <button type="button" class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white text-xs font-semibold rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" @click="refreshLeadsPerRegion">
              Refresh
            </button>
          </div>
          <Bar :data="leadsPerRegion" :options="chartOptions" />
        </div>
        <!-- Leads per Branch -->
        <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Leads per Branch</h3>
            <button type="button" class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white text-xs font-semibold rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" @click="refreshLeadsPerBranch">
              Refresh
            </button>
          </div>
          <Bar :data="leadsPerBranch" :options="chartOptions" />
        </div>
        <!-- Lead Counts by Stage -->
        <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Lead Counts by Stage</h3>
            <button type="button" class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white text-xs font-semibold rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" @click="refreshLeadsByStage">
              Refresh
            </button>
          </div>
          <Doughnut :data="leadsByStage" :options="chartOptions" />
        </div>
      </div>
    </div>
  </AppLayout>
</template>
