<template>
  <button :type="type" :disabled="disabled || loading" :class="classes">
    <span v-if="loading" class="inline-flex items-center gap-2">
      <svg class="h-3.5 w-3.5 animate-spin" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" /></svg>
      <slot name="loading">{{ loadingText }}</slot>
    </span>
    <slot v-else />
  </button>
</template>

<script setup lang="ts">
const props = withDefaults(defineProps<{
  variant?: 'primary' | 'secondary'
  type?: 'button' | 'submit'
  loading?: boolean
  loadingText?: string
  disabled?: boolean
  block?: boolean
}>(), {
  variant: 'primary',
  type: 'button',
  loadingText: 'Loading...',
})

const classes = computed(() => [
  'rounded-lg font-display text-[12px] font-bold uppercase tracking-widest transition-all duration-300 active:scale-[0.98] disabled:opacity-40 disabled:pointer-events-none',
  props.block ? 'w-full py-3.5' : 'px-6 py-2.5',
  props.variant === 'primary'
    ? 'app-btn-primary'
    : 'border border-white/[0.06] bg-white/[0.03] text-white/40 hover:bg-white/[0.06] hover:text-white/60',
])
</script>

<style scoped>
.app-btn-primary { background: var(--color-primary); color: white; }
.app-btn-primary:hover { background: var(--color-primary-hover); box-shadow: 0 0 30px rgba(220, 60, 60, 0.2); }
</style>
