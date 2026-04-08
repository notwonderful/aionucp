<template>
  <AdminFormLayout
    :item="faq" :saving="saving" :success-msg="successMsg" :error-msg="errorMsg"
    :save-label="$t('admin.saveFaq')" :create-label="$t('admin.createFaq')" :delete-label="$t('admin.deleteFaq')"
    @submit="onSubmit" @delete="onDelete">
    <template #main>
      <section class="card-panel p-6 space-y-5">
        <LanguageTabs v-model="activeLang" />

        <div v-for="loc in availableLocales" :key="loc" v-show="activeLang === loc" class="space-y-4">
          <div>
            <label class="form-label">{{ $t('admin.question') }} ({{ loc }})</label>
            <input v-model="form.question[loc]" type="text" class="form-input" :placeholder="$t('admin.questionPlaceholder')">
          </div>
          <div>
            <label class="form-label">{{ $t('admin.answer') }} ({{ loc }})</label>
            <textarea v-model="form.answer[loc]" rows="6" class="form-input resize-y" :placeholder="$t('admin.answerPlaceholder')" />
          </div>
        </div>
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
interface FaqItem {
  id: number
  question: string
  answer: string
  sort_order: number
  published: boolean
  translations?: {
    question: Record<string, string>
    answer: Record<string, string>
  }
}

const props = defineProps<{ faq?: FaqItem | null }>()
const emit = defineEmits<{ saved: [id: number] }>()

const { t, availableLocales } = useI18n()
const activeLang = ref(availableLocales[0] ?? 'en')

const emptyTranslations = () => Object.fromEntries(availableLocales.map(l => [l, '']))

const { handleSubmit, handleDelete, saving, successMsg, errorMsg } = useAdminForm<FaqItem>({
  endpoint: '/admin/faq',
  redirectTo: '/admin/faq',
  i18n: { saved: t('admin.faqSaved'), created: t('admin.faqCreated'), failed: t('admin.faqFailed'), deleteConfirm: t('admin.faqDeleteConfirm') },
})

const form = reactive({
  question: emptyTranslations(),
  answer: emptyTranslations(),
  sort_order: 0,
  published: true,
})

watch(() => props.faq, (f) => {
  if (!f) return
  if (f.translations) {
    for (const loc of availableLocales) {
      form.question[loc] = f.translations.question?.[loc] ?? ''
      form.answer[loc] = f.translations.answer?.[loc] ?? ''
    }
  }
  form.sort_order = f.sort_order
  form.published = f.published
}, { immediate: true })

async function onSubmit() {
  const payload = {
    question: { ...form.question },
    answer: { ...form.answer },
    sort_order: form.sort_order,
    published: form.published,
  }
  await handleSubmit(props.faq, payload, id => emit('saved', id))
}

function onDelete() {
  handleDelete(props.faq)
}
</script>
