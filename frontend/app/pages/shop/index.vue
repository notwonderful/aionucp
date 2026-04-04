<template>
  <div>
    <div class="mb-8 flex items-end justify-between">
      <div>
        <h1 class="font-display text-2xl font-extrabold uppercase tracking-tight lg:text-3xl">{{ $t('shop.title') }}</h1>
        <p class="mt-1 text-[13px] text-white/25">{{ $t('shop.subtitle') }}</p>
      </div>
      <div class="hidden items-center gap-2 rounded-lg bg-red-600/10 px-3.5 py-2 sm:flex">
        <span class="font-display text-[15px] font-bold tabular-nums text-red-400">{{ user?.balance ?? 0 }}</span>
        <span class="text-[10px] font-medium uppercase tracking-wider text-red-400/50">{{ $t('common.toll') }}</span>
      </div>
    </div>

    <div class="mb-6 flex gap-2 overflow-x-auto pb-1 scrollbar-none">
      <button
        v-for="cat in categoryTabs" :key="cat.id ?? 'all'"
        @click="activeCategory = cat.id"
        :class="['shrink-0 rounded-lg px-4 py-2 text-[13px] font-medium transition-all duration-300',
          activeCategory === cat.id
            ? 'bg-red-600/15 text-red-400'
            : 'bg-white/[0.03] text-white/30 hover:bg-white/[0.05] hover:text-white/50']"
      >
        {{ cat.name }}
        <span v-if="cat.count !== undefined" class="ml-1.5 text-[11px] opacity-50">{{ cat.count }}</span>
      </button>
    </div>

    <div v-if="status === 'pending'" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
      <div v-for="i in 8" :key="i" class="animate-pulse rounded-xl bg-white/[0.02]">
        <div class="rounded-t-xl bg-white/[0.03]" style="aspect-ratio: 4/3" />
        <div class="space-y-2 p-4">
          <div class="h-3 w-2/3 rounded bg-white/[0.04]" />
          <div class="h-4 w-full rounded bg-white/[0.04]" />
          <div class="h-3 w-1/3 rounded bg-white/[0.04]" />
        </div>
      </div>
    </div>

    <div v-else-if="filteredProducts.length" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
      <NuxtLink
        v-for="product in filteredProducts" :key="product.id"
        :to="`/shop/${product.slug}`"
        class="group overflow-hidden rounded-xl border border-white/[0.04] bg-white/[0.02] transition-all duration-300 hover:border-white/[0.08] hover:bg-white/[0.03]"
      >
        <div class="relative overflow-hidden border-b border-white/[0.04] bg-gradient-to-br from-red-950/20 via-surface-card to-surface" style="aspect-ratio: 4/3">
          <div class="absolute inset-0 flex flex-col items-center justify-center gap-2">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl border border-white/[0.06] bg-white/[0.03]">
              <svg class="h-5 w-5 text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" /></svg>
            </div>
          </div>
          <img
            :src="product.image_url" alt=""
            class="absolute inset-0 h-full w-full object-cover opacity-0 transition-all duration-500 group-hover:scale-105"
            @load="($event.target as HTMLImageElement).classList.remove('opacity-0')"
            @error="($event.target as HTMLImageElement).style.display = 'none'"
          />
          <div v-if="product.item_qty > 1" class="absolute right-2 top-2 rounded-md bg-black/60 px-1.5 py-0.5 text-[11px] font-bold tabular-nums text-white/70 backdrop-blur-sm">
            x{{ product.item_qty }}
          </div>
          <div v-if="product.category" class="absolute bottom-2 left-2 rounded-md bg-black/50 px-2 py-0.5 text-[10px] font-medium uppercase tracking-wider text-white/50 backdrop-blur-sm">
            {{ product.category.name }}
          </div>
        </div>

        <div class="p-4">
          <div class="truncate text-[14px] font-semibold leading-tight transition-colors group-hover:text-white">{{ product.name }}</div>
          <div class="mt-2.5 flex items-baseline justify-between">
            <div class="flex items-baseline gap-1">
              <span class="font-display text-[16px] font-bold tabular-nums text-red-400">{{ product.toll }}</span>
              <span class="text-[10px] font-medium uppercase tracking-wider text-red-400/40">{{ $t('common.toll') }}</span>
            </div>
            <span v-if="product.sales_count" class="text-[11px] text-white/15">{{ product.sales_count }} {{ $t('shop.sold') }}</span>
          </div>
        </div>
      </NuxtLink>
    </div>

    <div v-else class="rounded-xl border border-white/[0.04] bg-white/[0.02] py-16 text-center">
      <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/[0.03]">
        <svg class="h-5 w-5 text-white/15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72" /></svg>
      </div>
      <p class="text-[14px] font-medium text-white/30">{{ $t('shop.noProducts') }}</p>
      <p class="mt-1 text-[12px] text-white/15">{{ $t('shop.noProductsHint') }}</p>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'auth' })

interface Category { id: number; name: string; slug: string; parent_id: number | null }
interface Product { id: number; name: string; slug: string; description: string; toll: number; item_id: number; item_qty: number; image_url: string; sales_count: number; category: Category | null }

const { t } = useI18n()
const { $api } = useApi()
const { user } = useAuth()

const { data: shopData, status } = useAsyncData('shop', () =>
  $api<{ data: { products: Product[]; players: unknown[] } }>('/shop'),
)

const allProducts = computed(() => shopData.value?.data?.products ?? [])

const categories = computed(() => {
  const map = new Map<number, Category & { count: number }>()
  for (const p of allProducts.value) {
    if (p.category && !map.has(p.category.id)) {
      map.set(p.category.id, { ...p.category, count: 0 })
    }
    if (p.category) map.get(p.category.id)!.count++
  }
  return [...map.values()]
})

const categoryTabs = computed(() => [
  { id: null, name: t('shop.all'), count: allProducts.value.length },
  ...categories.value,
])

const activeCategory = ref<number | null>(null)

const filteredProducts = computed(() =>
  activeCategory.value === null
    ? allProducts.value
    : allProducts.value.filter(p => p.category?.id === activeCategory.value),
)
</script>

<style scoped>
.scrollbar-none::-webkit-scrollbar { display: none; }
.scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }
</style>
