<template>
  <div class="text-white">
    <!-- 404 -->
    <div v-if="!article" class="flex min-h-[60vh] flex-col items-center justify-center pt-28">
      <div class="font-display text-6xl font-extrabold text-white/10">404</div>
      <p class="mt-4 text-[14px] text-white/30">Article not found.</p>
      <NuxtLink to="/news" class="mt-6 text-[12px] font-bold uppercase tracking-widest text-red-500 hover:text-red-400">&larr; Back to news</NuxtLink>
    </div>

    <!-- Article -->
    <template v-else>
      <!-- Hero -->
      <div class="relative overflow-hidden pt-28 pb-12">
        <div v-if="article.image" class="absolute inset-0 bg-cover bg-center opacity-[0.08]" :style="{ backgroundImage: `url(${article.image})` }" />
        <div class="absolute inset-0 bg-gradient-to-b from-surface via-transparent to-surface" />
        <div class="relative mx-auto max-w-[760px] px-6">
          <NuxtLink to="/news" class="mb-6 inline-flex items-center gap-1.5 text-[12px] font-medium text-white/30 transition-colors hover:text-white/60">
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            {{ lang === 'ru' ? 'Все новости' : 'All news' }}
          </NuxtLink>
          <div class="flex items-center gap-3">
            <span class="rounded bg-red-600/15 px-2 py-0.5 text-[10px] font-bold uppercase tracking-widest text-red-400">{{ article.tag }}</span>
            <time class="text-[12px] text-white/20">{{ formatDate(article.date) }}</time>
          </div>
          <h1 class="mt-4 font-display text-3xl font-extrabold uppercase tracking-tight lg:text-5xl">{{ article.title }}</h1>
          <p class="mt-4 text-[15px] text-white/40">{{ article.excerpt }}</p>
        </div>
      </div>

      <!-- Body -->
      <article class="mx-auto max-w-[760px] px-6 pb-24">
        <div class="prose-article" v-html="renderedBody" />

        <!-- Nav between articles -->
        <div class="mt-16 flex items-center justify-between border-t border-white/[0.04] pt-8">
          <NuxtLink v-if="prevArticle" :to="`/news/${prevArticle.slug}`" class="group flex items-center gap-2 text-[13px] text-white/30 transition-colors hover:text-white/60">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            {{ prevArticle.title }}
          </NuxtLink>
          <div v-else />
          <NuxtLink v-if="nextArticle" :to="`/news/${nextArticle.slug}`" class="group flex items-center gap-2 text-right text-[13px] text-white/30 transition-colors hover:text-white/60">
            {{ nextArticle.title }}
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
          </NuxtLink>
        </div>
      </article>
    </template>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'default' })

const { lang } = useLang()
const route = useRoute()
const { getAll, getBySlug } = useNews()

const article = getBySlug(route.params.slug as string)
const allArticles = getAll()
const currentIndex = allArticles.findIndex(a => a.slug === route.params.slug)
const prevArticle = currentIndex > 0 ? allArticles[currentIndex - 1] : null
const nextArticle = currentIndex < allArticles.length - 1 ? allArticles[currentIndex + 1] : null

function formatDate(dateStr: string): string {
  const d = new Date(dateStr)
  return d.toLocaleDateString(lang.value === 'ru' ? 'ru-RU' : 'en-US', { year: 'numeric', month: 'long', day: 'numeric' })
}

// Simple markdown-ish renderer (## headers, **bold**, - lists, paragraphs)
const renderedBody = computed(() => {
  if (!article) return ''
  return article.body
    .split('\n\n')
    .map(block => {
      block = block.trim()
      if (!block) return ''
      // H2
      if (block.startsWith('## '))
        return `<h2>${block.slice(3)}</h2>`
      // H3
      if (block.startsWith('### '))
        return `<h3>${block.slice(4)}</h3>`
      // List
      if (block.startsWith('- ')) {
        const items = block.split('\n').map(line =>
          `<li>${inlineFormat(line.replace(/^- /, ''))}</li>`
        ).join('')
        return `<ul>${items}</ul>`
      }
      // Numbered list
      if (/^\d+\. /.test(block)) {
        const items = block.split('\n').map(line =>
          `<li>${inlineFormat(line.replace(/^\d+\. /, ''))}</li>`
        ).join('')
        return `<ol>${items}</ol>`
      }
      // Paragraph
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

if (!article) {
  throw createError({ statusCode: 404, statusMessage: 'Article not found' })
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
