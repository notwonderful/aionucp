<template>
  <Transition name="alert">
    <div v-if="message" :class="['flex items-center gap-2 rounded-lg px-4 py-3 text-[13px]', variantClasses[variant]]">
      <svg v-if="variant === 'success'" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
      <svg v-else class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
      {{ message }}
    </div>
  </Transition>
</template>

<script setup lang="ts">
defineProps<{
  message: string
  variant?: 'success' | 'error'
}>()

const variantClasses: Record<string, string> = {
  success: 'bg-emerald-500/10 text-emerald-400',
  error: 'bg-red-500/10 text-red-400',
}
</script>

<style scoped>
.alert-enter-active, .alert-leave-active { transition: opacity 0.3s ease, transform 0.3s ease; }
.alert-enter-from, .alert-leave-to { opacity: 0; transform: translateY(-4px); }
</style>
