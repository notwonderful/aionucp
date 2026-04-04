<template>
  <div class="overflow-hidden rounded-lg border border-white/[0.04]">
    <button
      class="flex w-full items-center justify-between gap-4 bg-white/[0.02] px-5 py-4 text-left transition-colors hover:bg-white/[0.04]"
      @click="open = !open">
      <span class="text-[13px] font-semibold">{{ title }}</span>
      <svg :class="['h-4 w-4 shrink-0 text-white/20 transition-transform duration-300', open && 'rotate-180']"
        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
      </svg>
    </button>
    <div :class="['transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)]',
      open ? 'max-h-[2000px] opacity-100' : 'max-h-0 opacity-0']">
      <div class="border-t border-white/[0.04] px-5 py-4">
        <slot />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{ title: string }>()
const open = ref(false)
</script>
