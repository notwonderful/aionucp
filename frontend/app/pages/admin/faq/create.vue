<template>
  <div>
    <BackLink to="/admin/faq" :label="$t('admin.backToFaq')" />

    <h1 class="mt-4 font-display text-2xl font-extrabold uppercase tracking-tight">{{ $t('admin.createFaq') }}</h1>

    <FaqForm class="mt-6" @saved="handleSaved" />
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const router = useRouter()

function handleSaved(id: number) {
  router.push(`/admin/faq/${id}`)
}
</script>
