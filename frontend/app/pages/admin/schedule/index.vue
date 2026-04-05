<template>
  <div>
    <PageHeader :title="$t('admin.manageSchedule')" :subtitle="$t('admin.manageScheduleDesc')">
      <template #actions>
        <NuxtLink to="/admin/schedule/create"
          class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-[13px] font-semibold text-white transition-colors hover:bg-red-500">
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
          {{ $t('admin.createEntry') }}
        </NuxtLink>
      </template>
    </PageHeader>

    <div class="mb-5">
      <FilterTabs v-model="activeFilter" :tabs="categoryFilters" />
    </div>

    <div v-if="status === 'pending'" class="space-y-2">
      <div v-for="i in 5" :key="i" class="h-16 animate-pulse rounded-xl bg-white/[0.02]" />
    </div>

    <template v-else>
      <DataTable :columns="columns" :has-rows="!!entries.length" :empty-text="$t('admin.noScheduleFound')">
        <NuxtLink v-for="item in entries" :key="item.id" :to="`/admin/schedule/${item.id}`"
          class="table-row border-b border-white/[0.04] last:border-0 transition-colors hover:bg-white/[0.015]">
          <td class="px-5 py-3.5">
            <span :class="['rounded px-1.5 py-0.5 text-[10px] font-medium uppercase tracking-wider',
              item.published ? 'bg-emerald-500/10 text-emerald-400' : 'bg-white/[0.04] text-white/25']">
              {{ item.published ? $t('admin.published') : $t('admin.draft') }}
            </span>
          </td>
          <td class="px-5 py-3.5">
            <span :class="['rounded bg-white/[0.04] px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest',
              item.category === 'siege' ? 'text-red-400/70' :
              item.category === 'dredgion' ? 'text-amber-400/70' : 'text-sky-400/70']">
              {{ item.category }}
            </span>
          </td>
          <td class="px-5 py-3.5 text-[13px] font-semibold text-white/70">{{ item.name }}</td>
          <td class="px-5 py-3.5 text-right text-[12px] tabular-nums text-white/20">{{ item.sort_order }}</td>
        </NuxtLink>
      </DataTable>
    </template>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const { t } = useI18n()
const { $api } = useApi()

const categoryFilters = computed(() => [
  { label: t('history.all'), value: '' },
  { label: t('schedule.sieges'), value: 'siege' },
  { label: t('schedule.dredgion'), value: 'dredgion' },
  { label: t('schedule.rifts'), value: 'rift' },
])

const columns = computed(() => [
  { key: 'status', label: t('admin.status') },
  { key: 'category', label: t('admin.categoryLabel') },
  { key: 'name', label: t('admin.entryName') },
  { key: 'sort_order', label: t('admin.sortOrder'), align: 'right' as const },
])

const activeFilter = ref('')

const queryParams = computed(() => {
  const params = new URLSearchParams()
  if (activeFilter.value) params.set('filter[category]', activeFilter.value)
  params.set('per_page', '50')
  return params.toString()
})

interface ScheduleItem {
  id: number
  category: string
  name: string
  metadata: Record<string, unknown>
  sort_order: number
  published: boolean
}

const { data: scheduleData, status } = useAsyncData(
  'admin-schedule',
  () => $api<{ data: ScheduleItem[] }>(`/admin/schedule?${queryParams.value}`),
  { watch: [queryParams] },
)

const entries = computed(() => scheduleData.value?.data ?? [])
</script>
