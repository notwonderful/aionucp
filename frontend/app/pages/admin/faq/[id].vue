<template>
  <div>
    <BackLink to="/admin/faq" :label="$t('admin.backToFaq')" />

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
