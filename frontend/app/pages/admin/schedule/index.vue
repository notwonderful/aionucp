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

    <SkeletonLoader v-if="status === 'pending'" height="h-16" />

    <template v-else>
      <DataTable :columns="columns" :has-rows="!!items.length" :empty-text="$t('admin.noScheduleFound')">
        <NuxtLink v-for="item in items" :key="item.id" :to="`/admin/schedule/${item.id}`"
          class="table-row border-b border-white/[0.04] last:border-0 transition-colors hover:bg-white/[0.015]">
          <td class="px-5 py-3.5">
            <StatusBadge :color="item.published ? 'emerald' : 'muted'" :label="item.published ? $t('admin.published') : $t('admin.draft')" />
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

interface ScheduleItem {
  id: number
  category: string
  name: string
  metadata: Record<string, unknown>
  sort_order: number
  published: boolean
}

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

const { items, status } = useListData<ScheduleItem>({
  cacheKey: 'admin-schedule',
  endpoint: '/admin/schedule',
  filters: [
    { key: 'category', value: activeFilter },
  ],
  extraParams: { per_page: '50' },
})
</script>
