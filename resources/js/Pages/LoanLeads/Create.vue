<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, computed } from 'vue';
import TableComponents, { 
  TableHead, 
  TableHeader, 
  TableBody, 
  TableRow, 
  TableCell 
} from '@/Components/TableComponents.vue';
import Modal from '@/Components/Modal.vue';

// Sample leads data
const leads = [
    { id: 1, name: 'Lead Name 1', email: 'lead1@example.com', phone: '555-123-1001', status: 'Active' },
    { id: 2, name: 'Lead Name 2', email: 'lead2@example.com', phone: '555-123-1002', status: 'Active' },
    { id: 3, name: 'Lead Name 3', email: 'lead3@example.com', phone: '555-123-1003', status: 'Active' },
    { id: 4, name: 'Lead Name 4', email: 'lead4@example.com', phone: '555-123-1004', status: 'Active' },
    { id: 5, name: 'Lead Name 5', email: 'lead5@example.com', phone: '555-123-1005', status: 'Active' },
];

// State management for selection
const selectedLeads = ref([]);
const indeterminate = computed(() => selectedLeads.value.length > 0 && selectedLeads.value.length < leads.length);

// Toggle select all
const toggleSelectAll = (e) => {
    selectedLeads.value = e.target.checked ? leads.map(lead => lead.id) : [];
};

// Modal states
const showAddModal = ref(false);
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const showBulkDeleteModal = ref(false);

// Current lead being edited/deleted
const currentLead = ref(null);

// Form data for add/edit
const formData = ref({
    name: '',
    email: '',
    phone: '',
    status: 'Active'
});

// Open add modal
const openAddModal = () => {
    formData.value = {
        name: '',
        email: '',
        phone: '',
        status: 'Active'
    };
    showAddModal.value = true;
};

// Open edit modal
const openEditModal = (lead) => {
    currentLead.value = lead;
    formData.value = { ...lead };
    showEditModal.value = true;
};

// Open delete modal
const openDeleteModal = (lead) => {
    currentLead.value = lead;
    showDeleteModal.value = true;
};

// Open bulk delete modal
const openBulkDeleteModal = () => {
    showBulkDeleteModal.value = true;
};

// Save new lead
const saveLead = () => {
    // Implementation would go here
    showAddModal.value = false;
};

// Update lead
const updateLead = () => {
    // Implementation would go here
    showEditModal.value = false;
};

// Delete lead
const deleteLead = () => {
    // Implementation would go here
    showDeleteModal.value = false;
};

// Bulk delete leads
const bulkDeleteLeads = () => {
    // Implementation would go here
    showBulkDeleteModal.value = false;
    selectedLeads.value = [];
};
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Leads Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <!-- Table Controls -->
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center space-x-2">
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
                        
                        <div class="flex space-x-2">
                            <button 
                                type="button" 
                                @click="openAddModal"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Add New Lead
                            </button>
                            <div class="flex space-x-2">
                                <button type="button" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Import
                                </button>
                                <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Export
                                </button>
                            </div>
                        </div>
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
                                @click="openBulkDeleteModal"
                                class="inline-flex items-center rounded-sm bg-white px-2 py-1 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50"
                            >
                                Delete all
                            </button>
                        </div>
                    </div>
                    
                    <!-- Table -->
                    <div class="relative">
                        <TableComponents>
                            <thead class="bg-[#08796c] text-white">
                                <tr>
                                    <th class="border border-gray-300 py-3.5 px-4 text-sm font-semibold">
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
                                    </th>
                                    <th class="border border-gray-300 py-3.5 px-4 text-sm font-semibold">Name</th>
                                    <th class="border border-gray-300 py-3.5 px-4 text-sm font-semibold">Email</th>
                                    <th class="border border-gray-300 py-3.5 px-4 text-sm font-semibold">Phone</th>
                                    <th class="border border-gray-300 py-3.5 px-4 text-sm font-semibold">Status</th>
                                    <th class="border border-gray-300 py-3.5 px-4 text-sm font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="[&>*:nth-child(odd)]:bg-gray-50">
                                <tr v-for="lead in leads" :key="lead.id" :class="[selectedLeads.includes(lead.id) && 'bg-gray-100']">
                                    <td class="relative border border-gray-300 py-4 px-4">
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
                                    </td>
                                    <td 
                                        class="border border-gray-300 py-4 px-4 text-sm font-normal"
                                        :class="selectedLeads.includes(lead.id) ? 'text-indigo-600 font-medium' : ''"
                                    >
                                        {{ lead.name }}
                                    </td>
                                    <td class="border border-gray-300 py-4 px-4 text-sm font-normal">{{ lead.email }}</td>
                                    <td class="border border-gray-300 py-4 px-4 text-sm font-normal">{{ lead.phone }}</td>
                                    <td class="border border-gray-300 py-4 px-4 text-sm font-normal">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ lead.status }}</span>
                                    </td>
                                    <td class="border border-gray-300 py-4 px-4 text-sm font-normal">
                                        <div class="flex space-x-2">
                                            <button 
                                                @click="openEditModal(lead)" 
                                                class="text-blue-600 hover:text-blue-800"
                                            >
                                                Edit
                                            </button>
                                            <button 
                                                @click="openDeleteModal(lead)" 
                                                class="text-red-600 hover:text-red-800"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </TableComponents>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Lead Modal -->
        <Modal :show="showAddModal" @close="showAddModal = false">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Add New Lead</h2>
                <div class="mt-6 space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input 
                            type="text" 
                            id="name" 
                            v-model="formData.name" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            v-model="formData.email" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                        <input 
                            type="text" 
                            id="phone" 
                            v-model="formData.phone" 
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
                            <option>Pending</option>
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
                        @click="saveLead" 
                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Save
                    </button>
                </div>
            </div>
        </Modal>

        <!-- Edit Lead Modal -->
        <Modal :show="showEditModal" @close="showEditModal = false">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Edit Lead</h2>
                <div class="mt-6 space-y-4">
                    <div>
                        <label for="edit-name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input 
                            type="text" 
                            id="edit-name" 
                            v-model="formData.name" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                    </div>
                    <div>
                        <label for="edit-email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input 
                            type="email" 
                            id="edit-email" 
                            v-model="formData.email" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                    </div>
                    <div>
                        <label for="edit-phone" class="block text-sm font-medium text-gray-700">Phone</label>
                        <input 
                            type="text" 
                            id="edit-phone" 
                            v-model="formData.phone" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                    </div>
                    <div>
                        <label for="edit-status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select 
                            id="edit-status" 
                            v-model="formData.status" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                            <option>Active</option>
                            <option>Inactive</option>
                            <option>Pending</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button 
                        type="button" 
                        @click="showEditModal = false" 
                        class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                    >
                        Cancel
                    </button>
                    <button 
                        type="button" 
                        @click="updateLead" 
                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Update
                    </button>
                </div>
            </div>
        </Modal>

        <!-- Delete Lead Modal -->
        <Modal :show="showDeleteModal" @close="showDeleteModal = false">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Delete Lead</h2>
                <p class="mt-2 text-sm text-gray-500">
                    Are you sure you want to delete this lead? This action cannot be undone.
                </p>
                <div class="mt-6 flex justify-end space-x-3">
                    <button 
                        type="button" 
                        @click="showDeleteModal = false" 
                        class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                    >
                        Cancel
                    </button>
                    <button 
                        type="button" 
                        @click="deleteLead" 
                        class="inline-flex justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </Modal>

        <!-- Bulk Delete Modal -->
        <Modal :show="showBulkDeleteModal" @close="showBulkDeleteModal = false">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Delete Selected Leads</h2>
                <p class="mt-2 text-sm text-gray-500">
                    Are you sure you want to delete {{ selectedLeads.length }} selected {{ selectedLeads.length === 1 ? 'lead' : 'leads' }}? This action cannot be undone.
                </p>
                <div class="mt-6 flex justify-end space-x-3">
                    <button 
                        type="button" 
                        @click="showBulkDeleteModal = false" 
                        class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                    >
                        Cancel
                    </button>
                    <button 
                        type="button" 
                        @click="bulkDeleteLeads" 
                        class="inline-flex justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                    >
                        Delete All
                    </button>
                </div>
            </div>
        </Modal>
    </AppLayout>
</template>
