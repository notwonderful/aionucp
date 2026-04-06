<template>
  <div>
    <PageHeader :title="$t('admin.manageTickets')" :subtitle="$t('admin.manageTicketsDesc')" />

    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <FilterTabs v-model="activeFilter" :tabs="statusFilters" />
      <SearchInput v-model="search" :placeholder="$t('admin.searchTickets')" class="sm:w-64" />
    </div>

    <SkeletonLoader v-if="status === 'pending'" height="h-20" />

    <template v-else>
      <DataTable :columns="columns" :has-rows="!!tickets.length" :empty-text="$t('admin.noTicketsFound')">
        <NuxtLink v-for="t in tickets" :key="t.id" :to="`/admin/tickets/${t.id}`"
          class="table-row border-b border-white/[0.04] last:border-0 transition-colors hover:bg-white/[0.015]">
          <td class="px-5 py-3.5">
            <StatusBadge :color="t.status === 'open' ? 'emerald' : t.status === 'waiting' ? 'amber' : 'muted'" :label="t.status" />
          </td>
          <td class="px-5 py-3.5 text-[13px] font-semibold text-white/70">{{ t.subject }}</td>
          <td class="px-5 py-3.5">
            <div class="text-[13px] text-white/50">{{ t.user?.name }}</div>
            <div class="text-[11px] text-white/20">{{ t.user?.email }}</div>
          </td>
          <td class="px-5 py-3.5 text-[12px] text-white/30">{{ t.category?.name }}</td>
          <td class="px-5 py-3.5 text-right text-[13px] tabular-nums text-white/30">{{ t.messages_count }}</td>
          <td class="px-5 py-3.5 text-right text-[12px] text-white/20">{{ formatDate(t.updated_at) }}</td>
        </NuxtLink>
      </DataTable>
    </template>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

interface TicketItem { id: string; subject: string; status: string; user: { id: number; name: string; email: string } | null; category: { id: number; name: string } | null; messages_count: number; updated_at: string }

const { t } = useI18n()
const { $api } = useApi()
const { relative: formatDate } = useDate()

const statusFilters = computed(() => [
  { label: t('history.all'), value: '' },
  { label: t('admin.open'), value: 'open' },
  { label: t('admin.waiting'), value: 'waiting' },
  { label: t('admin.closed'), value: 'closed' },
])

const columns = computed(() => [
  { key: 'status', label: t('admin.status') },
  { key: 'subject', label: t('admin.subject') },
  { key: 'user', label: t('admin.user') },
  { key: 'category', label: t('admin.category') },
  { key: 'messages_count', label: t('admin.messages'), align: 'right' as const },
  { key: 'updated_at', label: t('admin.updated'), align: 'right' as const, sortable: true },
])

const activeFilter = ref('')
const search = ref('')

const queryParams = computed(() => {
  const params = new URLSearchParams()
  if (activeFilter.value) params.set('filter[status]', activeFilter.value)
  if (search.value) params.set('filter[search]', search.value)
  return params.toString()
})

const { data: ticketsData, status } = useAsyncData(
  'admin-tickets',
  () => $api<{ data: TicketItem[] }>(`/admin/tickets${queryParams.value ? `?${queryParams.value}` : ''}`),
  { watch: [queryParams] },
)

const tickets = computed(() => ticketsData.value?.data ?? [])
</script>
