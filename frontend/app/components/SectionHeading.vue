<template>
  <div class="text-center">
    <h2 class="font-cinzel text-2xl font-bold tracking-[0.1em] text-white sm:text-3xl">
      {{ title }}
    </h2>
    <div class="mx-auto mt-4 flex max-w-[200px] items-center gap-3">
      <div class="h-px flex-1 bg-gradient-to-r from-transparent to-gold-400/40" />
      <svg class="h-2 w-2 shrink-0 text-gold-400/60" viewBox="0 0 8 8">
        <rect x="1.17" y="1.17" width="5.66" height="5.66" transform="rotate(45 4 4)" fill="currentColor" />
      </svg>
      <div class="h-px flex-1 bg-gradient-to-l from-transparent to-gold-400/40" />
    </div>
    <p v-if="subtitle" class="mt-3 font-philosopher text-sm text-gray-500">{{ subtitle }}</p>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  title: string
  subtitle?: string
}>()
</script>
