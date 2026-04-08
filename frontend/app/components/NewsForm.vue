<template>
  <AdminFormLayout
    :item="article" :saving="saving" :success-msg="successMsg" :error-msg="errorMsg"
    :save-label="$t('admin.saveArticle')" :create-label="$t('admin.createArticle')" :delete-label="$t('admin.deleteArticle')"
    @submit="onSubmit" @delete="onDelete">
    <template #main>
      <section class="card-panel p-6 space-y-5">
        <LanguageTabs v-model="activeLang" />

        <div v-for="loc in availableLocales" :key="loc" v-show="activeLang === loc" class="space-y-4">
          <div>
            <label class="form-label">{{ $t('admin.newsTitle') }} ({{ loc }})</label>
            <input v-model="form.title[loc]" type="text" class="form-input" :placeholder="$t('admin.newsTitlePlaceholder')">
          </div>
          <div>
            <label class="form-label">{{ $t('admin.excerpt') }} ({{ loc }})</label>
            <textarea v-model="form.excerpt[loc]" rows="2" class="form-input resize-none" :placeholder="$t('admin.excerptPlaceholder')" />
          </div>
          <div>
            <label class="form-label">{{ $t('admin.body') }} ({{ loc }})</label>
            <RichEditor v-model="form.body[loc]" :placeholder="$t('admin.bodyPlaceholder')" />
          </div>
        </div>
      </section>
    </template>

    <template #sidebar>
      <section class="card-panel p-6 space-y-4">
        <div>
          <label class="form-label">{{ $t('admin.tag') }}</label>
          <select v-model="form.tag" class="form-input">
            <option value="Update">Update</option>
            <option value="Event">Event</option>
            <option value="Patch">Patch</option>
            <option value="Guide">Guide</option>
            <option value="News">News</option>
          </select>
        </div>

        <div>
          <label class="form-label">{{ $t('admin.image') }}</label>
          <input type="file" accept="image/*" @change="handleImageChange"
            class="w-full text-[13px] text-white/40 file:mr-3 file:rounded-lg file:border-0 file:bg-white/[0.06] file:px-3 file:py-1.5 file:text-[12px] file:font-medium file:text-white/50 file:cursor-pointer hover:file:bg-white/[0.1]">
          <div v-if="article?.image_url && !imageFile" class="mt-2">
            <img :src="article.image_url" class="h-20 rounded-lg object-cover opacity-60" />
          </div>
        </div>

        <div class="flex items-center gap-3">
          <ToggleSwitch v-model="form.published" />
          <span class="text-[13px] text-white/50">{{ $t('admin.publishNow') }}</span>
        </div>
      </section>
    </template>
  </AdminFormLayout>
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

const props = defineProps<{ article?: ArticleWithTranslations | null }>()
const emit = defineEmits<{ saved: [id: number] }>()

const { t, availableLocales } = useI18n()
const activeLang = ref(availableLocales[0] ?? 'en')
const imageFile = ref<File | null>(null)

const emptyTranslations = () => Object.fromEntries(availableLocales.map(l => [l, '']))

const { handleSubmit, handleDelete, saving, successMsg, errorMsg } = useAdminForm<NewsArticle>({
  endpoint: '/admin/news',
  redirectTo: '/admin/news',
  i18n: { saved: t('admin.articleSaved'), created: t('admin.articleCreated'), failed: t('admin.articleFailed'), deleteConfirm: t('admin.deleteConfirm') },
})

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
    for (const loc of availableLocales) {
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

async function onSubmit() {
  const fd = new FormData()
  for (const loc of availableLocales) {
    fd.append(`title[${loc}]`, form.title[loc] || '')
    fd.append(`excerpt[${loc}]`, form.excerpt[loc] || '')
    fd.append(`body[${loc}]`, form.body[loc] || '')
  }
  fd.append('tag', form.tag)
  fd.append('published', form.published ? '1' : '0')
  if (form.published) fd.append('published_at', new Date().toISOString())
  if (imageFile.value) fd.append('image', imageFile.value)
  await handleSubmit(props.article, fd, id => emit('saved', id))
}

function onDelete() {
  handleDelete(props.article)
}
</script>
