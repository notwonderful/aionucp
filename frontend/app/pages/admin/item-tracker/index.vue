<template>
  <div>
    <PageHeader :title="$t('admin.itemTracker')" :subtitle="$t('admin.itemTrackerDesc')">
      <template #actions>
        <button @click="showAddModal = true"
          class="inline-flex items-center gap-2 rounded-lg bg-red-600/15 px-4 py-2 text-[13px] font-semibold text-red-400 transition-colors hover:bg-red-600/25">
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
          {{ $t('admin.addItem') }}
        </button>
      </template>
    </PageHeader>

    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <FilterTabs v-model="activeTab" :tabs="tabs" />
      <SearchInput v-model="search" :placeholder="activeTab === 'items' ? $t('admin.owner') : $t('admin.itemUniqueId')" class="sm:w-64" />
    </div>

    <template v-if="activeTab === 'items'">
      <SkeletonLoader v-if="itemsStatus === 'pending'" />

      <template v-else>
        <DataTable :columns="itemColumns" :has-rows="!!items.length" :empty-text="$t('admin.noTrackedItems')">
          <tr v-for="item in items" :key="item.item_unique_id"
            class="border-b border-white/[0.04] last:border-0">
            <td class="px-5 py-3 text-[13px] tabular-nums font-medium text-white/70">{{ item.item_unique_id }}</td>
            <td class="px-5 py-3 text-[13px] tabular-nums text-white/50">{{ item.item_id }}</td>
            <td class="px-5 py-3 text-[13px] text-white/70">{{ item.last_owner_name }}</td>
            <td class="px-5 py-3 text-[13px] text-white/40">{{ item.last_owner_account }}</td>
            <td class="px-5 py-3 text-[13px] tabular-nums text-white/50">{{ item.item_count }}</td>
            <td class="px-5 py-3 text-[13px] tabular-nums text-white/50">+{{ item.enchant }}</td>
            <td class="px-5 py-3">
              <StatusBadge :color="item.is_deleted ? 'red' : 'emerald'" :label="item.is_deleted ? $t('admin.deleted') : $t('admin.active')" />
            </td>
            <td class="px-5 py-3 text-[12px] text-white/20">{{ formatDate(item.last_changed_at) }}</td>
            <td class="px-5 py-3 text-right">
              <button @click="confirmDelete(item)" class="text-white/15 transition-colors hover:text-red-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
              </button>
            </td>
          </tr>
        </DataTable>

        <PaginationButtons v-model="itemsPage" :last-page="itemsMeta.last_page" />
      </template>
    </template>

    <template v-if="activeTab === 'logs'">
      <SkeletonLoader v-if="logsStatus === 'pending'" />

      <template v-else>
        <DataTable :columns="logColumns" :has-rows="!!logs.length" :empty-text="$t('admin.noTransferLogs')">
          <tr v-for="log in logs" :key="log.id"
            class="border-b border-white/[0.04] last:border-0">
            <td class="px-5 py-3 text-[13px] tabular-nums font-medium text-white/70">{{ log.item_unique_id }}</td>
            <td class="px-5 py-3 text-[13px] tabular-nums text-white/50">{{ log.item_id }}</td>
            <td class="px-5 py-3">
              <div class="text-[13px] text-white/50">{{ log.old_owner_name || '—' }}</div>
              <div class="text-[11px] text-white/20">{{ log.old_owner_account || '' }}</div>
            </td>
            <td class="px-5 py-3">
              <div class="text-[13px] text-white/50">{{ log.new_owner_name || '—' }}</div>
              <div class="text-[11px] text-white/20">{{ log.new_owner_account || '' }}</div>
            </td>
            <td class="px-5 py-3">
              <StatusBadge
                :color="log.event_type === 'transfer' ? 'sky' : log.event_type === 'deleted' ? 'red' : 'amber'"
                :label="log.event_type === 'transfer' ? $t('admin.transfer') : log.event_type === 'deleted' ? $t('admin.deleted') : $t('admin.enchantChanged')" />
            </td>
            <td class="px-5 py-3 text-right text-[12px] text-white/20">{{ formatDate(log.logged_at) }}</td>
          </tr>
        </DataTable>

        <PaginationButtons v-model="logsPage" :last-page="logsMeta.last_page" />
      </template>
    </template>

    <AppModal :open="showAddModal" :title="$t('admin.addItem')" @close="showAddModal = false">
      <form class="space-y-4" @submit.prevent="handleAdd">
        <div>
          <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.itemUniqueId') }}</label>
          <input v-model.number="addForm.item_unique_id" type="number" min="1" required
            class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30 placeholder:text-white/15"
            placeholder="100000">
        </div>

        <AlertMessage :message="addSuccess" variant="success" />
        <AlertMessage :message="addError" variant="error" />

        <AppButton type="submit" :loading="adding" :loading-text="$t('common.loading')" block>
          {{ $t('admin.addItem') }}
        </AppButton>
      </form>
    </AppModal>

    <AppModal :open="!!deleteTarget" @close="deleteTarget = null">
      <div class="space-y-4">
        <h3 class="font-display text-lg font-bold uppercase tracking-wider">{{ $t('admin.removeItem') }}</h3>
        <p class="text-[13px] leading-relaxed text-white/40">{{ $t('admin.confirmRemoveItem') }}</p>
        <div class="flex justify-end gap-3">
          <button @click="deleteTarget = null"
            class="rounded-lg border border-white/[0.06] px-4 py-2 text-[13px] font-medium text-white/40 transition-colors hover:text-white/60">
            {{ $t('common.cancel') }}
          </button>
          <AppButton variant="danger" :loading="deleting" @click="handleDelete">
            {{ $t('admin.removeItem') }}
          </AppButton>
        </div>
      </div>
    </AppModal>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

interface TrackedItemData { item_unique_id: number; item_id: number; item_owner: number; item_count: number; enchant: number; item_creator: string | null; last_owner_name: string; last_owner_account: string; is_deleted: boolean; first_seen_at: string; last_changed_at: string }
interface LogData { id: number; item_unique_id: number; item_id: number; old_owner_id: number | null; old_owner_name: string | null; old_owner_account: string | null; new_owner_id: number | null; new_owner_name: string | null; new_owner_account: string | null; event_type: string; logged_at: string }

const { t } = useI18n()
const { $api, fetchCsrfCookie } = useApi()
const { datetime: formatDate } = useDate()
const { submit: addSubmit, loading: adding, successMsg: addSuccess, errorMsg: addError } = useFormSubmit()

const activeTab = ref('items')
const search = ref('')
const itemsPage = ref(1)
const logsPage = ref(1)

const tabs = computed(() => [
  { label: t('admin.trackedItems'), value: 'items' },
  { label: t('admin.transferLogs'), value: 'logs' },
])

const itemColumns = computed(() => [
  { key: 'uid', label: t('admin.itemUniqueId') },
  { key: 'item_id', label: t('admin.itemId') },
  { key: 'owner', label: t('admin.owner') },
  { key: 'account', label: t('admin.account') },
  { key: 'count', label: 'Count' },
  { key: 'enchant', label: 'Enchant' },
  { key: 'status', label: t('admin.status') },
  { key: 'changed', label: t('admin.lastChanged') },
  { key: 'actions', label: '' },
])

const logColumns = computed(() => [
  { key: 'uid', label: t('admin.itemUniqueId') },
  { key: 'item_id', label: t('admin.itemId') },
  { key: 'from', label: t('admin.fromOwner') },
  { key: 'to', label: t('admin.toOwner') },
  { key: 'event', label: t('admin.eventType') },
  { key: 'date', label: t('admin.date'), align: 'right' as const },
])

const itemsQuery = computed(() => {
  const params = new URLSearchParams()
  params.set('page', String(itemsPage.value))
  if (search.value && activeTab.value === 'items') params.set('filter[last_owner_name]', search.value)
  return params.toString()
})

const logsQuery = computed(() => {
  const params = new URLSearchParams()
  params.set('page', String(logsPage.value))
  if (search.value && activeTab.value === 'logs') {
    if (/^\d+$/.test(search.value)) {
      params.set('filter[item_unique_id]', search.value)
    } else {
      params.set('filter[new_owner_name]', search.value)
    }
  }
  return params.toString()
})

const { data: itemsData, status: itemsStatus, refresh: refreshItems } = useAsyncData(
  'admin-tracked-items',
  () => $api<{ data: TrackedItemData[]; meta: any }>(`/admin/item-tracker?${itemsQuery.value}`),
  { watch: [itemsQuery] },
)

const { data: logsData, status: logsStatus, refresh: refreshLogs } = useAsyncData(
  'admin-tracker-logs',
  () => $api<{ data: LogData[]; meta: any }>(`/admin/item-tracker/logs?${logsQuery.value}`),
  { watch: [logsQuery] },
)

const items = computed(() => itemsData.value?.data ?? [])
const itemsMeta = computed(() => itemsData.value?.meta ?? { last_page: 1 })
const logs = computed(() => logsData.value?.data ?? [])
const logsMeta = computed(() => logsData.value?.meta ?? { last_page: 1 })

const showAddModal = ref(false)
const addForm = reactive({ item_unique_id: 0 })

async function handleAdd() {
  await addSubmit(async (api) => {
    const res = await api<{ message: string }>('/admin/item-tracker', { method: 'POST', body: addForm })
    addForm.item_unique_id = 0
    await refreshItems()
    setTimeout(() => { showAddModal.value = false; addSuccess.value = '' }, 1500)
    return res.message || t('admin.itemTracked')
  }, t('admin.itemTrackFailed'))
}

const deleteTarget = ref<TrackedItemData | null>(null)
const deleting = ref(false)

function confirmDelete(item: TrackedItemData) {
  deleteTarget.value = item
}

async function handleDelete() {
  if (!deleteTarget.value) return
  deleting.value = true

  try {
    await fetchCsrfCookie()
    await $api(`/admin/item-tracker/${deleteTarget.value.item_unique_id}`, { method: 'DELETE' })
    deleteTarget.value = null
    await refreshItems()
    await refreshLogs()
  } catch {
  } finally {
    deleting.value = false
  }
}

watch(activeTab, () => {
  search.value = ''
  itemsPage.value = 1
  logsPage.value = 1
})
</script>
