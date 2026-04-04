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

      <!-- ABYSS RANKINGS -->
      <div v-if="activeTab === 'abyss'">
        <div v-if="abyssLoading" class="space-y-3">
          <div v-for="i in 5" :key="i" class="h-14 animate-pulse rounded-lg bg-white/[0.03]" />
        </div>
        <table v-else class="w-full">
          <thead>
            <tr class="border-b border-white/[0.06]">
              <th class="py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15">#</th>
              <th class="py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15">{{ t('rank.name') }}</th>
              <th class="hidden py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15 sm:table-cell">{{ t('rank.race') }}</th>
              <th class="hidden py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15 md:table-cell">{{ t('rank.class') }}</th>
              <th class="py-3 pr-4 text-right text-[10px] font-bold uppercase tracking-widest text-white/15">{{ t('rank.kills') }}</th>
              <th class="py-3 text-right text-[10px] font-bold uppercase tracking-widest text-white/15">{{ t('rank.ap') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(entry, i) in abyssData" :key="i" class="border-b border-white/[0.03] transition-colors hover:bg-white/[0.015]">
              <td class="py-4 pr-4">
                <span :class="['font-display text-lg font-extrabold tabular-nums', i < 3 ? 'text-red-500' : 'text-white/15']">{{ String(i + 1).padStart(2, '0') }}</span>
              </td>
              <td class="py-4 pr-4 text-[14px] font-medium">{{ entry.player?.name }}</td>
              <td class="hidden py-4 pr-4 text-[13px] text-white/30 sm:table-cell">{{ entry.player?.race }}</td>
              <td class="hidden py-4 pr-4 text-[13px] text-white/30 md:table-cell">{{ entry.player?.player_class }}</td>
              <td class="py-4 pr-4 text-right text-[13px] tabular-nums text-white/40">{{ formatNum(entry.all_kill) }}</td>
              <td class="py-4 text-right font-display text-[14px] font-bold tabular-nums text-red-400/70">{{ formatNum(entry.ap) }}</td>
            </tr>
          </tbody>
        </table>
        <p v-if="!abyssLoading && abyssData.length === 0" class="py-12 text-center text-[14px] text-white/20">No abyss ranking data yet.</p>
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
                <span :class="['font-display text-lg font-extrabold tabular-nums', i < 3 ? 'text-red-500' : 'text-white/15']">{{ String(i + 1).padStart(2, '0') }}</span>
              </td>
              <td class="py-4 pr-4 text-[14px] font-medium">{{ leg.name }}</td>
              <td class="py-4 text-right font-display text-[14px] font-bold tabular-nums text-red-400/70">{{ leg.level }}</td>
            </tr>
          </tbody>
        </table>
        <p v-if="!legionLoading && legionData.length === 0" class="py-12 text-center text-[14px] text-white/20">No legion data yet.</p>
      </div>

      <!-- STATISTICS -->
      <div v-else-if="activeTab === 'statistics'" class="space-y-12">

        <!-- Counters -->
        <div class="grid gap-3 sm:grid-cols-2">
          <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
            <div class="text-[11px] font-bold uppercase tracking-widest text-white/20">{{ t('rank.online_now') }}</div>
            <div class="mt-2 font-display text-4xl font-extrabold tabular-nums text-white">{{ stats.online }}</div>
          </div>
          <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
            <div class="text-[11px] font-bold uppercase tracking-widest text-white/20">{{ t('rank.total_chars') }}</div>
            <div class="mt-2 font-display text-4xl font-extrabold tabular-nums text-white">{{ stats.total_characters }}</div>
          </div>
        </div>

        <!-- Online history — area chart -->
        <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
          <h3 class="mb-2 font-display text-lg font-bold uppercase tracking-wider">{{ lang === 'ru' ? 'Онлайн за неделю' : 'Weekly online' }}</h3>
          <ClientOnly>
            <apexchart type="area" height="280" :options="onlineChartOpts" :series="onlineChartSeries" />
          </ClientOnly>
        </div>

        <!-- Race balance — donut -->
        <div class="grid gap-4 lg:grid-cols-2">
          <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
            <h3 class="mb-2 font-display text-lg font-bold uppercase tracking-wider">{{ t('rank.by_race') }}</h3>
            <ClientOnly>
              <apexchart type="donut" height="260" :options="raceChartOpts" :series="raceChartSeries" />
            </ClientOnly>
          </div>

          <!-- Class distribution — horizontal bar -->
          <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
            <h3 class="mb-2 font-display text-lg font-bold uppercase tracking-wider">{{ t('rank.by_class') }}</h3>
            <ClientOnly>
              <apexchart type="bar" height="260" :options="classChartOpts" :series="classChartSeries" />
            </ClientOnly>
          </div>
        </div>

        <!-- Online by hour — bar chart -->
        <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
          <h3 class="mb-2 font-display text-lg font-bold uppercase tracking-wider">{{ lang === 'ru' ? 'Онлайн по часам (среднее)' : 'Average online by hour' }}</h3>
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

const { lang, t, setLang } = useLang()
const { $api } = useApi()
const activeTab = ref('abyss')

const tabs = [
  { key: 'abyss', labelKey: 'rank.abyss' },
  { key: 'legions', labelKey: 'rank.legions' },
  { key: 'statistics', labelKey: 'rank.statistics' },
]

function formatNum(n: number): string {
  return n?.toLocaleString('en-US') ?? '0'
}

// Abyss data
const abyssData = ref<any[]>([])
const abyssLoading = ref(true)

// Legion data
const legionData = ref<any[]>([])
const legionLoading = ref(true)

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
const onlineWeekly = [
  { day: 'Mon', values: [180, 210, 260, 312, 290, 245, 198] },
].length ? null : null // placeholder

const onlineChartOpts = {
  ...chartTheme,
  chart: { ...chartTheme.chart, type: 'area', sparkline: { enabled: false } },
  colors: ['#dc2626'],
  fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 100] } },
  stroke: { curve: 'smooth' as const, width: 2 },
  dataLabels: { enabled: false },
  xaxis: { ...chartTheme.xaxis, categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] },
}
const onlineChartSeries = [{ name: 'Peak online', data: [312, 287, 345, 298, 378, 401, 367] }]

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
const hourlyChartOpts = {
  ...chartTheme,
  chart: { ...chartTheme.chart, type: 'bar' },
  colors: ['#dc2626'],
  plotOptions: { bar: { borderRadius: 2, columnWidth: '55%' } },
  dataLabels: { enabled: false },
  xaxis: { ...chartTheme.xaxis, categories: Array.from({ length: 24 }, (_, i) => `${String(i).padStart(2, '0')}:00`) },
  tooltip: { ...chartTheme.tooltip, y: { formatter: (v: number) => `${v} players` } },
}
const hourlyChartSeries = [{
  name: 'Avg online',
  data: [45, 32, 22, 18, 15, 14, 18, 35, 78, 120, 165, 198, 230, 255, 270, 295, 320, 345, 370, 385, 365, 310, 240, 145],
}]

// Fetch data
onMounted(async () => {
  try {
    const [abyss, legion, statsRes] = await Promise.all([
      $api<{ data: any[] }>('/rating/abyss'),
      $api<{ data: any[] }>('/rating/legion'),
      $api<{ data: any }>('/rating/stats'),
    ])
    abyssData.value = abyss.data
    legionData.value = legion.data
    Object.assign(stats, statsRes.data)
  } catch (e) {
    console.error('Failed to load rankings:', e)
  } finally {
    abyssLoading.value = false
    legionLoading.value = false
  }
})
</script>
