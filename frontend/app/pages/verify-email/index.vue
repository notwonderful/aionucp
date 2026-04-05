<template>
  <div>
    <h1 class="font-display text-3xl font-extrabold uppercase tracking-tight">{{ $t('verify.title') }}</h1>
    <p class="mt-2 text-[14px] text-white/30">{{ $t('verify.desc') }}</p>

    <div class="mt-10 space-y-5">
      <AlertMessage :message="successMsg" variant="success" />
      <AlertMessage :message="errorMsg" variant="error" />

      <AppButton :loading="sending" :loading-text="$t('verify.sending')" block @click="resend">
        {{ $t('verify.resend') }}
      </AppButton>

      <AppButton variant="ghost" block @click="handleLogout">
        {{ $t('verify.logout') }}
      </AppButton>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'auth', middleware: 'auth' })

const { $api, fetchCsrfCookie } = useApi()
const { logout, isVerified } = useAuth()
const { t } = useI18n()
const localePath = useLocalePath()

const sending = ref(false)
const successMsg = ref('')
const errorMsg = ref('')

if (isVerified.value) {
  navigateTo(localePath('/dashboard'))
}

async function resend() {
  sending.value = true
  successMsg.value = ''
  errorMsg.value = ''

  try {
    await fetchCsrfCookie()
    await $api('/auth/email/verify/resend', { method: 'POST' })
    successMsg.value = t('verify.sent')
  } catch (e: unknown) {
    const err = e as { status?: number }
    errorMsg.value = err.status === 429 ? t('verify.tooMany') : t('verify.failed')
  } finally {
    sending.value = false
  }
}

async function handleLogout() {
  await logout()
}
</script>
