<template>
  <div class="text-white">

    <!-- Header -->
    <div class="relative overflow-hidden pt-28 pb-12">
      <div class="absolute inset-0 bg-[url('/img/bg_39_armor.jpg')] bg-cover bg-center opacity-[0.06]" />
      <div class="absolute inset-0 bg-gradient-to-b from-surface via-transparent to-surface" />
      <img src="/img/sield_bg_right_.png" alt="" class="pointer-events-none absolute -right-20 top-0 hidden h-[300px] object-contain opacity-[0.04] lg:block" />
      <div class="relative mx-auto max-w-[1280px] px-6">
        <h1 class="font-display text-5xl font-extrabold uppercase tracking-tighter lg:text-7xl">{{ t('rank.title') }}</h1>
        <p class="mt-3 max-w-md text-[15px] text-white/30">{{ t('rank.desc') }}</p>
      </div>
    </div>

    <!-- Tabs -->
    <div class="mx-auto max-w-[1280px] px-6">
      <div class="flex border-b border-white/[0.06]">
        <button v-for="tab in tabs" :key="tab.key"
          :class="['border-b-2 px-6 pb-3 font-display text-[14px] font-bold uppercase tracking-widest transition-all duration-300',
            activeTab === tab.key ? 'border-red-500 text-white' : 'border-transparent text-white/25 hover:text-white/50']"
          @click="activeTab = tab.key">
          {{ t(tab.labelKey) }}
        </button>
      </div>
    </div>

    <!-- Content -->
    <div class="mx-auto max-w-[1280px] px-6 py-12">

      <!-- ONLINE PLAYERS -->
      <div v-if="activeTab === 'online'">
        <div v-if="onlineLoading" class="space-y-3">
          <div v-for="i in 5" :key="i" class="h-14 animate-pulse rounded-lg bg-white/[0.03]" />
        </div>
        <table v-else class="w-full">
          <thead>
            <tr class="border-b border-white/[0.06]">
              <th class="py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15">#</th>
              <th class="py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15">{{ t('rank.name') }}</th>
              <th class="hidden py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15 sm:table-cell">{{ t('rank.race') }}</th>
              <th class="hidden py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15 md:table-cell">{{ t('rank.class') }}</th>
              <th class="py-3 text-right text-[10px] font-bold uppercase tracking-widest text-white/15">{{ t('rank.level') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(player, i) in onlineData" :key="player.id" class="border-b border-white/[0.03] transition-colors hover:bg-white/[0.015]">
              <td class="py-4 pr-4">
                <span class="font-display text-lg font-extrabold tabular-nums text-white/15">{{ String(((onlinePage - 1) * 15) + i + 1).padStart(2, '0') }}</span>
              </td>
              <td class="py-4 pr-4 text-[14px] font-medium">{{ player.name }}</td>
              <td class="hidden py-4 pr-4 text-[13px] text-white/30 sm:table-cell">{{ player.race }}</td>
              <td class="hidden py-4 pr-4 text-[13px] text-white/30 md:table-cell">{{ player.player_class }}</td>
              <td class="py-4 text-right font-display text-[14px] font-bold tabular-nums text-red-400/70">{{ player.level }}</td>
            </tr>
          </tbody>
        </table>
        <p v-if="!onlineLoading && onlineData.length === 0" class="py-12 text-center text-[14px] text-white/20">{{ t('rank.noOnline') }}</p>
        <div v-if="onlineMeta.last_page > 1" class="mt-6 flex items-center justify-center gap-2">
          <button v-for="p in onlineMeta.last_page" :key="p" @click="onlinePage = p"
            :class="['rounded-lg px-3 py-1.5 text-[12px] font-bold transition-colors',
              onlinePage === p ? 'bg-red-600/15 text-red-400' : 'text-white/25 hover:text-white/50']">
            {{ p }}
          </button>
        </div>
      </div>

      <!-- ABYSS RANKINGS -->
      <div v-else-if="activeTab === 'abyss'">
        <div v-if="abyssLoading" class="space-y-3">
          <div v-for="i in 5" :key="i" class="h-14 animate-pulse rounded-lg bg-white/[0.03]" />
        </div>
        <table v-else class="w-full">
          <thead>
            <tr class="border-b border-white/[0.06]">
              <th class="py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15">#</th>
              <th class="py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15">{{ t('rank.name') }}</th>
              <th class="hidden py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15 lg:table-cell">{{ t('rank.rank') }}</th>
              <th class="hidden py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15 sm:table-cell">{{ t('rank.race') }}</th>
              <th class="hidden py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15 md:table-cell">{{ t('rank.class') }}</th>
              <th class="py-3 pr-4 text-right text-[10px] font-bold uppercase tracking-widest text-white/15">{{ t('rank.kills') }}</th>
              <th class="py-3 text-right text-[10px] font-bold uppercase tracking-widest text-white/15">{{ t('rank.ap') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(entry, i) in abyssData" :key="i" class="border-b border-white/[0.03] transition-colors hover:bg-white/[0.015]">
              <td class="py-4 pr-4">
                <span :class="['font-display text-lg font-extrabold tabular-nums', i < 3 && abyssPage === 1 ? 'text-red-500' : 'text-white/15']">{{ String(((abyssPage - 1) * 15) + i + 1).padStart(2, '0') }}</span>
              </td>
              <td class="py-4 pr-4 text-[14px] font-medium">{{ entry.player?.name }}</td>
              <td class="hidden py-4 pr-4 text-[13px] text-white/30 lg:table-cell">{{ entry.rank_name }}</td>
              <td class="hidden py-4 pr-4 text-[13px] text-white/30 sm:table-cell">{{ entry.player?.race }}</td>
              <td class="hidden py-4 pr-4 text-[13px] text-white/30 md:table-cell">{{ entry.player?.player_class }}</td>
              <td class="py-4 pr-4 text-right text-[13px] tabular-nums text-white/40">{{ formatNum(entry.all_kill) }}</td>
              <td class="py-4 text-right font-display text-[14px] font-bold tabular-nums text-red-400/70">{{ formatNum(entry.ap) }}</td>
            </tr>
          </tbody>
        </table>
        <p v-if="!abyssLoading && abyssData.length === 0" class="py-12 text-center text-[14px] text-white/20">No abyss ranking data yet.</p>
        <div v-if="abyssMeta.last_page > 1" class="mt-6 flex items-center justify-center gap-2">
          <button v-for="p in abyssMeta.last_page" :key="p" @click="abyssPage = p"
            :class="['rounded-lg px-3 py-1.5 text-[12px] font-bold transition-colors',
              abyssPage === p ? 'bg-red-600/15 text-red-400' : 'text-white/25 hover:text-white/50']">
            {{ p }}
          </button>
        </div>
      </div>

      <!-- LEGIONS -->
      <div v-else-if="activeTab === 'legions'">
        <div v-if="legionLoading" class="space-y-3">
          <div v-for="i in 5" :key="i" class="h-14 animate-pulse rounded-lg bg-white/[0.03]" />
        </div>
        <table v-else class="w-full">
          <thead>
            <tr class="border-b border-white/[0.06]">
              <th class="py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15">#</th>
              <th class="py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15">{{ t('rank.name') }}</th>
              <th class="py-3 text-right text-[10px] font-bold uppercase tracking-widest text-white/15">{{ t('rank.level') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(leg, i) in legionData" :key="i" class="border-b border-white/[0.03] transition-colors hover:bg-white/[0.015]">
              <td class="py-4 pr-4">
                <span :class="['font-display text-lg font-extrabold tabular-nums', i < 3 && legionPage === 1 ? 'text-red-500' : 'text-white/15']">{{ String(((legionPage - 1) * 15) + i + 1).padStart(2, '0') }}</span>
              </td>
              <td class="py-4 pr-4 text-[14px] font-medium">{{ leg.name }}</td>
              <td class="py-4 text-right font-display text-[14px] font-bold tabular-nums text-red-400/70">{{ leg.level }}</td>
            </tr>
          </tbody>
        </table>
        <p v-if="!legionLoading && legionData.length === 0" class="py-12 text-center text-[14px] text-white/20">No legion data yet.</p>
        <div v-if="legionMeta.last_page > 1" class="mt-6 flex items-center justify-center gap-2">
          <button v-for="p in legionMeta.last_page" :key="p" @click="legionPage = p"
            :class="['rounded-lg px-3 py-1.5 text-[12px] font-bold transition-colors',
              legionPage === p ? 'bg-red-600/15 text-red-400' : 'text-white/25 hover:text-white/50']">
            {{ p }}
          </button>
        </div>
      </div>

      <!-- STATISTICS -->
      <div v-else-if="activeTab === 'statistics'" class="space-y-12">

        <!-- Counters -->
        <div class="grid gap-3 sm:grid-cols-2">
          <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
            <div class="text-[11px] font-bold uppercase tracking-widest text-white/20">{{ t('rank.onlineNow') }}</div>
            <div class="mt-2 font-display text-4xl font-extrabold tabular-nums text-white">{{ stats.online }}</div>
          </div>
          <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
            <div class="text-[11px] font-bold uppercase tracking-widest text-white/20">{{ t('rank.totalChars') }}</div>
            <div class="mt-2 font-display text-4xl font-extrabold tabular-nums text-white">{{ stats.total_characters }}</div>
          </div>
        </div>

        <!-- Online history — area chart -->
        <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
          <h3 class="mb-2 font-display text-lg font-bold uppercase tracking-wider">{{ t('rank.weeklyOnline') }}</h3>
          <ClientOnly>
            <apexchart type="area" height="280" :options="onlineChartOpts" :series="onlineChartSeries" />
          </ClientOnly>
        </div>

        <!-- Race balance — donut -->
        <div class="grid gap-4 lg:grid-cols-2">
          <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
            <h3 class="mb-2 font-display text-lg font-bold uppercase tracking-wider">{{ t('rank.byRace') }}</h3>
            <ClientOnly>
              <apexchart type="donut" height="260" :options="raceChartOpts" :series="raceChartSeries" />
            </ClientOnly>
          </div>

          <!-- Class distribution — horizontal bar -->
          <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
            <h3 class="mb-2 font-display text-lg font-bold uppercase tracking-wider">{{ t('rank.byClass') }}</h3>
            <ClientOnly>
              <apexchart type="bar" height="260" :options="classChartOpts" :series="classChartSeries" />
            </ClientOnly>
          </div>
        </div>

        <!-- Online by hour — bar chart -->
        <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
          <h3 class="mb-2 font-display text-lg font-bold uppercase tracking-wider">{{ t('rank.hourlyOnline') }}</h3>
          <ClientOnly>
            <apexchart type="bar" height="240" :options="hourlyChartOpts" :series="hourlyChartSeries" />
          </ClientOnly>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'default' })

const { t } = useI18n()
const { $api } = useApi()
const activeTab = ref('online')

const tabs = [
  { key: 'online', labelKey: 'rank.online' },
  { key: 'abyss', labelKey: 'rank.abyss' },
  { key: 'legions', labelKey: 'rank.legions' },
  { key: 'statistics', labelKey: 'rank.statistics' },
]

function formatNum(n: number): string {
  return n?.toLocaleString('en-US') ?? '0'
}

// Online players
const onlineData = ref<any[]>([])
const onlineLoading = ref(true)
const onlinePage = ref(1)
const onlineMeta = ref({ last_page: 1 })

async function fetchOnline() {
  onlineLoading.value = true
  try {
    const res = await $api<{ data: any[]; meta: any }>(`/rating/online?page=${onlinePage.value}`)
    onlineData.value = res.data
    onlineMeta.value = res.meta ?? { last_page: 1 }
  } catch (e) {
    console.error('Failed to load online players:', e)
  } finally {
    onlineLoading.value = false
  }
}

watch(onlinePage, () => fetchOnline())

// Abyss data
const abyssData = ref<any[]>([])
const abyssLoading = ref(true)
const abyssPage = ref(1)
const abyssMeta = ref({ last_page: 1 })

async function fetchAbyss() {
  abyssLoading.value = true
  try {
    const res = await $api<{ data: any[]; meta: any }>(`/rating/abyss?page=${abyssPage.value}`)
    abyssData.value = res.data
    abyssMeta.value = res.meta ?? { last_page: 1 }
  } catch (e) {
    console.error('Failed to load abyss rankings:', e)
  } finally {
    abyssLoading.value = false
  }
}

watch(abyssPage, () => fetchAbyss())

// Legion data
const legionData = ref<any[]>([])
const legionLoading = ref(true)
const legionPage = ref(1)
const legionMeta = ref({ last_page: 1 })

async function fetchLegion() {
  legionLoading.value = true
  try {
    const res = await $api<{ data: any[]; meta: any }>(`/rating/legion?page=${legionPage.value}`)
    legionData.value = res.data
    legionMeta.value = res.meta ?? { last_page: 1 }
  } catch (e) {
    console.error('Failed to load legion rankings:', e)
  } finally {
    legionLoading.value = false
  }
}

watch(legionPage, () => fetchLegion())

// Stats
const stats = reactive({ online: 0, total_characters: 0, races: {} as Record<string, number>, classes: {} as Record<string, number> })

// --- Chart theme ---
const chartTheme = {
  chart: { background: 'transparent', toolbar: { show: false }, zoom: { enabled: false } },
  theme: { mode: 'dark' as const },
  grid: { borderColor: 'rgba(255,255,255,0.04)', strokeDashArray: 3 },
  tooltip: { theme: 'dark', style: { fontSize: '12px' } },
  xaxis: { labels: { style: { colors: 'rgba(255,255,255,0.25)', fontSize: '11px' } }, axisBorder: { show: false }, axisTicks: { show: false } },
  yaxis: { labels: { style: { colors: 'rgba(255,255,255,0.25)', fontSize: '11px' } } },
}

// --- Online history (area chart) ---
const onlineHistory = reactive({ daily: [] as { date: string; peak: number; avg: number }[], hourly: [] as { hour: number; avg: number }[] })

const onlineChartOpts = computed(() => ({
  ...chartTheme,
  chart: { ...chartTheme.chart, type: 'area', sparkline: { enabled: false } },
  colors: ['#dc2626', '#f97316'],
  fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 100] } },
  stroke: { curve: 'smooth' as const, width: 2 },
  dataLabels: { enabled: false },
  xaxis: { ...chartTheme.xaxis, categories: onlineHistory.daily.map(d => d.date) },
}))
const onlineChartSeries = computed(() => [
  { name: t('rank.peakOnline'), data: onlineHistory.daily.map(d => d.peak) },
  { name: t('rank.avgOnline'), data: onlineHistory.daily.map(d => d.avg) },
])

// --- Race donut ---
const raceChartOpts = computed(() => ({
  chart: { background: 'transparent', toolbar: { show: false } },
  theme: { mode: 'dark' as const },
  colors: ['#0284c7', '#dc2626'],
  labels: Object.keys(stats.races).length ? Object.keys(stats.races) : ['Elyos', 'Asmodians'],
  legend: { position: 'bottom' as const, labels: { colors: 'rgba(255,255,255,0.4)' }, fontSize: '12px' },
  stroke: { show: false },
  dataLabels: { enabled: true, style: { fontSize: '13px', fontWeight: 700 }, dropShadow: { enabled: false } },
  plotOptions: { pie: { donut: { size: '55%', labels: { show: true, total: { show: true, label: 'Total', color: 'rgba(255,255,255,0.4)', fontSize: '12px', formatter: (w: any) => w.globals.seriesTotals.reduce((a: number, b: number) => a + b, 0) } } } } },
}))
const raceChartSeries = computed(() => Object.values(stats.races).length ? Object.values(stats.races) : [0, 0])

// --- Class horizontal bar ---
const classChartOpts = computed(() => ({
  ...chartTheme,
  chart: { ...chartTheme.chart, type: 'bar' },
  colors: ['#dc2626'],
  plotOptions: { bar: { horizontal: true, borderRadius: 3, barHeight: '60%' } },
  dataLabels: { enabled: false },
  xaxis: { ...chartTheme.xaxis, categories: Object.keys(stats.classes).length ? Object.keys(stats.classes) : ['—'] },
  yaxis: { labels: { style: { colors: 'rgba(255,255,255,0.35)', fontSize: '11px' } } },
  tooltip: { ...chartTheme.tooltip, y: { formatter: (v: number) => `${v} characters` } },
}))
const classChartSeries = computed(() => [{ name: 'Characters', data: Object.values(stats.classes).length ? Object.values(stats.classes) : [0] }])

// --- Online by hour (bar) ---
const hourlyChartOpts = computed(() => ({
  ...chartTheme,
  chart: { ...chartTheme.chart, type: 'bar' },
  colors: ['#dc2626'],
  plotOptions: { bar: { borderRadius: 2, columnWidth: '55%' } },
  dataLabels: { enabled: false },
  xaxis: { ...chartTheme.xaxis, categories: Array.from({ length: 24 }, (_, i) => `${String(i).padStart(2, '0')}:00`) },
  tooltip: { ...chartTheme.tooltip, y: { formatter: (v: number) => `${v} players` } },
}))
const hourlyChartSeries = computed(() => {
  const data = Array.from({ length: 24 }, () => 0)
  for (const h of onlineHistory.hourly) {
    data[h.hour] = h.avg
  }
  return [{ name: t('rank.avgOnline'), data }]
})

// Fetch data
onMounted(async () => {
  try {
    const [,, , statsRes, historyRes] = await Promise.all([
      fetchOnline(),
      fetchAbyss(),
      fetchLegion(),
      $api<{ data: any }>('/rating/stats'),
      $api<{ data: any }>('/rating/online-history'),
    ])
    Object.assign(stats, statsRes.data)
    Object.assign(onlineHistory, historyRes.data)
  } catch (e) {
    console.error('Failed to load rankings:', e)
  }
})
</script>
