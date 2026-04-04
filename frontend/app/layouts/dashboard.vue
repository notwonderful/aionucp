<template>
  <div class="flex h-[100dvh] bg-surface font-body text-white">
    <!-- Mobile overlay -->
    <div v-if="sidebarOpen" class="fixed inset-0 z-30 bg-black/60 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false" />

    <!-- Sidebar -->
    <aside
      :class="['fixed z-40 flex h-full w-[260px] shrink-0 flex-col bg-surface-dark transition-transform duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] lg:static lg:translate-x-0',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full']">
      <!-- Logo -->
      <div class="flex items-center gap-2.5 px-6 py-5">
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-600/15 ring-1 ring-red-500/20">
          <svg class="h-3.5 w-3.5 text-red-500" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        </div>
        <NuxtLink to="/dashboard" class="font-display text-lg font-extrabold tracking-tight">AION<span class="text-red-500">UCP</span></NuxtLink>
      </div>

      <!-- Nav -->
      <nav class="flex-1 overflow-y-auto px-3 py-4">
        <div class="space-y-0.5">
          <NuxtLink v-for="item in navItems" :key="item.to" :to="item.to"
            :class="['group flex items-center gap-3 rounded-lg px-4 py-2.5 text-[13px] font-medium transition-all duration-300',
              isActiveNav(item.to)
                ? 'bg-red-600/10 text-white'
                : 'text-white/30 hover:bg-white/[0.03] hover:text-white/60']"
            @click="sidebarOpen = false">
            <component :is="item.iconComponent" class="h-[18px] w-[18px] shrink-0" />
            {{ item.label }}
            <span v-if="isActiveNav(item.to)" class="ml-auto h-1.5 w-1.5 rounded-full bg-red-500" />
          </NuxtLink>
        </div>

        <template v-if="isAdmin">
          <div class="my-4 border-t border-white/[0.04]" />
          <NuxtLink to="/admin"
            :class="['group flex items-center gap-3 rounded-lg px-4 py-2.5 text-[13px] font-medium transition-all duration-300',
              isActiveNav('/admin')
                ? 'bg-red-600/10 text-white'
                : 'text-white/30 hover:bg-white/[0.03] hover:text-white/60']"
            @click="sidebarOpen = false">
            <component :is="IconAdminTickets" class="h-[18px] w-[18px] shrink-0" />
            {{ $t('layout.adminPanel') }}
            <span v-if="isActiveNav('/admin')" class="ml-auto h-1.5 w-1.5 rounded-full bg-red-500" />
          </NuxtLink>
        </template>
      </nav>

      <!-- Bottom -->
      <div class="space-y-2 border-t border-white/[0.04] p-3">
        <NuxtLink to="/" class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-[13px] font-medium text-white/20 transition-colors hover:bg-white/[0.03] hover:text-white/40">
          <svg class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
          {{ $t('layout.backToSite') }}
        </NuxtLink>
        <button @click="showLogoutModal = true"
          class="flex w-full items-center gap-3 rounded-lg px-4 py-2.5 text-[13px] font-medium text-red-400/60 transition-all duration-300 hover:bg-red-600/10 hover:text-red-400">
          <svg class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
          {{ $t('layout.logout') }}
        </button>
      </div>
    </aside>

    <!-- Main -->
    <div class="flex flex-1 flex-col overflow-hidden">
      <!-- Top bar -->
      <header class="flex shrink-0 items-center justify-between border-b border-white/[0.04] px-6 py-4">
        <button class="flex h-9 w-9 items-center justify-center rounded-lg text-white/30 transition-colors hover:bg-white/[0.04] hover:text-white lg:hidden" @click="sidebarOpen = !sidebarOpen">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" /></svg>
        </button>

        <div class="hidden text-[13px] text-white/20 lg:block">
          {{ navItems.find(i => i.to === route.path)?.label || 'Dashboard' }}
        </div>

        <div class="flex items-center gap-3">
          <div class="flex items-center gap-2 rounded-lg bg-red-600/10 px-3 py-1.5">
            <span class="font-display text-[14px] font-bold tabular-nums text-red-400">{{ user?.balance ?? 0 }}</span>
            <span class="text-[10px] font-medium uppercase tracking-wider text-red-400/50">{{ $t('common.toll') }}</span>
          </div>
          <div class="h-5 w-px bg-white/[0.06]" />
          <div class="relative">
            <button @click="notifOpen = !notifOpen" class="flex h-9 w-9 items-center justify-center rounded-lg text-white/30 transition-colors hover:bg-white/[0.04] hover:text-white/50">
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
              <span v-if="unreadCount" class="notif-badge absolute -right-0.5 -top-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[9px] font-bold text-white">{{ unreadCount }}</span>
            </button>
            <Transition name="dropdown">
              <div v-if="notifOpen" class="absolute right-0 top-full z-50 mt-2 w-80 rounded-xl border border-white/[0.06] bg-surface-light shadow-2xl">
                <div class="flex items-center justify-between border-b border-white/[0.04] px-4 py-3">
                  <span class="font-display text-[13px] font-bold uppercase tracking-wider">{{ $t('layout.notifications') }}</span>
                  <button v-if="unreadCount" @click="markAllRead" class="text-[11px] font-medium text-white/20 transition-colors hover:text-red-400">{{ $t('layout.markAllRead') }}</button>
                </div>
                <div>
                  <NuxtLink v-for="n in recentNotifications" :key="n.id"
                    :to="nLink(n)" @click="notifOpen = false"
                    :class="['flex gap-3 border-b border-white/[0.04] px-4 py-3 transition-colors hover:bg-white/[0.03]', !n.read_at ? 'bg-white/[0.02]' : '']">
                    <div :class="['mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg',
                      nType(n) === 'purchase' ? 'bg-red-600/10' : nType(n) === 'ticket' ? 'bg-emerald-500/10' : nType(n) === 'promo' ? 'bg-gold-500/10' : 'bg-white/[0.04]']">
                      <svg v-if="nType(n) === 'purchase'" class="h-4 w-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
                      <svg v-else-if="nType(n) === 'ticket'" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" /></svg>
                      <svg v-else-if="nType(n) === 'promo'" class="h-4 w-4 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21" /></svg>
                      <svg v-else class="h-4 w-4 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" /></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                      <p class="text-[12px] leading-relaxed text-white/50">{{ nText(n) }}</p>
                      <span class="mt-1 block text-[10px] text-white/15">{{ formatNotifTime(n.created_at) }}</span>
                    </div>
                    <span v-if="!n.read_at" class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-red-500" />
                  </NuxtLink>
                </div>
                <div v-if="!notifications.length" class="px-4 py-8 text-center text-[12px] text-white/20">{{ $t('layout.noNotifications') }}</div>
                <NuxtLink v-if="notifications.length" to="/profile/history" @click="notifOpen = false"
                  class="block border-t border-white/[0.04] px-4 py-3 text-center text-[12px] font-medium text-white/20 transition-colors hover:bg-white/[0.03] hover:text-white/40">
                  {{ $t('layout.viewAllActivity') }}
                </NuxtLink>
              </div>
            </Transition>
          </div>
          <div class="h-5 w-px bg-white/[0.06]" />
          <span class="text-[13px] font-medium text-white/40">{{ user?.name }}</span>
        </div>
      </header>

      <!-- Content -->
      <main class="flex-1 overflow-y-auto p-6 lg:p-8">
        <slot />
      </main>
    </div>

    <AppModal :open="showLogoutModal" :title="$t('layout.logout')" size="sm" @close="showLogoutModal = false">
      <template #icon>
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-600/10">
          <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
        </div>
      </template>
      <p class="text-[13px] leading-relaxed text-white/40">{{ $t('layout.logoutDesc') }}</p>
      <template #footer>
        <button @click="showLogoutModal = false"
          class="flex-1 rounded-lg border border-white/[0.06] bg-white/[0.03] py-3 font-display text-[12px] font-bold uppercase tracking-widest text-white/40 transition-all duration-300 hover:bg-white/[0.06] hover:text-white/60">
          {{ $t('common.cancel') }}
        </button>
        <button @click="confirmLogout" class="logout-confirm flex-1 rounded-lg py-3 font-display text-[12px] font-bold uppercase tracking-widest transition-all duration-300 hover:shadow-[0_0_30px_rgba(220,60,60,0.2)] active:scale-[0.98]">
          {{ $t('layout.logout') }}
        </button>
      </template>
    </AppModal>
  </div>
</template>

<script setup lang="ts">
import { h } from 'vue'

const { user, isAdmin, logout } = useAuth()
const { relative: formatNotifTime } = useDate()
const route = useRoute()
const sidebarOpen = ref(false)
const notifOpen = ref(false)
const showLogoutModal = ref(false)

interface Notification { id: string; type: string; data: { type?: string; text?: string; subject?: string; preview?: string; sender?: string; [key: string]: unknown }; read_at: string | null; created_at: string }

const { $api, fetchCsrfCookie } = useApi()
const notifications = ref<Notification[]>([])
const unreadCount = ref(0)

async function fetchNotifications() {
  try {
    const res = await $api<{ data: Notification[]; unread_count: number }>('/notifications')
    notifications.value = res.data
    unreadCount.value = res.unread_count
  } catch { /* ignore */ }
}

async function markAllRead() {
  await fetchCsrfCookie()
  await $api('/notifications/read', { method: 'POST' })
  notifications.value.forEach(n => { n.read_at = new Date().toISOString() })
  unreadCount.value = 0
}

fetchNotifications()

onMounted(() => {
  const { $echo } = useNuxtApp()
  if (!$echo || !user.value) return

  $echo.private(`App.Models.User.${user.value.id}`)
    .notification((n: Notification) => {
      if (!n.created_at) n.created_at = new Date().toISOString()
      if (!n.data && n.type) n.data = n as any
      notifications.value.unshift(n)
      unreadCount.value++
    })
})

onUnmounted(() => {
  const { $echo } = useNuxtApp()
  if ($echo && user.value) {
    $echo.leave(`App.Models.User.${user.value.id}`)
  }
})

// Inline icon components
const IconDashboard = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '1.5' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z' }),
])
const IconCharacters = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '1.5' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z' }),
])
const IconShop = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '1.5' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z' }),
])
const IconProfile = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '1.5' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z' }),
])
const IconTickets = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '1.5' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z' }),
])

const IconDonate = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '1.5' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z' }),
])

const navItems = [
  { label: 'Dashboard', to: '/dashboard', iconComponent: IconDashboard },
  { label: 'Characters', to: '/characters', iconComponent: IconCharacters },
  { label: 'Shop', to: '/shop', iconComponent: IconShop },
  { label: 'Donate', to: '/donate', iconComponent: IconDonate },
  { label: 'Tickets', to: '/tickets', iconComponent: IconTickets },
  { label: 'Profile', to: '/profile', iconComponent: IconProfile },
]

const IconAdminTickets = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '1.5' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z' }),
])
const IconAdminUsers = () => h('svg', { fill: 'none', viewBox: '0 0 24 24', stroke: 'currentColor', 'stroke-width': '1.5' }, [
  h('path', { 'stroke-linecap': 'round', 'stroke-linejoin': 'round', d: 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z' }),
])

const adminNavItems = [
  { label: 'Tickets', to: '/admin/tickets', iconComponent: IconAdminTickets },
  { label: 'Users', to: '/admin/users', iconComponent: IconAdminUsers },
]

function isActiveNav(to: string) {
  if (to === '/dashboard') return route.path === '/dashboard'
  return route.path.startsWith(to)
}

const recentNotifications = computed(() => notifications.value.slice(0, 3))

function nLink(n: Notification): string {
  const type = nType(n)
  if (type === 'ticket' && n.data?.ticket_id) return `/tickets?id=${n.data.ticket_id}`
  if (type === 'purchase') return '/shop'
  if (type === 'promo') return '/profile/history'
  return '/profile/history'
}

function nType(n: Notification): string {
  return n.data?.type || ''
}

function nText(n: Notification): string {
  if (!n.data) return ''
  return n.data.text || n.data.preview || n.data.subject || ''
}

async function confirmLogout() {
  showLogoutModal.value = false
  await logout()
}
watch(() => route.fullPath, () => { sidebarOpen.value = false; notifOpen.value = false })

onMounted(() => {
  document.addEventListener('click', (e) => {
    if (notifOpen.value && !(e.target as HTMLElement).closest('.relative')) {
      notifOpen.value = false
    }
  })
})
</script>

<style scoped>
.notif-badge { line-height: 1; }
.logout-confirm { background: var(--color-primary); color: white; }
.logout-confirm:hover { background: var(--color-primary-hover); }
.dropdown-enter-active, .dropdown-leave-active { transition: opacity 0.15s ease, transform 0.15s ease; }
.dropdown-enter-from, .dropdown-leave-to { opacity: 0; transform: translateY(-4px); }
</style>
