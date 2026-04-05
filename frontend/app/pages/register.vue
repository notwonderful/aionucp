<template>
  <div>
    <h1 class="font-display text-3xl font-extrabold uppercase tracking-tight">{{ $t('auth.createAccount') }}</h1>
    <p class="mt-2 text-[14px] text-white/30">{{ $t('auth.createAccountDesc') }}</p>

    <form class="mt-10 space-y-5" @submit.prevent="handleRegister">
      <!-- Username -->
      <FormInput v-model="form.name" id="name" :label="$t('auth.username')" required autocomplete="username" :placeholder="$t('auth.chooseUsername')" :error="errors.name?.[0]" />

      <!-- Email -->
      <FormInput v-model="form.email" id="email" :label="$t('auth.email')" type="email" required autocomplete="email" :placeholder="$t('auth.email')" :error="errors.email?.[0]" />

      <!-- Password -->
      <FormInput v-model="form.password" id="password" :label="$t('auth.password')" type="password" required autocomplete="new-password" :placeholder="$t('auth.enterPassword')" :error="errors.password?.[0]" />

      <!-- Confirm password -->
      <FormInput v-model="form.password_confirmation" id="password_confirmation" :label="$t('auth.confirmPassword')" type="password" required autocomplete="new-password" :placeholder="$t('auth.repeatPassword')" />

      <!-- Referral code -->
      <div>
        <label for="ref_code" class="mb-1.5 block text-[12px] font-medium text-white/40">
          {{ $t('auth.referralCode') }} <span class="text-white/15">({{ $t('auth.optional') }})</span>
        </label>
        <FormInput v-model="form.ref_code" id="ref_code" autocomplete="off" :placeholder="$t('auth.enterCode')" :error="errors.ref_code?.[0]" />
      </div>

      <!-- Error -->
      <AlertMessage :message="errorMessage" variant="error" />

      <!-- Submit -->
      <AppButton type="submit" :loading="isLoading" :loading-text="$t('auth.creating')" block>{{ $t('auth.createAccount') }}</AppButton>
    </form>

    <!-- Divider -->
    <div class="my-8 flex items-center gap-4">
      <div class="h-px flex-1 bg-white/[0.04]" />
      <span class="text-[11px] text-white/15">{{ $t('auth.or') }}</span>
      <div class="h-px flex-1 bg-white/[0.04]" />
    </div>

    <p class="text-center text-[13px] text-white/30">
      {{ $t('auth.alreadyHaveAccount') }}
      <NuxtLink :to="localePath('/login')" class="font-medium text-red-400 transition-colors hover:text-red-300">{{ $t('auth.signIn') }}</NuxtLink>
    </p>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'auth', middleware: 'guest' })

const { t } = useI18n()
const localePath = useLocalePath()
const form = reactive({ name: '', email: '', password: '', password_confirmation: '', ref_code: '' })
const { $api, fetchCsrfCookie } = useApi()
const { getToken } = useRecaptcha()
const errors = ref<Record<string, string[]>>({})
const errorMessage = ref('')
const isLoading = ref(false)

async function handleRegister() {
  isLoading.value = true
  errors.value = {}
  errorMessage.value = ''
  try {
    const recaptchaToken = await getToken('submitRegister')
    await fetchCsrfCookie()
    await $api('/auth/register', {
      method: 'POST',
      body: {
        name: form.name, email: form.email, password: form.password,
        password_confirmation: form.password_confirmation,
        ref_code: form.ref_code || undefined,
        'g-recaptcha-response': recaptchaToken,
      },
    })
    await navigateTo('/login')
  } catch (e: unknown) {
    const error = e as { data?: { message?: string; errors?: Record<string, string[]> } }
    if (error.data?.errors) errors.value = error.data.errors
    errorMessage.value = error.data?.message || t('auth.errorGeneric')
  } finally {
    isLoading.value = false
  }
}
</script>
