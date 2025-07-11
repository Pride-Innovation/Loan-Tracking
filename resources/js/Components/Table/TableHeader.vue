<script setup>
defineProps({
  align: {
    type: String,
    default: 'left'
  },
  className: {
    type: String,
    default: ''
  }
});
</script>

<template>
  <th 
    scope="col" 
    :class="`sticky top-0 z-10 border border-gray-300 py-3.5 px-4 text-${align} text-sm font-semibold whitespace-normal ${className}`"
  >
    <slot></slot>
  </th>
</template>
