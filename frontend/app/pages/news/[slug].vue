<template>
  <div class="text-white">
    <div v-if="status === 'pending'" class="pt-28 pb-24">
      <div class="mx-auto max-w-[760px] px-6 space-y-4">
        <div class="h-6 w-32 animate-pulse rounded bg-white/[0.04]" />
        <div class="h-12 w-3/4 animate-pulse rounded bg-white/[0.04]" />
        <div class="h-64 animate-pulse rounded bg-white/[0.02]" />
      </div>
    </div>

    <div v-else-if="!article" class="flex min-h-[60vh] flex-col items-center justify-center pt-28">
      <div class="font-display text-6xl font-extrabold text-white/10">404</div>
      <p class="mt-4 text-[14px] text-white/30">{{ $t('news.notFound') }}</p>
      <NuxtLink :to="localePath('/news')" class="mt-6 text-[12px] font-bold uppercase tracking-widest text-red-500 hover:text-red-400">&larr; {{ $t('news.backToNews') }}</NuxtLink>
    </div>

    <template v-else>
      <div class="relative overflow-hidden pt-28 pb-12">
        <div v-if="article.image_url" class="absolute inset-0 bg-cover bg-center opacity-[0.08]" :style="{ backgroundImage: `url(${article.image_url})` }" />
        <div class="absolute inset-0 bg-gradient-to-b from-surface via-transparent to-surface" />
        <div class="relative mx-auto max-w-[760px] px-6">
          <NuxtLink :to="localePath('/news')" class="mb-6 inline-flex items-center gap-1.5 text-[12px] font-medium text-white/30 transition-colors hover:text-white/60">
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            {{ $t('news.allNews') }}
          </NuxtLink>
          <div class="flex items-center gap-3">
            <span class="rounded bg-red-600/15 px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest text-red-400">{{ article.tag }}</span>
            <time class="text-[12px] text-white/20">{{ formatDate(article.published_at || article.created_at) }}</time>
          </div>
          <h1 class="mt-4 font-display text-3xl font-extrabold uppercase tracking-tight lg:text-5xl">{{ article.title }}</h1>
          <p class="mt-4 text-[15px] text-white/40">{{ article.excerpt }}</p>
        </div>
      </div>

      <article class="mx-auto max-w-[760px] px-6 pb-24">
        <div class="prose-article" v-html="renderedBody" />
      </article>
    </template>
  </div>
</template>

<script setup lang="ts">
import type { NewsArticle } from '~/composables/useNews'

definePageMeta({ layout: 'default' })

const route = useRoute()
const { $api } = useApi()
const localePath = useLocalePath()
const { full: formatDate } = useDate()

const { data: articleData, status } = useAsyncData(
  `news-${route.params.slug}`,
  () => $api<{ data: NewsArticle }>(`/news/${route.params.slug}`),
)

const article = computed(() => articleData.value?.data)

const renderedBody = computed(() => {
  if (!article.value) return ''
  return article.value.body
    .split('\n\n')
    .map(block => {
      block = block.trim()
      if (!block) return ''
      if (block.startsWith('## '))
        return `<h2>${block.slice(3)}</h2>`
      if (block.startsWith('### '))
        return `<h3>${block.slice(4)}</h3>`
      if (block.startsWith('- ')) {
        const items = block.split('\n').map(line =>
          `<li>${inlineFormat(line.replace(/^- /, ''))}</li>`
        ).join('')
        return `<ul>${items}</ul>`
      }
      if (/^\d+\. /.test(block)) {
        const items = block.split('\n').map(line =>
          `<li>${inlineFormat(line.replace(/^\d+\. /, ''))}</li>`
        ).join('')
        return `<ol>${items}</ol>`
      }
      return `<p>${inlineFormat(block)}</p>`
    })
    .join('')
})

function inlineFormat(text: string): string {
  return text
    .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
    .replace(/\*(.+?)\*/g, '<em>$1</em>')
    .replace(/`(.+?)`/g, '<code>$1</code>')
}
</script>

<style>
.prose-article h2 {
  font-family: var(--font-display);
  font-size: 1.5rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: -0.02em;
  color: white;
  margin-top: 2.5rem;
  margin-bottom: 1rem;
}
.prose-article h3 {
  font-family: var(--font-display);
  font-size: 1.125rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.02em;
  color: rgba(255,255,255,0.85);
  margin-top: 2rem;
  margin-bottom: 0.75rem;
}
.prose-article p {
  font-size: 0.9375rem;
  line-height: 1.75;
  color: rgba(255,255,255,0.4);
  margin-bottom: 1.25rem;
}
.prose-article strong {
  color: rgba(255,255,255,0.7);
  font-weight: 600;
}
.prose-article em {
  font-style: italic;
  color: rgba(255,255,255,0.5);
}
.prose-article code {
  font-size: 0.8125rem;
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.06);
  border-radius: 0.25rem;
  padding: 0.125rem 0.375rem;
  color: rgba(220,60,60,0.7);
}
.prose-article ul, .prose-article ol {
  margin-bottom: 1.25rem;
  padding-left: 1.25rem;
}
.prose-article ul { list-style-type: disc; }
.prose-article ol { list-style-type: decimal; }
.prose-article li {
  font-size: 0.9375rem;
  line-height: 1.75;
  color: rgba(255,255,255,0.4);
  margin-bottom: 0.25rem;
}
.prose-article li strong {
  color: rgba(255,255,255,0.7);
}
</style>
