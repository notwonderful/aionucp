<template>
  <section class="rounded-xl border border-white/[0.04] bg-white/[0.02]">
    <div class="border-b border-white/[0.04] px-6 py-4">
      <div class="flex items-center gap-3">
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-600/10">
          <svg class="h-4 w-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
        </div>
        <div>
          <h2 class="font-display text-[15px] font-bold uppercase tracking-wider">{{ $t('profile.account') }}</h2>
          <p class="mt-0.5 text-[11px] text-white/20">{{ $t('profile.accountDesc') }}</p>
        </div>
      </div>
    </div>

    <form class="max-w-lg space-y-4 px-6 py-5" @submit.prevent="handleUpdateProfile">
      <div>
        <label class="mb-1.5 block text-[12px] font-medium text-white/40">{{ $t('profile.username') }}</label>
        <div class="flex items-center gap-3 rounded-lg border border-white/[0.04] bg-white/[0.015] px-4 py-3">
          <span class="text-[14px] text-white/30">{{ user?.name }}</span>
          <span class="ml-auto rounded bg-white/[0.04] px-2 py-0.5 text-[10px] font-medium uppercase tracking-wider text-white/15">{{ $t('profile.readOnly') }}</span>
        </div>
      </div>

      <FormInput v-model="form.email" id="profile-email" :label="$t('profile.email')" type="email" required autocomplete="email" :error="errors.email?.[0]" />
      <AlertMessage :message="success" variant="success" />
      <AppButton type="submit" :loading="loading" :loading-text="$t('profile.saving')">{{ $t('profile.saveChanges') }}</AppButton>
    </form>
  </section>
</template>

<script setup lang="ts">
const { t } = useI18n()
const { $api, fetchCsrfCookie } = useApi()
const { user, fetchUser } = useAuth()

const form = reactive({ email: user.value?.email ?? '' })
const errors = ref<Record<string, string[]>>({})
const success = ref('')
const loading = ref(false)

watch(() => user.value?.email, (v) => { if (v) form.email = v })

async function handleUpdateProfile() {
  loading.value = true
  errors.value = {}
  success.value = ''
  try {
    await fetchCsrfCookie()
    await $api('/profile', { method: 'PATCH', body: { email: form.email } })
    await fetchUser()
    success.value = t('profile.profileUpdated')
  } catch (e: unknown) {
    const err = e as { data?: { errors?: Record<string, string[]> } }
    if (err.data?.errors) errors.value = err.data.errors
  } finally {
    loading.value = false
  }
}
</script>
