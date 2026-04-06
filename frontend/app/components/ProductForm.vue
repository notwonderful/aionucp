<template>
  <form @submit.prevent="handleSubmit" class="space-y-6">
    <div class="grid gap-6 lg:grid-cols-3">
      <div class="lg:col-span-2 space-y-5">
        <section class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6 space-y-5">
          <div class="flex gap-2">
            <button v-for="loc in locales" :key="loc" type="button" @click="activeLang = loc"
              :class="['rounded-lg px-3 py-1.5 text-[12px] font-bold uppercase tracking-wider transition-all',
                activeLang === loc ? 'bg-red-600/15 text-red-400' : 'text-white/25 hover:text-white/50']">
              {{ loc }}
            </button>
          </div>

          <div v-for="loc in locales" :key="loc" v-show="activeLang === loc" class="space-y-4">
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.productName') }} ({{ loc }})</label>
              <input v-model="form.name[loc]" type="text"
                class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30 placeholder:text-white/15"
                :placeholder="$t('admin.productNamePlaceholder')">
            </div>
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.productDescription') }} ({{ loc }})</label>
              <RichEditor v-model="form.description[loc]" :placeholder="$t('admin.productDescPlaceholder')" />
            </div>
          </div>
        </section>
      </div>

      <div class="space-y-5">
        <section class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6 space-y-4">
          <div>
            <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.categoryLabel') }}</label>
            <select v-model.number="form.category_id"
              class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30">
              <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
            </select>
          </div>

          <div class="grid gap-3 grid-cols-2">
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">Item ID</label>
              <input v-model.number="form.item_id" type="number" min="0"
                class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none focus:border-red-500/30"
                placeholder="0">
            </div>
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.itemQty') }}</label>
              <input v-model.number="form.item_qty" type="number" min="1"
                class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none focus:border-red-500/30"
                placeholder="1">
            </div>
          </div>

          <div>
            <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.toll') }}</label>
            <input v-model.number="form.toll" type="number" min="0"
              class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none focus:border-red-500/30"
              placeholder="100">
          </div>

          <div>
            <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.image') }}</label>
            <input type="file" accept="image/*" @change="handleImageChange"
              class="w-full text-[13px] text-white/40 file:mr-3 file:rounded-lg file:border-0 file:bg-white/[0.06] file:px-3 file:py-1.5 file:text-[12px] file:font-medium file:text-white/50 file:cursor-pointer hover:file:bg-white/[0.1]">
            <div v-if="product?.image_url && !imageFile" class="mt-2">
              <img :src="product.image_url" class="h-20 rounded-lg object-cover opacity-60" />
            </div>
          </div>
        </section>

        <AlertMessage :message="successMsg" variant="success" />
        <AlertMessage :message="errorMsg" variant="error" />

        <AppButton type="submit" :loading="saving" :loading-text="$t('common.loading')" block>
          {{ product ? $t('admin.saveProduct') : $t('admin.createProduct') }}
        </AppButton>

        <button v-if="product" type="button" @click="handleDelete"
          class="w-full rounded-lg border border-red-500/10 bg-red-600/5 py-2.5 text-[12px] font-bold uppercase tracking-widest text-red-400/60 transition-colors hover:bg-red-600/10 hover:text-red-400">
          {{ $t('admin.deleteProduct') }}
        </button>
      </div>
    </div>
  </form>
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

const props = defineProps<{
  product?: ProductItem | null
}>()

const emit = defineEmits<{
  saved: [id: number]
}>()

const { t, availableLocales } = useI18n()
const { $api, fetchCsrfCookie } = useApi()
const router = useRouter()

const locales = availableLocales
const activeLang = ref(locales[0])
const { submit, loading: saving, successMsg, errorMsg } = useFormSubmit()
const imageFile = ref<File | null>(null)

const emptyTranslations = () => Object.fromEntries(locales.map(l => [l, '']))

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
    for (const loc of locales) {
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

async function handleSubmit() {
  const fd = new FormData()
  for (const loc of locales) {
    fd.append(`name[${loc}]`, form.name[loc] || '')
    fd.append(`description[${loc}]`, form.description[loc] || '')
  }
  fd.append('category_id', String(form.category_id ?? ''))
  fd.append('item_id', String(form.item_id))
  fd.append('item_qty', String(form.item_qty))
  fd.append('toll', String(form.toll))
  if (imageFile.value) fd.append('image', imageFile.value)

  await submit(async (api) => {
    if (props.product) {
      fd.append('_method', 'PUT')
      const res = await api<{ data: ProductItem; message: string }>(`/admin/products/${props.product.id}`, { method: 'POST', body: fd })
      emit('saved', res.data.id)
      return res.message || t('admin.productSaved')
    }
    const res = await api<{ data: ProductItem; message: string }>('/admin/products', { method: 'POST', body: fd })
    emit('saved', res.data.id)
    return res.message || t('admin.productCreated')
  }, t('admin.productFailed'))
}

async function handleDelete() {
  if (!props.product || !confirm(t('admin.productDeleteConfirm'))) return
  try {
    await fetchCsrfCookie()
    await $api(`/admin/products/${props.product.id}`, { method: 'DELETE' })
    router.push('/admin/products')
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    errorMsg.value = err.data?.message || t('admin.productFailed')
  }
}
</script>
