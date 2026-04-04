<template>
  <div class="mb-5 flex gap-2 overflow-x-auto pb-1">
    <button
      v-for="tab in tabs" :key="tab.value"
      @click="$emit('update:modelValue', tab.value)"
      :class="['shrink-0 rounded-lg px-4 py-2 text-[13px] font-medium transition-all duration-300',
        modelValue === tab.value
          ? 'bg-red-600/15 text-red-400'
          : 'bg-white/[0.03] text-white/30 hover:bg-white/[0.05] hover:text-white/50']"
    >
      {{ tab.label }}
      <span v-if="tab.count !== undefined" class="ml-1.5 text-[11px] opacity-50">{{ tab.count }}</span>
    </button>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  modelValue: string
  tabs: { label: string; value: string; count?: number }[]
}>()

defineEmits<{ 'update:modelValue': [value: string] }>()
</script>
