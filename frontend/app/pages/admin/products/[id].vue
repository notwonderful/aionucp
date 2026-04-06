<template>
  <div>
    <BackLink to="/admin/products" :label="$t('admin.backToProducts')" />

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
