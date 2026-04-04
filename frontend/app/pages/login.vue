<template>
  <div>
    <h1 class="font-display text-3xl font-extrabold uppercase tracking-tight">Sign in</h1>
    <p class="mt-2 text-[14px] text-white/30">Enter the world of Atreia</p>

    <form class="mt-10 space-y-5" @submit.prevent="handleLogin">
      <!-- Email -->
      <FormInput v-model="form.email" id="email" label="Email" type="email" required autocomplete="email" placeholder="your@email.com" :error="errors.email?.[0]" />

      <!-- Password -->
      <div>
        <div class="mb-1.5 flex items-center justify-between">
          <label for="password" class="text-[12px] font-medium text-white/40">Password</label>
          <NuxtLink to="/forgot-password" class="text-[11px] font-medium text-white/20 transition-colors hover:text-red-400">Forgot?</NuxtLink>
        </div>
        <FormInput v-model="form.password" id="password" type="password" required autocomplete="current-password" placeholder="Enter password" :error="errors.password?.[0]" />
      </div>

      <!-- Remember -->
      <label class="flex cursor-pointer items-center gap-2.5">
        <input v-model="form.remember" type="checkbox"
          class="h-4 w-4 rounded border-white/10 bg-white/[0.03] text-red-600 focus:ring-red-500/20" />
        <span class="text-[13px] text-white/30">Remember me</span>
      </label>

      <!-- Error -->
      <AlertMessage :message="errorMessage" variant="error" />

      <!-- Submit -->
      <AppButton type="submit" :loading="isLoading" loading-text="Signing in..." block>Sign in</AppButton>
    </form>

    <!-- Divider -->
    <div class="my-8 flex items-center gap-4">
      <div class="h-px flex-1 bg-white/[0.04]" />
      <span class="text-[11px] text-white/15">or</span>
      <div class="h-px flex-1 bg-white/[0.04]" />
    </div>

    <!-- Register link -->
    <p class="text-center text-[13px] text-white/30">
      No account?
      <NuxtLink to="/register" class="font-medium text-red-400 transition-colors hover:text-red-300">Create one</NuxtLink>
    </p>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'auth', middleware: 'guest' })

const form = reactive({ email: '', password: '', remember: false })
const { $api, fetchCsrfCookie } = useApi()
const { getToken } = useRecaptcha()
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
    await $api('/auth/login', {
      method: 'POST',
      body: { email: form.email, password: form.password, remember: form.remember, 'g-recaptcha-response': recaptchaToken },
    })
    await navigateTo('/dashboard')
  } catch (e: unknown) {
    const error = e as { data?: { message?: string; errors?: Record<string, string[]> } }
    if (error.data?.errors) errors.value = error.data.errors
    errorMessage.value = error.data?.message || 'An error occurred. Please try again.'
  } finally {
    isLoading.value = false
  }
}
</script>
