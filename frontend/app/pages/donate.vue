<template>
  <div>
    <div class="mb-10 flex items-end justify-between">
      <div>
        <h1 class="font-display text-2xl font-extrabold uppercase tracking-tight lg:text-3xl">{{ $t('donate.title') }}</h1>
        <p class="mt-1 text-[13px] text-white/25">{{ $t('donate.subtitle') }}</p>
      </div>
      <div class="hidden items-center gap-2 rounded-lg bg-red-600/10 px-3.5 py-2 sm:flex">
        <span class="font-display text-[15px] font-bold tabular-nums text-red-400">{{ user?.balance ?? 0 }}</span>
        <span class="text-[10px] font-medium uppercase tracking-wider text-red-400/50">{{ $t('common.toll') }}</span>
      </div>
    </div>

    <div v-if="methodsLoading" class="flex items-center justify-center py-20">
      <svg class="h-6 w-6 animate-spin text-white/20" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" /></svg>
    </div>

    <div v-else-if="gateways.length === 0" class="rounded-xl border border-white/[0.04] bg-white/[0.02] px-6 py-16 text-center">
      <p class="text-[14px] text-white/30">{{ $t('donate.unavailable') }}</p>
    </div>

    <div v-else class="mx-auto max-w-2xl space-y-8">

      <section v-if="bonusTiers.length > 0" class="relative overflow-hidden rounded-xl border border-amber-500/10 bg-gradient-to-br from-amber-500/[0.04] to-transparent p-6">
        <div class="absolute -right-6 -top-6 h-32 w-32 rounded-full bg-amber-500/[0.03] blur-2xl" />
        <div class="relative">
          <div class="mb-4 flex items-center gap-2">
            <svg class="h-5 w-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" /></svg>
            <h3 class="font-display text-[14px] font-bold uppercase tracking-wider text-amber-400">{{ $t('donate.bonusTitle') }}</h3>
          </div>
          <div class="flex flex-wrap gap-2">
            <div v-for="tier in bonusTiers" :key="tier.min_toll"
              :class="['relative rounded-lg border px-4 py-2.5 text-center transition-all duration-300',
                currentBonusPercent >= tier.bonus_percent && amount && amount >= tier.min_toll
                  ? 'border-amber-500/30 bg-amber-500/10'
                  : 'border-white/[0.04] bg-white/[0.02]']">
              <p class="font-display text-[18px] font-extrabold tabular-nums" :class="currentBonusPercent >= tier.bonus_percent && amount && amount >= tier.min_toll ? 'text-amber-400' : 'text-white/40'">+{{ tier.bonus_percent }}%</p>
              <p class="mt-0.5 text-[11px] tabular-nums text-white/20">{{ $t('donate.from') }} {{ tier.min_toll.toLocaleString() }}</p>
            </div>
          </div>
        </div>
      </section>

      <section class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
        <label class="mb-3 block text-[11px] font-bold uppercase tracking-widest text-white/20">{{ $t('donate.amountLabel') }}</label>

        <div class="relative">
          <input
            v-model.number="amount" type="number" min="1" step="10"
            placeholder="100"
            class="w-full rounded-xl border border-white/[0.06] bg-white/[0.03] px-5 py-4 pr-20 font-display text-[22px] font-bold tabular-nums text-white placeholder-white/10 outline-none transition-all duration-300 focus:border-red-500/30 focus:bg-white/[0.05] focus:ring-1 focus:ring-red-500/20"
          />
          <span class="absolute right-5 top-1/2 -translate-y-1/2 text-[13px] font-medium uppercase tracking-wider text-white/15">{{ $t('common.toll') }}</span>
        </div>

        <div class="mt-4 flex flex-wrap gap-2">
          <button v-for="preset in [50, 100, 250, 500, 1000, 2500]" :key="preset"
            @click="amount = preset"
            :class="['rounded-lg px-4 py-2 text-[13px] font-bold tabular-nums transition-all duration-300',
              amount === preset
                ? 'bg-red-600/20 text-red-400 ring-1 ring-red-500/20'
                : 'bg-white/[0.03] text-white/25 hover:bg-white/[0.06] hover:text-white/40']">
            {{ preset.toLocaleString() }}
          </button>
        </div>

        <div v-if="amount && amount > 0" class="mt-5 flex items-center gap-6 rounded-lg bg-white/[0.02] px-4 py-3">
          <div v-for="(rate, code) in rates" :key="code" class="flex items-center gap-1.5">
            <span class="text-[11px] text-white/20">{{ code }}</span>
            <span class="font-display text-[14px] font-bold tabular-nums" :class="selectedGateway?.currency.code === code ? 'text-white/60' : 'text-white/25'">
              {{ currencySymbols[code] || '' }}{{ (amount * rate).toFixed(code === 'RUB' ? 0 : 2) }}
            </span>
          </div>
        </div>
      </section>

      <section class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6">
        <label class="mb-3 block text-[11px] font-bold uppercase tracking-widest text-white/20">{{ $t('donate.paymentMethod') }}</label>

        <div class="grid gap-3" :class="gateways.length > 1 ? 'sm:grid-cols-2' : ''">
          <button
            v-for="gw in gateways" :key="gw.gateway"
            @click="selectedGateway = gw"
            :class="['group relative flex items-center gap-4 rounded-xl border p-5 text-left transition-all duration-300',
              selectedGateway?.gateway === gw.gateway
                ? 'border-red-500/25 bg-gradient-to-br from-red-600/[0.06] to-transparent'
                : 'border-white/[0.04] bg-white/[0.015] hover:border-white/[0.08] hover:bg-white/[0.03]']"
          >
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl transition-colors"
              :class="selectedGateway?.gateway === gw.gateway ? 'bg-red-600/15' : 'bg-white/[0.04]'">
              <img v-if="gw.icon" :src="gw.icon" :alt="gw.label" class="h-8 w-auto brightness-0 invert"
                :class="selectedGateway?.gateway === gw.gateway ? 'opacity-90' : 'opacity-40'" />
              <span v-else class="text-xl">💰</span>
            </div>
            <div class="min-w-0 flex-1">
              <div class="text-[15px] font-bold" :class="selectedGateway?.gateway === gw.gateway ? 'text-red-400' : 'text-white/60'">{{ gw.label }}</div>
              <div class="mt-0.5 text-[12px] text-white/20">
                {{ gw.currency.code }} · {{ $t('donate.min') }} {{ gw.min_amount }}{{ gw.currency.symbol }}
              </div>
            </div>
            <div v-if="selectedGateway?.gateway === gw.gateway"
              class="absolute right-4 top-4 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 shadow-lg shadow-red-500/20">
              <svg class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
            </div>
          </button>
        </div>
      </section>

      <section class="space-y-4">
        <div v-if="amount && amount > 0 && selectedGateway" class="rounded-xl border border-white/[0.04] bg-white/[0.02] px-6 py-5">
          <div class="flex items-center justify-between">
            <div class="space-y-0.5">
              <p class="text-[12px] text-white/25">{{ $t('donate.youReceive') }}</p>
              <div class="flex items-baseline gap-2">
                <p class="font-display text-[22px] font-extrabold tabular-nums text-red-400">{{ totalToll.toLocaleString() }}</p>
                <span class="text-[13px] font-bold text-red-400/50">{{ $t('common.toll') }}</span>
              </div>
            </div>
            <div class="text-right space-y-0.5">
              <p class="text-[12px] text-white/25">{{ $t('donate.youPay') }}</p>
              <p class="font-display text-[22px] font-extrabold tabular-nums text-white/70">
                {{ currencySymbols[selectedGateway.currency.code] }}{{ moneyDisplay }}
              </p>
            </div>
          </div>

          <div v-if="bonusToll > 0" class="mt-3 flex items-center gap-2 rounded-lg border border-amber-500/15 bg-amber-500/[0.05] px-4 py-2.5">
            <svg class="h-4 w-4 shrink-0 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" /></svg>
            <p class="text-[13px] font-medium text-amber-400">
              +{{ bonusToll.toLocaleString() }} {{ $t('donate.bonusToll') }}
              <span class="text-amber-400/50">(+{{ currentBonusPercent }}%)</span>
            </p>
          </div>
        </div>

        <div v-if="limitError" class="flex items-start gap-2.5 rounded-xl bg-red-500/5 px-5 py-3.5">
          <svg class="mt-0.5 h-4 w-4 shrink-0 text-red-400/60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
          <p class="text-[12px] leading-relaxed text-red-400/50">{{ limitError }}</p>
        </div>

        <AlertMessage :message="errorMessage" variant="error" />

        <AppButton :loading="loading" :loading-text="$t('donate.processing')" :disabled="!canSubmit" block @click="handleDonate" class="!py-4 !text-[15px]">{{ $t('donate.proceedToPayment') }}</AppButton>

        <p class="text-center text-[11px] leading-relaxed text-white/15">
          {{ $t('donate.termsPrefix') }} <NuxtLink :to="localePath('/terms')" class="text-white/25 underline underline-offset-2 transition-colors hover:text-white/40">{{ $t('donate.termsLink') }}</NuxtLink>
        </p>
      </section>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'auth' })

const { t } = useI18n()
const localePath = useLocalePath()
const { $api, fetchCsrfCookie } = useApi()
const { user } = useAuth()

interface GatewayMethod {
  gateway: string
  label: string
  icon: string
  currency: { code: string; symbol: string }
  min_amount: number
  max_amount: number
}

interface BonusTier {
  min_toll: number
  bonus_percent: number
}

const gateways = ref<GatewayMethod[]>([])
const rates = ref<Record<string, number>>({})
const bonusTiers = ref<BonusTier[]>([])
const methodsLoading = ref(true)

const selectedGateway = ref<GatewayMethod | null>(null)
const amount = ref<number | null>(100)
const loading = ref(false)
const errorMessage = ref('')

const currencySymbols: Record<string, string> = { USD: '$', EUR: '€', RUB: '₽' }

const currentBonusPercent = computed(() => {
  if (!amount.value || !bonusTiers.value.length) return 0
  let percent = 0
  for (const tier of bonusTiers.value) {
    if (amount.value >= tier.min_toll) percent = tier.bonus_percent
  }
  return percent
})

const bonusToll = computed(() => {
  if (!amount.value || !currentBonusPercent.value) return 0
  return Math.floor(amount.value * currentBonusPercent.value / 100)
})

const totalToll = computed(() => (amount.value ?? 0) + bonusToll.value)

const moneyAmount = computed(() => {
  if (!amount.value || !selectedGateway.value) return 0
  const rate = rates.value[selectedGateway.value.currency.code]
  return rate ? amount.value * rate : 0
})

const moneyDisplay = computed(() => {
  if (!selectedGateway.value) return '0'
  return selectedGateway.value.currency.code === 'RUB'
    ? moneyAmount.value.toFixed(0)
    : moneyAmount.value.toFixed(2)
})

const limitError = computed(() => {
  if (!selectedGateway.value || !amount.value || !moneyAmount.value) return ''
  const gw = selectedGateway.value
  if (moneyAmount.value < gw.min_amount) {
    return t('donate.minAmountError', { amount: gw.min_amount, symbol: gw.currency.symbol })
  }
  if (gw.max_amount > 0 && moneyAmount.value > gw.max_amount) {
    return t('donate.maxAmountError', { amount: gw.max_amount, symbol: gw.currency.symbol })
  }
  return ''
})

const canSubmit = computed(() => {
  return selectedGateway.value && amount.value && amount.value > 0 && !limitError.value
})

async function fetchMethods() {
  methodsLoading.value = true
  try {
    const res = await $api<{ data: GatewayMethod[]; rates: Record<string, number>; bonus_tiers: BonusTier[] }>('/donate')
    gateways.value = res.data
    rates.value = res.rates
    bonusTiers.value = (res.bonus_tiers || []).sort((a, b) => a.min_toll - b.min_toll)
    if (gateways.value.length > 0) {
      selectedGateway.value = gateways.value[0]
    }
  } catch {
    gateways.value = []
  } finally {
    methodsLoading.value = false
  }
}

async function handleDonate() {
  if (!selectedGateway.value || !amount.value) return

  loading.value = true
  errorMessage.value = ''

  try {
    await fetchCsrfCookie()
    const res = await $api<{ data: { redirect_url: string } }>('/donate', {
      method: 'POST',
      body: {
        gateway: selectedGateway.value.gateway,
        amount_toll: amount.value,
      },
    })
    if (res.data.redirect_url) {
      window.location.href = res.data.redirect_url
    }
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    errorMessage.value = err.data?.message || t('donate.paymentError')
  } finally {
    loading.value = false
  }
}

onMounted(fetchMethods)
</script>
