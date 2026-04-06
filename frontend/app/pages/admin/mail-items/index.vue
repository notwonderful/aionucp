<template>
  <div>
    <PageHeader :title="$t('admin.sendItem')" :subtitle="$t('admin.sendItemDesc')" />

    <div class="grid gap-8 lg:grid-cols-3">
      <section class="lg:col-span-1 card-panel p-6">
        <h3 class="mb-5 text-[13px] font-bold uppercase tracking-widest text-white/30">{{ $t('admin.sendNewItem') }}</h3>
        <form class="space-y-4" @submit.prevent="handleSend">
          <div>
            <label class="form-label">{{ $t('admin.playerName') }}</label>
            <input v-model="form.player_name" type="text" required
              class="form-input"
              placeholder="CharacterName">
          </div>
          <div>
            <label class="form-label">Item ID</label>
            <input v-model.number="form.item_id" type="number" min="1" required
              class="form-input"
              placeholder="100000">
          </div>
          <div>
            <label class="form-label">{{ $t('admin.itemQty') }}</label>
            <input v-model.number="form.item_qty" type="number" min="1" max="1000" required
              class="form-input"
              placeholder="1">
          </div>

          <AlertMessage :message="successMsg" variant="success" />
          <AlertMessage :message="errorMsg" variant="error" />

          <AppButton type="submit" :loading="sending" :loading-text="$t('common.loading')" block>
            {{ $t('admin.sendItem') }}
          </AppButton>
        </form>
      </section>

      <section class="lg:col-span-2">
        <h3 class="mb-4 text-[13px] font-bold uppercase tracking-widest text-white/30">{{ $t('admin.sendHistory') }}</h3>

        <SkeletonLoader v-if="logsStatus === 'pending'" />

        <DataTable v-else :columns="columns" :has-rows="!!logs.length" :empty-text="$t('admin.noMailLogs')">
          <tr v-for="log in logs" :key="log.id"
            class="border-b border-white/[0.04] last:border-0">
            <td class="px-5 py-3 text-[13px] text-white/50">{{ log.admin_name }}</td>
            <td class="px-5 py-3 text-[13px] font-medium text-white/70">{{ log.player_name }}</td>
            <td class="px-5 py-3 text-[13px] tabular-nums text-white/50">{{ log.item_id }}</td>
            <td class="px-5 py-3 text-[13px] tabular-nums text-white/50">{{ log.item_qty }}</td>
            <td class="px-5 py-3 text-right text-[12px] text-white/20">{{ formatDate(log.created_at) }}</td>
          </tr>
        </DataTable>

        <NuxtLink v-if="logs.length >= 5" to="/admin/mail-items/history"
          class="mt-4 inline-flex items-center gap-1.5 text-[12px] font-bold uppercase tracking-widest text-red-500/60 transition-colors hover:text-red-400">
          {{ $t('admin.viewAll') }} &rarr;
        </NuxtLink>
      </section>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const { t } = useI18n()
const { $api } = useApi()
const { datetime: formatDate } = useDate()
const { submit, loading: sending, successMsg, errorMsg } = useFormSubmit()

const form = reactive({ player_name: '', item_id: 0, item_qty: 1 })

const columns = [
  { key: 'admin', label: t('admin.admin') },
  { key: 'player', label: t('admin.playerName') },
  { key: 'item_id', label: 'Item ID' },
  { key: 'qty', label: t('admin.itemQty') },
  { key: 'date', label: t('admin.date'), align: 'right' as const },
]

const { data: logsData, status: logsStatus, refresh: refreshLogs } = useAsyncData(
  'mail-item-logs',
  () => $api<{ data: any[] }>('/admin/mail-items?per_page=5'),
)

const logs = computed(() => logsData.value?.data ?? [])

async function handleSend() {
  await submit(async (api) => {
    const res = await api<{ message: string }>('/admin/mail-items', { method: 'POST', body: form })
    form.player_name = ''
    form.item_id = 0
    form.item_qty = 1
    await refreshLogs()
    return res.message || t('admin.itemSent')
  }, t('admin.itemSendFailed'))
}
</script>
