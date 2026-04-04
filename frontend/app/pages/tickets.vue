<template>
  <div class="-m-6 lg:-m-8">
    <div class="flex" style="height: calc(100dvh - 57px)">

      <div
        :class="['ticket-list flex shrink-0 flex-col border-r border-white/[0.04]',
          activeTicketId && 'ticket-list--collapsed']"
      >
        <div class="flex items-center justify-between border-b border-white/[0.04] px-5 py-4">
          <h1 class="font-display text-[15px] font-bold uppercase tracking-wider">Tickets</h1>
          <button @click="openCreateModal" class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-600/15 text-red-400 transition-colors hover:bg-red-600/25">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
          </button>
        </div>

        <div class="flex-1 overflow-y-auto">
          <button
            v-for="ticket in tickets" :key="ticket.id"
            @click="selectTicket(ticket.id)"
            :class="['flex w-full gap-3 border-b border-white/[0.04] px-5 py-4 text-left transition-colors',
              activeTicketId === ticket.id ? 'bg-white/[0.04]' : 'hover:bg-white/[0.02]']"
          >
            <div :class="['mt-1.5 h-2 w-2 shrink-0 rounded-full',
              ticket.status === 'open' ? 'bg-emerald-400' : ticket.status === 'waiting' ? 'bg-amber-400' : 'bg-white/15']" />
            <div class="min-w-0 flex-1">
              <div class="flex items-center justify-between gap-2">
                <span class="truncate text-[13px] font-semibold">{{ ticket.subject }}</span>
                <span class="shrink-0 text-[11px] text-white/20">{{ formatDate(ticket.updated_at) }}</span>
              </div>
              <p v-if="ticket.last_message" class="mt-1 truncate text-[12px] text-white/25">{{ stripHtml(ticket.last_message.body) }}</p>
              <div class="mt-1.5">
                <span :class="['rounded px-1.5 py-0.5 text-[10px] font-medium uppercase tracking-wider',
                  ticket.status === 'open' ? 'bg-emerald-500/10 text-emerald-400'
                    : ticket.status === 'waiting' ? 'bg-amber-500/10 text-amber-400'
                    : 'bg-white/[0.04] text-white/25']">
                  {{ ticket.status }}
                </span>
              </div>
            </div>
          </button>

          <div v-if="ticketsStatus !== 'pending' && !tickets.length" class="flex flex-col items-center justify-center py-20 text-center">
            <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-white/[0.03]">
              <svg class="h-5 w-5 text-white/15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" /></svg>
            </div>
            <p class="text-[13px] text-white/25">No tickets yet</p>
          </div>
        </div>
      </div>

      <div :class="['flex flex-1 flex-col', !activeTicketId && 'ticket-chat--empty']">

        <div v-if="!activeTicketId" class="flex flex-1 flex-col items-center justify-center px-6 text-center">
          <div class="mb-5 flex h-20 w-20 items-center justify-center rounded-2xl border border-white/[0.04] bg-white/[0.02]">
            <svg class="h-9 w-9 text-white/10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" /></svg>
          </div>
          <p class="font-display text-[16px] font-bold uppercase tracking-wider text-white/25">Need help?</p>
          <p class="mt-2 max-w-xs text-[13px] leading-relaxed text-white/15">Create a support ticket and our team will get back to you as soon as possible.</p>
          <AppButton class="mt-6" @click="openCreateModal">Create a ticket</AppButton>
        </div>

        <template v-else>
          <div class="flex items-center gap-3 border-b border-white/[0.04] px-5 py-3.5">
            <button @click="activeTicketId = null" class="flex h-8 w-8 items-center justify-center rounded-lg text-white/20 transition-colors hover:bg-white/[0.04] hover:text-white/40 lg:hidden">
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
            </button>
            <div class="min-w-0 flex-1">
              <div class="truncate text-[14px] font-semibold">{{ activeDetail?.subject }}</div>
              <div class="mt-0.5 flex items-center gap-2">
                <span :class="['h-1.5 w-1.5 rounded-full',
                  activeDetail?.status === 'open' ? 'bg-emerald-400' : activeDetail?.status === 'waiting' ? 'bg-amber-400' : 'bg-white/15']" />
                <span class="text-[11px] capitalize text-white/25">{{ activeDetail?.status }}</span>
              </div>
            </div>
          </div>

          <div v-if="detailStatus === 'pending'" class="flex flex-1 items-center justify-center">
            <svg class="h-6 w-6 animate-spin text-white/20" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" /></svg>
          </div>

          <template v-else>
            <div ref="messagesContainer" class="flex-1 overflow-y-auto px-5 py-4" @scroll="onMessagesScroll">
              <div class="mx-auto max-w-2xl space-y-4">
                <div v-if="loadingMore" class="flex justify-center py-2">
                  <svg class="h-5 w-5 animate-spin text-white/20" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" /></svg>
                </div>
                <div v-for="msg in messages" :key="msg.id"
                  :class="['flex', msg.user.is_admin ? 'justify-start' : 'justify-end']">
                  <div :class="['max-w-[80%] rounded-2xl px-4 py-2.5',
                    msg.user.is_admin
                      ? 'rounded-bl-md bg-white/[0.05] text-white/60'
                      : 'rounded-br-md bg-red-600/20 text-white/80']">
                    <div v-if="msg.user.is_admin" class="mb-1 text-[11px] font-medium text-red-400/60">{{ msg.user.name }}</div>
                    <div class="prose-chat text-[13px] leading-relaxed" v-html="msg.body" />
                    <div :class="['mt-1 text-[10px]', msg.user.is_admin ? 'text-white/15' : 'text-right text-white/20']">{{ formatTime(msg.created_at) }}</div>
                  </div>
                </div>
              </div>
            </div>

            <div v-if="activeDetail?.status !== 'closed'" class="border-t border-white/[0.04] px-5 py-4">
              <div class="flex gap-3">
                <div class="flex-1">
                  <LazyRichEditor v-model="messageText" placeholder="Type a message..." :toolbar="true" />
                </div>
                <button type="button" @click="sendMessage" :disabled="!messageText || messageText === '<p></p>' || sending"
                  class="send-btn flex shrink-0 items-start justify-center rounded-lg bg-red-600 text-white transition-all duration-300 hover:bg-red-500 active:scale-95 disabled:opacity-30 disabled:pointer-events-none" style="padding-top: 13px">
                  <svg v-if="!sending" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>
                  <svg v-else class="h-5 w-5 animate-spin" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" /></svg>
                </button>
              </div>
            </div>
            <div v-else class="border-t border-white/[0.04] px-5 py-4 text-center text-[12px] text-white/20">
              This ticket is closed
            </div>
          </template>
        </template>
      </div>
    </div>

    <AppModal :open="showCreateModal" title="New Ticket" size="lg" @close="showCreateModal = false">
      <template #icon>
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-600/10">
          <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
        </div>
      </template>

      <form @submit.prevent="handleCreateTicket" class="space-y-4">
        <FormInput v-model="newTicket.subject" label="Subject" required placeholder="Brief description of your issue" />

        <div>
          <label class="mb-1.5 block text-[12px] font-medium text-white/40">Category</label>
          <select
            v-model="newTicket.category_id"
            class="w-full appearance-none rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-3 text-[14px] text-white outline-none transition-all duration-300 focus:border-red-500/30 focus:bg-white/[0.05] focus:ring-1 focus:ring-red-500/20"
          >
            <option v-for="cat in categories" :key="cat.id" :value="cat.id" class="bg-surface-overlay">{{ cat.name }}</option>
          </select>
        </div>

        <div>
          <label class="mb-1.5 block text-[12px] font-medium text-white/40">Message</label>
          <LazyRichEditor v-model="newTicket.body" placeholder="Describe your issue in detail..." />
        </div>

        <AlertMessage :message="createError" variant="error" />

        <div class="flex gap-3 pt-1">
          <AppButton variant="secondary" @click="showCreateModal = false">Cancel</AppButton>
          <AppButton type="submit" :loading="creating" loading-text="Creating..." :disabled="!newTicket.subject.trim() || !newTicket.body || newTicket.body === '<p></p>'">Submit</AppButton>
        </div>
      </form>
    </AppModal>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'auth' })

interface TicketUser { id: number; name: string; is_admin: boolean }
interface TicketMsg { id: number; user: TicketUser; body: string; created_at: string }
interface TicketLastMsg { id: number; body: string; user: TicketUser; created_at: string }
interface TicketItem { id: string; subject: string; status: string; priority: string; category: { id: number; name: string } | null; last_message: TicketLastMsg | null; updated_at: string; created_at: string }
interface Category { id: number; name: string; slug: string }

const { $api, fetchCsrfCookie } = useApi()

const { data: ticketsData, status: ticketsStatus, refresh: refreshTickets } = useAsyncData('tickets', () =>
  $api<{ data: TicketItem[] }>('/tickets'),
)

const { data: categoriesData } = useAsyncData('ticket-categories', () =>
  $api<{ data: Category[] }>('/tickets/categories'),
)

const tickets = computed(() => ticketsData.value?.data ?? [])
const categories = computed(() => categoriesData.value?.data ?? [])

const route = useRoute()
const router = useRouter()

const activeTicketId = ref<string | null>((route.query.id as string) || null)
const messagesContainer = ref<HTMLElement | null>(null)
const messageText = ref('')
const sending = ref(false)
const showCreateModal = ref(false)
const creating = ref(false)
const createError = ref('')
const newTicket = reactive({ subject: '', category_id: 0, body: '' })

const activeDetail = ref<TicketItem | null>(null)
const messages = ref<TicketMsg[]>([])
const detailStatus = ref<'idle' | 'pending' | 'success'>('idle')
const nextCursor = ref<string | null>(null)
const loadingMore = ref(false)

watch(activeTicketId, async (id) => {
  if (!id) {
    activeDetail.value = null
    messages.value = []
    detailStatus.value = 'idle'
    nextCursor.value = null
    router.replace({ query: {} })
    return
  }
  router.replace({ query: { id } })
  await fetchDetail(id)
})

interface TicketShowResponse {
  data: TicketItem
  messages: TicketMsg[]
  pagination: { next_cursor: string | null; has_more: boolean }
}

async function fetchDetail(id: string) {
  detailStatus.value = 'pending'
  try {
    const res = await $api<TicketShowResponse>(`/tickets/${id}`)
    activeDetail.value = res.data
    messages.value = [...res.messages].reverse()
    nextCursor.value = res.pagination.next_cursor
    detailStatus.value = 'success'
    scrollToBottom()
  } catch {
    activeDetail.value = null
    messages.value = []
    detailStatus.value = 'idle'
  }
}

async function loadOlderMessages() {
  if (!activeTicketId.value || !nextCursor.value || loadingMore.value) return
  loadingMore.value = true
  try {
    const container = messagesContainer.value
    const prevHeight = container?.scrollHeight ?? 0

    const res = await $api<TicketShowResponse>(`/tickets/${activeTicketId.value}?cursor=${nextCursor.value}`)
    messages.value = [...[...res.messages].reverse(), ...messages.value]
    nextCursor.value = res.pagination.next_cursor

    nextTick(() => {
      if (container) container.scrollTop = container.scrollHeight - prevHeight
    })
  } catch { /* ignore */ } finally {
    loadingMore.value = false
  }
}

function onMessagesScroll(e: Event) {
  const el = e.target as HTMLElement
  if (el.scrollTop < 100 && nextCursor.value) loadOlderMessages()
}

if (activeTicketId.value) {
  fetchDetail(activeTicketId.value)
}

const { $echo } = useNuxtApp()
let echoChannel: ReturnType<typeof $echo.private> | null = null

watch(activeTicketId, (id, oldId) => {
  if (oldId && echoChannel) {
    $echo?.leave(`tickets.${oldId}`)
    echoChannel = null
  }
  if (id && $echo) {
    echoChannel = $echo.private(`tickets.${id}`)
      .listen('.message.sent', (e: { message: TicketMsg }) => {
        const exists = messages.value.some(m => m.id === e.message.id)
        if (!exists) {
          messages.value.push(e.message)
          scrollToBottom()
        }
        refreshTickets()
      })
      .listen('.status.changed', (e: { status: string }) => {
        if (activeDetail.value) activeDetail.value.status = e.status
        refreshTickets()
      })
  }
})

onUnmounted(() => {
  if (activeTicketId.value && $echo) {
    $echo.leave(`tickets.${activeTicketId.value}`)
  }
})

function selectTicket(id: string) {
  activeTicketId.value = id
}

function scrollToBottom() {
  nextTick(() => {
    if (messagesContainer.value) {
      messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight
    }
  })
}

async function sendMessage() {
  if (!messageText.value || messageText.value === '<p></p>' || !activeTicketId.value) return

  const tempId = Date.now()
  const body = messageText.value
  const { user } = useAuth()

  messages.value.push({
    id: tempId,
    user: { id: user.value!.id, name: user.value!.name, is_admin: false },
    body,
    created_at: new Date().toISOString(),
  })
  messageText.value = ''
  scrollToBottom()

  sending.value = true
  try {
    await fetchCsrfCookie()
    const res = await $api<{ data: TicketMsg }>(`/tickets/${activeTicketId.value}/reply`, {
      method: 'POST',
      body: { body },
    })
    const idx = messages.value.findIndex(m => m.id === tempId)
    if (idx !== -1) messages.value[idx] = res.data
    refreshTickets()
  } catch {
    messages.value = messages.value.filter(m => m.id !== tempId)
  } finally {
    sending.value = false
  }
}

function openCreateModal() {
  newTicket.subject = ''
  newTicket.category_id = categories.value[0]?.id ?? 0
  newTicket.body = ''
  createError.value = ''
  showCreateModal.value = true
}

async function handleCreateTicket() {
  if (!newTicket.subject.trim() || !newTicket.body) return
  creating.value = true
  createError.value = ''
  try {
    await fetchCsrfCookie()
    const res = await $api<{ data: TicketItem }>('/tickets', {
      method: 'POST',
      body: { subject: newTicket.subject, category_id: newTicket.category_id, body: newTicket.body },
    })
    showCreateModal.value = false
    await refreshTickets()
    activeTicketId.value = res.data.id
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    createError.value = err.data?.message || 'Failed to create ticket.'
  } finally {
    creating.value = false
  }
}

function stripHtml(html: string) {
  return html.replace(/<[^>]*>/g, '').slice(0, 100)
}

function formatDate(date: string) {
  const d = new Date(date)
  const now = new Date()
  const diff = now.getTime() - d.getTime()
  if (diff < 3600000) return `${Math.floor(diff / 60000)}m ago`
  if (diff < 86400000) return `${Math.floor(diff / 3600000)}h ago`
  if (diff < 604800000) return `${Math.floor(diff / 86400000)}d ago`
  return d.toLocaleDateString('en', { month: 'short', day: 'numeric' })
}

function formatTime(date: string) {
  return new Date(date).toLocaleTimeString('en', { hour: '2-digit', minute: '2-digit' })
}
</script>

<style scoped>
.send-btn { width: 46px; height: 46px; }
.ticket-list--collapsed { display: none; }
.ticket-chat--empty { display: none; }

@media (min-width: 1024px) {
  .ticket-list { width: 340px; }
  .ticket-list--collapsed { display: flex; }
  .ticket-chat--empty { display: flex; }
}
:deep(.prose-chat p) { margin: 0.15rem 0; }
:deep(.prose-chat strong) { font-weight: 600; }
:deep(.prose-chat ul) { list-style: disc; padding-left: 1.25rem; }
:deep(.prose-chat ol) { list-style: decimal; padding-left: 1.25rem; }
:deep(.prose-chat a) { color: rgb(239 68 68); text-decoration: underline; }
:deep(.prose-chat code) { background: rgba(255 255 255 / 0.08); border-radius: 0.25rem; padding: 0.1rem 0.3rem; font-size: 0.85em; }
:deep(.prose-chat blockquote) { border-left: 2px solid rgba(255 255 255 / 0.1); padding-left: 0.75rem; opacity: 0.7; }
</style>
