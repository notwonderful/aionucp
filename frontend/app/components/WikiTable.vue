<template>
  <div class="overflow-hidden rounded-lg border border-white/[0.04]">
    <table class="w-full">
      <tbody>
        <tr v-for="(row, i) in rows" :key="i"
          :class="['transition-colors hover:bg-white/[0.015]', i > 0 && 'border-t border-white/[0.03]']">
          <td class="px-5 py-3.5 text-[13px] text-white/40">{{ row[0] }}</td>
          <td class="px-5 py-3.5 text-right text-[13px] font-semibold tabular-nums text-white/80">{{ row[1] }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup lang="ts">
defineProps<{ rows: string[][] }>()
</script>
