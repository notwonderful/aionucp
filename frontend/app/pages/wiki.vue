<template>
  <div class="text-white">

    <!-- Header -->
    <div class="relative overflow-hidden pt-28 pb-16">
      <div class="absolute inset-0 bg-[url('/img/bg_waterfall.jpg')] bg-cover bg-center opacity-[0.06]" />
      <div class="absolute inset-0 bg-gradient-to-b from-surface via-transparent to-surface" />
      <img src="/img/wing.png" alt="" class="pointer-events-none absolute -right-10 top-10 hidden h-[200px] rotate-[-10deg] object-contain opacity-[0.05] lg:block" />
      <div class="relative mx-auto max-w-[1280px] px-6">
        <h1 class="font-display text-5xl font-extrabold uppercase tracking-tighter lg:text-7xl">{{ t('wiki.title') }}</h1>
        <p class="mt-3 max-w-md text-[15px] text-white/30">{{ t('wiki.desc') }}</p>
      </div>
    </div>

    <!-- Content: sidebar + main -->
    <div class="mx-auto flex max-w-[1280px] gap-10 px-6 pb-24 lg:gap-16">

      <!-- Sidebar nav -->
      <aside class="hidden w-[200px] shrink-0 lg:block">
        <div class="sticky top-24 space-y-1">
          <button v-for="cat in wikiCategories" :key="cat.slug"
            :class="['flex w-full items-center gap-2 rounded-lg px-3 py-2.5 text-left text-[13px] font-medium transition-all duration-300',
              activeCat === cat.slug
                ? 'bg-red-600/10 text-red-400'
                : 'text-white/30 hover:bg-white/[0.03] hover:text-white/60']"
            @click="activeCat = cat.slug">
            <span :class="['h-1.5 w-1.5 rounded-full transition-colors', activeCat === cat.slug ? 'bg-red-500' : 'bg-white/10']" />
            {{ cat.name }}
          </button>
        </div>
      </aside>

      <!-- Mobile category selector -->
      <div class="flex flex-wrap gap-1.5 lg:hidden mb-6">
        <button v-for="cat in wikiCategories" :key="cat.slug"
          :class="['rounded-lg px-3 py-2 text-[12px] font-medium transition-all',
            activeCat === cat.slug ? 'bg-red-600/10 text-red-400' : 'text-white/30 hover:text-white/50']"
          @click="activeCat = cat.slug">
          {{ cat.name }}
        </button>
      </div>

      <!-- Main content -->
      <main class="min-w-0 flex-1 space-y-8">
        <template v-for="entry in activeEntries" :key="entry.id">
          <div v-if="entry.type === 'text'" class="prose-wiki text-[14px] leading-relaxed text-white/35" v-html="entry.content.body" />

          <WikiCallout v-else-if="entry.type === 'callout'" :type="String(entry.content.callout_type) as any">
            <span v-html="entry.content.body" />
          </WikiCallout>

          <WikiSection v-else-if="entry.type === 'table'" :title="String(entry.content.title)">
            <WikiTable :rows="entry.content.rows as string[][]" />
          </WikiSection>

          <WikiSpoiler v-else-if="entry.type === 'spoiler'" :title="String(entry.content.title)">
            <div class="prose-wiki text-[13px] leading-relaxed text-white/35" v-html="entry.content.body" />
          </WikiSpoiler>
        </template>

        <div v-if="!activeEntries.length" class="py-12 text-center text-[14px] text-white/20">
          {{ t('common.noData') }}
        </div>
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'default' })

const { t } = useI18n()
const { $api } = useApi()

interface WikiEntry {
  id: number
  type: string
  content: Record<string, unknown>
  sort_order: number
}

interface WikiCat {
  id: number
  name: string
  slug: string
  entries: WikiEntry[]
}

const { data: wikiData } = useAsyncData('wiki', () => $api<{ data: WikiCat[] }>('/wiki'))

const wikiCategories = computed(() => wikiData.value?.data ?? [])
const activeCat = ref('')

watch(wikiCategories, (cats) => {
  if (cats.length && !activeCat.value) activeCat.value = cats[0].slug
}, { immediate: true })

const activeEntries = computed(() =>
  wikiCategories.value.find(c => c.slug === activeCat.value)?.entries ?? []
)
</script>
