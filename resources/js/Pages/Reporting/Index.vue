<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue';
import TableComponents from '@/Components/TableComponents.vue';
import TableHead from '@/Components/Table/TableHead.vue';
import TableHeader from '@/Components/Table/TableHeader.vue';
import TableBody from '@/Components/Table/TableBody.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import TableCell from '@/Components/Table/TableCell.vue';
import Modal from '@/Components/Modal.vue';

// Sample leads data with more entries for pagination testing - keeping original data structure
const leads = [
    { id: 1, name: 'John Doe', email: 'john@example.com', phone: '555-123-1001', status: 'Active' },
    { id: 2, name: 'Jane Smith', email: 'jane@example.com', phone: '555-123-1002', status: 'Pending' },
    { id: 3, name: 'Bob Lee', email: 'bob@example.com', phone: '555-123-1003', status: 'Inactive' },
    { id: 4, name: 'Alice Brown', email: 'alice@example.com', phone: '555-123-1004', status: 'Active' },
    { id: 5, name: 'Charlie Green', email: 'charlie@example.com', phone: '555-123-1005', status: 'Active' },
    { id: 6, name: 'David Wilson', email: 'david@example.com', phone: '555-123-1006', status: 'Active' },
    { id: 7, name: 'Emily Davis', email: 'emily@example.com', phone: '555-123-1007', status: 'Pending' },
    { id: 8, name: 'Frank Johnson', email: 'frank@example.com', phone: '555-123-1008', status: 'Inactive' },
    { id: 9, name: 'Grace Taylor', email: 'grace@example.com', phone: '555-123-1009', status: 'Active' },
    { id: 10, name: 'Henry Clark', email: 'henry@example.com', phone: '555-123-1010', status: 'Active' },
    { id: 11, name: 'Isabella Moore', email: 'isabella@example.com', phone: '555-123-1011', status: 'Active' },
    { id: 12, name: 'Jack Lewis', email: 'jack@example.com', phone: '555-123-1012', status: 'Pending' },
    { id: 13, name: 'Katherine Hall', email: 'katherine@example.com', phone: '555-123-1013', status: 'Active' },
    { id: 14, name: 'Liam Allen', email: 'liam@example.com', phone: '555-123-1014', status: 'Inactive' },
    { id: 15, name: 'Mia Young', email: 'mia@example.com', phone: '555-123-1015', status: 'Active' },
    { id: 16, name: 'Noah Scott', email: 'noah@example.com', phone: '555-123-1016', status: 'Active' },
    { id: 17, name: 'Olivia King', email: 'olivia@example.com', phone: '555-123-1017', status: 'Pending' },
    { id: 18, name: 'Parker Wright', email: 'parker@example.com', phone: '555-123-1018', status: 'Inactive' },
];

// For demonstration purposes of filtering - in a real app these would come from your data
const regions = ['North', 'South', 'East', 'West'];
const branches = ['Main Office', 'Downtown', 'Suburb', 'Mall'];

const selectedLeads = ref([]);
const indeterminate = computed(() => selectedLeads.value.length > 0 && selectedLeads.value.length < leads.length);
const toggleSelectAll = (e) => {
    selectedLeads.value = e.target.checked ? leads.map(lead => lead.id) : [];
};

// Filter state
const statusFilter = ref('All');
const regionFilter = ref('All');
const branchFilter = ref('All');
const dateFilterType = ref('Last Month');
const dateRange = ref({
    start: '',
    end: ''
});

// Helper functions for date filtering
const getDateForFilter = (filterType) => {
    const today = new Date();
    const result = { start: null, end: today };
    
    switch (filterType) {
        case 'Last Week':
            const lastWeek = new Date(today);
            lastWeek.setDate(today.getDate() - 7);
            result.start = lastWeek;
            break;
        case 'Last Month':
            const lastMonth = new Date(today);
            lastMonth.setMonth(today.getMonth() - 1);
            result.start = lastMonth;
            break;
        case 'Last Year':
            const lastYear = new Date(today);
            lastYear.setFullYear(today.getFullYear() - 1);
            result.start = lastYear;
            break;
        case 'Custom':
            if (dateRange.value.start) {
                result.start = new Date(dateRange.value.start);
            }
            if (dateRange.value.end) {
                result.end = new Date(dateRange.value.end);
            }
            break;
    }
    
    return result;
};

// Computed property for filtered data
const filteredLeads = computed(() => {
    let result = [...leads];
    
    // Apply status filter
    if (statusFilter.value !== 'All') {
        result = result.filter(lead => lead.status === statusFilter.value);
    }
    
    // In a real app, we'd filter by region and branch if the data had these properties
    // Keeping these for demonstration purposes
    if (regionFilter.value !== 'All') {
        // result = result.filter(lead => lead.region === regionFilter.value);
    }
    
    if (branchFilter.value !== 'All') {
        // result = result.filter(lead => lead.branch === branchFilter.value);
    }
    
    // Date filters would go here if we had date data
    
    return result;
});

// Get status color based on status value
const getStatusColor = (status) => {
    switch (status) {
        case 'Active':
            return 'bg-green-100 text-green-800';
        case 'Pending':
            return 'bg-yellow-100 text-yellow-800';
        case 'Inactive':
            return 'bg-gray-100 text-gray-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};
</script>

<template>
    <AppLayout title="Leads">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Reports
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <!-- Only Export Button -->
                    <div class="flex justify-end mb-4">
                        <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Export
                        </button>
                    </div>
                    
                    <!-- Table with enhanced features -->
                    <TableComponents 
                        :data="filteredLeads"
                        :searchable="true"
                        :paginate="true"
                        :per-page-options="[5, 10, 25, 50]"
                    >
                        <!-- Additional filters -->
                        <template #filters>
                            <div class="flex flex-wrap items-center gap-4">
                                <div class="flex items-center space-x-2">
                                    <label for="status-filter" class="text-sm text-gray-700">Status:</label>
                                    <select 
                                        id="status-filter" 
                                        v-model="statusFilter"
                                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                    >
                                        <option>All</option>
                                        <option>Active</option>
                                        <option>Pending</option>
                                        <option>Inactive</option>
                                    </select>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <label for="region-filter" class="text-sm text-gray-700">Region:</label>
                                    <select 
                                        id="region-filter" 
                                        v-model="regionFilter"
                                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                    >
                                        <option>All</option>
                                        <option v-for="region in regions" :key="region">{{ region }}</option>
                                    </select>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <label for="branch-filter" class="text-sm text-gray-700">Branch:</label>
                                    <select 
                                        id="branch-filter" 
                                        v-model="branchFilter"
                                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                    >
                                        <option>All</option>
                                        <option v-for="branch in branches" :key="branch">{{ branch }}</option>
                                    </select>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <label for="date-filter-type" class="text-sm text-gray-700">Period:</label>
                                    <select 
                                        id="date-filter-type" 
                                        v-model="dateFilterType"
                                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                    >
                                        <option>Last Week</option>
                                        <option>Last Month</option>
                                        <option>Last Year</option>
                                        <option>Custom</option>
                                    </select>
                                </div>
                                
                                <template v-if="dateFilterType === 'Custom'">
                                    <div class="flex items-center space-x-2">
                                        <label for="date-from" class="text-sm text-gray-700">From:</label>
                                        <input 
                                            id="date-from" 
                                            v-model="dateRange.start"
                                            type="date" 
                                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                        />
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <label for="date-to" class="text-sm text-gray-700">To:</label>
                                        <input 
                                            id="date-to" 
                                            v-model="dateRange.end"
                                            type="date" 
                                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                        />
                                    </div>
                                </template>
                            </div>
                        </template>
                        
                        <TableHead>
                            <tr>
                                <TableHeader>
                                    <div class="group grid size-4 grid-cols-1">
                                        <input 
                                            type="checkbox" 
                                            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" 
                                            :checked="indeterminate || selectedLeads.length === leads.length" 
                                            :indeterminate="indeterminate"
                                            @change="toggleSelectAll" 
                                        />
                                        <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white" viewBox="0 0 14 14" fill="none">
                                            <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </TableHeader>
                                <TableHeader>Name</TableHeader>
                                <TableHeader>Email</TableHeader>
                                <TableHeader>Phone</TableHeader>
                                <TableHeader>Status</TableHeader>
                            </tr>
                        </TableHead>
                        <TableBody>
                            <template v-slot="{ data }">
                                <TableRow 
                                    v-for="lead in data || filteredLeads" 
                                    :key="lead.id" 
                                    :className="selectedLeads.includes(lead.id) ? 'bg-gray-100' : ''"
                                >
                                    <TableCell class="relative">
                                        <div v-if="selectedLeads.includes(lead.id)" class="absolute inset-y-0 left-0 w-0.5 bg-indigo-600"></div>
                                        <div class="group grid size-4 grid-cols-1">
                                            <input 
                                                type="checkbox" 
                                                class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" 
                                                :value="lead.id" 
                                                v-model="selectedLeads" 
                                            />
                                            <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white" viewBox="0 0 14 14" fill="none">
                                                <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    </TableCell>
                                    <TableCell :className="selectedLeads.includes(lead.id) ? 'text-indigo-600 font-medium' : ''">
                                        {{ lead.name }}
                                    </TableCell>
                                    <TableCell>{{ lead.email }}</TableCell>
                                    <TableCell>{{ lead.phone }}</TableCell>
                                    <TableCell>
                                        <span :class="`px-2 py-1 text-xs font-semibold rounded-full ${getStatusColor(lead.status)}`">
                                            {{ lead.status }}
                                        </span>
                                    </TableCell>
                                </TableRow>
                            </template>
                        </TableBody>
                    </TableComponents>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
