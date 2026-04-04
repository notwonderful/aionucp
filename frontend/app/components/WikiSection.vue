<template>
  <div>
    <h3 class="mb-4 font-display text-lg font-bold uppercase tracking-wider">{{ title }}</h3>
    <slot />
  </div>
</template>

<script setup lang="ts">
defineProps<{ title: string }>()
</script>
