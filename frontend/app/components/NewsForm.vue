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
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.newsTitle') }} ({{ loc }})</label>
              <input v-model="form.title[loc]" type="text"
                class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30 placeholder:text-white/15"
                :placeholder="$t('admin.newsTitlePlaceholder')">
            </div>
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.excerpt') }} ({{ loc }})</label>
              <textarea v-model="form.excerpt[loc]" rows="2"
                class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30 placeholder:text-white/15 resize-none"
                :placeholder="$t('admin.excerptPlaceholder')" />
            </div>
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.body') }} ({{ loc }})</label>
              <RichEditor v-model="form.body[loc]" :placeholder="$t('admin.bodyPlaceholder')" />
            </div>
          </div>
        </section>
      </div>

      <div class="space-y-5">
        <section class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6 space-y-4">
          <div>
            <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.tag') }}</label>
            <select v-model="form.tag"
              class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30">
              <option value="Update">Update</option>
              <option value="Event">Event</option>
              <option value="Patch">Patch</option>
              <option value="Guide">Guide</option>
              <option value="News">News</option>
            </select>
          </div>

          <div>
            <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.image') }}</label>
            <input type="file" accept="image/*" @change="handleImageChange"
              class="w-full text-[13px] text-white/40 file:mr-3 file:rounded-lg file:border-0 file:bg-white/[0.06] file:px-3 file:py-1.5 file:text-[12px] file:font-medium file:text-white/50 file:cursor-pointer hover:file:bg-white/[0.1]">
            <div v-if="article?.image_url && !imageFile" class="mt-2">
              <img :src="article.image_url" class="h-20 rounded-lg object-cover opacity-60" />
            </div>
          </div>

          <div class="flex items-center gap-3">
            <button type="button" @click="form.published = !form.published"
              :class="['relative h-6 w-11 rounded-full transition-colors duration-300',
                form.published ? 'bg-emerald-500' : 'bg-white/10']">
              <span :class="['absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white transition-transform duration-300',
                form.published && 'translate-x-5']" />
            </button>
            <span class="text-[13px] text-white/50">{{ $t('admin.publishNow') }}</span>
          </div>
        </section>

        <AlertMessage :message="successMsg" variant="success" />
        <AlertMessage :message="errorMsg" variant="error" />

        <AppButton type="submit" :loading="saving" :loading-text="$t('common.loading')" block>
          {{ article ? $t('admin.saveArticle') : $t('admin.createArticle') }}
        </AppButton>

        <button v-if="article" type="button" @click="handleDelete"
          class="w-full rounded-lg border border-red-500/10 bg-red-600/5 py-2.5 text-[12px] font-bold uppercase tracking-widest text-red-400/60 transition-colors hover:bg-red-600/10 hover:text-red-400">
          {{ $t('admin.deleteArticle') }}
        </button>
      </div>
    </div>
  </form>
</template>

<script setup lang="ts">
import type { NewsArticle } from '~/composables/useNews'

interface ArticleWithTranslations extends NewsArticle {
  translations?: {
    title: Record<string, string>
    excerpt: Record<string, string>
    body: Record<string, string>
  }
}

const props = defineProps<{
  article?: ArticleWithTranslations | null
}>()

const emit = defineEmits<{
  saved: [id: number]
}>()

const { t, availableLocales } = useI18n()
const { $api, fetchCsrfCookie } = useApi()
const router = useRouter()

const locales = availableLocales
const activeLang = ref(locales[0])
const { submit, loading: saving, successMsg, errorMsg } = useFormSubmit()
const imageFile = ref<File | null>(null)

const emptyTranslations = () => Object.fromEntries(locales.map(l => [l, '']))

const form = reactive({
  title: emptyTranslations(),
  excerpt: emptyTranslations(),
  body: emptyTranslations(),
  tag: 'News',
  published: false,
})

watch(() => props.article, (a) => {
  if (!a) return
  if (a.translations) {
    for (const loc of locales) {
      form.title[loc] = a.translations.title?.[loc] ?? ''
      form.excerpt[loc] = a.translations.excerpt?.[loc] ?? ''
      form.body[loc] = a.translations.body?.[loc] ?? ''
    }
  }
  form.tag = a.tag
  form.published = a.published
}, { immediate: true })

function handleImageChange(e: Event) {
  const input = e.target as HTMLInputElement
  imageFile.value = input.files?.[0] ?? null
}

async function handleSubmit() {
  const fd = new FormData()
  for (const loc of locales) {
    fd.append(`title[${loc}]`, form.title[loc] || '')
    fd.append(`excerpt[${loc}]`, form.excerpt[loc] || '')
    fd.append(`body[${loc}]`, form.body[loc] || '')
  }
  fd.append('tag', form.tag)
  fd.append('published', form.published ? '1' : '0')
  if (form.published) fd.append('published_at', new Date().toISOString())
  if (imageFile.value) fd.append('image', imageFile.value)

  await submit(async (api) => {
    if (props.article) {
      fd.append('_method', 'PUT')
      const res = await api<{ data: NewsArticle; message: string }>(`/admin/news/${props.article.id}`, { method: 'POST', body: fd })
      emit('saved', res.data.id)
      return res.message || t('admin.articleSaved')
    }
    const res = await api<{ data: NewsArticle; message: string }>('/admin/news', { method: 'POST', body: fd })
    emit('saved', res.data.id)
    return res.message || t('admin.articleCreated')
  }, t('admin.articleFailed'))
}

async function handleDelete() {
  if (!props.article || !confirm(t('admin.deleteConfirm'))) return
  try {
    await fetchCsrfCookie()
    await $api(`/admin/news/${props.article.id}`, { method: 'DELETE' })
    router.push('/admin/news')
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    errorMsg.value = err.data?.message || t('admin.articleFailed')
  }
}
</script>
