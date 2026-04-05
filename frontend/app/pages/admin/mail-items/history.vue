<template>
  <div>
    <PageHeader :title="$t('admin.sendHistory')" :subtitle="$t('admin.sendHistoryDesc')">
      <template #actions>
        <NuxtLink to="/admin/mail-items"
          class="inline-flex items-center gap-2 rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2 text-[13px] font-semibold text-white/50 transition-colors hover:text-white/80">
          &larr; {{ $t('admin.backToSendItem') }}
        </NuxtLink>
      </template>
    </PageHeader>

    <div v-if="status === 'pending'" class="space-y-2">
      <div v-for="i in 10" :key="i" class="h-14 animate-pulse rounded-xl bg-white/[0.02]" />
    </div>

    <template v-else>
      <DataTable :columns="columns" :has-rows="!!logs.length" :empty-text="$t('admin.noMailLogs')">
        <tr v-for="log in logs" :key="log.id"
          class="border-b border-white/[0.04] last:border-0">
          <td class="px-5 py-3 text-[13px] text-white/50">{{ log.admin_name }}</td>
          <td class="px-5 py-3 text-[13px] font-medium text-white/70">{{ log.player_name }}</td>
          <td class="px-5 py-3 text-[13px] tabular-nums text-white/50">{{ log.item_id }}</td>
          <td class="px-5 py-3 text-[13px] tabular-nums text-white/50">{{ log.item_qty }}</td>
          <td class="px-5 py-3 text-right text-[12px] text-white/20">{{ formatDate(log.created_at) }}</td>
        </tr>
      </DataTable>

      <div v-if="meta.last_page > 1" class="mt-6 flex items-center justify-center gap-2">
        <button v-for="p in meta.last_page" :key="p" @click="page = p"
          :class="['rounded-lg px-3 py-1.5 text-[12px] font-bold transition-colors',
            page === p ? 'bg-red-600/15 text-red-400' : 'text-white/25 hover:text-white/50']">
          {{ p }}
        </button>
      </div>
    </template>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const { t } = useI18n()
const { $api } = useApi()
const { datetime: formatDate } = useDate()

const page = ref(1)

const columns = [
  { key: 'admin', label: t('admin.admin') },
  { key: 'player', label: t('admin.playerName') },
  { key: 'item_id', label: 'Item ID' },
  { key: 'qty', label: t('admin.itemQty') },
  { key: 'date', label: t('admin.date'), align: 'right' as const },
]

const { data: logsData, status } = useAsyncData(
  'mail-item-history',
  () => $api<{ data: any[]; meta: any }>(`/admin/mail-items?page=${page.value}`),
  { watch: [page] },
)

const logs = computed(() => logsData.value?.data ?? [])
const meta = computed(() => logsData.value?.meta ?? { last_page: 1 })
</script>
