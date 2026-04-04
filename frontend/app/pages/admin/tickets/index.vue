<template>
  <div>
    <div class="mb-8 flex items-end justify-between">
      <div>
        <h1 class="font-display text-2xl font-extrabold uppercase tracking-tight lg:text-3xl">Manage Tickets</h1>
        <p class="mt-1 text-[13px] text-white/25">All user support tickets</p>
      </div>
    </div>

    <div class="mb-5 flex gap-2">
      <button v-for="f in statusFilters" :key="f.value"
        @click="activeFilter = f.value"
        :class="['rounded-lg px-4 py-2 text-[13px] font-medium transition-all duration-300',
          activeFilter === f.value
            ? 'bg-red-600/15 text-red-400'
            : 'bg-white/[0.03] text-white/30 hover:bg-white/[0.05] hover:text-white/50']">
        {{ f.label }}
      </button>
    </div>

    <div v-if="status === 'pending'" class="space-y-2">
      <div v-for="i in 5" :key="i" class="h-20 animate-pulse rounded-xl bg-white/[0.02]" />
    </div>

    <div v-else-if="tickets.length" class="rounded-xl border border-white/[0.04] bg-white/[0.02] overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b border-white/[0.04]">
              <th class="px-5 py-3 text-left text-[11px] font-medium uppercase tracking-wider text-white/20">Status</th>
              <th class="px-5 py-3 text-left text-[11px] font-medium uppercase tracking-wider text-white/20">Subject</th>
              <th class="px-5 py-3 text-left text-[11px] font-medium uppercase tracking-wider text-white/20">User</th>
              <th class="px-5 py-3 text-left text-[11px] font-medium uppercase tracking-wider text-white/20">Category</th>
              <th class="px-5 py-3 text-right text-[11px] font-medium uppercase tracking-wider text-white/20">Messages</th>
              <th class="px-5 py-3 text-right text-[11px] font-medium uppercase tracking-wider text-white/20">Updated</th>
            </tr>
          </thead>
          <tbody>
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
          </tbody>
        </table>
      </div>
    </div>

    <EmptyState v-else title="No tickets found" subtitle="No tickets match the selected filter" />
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

interface TicketItem { id: string; subject: string; status: string; priority: string; user: { id: number; name: string; email: string } | null; category: { id: number; name: string } | null; messages_count: number; updated_at: string }

const { $api } = useApi()

const statusFilters = [
  { label: 'All', value: '' },
  { label: 'Open', value: 'open' },
  { label: 'Waiting', value: 'waiting' },
  { label: 'Closed', value: 'closed' },
]

const activeFilter = ref('')

const { data: ticketsData, status, refresh } = useAsyncData(
  'admin-tickets',
  () => $api<{ data: TicketItem[] }>(`/admin/tickets${activeFilter.value ? `?filter[status]=${activeFilter.value}` : ''}`),
  { watch: [activeFilter] },
)

const tickets = computed(() => ticketsData.value?.data ?? [])

function formatDate(date: string) {
  const d = new Date(date)
  const diff = Date.now() - d.getTime()
  if (diff < 3600000) return `${Math.floor(diff / 60000)}m ago`
  if (diff < 86400000) return `${Math.floor(diff / 3600000)}h ago`
  return d.toLocaleDateString('en', { month: 'short', day: 'numeric' })
}
</script>
