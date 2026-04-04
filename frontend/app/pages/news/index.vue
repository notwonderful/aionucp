<template>
  <div class="text-white">
    <!-- Header -->
    <div class="relative overflow-hidden pt-28 pb-12">
      <div class="absolute inset-0 bg-[url('/img/bg_waterfall.jpg')] bg-cover bg-center opacity-[0.04]" />
      <div class="relative mx-auto max-w-[1200px] px-6">
        <h1 class="font-display text-5xl font-extrabold uppercase tracking-tighter lg:text-7xl">{{ lang === 'ru' ? 'Новости' : 'News' }}</h1>
        <p class="mt-3 max-w-md text-[15px] text-white/30">{{ lang === 'ru' ? 'Обновления, патчи, события и гайды.' : 'Updates, patches, events, and guides.' }}</p>
      </div>
    </div>

    <!-- Articles -->
    <div class="mx-auto max-w-[1200px] px-6 pb-24">
      <!-- Featured (first article) -->
      <NuxtLink :to="`/news/${featured.slug}`" class="group mb-8 block overflow-hidden rounded-xl border border-white/[0.04]">
        <div class="grid lg:grid-cols-2">
          <div class="h-56 bg-cover bg-center lg:h-auto" :style="featured.image ? { backgroundImage: `url(${featured.image})` } : {}"
            :class="!featured.image && 'bg-gradient-to-br from-red-950/30 to-surface'" />
          <div class="flex flex-col justify-center p-8 lg:p-10">
            <div class="flex items-center gap-3">
              <span class="rounded bg-red-600/15 px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest text-red-400">{{ featured.tag }}</span>
              <time class="text-[12px] text-white/20">{{ formatDate(featured.date) }}</time>
            </div>
            <h2 class="mt-3 font-display text-2xl font-extrabold uppercase tracking-tight transition-colors duration-300 group-hover:text-red-400 lg:text-3xl">{{ featured.title }}</h2>
            <p class="mt-3 text-[14px] leading-relaxed text-white/35">{{ featured.excerpt }}</p>
            <span class="mt-5 text-[12px] font-bold uppercase tracking-widest text-red-500/60 transition-colors group-hover:text-red-400">{{ lang === 'ru' ? 'Читать' : 'Read more' }} &rarr;</span>
          </div>
        </div>
      </NuxtLink>

      <!-- Rest of articles -->
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <NuxtLink v-for="article in rest" :key="article.id" :to="`/news/${article.slug}`"
          class="group overflow-hidden rounded-xl border border-white/[0.04] bg-white/[0.02] transition-colors duration-300 hover:border-white/[0.08]">
          <div class="h-40 bg-cover bg-center" :style="article.image ? { backgroundImage: `url(${article.image})` } : {}"
            :class="!article.image && 'bg-gradient-to-br from-white/[0.03] to-transparent'" />
          <div class="p-5">
            <div class="flex items-center gap-3">
              <span class="rounded bg-red-600/10 px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest text-red-400/70">{{ article.tag }}</span>
              <time class="text-[11px] text-white/15">{{ formatDate(article.date) }}</time>
            </div>
            <h3 class="mt-2 font-display text-[16px] font-bold uppercase tracking-tight leading-snug transition-colors duration-300 group-hover:text-red-400">{{ article.title }}</h3>
            <p class="mt-2 text-[13px] leading-relaxed text-white/25 line-clamp-2">{{ article.excerpt }}</p>
          </div>
        </NuxtLink>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'default' })

const { lang } = useLang()
const { getAll } = useNews()
const { full: formatDate } = useDate()

const articles = getAll()
const featured = articles[0]
const rest = articles.slice(1)
</script>
