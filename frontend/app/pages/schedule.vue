<template>
  <div class="text-white">

    <!-- Header -->
    <div class="relative overflow-hidden pb-12 pt-28">
      <div class="absolute inset-0 bg-[url('/img/bg_waterfall.jpg')] bg-cover bg-center opacity-[0.05]" />
      <div class="absolute inset-0 bg-gradient-to-b from-surface via-transparent to-surface" />
      <div class="relative mx-auto max-w-[1200px] px-6 text-center">
        <h1 class="font-display text-5xl font-extrabold uppercase tracking-tighter lg:text-7xl">
          {{ t('schedule.title') }}
        </h1>
        <p class="mx-auto mt-4 max-w-lg text-[14px] text-white/30">{{ t('schedule.desc') }}</p>
      </div>
    </div>

    <!-- Tabs -->
    <div class="mx-auto max-w-[1200px] px-6">
      <div class="flex border-b border-white/[0.06]">
        <button v-for="tab in tabs" :key="tab.key"
          :class="['border-b-2 px-6 pb-3 font-display text-[14px] font-bold uppercase tracking-widest transition-all duration-300',
            activeTab === tab.key ? 'border-red-500 text-white' : 'border-transparent text-white/25 hover:text-white/50']"
          @click="activeTab = tab.key">
          {{ t(tab.labelKey) }}
        </button>
      </div>
    </div>

    <!-- Tab content -->
    <div class="mx-auto max-w-[1200px] px-6 py-12">

      <!-- SIEGES — weekly grid -->
      <div v-if="activeTab === 'sieges'" class="overflow-x-auto">
        <table class="w-full min-w-[800px]">
          <thead>
            <tr>
              <th class="w-[80px] py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15">{{ t('schedule.time') }}</th>
              <th v-for="day in days" :key="day" class="py-3 text-center text-[10px] font-bold uppercase tracking-widest text-white/15">{{ day }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in siegeGrid" :key="row.time" class="border-t border-white/[0.04]">
              <td class="py-4 pr-4 font-display text-[15px] font-bold tabular-nums text-white/50">{{ row.time }}</td>
              <td v-for="(cell, di) in row.cells" :key="di" class="py-4 text-center">
                <template v-if="cell">
                  <div :class="['inline-block rounded-lg px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider transition-all duration-500',
                    isSiegeActive(row.time, di)
                      ? 'bg-emerald-500/20 text-emerald-400 ring-1 ring-emerald-500/30'
                      : cell.type === 'divine' ? 'bg-red-500/15 text-red-400'
                      : cell.type === 'upper' ? 'bg-amber-500/10 text-amber-400/80'
                      : 'bg-white/[0.04] text-white/40']">
                    {{ cell.name }}
                  </div>
                </template>
                <span v-else class="text-white/[0.06]">&mdash;</span>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Legend -->
        <div class="mt-8 flex flex-wrap gap-5 border-t border-white/[0.04] pt-6">
          <div class="flex items-center gap-2">
            <span class="h-2.5 w-2.5 rounded-sm bg-red-500/40" />
            <span class="text-[11px] text-white/30">Divine Fortress (Core)</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="h-2.5 w-2.5 rounded-sm bg-amber-500/30" />
            <span class="text-[11px] text-white/30">Upper Abyss Fortress</span>
          </div>
          <div class="flex items-center gap-2">
            <span class="h-2.5 w-2.5 rounded-sm bg-white/10" />
            <span class="text-[11px] text-white/30">Lower Abyss / Balaurea</span>
          </div>
        </div>
      </div>

      <!-- DREDGION -->
      <div v-else-if="activeTab === 'dredgion'">
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
          <div v-for="dred in dredgionList" :key="dred.id"
            :class="['rounded-xl p-6 transition-all duration-500',
              isDredgionActive(dred.metadata.slots as any[])
                ? 'border border-emerald-500/20 bg-emerald-500/[0.04] ring-1 ring-emerald-500/10'
                : 'border border-white/[0.04] bg-white/[0.02]']">
            <h3 class="font-display text-[16px] font-bold uppercase tracking-wider">{{ dred.name }}</h3>
            <p class="mt-1 text-[12px] text-white/20">{{ dred.metadata.level }}</p>
            <div class="mt-4 space-y-2">
              <div v-for="slot in (dred.metadata.slots as any[])" :key="slot.days" class="flex items-center justify-between border-t border-white/[0.03] pt-2">
                <span class="text-[12px] text-white/30">{{ slot.days }}</span>
                <span class="rounded bg-red-600/10 px-2 py-0.5 text-[12px] font-bold tabular-nums text-red-400/70">{{ slot.time }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- RIFTS -->
      <div v-else-if="activeTab === 'rifts'">
        <div class="max-w-2xl">
          <div class="grid grid-cols-[80px_1fr_auto] items-center gap-x-6">
            <template v-for="rift in riftList" :key="rift.id">
              <div :class="['border-t border-white/[0.04] py-4 font-display text-[15px] font-bold tabular-nums transition-colors duration-500',
                isRiftActive(String(rift.metadata.time)) ? 'text-emerald-400' : 'text-white/50']">{{ rift.metadata.time }}</div>
              <div :class="['border-t border-white/[0.04] py-4',
                isRiftActive(String(rift.metadata.time)) ? 'bg-emerald-500/[0.04]' : '']">
                <span :class="['text-[13px] font-medium',
                  isRiftActive(String(rift.metadata.time)) ? 'text-emerald-400'
                  : String(rift.metadata.direction).includes('Morheim') ? 'text-red-400/70' : 'text-sky-400/70']">
                  {{ rift.metadata.direction }}
                </span>
              </div>
              <div :class="['border-t border-white/[0.04] py-4',
                isRiftActive(String(rift.metadata.time)) ? 'bg-emerald-500/[0.04]' : '']">
                <span :class="['inline-block h-2 w-2 rounded-full',
                  isRiftActive(String(rift.metadata.time)) ? 'bg-emerald-500 animate-pulse'
                  : String(rift.metadata.direction).includes('Morheim') ? 'bg-red-500/40' : 'bg-sky-500/40']" />
              </div>
            </template>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'default' })

const { t } = useI18n()
const { $api } = useApi()
const activeTab = ref('sieges')

const tabs = [
  { key: 'sieges', labelKey: 'schedule.sieges' },
  { key: 'dredgion', labelKey: 'schedule.dredgion' },
  { key: 'rifts', labelKey: 'schedule.rifts' },
]

const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']

interface ScheduleItem {
  id: number
  category: string
  name: string
  metadata: Record<string, unknown>
  sort_order: number
  published: boolean
}

interface ScheduleResponse {
  data: {
    siege: ScheduleItem[]
    dredgion: ScheduleItem[]
    rift: ScheduleItem[]
  }
}

const { data: scheduleData } = useAsyncData('schedule', () => $api<ScheduleResponse>('/schedule'))

type FortressCell = { name: string; type: string } | null

const siegeGrid = computed(() => {
  const sieges = scheduleData.value?.data?.siege ?? []
  const timeMap = new Map<string, FortressCell[]>()

  for (const s of sieges) {
    const time = String(s.metadata.time)
    const day = Number(s.metadata.day_of_week)
    if (!timeMap.has(time)) timeMap.set(time, Array(7).fill(null))
    const row = timeMap.get(time)!
    row[day] = { name: s.name, type: String(s.metadata.fortress_type) }
  }

  return Array.from(timeMap.entries())
    .sort(([a], [b]) => a.localeCompare(b))
    .map(([time, cells]) => ({ time, cells }))
})

const dredgionList = computed(() => scheduleData.value?.data?.dredgion ?? [])
const riftList = computed(() => scheduleData.value?.data?.rift ?? [])

const { serverDay, serverHour } = useDate()
const currentDay = ref(serverDay())
const currentHour = ref(serverHour())
let timer: ReturnType<typeof setInterval>

onMounted(() => {
  timer = setInterval(() => {
    currentDay.value = serverDay()
    currentHour.value = serverHour()
  }, 60000)
})
onUnmounted(() => clearInterval(timer))

function isSiegeActive(time: string, dayIndex: number): boolean {
  if (dayIndex !== currentDay.value) return false
  const [h] = time.split(':').map(Number)
  return currentHour.value >= h && currentHour.value < h + 1
}

function isRiftActive(time: string): boolean {
  const [h] = time.split(':').map(Number)
  return currentHour.value >= h && currentHour.value < h + 2
}

function isDredgionActive(slots: { days: string; time: string }[]): boolean {
  const dayLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
  const today = dayLabels[currentDay.value]

  return slots.some(slot => {
    const dayMatch = slot.days.includes('—')
      ? isDayInRange(today, slot.days, dayLabels)
      : slot.days.includes(today)
    if (!dayMatch) return false
    const [startStr, endStr] = slot.time.split('—').map(s => s.trim())
    const [startH] = startStr.split(':').map(Number)
    const [endH] = endStr.split(':').map(Number)
    return endH < startH
      ? (currentHour.value >= startH || currentHour.value < endH)
      : (currentHour.value >= startH && currentHour.value < endH)
  })
}

function isDayInRange(today: string, range: string, dayLabels: string[]): boolean {
  const [start, end] = range.split('—').map(s => s.trim())
  const si = dayLabels.indexOf(start.slice(0, 3))
  const ei = dayLabels.indexOf(end.slice(0, 3))
  const ti = dayLabels.indexOf(today)
  return si <= ei ? (ti >= si && ti <= ei) : (ti >= si || ti <= ei)
}
</script>
