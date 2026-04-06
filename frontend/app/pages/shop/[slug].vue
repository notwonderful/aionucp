<template>
  <div>
    <NuxtLink :to="localePath('/shop')" class="inline-flex items-center gap-2 text-[13px] font-medium text-white/25 transition-colors hover:text-white/50">
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
      {{ $t('shop.backToShop') }}
    </NuxtLink>

    <div v-if="status === 'pending'" class="mt-6 grid gap-8 lg:grid-cols-2">
      <div class="aspect-square animate-pulse rounded-xl bg-white/[0.03]" />
      <div class="space-y-4">
        <div class="h-4 w-1/4 rounded bg-white/[0.04]" />
        <div class="h-8 w-3/4 rounded bg-white/[0.04]" />
        <div class="h-20 w-full rounded bg-white/[0.04]" />
      </div>
    </div>

    <div v-else-if="!product" class="mt-16 text-center">
      <p class="text-[14px] font-medium text-white/30">{{ $t('shop.productNotFound') }}</p>
    </div>

    <div v-else class="mt-6 grid gap-8 lg:grid-cols-2">
      <div class="relative aspect-square overflow-hidden card-panel">
        <div class="absolute inset-0 flex items-center justify-center">
          <svg class="h-16 w-16 text-white/[0.05]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="0.75"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" /></svg>
        </div>
        <img
          :src="product.image_url" alt=""
          class="absolute inset-0 h-full w-full object-cover opacity-0 transition-opacity"
          @load="($event.target as HTMLImageElement).classList.remove('opacity-0')"
          @error="($event.target as HTMLImageElement).style.display = 'none'"
        />
        <div v-if="product.item_qty > 1" class="absolute right-3 top-3 rounded-lg bg-black/60 px-2.5 py-1 text-[13px] font-bold tabular-nums text-white/80 backdrop-blur-sm">
          x{{ product.item_qty }}
        </div>
      </div>

      <div class="flex flex-col">
        <span v-if="product.category" class="mb-3 inline-flex w-fit rounded-md bg-white/[0.04] px-2 py-1 text-[11px] font-medium uppercase tracking-wider text-white/25">
          {{ product.category.name }}
        </span>

        <h1 class="font-display text-2xl font-extrabold uppercase tracking-tight lg:text-3xl">{{ product.name }}</h1>

        <p v-if="product.description" class="mt-3 text-[14px] leading-relaxed text-white/30">{{ product.description }}</p>

        <div class="mt-6 flex items-center gap-4 card-panel p-5">
          <div>
            <div class="text-[11px] font-medium uppercase tracking-widest text-white/20">{{ $t('shop.price') }}</div>
            <div class="mt-1 font-display text-3xl font-extrabold tabular-nums text-red-400">{{ product.toll }}</div>
            <div class="mt-0.5 text-[11px] text-white/15">{{ $t('common.tollPoints') }}</div>
          </div>
          <div class="h-10 w-px bg-white/[0.06]" />
          <div>
            <div class="text-[11px] font-medium uppercase tracking-widest text-white/20">{{ $t('shop.sold') }}</div>
            <div class="mt-1 font-display text-xl font-bold tabular-nums text-white/50">{{ product.sales_count }}</div>
            <div class="mt-0.5 text-[11px] text-white/15">{{ $t('shop.times') }}</div>
          </div>
        </div>

        <div class="mt-6">
          <label class="mb-1.5 block text-[12px] font-medium text-white/40">{{ $t('shop.sendToCharacter') }}</label>
          <select
            v-model="selectedPlayerId"
            class="w-full appearance-none rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-3 text-[14px] text-white outline-none transition-all duration-300 focus:border-red-500/30 focus:bg-white/[0.05] focus:ring-1 focus:ring-red-500/20"
          >
            <option value="" disabled class="bg-surface-overlay text-white/40">{{ $t('shop.selectCharacter') }}</option>
            <option v-for="player in players" :key="player.id" :value="player.id" class="bg-surface-overlay">
              {{ player.name }} — {{ player.player_class }}
            </option>
          </select>
          <p v-if="players.length === 0 && status !== 'pending'" class="mt-1.5 text-[12px] text-white/20">
            {{ $t('shop.noCharactersFound') }}
          </p>
        </div>

        <AppButton :loading="purchasing" :loading-text="$t('donate.processing')" :disabled="!selectedPlayerId" block @click="showConfirm = true">{{ $t('shop.purchaseFor', { amount: product.toll }) }}</AppButton>

        <AlertMessage :message="successMessage" variant="success" />
        <AlertMessage :message="errorMessage" variant="error" />
      </div>
    </div>

    <!-- Similar products -->
    <div v-if="product && relatedProducts.length" class="mt-12">
      <h2 class="mb-5 font-display text-lg font-bold uppercase tracking-wider">{{ $t('shop.similarItems') }}</h2>
      <div class="grid gap-4 sm:grid-cols-2">
        <NuxtLink
          v-for="item in relatedProducts" :key="item.id"
          :to="`/shop/${item.slug}`"
          class="group overflow-hidden card-panel transition-all duration-300 hover:border-white/[0.08] hover:bg-white/[0.03]"
        >
          <div class="relative overflow-hidden border-b border-white/[0.04] bg-gradient-to-br from-red-950/20 via-surface-card to-surface" style="aspect-ratio: 4/3">
            <div class="absolute inset-0 flex items-center justify-center">
              <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/[0.06] bg-white/[0.03]">
                <svg class="h-5 w-5 text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" /></svg>
              </div>
            </div>
            <img
              :src="item.image_url" alt=""
              class="absolute inset-0 h-full w-full object-cover opacity-0 transition-all duration-500 group-hover:scale-105"
              @load="($event.target as HTMLImageElement).classList.remove('opacity-0')"
              @error="($event.target as HTMLImageElement).style.display = 'none'"
            />
            <div v-if="item.category" class="absolute bottom-2 left-2 rounded-md bg-black/50 px-2 py-0.5 text-[10px] font-medium uppercase tracking-wider text-white/50 backdrop-blur-sm">
              {{ item.category.name }}
            </div>
          </div>
          <div class="p-3.5">
            <div class="truncate text-[13px] font-semibold leading-tight transition-colors group-hover:text-white">{{ item.name }}</div>
            <div class="mt-2 flex items-baseline gap-1">
              <span class="font-display text-[15px] font-bold tabular-nums text-red-400">{{ item.toll }}</span>
              <span class="text-[10px] font-medium uppercase tracking-wider text-red-400/40">{{ $t('common.toll') }}</span>
            </div>
          </div>
        </NuxtLink>
      </div>
    </div>

    <AppModal :open="showConfirm" :title="$t('shop.confirmPurchase')" @close="showConfirm = false">
      <template #icon>
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-600/10">
          <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
        </div>
      </template>

      <div class="space-y-3 rounded-lg border border-white/[0.04] bg-white/[0.02] p-4">
        <div class="flex items-center justify-between">
          <span class="text-[12px] text-white/30">{{ $t('shop.item') }}</span>
          <span class="text-[13px] font-semibold">{{ product?.name }}</span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-[12px] text-white/30">{{ $t('shop.quantity') }}</span>
          <span class="text-[13px] font-medium text-white/60">x{{ product?.item_qty }}</span>
        </div>
        <div class="h-px bg-white/[0.04]" />
        <div class="flex items-center justify-between">
          <span class="text-[12px] text-white/30">{{ $t('shop.price') }}</span>
          <span class="font-display text-[15px] font-bold tabular-nums text-red-400">{{ product?.toll }} {{ $t('common.toll') }}</span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-[12px] text-white/30">{{ $t('shop.recipient') }}</span>
          <span class="text-[13px] font-medium text-white/60">{{ selectedPlayerName }}</span>
        </div>
      </div>

      <template #footer>
        <AppButton variant="secondary" @click="showConfirm = false">{{ $t('common.cancel') }}</AppButton>
        <AppButton :loading="purchasing" :loading-text="$t('donate.processing')" @click="handlePurchase">{{ $t('common.confirm') }}</AppButton>
      </template>
    </AppModal>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'auth' })

interface Category { id: number; name: string; slug: string; parent_id: number | null }
interface Product { id: number; name: string; slug: string; description: string; toll: number; item_id: number; item_qty: number; image_url: string; sales_count: number; category: Category | null }
interface Player { id: number; name: string; race: string; player_class: string; online: boolean }

const { t } = useI18n()
const localePath = useLocalePath()
const route = useRoute()
const { $api } = useApi()
const { fetchUser } = useAuth()
const { submit: purchaseSubmit, loading: purchasing, successMsg: successMessage, errorMsg: errorMessage } = useFormSubmit()

const { data: shopData, status } = useAsyncData('shop', () =>
  $api<{ data: { products: Product[]; players: Player[] } }>('/shop'),
)

const product = computed(() =>
  shopData.value?.data?.products?.find(p => p.slug === route.params.slug) ?? null,
)

const players = computed(() => shopData.value?.data?.players ?? [])

const relatedProducts = computed(() => {
  if (!product.value?.category) return []
  return (shopData.value?.data?.products ?? [])
    .filter(p => p.id !== product.value!.id && p.category?.id === product.value!.category!.id)
    .slice(0, 2)
})

const selectedPlayerId = ref<number | ''>('')
const selectedPlayerName = computed(() =>
  players.value.find(p => p.id === Number(selectedPlayerId.value))?.name ?? '',
)

const showConfirm = ref(false)

async function handlePurchase() {
  if (!product.value || !selectedPlayerId.value) return
  await purchaseSubmit(async (api) => {
    await api(`/shop/${product.value!.id}/buy`, { method: 'POST', body: { player_id: Number(selectedPlayerId.value) } })
    showConfirm.value = false
    await fetchUser()
    return t('shop.sentTo', { item: product.value!.name, character: selectedPlayerName.value })
  }, t('shop.purchaseFailed'))
  showConfirm.value = false
}

onMounted(() => {
  const onEsc = (e: KeyboardEvent) => { if (e.key === 'Escape') showConfirm.value = false }
  document.addEventListener('keydown', onEsc)
  onUnmounted(() => document.removeEventListener('keydown', onEsc))
})

watch(showConfirm, (open) => {
  document.body.style.overflow = open ? 'hidden' : ''
})
</script>

