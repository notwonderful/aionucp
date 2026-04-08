<template>
  <AdminFormLayout
    :item="product" :saving="saving" :success-msg="successMsg" :error-msg="errorMsg"
    :save-label="$t('admin.saveProduct')" :create-label="$t('admin.createProduct')" :delete-label="$t('admin.deleteProduct')"
    @submit="onSubmit" @delete="onDelete">
    <template #main>
      <section class="card-panel p-6 space-y-5">
        <LanguageTabs v-model="activeLang" />

        <div v-for="loc in availableLocales" :key="loc" v-show="activeLang === loc" class="space-y-4">
          <div>
            <label class="form-label">{{ $t('admin.productName') }} ({{ loc }})</label>
            <input v-model="form.name[loc]" type="text" class="form-input" :placeholder="$t('admin.productNamePlaceholder')">
          </div>
          <div>
            <label class="form-label">{{ $t('admin.productDescription') }} ({{ loc }})</label>
            <RichEditor v-model="form.description[loc]" :placeholder="$t('admin.productDescPlaceholder')" />
          </div>
        </div>
      </section>
    </template>

    <template #sidebar>
      <section class="card-panel p-6 space-y-4">
        <div>
          <label class="form-label">{{ $t('admin.categoryLabel') }}</label>
          <select v-model.number="form.category_id" class="form-input">
            <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
          </select>
        </div>

        <div class="grid gap-3 grid-cols-2">
          <div>
            <label class="form-label">Item ID</label>
            <input v-model.number="form.item_id" type="number" min="0" class="form-input" placeholder="0">
          </div>
          <div>
            <label class="form-label">{{ $t('admin.itemQty') }}</label>
            <input v-model.number="form.item_qty" type="number" min="1" class="form-input" placeholder="1">
          </div>
        </div>

        <div>
          <label class="form-label">{{ $t('admin.toll') }}</label>
          <input v-model.number="form.toll" type="number" min="0" class="form-input" placeholder="100">
        </div>

        <div>
          <label class="form-label">{{ $t('admin.image') }}</label>
          <input type="file" accept="image/*" @change="handleImageChange"
            class="w-full text-[13px] text-white/40 file:mr-3 file:rounded-lg file:border-0 file:bg-white/[0.06] file:px-3 file:py-1.5 file:text-[12px] file:font-medium file:text-white/50 file:cursor-pointer hover:file:bg-white/[0.1]">
          <div v-if="product?.image_url && !imageFile" class="mt-2">
            <img :src="product.image_url" class="h-20 rounded-lg object-cover opacity-60" />
          </div>
        </div>
      </section>
    </template>
  </AdminFormLayout>
</template>

<script setup lang="ts">
interface ProductItem {
  id: number
  name: string
  toll: number
  item_id: number
  item_qty: number
  category_id: number
  image_url: string | null
  translations?: { name: Record<string, string>; description: Record<string, string> }
}

interface CatItem { id: number; name: string }

const props = defineProps<{ product?: ProductItem | null }>()
const emit = defineEmits<{ saved: [id: number] }>()

const { t, availableLocales } = useI18n()
const { $api } = useApi()
const activeLang = ref(availableLocales[0] ?? 'en')
const imageFile = ref<File | null>(null)

const emptyTranslations = () => Object.fromEntries(availableLocales.map(l => [l, '']))

const { handleSubmit, handleDelete, saving, successMsg, errorMsg } = useAdminForm<ProductItem>({
  endpoint: '/admin/products',
  redirectTo: '/admin/products',
  i18n: { saved: t('admin.productSaved'), created: t('admin.productCreated'), failed: t('admin.productFailed'), deleteConfirm: t('admin.productDeleteConfirm') },
})

const { data: catsData } = useAsyncData('product-form-cats', () => $api<{ data: CatItem[] }>('/admin/categories'))
const categories = computed(() => catsData.value?.data ?? [])

const form = reactive({
  name: emptyTranslations(),
  description: emptyTranslations(),
  category_id: null as number | null,
  item_id: 0,
  item_qty: 1,
  toll: 0,
})

watch(() => props.product, (p) => {
  if (!p) return
  if (p.translations) {
    for (const loc of availableLocales) {
      form.name[loc] = p.translations.name?.[loc] ?? ''
      form.description[loc] = p.translations.description?.[loc] ?? ''
    }
  }
  form.category_id = p.category_id
  form.item_id = p.item_id
  form.item_qty = p.item_qty
  form.toll = p.toll
}, { immediate: true })

function handleImageChange(e: Event) {
  const input = e.target as HTMLInputElement
  imageFile.value = input.files?.[0] ?? null
}

async function onSubmit() {
  const fd = new FormData()
  for (const loc of availableLocales) {
    fd.append(`name[${loc}]`, form.name[loc] || '')
    fd.append(`description[${loc}]`, form.description[loc] || '')
  }
  fd.append('category_id', String(form.category_id ?? ''))
  fd.append('item_id', String(form.item_id))
  fd.append('item_qty', String(form.item_qty))
  fd.append('toll', String(form.toll))
  if (imageFile.value) fd.append('image', imageFile.value)
  await handleSubmit(props.product, fd, id => emit('saved', id))
}

function onDelete() {
  handleDelete(props.product)
}
</script>
