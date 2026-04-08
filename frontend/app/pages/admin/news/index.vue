<template>
  <div>
    <PageHeader :title="$t('admin.manageNews')" :subtitle="$t('admin.manageNewsDesc')">
      <template #actions>
        <NuxtLink to="/admin/news/create"
          class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-[13px] font-semibold text-white transition-colors hover:bg-red-500">
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
          {{ $t('admin.createArticle') }}
        </NuxtLink>
      </template>
    </PageHeader>

    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <FilterTabs v-model="activeFilter" :tabs="tagFilters" />
      <SearchInput v-model="search" :placeholder="$t('admin.searchNews')" class="sm:w-64" />
    </div>

    <SkeletonLoader v-if="status === 'pending'" height="h-20" />

    <template v-else>
      <DataTable :columns="columns" :has-rows="!!items.length" :empty-text="$t('admin.noNewsFound')">
        <NuxtLink v-for="item in items" :key="item.id" :to="`/admin/news/${item.id}`"
          class="table-row border-b border-white/[0.04] last:border-0 transition-colors hover:bg-white/[0.015]">
          <td class="px-5 py-3.5">
            <StatusBadge :color="item.published ? 'emerald' : 'muted'" :label="item.published ? $t('admin.published') : $t('admin.draft')" />
          </td>
          <td class="px-5 py-3.5 text-[13px] font-semibold text-white/70">{{ item.title }}</td>
          <td class="px-5 py-3.5">
            <span class="rounded bg-red-600/10 px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest text-red-400/70">{{ item.tag }}</span>
          </td>
          <td class="px-5 py-3.5 text-right text-[12px] text-white/20">{{ item.published_at ? formatDate(item.published_at) : '—' }}</td>
        </NuxtLink>
      </DataTable>
    </template>
  </div>
</template>

<script setup lang="ts">
import type { NewsArticle } from '~/composables/useNews'

definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const { t } = useI18n()
const { relative: formatDate } = useDate()

const activeFilter = ref('')
const search = ref('')

const tagFilters = computed(() => [
  { label: t('history.all'), value: '' },
  { label: 'Update', value: 'Update' },
  { label: 'Event', value: 'Event' },
  { label: 'Patch', value: 'Patch' },
  { label: 'Guide', value: 'Guide' },
  { label: 'News', value: 'News' },
])

const columns = computed(() => [
  { key: 'status', label: t('admin.status') },
  { key: 'title', label: t('admin.newsTitle') },
  { key: 'tag', label: t('admin.tag') },
  { key: 'published_at', label: t('admin.publishedAt'), align: 'right' as const, sortable: true },
])

const { items, status } = useListData<NewsArticle>({
  cacheKey: 'admin-news',
  endpoint: '/admin/news',
  filters: [
    { key: 'tag', value: activeFilter },
    { key: 'search', value: search },
  ],
})
</script>
