<script setup>
import { ref, watch } from 'vue';
import { MagnifyingGlassIcon } from '@heroicons/vue/20/solid';

const props = defineProps({
  perPageOptions: {
    type: Array,
    default: () => [10, 25, 50, 100]
  },
  searchable: {
    type: Boolean,
    default: true
  }
});

const emit = defineEmits(['update:searchTerm', 'update:perPage']);

const searchTerm = ref('');
const perPage = ref(props.perPageOptions[0]);

watch(searchTerm, (value) => {
  emit('update:searchTerm', value);
});

watch(perPage, (value) => {
  emit('update:perPage', value);
});
</script>

<template>
  <div class="mb-4 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
    <div class="flex-grow max-w-md" v-if="searchable">
      <div class="relative">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
          <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
        </div>
        <input
          type="text"
          v-model="searchTerm"
          class="block w-full rounded-md border-0 py-1.5 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
          placeholder="Search..."
        />
      </div>
    </div>
    
    <slot></slot>
    
    <div class="flex items-center space-x-2" v-if="props.perPageOptions.length > 0">
      <label for="perPage" class="text-sm text-gray-700">Show:</label>
      <select
        id="perPage"
        v-model="perPage"
        class="h-9 rounded-md border-gray-300 py-0 pl-2 pr-8 text-gray-900 focus:ring-indigo-600 sm:text-sm"
      >
        <option v-for="option in props.perPageOptions" :key="option" :value="option">
          {{ option }}
        </option>
      </select>
    </div>
  </div>
</template>
