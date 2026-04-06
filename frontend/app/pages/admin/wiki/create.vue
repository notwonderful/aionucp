<template>
  <div>
    <BackLink to="/admin/wiki" :label="$t('admin.backToWiki')" />

    <h1 class="mt-4 font-display text-2xl font-extrabold uppercase tracking-tight">{{ $t('admin.createWikiEntry') }}</h1>

    <WikiEntryForm class="mt-6" @saved="handleSaved" />
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const router = useRouter()

function handleSaved(id: number) {
  router.push(`/admin/wiki/${id}`)
}
</script>
