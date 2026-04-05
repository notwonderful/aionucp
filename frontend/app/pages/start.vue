<template>
  <div class="text-white">

    <!-- Hero -->
    <div class="relative overflow-hidden pt-28 pb-20">
      <div class="absolute inset-0 bg-[url('/img/bg_39_armor.jpg')] bg-cover bg-center opacity-[0.08]" />
      <div class="absolute inset-0 bg-gradient-to-b from-surface via-transparent to-surface" />
      <img src="/img/shugo_hd.png" alt="" class="pointer-events-none absolute -right-4 bottom-0 hidden h-[280px] object-contain opacity-15 lg:block" />
      <div class="relative mx-auto max-w-[900px] px-6 text-center">
        <h1 class="font-display text-5xl font-extrabold uppercase tracking-tighter lg:text-7xl">{{ t('start.title') }}</h1>
        <p class="mt-4 text-[16px] text-white/35">{{ t('start.desc') }}</p>
      </div>
    </div>

    <!-- Steps — vertical timeline -->
    <div class="mx-auto max-w-[900px] px-6 pb-12">
      <div class="relative">
        <!-- Vertical line -->
        <div class="absolute left-6 top-0 hidden h-full w-px bg-gradient-to-b from-red-600/40 via-red-600/20 to-transparent md:block" />

        <!-- Step 1 -->
        <div class="relative mb-16 md:pl-20">
          <div class="absolute left-0 top-1 hidden h-12 w-12 items-center justify-center rounded-xl bg-red-600/15 ring-1 ring-red-500/25 md:flex">
            <span class="font-display text-lg font-extrabold text-red-500">01</span>
          </div>
          <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-8">
            <span class="mb-1 inline-block font-display text-lg font-extrabold text-red-500 md:hidden">01</span>
            <h2 class="font-display text-2xl font-extrabold uppercase tracking-tight">{{ t('start.s1.title') }}</h2>
            <p class="mt-3 max-w-lg text-[14px] leading-relaxed text-white/35">{{ t('start.s1.desc') }}</p>
            <NuxtLink to="/register"
              class="mt-6 inline-block bg-red-600 px-6 py-3 text-[12px] font-bold uppercase tracking-widest text-white transition-all hover:bg-red-500 hover:shadow-[0_0_30px_rgba(220,60,60,0.25)] active:scale-[0.97]">
              {{ t('start.s1.cta') }}
            </NuxtLink>
          </div>
        </div>

        <!-- Step 2 -->
        <div class="relative mb-16 md:pl-20">
          <div class="absolute left-0 top-1 hidden h-12 w-12 items-center justify-center rounded-xl bg-red-600/15 ring-1 ring-red-500/25 md:flex">
            <span class="font-display text-lg font-extrabold text-red-500">02</span>
          </div>
          <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-8">
            <span class="mb-1 inline-block font-display text-lg font-extrabold text-red-500 md:hidden">02</span>
            <h2 class="font-display text-2xl font-extrabold uppercase tracking-tight">{{ t('start.s2.title') }}</h2>
            <p class="mt-3 max-w-lg text-[14px] leading-relaxed text-white/35">{{ t('start.s2.desc') }}</p>

            <!-- Download buttons -->
            <div class="mt-6 flex flex-wrap gap-3">
              <a :href="dl?.url || '#'"
                class="inline-flex items-center gap-2.5 bg-red-600 px-6 py-3 text-[12px] font-bold uppercase tracking-widest text-white transition-all hover:bg-red-500 hover:shadow-[0_0_30px_rgba(220,60,60,0.25)] active:scale-[0.97]">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                {{ t('start.s2.cta') }}
              </a>
              <span class="flex items-center text-[12px] text-white/20">{{ dl?.file_size }}</span>
            </div>

          </div>
        </div>

        <!-- Step 3 -->
        <div class="relative mb-16 md:pl-20">
          <div class="absolute left-0 top-1 hidden h-12 w-12 items-center justify-center rounded-xl bg-red-600/15 ring-1 ring-red-500/25 md:flex">
            <span class="font-display text-lg font-extrabold text-red-500">03</span>
          </div>
          <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-8">
            <span class="mb-1 inline-block font-display text-lg font-extrabold text-red-500 md:hidden">03</span>
            <h2 class="font-display text-2xl font-extrabold uppercase tracking-tight">{{ t('start.s3.title') }}</h2>
            <p class="mt-3 max-w-lg text-[14px] leading-relaxed text-white/35">{{ t('start.s3.desc') }}</p>

            <!-- Quick checklist -->
            <div class="mt-6 space-y-2">
              <div v-for="item in checklist" :key="item" class="flex items-start gap-2.5">
                <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-500/60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                <span class="text-[13px] text-white/35">{{ item }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- System Requirements -->
    <div class="border-t border-white/[0.04] py-20">
      <div class="mx-auto max-w-[900px] px-6">
        <h2 class="mb-10 font-display text-2xl font-extrabold uppercase tracking-tight lg:text-3xl">{{ t('start.req.title') }}</h2>

        <div class="grid gap-4 sm:grid-cols-2">
          <!-- Minimum -->
          <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
            <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-white/20">{{ t('start.req.min') }}</span>
            <div class="mt-4 space-y-3">
              <div v-for="req in minReqs" :key="req.label" class="flex justify-between border-t border-white/[0.03] pt-3">
                <span class="text-[12px] text-white/25">{{ req.label }}</span>
                <span class="text-[13px] font-medium text-white/50">{{ req.value }}</span>
              </div>
            </div>
          </div>
          <!-- Recommended -->
          <div class="rounded-xl border border-red-500/10 bg-red-500/[0.02] p-6 ring-1 ring-red-500/[0.07]">
            <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-red-400/50">{{ t('start.req.rec') }}</span>
            <div class="mt-4 space-y-3">
              <div v-for="req in recReqs" :key="req.label" class="flex justify-between border-t border-white/[0.03] pt-3">
                <span class="text-[12px] text-white/25">{{ req.label }}</span>
                <span class="text-[13px] font-medium text-white/60">{{ req.value }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Troubleshooting FAQ -->
    <div class="border-t border-white/[0.04] py-20">
      <div class="mx-auto max-w-[900px] px-6">
        <h2 class="mb-10 font-display text-2xl font-extrabold uppercase tracking-tight lg:text-3xl">{{ t('start.faq.title') }}</h2>

        <div class="space-y-1">
          <div v-for="(faq, i) in faqs" :key="i" class="border-b border-white/[0.04]">
            <button class="flex w-full items-center justify-between py-5 text-left transition-colors hover:text-white"
              @click="openFaq === i ? openFaq = -1 : openFaq = i">
              <span class="pr-4 text-[14px] font-semibold">{{ t(faq.qKey) }}</span>
              <svg :class="['h-4 w-4 shrink-0 text-white/20 transition-transform duration-300', openFaq === i ? 'rotate-45' : '']"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
              </svg>
            </button>
            <div :class="['overflow-hidden transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)]',
              openFaq === i ? 'max-h-40 pb-5 opacity-100' : 'max-h-0 opacity-0']">
              <p class="text-[14px] leading-relaxed text-white/30">{{ t(faq.aKey) }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom CTA -->
    <div class="border-t border-white/[0.04] py-16">
      <div class="mx-auto max-w-[600px] px-6 text-center">
        <p class="text-[14px] text-white/25">{{ t('start.discordHelp') }}</p>
        <div class="mt-5 flex flex-wrap justify-center gap-3">
          <a :href="dl?.discord_url || '#'" class="inline-flex items-center gap-2 bg-[#5865F2] px-5 py-2.5 text-[12px] font-bold uppercase tracking-widest text-white transition-all hover:bg-[#4752C4] active:scale-[0.97]">
            <svg class="h-4 w-4" viewBox="0 0 127.14 96.36" fill="currentColor"><path d="M107.7,8.07A105.15,105.15,0,0,0,81.47,0a72.06,72.06,0,0,0-3.36,6.83A97.68,97.68,0,0,0,49,6.83,72.37,72.37,0,0,0,45.64,0,105.89,105.89,0,0,0,19.39,8.09C2.79,32.65-1.71,56.6.54,80.21h0A105.73,105.73,0,0,0,32.71,96.36,77.7,77.7,0,0,0,39.6,85.25a68.42,68.42,0,0,1-10.85-5.18c.91-.66,1.8-1.34,2.66-2a75.57,75.57,0,0,0,64.32,0c.87.71,1.76,1.39,2.66,2a68.68,68.68,0,0,1-10.87,5.19,77,77,0,0,0,6.89,11.1A105.25,105.25,0,0,0,126.6,80.22h0C129.24,52.84,122.09,29.11,107.7,8.07ZM42.45,65.69C36.18,65.69,31,60,31,53s5-12.74,11.43-12.74S54,46,53.89,53,48.84,65.69,42.45,65.69Zm42.24,0C78.41,65.69,73.25,60,73.25,53s5-12.74,11.44-12.74S96.23,46,96.12,53,91.08,65.69,84.69,65.69Z"/></svg>
            Discord
          </a>
          <NuxtLink to="/wiki" class="inline-block border border-white/[0.06] bg-white/[0.02] px-5 py-2.5 text-[12px] font-bold uppercase tracking-widest text-white/40 transition-all hover:bg-white/[0.04] hover:text-white/60 active:scale-[0.97]">
            Wiki
          </NuxtLink>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'default' })

const { t } = useI18n()
const { $api } = useApi()
const openFaq = ref(-1)

const checklist = computed(() => [
  t('start.s3.c1'), t('start.s3.c2'), t('start.s3.c3'),
  t('start.s3.c4'), t('start.s3.c5'), t('start.s3.c6'),
])

interface ReqItem { label: string; value: string }
interface DownloadData {
  url: string
  file_size: string
  discord_url: string
  min_requirements: ReqItem[]
  rec_requirements: ReqItem[]
}

const { data: downloadData } = useAsyncData('download-settings', () => $api<{ data: DownloadData }>('/settings/download'))
const dl = computed(() => downloadData.value?.data)
const minReqs = computed(() => dl.value?.min_requirements ?? [])
const recReqs = computed(() => dl.value?.rec_requirements ?? [])

const faqs = [
  { qKey: 'start.faq.q1', aKey: 'start.faq.a1' },
  { qKey: 'start.faq.q2', aKey: 'start.faq.a2' },
  { qKey: 'start.faq.q3', aKey: 'start.faq.a3' },
  { qKey: 'start.faq.q4', aKey: 'start.faq.a4' },
]
</script>
