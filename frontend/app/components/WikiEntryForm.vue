<template>
  <form @submit.prevent="handleSubmit" class="space-y-6">
    <div class="grid gap-6 lg:grid-cols-3">
      <div class="lg:col-span-2 space-y-5">
        <section class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6 space-y-4">
          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.categoryLabel') }}</label>
              <select v-model.number="form.wiki_category_id"
                class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none focus:border-red-500/30 disabled:opacity-40">
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
              </select>
            </div>
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.wikiType') }}</label>
              <select v-model="form.type" :disabled="!!entry"
                class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none focus:border-red-500/30 disabled:opacity-40">
                <option v-for="tp in types" :key="tp" :value="tp">{{ tp }}</option>
              </select>
            </div>
          </div>

          <!-- Text -->
          <div v-if="form.type === 'text'">
            <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.body') }}</label>
            <RichEditor v-model="form.content.body as string" placeholder="Paragraph text..." />
          </div>

          <!-- Table -->
          <template v-if="form.type === 'table'">
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.newsTitle') }}</label>
              <input v-model="form.content.title" type="text"
                class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none focus:border-red-500/30"
                placeholder="Section title">
            </div>
            <div>
              <div class="mb-2 flex items-center justify-between">
                <label class="text-[12px] font-medium text-white/30">Rows</label>
                <button type="button" @click="addRow"
                  class="rounded-lg bg-white/[0.04] px-2.5 py-1 text-[11px] font-bold text-white/30 hover:bg-white/[0.08]">+</button>
              </div>
              <div v-for="(row, i) in (form.content.rows as string[][])" :key="i" class="mb-2 flex gap-2">
                <input v-model="row[0]" type="text"
                  class="w-1/3 rounded-lg border border-white/[0.06] bg-white/[0.03] px-3 py-2 text-[13px] text-white/70 outline-none focus:border-red-500/30"
                  placeholder="Label">
                <input v-model="row[1]" type="text"
                  class="flex-1 rounded-lg border border-white/[0.06] bg-white/[0.03] px-3 py-2 text-[13px] text-white/70 outline-none focus:border-red-500/30"
                  placeholder="Value">
                <button type="button" @click="removeRow(i)"
                  class="shrink-0 rounded-lg px-2 text-white/15 hover:bg-red-600/10 hover:text-red-400">
                  <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
              </div>
            </div>
          </template>

          <!-- Callout -->
          <template v-if="form.type === 'callout'">
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">Callout type</label>
              <select v-model="form.content.callout_type"
                class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none focus:border-red-500/30">
                <option value="tip">Tip</option>
                <option value="warning">Warning</option>
                <option value="note">Note</option>
              </select>
            </div>
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.body') }}</label>
              <RichEditor v-model="form.content.body as string" placeholder="Callout text..." />
            </div>
          </template>

          <!-- Spoiler -->
          <template v-if="form.type === 'spoiler'">
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.newsTitle') }}</label>
              <input v-model="form.content.title" type="text"
                class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none focus:border-red-500/30"
                placeholder="Spoiler question">
            </div>
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.body') }}</label>
              <RichEditor v-model="form.content.body as string" placeholder="Answer..." />
            </div>
          </template>
        </section>
      </div>

      <div class="space-y-5">
        <section class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6 space-y-4">
          <div>
            <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.sortOrder') }}</label>
            <input v-model.number="form.sort_order" type="number" min="0"
              class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none focus:border-red-500/30"
              placeholder="0">
          </div>
          <div class="flex items-center gap-3">
            <button type="button" @click="form.published = !form.published"
              :class="['relative h-6 w-11 rounded-full transition-colors duration-300',
                form.published ? 'bg-emerald-500' : 'bg-white/10']">
              <span :class="['absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white transition-transform duration-300',
                form.published && 'translate-x-5']" />
            </button>
            <span class="text-[13px] text-white/50">{{ $t('admin.published') }}</span>
          </div>
        </section>

        <AlertMessage :message="successMsg" variant="success" />
        <AlertMessage :message="errorMsg" variant="error" />

        <AppButton type="submit" :loading="saving" :loading-text="$t('common.loading')" block>
          {{ entry ? $t('admin.saveWikiEntry') : $t('admin.createWikiEntry') }}
        </AppButton>

        <button v-if="entry" type="button" @click="handleDelete"
          class="w-full rounded-lg border border-red-500/10 bg-red-600/5 py-2.5 text-[12px] font-bold uppercase tracking-widest text-red-400/60 transition-colors hover:bg-red-600/10 hover:text-red-400">
          {{ $t('admin.deleteWikiEntry') }}
        </button>
      </div>
    </div>
  </form>
</template>

<script setup lang="ts">
interface WikiCat { id: number; name: string; slug: string }

interface WikiItem {
  id: number
  wiki_category_id: number
  type: string
  content: Record<string, unknown>
  sort_order: number
  published: boolean
}

const props = defineProps<{
  entry?: WikiItem | null
}>()

const emit = defineEmits<{
  saved: [id: number]
}>()

const { t } = useI18n()
const { $api, fetchCsrfCookie } = useApi()
const router = useRouter()

const { data: catsData } = useAsyncData('wiki-categories', () => $api<{ data: WikiCat[] }>('/admin/wiki-categories'))
const categories = computed(() => catsData.value?.data ?? [])
const types = ['text', 'table', 'callout', 'spoiler']
const saving = ref(false)
const successMsg = ref('')
const errorMsg = ref('')

function initContent(type: string): Record<string, unknown> {
  if (type === 'text') return { body: '' }
  if (type === 'table') return { title: '', rows: [['', '']] }
  if (type === 'callout') return { callout_type: 'tip', body: '' }
  return { title: '', body: '' }
}

const form = reactive({
  wiki_category_id: null as number | null,
  type: 'text',
  content: initContent('text') as Record<string, unknown>,
  sort_order: 0,
  published: true,
})

watch(() => form.type, (tp) => {
  if (!props.entry) form.content = initContent(tp)
})

watch(() => props.entry, (e) => {
  if (!e) return
  form.wiki_category_id = e.wiki_category_id
  form.type = e.type
  form.content = JSON.parse(JSON.stringify(e.content))
  form.sort_order = e.sort_order
  form.published = e.published
}, { immediate: true })

function addRow() {
  if (!form.content.rows) form.content.rows = []
  ;(form.content.rows as string[][]).push(['', ''])
}

function removeRow(i: number) {
  ;(form.content.rows as string[][]).splice(i, 1)
}

async function handleSubmit() {
  saving.value = true
  successMsg.value = ''
  errorMsg.value = ''

  try {
    await fetchCsrfCookie()

    const payload = {
      wiki_category_id: form.wiki_category_id,
      type: form.type,
      content: form.content,
      sort_order: form.sort_order,
      published: form.published,
    }

    if (props.entry) {
      const res = await $api<{ data: WikiItem; message: string }>(`/admin/wiki/${props.entry.id}`, {
        method: 'PUT',
        body: payload,
      })
      successMsg.value = res.message || t('admin.wikiSaved')
      emit('saved', res.data.id)
    } else {
      const res = await $api<{ data: WikiItem; message: string }>('/admin/wiki', {
        method: 'POST',
        body: payload,
      })
      successMsg.value = res.message || t('admin.wikiCreated')
      emit('saved', res.data.id)
    }
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    errorMsg.value = err.data?.message || t('admin.wikiFailed')
  } finally {
    saving.value = false
  }
}

async function handleDelete() {
  if (!props.entry || !confirm(t('admin.wikiDeleteConfirm'))) return
  try {
    await fetchCsrfCookie()
    await $api(`/admin/wiki/${props.entry.id}`, { method: 'DELETE' })
    router.push('/admin/wiki')
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    errorMsg.value = err.data?.message || t('admin.wikiFailed')
  }
}
</script>
