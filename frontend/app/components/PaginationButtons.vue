<template>
  <div v-if="lastPage > 1" class="mt-6 flex items-center justify-center gap-2">
    <button v-for="p in lastPage" :key="p" @click="$emit('update:modelValue', p)"
      :class="['rounded-lg px-3 py-1.5 text-[12px] font-bold transition-colors',
        modelValue === p ? 'bg-red-600/15 text-red-400' : 'text-white/25 hover:text-white/50']">
      {{ p }}
    </button>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  modelValue: number
  lastPage: number
}>()

defineEmits<{
  'update:modelValue': [value: number]
}>()
</script>
