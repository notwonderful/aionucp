<template>
  <NuxtLink :to="to" class="inline-flex items-center gap-2 text-[13px] font-medium text-white/25 transition-colors hover:text-white/50">
    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
    {{ label }}
  </NuxtLink>
</template>

<script setup lang="ts">
defineProps<{
  to: string
  label: string
}>()
</script>
