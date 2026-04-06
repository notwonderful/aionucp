<template>
  <button type="button" @click="$emit('update:modelValue', !modelValue)"
    :class="['relative h-6 w-11 rounded-full transition-colors duration-300',
      modelValue ? 'bg-emerald-500' : 'bg-white/10']">
    <span :class="['absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white transition-transform duration-300',
      modelValue && 'translate-x-5']" />
  </button>
</template>

<script setup lang="ts">
defineProps<{
  modelValue: boolean
}>()

defineEmits<{
  'update:modelValue': [value: boolean]
}>()
</script>
