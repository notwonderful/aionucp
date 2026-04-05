<template>
  <div>
    <PageHeader :title="$t('admin.paymentSettings')" :subtitle="$t('admin.paymentSettingsDesc')" />

    <form @submit.prevent="handleSubmit" class="space-y-6">
      <div class="grid gap-6 lg:grid-cols-2">
        <section class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6 space-y-4">
          <h3 class="text-[13px] font-bold uppercase tracking-widest text-white/30">{{ $t('admin.paymentGeneral') }}</h3>
          <div class="flex items-center gap-3">
            <button type="button" @click="paymentForm.enabled = !paymentForm.enabled"
              :class="['relative h-6 w-11 rounded-full transition-colors duration-300',
                paymentForm.enabled ? 'bg-emerald-500' : 'bg-white/10']">
              <span :class="['absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white transition-transform duration-300',
                paymentForm.enabled && 'translate-x-5']" />
            </button>
            <span class="text-[13px] text-white/50">{{ $t('admin.donationsEnabled') }}</span>
          </div>
          <div>
            <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.rateRub') }}</label>
            <input v-model.number="paymentForm.rate_rub" type="number" step="any" min="0"
              class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30"
              placeholder="1.0">
            <p class="mt-1 text-[11px] text-white/15">1 toll = X RUB</p>
          </div>
          <div>
            <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.rateUsd') }}</label>
            <input v-model.number="paymentForm.rate_usd" type="number" step="any" min="0"
              class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30"
              placeholder="0.01245">
            <p class="mt-1 text-[11px] text-white/15">1 toll = X USD</p>
          </div>
          <div>
            <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.rateEur') }}</label>
            <input v-model.number="paymentForm.rate_eur" type="number" step="any" min="0"
              class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30"
              placeholder="0.01117">
            <p class="mt-1 text-[11px] text-white/15">1 toll = X EUR</p>
          </div>
        </section>

        <section class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6 space-y-4">
          <h3 class="text-[13px] font-bold uppercase tracking-widest text-white/30">{{ $t('admin.gatewayLimits') }}</h3>
          <div v-for="(limit, key) in gatewayForm.limits" :key="key"
            class="rounded-lg border border-white/[0.04] bg-white/[0.015] p-4 space-y-3">
            <div class="flex items-center justify-between">
              <span class="text-[14px] font-semibold text-white/60">{{ gatewayLabels[key] || key }}</span>
              <div class="flex items-center gap-2">
                <button type="button" @click="limit.enabled = !limit.enabled"
                  :class="['relative h-6 w-11 rounded-full transition-colors duration-300',
                    limit.enabled ? 'bg-emerald-500' : 'bg-white/10']">
                  <span :class="['absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white transition-transform duration-300',
                    limit.enabled && 'translate-x-5']" />
                </button>
                <span class="text-[11px] text-white/30">{{ $t('admin.enabled') }}</span>
              </div>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
              <div>
                <label class="mb-1 block text-[11px] font-medium text-white/25">{{ $t('admin.minAmount') }} ({{ limit.currency }})</label>
                <input v-model.number="limit.min_amount" type="number" step="0.01" min="0"
                  class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-3 py-2 text-[13px] text-white/70 outline-none focus:border-red-500/30">
              </div>
              <div>
                <label class="mb-1 block text-[11px] font-medium text-white/25">{{ $t('admin.maxAmount') }} ({{ limit.currency }})</label>
                <input v-model.number="limit.max_amount" type="number" step="0.01" min="0"
                  class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-3 py-2 text-[13px] text-white/70 outline-none focus:border-red-500/30">
              </div>
            </div>
          </div>
        </section>
      </div>

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
const { $api, fetchCsrfCookie } = useApi()

const saving = ref(false)
const successMsg = ref('')
const errorMsg = ref('')

const gatewayLabels: Record<string, string> = { stripe: 'Stripe', pally: 'Pally' }

const paymentForm = reactive({
  enabled: false,
  rate_rub: 1.0,
  rate_usd: 0.01245,
  rate_eur: 0.01117,
})

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
  saving.value = true
  successMsg.value = ''
  errorMsg.value = ''

  try {
    await fetchCsrfCookie()
    await Promise.all([
      $api('/admin/settings/payments/rates', {
        method: 'PUT',
        body: { ...paymentForm },
      }),
      $api('/admin/settings/payments/gateways', {
        method: 'PUT',
        body: { limits: gatewayForm.limits },
      }),
    ])
    successMsg.value = t('admin.settingsSaved')
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    errorMsg.value = err.data?.message || t('admin.settingsFailed')
  } finally {
    saving.value = false
  }
}
</script>
