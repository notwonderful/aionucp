<template>
  <div :class="['flex gap-3 rounded-lg border px-5 py-4', styles[type]]">
    <div class="shrink-0 pt-0.5">
      <!-- Tip -->
      <svg v-if="type === 'tip'" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" /></svg>
      <!-- Warning -->
      <svg v-else-if="type === 'warning'" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
      <!-- Note -->
      <svg v-else class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
    </div>
    <div class="text-[13px] leading-relaxed"><slot /></div>
  </div>
</template>

<script setup lang="ts">
defineProps<{ type: 'tip' | 'warning' | 'note' }>()

const styles = {
  tip: 'border-emerald-500/15 bg-emerald-500/[0.04] text-emerald-300/70 [&_svg]:text-emerald-400/60',
  warning: 'border-amber-500/15 bg-amber-500/[0.04] text-amber-300/70 [&_svg]:text-amber-400/60',
  note: 'border-sky-500/15 bg-sky-500/[0.04] text-sky-300/70 [&_svg]:text-sky-400/60',
}
</script>
