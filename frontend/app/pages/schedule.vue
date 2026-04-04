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
                  <div :class="['inline-block rounded-lg px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider',
                    cell.type === 'divine' ? 'bg-red-500/15 text-red-400' :
                    cell.type === 'upper' ? 'bg-amber-500/10 text-amber-400/80' :
                    'bg-white/[0.04] text-white/40']">
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
          <div v-for="dred in dredgionSchedule" :key="dred.name"
            class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
            <h3 class="font-display text-[16px] font-bold uppercase tracking-wider">{{ dred.name }}</h3>
            <p class="mt-1 text-[12px] text-white/20">{{ dred.level }}</p>
            <div class="mt-4 space-y-2">
              <div v-for="slot in dred.slots" :key="slot.days" class="flex items-center justify-between border-t border-white/[0.03] pt-2">
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
            <template v-for="rift in riftSchedule" :key="rift.time">
              <div class="border-t border-white/[0.04] py-4 font-display text-[15px] font-bold tabular-nums text-white/50">{{ rift.time }}</div>
              <div class="border-t border-white/[0.04] py-4">
                <span :class="['text-[13px] font-medium',
                  rift.direction.includes('Morheim') ? 'text-red-400/70' : 'text-sky-400/70']">
                  {{ rift.direction }}
                </span>
              </div>
              <div class="border-t border-white/[0.04] py-4">
                <span :class="['inline-block h-2 w-2 rounded-full',
                  rift.direction.includes('Morheim') ? 'bg-red-500/40' : 'bg-sky-500/40']" />
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

const { lang, t, setLang } = useLang()
const activeTab = ref('sieges')

const tabs = [
  { key: 'sieges', labelKey: 'schedule.sieges' },
  { key: 'dredgion', labelKey: 'schedule.dredgion' },
  { key: 'rifts', labelKey: 'schedule.rifts' },
]

const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']

type FortressCell = { name: string; type: 'divine' | 'upper' | 'lower' } | null

const siegeGrid: { time: string; cells: FortressCell[] }[] = [
  {
    time: '16:00',
    cells: [
      { name: 'Asteria', type: 'lower' },
      null,
      { name: 'Asteria', type: 'lower' },
      null,
      { name: 'Asteria', type: 'lower' },
      null,
      { name: 'Asteria', type: 'lower' },
    ],
  },
  {
    time: '18:00',
    cells: [
      null,
      { name: 'Sulfur', type: 'upper' },
      null,
      { name: 'Sulfur', type: 'upper' },
      null,
      { name: 'Sulfur', type: 'upper' },
      null,
    ],
  },
  {
    time: '20:00',
    cells: [
      { name: 'Krotan', type: 'lower' },
      { name: 'Kysis', type: 'lower' },
      { name: 'Miren', type: 'lower' },
      { name: 'Krotan', type: 'lower' },
      { name: 'Kysis', type: 'lower' },
      { name: 'Miren', type: 'lower' },
      { name: 'Krotan', type: 'lower' },
    ],
  },
  {
    time: '22:00',
    cells: [
      null,
      null,
      null,
      null,
      null,
      { name: 'Divine', type: 'divine' },
      { name: 'Divine', type: 'divine' },
    ],
  },
  {
    time: '23:00',
    cells: [
      { name: 'Siel Western', type: 'upper' },
      null,
      { name: 'Siel Eastern', type: 'upper' },
      null,
      { name: 'Siel Western', type: 'upper' },
      null,
      { name: 'Siel Eastern', type: 'upper' },
    ],
  },
  {
    time: '00:00',
    cells: [
      null,
      null,
      null,
      null,
      null,
      { name: 'Divine', type: 'divine' },
      null,
    ],
  },
]

const dredgionSchedule = [
  {
    name: 'Baranath Dredgion',
    level: 'Lv. 46-55',
    slots: [
      { days: 'Mon — Fri', time: '10:00 — 02:00' },
      { days: 'Sat — Sun', time: '10:00 — 02:00' },
    ],
  },
  {
    name: 'Chantra Dredgion',
    level: 'Lv. 51-55',
    slots: [
      { days: 'Mon — Fri', time: '12:00 — 02:00' },
      { days: 'Sat — Sun', time: '12:00 — 02:00' },
    ],
  },
  {
    name: 'Terath Dredgion',
    level: 'Lv. 55',
    slots: [
      { days: 'Sat', time: '20:00 — 22:00' },
      { days: 'Sun', time: '20:00 — 22:00' },
    ],
  },
]

const riftSchedule = [
  { time: '01:00', direction: 'Morheim → Eltnen' },
  { time: '03:00', direction: 'Eltnen → Morheim' },
  { time: '05:00', direction: 'Morheim → Eltnen' },
  { time: '07:00', direction: 'Eltnen → Morheim' },
  { time: '09:00', direction: 'Morheim → Eltnen' },
  { time: '11:00', direction: 'Eltnen → Morheim' },
  { time: '13:00', direction: 'Morheim → Eltnen' },
  { time: '15:00', direction: 'Eltnen → Morheim' },
  { time: '17:00', direction: 'Morheim → Eltnen' },
  { time: '19:00', direction: 'Eltnen → Morheim' },
  { time: '21:00', direction: 'Morheim → Eltnen' },
  { time: '23:00', direction: 'Eltnen → Morheim' },
]
</script>
