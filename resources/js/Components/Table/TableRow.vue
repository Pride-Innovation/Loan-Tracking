<script setup>
const props = defineProps({
  onClick: {
    type: Function,
    default: null
  },
  className: {
    type: String,
    default: ''
  }
});
</script>

<template>
  <tr 
    :class="`${onClick ? 'cursor-pointer hover:bg-gray-100' : ''} ${className}`"
    @click="onClick && onClick()"
  >
    <slot></slot>
  </tr>
</template>
