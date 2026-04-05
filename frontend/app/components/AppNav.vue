<template>
  <!-- ANNOUNCEMENT BAR -->
  <div v-if="showAnnounce" class="fixed top-0 left-0 right-0 z-50 flex items-center justify-center gap-3 bg-red-600 px-4 py-2 text-center">
    <span class="text-[12px] font-medium text-white/90">{{ t('announce.text') }}</span>
    <a href="#" class="text-[12px] font-bold text-white underline underline-offset-2">{{ t('announce.link') }}</a>
    <button class="absolute right-3 top-1/2 -translate-y-1/2 text-white/50 transition-colors hover:text-white" @click="showAnnounce = false">
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
    </button>
  </div>

  <!-- NAV -->
  <nav :class="[
    'fixed left-0 right-0 z-40 transition-all duration-700 ease-[cubic-bezier(0.32,0.72,0,1)]',
    showAnnounce ? 'top-[36px]' : 'top-0',
    scrolled
      ? 'bg-surface/90 backdrop-blur-xl shadow-[0_4px_30px_rgba(0,0,0,0.5)]'
      : 'bg-gradient-to-b from-black/70 to-transparent',
  ]">
    <div class="mx-auto flex max-w-[1280px] items-center justify-between px-6 py-4">
      <!-- Logo -->
      <NuxtLink to="/" class="group flex items-center gap-2.5">
        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-600/15 ring-1 ring-red-500/20 transition-all duration-300 group-hover:bg-red-600/25 group-hover:ring-red-500/40">
          <svg class="h-4 w-4 text-red-500" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        </div>
        <span class="font-display text-xl font-extrabold tracking-tight text-white">AION<span class="text-red-500">UCP</span></span>
      </NuxtLink>

      <!-- Nav links -->
      <div class="hidden items-center gap-7 md:flex">
        <NuxtLink v-for="lnk in navLinks" :key="lnk.href" :to="localePath(lnk.href)"
          :class="['group relative py-1 text-[12px] font-medium uppercase tracking-widest transition-colors duration-300',
            isActive(lnk.href) ? 'text-white' : 'text-white/40 hover:text-white']">
          {{ t(lnk.key) }}
          <span :class="['absolute bottom-0 left-1/2 h-[2px] -translate-x-1/2 rounded-full bg-red-500 transition-all duration-300',
            isActive(lnk.href) ? 'w-full' : 'w-0 group-hover:w-full']" />
        </NuxtLink>
      </div>

      <!-- Right zone -->
      <div class="flex items-center gap-4">
        <div class="hidden items-center gap-1 sm:flex">
          <NuxtLink v-for="l in (['en','ru'] as const)" :key="l" :to="switchLocalePath(l)"
            :class="['rounded px-2 py-1 text-[10px] font-bold uppercase transition-all duration-300',
              locale===l ? 'bg-white/[0.08] text-white' : 'text-white/20 hover:text-white/50']">{{ l }}</NuxtLink>
        </div>
        <div class="hidden h-5 w-px bg-white/[0.08] sm:block" />
        <template v-if="isAuthenticated">
          <NuxtLink :to="localePath('/dashboard')"
            class="rounded-lg bg-red-600 px-5 py-2.5 text-[11px] font-bold uppercase tracking-widest text-white shadow-[0_0_15px_rgba(220,60,60,0.15)] transition-all duration-300 hover:bg-red-500 hover:shadow-[0_0_25px_rgba(220,60,60,0.35)] active:scale-[0.97]">
            Dashboard
          </NuxtLink>
        </template>
        <template v-else>
          <NuxtLink :to="localePath('/login')" class="hidden text-[12px] font-medium text-white/30 transition-colors duration-300 hover:text-white/60 sm:block">
            {{ t('nav.signin') }}
          </NuxtLink>
          <NuxtLink :to="localePath('/register')"
            class="rounded-lg bg-red-600 px-5 py-2.5 text-[11px] font-bold uppercase tracking-widest text-white shadow-[0_0_15px_rgba(220,60,60,0.15)] transition-all duration-300 hover:bg-red-500 hover:shadow-[0_0_25px_rgba(220,60,60,0.35)] active:scale-[0.97]">
            {{ t('nav.play') }}
          </NuxtLink>
        </template>
        <!-- Mobile hamburger -->
        <button class="flex h-9 w-9 items-center justify-center rounded-lg text-white/40 transition-colors hover:bg-white/[0.06] hover:text-white md:hidden" @click="mobileMenu = !mobileMenu">
          <svg v-if="!mobileMenu" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" /></svg>
          <svg v-else class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
      </div>
    </div>

    <!-- Mobile menu -->
    <div v-if="mobileMenu" class="border-t border-white/[0.04] bg-surface/95 px-6 pb-6 pt-4 backdrop-blur-xl md:hidden">
      <div class="flex flex-col gap-1">
        <NuxtLink v-for="lnk in navLinks" :key="lnk.href" :to="localePath(lnk.href)"
          :class="['rounded-lg px-3 py-3 text-[13px] font-medium uppercase tracking-widest transition-colors',
            isActive(lnk.href) ? 'bg-white/[0.04] text-white' : 'text-white/50 hover:bg-white/[0.04] hover:text-white']"
          @click="mobileMenu = false">
          {{ t(lnk.key) }}
        </NuxtLink>
      </div>
      <div class="mt-4 flex items-center gap-2 border-t border-white/[0.04] pt-4">
        <NuxtLink v-for="l in (['en','ru'] as const)" :key="l" :to="switchLocalePath(l)"
          :class="['rounded px-3 py-1.5 text-[11px] font-bold uppercase',
            locale===l ? 'bg-white/[0.08] text-white' : 'text-white/25']">{{ l }}</NuxtLink>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
const { locale, t } = useI18n()
const switchLocalePath = useSwitchLocalePath()
const localePath = useLocalePath()
const route = useRoute()
const { isAuthenticated } = useAuth()

const showAnnounce = ref(true)
const mobileMenu = ref(false)
const scrolled = ref(false)

const navLinks = [
  { key: 'nav.start', href: '/start' },
  { key: 'nav.news', href: '/news' },
  { key: 'nav.rankings', href: '/rankings' },
  { key: 'nav.siege', href: '/schedule' },
  { key: 'nav.wiki', href: '/wiki' },
]

function isActive(href: string): boolean {
  if (href.startsWith('/#')) return false
  return route.path === href || route.path.startsWith(href + '/')
}

onMounted(() => {
  const fn = () => { scrolled.value = window.scrollY > 60 }
  window.addEventListener('scroll', fn, { passive: true })
  onUnmounted(() => window.removeEventListener('scroll', fn))
})

watch(() => route.path, () => { mobileMenu.value = false })
</script>
