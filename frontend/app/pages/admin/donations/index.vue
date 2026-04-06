<template>
  <div>
    <PageHeader :title="$t('admin.donations')" :subtitle="$t('admin.donationsDesc')" />

    <div v-if="statsStatus === 'pending'" class="mb-8 grid gap-4 sm:grid-cols-3">
      <div v-for="i in 3" :key="i" class="h-24 animate-pulse rounded-xl bg-white/[0.02]" />
    </div>

    <div v-else class="mb-8 grid gap-4 sm:grid-cols-3">
      <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-5">
        <div class="text-[12px] font-medium uppercase tracking-widest text-white/25">{{ $t('admin.totalRevenue') }}</div>
        <div class="mt-2 font-display text-2xl font-extrabold tabular-nums text-emerald-400">${{ stats.total_revenue.toLocaleString('en-US', { minimumFractionDigits: 2 }) }}</div>
      </div>
      <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-5">
        <div class="text-[12px] font-medium uppercase tracking-widest text-white/25">{{ $t('admin.totalToll') }}</div>
        <div class="mt-2 font-display text-2xl font-extrabold tabular-nums text-red-400">{{ stats.total_toll.toLocaleString() }}</div>
      </div>
      <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-5">
        <div class="text-[12px] font-medium uppercase tracking-widest text-white/25">{{ $t('admin.totalDonations') }}</div>
        <div class="mt-2 font-display text-2xl font-extrabold tabular-nums text-sky-400">{{ stats.total_count }}</div>
      </div>
    </div>

    <div class="mb-8 grid gap-4 lg:grid-cols-3">
      <div class="lg:col-span-2 rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
        <h3 class="mb-2 font-display text-[13px] font-bold uppercase tracking-widest text-white/30">{{ $t('admin.revenueChart') }}</h3>
        <ClientOnly>
          <apexchart type="area" height="280" :options="revenueChartOpts" :series="revenueChartSeries" />
        </ClientOnly>
      </div>

      <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
        <h3 class="mb-2 font-display text-[13px] font-bold uppercase tracking-widest text-white/30">{{ $t('admin.gateway') }}</h3>
        <ClientOnly>
          <apexchart type="donut" height="280" :options="gatewayChartOpts" :series="gatewayChartSeries" />
        </ClientOnly>
      </div>
    </div>

    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <FilterTabs v-model="statusFilter" :tabs="statusTabs" />
      <SearchInput v-model="search" :placeholder="$t('admin.searchUsers')" class="sm:w-64" />
    </div>

    <SkeletonLoader v-if="listStatus === 'pending'" />

    <template v-else>
      <DataTable :columns="columns" :has-rows="!!donations.length" :empty-text="$t('admin.noDonations')">
        <tr v-for="d in donations" :key="d.id" class="border-b border-white/[0.04] last:border-0">
          <td class="px-5 py-3">
            <div class="text-[13px] font-medium text-white/70">{{ d.user?.name || '—' }}</div>
            <div class="text-[11px] text-white/20">{{ d.user?.email || '' }}</div>
          </td>
          <td class="px-5 py-3 text-[13px] tabular-nums font-semibold text-emerald-400">${{ d.amount_money.toFixed(2) }}</td>
          <td class="px-5 py-3 text-[13px] tabular-nums text-red-400">{{ d.amount_toll.toLocaleString() }}</td>
          <td class="px-5 py-3 text-[13px] text-white/40">{{ d.gateway }}</td>
          <td class="px-5 py-3">
            <StatusBadge
              :color="d.status === 'completed' ? 'emerald' : d.status === 'pending' ? 'amber' : d.status === 'refunded' ? 'sky' : 'red'"
              :label="statusLabel(d.status)" />
          </td>
          <td class="px-5 py-3 text-right text-[12px] text-white/20">{{ formatDate(d.completed_at || d.created_at) }}</td>
        </tr>
      </DataTable>

      <PaginationButtons v-model="page" :last-page="listMeta.last_page" />
    </template>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

interface DonationItem { id: number; user: { id: number; name: string; email: string } | null; gateway: string; status: string; amount_toll: number; amount_money: number; currency: string; completed_at: string | null; created_at: string }
interface StatsData { total_revenue: number; total_toll: number; total_count: number; daily: { date: string; revenue: number; toll: number; count: number }[]; by_gateway: { gateway: string; revenue: number; count: number }[] }

const { t } = useI18n()
const { $api } = useApi()
const { datetime: formatDate } = useDate()

const statusFilter = ref('')
const search = ref('')
const page = ref(1)

const statusTabs = computed(() => [
  { label: t('admin.allStatuses'), value: '' },
  { label: t('admin.completed'), value: 'completed' },
  { label: t('admin.pending'), value: 'pending' },
  { label: t('admin.failed'), value: 'failed' },
  { label: t('admin.refunded'), value: 'refunded' },
])

const columns = computed(() => [
  { key: 'user', label: t('admin.user') },
  { key: 'amount', label: t('admin.amount') },
  { key: 'toll', label: t('admin.toll') },
  { key: 'gateway', label: t('admin.gateway') },
  { key: 'status', label: t('admin.status') },
  { key: 'date', label: t('admin.date'), align: 'right' as const },
])

function statusLabel(status: string) {
  const map: Record<string, string> = {
    completed: t('admin.completed'),
    pending: t('admin.pending'),
    failed: t('admin.failed'),
    refunded: t('admin.refunded'),
  }
  return map[status] || status
}

const listQuery = computed(() => {
  const params = new URLSearchParams()
  params.set('page', String(page.value))
  if (statusFilter.value) params.set('filter[status]', statusFilter.value)
  if (search.value) params.set('filter[user_id]', search.value)
  return params.toString()
})

const { data: statsData, status: statsStatus } = useAsyncData(
  'admin-donation-stats',
  () => $api<StatsData>('/admin/donations/stats'),
)

const { data: listData, status: listStatus } = useAsyncData(
  'admin-donations',
  () => $api<{ data: DonationItem[]; meta: any }>(`/admin/donations?${listQuery.value}`),
  { watch: [listQuery] },
)

const stats = computed<StatsData>(() => statsData.value ?? { total_revenue: 0, total_toll: 0, total_count: 0, daily: [], by_gateway: [] })
const donations = computed(() => listData.value?.data ?? [])
const listMeta = computed(() => listData.value?.meta ?? { last_page: 1 })

const chartTheme = {
  chart: { background: 'transparent', toolbar: { show: false }, zoom: { enabled: false } },
  theme: { mode: 'dark' as const },
  grid: { borderColor: 'rgba(255,255,255,0.04)', strokeDashArray: 3 },
  tooltip: { theme: 'dark', style: { fontSize: '12px' } },
  xaxis: { labels: { style: { colors: 'rgba(255,255,255,0.25)', fontSize: '11px' } } },
  yaxis: { labels: { style: { colors: 'rgba(255,255,255,0.25)', fontSize: '11px' } } },
}

const revenueChartOpts = computed(() => ({
  ...chartTheme,
  chart: { ...chartTheme.chart, type: 'area', sparkline: { enabled: false } },
  colors: ['#10b981', '#dc2626'],
  fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 100] } },
  stroke: { curve: 'smooth' as const, width: 2 },
  dataLabels: { enabled: false },
  xaxis: { ...chartTheme.xaxis, categories: stats.value.daily.map(d => d.date) },
  tooltip: { ...chartTheme.tooltip, y: { formatter: (v: number) => `$${v.toFixed(2)}` } },
}))

const revenueChartSeries = computed(() => [
  { name: t('admin.amount'), data: stats.value.daily.map(d => Number(d.revenue)) },
  { name: t('admin.toll'), data: stats.value.daily.map(d => Number(d.toll)) },
])

const gatewayChartOpts = computed(() => ({
  chart: { background: 'transparent', toolbar: { show: false } },
  theme: { mode: 'dark' as const },
  colors: ['#6366f1', '#f59e0b', '#10b981', '#dc2626'],
  labels: stats.value.by_gateway.map(g => g.gateway),
  legend: { position: 'bottom' as const, labels: { colors: 'rgba(255,255,255,0.4)' } },
  stroke: { show: false },
  dataLabels: { style: { fontSize: '11px' } },
  tooltip: { y: { formatter: (v: number) => `$${v.toFixed(2)}` } },
}))

const gatewayChartSeries = computed(() => stats.value.by_gateway.map(g => Number(g.revenue)))

watch(statusFilter, () => { page.value = 1 })
</script>
