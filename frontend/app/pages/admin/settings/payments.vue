<template>
  <div>
    <PageHeader :title="$t('admin.paymentSettings')" :subtitle="$t('admin.paymentSettingsDesc')" />

    <form @submit.prevent="handleSubmit" class="space-y-6">
      <div class="grid gap-6 lg:grid-cols-2">
        <section class="card-panel p-6 space-y-4">
          <h3 class="text-[13px] font-bold uppercase tracking-widest text-white/30">{{ $t('admin.paymentGeneral') }}</h3>
          <div class="flex items-center gap-3">
            <ToggleSwitch v-model="paymentForm.enabled" />
            <span class="text-[13px] text-white/50">{{ $t('admin.donationsEnabled') }}</span>
          </div>
          <div>
            <label class="form-label">{{ $t('admin.rateRub') }}</label>
            <input v-model.number="paymentForm.rate_rub" type="number" step="any" min="0"
              class="form-input"
              placeholder="1.0">
            <p class="mt-1 text-[11px] text-white/15">1 toll = X RUB</p>
          </div>
          <div>
            <label class="form-label">{{ $t('admin.rateUsd') }}</label>
            <input v-model.number="paymentForm.rate_usd" type="number" step="any" min="0"
              class="form-input"
              placeholder="0.01245">
            <p class="mt-1 text-[11px] text-white/15">1 toll = X USD</p>
          </div>
          <div>
            <label class="form-label">{{ $t('admin.rateEur') }}</label>
            <input v-model.number="paymentForm.rate_eur" type="number" step="any" min="0"
              class="form-input"
              placeholder="0.01117">
            <p class="mt-1 text-[11px] text-white/15">1 toll = X EUR</p>
          </div>
        </section>

        <section class="card-panel p-6 space-y-4">
          <h3 class="text-[13px] font-bold uppercase tracking-widest text-white/30">{{ $t('admin.gatewayLimits') }}</h3>
          <div v-for="(limit, key) in gatewayForm.limits" :key="key"
            class="rounded-lg border border-white/[0.04] bg-white/[0.015] p-4 space-y-3">
            <div class="flex items-center justify-between">
              <span class="text-[14px] font-semibold text-white/60">{{ gatewayLabels[key] || key }}</span>
              <div class="flex items-center gap-2">
                <ToggleSwitch v-model="limit.enabled" />
                <span class="text-[11px] text-white/30">{{ $t('admin.enabled') }}</span>
              </div>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
              <div>
                <label class="mb-1 block text-[11px] font-medium text-white/25">{{ $t('admin.minAmount') }} ({{ limit.currency }})</label>
                <input v-model.number="limit.min_amount" type="number" step="0.01" min="0"
                  class="form-input">
              </div>
              <div>
                <label class="mb-1 block text-[11px] font-medium text-white/25">{{ $t('admin.maxAmount') }} ({{ limit.currency }})</label>
                <input v-model.number="limit.max_amount" type="number" step="0.01" min="0"
                  class="form-input">
              </div>
            </div>
          </div>
        </section>
      </div>

      <section class="card-panel p-6 space-y-4">
        <div class="flex items-center justify-between">
          <h3 class="text-[13px] font-bold uppercase tracking-widest text-white/30">{{ $t('admin.bonusTiers') }}</h3>
          <button type="button" @click="addTier"
            class="rounded-lg bg-white/[0.04] px-3 py-1.5 text-[11px] font-bold text-white/30 transition-colors hover:bg-white/[0.08] hover:text-white/50">
            + {{ $t('admin.addTier') }}
          </button>
        </div>
        <div v-for="(tier, i) in paymentForm.bonus_tiers" :key="i" class="flex items-end gap-3">
          <div class="flex-1">
            <label class="mb-1 block text-[11px] font-medium text-white/25">{{ $t('admin.minToll') }}</label>
            <input v-model.number="tier.min_toll" type="number" min="1" step="1"
              class="form-input">
          </div>
          <div class="flex-1">
            <label class="mb-1 block text-[11px] font-medium text-white/25">{{ $t('admin.bonusPercent') }}</label>
            <input v-model.number="tier.bonus_percent" type="number" min="1" max="100" step="1"
              class="form-input">
          </div>
          <button type="button" @click="removeTier(i)"
            class="mb-0.5 shrink-0 rounded-lg p-2 text-white/15 transition-colors hover:bg-red-600/10 hover:text-red-400">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
          </button>
        </div>
      </section>

      <AlertMessage :message="successMsg" variant="success" />
      <AlertMessage :message="errorMsg" variant="error" />

      <AppButton type="submit" :loading="saving" :loading-text="$t('common.loading')">
        {{ $t('common.save') }}
      </AppButton>
    </form>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const { t } = useI18n()
const { $api } = useApi()
const { submit, loading: saving, successMsg, errorMsg } = useFormSubmit()

const gatewayLabels: Record<string, string> = { stripe: 'Stripe', pally: 'Pally' }

const paymentForm = reactive({
  enabled: false,
  rate_rub: 1.0,
  rate_usd: 0.01245,
  rate_eur: 0.01117,
  bonus_tiers: [] as Array<{ min_toll: number; bonus_percent: number }>,
})

function addTier() {
  paymentForm.bonus_tiers.push({ min_toll: 100, bonus_percent: 5 })
}

function removeTier(index: number) {
  paymentForm.bonus_tiers.splice(index, 1)
}

const gatewayForm = reactive({
  limits: {} as Record<string, { min_amount: number; max_amount: number; currency: string; enabled: boolean }>,
})

async function fetchSettings() {
  try {
    const [paymentRes, gatewayRes] = await Promise.all([
      $api<{ data: typeof paymentForm }>('/admin/settings/payments/rates'),
      $api<{ data: { limits: typeof gatewayForm.limits } }>('/admin/settings/payments/gateways'),
    ])
    Object.assign(paymentForm, paymentRes.data)
    gatewayForm.limits = gatewayRes.data.limits
  } catch { /* */ }
}

fetchSettings()

async function handleSubmit() {
  await submit(async (api) => {
    await Promise.all([
      api('/admin/settings/payments/rates', { method: 'PUT', body: { ...paymentForm } }),
      api('/admin/settings/payments/gateways', { method: 'PUT', body: { limits: gatewayForm.limits } }),
    ])
    return t('admin.settingsSaved')
  }, t('admin.settingsFailed'))
}
</script>
