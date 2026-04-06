<template>
  <div>
    <BackLink to="/admin/news" :label="$t('admin.backToNews')" />

    <div v-if="!article" class="mt-8">
      <EmptyState :title="$t('admin.articleNotFound')" />
    </div>

    <template v-else>
      <h1 class="mt-4 font-display text-2xl font-extrabold uppercase tracking-tight">{{ $t('admin.editArticle') }}</h1>
      <NewsForm class="mt-6" :article="article" @saved="handleSaved" />
    </template>
  </div>
</template>

<script setup lang="ts">
import type { NewsArticle } from '~/composables/useNews'

definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const route = useRoute()
const { $api } = useApi()

interface NewsDetailResponse {
  data: NewsArticle & { translations?: { title: Record<string, string>; excerpt: Record<string, string>; body: Record<string, string> } }
}

const article = ref<NewsDetailResponse['data'] | null>(null)

async function fetchArticle() {
  try {
    const res = await $api<NewsDetailResponse>(`/admin/news/${route.params.id}`)
    article.value = res.data
  } catch { /* */ }
}

fetchArticle()

function handleSaved() {
  fetchArticle()
}
</script>
