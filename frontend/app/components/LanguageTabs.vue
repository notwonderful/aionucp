<template>
  <div class="flex gap-2">
    <button v-for="loc in locales" :key="loc" type="button" @click="model = loc"
      :class="['rounded-lg px-3 py-1.5 text-[12px] font-bold uppercase tracking-wider transition-all',
        model === loc ? 'bg-red-600/15 text-red-400' : 'text-white/25 hover:text-white/50']">
      {{ loc }}
    </button>
  </div>
</template>

<script setup lang="ts">
const { availableLocales } = useI18n()
const locales = availableLocales

const model = defineModel<string>({ required: true })
</script>
