<template>
  <div>
    <div class="mb-8">
      <h1 class="font-display text-2xl font-extrabold uppercase tracking-tight lg:text-3xl">{{ $t('profile.settings') }}</h1>
      <p class="mt-1 text-[13px] text-white/25">{{ $t('profile.settingsDesc') }}</p>
    </div>

    <div class="mb-6 flex gap-2 overflow-x-auto pb-1">
      <NuxtLink
        v-for="tab in tabs" :key="tab.to"
        :to="tab.to"
        :class="['flex shrink-0 items-center gap-2 rounded-lg px-4 py-2.5 text-[13px] font-medium transition-all duration-300',
          isActive(tab.to)
            ? 'bg-red-600/15 text-red-400'
            : 'bg-white/[0.03] text-white/30 hover:bg-white/[0.05] hover:text-white/50']"
      >
        <component :is="tab.icon" class="h-4 w-4" />
        {{ tab.label }}
      </NuxtLink>
    </div>

    <NuxtPage />
  </div>
</template>

<script setup lang="ts">
import { h } from 'vue'

definePageMeta({ layout: 'dashboard', middleware: 'auth' })

const route = useRoute()

const IconUser = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '1.5' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z' }),
])
const IconShield = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '1.5' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z' }),
])
const IconHistory = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '1.5' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z' }),
])

const { t } = useI18n()

const tabs = computed(() => [
  { label: t('profile.profileTab'), to: '/profile', icon: IconUser },
  { label: t('profile.securityTab'), to: '/profile/security', icon: IconShield },
  { label: t('profile.historyTab'), to: '/profile/history', icon: IconHistory },
])

function isActive(to: string) {
  if (to === '/profile') return route.path === '/profile' || route.path === '/profile/'
  return route.path.startsWith(to)
}
</script>
