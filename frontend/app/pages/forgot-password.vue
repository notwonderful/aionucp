<template>
  <div>
    <!-- Back link -->
    <NuxtLink :to="localePath('/login')" class="mb-8 inline-flex items-center gap-1.5 text-[12px] font-medium text-white/25 transition-colors hover:text-white/50">
      <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
      {{ $t('auth.signIn') }}
    </NuxtLink>

    <h1 class="font-display text-3xl font-extrabold uppercase tracking-tight">{{ $t('auth.resetPassword') }}</h1>
    <p class="mt-2 max-w-xs text-[14px] text-white/30">{{ $t('auth.resetPasswordDesc') }}</p>

    <!-- Success state -->
    <div v-if="sent" class="mt-10 rounded-lg border border-emerald-500/15 bg-emerald-500/[0.05] px-5 py-4">
      <div class="flex items-start gap-3">
        <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <div>
          <p class="text-[14px] font-medium text-emerald-300">{{ $t('auth.checkEmail') }}</p>
          <p class="mt-1 text-[13px] text-emerald-300/50">{{ $t('auth.checkEmailDesc') }}</p>
        </div>
      </div>
    </div>

    <!-- Form -->
    <form v-else class="mt-10 space-y-5" @submit.prevent="handleSubmit">
      <FormInput v-model="form.email" id="email" :label="$t('auth.email')" type="email" required autocomplete="email" :placeholder="$t('auth.email')" :error="errors.email?.[0]" />

      <AlertMessage :message="errorMessage" variant="error" />

      <AppButton type="submit" :loading="isLoading" :loading-text="$t('auth.sending')" block>{{ $t('auth.sendResetLink') }}</AppButton>
    </form>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'auth', middleware: 'guest' })

const { t } = useI18n()
const localePath = useLocalePath()
const form = reactive({ email: '' })
const { $api, fetchCsrfCookie } = useApi()
const errors = ref<Record<string, string[]>>({})
const errorMessage = ref('')
const isLoading = ref(false)
const sent = ref(false)

async function handleSubmit() {
  isLoading.value = true
  errors.value = {}
  errorMessage.value = ''
  try {
    await fetchCsrfCookie()
    await $api('/auth/forgot-password', {
      method: 'POST',
      body: { email: form.email },
    })
    sent.value = true
  } catch (e: unknown) {
    const error = e as { data?: { message?: string; errors?: Record<string, string[]> } }
    if (error.data?.errors) errors.value = error.data.errors
    errorMessage.value = error.data?.message || t('auth.errorGeneric')
  } finally {
    isLoading.value = false
  }
}
</script>
