<template>
  <div class="grid gap-6 xl:grid-cols-2">
    <div class="space-y-6">
      <section class="rounded-xl border border-white/[0.04] bg-white/[0.02]">
        <div class="border-b border-white/[0.04] px-6 py-4">
          <div class="flex items-center gap-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/[0.04]">
              <svg class="h-4 w-4 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
            </div>
            <div>
              <h2 class="font-display text-[15px] font-bold uppercase tracking-wider">Password</h2>
              <p class="mt-0.5 text-[11px] text-white/20">Change your account password</p>
            </div>
          </div>
        </div>

        <form class="space-y-4 px-6 py-5" @submit.prevent="handleUpdatePassword">
          <FormInput v-model="passwordForm.current_password" id="current-password" label="Current password" type="password" required autocomplete="current-password" placeholder="Enter current password" :error="passwordErrors.current_password?.[0]" />
          <FormInput v-model="passwordForm.password" id="new-password" label="New password" type="password" required autocomplete="new-password" placeholder="Enter new password" :error="passwordErrors.password?.[0]" />
          <FormInput v-model="passwordForm.password_confirmation" id="confirm-password" label="Confirm password" type="password" required autocomplete="new-password" placeholder="Repeat new password" />
          <AlertMessage :message="passwordSuccess" variant="success" />
          <AlertMessage :message="passwordError" variant="error" />
          <AppButton type="submit" :loading="passwordLoading" loading-text="Updating...">Update password</AppButton>
        </form>
      </section>

      <section class="rounded-xl border border-white/[0.04] bg-white/[0.02] px-6 py-5">
        <h3 class="flex items-center gap-2 font-display text-[13px] font-bold uppercase tracking-wider text-white/30">
          <svg class="h-3.5 w-3.5 text-white/15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>
          Security tips
        </h3>
        <ul class="mt-3.5 space-y-3">
          <li class="flex items-start gap-2.5 text-[12px] leading-relaxed text-white/20">
            <svg class="mt-[3px] h-3 w-3 shrink-0 text-red-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
            Use a unique password not shared with other services
          </li>
          <li class="flex items-start gap-2.5 text-[12px] leading-relaxed text-white/20">
            <svg class="mt-[3px] h-3 w-3 shrink-0 text-red-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
            Enable two-factor authentication for maximum protection
          </li>
          <li class="flex items-start gap-2.5 text-[12px] leading-relaxed text-white/20">
            <svg class="mt-[3px] h-3 w-3 shrink-0 text-red-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
            Never share your credentials or verification codes
          </li>
        </ul>
      </section>
    </div>

    <section class="rounded-xl border border-white/[0.04] bg-white/[0.02]">
      <div class="border-b border-white/[0.04] px-6 py-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg" :class="tfa.enabled ? 'bg-emerald-500/10' : 'bg-white/[0.04]'">
              <svg class="h-4 w-4" :class="tfa.enabled ? 'text-emerald-400' : 'text-white/40'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
            </div>
            <div>
              <h2 class="font-display text-[15px] font-bold uppercase tracking-wider">Two-Factor Auth</h2>
              <p class="mt-0.5 text-[11px] text-white/20">Extra layer of protection</p>
            </div>
          </div>
          <div v-if="tfa.enabled" class="flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-3 py-1">
            <span class="relative flex h-1.5 w-1.5"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75" /><span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-400" /></span>
            <span class="text-[11px] font-medium text-emerald-400">Active</span>
          </div>
          <div v-else class="flex items-center gap-1.5 rounded-full bg-white/[0.04] px-3 py-1">
            <span class="h-1.5 w-1.5 rounded-full bg-white/20" />
            <span class="text-[11px] font-medium text-white/25">Disabled</span>
          </div>
        </div>
      </div>

      <div class="px-6 py-5">
        <template v-if="!tfa.enabled && tfa.step === 'idle'">
          <p class="text-[13px] leading-relaxed text-white/30">
            Protect your account by requiring a verification code in addition to your password when signing in.
          </p>
          <div class="mt-5 space-y-2">
            <button @click="tfa.step = 'email'" class="group flex w-full items-center gap-4 rounded-xl border border-white/[0.04] bg-white/[0.02] p-4 text-left transition-all duration-300 hover:border-red-500/15 hover:bg-white/[0.03]">
              <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-red-600/10 transition-colors group-hover:bg-red-600/15">
                <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
              </div>
              <div class="min-w-0 flex-1">
                <div class="text-[14px] font-semibold transition-colors group-hover:text-red-400">Email verification</div>
                <div class="mt-0.5 truncate text-[12px] text-white/20">Receive a code at your email</div>
              </div>
              <svg class="h-4 w-4 shrink-0 text-white/10 transition-all duration-300 group-hover:translate-x-0.5 group-hover:text-red-400/60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
            </button>
            <button @click="tfa.step = 'app'" class="group flex w-full items-center gap-4 rounded-xl border border-white/[0.04] bg-white/[0.02] p-4 text-left transition-all duration-300 hover:border-white/[0.08] hover:bg-white/[0.03]">
              <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-white/[0.04] transition-colors group-hover:bg-white/[0.06]">
                <svg class="h-5 w-5 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" /></svg>
              </div>
              <div class="min-w-0 flex-1">
                <div class="text-[14px] font-semibold transition-colors group-hover:text-white/80">Authenticator app</div>
                <div class="mt-0.5 text-[12px] text-white/20">Google Authenticator, Authy, etc.</div>
              </div>
              <svg class="h-4 w-4 shrink-0 text-white/10 transition-all duration-300 group-hover:translate-x-0.5 group-hover:text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
            </button>
          </div>
        </template>

        <template v-else-if="tfa.enabled">
          <div class="space-y-4">
            <div class="flex items-start gap-3 rounded-lg border border-emerald-500/10 bg-emerald-500/5 px-4 py-3.5">
              <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
              <div>
                <p class="text-[13px] font-medium text-emerald-400">Two-factor authentication is active</p>
                <p class="mt-1 text-[12px] text-white/20">Method: <span class="text-white/40">{{ tfa.method === 'email' ? 'Email verification' : 'Authenticator app' }}</span></p>
              </div>
            </div>
            <div class="rounded-lg border border-white/[0.04] bg-white/[0.02] px-4 py-3">
              <p class="text-[12px] leading-relaxed text-white/25">Make sure to save your recovery codes in a secure location.</p>
            </div>
            <AppButton variant="secondary" @click="tfa.enabled = false; tfa.method = ''">Disable 2FA</AppButton>
          </div>
        </template>

        <div v-else class="space-y-4">
          <div class="flex items-center gap-3">
            <button @click="tfa.step = 'idle'" class="flex h-8 w-8 items-center justify-center rounded-lg text-white/20 transition-colors hover:bg-white/[0.04] hover:text-white/40">
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
            </button>
            <h3 class="font-display text-[14px] font-bold uppercase tracking-wider">{{ tfa.step === 'email' ? 'Email verification' : 'Authenticator app' }}</h3>
          </div>
          <p class="text-[13px] leading-relaxed text-white/30">Setup is available after backend integration.</p>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup lang="ts">
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
    passwordSuccess.value = 'Password updated successfully.'
    passwordForm.current_password = ''
    passwordForm.password = ''
    passwordForm.password_confirmation = ''
  } catch (e: unknown) {
    const err = e as { data?: { errors?: Record<string, string[]>; message?: string } }
    if (err.data?.errors) passwordErrors.value = err.data.errors
    else passwordError.value = err.data?.message || 'Failed to update password.'
  } finally {
    passwordLoading.value = false
  }
}

const tfa = reactive({
  enabled: false,
  method: '' as 'email' | 'app' | '',
  step: 'idle' as 'idle' | 'email' | 'app',
})
</script>
