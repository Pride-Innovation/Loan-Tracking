<script setup>
import { computed } from 'vue';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid';

const props = defineProps({
  currentPage: {
    type: Number,
    required: true
  },
  totalItems: {
    type: Number,
    required: true
  },
  perPage: {
    type: Number,
    required: true
  },
  showingFrom: {
    type: Number,
    required: true
  },
  showingTo: {
    type: Number,
    required: true
  }
});

const emit = defineEmits(['pageChange']);

const totalPages = computed(() => Math.ceil(props.totalItems / props.perPage));

const pageNumbers = computed(() => {
  if (totalPages.value <= 7) {
    return Array.from({ length: totalPages.value }, (_, i) => i + 1);
  }
  
  const pages = [];
  if (props.currentPage <= 3) {
    pages.push(1, 2, 3, 4, '...', totalPages.value);
  } else if (props.currentPage >= totalPages.value - 2) {
    pages.push(1, '...', totalPages.value - 3, totalPages.value - 2, totalPages.value - 1, totalPages.value);
  } else {
    pages.push(1, '...', props.currentPage - 1, props.currentPage, props.currentPage + 1, '...', totalPages.value);
  }
  return pages;
});

function goToPage(page) {
  if (page !== '...' && page !== props.currentPage) {
    emit('pageChange', page);
  }
}

function nextPage() {
  if (props.currentPage < totalPages.value) {
    emit('pageChange', props.currentPage + 1);
  }
}

function prevPage() {
  if (props.currentPage > 1) {
    emit('pageChange', props.currentPage - 1);
  }
}
</script>

<template>
  <div class="mt-4 flex items-center justify-between gap-x-6 border-t border-gray-200 px-4 py-4 sm:px-0">
    <div class="text-sm text-gray-700">
      Showing <span class="font-medium">{{ showingFrom }}</span> to <span class="font-medium">{{ showingTo }}</span> of <span class="font-medium">{{ totalItems }}</span> results
    </div>
    <div class="flex items-center space-x-2">
      <button 
        type="button" 
        @click="prevPage" 
        :disabled="currentPage === 1"
        :class="['inline-flex items-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50', currentPage === 1 ? 'opacity-50 cursor-not-allowed' : '']"
      >
        <ChevronLeftIcon class="-ml-0.5 h-5 w-5" aria-hidden="true" />
        Previous
      </button>
      <div class="hidden sm:flex sm:items-center sm:space-x-1">
        <template v-for="(page, index) in pageNumbers" :key="index">
          <button 
            v-if="page !== '...'" 
            type="button" 
            @click="goToPage(page)"
            :class="['rounded-md px-3 py-2 text-sm font-semibold', page === currentPage ? 'bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0']"
          >
            {{ page }}
          </button>
          <span v-else class="px-2 py-2 text-gray-500">{{ page }}</span>
        </template>
      </div>
      <button 
        type="button" 
        @click="nextPage" 
        :disabled="currentPage === totalPages"
        :class="['inline-flex items-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50', currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : '']"
      >
        Next
        <ChevronRightIcon class="-mr-0.5 h-5 w-5" aria-hidden="true" />
      </button>
    </div>
  </div>
</template>
