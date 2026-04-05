<template>
  <div>
    <PageHeader :title="$t('admin.manageWiki')" :subtitle="$t('admin.manageWikiDesc')">
      <template #actions>
        <NuxtLink to="/admin/wiki/categories"
          class="inline-flex items-center gap-2 rounded-lg border border-white/[0.06] bg-white/[0.02] px-4 py-2 text-[13px] font-semibold text-white/40 transition-colors hover:bg-white/[0.04] hover:text-white/60">
          {{ $t('admin.wikiCategories') }}
        </NuxtLink>
        <NuxtLink to="/admin/wiki/create"
          class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-[13px] font-semibold text-white transition-colors hover:bg-red-500">
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
          {{ $t('admin.createWikiEntry') }}
        </NuxtLink>
      </template>
    </PageHeader>

    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center">
      <FilterTabs v-model="catFilter" :tabs="categoryFilters" />
      <div class="hidden h-5 w-px bg-white/[0.06] sm:block" />
      <FilterTabs v-model="typeFilter" :tabs="typeFilters" />
    </div>

    <div v-if="status === 'pending'" class="space-y-2">
      <div v-for="i in 5" :key="i" class="h-16 animate-pulse rounded-xl bg-white/[0.02]" />
    </div>

    <template v-else>
      <DataTable :columns="columns" :has-rows="!!entries.length" :empty-text="$t('admin.noWikiFound')">
        <NuxtLink v-for="item in entries" :key="item.id" :to="`/admin/wiki/${item.id}`"
          class="table-row border-b border-white/[0.04] last:border-0 transition-colors hover:bg-white/[0.015]">
          <td class="px-5 py-3.5">
            <span :class="['rounded px-1.5 py-0.5 text-[10px] font-medium uppercase tracking-wider',
              item.published ? 'bg-emerald-500/10 text-emerald-400' : 'bg-white/[0.04] text-white/25']">
              {{ item.published ? $t('admin.published') : $t('admin.draft') }}
            </span>
          </td>
          <td class="px-5 py-3.5">
            <span class="rounded bg-white/[0.04] px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest text-white/40">{{ item.category?.name ?? '' }}</span>
          </td>
          <td class="px-5 py-3.5">
            <span class="rounded bg-white/[0.04] px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest text-white/30">{{ item.type }}</span>
          </td>
          <td class="px-5 py-3.5 text-[13px] text-white/50 truncate max-w-[300px]">{{ entryLabel(item) }}</td>
          <td class="px-5 py-3.5 text-right text-[12px] tabular-nums text-white/20">{{ item.sort_order }}</td>
        </NuxtLink>
      </DataTable>
    </template>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const { t } = useI18n()
const { $api } = useApi()

interface WikiCat { id: number; name: string; slug: string }
const { data: catsData } = useAsyncData('wiki-categories-filter', () => $api<{ data: WikiCat[] }>('/admin/wiki-categories'))
const categoryFilters = computed(() => [
  { label: t('history.all'), value: '' },
  ...(catsData.value?.data ?? []).map(c => ({ label: c.name, value: String(c.id) })),
])

const typeFilters = computed(() => [
  { label: t('history.all'), value: '' },
  { label: 'Text', value: 'text' },
  { label: 'Table', value: 'table' },
  { label: 'Callout', value: 'callout' },
  { label: 'Spoiler', value: 'spoiler' },
])

const columns = computed(() => [
  { key: 'status', label: t('admin.status') },
  { key: 'category', label: t('admin.categoryLabel') },
  { key: 'type', label: t('admin.wikiType') },
  { key: 'preview', label: t('admin.preview') },
  { key: 'sort_order', label: t('admin.sortOrder'), align: 'right' as const },
])

const catFilter = ref('')
const typeFilter = ref('')

const queryParams = computed(() => {
  const params = new URLSearchParams()
  if (catFilter.value) params.set('filter[wiki_category_id]', catFilter.value)
  if (typeFilter.value) params.set('filter[type]', typeFilter.value)
  params.set('per_page', '50')
  return params.toString()
})

interface WikiItem {
  id: number
  category: string
  type: string
  content: Record<string, unknown>
  sort_order: number
  published: boolean
}

const { data, status } = useAsyncData(
  'admin-wiki',
  () => $api<{ data: WikiItem[] }>(`/admin/wiki?${queryParams.value}`),
  { watch: [queryParams] },
)

const entries = computed(() => data.value?.data ?? [])

function entryLabel(item: WikiItem): string {
  const c = item.content
  if (item.type === 'text') return String(c.body ?? '').slice(0, 80)
  if (item.type === 'table') return String(c.title ?? '')
  if (item.type === 'callout') return `[${c.callout_type}] ${String(c.body ?? '').slice(0, 60)}`
  if (item.type === 'spoiler') return String(c.title ?? '')
  return ''
}
</script>
