<template>
  <div class="grid gap-6 xl:grid-cols-2">
    <div class="space-y-6">
      <section class="card-panel">
        <div class="border-b border-white/[0.04] px-6 py-4">
          <div class="flex items-center gap-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/[0.04]">
              <svg class="h-4 w-4 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
            </div>
            <div>
              <h2 class="font-display text-[15px] font-bold uppercase tracking-wider">{{ $t('security.password') }}</h2>
              <p class="mt-0.5 text-[11px] text-white/20">{{ $t('security.passwordDesc') }}</p>
            </div>
          </div>
        </div>

        <form class="space-y-4 px-6 py-5" @submit.prevent="handleUpdatePassword">
          <FormInput v-model="passwordForm.current_password" id="current-password" :label="$t('security.currentPassword')" type="password" required autocomplete="current-password" :placeholder="$t('security.currentPasswordPlaceholder')" :error="passwordErrors.current_password?.[0]" />
          <FormInput v-model="passwordForm.password" id="new-password" :label="$t('security.newPassword')" type="password" required autocomplete="new-password" :placeholder="$t('security.newPasswordPlaceholder')" :error="passwordErrors.password?.[0]" />
          <FormInput v-model="passwordForm.password_confirmation" id="confirm-password" :label="$t('security.confirmPassword')" type="password" required autocomplete="new-password" :placeholder="$t('security.confirmPasswordPlaceholder')" />
          <AlertMessage :message="passwordSuccess" variant="success" />
          <AlertMessage :message="passwordError" variant="error" />
          <AppButton type="submit" :loading="passwordLoading" :loading-text="$t('security.updating')">{{ $t('security.updatePassword') }}</AppButton>
        </form>
      </section>

      <section class="card-panel px-6 py-5">
        <h3 class="flex items-center gap-2 font-display text-[13px] font-bold uppercase tracking-wider text-white/30">
          <svg class="h-3.5 w-3.5 text-white/15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
          {{ $t('security.securityTips') }}
        </h3>
        <ul class="mt-3.5 space-y-3">
          <li class="flex items-start gap-2.5 text-[12px] leading-relaxed text-white/20">
            <svg class="mt-[3px] h-3 w-3 shrink-0 text-red-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
            {{ $t('security.tip1') }}
          </li>
          <li class="flex items-start gap-2.5 text-[12px] leading-relaxed text-white/20">
            <svg class="mt-[3px] h-3 w-3 shrink-0 text-red-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
            {{ $t('security.tip2') }}
          </li>
          <li class="flex items-start gap-2.5 text-[12px] leading-relaxed text-white/20">
            <svg class="mt-[3px] h-3 w-3 shrink-0 text-red-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
            {{ $t('security.tip3') }}
          </li>
        </ul>
      </section>
    </div>

    <section class="card-panel">
      <div class="border-b border-white/[0.04] px-6 py-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg" :class="tfa.enabled ? 'bg-emerald-500/10' : 'bg-white/[0.04]'">
              <svg class="h-4 w-4" :class="tfa.enabled ? 'text-emerald-400' : 'text-white/40'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
            </div>
            <div>
              <h2 class="font-display text-[15px] font-bold uppercase tracking-wider">{{ $t('security.twoFactorAuth') }}</h2>
              <p class="mt-0.5 text-[11px] text-white/20">{{ $t('security.twoFactorDesc') }}</p>
            </div>
          </div>
          <div v-if="tfa.enabled" class="flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-3 py-1">
            <span class="relative flex h-1.5 w-1.5"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75" /><span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-400" /></span>
            <span class="text-[11px] font-medium text-emerald-400">{{ $t('security.active') }}</span>
          </div>
          <div v-else class="flex items-center gap-1.5 rounded-full bg-white/[0.04] px-3 py-1">
            <span class="h-1.5 w-1.5 rounded-full bg-white/20" />
            <span class="text-[11px] font-medium text-white/25">{{ $t('security.disabled') }}</span>
          </div>
        </div>
      </div>

      <div class="px-6 py-5">
        <div v-if="tfaLoading" class="flex items-center justify-center py-8">
          <svg class="h-5 w-5 animate-spin text-white/20" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" /></svg>
        </div>

        <template v-else-if="!tfa.enabled && tfa.step === 'idle'">
          <p class="text-[13px] leading-relaxed text-white/30">
            {{ $t('security.twoFactorInfo') }}
          </p>
          <div class="mt-5 space-y-2">
            <div class="card-panel transition-all duration-300" :class="selectedMethod === 'email' && 'border-red-500/15 bg-white/[0.03]'">
              <button @click="selectedMethod = selectedMethod === 'email' ? '' : 'email'" class="group flex w-full items-center gap-4 p-4 text-left">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-red-600/10 transition-colors group-hover:bg-red-600/15">
                  <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                </div>
                <div class="min-w-0 flex-1">
                  <div class="text-[14px] font-semibold transition-colors group-hover:text-red-400">{{ $t('security.emailVerification') }}</div>
                  <div class="mt-0.5 truncate text-[12px] text-white/20">{{ $t('security.emailVerificationDesc') }}</div>
                </div>
                <svg class="h-4 w-4 shrink-0 text-white/10 transition-all duration-300" :class="selectedMethod === 'email' ? 'rotate-90 text-red-400/60' : 'group-hover:translate-x-0.5 group-hover:text-red-400/60'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
              </button>
              <div v-if="selectedMethod === 'email'" class="border-t border-white/[0.04] px-4 pb-4 pt-3">
                <p class="text-[12px] leading-relaxed text-white/25">{{ $t('security.emailSetupDesc') }}</p>
                <AppButton class="mt-3" @click="setupTfa('email')" :loading="tfaActionLoading" :loading-text="$t('security.sending')">{{ $t('security.sendCode') }}</AppButton>
              </div>
            </div>
            <div class="card-panel transition-all duration-300" :class="selectedMethod === 'app' && 'border-white/[0.08] bg-white/[0.03]'">
              <button @click="selectedMethod = selectedMethod === 'app' ? '' : 'app'" class="group flex w-full items-center gap-4 p-4 text-left">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-white/[0.04] transition-colors group-hover:bg-white/[0.06]">
                  <svg class="h-5 w-5 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" /></svg>
                </div>
                <div class="min-w-0 flex-1">
                  <div class="text-[14px] font-semibold transition-colors group-hover:text-white/80">{{ $t('security.authenticatorApp') }}</div>
                  <div class="mt-0.5 text-[12px] text-white/20">{{ $t('security.authenticatorAppDesc') }}</div>
                </div>
                <svg class="h-4 w-4 shrink-0 text-white/10 transition-all duration-300" :class="selectedMethod === 'app' ? 'rotate-90 text-white/30' : 'group-hover:translate-x-0.5 group-hover:text-white/30'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
              </button>
              <div v-if="selectedMethod === 'app'" class="border-t border-white/[0.04] px-4 pb-4 pt-3">
                <p class="text-[12px] leading-relaxed text-white/25">{{ $t('security.appSetupDesc') }}</p>
                <AppButton class="mt-3" variant="secondary" @click="setupTfa('app')" :loading="tfaActionLoading" :loading-text="$t('security.generating')">{{ $t('security.generateQr') }}</AppButton>
              </div>
            </div>
          </div>
        </template>

        <template v-else-if="tfa.enabled && tfa.step === 'idle'">
          <div class="space-y-4">
            <div class="flex items-start gap-3 rounded-lg border border-emerald-500/10 bg-emerald-500/5 px-4 py-3.5">
              <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
              <div>
                <p class="text-[13px] font-medium text-emerald-400">{{ $t('security.twoFactorActive') }}</p>
                <p class="mt-1 text-[12px] text-white/20">{{ $t('security.method') }}: <span class="text-white/40">{{ tfa.method === 'email' ? $t('security.emailVerification') : $t('security.authenticatorApp') }}</span></p>
              </div>
            </div>
            <button @click="handleRegenerateCodes" class="flex w-full items-center gap-3 rounded-lg border border-white/[0.04] bg-white/[0.02] px-4 py-3 text-left transition-all hover:bg-white/[0.04]">
              <svg class="h-4 w-4 shrink-0 text-white/25" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182M2.985 19.644l3.181-3.182" /></svg>
              <div>
                <p class="text-[12px] font-medium text-white/40">{{ $t('security.regenerateCodes') }}</p>
                <p class="mt-0.5 text-[11px] text-white/15">{{ $t('security.regenerateCodesDesc') }}</p>
              </div>
            </button>
            <AppButton variant="secondary" @click="tfa.step = 'disable'">{{ $t('security.disable2fa') }}</AppButton>
          </div>
        </template>

        <template v-else-if="tfa.step === 'disable'">
          <div class="space-y-4">
            <div class="flex items-center gap-3">
              <button @click="tfa.step = 'idle'" class="flex h-8 w-8 items-center justify-center rounded-lg text-white/20 transition-colors hover:bg-white/[0.04] hover:text-white/40">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
              </button>
              <h3 class="font-display text-[14px] font-bold uppercase tracking-wider">{{ $t('security.disable2fa') }}</h3>
            </div>
            <p class="text-[13px] leading-relaxed text-white/30">{{ $t('security.disableConfirmText') }}</p>
            <FormInput v-model="disablePassword" id="disable-2fa-password" :label="$t('security.currentPassword')" type="password" required :placeholder="$t('security.currentPasswordPlaceholder')" />
            <AlertMessage :message="tfaError" variant="error" />
            <div class="flex gap-3">
              <AppButton variant="secondary" @click="tfa.step = 'idle'">{{ $t('common.cancel') }}</AppButton>
              <AppButton @click="handleDisableTfa" :loading="tfaActionLoading" :loading-text="$t('security.disabling')">{{ $t('security.confirmDisable') }}</AppButton>
            </div>
          </div>
        </template>

        <template v-else-if="tfa.step === 'recovery'">
          <div class="space-y-4">
            <div class="flex items-center gap-3">
              <button @click="tfa.step = 'idle'" class="flex h-8 w-8 items-center justify-center rounded-lg text-white/20 transition-colors hover:bg-white/[0.04] hover:text-white/40">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
              </button>
              <h3 class="font-display text-[14px] font-bold uppercase tracking-wider">{{ $t('security.recoveryCodes') }}</h3>
            </div>
            <div class="rounded-lg border border-amber-500/15 bg-amber-500/5 px-4 py-3">
              <p class="text-[12px] leading-relaxed text-amber-400/80">{{ $t('security.recoveryCodesWarning') }}</p>
            </div>
            <div class="grid grid-cols-2 gap-2 rounded-lg border border-white/[0.04] bg-white/[0.02] p-4">
              <code v-for="code in recoveryCodes" :key="code" class="text-center text-[13px] tracking-wider text-white/50">{{ code }}</code>
            </div>
            <button @click="copyRecoveryCodes" class="flex w-full items-center justify-center gap-2 rounded-lg border border-white/[0.04] bg-white/[0.02] px-4 py-2.5 text-[12px] text-white/30 transition-colors hover:bg-white/[0.04] hover:text-white/50">
              <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9.75a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" /></svg>
              {{ codesCopied ? $t('security.copied') : $t('security.copyCodes') }}
            </button>
            <AppButton @click="tfa.step = 'idle'">{{ $t('common.confirm') }}</AppButton>
          </div>
        </template>

        <div v-else-if="tfa.step === 'email' || tfa.step === 'app'" class="space-y-4">
          <div class="flex items-center gap-3">
            <button @click="resetSetup" class="flex h-8 w-8 items-center justify-center rounded-lg text-white/20 transition-colors hover:bg-white/[0.04] hover:text-white/40">
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
            </button>
            <h3 class="font-display text-[14px] font-bold uppercase tracking-wider">{{ tfa.step === 'email' ? $t('security.emailVerification') : $t('security.authenticatorApp') }}</h3>
          </div>

          <template v-if="setupData">
            <div v-if="tfa.step === 'app' && setupData.qr_svg" class="space-y-3">
              <p class="text-[13px] leading-relaxed text-white/30">{{ $t('security.scanQrCode') }}</p>
              <div class="flex justify-center rounded-lg border border-white/[0.04] bg-white p-4">
                <img :src="setupData.qr_svg" alt="QR Code" class="h-48 w-48" />
              </div>
              <details class="rounded-lg border border-white/[0.04] bg-white/[0.02]">
                <summary class="cursor-pointer px-4 py-2.5 text-[12px] text-white/25 hover:text-white/40">{{ $t('security.cantScanQr') }}</summary>
                <div class="border-t border-white/[0.04] px-4 py-3">
                  <code class="block break-all text-[12px] text-white/40">{{ setupData.secret }}</code>
                </div>
              </details>
            </div>
            <div v-else-if="tfa.step === 'email'">
              <p class="text-[13px] leading-relaxed text-white/30">{{ $t('security.emailCodeSent') }}</p>
            </div>

            <form @submit.prevent="handleVerifyCode" class="space-y-4">
              <FormInput v-model="verifyCode" id="2fa-code" :label="$t('security.enterCode')" type="text" required :placeholder="$t('security.codePlaceholder')" inputmode="numeric" autocomplete="one-time-code" />
              <AlertMessage :message="tfaError" variant="error" />
              <AppButton type="submit" :loading="tfaActionLoading" :loading-text="$t('security.verifying')">{{ $t('security.verifyAndEnable') }}</AppButton>
            </form>
          </template>

          <div v-else class="flex items-center justify-center py-8">
            <svg class="h-5 w-5 animate-spin text-white/20" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" /></svg>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
const { t } = useI18n()
const { $api, fetchCsrfCookie } = useApi()

const passwordForm = reactive({ current_password: '', password: '', password_confirmation: '' })
const passwordErrors = ref<Record<string, string[]>>({})
const passwordSuccess = ref('')
const passwordError = ref('')
const passwordLoading = ref(false)

async function handleUpdatePassword() {
  passwordLoading.value = true
  passwordErrors.value = {}
  passwordSuccess.value = ''
  passwordError.value = ''
  try {
    await fetchCsrfCookie()
    await $api<{ message: string }>('/auth/password', { method: 'PUT', body: { ...passwordForm } })
    passwordSuccess.value = t('security.passwordUpdated')
    passwordForm.current_password = ''
    passwordForm.password = ''
    passwordForm.password_confirmation = ''
  } catch (e: unknown) {
    const err = e as { data?: { errors?: Record<string, string[]>; message?: string } }
    if (err.data?.errors) passwordErrors.value = err.data.errors
    else passwordError.value = err.data?.message || t('security.passwordFailed')
  } finally {
    passwordLoading.value = false
  }
}

interface TfaStatusResponse {
  enabled: boolean
  method: 'email' | 'app' | null
}

interface TfaSetupResponse {
  qr_svg?: string
  secret?: string
  message?: string
}

interface TfaVerifyResponse {
  recovery_codes: string[]
  message?: string
}

interface TfaRecoveryResponse {
  recovery_codes: string[]
}

const tfa = reactive({
  enabled: false,
  method: '' as 'email' | 'app' | '',
  step: 'idle' as 'idle' | 'email' | 'app' | 'disable' | 'recovery',
})

const tfaLoading = ref(true)
const tfaActionLoading = ref(false)
const tfaError = ref('')
const setupData = ref<TfaSetupResponse | null>(null)
const verifyCode = ref('')
const disablePassword = ref('')
const recoveryCodes = ref<string[]>([])
const codesCopied = ref(false)
const selectedMethod = ref('')

async function fetchTfaStatus() {
  tfaLoading.value = true
  try {
    const res = await $api<{ data: TfaStatusResponse }>('/2fa/status')
    tfa.enabled = res.data.enabled
    tfa.method = res.data.method || ''
  } catch {
    tfa.enabled = false
  } finally {
    tfaLoading.value = false
  }
}

async function setupTfa(method: 'email' | 'app') {
  tfa.step = method
  tfaError.value = ''
  setupData.value = null
  try {
    await fetchCsrfCookie()
    const res = await $api<{ data: TfaSetupResponse }>('/2fa/setup', { method: 'POST', body: { method } })
    setupData.value = res.data
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    tfaError.value = err.data?.message || t('common.error')
    tfa.step = 'idle'
  }
}

async function handleVerifyCode() {
  tfaActionLoading.value = true
  tfaError.value = ''
  try {
    await fetchCsrfCookie()
    const res = await $api<{ data: TfaVerifyResponse }>('/2fa/verify', { method: 'POST', body: { code: verifyCode.value } })
    tfa.enabled = true
    tfa.method = tfa.step as 'email' | 'app'
    recoveryCodes.value = res.data.recovery_codes
    verifyCode.value = ''
    setupData.value = null
    tfa.step = 'recovery'
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    tfaError.value = err.data?.message || t('security.invalidCode')
  } finally {
    tfaActionLoading.value = false
  }
}

async function handleDisableTfa() {
  tfaActionLoading.value = true
  tfaError.value = ''
  try {
    await fetchCsrfCookie()
    await $api('/2fa', { method: 'DELETE', body: { password: disablePassword.value } })
    tfa.enabled = false
    tfa.method = ''
    disablePassword.value = ''
    tfa.step = 'idle'
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    tfaError.value = err.data?.message || t('common.error')
  } finally {
    tfaActionLoading.value = false
  }
}

async function handleRegenerateCodes() {
  tfaActionLoading.value = true
  tfaError.value = ''
  try {
    await fetchCsrfCookie()
    const res = await $api<{ data: TfaRecoveryResponse }>('/2fa/recovery-codes', { method: 'POST' })
    recoveryCodes.value = res.data.recovery_codes
    codesCopied.value = false
    tfa.step = 'recovery'
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    tfaError.value = err.data?.message || t('common.error')
  } finally {
    tfaActionLoading.value = false
  }
}

async function copyRecoveryCodes() {
  await navigator.clipboard.writeText(recoveryCodes.value.join('\n'))
  codesCopied.value = true
}

function resetSetup() {
  tfa.step = 'idle'
  setupData.value = null
  verifyCode.value = ''
  tfaError.value = ''
}

onMounted(fetchTfaStatus)
</script>
