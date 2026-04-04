<template>
  <div>
    <div class="mb-8 flex items-end justify-between">
      <div>
        <h1 class="font-display text-2xl font-extrabold uppercase tracking-tight lg:text-3xl">{{ $t('donate.title') }}</h1>
        <p class="mt-1 text-[13px] text-white/25">{{ $t('donate.subtitle') }}</p>
      </div>
      <div class="hidden items-center gap-2 rounded-lg bg-red-600/10 px-3.5 py-2 sm:flex">
        <span class="font-display text-[15px] font-bold tabular-nums text-red-400">{{ user?.balance ?? 0 }}</span>
        <span class="text-[10px] font-medium uppercase tracking-wider text-red-400/50">{{ $t('common.toll') }}</span>
      </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-5">
      <div class="lg:col-span-3 space-y-6">
        <div class="flex gap-2">
          <button
            v-for="group in groups" :key="group.id"
            @click="activeGroup = group.id"
            :class="['shrink-0 rounded-lg px-5 py-2.5 text-[13px] font-medium transition-all duration-300',
              activeGroup === group.id
                ? 'bg-red-600/15 text-red-400'
                : 'bg-white/[0.03] text-white/30 hover:bg-white/[0.05] hover:text-white/50']"
          >
            {{ group.name }}
          </button>
        </div>

        <div class="grid gap-3 sm:grid-cols-2">
          <button
            v-for="method in activeMethods" :key="method.id"
            @click="selectedMethod = method"
            :class="['group flex items-center gap-4 rounded-xl border p-4 text-left transition-all duration-300',
              selectedMethod?.id === method.id
                ? 'border-red-500/30 bg-red-600/5'
                : 'border-white/[0.04] bg-white/[0.02] hover:border-white/[0.08] hover:bg-white/[0.03]']"
          >
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl" :class="selectedMethod?.id === method.id ? 'bg-red-600/15' : 'bg-white/[0.04]'">
              <span class="text-lg">{{ method.icon }}</span>
            </div>
            <div class="min-w-0 flex-1">
              <div class="text-[14px] font-semibold" :class="selectedMethod?.id === method.id ? 'text-red-400' : 'text-white/70'">{{ method.name }}</div>
              <div class="mt-0.5 text-[12px] text-white/20">{{ method.description }}</div>
            </div>
            <div v-if="selectedMethod?.id === method.id" class="shrink-0">
              <div class="flex h-5 w-5 items-center justify-center rounded-full bg-red-500">
                <svg class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
              </div>
            </div>
          </button>
        </div>
      </div>

      <div class="lg:col-span-2">
        <div class="rounded-xl border border-white/[0.04] bg-white/[0.02]">
          <div class="border-b border-white/[0.04] px-6 py-4">
            <h2 class="font-display text-[15px] font-bold uppercase tracking-wider">{{ $t('donate.order') }}</h2>
          </div>

          <div class="space-y-5 px-6 py-5">
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/40">{{ $t('donate.amountLabel') }}</label>
              <input
                v-model.number="amount" type="number" min="10" step="10"
                placeholder="100"
                class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-3 font-display text-[16px] font-bold tabular-nums text-white placeholder-white/15 outline-none transition-all duration-300 focus:border-red-500/30 focus:bg-white/[0.05] focus:ring-1 focus:ring-red-500/20"
              />
            </div>

            <div class="flex flex-wrap gap-2">
              <button v-for="preset in [50, 100, 250, 500, 1000]" :key="preset"
                @click="amount = preset"
                :class="['rounded-lg px-3 py-1.5 text-[12px] font-medium tabular-nums transition-all duration-300',
                  amount === preset ? 'bg-red-600/15 text-red-400' : 'bg-white/[0.03] text-white/25 hover:bg-white/[0.05] hover:text-white/40']">
                {{ preset }}
              </button>
            </div>

            <div v-if="amount" class="space-y-2 rounded-lg border border-white/[0.04] bg-white/[0.015] p-4">
              <div v-if="selectedMethod" class="flex items-center justify-between">
                <span class="text-[12px] text-white/30">{{ $t('donate.paymentMethod') }}</span>
                <span class="text-[13px] font-medium text-white/60">{{ selectedMethod.name }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-[12px] text-white/30">{{ $t('donate.youReceive') }}</span>
                <span class="font-display text-[15px] font-bold tabular-nums text-red-400">{{ amount }} {{ $t('common.toll') }}</span>
              </div>
              <div class="h-px bg-white/[0.04]" />
              <div class="flex items-center justify-between">
                <span class="text-[12px] text-white/30">~ USD</span>
                <span class="text-[13px] tabular-nums text-white/40">${{ (amount * rates.USD).toFixed(2) }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-[12px] text-white/30">~ EUR</span>
                <span class="text-[13px] tabular-nums text-white/40">&euro;{{ (amount * rates.EUR).toFixed(2) }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span class="text-[12px] text-white/30">~ RUB</span>
                <span class="text-[13px] tabular-nums text-white/40">{{ (amount * rates.RUB).toFixed(0) }} &#8381;</span>
              </div>
            </div>

            <div class="flex items-start gap-2.5 rounded-lg bg-amber-500/5 px-4 py-3">
              <svg class="mt-0.5 h-4 w-4 shrink-0 text-amber-400/60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
              <p class="text-[11px] leading-relaxed text-amber-400/50">{{ $t('donate.finalAmountWarning') }}</p>
            </div>

            <AlertMessage :message="successMessage" variant="success" />
            <AlertMessage :message="errorMessage" variant="error" />

            <AppButton :loading="loading" :loading-text="$t('donate.processing')" :disabled="!selectedMethod || !amount || amount < 10" block @click="handleDonate">{{ $t('donate.proceedToPayment') }}</AppButton>

            <p class="text-center text-[11px] leading-relaxed text-white/15">
              {{ $t('donate.termsNotice') }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'auth' })

const { t } = useI18n()
const { $api, fetchCsrfCookie } = useApi()
const { user } = useAuth()

interface PaymentMethod {
  id: string
  name: string
  description: string
  icon: string
  group: string
}

const groups = [
  { id: 'international', name: t('donate.international') },
  { id: 'ru', name: t('donate.russiaCis') },
]

const methods: PaymentMethod[] = [
  { id: 'payop_card', name: 'Credit Card', description: 'Visa, Mastercard', icon: '💳', group: 'international' },
  { id: 'payop_paypal', name: 'PayPal', description: 'Pay with PayPal account', icon: '🅿️', group: 'international' },
  { id: 'payop_crypto', name: 'Cryptocurrency', description: 'BTC, ETH, USDT & more', icon: '₿', group: 'international' },
  { id: 'payop_skrill', name: 'Skrill', description: 'Skrill e-wallet', icon: '💰', group: 'international' },
  { id: 'palych_card', name: 'Bank Card', description: 'Visa, Mastercard, Mir', icon: '💳', group: 'ru' },
  { id: 'palych_sbp', name: 'SBP', description: 'Fast bank transfer', icon: '🏦', group: 'ru' },
  { id: 'palych_qiwi', name: 'QIWI', description: 'QIWI Wallet', icon: '🥝', group: 'ru' },
  { id: 'palych_yoomoney', name: 'YooMoney', description: 'YooMoney wallet', icon: '💵', group: 'ru' },
]

const rates = { USD: 0.01, EUR: 0.009, RUB: 0.86 }

const activeGroup = ref('international')
const selectedMethod = ref<PaymentMethod | null>(null)
const amount = ref<number | null>(100)
const loading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

const activeMethods = computed(() => methods.filter(m => m.group === activeGroup.value))

watch(activeGroup, () => { selectedMethod.value = null })

async function handleDonate() {
  if (!selectedMethod.value || !amount.value) return

  loading.value = true
  successMessage.value = ''
  errorMessage.value = ''

  try {
    await fetchCsrfCookie()
    // TODO: POST /api/donate { payment_method: string, amount: number }
    await $api('/donate', {
      method: 'POST',
      body: {
        payment_method: selectedMethod.value.id,
        amount: amount.value,
      },
    })
    successMessage.value = 'Redirecting to payment...'
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    errorMessage.value = err.data?.message || 'Payment is not available at the moment.'
  } finally {
    loading.value = false
  }
}
</script>

