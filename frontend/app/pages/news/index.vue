<template>
  <div class="text-white">
    <div class="relative overflow-hidden pt-28 pb-12">
      <div class="absolute inset-0 bg-[url('/img/bg_waterfall.jpg')] bg-cover bg-center opacity-[0.04]" />
      <div class="relative mx-auto max-w-[1200px] px-6">
        <h1 class="font-display text-5xl font-extrabold uppercase tracking-tighter lg:text-7xl">{{ $t('nav.news') }}</h1>
        <p class="mt-3 max-w-md text-[15px] text-white/30">{{ $t('news.subtitle') }}</p>
      </div>
    </div>

    <div class="mx-auto max-w-[1200px] px-6 pb-24">
      <div v-if="status === 'pending'" class="space-y-4">
        <div class="h-64 animate-pulse rounded-xl bg-white/[0.02]" />
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
          <div v-for="i in 3" :key="i" class="h-56 animate-pulse rounded-xl bg-white/[0.02]" />
        </div>
      </div>

      <template v-else-if="articles.length">
        <NuxtLink v-if="featured" :to="localePath(`/news/${featured.slug}`)" class="group mb-8 block overflow-hidden rounded-xl border border-white/[0.04]">
          <div class="grid lg:grid-cols-2">
            <div class="h-56 bg-cover bg-center lg:h-auto" :style="featured.image_url ? { backgroundImage: `url(${featured.image_url})` } : {}"
              :class="!featured.image_url && 'bg-gradient-to-br from-red-950/30 to-surface'" />
            <div class="flex flex-col justify-center p-8 lg:p-10">
              <div class="flex items-center gap-3">
                <span class="rounded bg-red-600/15 px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest text-red-400">{{ featured.tag }}</span>
                <time class="text-[12px] text-white/20">{{ formatDate(featured.published_at || featured.created_at) }}</time>
              </div>
              <h2 class="mt-3 font-display text-2xl font-extrabold uppercase tracking-tight transition-colors duration-300 group-hover:text-red-400 lg:text-3xl">{{ featured.title }}</h2>
              <p class="mt-3 text-[14px] leading-relaxed text-white/35">{{ featured.excerpt }}</p>
              <span class="mt-5 text-[12px] font-bold uppercase tracking-widest text-red-500/60 transition-colors group-hover:text-red-400">{{ $t('news.readMore') }} &rarr;</span>
            </div>
          </div>
        </NuxtLink>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
          <NuxtLink v-for="article in rest" :key="article.id" :to="localePath(`/news/${article.slug}`)"
            class="group overflow-hidden rounded-xl border border-white/[0.04] bg-white/[0.02] transition-colors duration-300 hover:border-white/[0.08]">
            <div class="h-40 bg-cover bg-center" :style="article.image_url ? { backgroundImage: `url(${article.image_url})` } : {}"
              :class="!article.image_url && 'bg-gradient-to-br from-white/[0.03] to-transparent'" />
            <div class="p-5">
              <div class="flex items-center gap-3">
                <span class="rounded bg-red-600/10 px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest text-red-400/70">{{ article.tag }}</span>
                <time class="text-[11px] text-white/15">{{ formatDate(article.published_at || article.created_at) }}</time>
              </div>
              <h3 class="mt-2 font-display text-[16px] font-bold uppercase tracking-tight leading-snug transition-colors duration-300 group-hover:text-red-400">{{ article.title }}</h3>
              <p class="mt-2 text-[13px] leading-relaxed text-white/25 line-clamp-2">{{ article.excerpt }}</p>
            </div>
          </NuxtLink>
        </div>
      </template>

      <div v-else class="py-20 text-center text-white/20">{{ $t('news.noNews') }}</div>

      <div v-if="meta.last_page > 1" class="mt-10 flex items-center justify-center gap-2">
        <button v-for="p in meta.last_page" :key="p" @click="page = p"
          :class="['rounded-lg px-3 py-1.5 text-[12px] font-bold transition-colors',
            page === p ? 'bg-red-600/15 text-red-400' : 'text-white/25 hover:text-white/50']">
          {{ p }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'default' })

const { $api } = useApi()
const localePath = useLocalePath()
const { full: formatDate } = useDate()

const page = ref(1)
const articles = ref<any[]>([])
const meta = ref({ last_page: 1 })
const status = ref<'pending' | 'success'>('pending')

async function fetchNews() {
  status.value = 'pending'
  try {
    const res = await $api<{ data: any[]; meta: any }>(`/news?page=${page.value}`)
    articles.value = res.data
    meta.value = res.meta ?? { last_page: 1 }
  } finally {
    status.value = 'success'
  }
}

watch(page, () => fetchNews())
onMounted(() => fetchNews())

const featured = computed(() => page.value === 1 ? articles.value[0] : null)
const rest = computed(() => page.value === 1 ? articles.value.slice(1) : articles.value)
</script>
