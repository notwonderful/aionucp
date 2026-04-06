<template>
  <div :class="['space-y-' + gap]">
    <div v-for="i in count" :key="i" :class="[height, 'animate-pulse rounded-xl bg-white/[0.02]']" />
  </div>
</template>

<script setup lang="ts">
withDefaults(defineProps<{
  count?: number
  height?: string
  gap?: string
}>(), {
  count: 5,
  height: 'h-14',
  gap: '2',
})
</script>
