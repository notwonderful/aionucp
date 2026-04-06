<template>
  <div>
    <BackLink to="/admin/products" :label="$t('admin.backToProducts')" />

    <h1 class="mt-4 font-display text-2xl font-extrabold uppercase tracking-tight">{{ $t('admin.createProduct') }}</h1>

    <ProductForm class="mt-6" @saved="handleSaved" />
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const router = useRouter()

function handleSaved(id: number) {
  router.push(`/admin/products/${id}`)
}
</script>
