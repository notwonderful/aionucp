<template>
  <div>
    <NuxtLink to="/admin/news" class="inline-flex items-center gap-2 text-[13px] font-medium text-white/25 transition-colors hover:text-white/50">
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
      {{ $t('admin.backToNews') }}
    </NuxtLink>

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
