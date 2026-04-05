<template>
  <form @submit.prevent="handleSubmit" class="space-y-6">
    <div class="grid gap-6 lg:grid-cols-3">
      <div class="lg:col-span-2 space-y-5">
        <section class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6 space-y-5">
          <div class="flex gap-2">
            <button v-for="loc in locales" :key="loc" type="button" @click="activeLang = loc"
              :class="['rounded-lg px-3 py-1.5 text-[12px] font-bold uppercase tracking-wider transition-all',
                activeLang === loc ? 'bg-red-600/15 text-red-400' : 'text-white/25 hover:text-white/50']">
              {{ loc }}
            </button>
          </div>

          <div v-for="loc in locales" :key="loc" v-show="activeLang === loc" class="space-y-4">
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.question') }} ({{ loc }})</label>
              <input v-model="form.question[loc]" type="text"
                class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30 placeholder:text-white/15"
                :placeholder="$t('admin.questionPlaceholder')">
            </div>
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.answer') }} ({{ loc }})</label>
              <textarea v-model="form.answer[loc]" rows="6"
                class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30 placeholder:text-white/15 resize-y"
                :placeholder="$t('admin.answerPlaceholder')" />
            </div>
          </div>
        </section>
      </div>

      <div class="space-y-5">
        <section class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6 space-y-4">
          <div>
            <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.sortOrder') }}</label>
            <input v-model.number="form.sort_order" type="number" min="0"
              class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30 placeholder:text-white/15"
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
          {{ faq ? $t('admin.saveFaq') : $t('admin.createFaq') }}
        </AppButton>

        <button v-if="faq" type="button" @click="handleDelete"
          class="w-full rounded-lg border border-red-500/10 bg-red-600/5 py-2.5 text-[12px] font-bold uppercase tracking-widest text-red-400/60 transition-colors hover:bg-red-600/10 hover:text-red-400">
          {{ $t('admin.deleteFaq') }}
        </button>
      </div>
    </div>
  </form>
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

const props = defineProps<{
  faq?: FaqItem | null
}>()

const emit = defineEmits<{
  saved: [id: number]
}>()

const { t, availableLocales } = useI18n()
const { $api, fetchCsrfCookie } = useApi()
const router = useRouter()

const locales = availableLocales
const activeLang = ref(locales[0])
const saving = ref(false)
const successMsg = ref('')
const errorMsg = ref('')

const emptyTranslations = () => Object.fromEntries(locales.map(l => [l, '']))

const form = reactive({
  question: emptyTranslations(),
  answer: emptyTranslations(),
  sort_order: 0,
  published: true,
})

watch(() => props.faq, (f) => {
  if (!f) return
  if (f.translations) {
    for (const loc of locales) {
      form.question[loc] = f.translations.question?.[loc] ?? ''
      form.answer[loc] = f.translations.answer?.[loc] ?? ''
    }
  }
  form.sort_order = f.sort_order
  form.published = f.published
}, { immediate: true })

async function handleSubmit() {
  saving.value = true
  successMsg.value = ''
  errorMsg.value = ''

  try {
    await fetchCsrfCookie()

    const payload = {
      question: { ...form.question },
      answer: { ...form.answer },
      sort_order: form.sort_order,
      published: form.published,
    }

    if (props.faq) {
      const res = await $api<{ data: FaqItem; message: string }>(`/admin/faq/${props.faq.id}`, {
        method: 'PUT',
        body: payload,
      })
      successMsg.value = res.message || t('admin.faqSaved')
      emit('saved', res.data.id)
    } else {
      const res = await $api<{ data: FaqItem; message: string }>('/admin/faq', {
        method: 'POST',
        body: payload,
      })
      successMsg.value = res.message || t('admin.faqCreated')
      emit('saved', res.data.id)
    }
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    errorMsg.value = err.data?.message || t('admin.faqFailed')
  } finally {
    saving.value = false
  }
}

async function handleDelete() {
  if (!props.faq || !confirm(t('admin.faqDeleteConfirm'))) return
  try {
    await fetchCsrfCookie()
    await $api(`/admin/faq/${props.faq.id}`, { method: 'DELETE' })
    router.push('/admin/faq')
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    errorMsg.value = err.data?.message || t('admin.faqFailed')
  }
}
</script>
