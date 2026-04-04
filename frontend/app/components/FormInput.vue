<template>
  <div>
    <label v-if="label" :for="id" class="mb-1.5 block text-[12px] font-medium text-white/40">{{ label }}</label>
    <input
      :id="id"
      :value="modelValue"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
      :type="type"
      :placeholder="placeholder"
      :required="required"
      :disabled="disabled"
      :autocomplete="autocomplete"
      class="form-input w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-3 text-[14px] text-white placeholder-white/15 outline-none transition-all duration-300 focus:border-red-500/30 focus:bg-white/[0.05] focus:ring-1 focus:ring-red-500/20 disabled:opacity-50"
    />
    <p v-if="error" class="mt-1.5 text-[12px] text-red-400">{{ error }}</p>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  modelValue?: string | number
  label?: string
  type?: string
  placeholder?: string
  required?: boolean
  disabled?: boolean
  autocomplete?: string
  error?: string
  id?: string
}>()

defineEmits<{ 'update:modelValue': [value: string] }>()
</script>
