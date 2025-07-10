<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import TableComponents, { 
  TableHead, 
  TableHeader, 
  TableBody, 
  TableRow, 
  TableCell 
} from '@/Components/TableComponents.vue';
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
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="text-sm text-gray-700">Select All</span>
                        </div>
                        
                        <div class="flex space-x-2">
                            <button type="button" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
                    
                    <!-- Table -->
                    <TableComponents>
                        <thead class="bg-[#08796c] text-white">
                            <tr>
                                <th class="border border-gray-300 py-3.5 px-4 text-sm font-semibold">
                                    <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                </th>
                                <th class="border border-gray-300 py-3.5 px-4 text-sm font-semibold">Name</th>
                                <th class="border border-gray-300 py-3.5 px-4 text-sm font-semibold">Email</th>
                                <th class="border border-gray-300 py-3.5 px-4 text-sm font-semibold">Phone</th>
                                <th class="border border-gray-300 py-3.5 px-4 text-sm font-semibold">Status</th>
                                <th class="border border-gray-300 py-3.5 px-4 text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="[&>*:nth-child(odd)]:bg-gray-50">
                            <tr v-for="i in 5" :key="i" class="hover:bg-gray-100">
                                <td class="border border-gray-300 py-4 px-4">
                                    <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                </td>
                                <td class="border border-gray-300 py-4 px-4 text-sm font-normal">Lead Name {{ i }}</td>
                                <td class="border border-gray-300 py-4 px-4 text-sm font-normal">lead{{ i }}@example.com</td>
                                <td class="border border-gray-300 py-4 px-4 text-sm font-normal">555-123-{{ 1000 + i }}</td>
                                <td class="border border-gray-300 py-4 px-4 text-sm font-normal">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
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
