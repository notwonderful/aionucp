<template>
  <div>
    <NuxtLink to="/admin/faq" class="inline-flex items-center gap-2 text-[13px] font-medium text-white/25 transition-colors hover:text-white/50">
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
      {{ $t('admin.backToFaq') }}
    </NuxtLink>

    <div v-if="!faq" class="mt-8">
      <EmptyState :title="$t('admin.faqNotFound')" />
    </div>

    <template v-else>
      <h1 class="mt-4 font-display text-2xl font-extrabold uppercase tracking-tight">{{ $t('admin.editFaq') }}</h1>
      <FaqForm class="mt-6" :faq="faq" @saved="handleSaved" />
    </template>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const route = useRoute()
const { $api } = useApi()

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

const faq = ref<FaqItem | null>(null)

async function fetchFaq() {
  try {
    const res = await $api<{ data: FaqItem }>(`/admin/faq/${route.params.id}`)
    faq.value = res.data
  } catch { /* */ }
}

fetchFaq()

function handleSaved() {
  fetchFaq()
}
</script>
