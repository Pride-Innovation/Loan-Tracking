<script setup>
defineProps({
  align: {
    type: String,
    default: 'left'
  },
  className: {
    type: String,
    default: ''
  },
  as: {
    type: String,
    default: 'td'
  }
});
</script>

<template>
  <component 
    :is="as" 
    :class="`border border-gray-300 py-4 px-4 text-sm font-normal whitespace-normal text-${align} ${className}`"
  >
    <slot></slot>
  </component>
</template>
