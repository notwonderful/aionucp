<template>
  <div>
    <button @click="handleBack" class="mb-6 flex items-center gap-2 text-[12px] text-white/20 transition-colors hover:text-white/40">
      <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
      {{ $t('common.back') }}
    </button>

    <h1 class="font-display text-3xl font-extrabold uppercase tracking-tight">{{ $t('auth.twoFactorTitle') }}</h1>
    <p class="mt-2 text-[14px] text-white/30">
      {{ method === 'email' ? $t('auth.twoFactorEmailDesc') : $t('auth.twoFactorAppDesc') }}
    </p>

    <form class="mt-10 space-y-5" @submit.prevent="handleVerify">
      <FormInput
        v-if="!useRecovery"
        v-model="code"
        id="2fa-code"
        :label="$t('auth.verificationCode')"
        type="text"
        required
        :placeholder="$t('auth.codePlaceholder')"
        inputmode="numeric"
        autocomplete="one-time-code"
      />
      <FormInput
        v-else
        v-model="code"
        id="recovery-code"
        :label="$t('auth.recoveryCode')"
        type="text"
        required
        :placeholder="$t('auth.recoveryCodePlaceholder')"
      />

      <AlertMessage :message="errorMessage" variant="error" />

      <AppButton type="submit" :loading="isLoading" :loading-text="$t('auth.verifying')" block>{{ $t('auth.verify') }}</AppButton>
    </form>

    <button @click="useRecovery = !useRecovery" class="mt-4 w-full text-center text-[12px] text-white/20 transition-colors hover:text-white/40">
      {{ useRecovery ? $t('auth.useVerificationCode') : $t('auth.useRecoveryCode') }}
    </button>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'auth', middleware: 'guest' })

const { t } = useI18n()
const localePath = useLocalePath()
const { $api, fetchCsrfCookie } = useApi()

const token = ref('')
const method = ref<'email' | 'app'>('app')

onMounted(() => {
  token.value = sessionStorage.getItem('2fa_token') || ''
  method.value = (sessionStorage.getItem('2fa_method') as 'email' | 'app') || 'app'

  if (!token.value) {
    navigateTo(localePath('/login'))
  }
})

const code = ref('')
const useRecovery = ref(false)
const errorMessage = ref('')
const isLoading = ref(false)

function handleBack() {
  sessionStorage.removeItem('2fa_token')
  sessionStorage.removeItem('2fa_method')
  navigateTo(localePath('/login'))
}

async function handleVerify() {
  isLoading.value = true
  errorMessage.value = ''
  try {
    await fetchCsrfCookie()
    await $api('/auth/verify-2fa', {
      method: 'POST',
      body: {
        two_factor_token: token.value,
        code: code.value,
        recovery: useRecovery.value,
      },
    })
    sessionStorage.removeItem('2fa_token')
    sessionStorage.removeItem('2fa_method')
    await navigateTo(localePath('/dashboard'))
  } catch (e: unknown) {
    const error = e as { data?: { message?: string } }
    errorMessage.value = error.data?.message || t('auth.invalidCode')
  } finally {
    isLoading.value = false
  }
}
</script>
