<template>
  <div>
    <BackLink to="/admin/tickets" :label="$t('admin.backToTickets')" />

    <div v-if="!ticket" class="mt-8">
      <EmptyState :title="$t('admin.ticketNotFound')" />
    </div>

    <template v-else>
      <div class="mt-6 flex items-start justify-between gap-4">
        <div>
          <h1 class="font-display text-xl font-extrabold uppercase tracking-tight lg:text-2xl">{{ ticket.subject }}</h1>
          <div class="mt-2 flex items-center gap-3 text-[12px] text-white/25">
            <span>{{ ticket.user?.name }} ({{ ticket.user?.email }})</span>
            <span class="text-white/10">&middot;</span>
            <span>{{ ticket.category?.name }}</span>
            <span class="text-white/10">&middot;</span>
            <span :class="['rounded px-1.5 py-0.5 text-[10px] font-medium uppercase tracking-wider',
              ticket.status === 'open' ? 'bg-emerald-500/10 text-emerald-400'
                : ticket.status === 'waiting' ? 'bg-amber-500/10 text-amber-400'
                : 'bg-white/[0.04] text-white/25']">
              {{ ticket.status }}
            </span>
          </div>
        </div>
        <div class="flex gap-2">
          <AppButton v-if="ticket.status !== 'closed'" variant="secondary" @click="handleClose">{{ $t('admin.closeTicket') }}</AppButton>
          <AppButton v-else variant="secondary" @click="handleOpen">{{ $t('admin.reopen') }}</AppButton>
        </div>
      </div>

      <div class="mt-6 space-y-4">
        <div v-for="msg in chatMessages" :key="msg.id"
          :class="['flex', msg.user.is_admin ? 'justify-end' : 'justify-start']">
          <div :class="['max-w-[70%] rounded-2xl px-4 py-2.5',
            msg.user.is_admin
              ? 'rounded-br-md bg-red-600/20 text-white/80'
              : 'rounded-bl-md bg-white/[0.05] text-white/60']">
            <div class="mb-1 text-[11px] font-medium" :class="msg.user.is_admin ? 'text-red-400/60' : 'text-white/25'">{{ msg.user.name }}</div>
            <div class="prose-chat text-[13px] leading-relaxed" v-html="msg.body" />
            <div :class="['mt-1 text-[10px]', msg.user.is_admin ? 'text-right text-white/20' : 'text-white/15']">{{ formatTime(msg.created_at) }}</div>
          </div>
        </div>
      </div>

      <div v-if="ticket.status !== 'closed'" class="mt-6">
        <label class="mb-1.5 block text-[12px] font-medium text-white/40">{{ $t('admin.replyAsAdmin') }}</label>
        <LazyRichEditor v-model="replyBody" :placeholder="$t('admin.replyPlaceholder')" />
        <div class="mt-3">
          <AppButton :loading="sending" :loading-text="$t('admin.sending')" :disabled="!replyBody || replyBody === '<p></p>'" @click="handleReply">{{ $t('admin.sendReply') }}</AppButton>
        </div>
        <AlertMessage :message="error" variant="error" />
      </div>
    </template>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

interface TicketUser { id: number; name: string; email?: string; is_admin: boolean }
interface TicketMsg { id: number; user: TicketUser; body: string; created_at: string }
interface TicketDetail { id: string; subject: string; status: string; user: { id: number; name: string; email: string } | null; category: { id: number; name: string } | null; messages_count: number }

const { t } = useI18n()
const route = useRoute()
const { $api, fetchCsrfCookie } = useApi()
const { datetime: formatTime } = useDate()

const ticket = ref<TicketDetail | null>(null)
const messages = ref<TicketMsg[]>([])
const replyBody = ref('')
const sending = ref(false)
const error = ref('')

const chatMessages = computed(() => [...messages.value].reverse())

async function fetchTicket() {
  try {
    const res = await $api<{ data: TicketDetail; messages: TicketMsg[] }>(`/admin/tickets/${route.params.id}`)
    ticket.value = res.data
    messages.value = res.messages
  } catch { /* */ }
}

fetchTicket()

async function handleReply() {
  if (!replyBody.value || replyBody.value === '<p></p>') return
  sending.value = true
  error.value = ''
  try {
    await fetchCsrfCookie()
    const res = await $api<{ data: TicketMsg }>(`/admin/tickets/${route.params.id}/reply`, {
      method: 'POST',
      body: { body: replyBody.value },
    })
    messages.value.unshift(res.data)
    replyBody.value = ''
    if (ticket.value) ticket.value.status = 'open'
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    error.value = err.data?.message || t('admin.replyFailed')
  } finally {
    sending.value = false
  }
}

async function handleClose() {
  await fetchCsrfCookie()
  await $api(`/admin/tickets/${route.params.id}/close`, { method: 'POST' })
  if (ticket.value) ticket.value.status = 'closed'
}

async function handleOpen() {
  await fetchCsrfCookie()
  await $api(`/admin/tickets/${route.params.id}/open`, { method: 'POST' })
  if (ticket.value) ticket.value.status = 'open'
}
</script>

<style scoped>
:deep(.prose-chat p) { margin: 0.15rem 0; }
:deep(.prose-chat strong) { font-weight: 600; }
:deep(.prose-chat ul) { list-style: disc; padding-left: 1.25rem; }
:deep(.prose-chat ol) { list-style: decimal; padding-left: 1.25rem; }
:deep(.prose-chat a) { color: rgb(239 68 68); text-decoration: underline; }
:deep(.prose-chat code) { background: rgba(255 255 255 / 0.08); border-radius: 0.25rem; padding: 0.1rem 0.3rem; font-size: 0.85em; }
:deep(.prose-chat blockquote) { border-left: 2px solid rgba(255 255 255 / 0.1); padding-left: 0.75rem; opacity: 0.7; }
</style>
