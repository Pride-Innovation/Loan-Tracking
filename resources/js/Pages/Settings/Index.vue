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

// Sample settings data with more entries for pagination testing
const settings = [
    { id: 1, key: 'Site Name', value: 'Loan Portal', status: 'Active' },
    { id: 2, key: 'Support Email', value: 'support@loan.com', status: 'Active' },
    { id: 3, key: 'Max Loan Amount', value: '$50,000', status: 'Active' },
    { id: 4, key: 'Min Credit Score', value: '650', status: 'Inactive' },
    { id: 5, key: 'Default Interest Rate', value: '7%', status: 'Active' },
    { id: 6, key: 'Application Fee', value: '$100', status: 'Active' },
    { id: 7, key: 'Late Payment Fee', value: '$25', status: 'Active' },
    { id: 8, key: 'Payment Grace Period', value: '5 days', status: 'Active' },
    { id: 9, key: 'Default Loan Term', value: '36 months', status: 'Active' },
    { id: 10, key: 'Admin Email', value: 'admin@loan.com', status: 'Inactive' },
    { id: 11, key: 'Company Address', value: '123 Finance St', status: 'Active' },
    { id: 12, key: 'Technical Support Phone', value: '555-987-6543', status: 'Active' },
    { id: 13, key: 'Office Hours', value: '9am-5pm Mon-Fri', status: 'Active' },
    { id: 14, key: 'Emergency Contact', value: '555-911-0000', status: 'Active' },
    { id: 15, key: 'Tax ID', value: '12-3456789', status: 'Inactive' },
];

const selectedSettings = ref([]);
const indeterminate = computed(() => selectedSettings.value.length > 0 && selectedSettings.value.length < settings.length);
const toggleSelectAll = (e) => {
    selectedSettings.value = e.target.checked ? settings.map(setting => setting.id) : [];
};

// Modal state for Add Setting
const showAddModal = ref(false);
const formData = ref({
    key: '',
    value: '',
    status: 'Active'
});

const openAddModal = () => {
    formData.value = {
        key: '',
        value: '',
        status: 'Active'
    };
    showAddModal.value = true;
};

const saveSetting = () => {
    // Implementation would go here
    showAddModal.value = false;
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
                    <!-- Add Button -->
                    <div class="flex justify-end mb-4">
                        <button 
                            type="button" 
                            @click="openAddModal"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Add New Setting
                        </button>
                    </div>
                    
                    <!-- Select All Checkbox -->
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
                    
                    <!-- Table with enhanced features -->
                    <TableComponents 
                        :data="settings"
                        :searchable="true"
                        :paginate="true"
                        :per-page-options="[5, 10, 25, 50]"
                    >
                        <TableHead>
                            <tr>
                                <TableHeader>
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
                                </TableHeader>
                                <TableHeader>Key</TableHeader>
                                <TableHeader>Value</TableHeader>
                                <TableHeader>Status</TableHeader>
                                <TableHeader>Actions</TableHeader>
                            </tr>
                        </TableHead>
                        
                        <TableBody>
                            <template v-slot="{ data }">
                                <TableRow 
                                    v-for="setting in data || settings" 
                                    :key="setting.id" 
                                    :className="selectedSettings.includes(setting.id) ? 'bg-gray-100' : ''"
                                >
                                    <TableCell class="relative">
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
                                    </TableCell>
                                    <TableCell :className="selectedSettings.includes(setting.id) ? 'text-indigo-600 font-medium' : ''">
                                        {{ setting.key }}
                                    </TableCell>
                                    <TableCell>{{ setting.value }}</TableCell>
                                    <TableCell>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ setting.status }}</span>
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
        
        <!-- Add Setting Modal -->
        <Modal :show="showAddModal" @close="showAddModal = false">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Add New Setting</h2>
                <div class="mt-6 space-y-4">
                    <div>
                        <label for="key" class="block text-sm font-medium text-gray-700">Key</label>
                        <input 
                            type="text" 
                            id="key" 
                            v-model="formData.key" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                    </div>
                    <div>
                        <label for="value" class="block text-sm font-medium text-gray-700">Value</label>
                        <input 
                            type="text" 
                            id="value" 
                            v-model="formData.value" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select 
                            id="status" 
                            v-model="formData.status" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button 
                        type="button" 
                        @click="showAddModal = false" 
                        class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                    >
                        Cancel
                    </button>
                    <button 
                        type="button" 
                        @click="saveSetting" 
                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Save
                    </button>
                </div>
            </div>
        </Modal>
    </AppLayout>
</template>
