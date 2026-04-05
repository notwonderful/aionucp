<template>
  <div>
    <NuxtLink to="/admin/wiki" class="inline-flex items-center gap-2 text-[13px] font-medium text-white/25 transition-colors hover:text-white/50">
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
      {{ $t('admin.backToWiki') }}
    </NuxtLink>

    <div v-if="!entry" class="mt-8">
      <EmptyState :title="$t('admin.wikiNotFound')" />
    </div>

    <template v-else>
      <h1 class="mt-4 font-display text-2xl font-extrabold uppercase tracking-tight">{{ $t('admin.editWikiEntry') }}</h1>
      <WikiEntryForm class="mt-6" :entry="entry" @saved="handleSaved" />
    </template>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const route = useRoute()
const { $api } = useApi()

interface WikiItem {
  id: number
  category: string
  type: string
  content: Record<string, unknown>
  sort_order: number
  published: boolean
}

const entry = ref<WikiItem | null>(null)

async function fetchEntry() {
  try {
    const res = await $api<{ data: WikiItem }>(`/admin/wiki/${route.params.id}`)
    entry.value = res.data
  } catch { /* */ }
}

fetchEntry()

function handleSaved() {
  fetchEntry()
}
</script>
