<template>
  <div class="relative">
    <svg class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
    <input
      :value="modelValue"
      @input="onInput"
      type="text"
      :placeholder="placeholder"
      class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] py-2.5 pl-10 pr-4 text-[13px] text-white placeholder-white/15 outline-none transition-all duration-300 focus:border-red-500/30 focus:bg-white/[0.05] focus:ring-1 focus:ring-red-500/20"
    />
  </div>
</template>

<script setup lang="ts">
const props = withDefaults(defineProps<{
  modelValue: string
  placeholder?: string
  debounce?: number
}>(), {
  placeholder: 'Search...',
  debounce: 300,
})

const emit = defineEmits<{ 'update:modelValue': [value: string] }>()

let timer: ReturnType<typeof setTimeout>

function onInput(e: Event) {
  const value = (e.target as HTMLInputElement).value
  clearTimeout(timer)
  timer = setTimeout(() => emit('update:modelValue', value), props.debounce)
}
</script>
