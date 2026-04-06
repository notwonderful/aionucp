<template>
  <span :class="['rounded px-1.5 py-0.5 text-[10px] font-medium uppercase tracking-wider', colorClass]">
    <slot>{{ label }}</slot>
  </span>
</template>

<script setup lang="ts">
const props = withDefaults(defineProps<{
  color?: 'emerald' | 'amber' | 'red' | 'sky' | 'muted' | 'gold'
  label?: string
}>(), {
  color: 'muted',
  label: '',
})

const colorMap: Record<string, string> = {
  emerald: 'bg-emerald-500/10 text-emerald-400',
  amber: 'bg-amber-500/10 text-amber-400',
  red: 'bg-red-500/10 text-red-400',
  sky: 'bg-sky-500/10 text-sky-400',
  gold: 'bg-gold-500/10 text-gold-400',
  muted: 'bg-white/[0.04] text-white/25',
}

const colorClass = computed(() => colorMap[props.color] || colorMap.muted)
</script>
