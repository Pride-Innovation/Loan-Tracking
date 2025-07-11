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

// Sample leads data
const leads = [
    { id: 1, name: 'John Doe', email: 'john@example.com', phone: '555-123-1001', status: 'Active' },
    { id: 2, name: 'Jane Smith', email: 'jane@example.com', phone: '555-123-1002', status: 'Pending' },
    { id: 3, name: 'Bob Lee', email: 'bob@example.com', phone: '555-123-1003', status: 'Inactive' },
    { id: 4, name: 'Alice Brown', email: 'alice@example.com', phone: '555-123-1004', status: 'Active' },
    { id: 5, name: 'Charlie Green', email: 'charlie@example.com', phone: '555-123-1005', status: 'Active' },
];

const selectedLeads = ref([]);
const indeterminate = computed(() => selectedLeads.value.length > 0 && selectedLeads.value.length < leads.length);
const toggleSelectAll = (e) => {
    selectedLeads.value = e.target.checked ? leads.map(lead => lead.id) : [];
};
</script>

<template>
    <AppLayout title="Leads">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Leads Dashboard
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
                    <!-- Select All Checkbox above table -->
                    <div class="flex items-center space-x-2 mb-4">
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
                        <span class="text-sm text-gray-700">Select All</span>
                    </div>
                    <!-- Bulk Actions Bar -->
                    <div v-if="selectedLeads.length > 0" class="bg-gray-50 p-3 mb-4 rounded-md flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-700">{{ selectedLeads.length }} {{ selectedLeads.length === 1 ? 'item' : 'items' }} selected</span>
                        <div class="flex space-x-2">
                            <button 
                                type="button" 
                                class="inline-flex items-center rounded-sm bg-white px-2 py-1 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50"
                            >
                                Bulk edit
                            </button>
                            <button 
                                type="button" 
                                class="inline-flex items-center rounded-sm bg-white px-2 py-1 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50"
                            >
                                Delete all
                            </button>
                        </div>
                    </div>
                    <!-- Table -->
                    <TableComponents :data="leads">
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
                                <TableHeader>Actions</TableHeader>
                            </tr>
                        </TableHead>
                        <TableBody>
                            <template v-slot="{ data }">
                                <TableRow 
                                    v-for="lead in data || leads" 
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
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ lead.status }}</span>
                                    </TableCell>
                                    <TableCell>
                                        <div class="flex space-x-2">
                                            <button class="text-blue-600 hover:text-blue-800">Edit</button>
                                            <button class="text-red-600 hover:text-red-800">Delete</button>
                                        </div>
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
