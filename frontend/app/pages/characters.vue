<template>
  <div>
    <div class="mb-8">
      <h1 class="font-display text-2xl font-extrabold uppercase tracking-tight lg:text-3xl">Characters</h1>
      <p class="mt-1 text-[13px] text-white/25">Manage your in-game characters</p>
    </div>

    <div v-if="status === 'pending'" class="space-y-3">
      <div v-for="i in 3" :key="i" class="h-24 animate-pulse rounded-xl bg-white/[0.02]" />
    </div>

    <EmptyState v-else-if="allPlayers.length === 0" title="No characters yet" subtitle="Log into the game to create your first character">
      <template #icon>
        <svg class="h-6 w-6 text-white/15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
      </template>
    </EmptyState>

    <div v-else class="space-y-3">
      <div
        v-for="player in allPlayers" :key="player.id"
        class="overflow-hidden rounded-xl border border-white/[0.04] bg-white/[0.02] transition-colors duration-200 hover:bg-white/[0.03]"
      >
        <div class="flex items-center justify-between px-6 py-5">
          <div class="flex items-center gap-5">
            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/[0.03]">
              <img v-if="classIconMap[player.player_class]" :src="`/img/class/${classIconMap[player.player_class]}.png`"
                :alt="player.player_class" class="h-9 w-9 object-contain opacity-60" />
              <span v-else class="font-display text-xl font-extrabold text-white/15">{{ player.player_class?.charAt(0) }}</span>
            </div>
            <div>
              <div class="flex items-center gap-3">
                <span class="text-[16px] font-bold">{{ player.name }}</span>
                <span v-if="player.online" class="flex items-center gap-1.5 text-[11px] font-medium text-emerald-400">
                  <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75" />
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-400" />
                  </span>
                  Online
                </span>
                <span v-else class="text-[11px] text-white/15">Offline</span>
              </div>
              <div class="mt-1 flex items-center gap-3 text-[12px] text-white/25">
                <span :class="player.race === 'ELYOS' ? 'text-sky-400/60' : 'text-red-400/60'">{{ player.race }}</span>
                <span class="text-white/10">&middot;</span>
                <span>{{ player.player_class }}</span>
              </div>
            </div>
          </div>

          <div class="flex items-center gap-2">
            <button
              @click="handleTeleport(player)"
              :disabled="player.online || teleportingId === player.id"
              class="flex items-center gap-2 rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2 text-[12px] font-medium text-white/40 transition-all duration-300 hover:border-red-500/20 hover:bg-red-600/10 hover:text-red-400 disabled:opacity-30 disabled:pointer-events-none"
            >
              <svg v-if="teleportingId !== player.id" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
              <svg v-else class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" /></svg>
              Teleport
            </button>
          </div>
        </div>

        <Transition name="fade">
          <div v-if="teleportResult[player.id]"
            :class="['px-6 py-3 text-[12px] border-t border-white/[0.04]',
              teleportResult[player.id]?.success ? 'bg-emerald-500/5 text-emerald-400' : 'bg-red-500/5 text-red-400']">
            {{ teleportResult[player.id]?.message }}
          </div>
        </Transition>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'auth' })

interface Player { id: number; name: string; race: string; player_class: string; online: boolean }
interface AccountData { id: number; name: string; toll: number; membership: number; membership_expire: string | null; players: Player[] }

const { $api, fetchCsrfCookie } = useApi()

const { data: dashboardData, status } = useAsyncData('dashboard', () =>
  $api<{ data: AccountData[] }>('/dashboard'),
)

const allPlayers = computed(() =>
  dashboardData.value?.data?.flatMap(acc => acc.players) ?? [],
)

const teleportingId = ref<number | null>(null)
const teleportResult = reactive<Record<number, { success: boolean; message: string } | null>>({})

async function handleTeleport(player: Player) {
  teleportingId.value = player.id
  teleportResult[player.id] = null

  try {
    await fetchCsrfCookie()
    const res = await $api<{ message: string }>(`/players/${player.id}/teleport`, { method: 'POST' })
    teleportResult[player.id] = { success: true, message: res.message || 'Teleported successfully!' }
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    teleportResult[player.id] = { success: false, message: err.data?.message || 'Teleport failed.' }
  } finally {
    teleportingId.value = null
    setTimeout(() => { teleportResult[player.id] = null }, 5000)
  }
}

const classIconMap: Record<string, number> = {
  GLADIATOR: 1,
  RANGER: 4,
  SORCERER: 5,
  CLERIC: 7,
  CHANTER: 8,
  AETHERTECH: 10,
  SONGWEAVER: 11,
}
</script>

