<template>
  <div>
    <!-- Welcome header -->
    <div class="mb-8">
      <h1 class="font-display text-2xl font-extrabold uppercase tracking-tight lg:text-3xl">
        {{ user?.name || 'Daeva' }}
      </h1>
      <p class="mt-1 text-[13px] text-white/25">{{ user?.email }}</p>
    </div>

    <!-- Stat cards -->
    <div class="grid gap-3 sm:grid-cols-3">
      <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-5">
        <div class="text-[11px] font-medium uppercase tracking-widest text-white/20">{{ $t('dashboard.balance') }}</div>
        <div class="mt-2 font-display text-3xl font-extrabold tabular-nums text-red-400">{{ user?.balance ?? 0 }}</div>
        <div class="mt-1 text-[11px] text-white/15">{{ $t('common.tollPoints') }}</div>
      </div>
      <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-5">
        <div class="text-[11px] font-medium uppercase tracking-widest text-white/20">{{ $t('dashboard.characters') }}</div>
        <div class="mt-2 font-display text-3xl font-extrabold tabular-nums text-white">{{ allPlayers.length }}</div>
        <div class="mt-1 text-[11px] text-white/15">{{ $t('dashboard.totalOnAccount') }}</div>
      </div>
      <div class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-5">
        <div class="text-[11px] font-medium uppercase tracking-widest text-white/20">{{ $t('dashboard.membership') }}</div>
        <div class="mt-2 font-display text-lg font-bold text-white/40">{{ $t('dashboard.free') }}</div>
        <div class="mt-1 text-[11px] text-white/15">{{ $t('dashboard.noSubscription') }}</div>
      </div>
    </div>

    <!-- Characters -->
    <div class="mt-10">
      <div class="mb-4 flex items-center justify-between">
        <h2 class="font-display text-lg font-bold uppercase tracking-wider">{{ $t('dashboard.characters') }}</h2>
        <span class="text-[11px] text-white/15">{{ allPlayers.length }} total</span>
      </div>

      <!-- Loading -->
      <div v-if="status === 'pending'" class="space-y-2">
        <div v-for="i in 3" :key="i" class="h-16 animate-pulse rounded-xl bg-white/[0.02]" />
      </div>

      <!-- Empty -->
      <div v-else-if="allPlayers.length === 0" class="rounded-xl border border-white/[0.04] bg-white/[0.02] py-16 text-center">
        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/[0.03]">
          <svg class="h-5 w-5 text-white/15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
        </div>
        <p class="text-[14px] font-medium text-white/30">{{ $t('dashboard.noCharactersYet') }}</p>
        <p class="mt-1 text-[12px] text-white/15">{{ $t('dashboard.createFirstCharacter') }}</p>
      </div>

      <!-- Characters list -->
      <div v-else class="space-y-1.5">
        <div v-for="player in allPlayers" :key="player.id"
          class="flex items-center justify-between rounded-xl border border-white/[0.04] bg-white/[0.02] px-5 py-4 transition-colors duration-200 hover:bg-white/[0.03]">
          <div class="flex items-center gap-4">
            <!-- Class icon -->
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/[0.03]">
              <img v-if="classIconMap[player.player_class]" :src="`/img/class/${classIconMap[player.player_class]}.png`"
                :alt="player.player_class" class="h-7 w-7 object-contain opacity-60" />
              <span v-else class="font-display text-[14px] font-extrabold text-white/15">{{ player.player_class?.charAt(0) }}</span>
            </div>
            <div>
              <div class="text-[14px] font-semibold">{{ player.name }}</div>
              <div class="mt-0.5 flex items-center gap-2 text-[11px] text-white/25">
                <span>{{ player.race }}</span>
                <span class="text-white/10">&middot;</span>
                <span>{{ player.player_class }}</span>
              </div>
            </div>
          </div>
          <div class="flex items-center gap-2">
            <span v-if="player.online" class="flex items-center gap-1.5 text-[11px] font-medium text-emerald-400">
              <span class="relative flex h-2 w-2">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75" />
                <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-400" />
              </span>
              {{ $t('common.online') }}
            </span>
            <span v-else class="text-[11px] text-white/15">{{ $t('common.offline') }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick links -->
    <div class="mt-10 grid gap-3 sm:grid-cols-3">
      <NuxtLink to="/shop"
        class="group flex items-center gap-4 rounded-xl border border-white/[0.04] bg-white/[0.02] p-5 transition-all duration-300 hover:border-white/[0.08] hover:bg-white/[0.03]">
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-600/10">
          <svg class="h-4 w-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72" /></svg>
        </div>
        <div>
          <div class="text-[14px] font-semibold transition-colors group-hover:text-red-400">{{ $t('dashboard.tollShop') }}</div>
          <div class="mt-0.5 text-[12px] text-white/20">{{ $t('dashboard.shopDesc') }}</div>
        </div>
      </NuxtLink>
      <button @click="showPromoModal = true"
        class="group flex items-center gap-4 rounded-xl border border-white/[0.04] bg-white/[0.02] p-5 text-left transition-all duration-300 hover:border-white/[0.08] hover:bg-white/[0.03]">
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gold-500/10">
          <svg class="h-4 w-4 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
        </div>
        <div>
          <div class="text-[14px] font-semibold transition-colors group-hover:text-gold-400">{{ $t('dashboard.promoCode') }}</div>
          <div class="mt-0.5 text-[12px] text-white/20">{{ $t('dashboard.promoDesc') }}</div>
        </div>
      </button>
      <NuxtLink to="/profile"
        class="group flex items-center gap-4 rounded-xl border border-white/[0.04] bg-white/[0.02] p-5 transition-all duration-300 hover:border-white/[0.08] hover:bg-white/[0.03]">
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/[0.04]">
          <svg class="h-4 w-4 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
        </div>
        <div>
          <div class="text-[14px] font-semibold transition-colors group-hover:text-white/80">{{ $t('dashboard.accountSettings') }}</div>
          <div class="mt-0.5 text-[12px] text-white/20">{{ $t('dashboard.settingsDesc') }}</div>
        </div>
      </NuxtLink>
    </div>

    <div class="mt-10 rounded-xl border border-white/[0.04] bg-white/[0.02] px-6 py-5">
      <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
        <div class="flex items-center gap-4">
          <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white/[0.04]">
            <svg class="h-5 w-5 text-white/25" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" /></svg>
          </div>
          <div>
            <div class="text-[14px] font-semibold text-white/60">{{ $t('dashboard.needHelp') }}</div>
            <div class="mt-0.5 text-[12px] text-white/20">{{ $t('dashboard.needHelpDesc') }}</div>
          </div>
        </div>
        <NuxtLink to="/tickets"
          class="shrink-0 rounded-lg border border-white/[0.06] bg-white/[0.03] px-6 py-2.5 font-display text-[12px] font-bold uppercase tracking-widest text-white/40 transition-all duration-300 hover:bg-white/[0.06] hover:text-white/60">
          {{ $t('dashboard.contactSupport') }}
        </NuxtLink>
      </div>
    </div>

    <AppModal :open="showPromoModal" :title="$t('dashboard.promoCode')" @close="closePromoModal">
      <template #icon>
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gold-500/10">
          <svg class="h-5 w-5 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
        </div>
      </template>

      <form @submit.prevent="handleActivatePromo" class="space-y-4">
        <div>
          <label class="mb-1.5 block text-[12px] font-medium text-white/40">{{ $t('dashboard.enterYourCode') }}</label>
          <input
            v-model="promoCode" type="text" required
            placeholder="XXXX-XXXX-XXXX"
            class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-3 font-mono text-[15px] tracking-widest text-white uppercase placeholder-white/15 outline-none transition-all duration-300 focus:border-gold-500/30 focus:bg-white/[0.05] focus:ring-1 focus:ring-gold-500/20"
          />
        </div>

        <AlertMessage :message="promoSuccess" variant="success" />
        <AlertMessage :message="promoError" variant="error" />

        <div class="flex gap-3">
          <AppButton variant="secondary" @click="closePromoModal">{{ $t('common.cancel') }}</AppButton>
          <button type="submit" :disabled="!promoCode.trim() || promoLoading"
            class="flex-1 rounded-lg bg-gold-500 py-3 font-display text-[12px] font-bold uppercase tracking-widest text-black transition-all duration-300 hover:bg-gold-400 active:scale-[0.98] disabled:opacity-40 disabled:pointer-events-none">
            <span v-if="promoLoading" class="inline-flex items-center gap-2">
              <svg class="h-3.5 w-3.5 animate-spin" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" /></svg>
              {{ $t('dashboard.activating') }}
            </span>
            <span v-else>{{ $t('dashboard.activate') }}</span>
          </button>
        </div>
      </form>
    </AppModal>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'auth' })

interface Player { id: number; name: string; race: string; player_class: string; online: boolean }
interface AccountData { id: number; name: string; toll: number; membership: number; membership_expire: string | null; players: Player[] }

const { $api, fetchCsrfCookie } = useApi()
const { user, fetchUser } = useAuth()

const { data: dashboardData, status } = useAsyncData('dashboard', () =>
  $api<{ data: AccountData[] }>('/dashboard'),
)

const allPlayers = computed(() =>
  dashboardData.value?.data?.flatMap(acc => acc.players) ?? [],
)

const showPromoModal = ref(false)
const promoCode = ref('')
const promoLoading = ref(false)
const promoSuccess = ref('')
const promoError = ref('')

function closePromoModal() {
  showPromoModal.value = false
  promoCode.value = ''
  promoSuccess.value = ''
  promoError.value = ''
}

async function handleActivatePromo() {
  if (!promoCode.value.trim()) return
  promoLoading.value = true
  promoSuccess.value = ''
  promoError.value = ''
  try {
    await fetchCsrfCookie()
    const res = await $api<{ message: string }>('/promocodes/activate', {
      method: 'POST',
      body: { code: promoCode.value.trim() },
    })
    promoSuccess.value = res.message || 'Promo code activated!'
    promoCode.value = ''
    await fetchUser()
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    promoError.value = err.data?.message || 'Invalid or expired promo code.'
  } finally {
    promoLoading.value = false
  }
}

const classIconMap: Record<string, number> = {
  GLADIATOR: 1,
  RANGER: 4,
  SORCERER: 5,
  CLERIC: 7,
  CHANTER: 8,
  AETHERTECH: 10,
  SONGWEAVER: 11,
}
</script>

