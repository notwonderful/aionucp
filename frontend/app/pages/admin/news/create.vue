<template>
  <div>
    <BackLink to="/admin/news" :label="$t('admin.backToNews')" />

    <h1 class="mt-4 font-display text-2xl font-extrabold uppercase tracking-tight">{{ $t('admin.createArticle') }}</h1>

    <NewsForm class="mt-6" @saved="handleSaved" />
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const router = useRouter()

function handleSaved(id: number) {
  router.push(`/admin/news/${id}`)
}
</script>
