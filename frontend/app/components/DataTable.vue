<template>
  <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="border-b border-white/[0.04]">
            <th
              v-for="col in columns" :key="col.key"
              :class="['px-5 py-3 text-[11px] font-medium uppercase tracking-wider text-white/20',
                col.align === 'right' ? 'text-right' : 'text-left',
                col.sortable ? 'cursor-pointer select-none hover:text-white/40 transition-colors' : '']"
              @click="col.sortable && toggleSort(col.key)"
            >
              <span class="inline-flex items-center gap-1">
                {{ col.label }}
                <template v-if="col.sortable && sortKey === col.key">
                  <svg v-if="sortDir === 'asc'" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" /></svg>
                  <svg v-else class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                </template>
              </span>
            </th>
          </tr>
        </thead>
        <tbody>
          <slot />
        </tbody>
      </table>
    </div>
    <div v-if="!hasRows" class="px-4 py-12 text-center text-[13px] text-white/20">{{ emptyText }}</div>
  </div>
</template>

<script setup lang="ts">
const props = withDefaults(defineProps<{
  columns: { key: string; label: string; align?: 'left' | 'right'; sortable?: boolean }[]
  hasRows?: boolean
  emptyText?: string
}>(), {
  hasRows: true,
  emptyText: 'No data found',
})

const sortKey = defineModel<string>('sortKey')
const sortDir = defineModel<'asc' | 'desc'>('sortDir')

const emit = defineEmits<{ sort: [key: string, dir: 'asc' | 'desc'] }>()

function toggleSort(key: string) {
  if (sortKey.value === key) {
    sortDir.value = sortDir.value === 'asc' ? 'desc' : 'asc'
  } else {
    sortKey.value = key
    sortDir.value = 'desc'
  }
  emit('sort', sortKey.value!, sortDir.value!)
}
</script>
