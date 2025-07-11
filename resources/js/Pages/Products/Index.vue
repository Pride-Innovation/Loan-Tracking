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

// Sample products data
const products = [
    { id: 1, name: 'Home Loan', type: 'Mortgage', rate: '6.5%', status: 'Active' },
    { id: 2, name: 'Car Loan', type: 'Auto', rate: '7.2%', status: 'Active' },
    { id: 3, name: 'Personal Loan', type: 'Unsecured', rate: '12%', status: 'Inactive' },
    { id: 4, name: 'Business Loan', type: 'Commercial', rate: '9%', status: 'Active' },
    { id: 5, name: 'Education Loan', type: 'Student', rate: '5.8%', status: 'Pending' },
];

const selectedProducts = ref([]);
const indeterminate = computed(() => selectedProducts.value.length > 0 && selectedProducts.value.length < products.length);
const toggleSelectAll = (e) => {
    selectedProducts.value = e.target.checked ? products.map(product => product.id) : [];
};

// Modal state for Add Product
const showAddModal = ref(false);
const formData = ref({
    name: '',
    type: '',
    rate: '',
    status: 'Active'
});
const openAddModal = () => {
    formData.value = {
        name: '',
        type: '',
        rate: '',
        status: 'Active'
    };
    showAddModal.value = true;
};
const saveProduct = () => {
    // Implementation would go here
    showAddModal.value = false;
};
</script>

<template>
    <AppLayout title="Products">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Products Dashboard
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <!-- Only Add Button -->
                    <div class="flex justify-end mb-4">
                        <button 
                            type="button" 
                            @click="openAddModal"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Add New Product
                        </button>
                    </div>
                    <!-- Select All Checkbox above table -->
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="group grid size-4 grid-cols-1">
                            <input 
                                type="checkbox" 
                                class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" 
                                :checked="indeterminate || selectedProducts.length === products.length" 
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
                    <div v-if="selectedProducts.length > 0" class="bg-gray-50 p-3 mb-4 rounded-md flex items-center space-x-4">
                        <span class="text-sm font-medium text-gray-700">{{ selectedProducts.length }} {{ selectedProducts.length === 1 ? 'item' : 'items' }} selected</span>
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
                    <TableComponents :data="products">
                        <TableHead>
                            <tr>
                                <TableHeader>
                                    <div class="group grid size-4 grid-cols-1">
                                        <input 
                                            type="checkbox" 
                                            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" 
                                            :checked="indeterminate || selectedProducts.length === products.length" 
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
                                <TableHeader>Type</TableHeader>
                                <TableHeader>Rate</TableHeader>
                                <TableHeader>Status</TableHeader>
                                <TableHeader>Actions</TableHeader>
                            </tr>
                        </TableHead>
                        <TableBody>
                            <template v-slot="{ data }">
                                <TableRow 
                                    v-for="product in data || products" 
                                    :key="product.id" 
                                    :className="selectedProducts.includes(product.id) ? 'bg-gray-100' : ''"
                                >
                                    <TableCell class="relative">
                                        <div v-if="selectedProducts.includes(product.id)" class="absolute inset-y-0 left-0 w-0.5 bg-indigo-600"></div>
                                        <div class="group grid size-4 grid-cols-1">
                                            <input 
                                                type="checkbox" 
                                                class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" 
                                                :value="product.id" 
                                                v-model="selectedProducts" 
                                            />
                                            <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white" viewBox="0 0 14 14" fill="none">
                                                <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    </TableCell>
                                    <TableCell :className="selectedProducts.includes(product.id) ? 'text-indigo-600 font-medium' : ''">
                                        {{ product.name }}
                                    </TableCell>
                                    <TableCell>{{ product.type }}</TableCell>
                                    <TableCell>{{ product.rate }}</TableCell>
                                    <TableCell>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ product.status }}</span>
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
        <!-- Add Product Modal -->
        <Modal :show="showAddModal" @close="showAddModal = false">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Add New Product</h2>
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
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <input 
                            type="text" 
                            id="type" 
                            v-model="formData.type" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        >
                    </div>
                    <div>
                        <label for="rate" class="block text-sm font-medium text-gray-700">Rate</label>
                        <input 
                            type="text" 
                            id="rate" 
                            v-model="formData.rate" 
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
                        @click="saveProduct" 
                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Save
                    </button>
                </div>
            </div>
        </Modal>
    </AppLayout>
</template>
