<script setup>
defineProps({
  className: {
    type: String,
    default: ''
  }
});
</script>

<template>
  <tbody :class="`[&>*:nth-child(odd)]:bg-gray-50 ${className}`">
    <slot></slot>
  </tbody>
</template>
