<template>
  <AdminFormLayout
    :item="entry" :saving="saving" :success-msg="successMsg" :error-msg="errorMsg"
    :save-label="$t('admin.saveWikiEntry')" :create-label="$t('admin.createWikiEntry')" :delete-label="$t('admin.deleteWikiEntry')"
    @submit="onSubmit" @delete="onDelete">
    <template #main>
      <section class="card-panel p-6 space-y-4">
        <div class="grid gap-4 sm:grid-cols-2">
          <div>
            <label class="form-label">{{ $t('admin.categoryLabel') }}</label>
            <select v-model.number="form.wiki_category_id" class="form-input disabled:opacity-40">
              <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
            </select>
          </div>
          <div>
            <label class="form-label">{{ $t('admin.wikiType') }}</label>
            <select v-model="form.type" :disabled="!!entry" class="form-input disabled:opacity-40">
              <option v-for="tp in types" :key="tp" :value="tp">{{ tp }}</option>
            </select>
          </div>
        </div>

        <div v-if="form.type === 'text'">
          <label class="form-label">{{ $t('admin.body') }}</label>
          <RichEditor v-model="form.content.body as string" placeholder="Paragraph text..." />
        </div>

        <template v-if="form.type === 'table'">
          <div>
            <label class="form-label">{{ $t('admin.newsTitle') }}</label>
            <input v-model="form.content.title" type="text" class="form-input" placeholder="Section title">
          </div>
          <div>
            <div class="mb-2 flex items-center justify-between">
              <label class="text-[12px] font-medium text-white/30">Rows</label>
              <button type="button" @click="addRow"
                class="rounded-lg bg-white/[0.04] px-2.5 py-1 text-[11px] font-bold text-white/30 hover:bg-white/[0.08]">+</button>
            </div>
            <div v-for="(row, i) in (form.content.rows as string[][])" :key="i" class="mb-2 flex gap-2">
              <input v-model="row[0]" type="text" class="form-input w-1/3" placeholder="Label">
              <input v-model="row[1]" type="text" class="form-input flex-1" placeholder="Value">
              <button type="button" @click="removeRow(i)"
                class="shrink-0 rounded-lg px-2 text-white/15 hover:bg-red-600/10 hover:text-red-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
            </div>
          </div>
        </template>

        <template v-if="form.type === 'callout'">
          <div>
            <label class="form-label">Callout type</label>
            <select v-model="form.content.callout_type" class="form-input">
              <option value="tip">Tip</option>
              <option value="warning">Warning</option>
              <option value="note">Note</option>
            </select>
          </div>
          <div>
            <label class="form-label">{{ $t('admin.body') }}</label>
            <RichEditor v-model="form.content.body as string" placeholder="Callout text..." />
          </div>
        </template>

        <template v-if="form.type === 'spoiler'">
          <div>
            <label class="form-label">{{ $t('admin.newsTitle') }}</label>
            <input v-model="form.content.title" type="text" class="form-input" placeholder="Spoiler question">
          </div>
          <div>
            <label class="form-label">{{ $t('admin.body') }}</label>
            <RichEditor v-model="form.content.body as string" placeholder="Answer..." />
          </div>
        </template>
      </section>
    </template>

    <template #sidebar>
      <section class="card-panel p-6 space-y-4">
        <div>
          <label class="form-label">{{ $t('admin.sortOrder') }}</label>
          <input v-model.number="form.sort_order" type="number" min="0" class="form-input" placeholder="0">
        </div>
        <div class="flex items-center gap-3">
          <ToggleSwitch v-model="form.published" />
          <span class="text-[13px] text-white/50">{{ $t('admin.published') }}</span>
        </div>
      </section>
    </template>
  </AdminFormLayout>
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

const props = defineProps<{ entry?: WikiItem | null }>()
const emit = defineEmits<{ saved: [id: number] }>()

const { t } = useI18n()
const { $api } = useApi()

const { data: catsData } = useAsyncData('wiki-categories', () => $api<{ data: WikiCat[] }>('/admin/wiki-categories'))
const categories = computed(() => catsData.value?.data ?? [])
const types = ['text', 'table', 'callout', 'spoiler']

const { handleSubmit, handleDelete, saving, successMsg, errorMsg } = useAdminForm<WikiItem>({
  endpoint: '/admin/wiki',
  redirectTo: '/admin/wiki',
  i18n: { saved: t('admin.wikiSaved'), created: t('admin.wikiCreated'), failed: t('admin.wikiFailed'), deleteConfirm: t('admin.wikiDeleteConfirm') },
})

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

async function onSubmit() {
  const payload = {
    wiki_category_id: form.wiki_category_id,
    type: form.type,
    content: form.content,
    sort_order: form.sort_order,
    published: form.published,
  }
  await handleSubmit(props.entry, payload, id => emit('saved', id))
}

function onDelete() {
  handleDelete(props.entry)
}
</script>
