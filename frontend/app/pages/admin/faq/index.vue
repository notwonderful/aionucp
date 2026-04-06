<template>
  <div>
    <PageHeader :title="$t('admin.manageFaq')" :subtitle="$t('admin.manageFaqDesc')">
      <template #actions>
        <NuxtLink to="/admin/faq/create"
          class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-[13px] font-semibold text-white transition-colors hover:bg-red-500">
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
          {{ $t('admin.createFaq') }}
        </NuxtLink>
      </template>
    </PageHeader>

    <SkeletonLoader v-if="status === 'pending'" height="h-20" />

    <template v-else>
      <DataTable :columns="columns" :has-rows="!!faqList.length" :empty-text="$t('admin.noFaqFound')">
        <NuxtLink v-for="item in faqList" :key="item.id" :to="`/admin/faq/${item.id}`"
          class="table-row border-b border-white/[0.04] last:border-0 transition-colors hover:bg-white/[0.015]">
          <td class="px-5 py-3.5">
            <StatusBadge :color="item.published ? 'emerald' : 'muted'" :label="item.published ? $t('admin.published') : $t('admin.draft')" />
          </td>
          <td class="px-5 py-3.5 text-[13px] font-semibold text-white/70">{{ item.question }}</td>
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

const columns = computed(() => [
  { key: 'status', label: t('admin.status') },
  { key: 'question', label: t('admin.question') },
  { key: 'sort_order', label: t('admin.sortOrder'), align: 'right' as const },
])

const { data: faqData, status } = useAsyncData(
  'admin-faq',
  () => $api<{ data: Array<{ id: number; question: string; answer: string; sort_order: number; published: boolean }> }>('/admin/faq'),
)

const faqList = computed(() => faqData.value?.data ?? [])
</script>
