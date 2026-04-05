<template>
  <div class="text-white">

    <!-- HERO — full cinematic, video dominant -->
    <section class="relative min-h-[100dvh] overflow-hidden">
      <video autoplay muted loop playsinline class="absolute inset-0 h-full w-full object-cover">
        <source src="/video/hero.webm" type="video/webm" />
        <source src="/video/hero.mp4" type="video/mp4" />
      </video>
      <!-- Minimal overlay — let video breathe -->
      <div class="absolute inset-0 bg-gradient-to-b from-surface/40 via-transparent to-surface" />
      <div class="absolute inset-0 bg-gradient-to-r from-surface/80 via-surface/20 to-transparent" />

      <!-- Content — left aligned, bottom heavy -->
      <div class="relative z-10 flex min-h-[100dvh] flex-col justify-end pb-24 pt-32 lg:justify-center lg:pb-0 lg:pt-0">
        <div class="mx-auto w-full max-w-[1200px] px-6">
          <div class="max-w-2xl">
            <!-- Server status inline -->
            <div class="mb-5 flex items-center gap-3 text-[12px] font-medium text-white/40">
              <span class="flex h-2 w-2"><span class="absolute h-2 w-2 animate-ping rounded-full bg-emerald-400 opacity-75" /><span class="relative h-2 w-2 rounded-full bg-emerald-400" /></span>
              {{ serverStatus.online }} online
              <span class="text-white/10">/</span>
              patch 3.9
              <span class="text-white/10">/</span>
              EU servers
            </div>

            <!-- Title — massive Syne -->
            <h1 class="font-display text-[clamp(3rem,9vw,8rem)] font-extrabold uppercase leading-[0.85] tracking-tighter">
              {{ t('hero.title1') }}<br>
              <span class="text-red-500">{{ t('hero.title2') }}</span>
            </h1>

            <p class="mt-6 max-w-md text-[15px] leading-relaxed text-white/40 italic">
              {{ t('hero.desc') }}
            </p>

            <div class="mt-10 flex items-center gap-5">
              <NuxtLink to="/start"
                class="inline-block bg-red-600 px-8 py-4 font-display text-[13px] font-bold uppercase tracking-widest text-white transition-all hover:bg-red-500 hover:shadow-[0_0_40px_rgba(220,60,60,0.3)] active:scale-[0.97]">
                {{ t('hero.cta') }}
              </NuxtLink>
              <a href="#" class="inline-flex items-center gap-2.5 rounded-lg bg-[#5865F2] px-6 py-4 text-[13px] font-bold uppercase tracking-widest text-white transition-all hover:bg-[#4752C4] hover:shadow-[0_0_30px_rgba(88,101,242,0.25)] active:scale-[0.97]">
                <svg class="h-5 w-5" viewBox="0 0 127.14 96.36" fill="currentColor"><path d="M107.7,8.07A105.15,105.15,0,0,0,81.47,0a72.06,72.06,0,0,0-3.36,6.83A97.68,97.68,0,0,0,49,6.83,72.37,72.37,0,0,0,45.64,0,105.89,105.89,0,0,0,19.39,8.09C2.79,32.65-1.71,56.6.54,80.21h0A105.73,105.73,0,0,0,32.71,96.36,77.7,77.7,0,0,0,39.6,85.25a68.42,68.42,0,0,1-10.85-5.18c.91-.66,1.8-1.34,2.66-2a75.57,75.57,0,0,0,64.32,0c.87.71,1.76,1.39,2.66,2a68.68,68.68,0,0,1-10.87,5.19,77,77,0,0,0,6.89,11.1A105.25,105.25,0,0,0,126.6,80.22h0C129.24,52.84,122.09,29.11,107.7,8.07ZM42.45,65.69C36.18,65.69,31,60,31,53s5-12.74,11.43-12.74S54,46,53.89,53,48.84,65.69,42.45,65.69Zm42.24,0C78.41,65.69,73.25,60,73.25,53s5-12.74,11.44-12.74S96.23,46,96.12,53,91.08,65.69,84.69,65.69Z"/></svg>
                Discord
              </a>
            </div>
          </div>
        </div>
      </div>

    </section>

    <!-- HOW TO START — 3 steps -->
    <section class="relative border-t border-white/[0.04] py-28 lg:py-36">
      <div class="mx-auto max-w-[1200px] px-6">
        <h2 v-reveal class="text-center font-display text-3xl font-extrabold uppercase tracking-tighter lg:text-4xl">
          {{ t('steps.title') }}
        </h2>

        <div class="mt-16 grid items-start md:grid-cols-[1fr_auto_1fr_auto_1fr]">
          <template v-for="(step, i) in steps" :key="i">
            <!-- Arrow between steps -->
            <div v-if="i > 0" class="hidden items-center justify-center self-center md:flex">
              <svg class="h-5 w-5 text-red-600/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
            </div>
            <!-- Step -->
            <div class="relative border-t border-white/[0.06] p-10 md:p-12">
              <span class="font-display text-[80px] font-extrabold leading-none text-white/[0.03]">{{ String(i + 1).padStart(2, '0') }}</span>
              <div class="-mt-10">
                <h3 class="font-display text-[18px] font-bold uppercase tracking-wider">{{ t(step.titleKey) }}</h3>
                <p class="mt-2 max-w-xs text-[14px] leading-relaxed text-white/30">{{ t(step.descKey) }}</p>
                <NuxtLink v-if="step.link" :to="step.link"
                  class="mt-5 inline-block text-[12px] font-bold uppercase tracking-widest text-red-500 transition-colors hover:text-red-400">
                  {{ step.linkLabel }} &rarr;
                </NuxtLink>
              </div>
            </div>
          </template>
        </div>
      </div>
    </section>


    <!-- FACTIONS — full-bleed imagery, text overlaid -->
    <section class="relative overflow-hidden">
      <div class="grid min-h-[450px] md:grid-cols-2 lg:min-h-[500px]">
        <!-- Elyos — waterfall is the star -->
        <div class="relative flex items-end overflow-hidden p-8 lg:p-12">
          <div class="absolute inset-0 bg-[url('/img/bg_waterfall.jpg')] bg-cover bg-center" />
          <div class="absolute inset-0 bg-gradient-to-t from-surface via-surface/40 to-sky-950/30" />
          <div class="absolute inset-0 bg-gradient-to-r from-surface/30 to-transparent md:bg-none" />
          <img src="/img/race/0.png" alt="" class="pointer-events-none absolute top-6 right-6 h-12 w-12 object-contain opacity-30" />
          <div class="relative">
            <div class="font-display text-[13px] font-bold uppercase tracking-[0.3em] text-sky-400/60">{{ t('factions.elyos') }}</div>
            <div class="mt-1 text-[48px] font-bold tabular-nums leading-none text-white lg:text-[56px]">{{ factionData.elyos }}</div>
            <div class="mt-2 text-[12px] text-white/40">{{ t('stats.online') }}</div>
          </div>
        </div>
        <!-- Asmodian — armor art is the star -->
        <div class="relative flex items-end overflow-hidden p-8 lg:p-12">
          <div class="absolute inset-0 bg-[url('/img/bg_39_armor.jpg')] bg-cover bg-center" />
          <div class="absolute inset-0 bg-gradient-to-t from-surface via-surface/40 to-red-950/30" />
          <div class="absolute inset-0 bg-gradient-to-l from-surface/30 to-transparent md:bg-none" />
          <img src="/img/race/1.png" alt="" class="pointer-events-none absolute top-6 left-6 h-12 w-12 object-contain opacity-30" />
          <div class="relative md:ml-auto md:text-right">
            <div class="font-display text-[13px] font-bold uppercase tracking-[0.3em] text-red-500/60">{{ t('factions.asmodian') }}</div>
            <div class="mt-1 text-[48px] font-bold tabular-nums leading-none text-white lg:text-[56px]">{{ factionData.asmodians }}</div>
            <div class="mt-2 text-[12px] text-white/40">{{ t('stats.online') }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- LIVE SIEGE TIMER -->
    <section class="relative overflow-hidden border-t border-white/[0.04] bg-surface">
      <div class="absolute inset-0 bg-[url('/img/bg_39_armor.jpg')] bg-cover bg-center opacity-[0.04]" />
      <div class="relative mx-auto flex max-w-[1200px] flex-col items-center justify-between gap-6 px-6 py-10 md:flex-row">
        <div class="flex items-center gap-4">
          <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-600/15">
            <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" /></svg>
          </div>
          <div>
            <div class="text-[11px] font-bold uppercase tracking-widest text-red-500/60">{{ t('timer.next') }}</div>
            <div class="font-display text-lg font-bold uppercase tracking-tight">{{ nextSiege.name }}</div>
          </div>
        </div>
        <!-- Countdown digits -->
        <div class="flex items-center gap-1">
          <div v-for="unit in countdownUnits" :key="unit.label" class="flex items-center gap-1">
            <div class="flex h-14 w-14 items-center justify-center rounded-lg bg-white/[0.04] font-display text-2xl font-extrabold tabular-nums text-white">
              {{ String(unit.value).padStart(2, '0') }}
            </div>
            <span class="mr-2 text-[10px] font-bold uppercase tracking-widest text-white/20">{{ unit.label }}</span>
          </div>
        </div>
        <NuxtLink to="/schedule" class="text-[12px] font-bold uppercase tracking-widest text-white/25 transition-colors hover:text-white/50">
          {{ t('schedule.title') }} &rarr;
        </NuxtLink>
      </div>
    </section>


    <!-- CLASS PICKER — horizontal accordion strips -->
    <section class="relative overflow-hidden py-28 lg:py-36">
      <!-- Atmospheric bg -->
      <div class="absolute inset-0 bg-[url('/img/bg_waterfall.jpg')] bg-cover bg-center opacity-[0.03]" />
      <div class="absolute inset-0 bg-gradient-to-b from-surface via-transparent to-surface" />

      <div class="relative mx-auto max-w-[1200px] px-6">
        <h2 v-reveal class="mb-14 text-center font-display text-4xl font-extrabold uppercase tracking-tighter lg:text-5xl">
          {{ t('classes.title') }}
        </h2>

        <!-- Accordion strips -->
        <div class="flex h-[420px] gap-1.5 overflow-hidden rounded-2xl lg:h-[480px]">
          <button v-for="cls in aionClasses" :key="cls.id"
            :class="['group relative overflow-hidden transition-all duration-700 ease-[cubic-bezier(0.32,0.72,0,1)]',
              selectedClass === cls.id ? 'flex-[3]' : 'flex-[0.6] hover:flex-[0.8]']"
            :style="{ background: cls.gradient }"
            @click="selectedClass = cls.id">
            <!-- Full overlay gradient -->
            <div :class="['absolute inset-0 transition-opacity duration-700',
              selectedClass === cls.id ? 'opacity-0' : 'bg-black/50 opacity-100 group-hover:opacity-70']" />
            <!-- Red line indicator for active -->
            <div :class="['absolute bottom-0 left-0 right-0 h-[3px] bg-red-500 transition-all duration-500',
              selectedClass === cls.id ? 'opacity-100' : 'opacity-0']" />

            <!-- Class icon centered — visible in collapsed state -->
            <div :class="['absolute inset-0 flex items-center justify-center transition-all duration-700',
              selectedClass === cls.id ? 'opacity-0 scale-150' : 'opacity-100']">
              <img v-if="cls.hasIcon" :src="`/img/class/${cls.iconId}.png`" :alt="cls.name"
                class="h-12 w-12 object-contain opacity-40 drop-shadow-[0_2px_10px_rgba(0,0,0,0.8)]" />
              <span v-else class="font-display text-[48px] font-extrabold uppercase leading-none text-white/10">{{ cls.name.charAt(0) }}</span>
            </div>

            <!-- Vertical class name — visible in collapsed state -->
            <div :class="['absolute bottom-6 left-1/2 -translate-x-1/2 whitespace-nowrap transition-all duration-500',
              selectedClass === cls.id ? 'opacity-0' : 'opacity-100']">
              <span class="font-display text-[11px] font-bold uppercase tracking-[0.3em] text-white/40 [writing-mode:vertical-lr] rotate-180">
                {{ cls.name }}
              </span>
            </div>

            <!-- Expanded content — visible when selected -->
            <div :class="['absolute inset-0 flex flex-col justify-end p-8 transition-all duration-700 lg:p-10',
              selectedClass === cls.id ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8']">
              <!-- Large icon in bg -->
              <img v-if="cls.hasIcon" :src="`/img/class/${cls.iconId}.png`" :alt="cls.name"
                class="absolute top-1/2 left-1/2 h-64 w-64 -translate-x-1/2 -translate-y-1/2 object-contain opacity-[0.07]" />

              <div class="relative">
                <div class="text-[11px] font-bold uppercase tracking-[0.2em] text-red-400/70">{{ cls.role }}</div>
                <div class="mt-1 font-display text-3xl font-extrabold uppercase tracking-tight lg:text-4xl">{{ cls.name }}</div>
                <p class="mt-3 max-w-sm text-[13px] leading-relaxed text-white/40">{{ cls.description }}</p>
                <!-- Stat bars inline -->
                <div class="mt-5 flex max-w-xs gap-4">
                  <div v-for="stat in cls.stats" :key="stat.name" class="flex-1">
                    <div class="mb-1 text-[9px] font-bold uppercase tracking-wider text-white/20">{{ stat.name }}</div>
                    <div class="h-1 overflow-hidden rounded-full bg-white/[0.08]">
                      <div class="h-full rounded-full transition-all duration-1000 ease-[cubic-bezier(0.32,0.72,0,1)]"
                        :class="stat.value >= 8 ? 'bg-red-500/70' : stat.value >= 5 ? 'bg-amber-500/50' : 'bg-white/20'"
                        :style="{ width: selectedClass === cls.id ? `${stat.value * 10}%` : '0%' }" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </button>
        </div>
      </div>
    </section>

    <!-- FEATURES -->
    <section id="realm" class="relative overflow-hidden py-28 lg:py-40">

      <div class="relative mx-auto max-w-[1200px] px-6">
        <!-- Section header — left aligned, big -->
        <div v-reveal class="mb-20 max-w-lg">
          <span class="text-[11px] font-bold uppercase tracking-[0.3em] text-red-500/70">{{ t('realm.eyebrow') }}</span>
          <h2 class="mt-3 font-display text-4xl font-extrabold uppercase tracking-tighter lg:text-5xl">
            {{ t('realm.title') }}
          </h2>
        </div>

        <!-- 2-col feature grid — no cards, just text blocks with left red bar -->
        <div class="grid gap-x-20 gap-y-16 md:grid-cols-2">
          <div v-for="feat in allFeatures" :key="feat.titleKey" class="relative pl-5 before:absolute before:left-0 before:top-0 before:h-full before:w-[2px] before:bg-red-600/30">
            <h3 class="font-display text-[17px] font-bold uppercase tracking-wider">{{ t(feat.titleKey) }}</h3>
            <p class="mt-2 text-[14px] leading-relaxed text-white/35">{{ t(feat.descKey) }}</p>
          </div>
        </div>
      </div>
    </section>


    <!-- NEWS — editorial, image-led -->
    <section id="news" class="relative py-28 lg:py-40">
      <!-- Dark gradient bg with game art -->
      <div class="absolute inset-0 bg-gradient-to-b from-surface-card via-surface to-surface" />

      <div class="relative mx-auto max-w-[1200px] px-6">
        <div class="mb-14 flex items-end justify-between">
          <h2 v-reveal class="font-display text-3xl font-extrabold uppercase tracking-tighter lg:text-4xl">{{ t('news.title') }}</h2>
          <NuxtLink to="/news" class="text-[12px] font-medium uppercase tracking-widest text-red-500/60 transition-colors hover:text-red-500">{{ t('news.all') }}</NuxtLink>
        </div>

        <div class="grid gap-4 lg:grid-cols-12">
          <!-- Featured — 8 cols, image dominant -->
          <NuxtLink v-if="featuredNews" :to="`/news/${featuredNews.slug}`" class="group relative overflow-hidden lg:col-span-8">
            <div class="aspect-[16/9] overflow-hidden bg-cover bg-center lg:aspect-[2/1]" :style="featuredNews.image_url ? { backgroundImage: `url(${featuredNews.image_url})` } : {}" :class="!featuredNews.image_url && 'bg-gradient-to-br from-red-950/30 to-surface'">
              <div class="flex h-full flex-col justify-end bg-gradient-to-t from-surface via-surface/30 to-transparent p-8 transition-all duration-500 group-hover:via-surface/50">
                <span class="mb-3 w-fit bg-red-600 px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest">{{ featuredNews.tag }}</span>
                <h3 class="font-display text-2xl font-bold uppercase tracking-tight lg:text-3xl">{{ featuredNews.title }}</h3>
                <p class="mt-2 max-w-md text-[13px] text-white/40">{{ featuredNews.excerpt }}</p>
                <time class="mt-4 text-[11px] text-white/20">{{ formatDate(featuredNews.published_at) }}</time>
              </div>
            </div>
          </NuxtLink>

          <!-- Side stack — 4 cols -->
          <div class="flex flex-col gap-4 lg:col-span-4">
            <NuxtLink v-for="item in sideNews" :key="item.id" :to="`/news/${item.slug}`"
              class="group flex-1 overflow-hidden rounded-xl border border-white/[0.04] bg-white/[0.02] transition-colors hover:border-white/[0.08]">
              <div v-if="item.image_url" class="h-28 bg-cover bg-center" :style="{ backgroundImage: `url(${item.image_url})` }">
                <div class="h-full bg-gradient-to-t from-surface to-transparent" />
              </div>
              <div class="p-5" :class="!item.image_url && 'pt-5'">
                <span class="text-[10px] font-bold uppercase tracking-widest text-red-500/50">{{ item.tag }}</span>
                <h3 class="mt-1 font-display text-[15px] font-bold leading-snug uppercase tracking-tight transition-colors group-hover:text-red-400">{{ item.title }}</h3>
                <p class="mt-1 text-[12px] text-white/25 line-clamp-2">{{ item.excerpt }}</p>
                <time class="mt-2 block text-[11px] text-white/15">{{ formatDate(item.published_at) }}</time>
              </div>
            </NuxtLink>
          </div>
        </div>
      </div>
    </section>

    <!-- RANKINGS -->
    <section id="stats" class="relative border-t border-white/[0.04] py-28 lg:py-40">
      <div class="relative mx-auto max-w-[1200px] px-6">
        <div class="mb-10 flex flex-wrap items-end justify-between gap-4">
          <h2 v-reveal class="font-display text-3xl font-extrabold uppercase tracking-tighter lg:text-4xl">{{ t('rankings.title') }}</h2>
          <div class="flex">
            <button v-for="tab in rankingTabs" :key="tab.key"
              :class="['border-b-2 px-5 pb-2 text-[12px] font-bold uppercase tracking-widest transition-all',
                activeTab === tab.key ? 'border-red-500 text-white' : 'border-transparent text-white/25 hover:text-white/50']"
              @click="activeTab = tab.key">{{ t(tab.labelKey) }}</button>
          </div>
        </div>

        <table class="w-full">
          <thead>
            <tr class="border-b border-white/[0.06]">
              <th class="py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15">#</th>
              <th class="py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15">{{ t('rankings.character') }}</th>
              <th class="hidden py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15 sm:table-cell">{{ t('rankings.race') }}</th>
              <th class="hidden py-3 pr-4 text-left text-[10px] font-bold uppercase tracking-widest text-white/15 md:table-cell">{{ t('rankings.class') }}</th>
              <th class="py-3 text-right text-[10px] font-bold uppercase tracking-widest text-white/15">{{ activeTab === 'online' ? t('rankings.status') : t('rankings.score') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(p, i) in rankings" :key="i" class="border-b border-white/[0.03] transition-colors hover:bg-white/[0.015]">
              <td class="py-4 pr-4"><span :class="['font-display text-lg font-extrabold tabular-nums', i < 3 ? 'text-red-500' : 'text-white/15']">{{ String(i+1).padStart(2,'0') }}</span></td>
              <td class="py-4 pr-4 text-[14px] font-medium">{{ p.name }}</td>
              <td class="hidden py-4 pr-4 text-[13px] text-white/30 sm:table-cell">{{ p.race }}</td>
              <td class="hidden py-4 pr-4 text-[13px] text-white/30 md:table-cell">{{ p.class }}</td>
              <td class="py-4 text-right font-display text-[14px] font-bold tabular-nums text-red-400/70">{{ p.score }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- SIEGE -->
    <section id="siege" class="relative overflow-hidden py-28 lg:py-40">

      <div class="relative mx-auto max-w-[900px] px-6">
        <h2 v-reveal class="mb-12 text-center font-display text-3xl font-extrabold uppercase tracking-tighter lg:text-4xl">{{ t('siege.title') }}</h2>

        <div class="space-y-1">
          <div v-for="s in siegeSchedule" :key="s.name"
            class="flex items-center justify-between border-b border-white/[0.04] py-5 transition-colors hover:bg-white/[0.02]">
            <div>
              <span class="font-display text-[15px] font-bold uppercase tracking-wider">{{ s.name }}</span>
              <span class="ml-3 text-[12px] text-white/20">{{ s.location }}</span>
            </div>
            <div class="flex items-center gap-4">
              <span class="text-[12px] text-white/20">{{ s.day }}</span>
              <span class="bg-red-600/15 px-3 py-1 text-[12px] font-bold tabular-nums text-red-400">{{ s.time }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- COMMUNITY -->
    <section class="relative border-t border-white/[0.04] py-28 lg:py-36">
      <div class="mx-auto flex max-w-[1200px] flex-col items-center gap-12 px-6 md:flex-row md:gap-20">
        <!-- Discord mockup -->
        <div class="w-full max-w-sm rounded-lg bg-[#5865F2]/10 p-8 ring-1 ring-[#5865F2]/20">
          <svg class="mb-4 h-8 w-8 text-[#5865F2]" viewBox="0 0 24 24" fill="currentColor"><path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994a.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03z" /></svg>
          <div class="space-y-2">
            <div v-for="msg in discordPreview" :key="msg.name" class="flex items-start gap-2.5">
              <div :class="['h-6 w-6 shrink-0 rounded-full', msg.color]" />
              <div>
                <span class="text-[11px] font-bold" :class="msg.nameColor">{{ msg.name }}</span>
                <p class="text-[12px] leading-snug text-white/30">{{ msg.text }}</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Text -->
        <div class="max-w-md">
          <h2 class="font-display text-3xl font-extrabold uppercase tracking-tighter lg:text-4xl">{{ t('community.title') }}</h2>
          <p class="mt-3 text-[14px] leading-relaxed text-white/35">{{ t('community.desc') }}</p>
          <a href="#" class="mt-6 inline-block bg-[#5865F2] px-6 py-3 text-[12px] font-bold uppercase tracking-widest text-white transition-all hover:bg-[#4752C4] active:scale-[0.97]">
            {{ t('community.cta') }}
          </a>
        </div>
      </div>
    </section>

    <!-- DOWNLOAD -->
    <section class="relative overflow-hidden border-t border-white/[0.04] py-28 lg:py-36">

      <div class="relative mx-auto max-w-[1200px] px-6">
        <div class="flex flex-col items-start gap-14 lg:flex-row lg:gap-20">
          <!-- Left: download CTA -->
          <div class="max-w-lg flex-1">
            <h2 v-reveal class="font-display text-3xl font-extrabold uppercase tracking-tighter lg:text-4xl">{{ t('download.title') }}</h2>
            <p class="mt-3 text-[14px] text-white/30">{{ t('download.launcher') }}</p>
            <div class="mt-8 flex flex-wrap items-center gap-4">
              <a href="#"
                class="inline-flex items-center gap-3 bg-red-600 px-8 py-4 font-display text-[13px] font-bold uppercase tracking-widest text-white transition-all hover:bg-red-500 hover:shadow-[0_0_40px_rgba(220,60,60,0.25)] active:scale-[0.97]">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                {{ t('download.cta') }}
              </a>
              <span class="text-[12px] text-white/20">{{ t('download.size') }}</span>
            </div>
          </div>

          <!-- Right: system requirements -->
          <div class="w-full max-w-xs">
            <h3 class="mb-4 text-[11px] font-bold uppercase tracking-[0.3em] text-red-500/60">{{ t('download.req') }}</h3>
            <div class="space-y-3">
              <div v-for="req in sysReqs" :key="req.labelKey" class="flex items-start gap-3 border-t border-white/[0.04] pt-3">
                <span class="text-[10px] font-bold uppercase tracking-wider text-white/15">{{ req.label }}</span>
                <span class="text-[13px] text-white/40">{{ t(req.valueKey) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="relative border-t border-white/[0.04] py-28 lg:py-36">
      <div class="mx-auto max-w-[760px] px-6">
        <h2 v-reveal class="mb-12 text-center font-display text-3xl font-extrabold uppercase tracking-tighter lg:text-4xl">{{ t('faq.title') }}</h2>

        <div class="space-y-1">
          <div v-for="(faq, i) in faqs" :key="i" class="border-b border-white/[0.04]">
            <button
              class="flex w-full items-center justify-between py-5 text-left transition-colors hover:text-white"
              @click="openFaq === i ? openFaq = -1 : openFaq = i">
              <span class="pr-4 font-display text-[15px] font-bold uppercase tracking-wider">{{ t(faq.qKey) }}</span>
              <svg :class="['h-4 w-4 shrink-0 text-white/20 transition-transform duration-300',
                openFaq === i ? 'rotate-45' : '']"
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
    </section>

    <!-- CTA — background image is primary -->
    <section class="relative overflow-hidden py-40 lg:py-52">
      <div class="absolute inset-0 bg-[url('/img/bg_waterfall.jpg')] bg-cover bg-center" />
      <div class="absolute inset-0 bg-gradient-to-t from-surface via-surface/50 to-surface/70" />

      <div class="relative mx-auto max-w-xl px-6 text-center">
        <h2 class="font-display text-4xl font-extrabold uppercase tracking-tighter lg:text-6xl">
          {{ t('cta.title1') }}<br><span class="text-red-500">{{ t('cta.title2') }}</span>
        </h2>
        <p class="mx-auto mt-4 max-w-sm text-[14px] italic text-white/30">{{ t('cta.desc') }}</p>
        <NuxtLink to="/register"
          class="mt-10 inline-block bg-red-600 px-10 py-4 font-display text-[13px] font-bold uppercase tracking-widest text-white transition-all hover:bg-red-500 hover:shadow-[0_0_50px_rgba(220,60,60,0.3)] active:scale-[0.97]">
          {{ t('cta.button') }}
        </NuxtLink>
      </div>
    </section>

  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'default' })

const { locale, t } = useI18n()
const activeTab = ref('pvp')
const openFaq = ref(-1)

// Scroll reveal directive
const vReveal = {
  mounted(el: HTMLElement) {
    el.style.opacity = '0'
    el.style.transform = 'translateY(32px)'
    el.style.transition = 'opacity 0.8s cubic-bezier(0.32,0.72,0,1), transform 0.8s cubic-bezier(0.32,0.72,0,1)'
    const obs = new IntersectionObserver(([e]) => {
      if (e.isIntersecting) {
        el.style.opacity = '1'
        el.style.transform = 'translateY(0)'
        obs.disconnect()
      }
    }, { threshold: 0.15 })
    obs.observe(el)
  },
}


const serverStatus = reactive({ online: 347 })
const serverStats = [
  { value: '347', key: 'stats.online' },
  { value: '2,418', key: 'stats.accounts' },
  { value: '3.9', key: 'stats.patch' },
  { value: '99.7%', key: 'stats.uptime' },
]

const steps = [
  { titleKey: 'steps.1.title', descKey: 'steps.1.desc', link: '/register', linkLabel: t('steps.1.linkLabel') },
  { titleKey: 'steps.2.title', descKey: 'steps.2.desc', link: null, linkLabel: 'Download' },
  { titleKey: 'steps.3.title', descKey: 'steps.3.desc', link: null, linkLabel: null },
]

const factionData = reactive({ elyos: 189, asmodians: 158 })

const discordPreview = [
  { name: 'Lumiel', text: 'LFG Dredgion, need healer', color: 'bg-sky-500', nameColor: 'text-sky-400' },
  { name: 'Shadowbane', text: 'GG siege, Asmo took Divine', color: 'bg-red-500', nameColor: 'text-red-400' },
  { name: 'Celestia', text: 'Selling Balic crafts, PM me', color: 'bg-emerald-500', nameColor: 'text-emerald-400' },
  { name: 'Ironwing', text: 'New patch when?', color: 'bg-amber-500', nameColor: 'text-amber-400' },
]

// --- Siege countdown ---
const siegeEvents = [
  { name: 'Divine Fortress', day: 6, hour: 22 }, // Saturday 22:00
  { name: 'Divine Fortress', day: 0, hour: 22 }, // Sunday 22:00
  { name: 'Krotan Refuge', day: 1, hour: 20 },
  { name: 'Kysis Fortress', day: 2, hour: 20 },
  { name: 'Miren Fortress', day: 3, hour: 20 },
  { name: 'Sulfur Fortress', day: 4, hour: 18 },
  { name: 'Krotan Refuge', day: 5, hour: 20 },
]

const nextSiege = reactive({ name: 'Divine Fortress', ms: 0 })
const countdownUnits = ref([
  { label: '', value: 0 },
  { label: '', value: 0 },
  { label: '', value: 0 },
  { label: '', value: 0 },
])

function updateCountdown() {
  const now = new Date()
  let closest = Infinity
  let closestName = ''
  for (const ev of siegeEvents) {
    const target = new Date(now)
    target.setHours(ev.hour, 0, 0, 0)
    const diff = ((ev.day - now.getDay() + 7) % 7) * 86400000
    target.setTime(target.getTime() + diff)
    if (target.getTime() <= now.getTime()) target.setTime(target.getTime() + 7 * 86400000)
    const ms = target.getTime() - now.getTime()
    if (ms < closest) { closest = ms; closestName = ev.name }
  }
  nextSiege.name = closestName
  nextSiege.ms = closest
  const s = Math.floor(closest / 1000)
  countdownUnits.value = [
    { label: t('timer.days'), value: Math.floor(s / 86400) },
    { label: t('timer.hours'), value: Math.floor((s % 86400) / 3600) },
    { label: t('timer.min'), value: Math.floor((s % 3600) / 60) },
    { label: t('timer.sec'), value: s % 60 },
  ]
}

let countdownInterval: ReturnType<typeof setInterval>
onMounted(() => {
  updateCountdown()
  countdownInterval = setInterval(updateCountdown, 1000)
})
onUnmounted(() => clearInterval(countdownInterval))

// --- Class picker ---
const selectedClass = ref(1)

interface AionClass {
  id: number
  name: string
  role: string
  description: string
  hasIcon: boolean
  iconId: number
  gradient: string
  stats: { name: string; value: number }[]
}

const aionClasses: AionClass[] = [
  { id: 1, name: 'Gladiator', role: 'Melee DPS', hasIcon: false, iconId: 1, gradient: 'radial-gradient(circle at 30% 40%, #4a1a1a 0%, #1a0a0a 70%)', description: 'A master of polearms and greatswords. Devastating AoE damage dealer in the heart of battle. High burst, medium survivability — the frontline brawler every group wants.', stats: [{ name: 'Attack', value: 9 }, { name: 'Defense', value: 5 }, { name: 'Difficulty', value: 4 }] },
  { id: 2, name: 'Templar', role: 'Tank', hasIcon: false, iconId: 2, gradient: 'radial-gradient(circle at 30% 40%, #1a2a4a 0%, #0a0a1a 70%)', description: 'Shield-bearing guardian who absorbs punishment and controls the fight. The backbone of any PvE group and fortress defense. Pulls, stuns, and refuses to die.', stats: [{ name: 'Attack', value: 4 }, { name: 'Defense', value: 10 }, { name: 'Difficulty', value: 5 }] },
  { id: 3, name: 'Assassin', role: 'Melee Burst', hasIcon: false, iconId: 3, gradient: 'radial-gradient(circle at 30% 40%, #2a1a3a 0%, #0e0a12 70%)', description: 'Stealth killer who opens from the shadows and deletes targets in seconds. The most feared class in open-world PvP. High skill ceiling, massive reward.', stats: [{ name: 'Attack', value: 10 }, { name: 'Defense', value: 3 }, { name: 'Difficulty', value: 8 }] },
  { id: 4, name: 'Ranger', role: 'Ranged DPS', hasIcon: true, iconId: 4, gradient: 'radial-gradient(circle at 30% 40%, #1a3a1a 0%, #0a140a 70%)', description: 'Master of the bow with traps and snares. Controls distance, kites melee, and delivers sustained ranged damage. Essential in siege defense.', stats: [{ name: 'Attack', value: 8 }, { name: 'Defense', value: 4 }, { name: 'Difficulty', value: 6 }] },
  { id: 5, name: 'Sorcerer', role: 'Magic Burst', hasIcon: false, iconId: 5, gradient: 'radial-gradient(circle at 30% 40%, #3a1a3a 0%, #140a14 70%)', description: 'Pure destruction caster. Massive single-target and AoE spells that melt anything in range. Glass cannon — devastating when protected, vulnerable when caught.', stats: [{ name: 'Attack', value: 10 }, { name: 'Defense', value: 2 }, { name: 'Difficulty', value: 7 }] },
  { id: 6, name: 'Spirit Master', role: 'Pet / CC', hasIcon: false, iconId: 6, gradient: 'radial-gradient(circle at 30% 40%, #1a2a3a 0%, #0a1018 70%)', description: 'Summoner who commands elemental spirits while locking down enemies with fears and debuffs. Unique playstyle that dominates 1v1 PvP scenarios.', stats: [{ name: 'Attack', value: 7 }, { name: 'Defense', value: 4 }, { name: 'Difficulty', value: 9 }] },
  { id: 7, name: 'Cleric', role: 'Healer', hasIcon: true, iconId: 7, gradient: 'radial-gradient(circle at 30% 40%, #3a3a1a 0%, #18140a 70%)', description: 'The primary healer. Keeps the group alive through massive heals and protective buffs. Also capable of decent damage. Always in demand, never alone.', stats: [{ name: 'Attack', value: 5 }, { name: 'Defense', value: 7 }, { name: 'Difficulty', value: 6 }] },
  { id: 8, name: 'Chanter', role: 'Support / Hybrid', hasIcon: true, iconId: 8, gradient: 'radial-gradient(circle at 30% 40%, #2a2a1a 0%, #12100a 70%)', description: 'Melee support who empowers the entire group with mantras and buffs. Heals, hits, and boosts. The glue that turns a good group into an unstoppable one.', stats: [{ name: 'Attack', value: 6 }, { name: 'Defense', value: 6 }, { name: 'Difficulty', value: 5 }] },
]

const activeClass = computed(() => aionClasses.find(c => c.id === selectedClass.value) || aionClasses[0])

const allFeatures = [
  { titleKey: 'feat.classic.title', descKey: 'feat.classic.desc' },
  { titleKey: 'feat.pvp.title', descKey: 'feat.pvp.desc' },
  { titleKey: 'feat.fair.title', descKey: 'feat.fair.desc' },
  { titleKey: 'feat.rates.title', descKey: 'feat.rates.desc' },
  { titleKey: 'feat.servers.title', descKey: 'feat.servers.desc' },
  { titleKey: 'feat.team.title', descKey: 'feat.team.desc' },
]

const { $api } = useApi()
const { full: formatDate } = useDate()
const { data: newsData } = useAsyncData('home-news', () => $api<{ data: Array<{ id: number; slug: string; tag: string; title: string; excerpt: string; image_url: string | null; published_at: string }> }>('/news?per_page=4'))
const featuredNews = computed(() => newsData.value?.data?.[0] ?? null)
const sideNews = computed(() => (newsData.value?.data ?? []).slice(1, 4))

const rankingTabs = [
  { key: 'pvp', labelKey: 'tab.pvp' },
  { key: 'abyss', labelKey: 'tab.abyss' },
  { key: 'online', labelKey: 'tab.online' },
]

const rankingData: Record<string, { name: string; race: string; class: string; score: string }[]> = {
  pvp: [
    { name: 'Shadowbane', race: 'Asmodian', class: 'Assassin', score: '14,230' },
    { name: 'Lumiel', race: 'Elyos', class: 'Sorcerer', score: '12,845' },
    { name: 'Voidwalker', race: 'Asmodian', class: 'Ranger', score: '11,392' },
    { name: 'Aethergale', race: 'Elyos', class: 'Spirit Master', score: '10,104' },
    { name: 'Ironwing', race: 'Asmodian', class: 'Gladiator', score: '9,876' },
  ],
  abyss: [
    { name: 'Lumiel', race: 'Elyos', class: 'Sorcerer', score: '2,340,120' },
    { name: 'Shadowbane', race: 'Asmodian', class: 'Assassin', score: '2,100,430' },
    { name: 'Ironwing', race: 'Asmodian', class: 'Gladiator', score: '1,890,003' },
    { name: 'Celestia', race: 'Elyos', class: 'Cleric', score: '1,650,217' },
    { name: 'Darkflame', race: 'Asmodian', class: 'Sorcerer', score: '1,420,891' },
  ],
  online: [
    { name: 'Voidwalker', race: 'Asmodian', class: 'Ranger', score: 'Online' },
    { name: 'Lumiel', race: 'Elyos', class: 'Sorcerer', score: 'Online' },
    { name: 'Celestia', race: 'Elyos', class: 'Cleric', score: 'Online' },
    { name: 'Ironwing', race: 'Asmodian', class: 'Gladiator', score: 'Online' },
    { name: 'Frostweaver', race: 'Elyos', class: 'Chanter', score: 'Online' },
  ],
}

const rankings = computed(() => rankingData[activeTab.value] || [])

const siegeSchedule = [
  { name: 'Divine Fortress', location: 'Core Abyss', time: '20:00', day: 'Saturday' },
  { name: 'Sulfur Fortress', location: 'Upper Abyss', time: '21:00', day: 'Wednesday' },
  { name: 'Krotan Refuge', location: 'Lower Abyss', time: '20:30', day: 'Friday' },
  { name: 'Kysis Fortress', location: 'Lower Abyss', time: '19:00', day: 'Sunday' },
  { name: 'Miren Fortress', location: 'Lower Abyss', time: '21:30', day: 'Tuesday' },
]

const sysReqs = [
  { label: 'OS', valueKey: 'download.os' },
  { label: 'CPU', valueKey: 'download.cpu' },
  { label: 'RAM', valueKey: 'download.ram' },
  { label: 'GPU', valueKey: 'download.gpu' },
]

const faqs = [
  { qKey: 'faq.q1', aKey: 'faq.a1' },
  { qKey: 'faq.q2', aKey: 'faq.a2' },
  { qKey: 'faq.q3', aKey: 'faq.a3' },
  { qKey: 'faq.q4', aKey: 'faq.a4' },
  { qKey: 'faq.q5', aKey: 'faq.a5' },
]
</script>
