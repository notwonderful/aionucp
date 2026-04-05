<template>
  <div>
    <NuxtLink to="/admin/products" class="inline-flex items-center gap-2 text-[13px] font-medium text-white/25 transition-colors hover:text-white/50">
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
      {{ $t('admin.backToProducts') }}
    </NuxtLink>

    <div v-if="!product" class="mt-8">
      <EmptyState :title="$t('admin.productNotFound')" />
    </div>

    <template v-else>
      <h1 class="mt-4 font-display text-2xl font-extrabold uppercase tracking-tight">{{ $t('admin.editProduct') }}</h1>
      <ProductForm class="mt-6" :product="product" @saved="handleSaved" />
    </template>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const route = useRoute()
const { $api } = useApi()

interface ProductDetail {
  id: number
  name: string
  toll: number
  item_id: number
  item_qty: number
  category_id: number
  image_url: string | null
  translations?: { name: Record<string, string>; description: Record<string, string> }
}

const product = ref<ProductDetail | null>(null)

async function fetchProduct() {
  try {
    const res = await $api<{ data: ProductDetail }>(`/admin/products/${route.params.id}`)
    product.value = res.data
  } catch { /* */ }
}

fetchProduct()

function handleSaved() {
  fetchProduct()
}
</script>
