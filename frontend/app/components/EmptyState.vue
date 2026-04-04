<template>
  <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] py-16 text-center">
    <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/[0.03]">
      <slot name="icon">
        <svg class="h-5 w-5 text-white/15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6 4.125l2.25 2.25m0 0l2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
      </slot>
    </div>
    <p class="text-[14px] font-medium text-white/30">{{ title }}</p>
    <p v-if="subtitle" class="mt-1 text-[12px] text-white/15">{{ subtitle }}</p>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  title: string
  subtitle?: string
}>()
</script>
