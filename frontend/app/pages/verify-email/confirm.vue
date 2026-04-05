<template>
  <div>
    <h1 class="font-display text-3xl font-extrabold uppercase tracking-tight">{{ $t('verify.title') }}</h1>

    <div class="mt-10">
      <div v-if="verifying" class="flex items-center gap-3 text-[14px] text-white/30">
        <svg class="h-5 w-5 animate-spin text-red-500" viewBox="0 0 24 24" fill="none">
          <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25" />
          <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" class="opacity-75" />
        </svg>
        {{ $t('verify.verifying') }}
      </div>

      <AlertMessage :message="successMsg" variant="success" />
      <AlertMessage :message="errorMsg" variant="error" />

      <NuxtLink v-if="done" :to="localePath('/dashboard')" class="mt-6 inline-block text-[12px] font-bold uppercase tracking-widest text-red-500 hover:text-red-400">
        {{ $t('verify.goToDashboard') }} &rarr;
      </NuxtLink>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'auth', middleware: 'auth' })

const route = useRoute()
const { $api, fetchCsrfCookie } = useApi()
const { fetchUser } = useAuth()
const { t } = useI18n()
const localePath = useLocalePath()

const verifying = ref(true)
const done = ref(false)
const successMsg = ref('')
const errorMsg = ref('')

onMounted(async () => {
  const raw = window.location.href
  const marker = 'verify_url='
  const idx = raw.indexOf(marker)
  const verifyUrl = idx !== -1 ? decodeURIComponent(raw.slice(idx + marker.length)) : null

  let apiPath: string
  try {
    const url = new URL(verifyUrl)
    if (!/^\/api\/auth\/email\/verify\/\d+\/[a-f0-9]+$/.test(url.pathname)) throw new Error()
    apiPath = url.pathname.replace(/^\/api/, '') + url.search
  } catch {
    errorMsg.value = t('verify.invalidLink')
    verifying.value = false
    return
  }

  try {
    await fetchCsrfCookie()
    await $api(apiPath)
    successMsg.value = t('verify.verified')
    done.value = true
    await fetchUser()
  } catch {
    errorMsg.value = t('verify.failedVerify')
  } finally {
    verifying.value = false
  }
})
</script>
