<template>
  <div>
    <PageHeader title="Manage Tickets" subtitle="All user support tickets" />

    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <FilterTabs v-model="activeFilter" :tabs="statusFilters" />
      <SearchInput v-model="search" placeholder="Search by subject or user..." class="sm:w-64" />
    </div>

    <div v-if="status === 'pending'" class="space-y-2">
      <div v-for="i in 5" :key="i" class="h-20 animate-pulse rounded-xl bg-white/[0.02]" />
    </div>

    <template v-else>
      <DataTable :columns="columns" :has-rows="!!tickets.length" empty-text="No tickets match the selected filter">
        <NuxtLink v-for="t in tickets" :key="t.id" :to="`/admin/tickets/${t.id}`"
          class="table-row border-b border-white/[0.04] last:border-0 transition-colors hover:bg-white/[0.015]">
          <td class="px-5 py-3.5">
            <span :class="['rounded px-1.5 py-0.5 text-[10px] font-medium uppercase tracking-wider',
              t.status === 'open' ? 'bg-emerald-500/10 text-emerald-400'
                : t.status === 'waiting' ? 'bg-amber-500/10 text-amber-400'
                : 'bg-white/[0.04] text-white/25']">
              {{ t.status }}
            </span>
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

const { $api } = useApi()
const { relative: formatDate } = useDate()

const statusFilters = [
  { label: 'All', value: '' },
  { label: 'Open', value: 'open' },
  { label: 'Waiting', value: 'waiting' },
  { label: 'Closed', value: 'closed' },
]

const columns = [
  { key: 'status', label: 'Status' },
  { key: 'subject', label: 'Subject' },
  { key: 'user', label: 'User' },
  { key: 'category', label: 'Category' },
  { key: 'messages_count', label: 'Messages', align: 'right' as const },
  { key: 'updated_at', label: 'Updated', align: 'right' as const, sortable: true },
]

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
