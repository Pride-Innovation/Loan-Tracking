<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue';
import TableComponents from '@/Components/TableComponents.vue';

// Sample settings data
const settings = [
    { id: 1, key: 'Site Name', value: 'Loan Portal', status: 'Active' },
    { id: 2, key: 'Support Email', value: 'support@loan.com', status: 'Active' },
    { id: 3, key: 'Max Loan Amount', value: '$50,000', status: 'Active' },
    { id: 4, key: 'Min Credit Score', value: '650', status: 'Inactive' },
    { id: 5, key: 'Default Interest Rate', value: '7%', status: 'Active' },
];

const selectedSettings = ref([]);
const indeterminate = computed(() => selectedSettings.value.length > 0 && selectedSettings.value.length < settings.length);
const toggleSelectAll = (e) => {
    selectedSettings.value = e.target.checked ? settings.map(setting => setting.id) : [];
};
</script>

<template>
    <AppLayout title="Settings">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Settings Dashboard
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <!-- Select All Checkbox above table -->
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="group grid size-4 grid-cols-1">
                            <input 
                                type="checkbox" 
                                class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" 
                                :checked="indeterminate || selectedSettings.length === settings.length" 
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
                    <div v-if="selectedSettings.length > 0" class="bg-gray-50 p-3 mb-4 rounded-md flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-700">{{ selectedSettings.length }} {{ selectedSettings.length === 1 ? 'item' : 'items' }} selected</span>
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
                    <TableComponents>
                        <thead class="bg-[#08796c] text-white">
                            <tr>
                                <th class="border border-gray-300 py-3.5 px-4 text-sm font-semibold">
                                    <div class="group grid size-4 grid-cols-1">
                                        <input 
                                            type="checkbox" 
                                            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" 
                                            :checked="indeterminate || selectedSettings.length === settings.length" 
                                            :indeterminate="indeterminate"
                                            @change="toggleSelectAll" 
                                        />
                                        <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white" viewBox="0 0 14 14" fill="none">
                                            <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </th>
                                <th class="border border-gray-300 py-3.5 px-4 text-sm font-semibold">Key</th>
                                <th class="border border-gray-300 py-3.5 px-4 text-sm font-semibold">Value</th>
                                <th class="border border-gray-300 py-3.5 px-4 text-sm font-semibold">Status</th>
                                <th class="border border-gray-300 py-3.5 px-4 text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="[&>*:nth-child(odd)]:bg-gray-50">
                            <tr v-for="setting in settings" :key="setting.id" :class="[selectedSettings.includes(setting.id) && 'bg-gray-100']">
                                <td class="relative border border-gray-300 py-4 px-4">
                                    <div v-if="selectedSettings.includes(setting.id)" class="absolute inset-y-0 left-0 w-0.5 bg-indigo-600"></div>
                                    <div class="group grid size-4 grid-cols-1">
                                        <input 
                                            type="checkbox" 
                                            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" 
                                            :value="setting.id" 
                                            v-model="selectedSettings" 
                                        />
                                        <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white" viewBox="0 0 14 14" fill="none">
                                            <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </td>
                                <td class="border border-gray-300 py-4 px-4 text-sm font-normal" :class="selectedSettings.includes(setting.id) ? 'text-indigo-600 font-medium' : ''">
                                    {{ setting.key }}
                                </td>
                                <td class="border border-gray-300 py-4 px-4 text-sm font-normal">{{ setting.value }}</td>
                                <td class="border border-gray-300 py-4 px-4 text-sm font-normal">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ setting.status }}</span>
                                </td>
                                <td class="border border-gray-300 py-4 px-4 text-sm font-normal">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800">Edit</button>
                                        <button class="text-red-600 hover:text-red-800">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </TableComponents>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
