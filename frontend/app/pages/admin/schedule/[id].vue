<template>
  <div>
    <NuxtLink to="/admin/schedule" class="inline-flex items-center gap-2 text-[13px] font-medium text-white/25 transition-colors hover:text-white/50">
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
      {{ $t('admin.backToSchedule') }}
    </NuxtLink>

    <div v-if="!entry" class="mt-8">
      <EmptyState :title="$t('admin.scheduleNotFound')" />
    </div>

    <template v-else>
      <h1 class="mt-4 font-display text-2xl font-extrabold uppercase tracking-tight">{{ $t('admin.editEntry') }}</h1>
      <ScheduleForm class="mt-6" :entry="entry" @saved="handleSaved" />
    </template>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const route = useRoute()
const { $api } = useApi()

interface ScheduleItem {
  id: number
  category: string
  name: string
  metadata: Record<string, unknown>
  sort_order: number
  published: boolean
}

const entry = ref<ScheduleItem | null>(null)

async function fetchEntry() {
  try {
    const res = await $api<{ data: ScheduleItem }>(`/admin/schedule/${route.params.id}`)
    entry.value = res.data
  } catch { /* */ }
}

fetchEntry()

function handleSaved() {
  fetchEntry()
}
</script>
