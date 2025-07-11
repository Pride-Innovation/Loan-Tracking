<script setup>
import { ref, computed, watch } from 'vue';
import TableControls from '@/Components/Table/TableControls.vue';
import TablePagination from '@/Components/Table/TablePagination.vue';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid';

const props = defineProps({
  data: {
    type: Array,
    default: () => []
  },
  rows: {
    type: Number,
    default: 5
  },
  columns: {
    type: Number,
    default: 5
  },
  headerEnabled: {
    type: Boolean,
    default: true
  },
  columnWidths: {
    type: Array,
    default: () => []
  },
  columnNames: {
    type: Array,
    default: () => []
  },
  searchable: {
    type: Boolean,
    default: true
  },
  paginate: {
    type: Boolean,
    default: true
  },
  perPageOptions: {
    type: Array,
    default: () => [10, 25, 50, 100]
  }
});

// Reactive state
const searchTerm = ref('');
const currentPage = ref(1);
const perPage = ref(props.perPageOptions[0]);

// Computed properties
const filteredData = computed(() => {
  if (!props.data || props.data.length === 0) return [];
  if (!searchTerm.value) return props.data;
  
  const searchLower = searchTerm.value.toLowerCase();
  return props.data.filter(item => {
    return Object.values(item).some(val => 
      val !== null && val.toString().toLowerCase().includes(searchLower)
    );
  });
});

const paginatedData = computed(() => {
  if (!props.paginate) return filteredData.value;
  
  const startIndex = (currentPage.value - 1) * perPage.value;
  return filteredData.value.slice(startIndex, startIndex + perPage.value);
});

const showingFrom = computed(() => {
  if (filteredData.value.length === 0) return 0;
  return (currentPage.value - 1) * perPage.value + 1;
});

const showingTo = computed(() => {
  return Math.min(currentPage.value * perPage.value, filteredData.value.length);
});

// Methods
function handleSearchChange(value) {
  searchTerm.value = value;
  currentPage.value = 1;
}

function handlePerPageChange(value) {
  perPage.value = value;
  currentPage.value = 1;
}

function handlePageChange(page) {
  currentPage.value = page;
}

// Expose paginated data to parent
defineExpose({ paginatedData });
</script>

<template>
  <div>
    <!-- Table Controls -->
    <TableControls 
      v-if="searchable || paginate"
      :per-page-options="perPageOptions"
      :searchable="searchable"
      @update:search-term="handleSearchChange"
      @update:per-page="handlePerPageChange"
    >
      <slot name="filters"></slot>
    </TableControls>
    
    <!-- Main Table Component -->
    <div class="overflow-x-auto md:overflow-x-visible">
      <table class="min-w-full border-separate border-spacing-0 rounded-lg border border-gray-300">
        <slot :data="paginatedData || props.data"></slot>
      </table>
    </div>
    
    <!-- Pagination -->
    <TablePagination 
      v-if="paginate && filteredData.length > 0"
      :current-page="currentPage"
      :total-items="filteredData.length"
      :per-page="perPage"
      :showing-from="showingFrom"
      :showing-to="showingTo"
      @page-change="handlePageChange"
    />
  </div>
</template>
