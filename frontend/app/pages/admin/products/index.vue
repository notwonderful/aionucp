<template>
  <div>
    <PageHeader :title="$t('admin.manageProducts')" :subtitle="$t('admin.manageProductsDesc')">
      <template #actions>
        <NuxtLink to="/admin/categories"
          class="inline-flex items-center gap-2 rounded-lg border border-white/[0.06] bg-white/[0.02] px-4 py-2 text-[13px] font-semibold text-white/40 transition-colors hover:bg-white/[0.04] hover:text-white/60">
          {{ $t('admin.manageCategories') }}
        </NuxtLink>
        <NuxtLink to="/admin/products/create"
          class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-[13px] font-semibold text-white transition-colors hover:bg-red-500">
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
          {{ $t('admin.createProduct') }}
        </NuxtLink>
      </template>
    </PageHeader>

    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <FilterTabs v-model="catFilter" :tabs="categoryTabs" />
      <SearchInput v-model="search" :placeholder="$t('admin.searchProducts')" class="sm:w-64" />
    </div>

    <SkeletonLoader v-if="status === 'pending'" height="h-20" />

    <template v-else>
      <DataTable :columns="columns" :has-rows="!!products.length" :empty-text="$t('admin.noProductsFound')">
        <NuxtLink v-for="item in products" :key="item.id" :to="`/admin/products/${item.id}`"
          class="table-row border-b border-white/[0.04] last:border-0 transition-colors hover:bg-white/[0.015]">
          <td class="px-5 py-3.5">
            <img v-if="item.image_url" :src="item.image_url" class="h-10 w-10 rounded-lg object-cover" />
            <div v-else class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/[0.04]">
              <svg class="h-4 w-4 text-white/15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5" /></svg>
            </div>
          </td>
          <td class="px-5 py-3.5 text-[13px] font-semibold text-white/70">{{ item.name }}</td>
          <td class="px-5 py-3.5 text-[12px] text-white/30">{{ item.category?.name }}</td>
          <td class="px-5 py-3.5 text-right font-display text-[13px] font-bold tabular-nums text-red-400/70">{{ item.toll }}</td>
          <td class="px-5 py-3.5 text-right text-[12px] tabular-nums text-white/20">{{ item.sales_count }}</td>
        </NuxtLink>
      </DataTable>
    </template>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const { t } = useI18n()
const { $api } = useApi()

interface CatItem { id: number; name: string }
interface ProductItem { id: number; name: string; toll: number; sales_count: number; image_url: string | null; category?: CatItem }

const { data: catsData } = useAsyncData('admin-product-cats', () => $api<{ data: CatItem[] }>('/admin/categories'))
const categoryTabs = computed(() => [
  { label: t('history.all'), value: '' },
  ...(catsData.value?.data ?? []).map(c => ({ label: c.name, value: String(c.id) })),
])

const columns = computed(() => [
  { key: 'image', label: '' },
  { key: 'name', label: t('admin.productName') },
  { key: 'category', label: t('admin.categoryLabel') },
  { key: 'toll', label: t('admin.toll'), align: 'right' as const },
  { key: 'sales', label: t('admin.salesCount'), align: 'right' as const },
])

const catFilter = ref('')
const search = ref('')

const queryParams = computed(() => {
  const params = new URLSearchParams()
  if (catFilter.value) params.set('filter[category_id]', catFilter.value)
  if (search.value) params.set('filter[name]', search.value)
  return params.toString()
})

const { data, status } = useAsyncData(
  'admin-products',
  () => $api<{ data: ProductItem[] }>(`/admin/products${queryParams.value ? `?${queryParams.value}` : ''}`),
  { watch: [queryParams] },
)

const products = computed(() => data.value?.data ?? [])
</script>
