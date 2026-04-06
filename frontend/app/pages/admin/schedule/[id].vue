<template>
  <div>
    <BackLink to="/admin/schedule" :label="$t('admin.backToSchedule')" />

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
