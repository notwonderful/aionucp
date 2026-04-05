<template>
  <div>
    <h1 class="font-display text-3xl font-extrabold uppercase tracking-tight">{{ $t('auth.signIn') }}</h1>
    <p class="mt-2 text-[14px] text-white/30">{{ $t('auth.signInDesc') }}</p>

    <form class="mt-10 space-y-5" @submit.prevent="handleLogin">
      <FormInput v-model="form.email" id="email" :label="$t('auth.email')" type="email" required autocomplete="email" :placeholder="$t('auth.email')" :error="errors.email?.[0]" />

      <div>
        <div class="mb-1.5 flex items-center justify-between">
          <label for="password" class="text-[12px] font-medium text-white/40">{{ $t('auth.password') }}</label>
          <NuxtLink :to="localePath('/forgot-password')" class="text-[11px] font-medium text-white/20 transition-colors hover:text-red-400">{{ $t('auth.forgotPassword') }}</NuxtLink>
        </div>
        <FormInput v-model="form.password" id="password" type="password" required autocomplete="current-password" :placeholder="$t('auth.enterPassword')" :error="errors.password?.[0]" />
      </div>

      <label class="flex cursor-pointer items-center gap-2.5">
        <input v-model="form.remember" type="checkbox"
          class="h-4 w-4 rounded border-white/10 bg-white/[0.03] text-red-600 focus:ring-red-500/20" />
        <span class="text-[13px] text-white/30">{{ $t('auth.rememberMe') }}</span>
      </label>

      <AlertMessage :message="errorMessage" variant="error" />

      <AppButton type="submit" :loading="isLoading" :loading-text="$t('auth.signingIn')" block>{{ $t('auth.signIn') }}</AppButton>
    </form>

    <div class="my-8 flex items-center gap-4">
      <div class="h-px flex-1 bg-white/[0.04]" />
      <span class="text-[11px] text-white/15">{{ $t('auth.or') }}</span>
      <div class="h-px flex-1 bg-white/[0.04]" />
    </div>

    <p class="text-center text-[13px] text-white/30">
      {{ $t('auth.noAccount') }}
      <NuxtLink :to="localePath('/register')" class="font-medium text-red-400 transition-colors hover:text-red-300">{{ $t('auth.createOne') }}</NuxtLink>
    </p>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'auth', middleware: 'guest' })

const { t } = useI18n()
const localePath = useLocalePath()
const { $api, fetchCsrfCookie } = useApi()
const { getToken } = useRecaptcha()

const form = reactive({ email: '', password: '', remember: false })
const errors = ref<Record<string, string[]>>({})
const errorMessage = ref('')
const isLoading = ref(false)

async function handleLogin() {
  isLoading.value = true
  errors.value = {}
  errorMessage.value = ''
  try {
    const recaptchaToken = await getToken('submitLogin')
    await fetchCsrfCookie()
    const res = await $api<{ requires_2fa?: boolean; two_factor_token?: string; method?: string }>('/auth/login', {
      method: 'POST',
      body: { email: form.email, password: form.password, remember: form.remember, 'g-recaptcha-response': recaptchaToken },
    })
    if (res.requires_2fa && res.two_factor_token) {
      sessionStorage.setItem('2fa_token', res.two_factor_token)
      sessionStorage.setItem('2fa_method', res.method || 'app')
      await navigateTo(localePath('/auth/two-factor'))
    } else {
      await navigateTo(localePath('/dashboard'))
    }
  } catch (e: unknown) {
    const error = e as { data?: { message?: string; errors?: Record<string, string[]> } }
    if (error.data?.errors) errors.value = error.data.errors
    errorMessage.value = error.data?.message || t('auth.errorGeneric')
  } finally {
    isLoading.value = false
  }
}
</script>
