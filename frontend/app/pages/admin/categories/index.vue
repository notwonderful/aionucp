<template>
  <div>
    <PageHeader :title="$t('admin.manageCategories')" :subtitle="$t('admin.manageCategoriesDesc')">
      <template #actions>
        <NuxtLink to="/admin/products" class="text-[13px] font-medium text-white/25 transition-colors hover:text-white/50">
          {{ $t('admin.backToProducts') }}
        </NuxtLink>
      </template>
    </PageHeader>

    <!-- Add new -->
    <form @submit.prevent="handleAdd" class="mb-8 card-panel p-5">
      <h3 class="mb-3 text-[12px] font-bold uppercase tracking-widest text-white/20">{{ $t('admin.addCategory') }}</h3>
      <div class="flex flex-col gap-3 sm:flex-row">
        <div class="flex-1 space-y-2">
          <div v-for="loc in locales" :key="loc" class="flex gap-2">
            <span class="flex w-8 shrink-0 items-center justify-center text-[10px] font-bold uppercase text-white/20">{{ loc }}</span>
            <input v-model="newCat.name[loc]" type="text" :placeholder="`Name (${loc})`"
              class="flex-1 rounded-lg border border-white/[0.06] bg-white/[0.03] px-3 py-2 text-[13px] text-white/70 outline-none focus:border-red-500/30 placeholder:text-white/15">
          </div>
        </div>
        <div class="flex items-end">
          <AppButton type="submit" :loading="adding" :loading-text="'...'">{{ $t('common.save') }}</AppButton>
        </div>
      </div>
    </form>

    <AlertMessage :message="msg" variant="success" />

    <!-- List -->
    <div class="space-y-2">
      <div v-for="cat in cats" :key="cat.id"
        class="card-panel p-4">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
          <div class="flex-1 space-y-1.5">
            <div v-for="loc in locales" :key="loc" class="flex gap-2">
              <span class="flex w-8 shrink-0 items-center justify-center text-[10px] font-bold uppercase text-white/20">{{ loc }}</span>
              <input v-model="cat._names[loc]" type="text"
                class="flex-1 rounded-lg border border-white/[0.06] bg-white/[0.03] px-3 py-2 text-[13px] text-white/70 outline-none focus:border-red-500/30">
            </div>
          </div>
          <div class="flex items-center gap-2">
            <span class="text-[11px] text-white/15">{{ cat.products_count ?? 0 }} items</span>
            <button @click="handleSave(cat)" class="rounded-lg bg-white/[0.04] px-3 py-2 text-[12px] font-bold text-white/40 hover:bg-white/[0.08] hover:text-white/60">
              {{ $t('common.save') }}
            </button>
            <button @click="handleDelete(cat)" class="rounded-lg px-2 py-2 text-white/15 hover:bg-red-600/10 hover:text-red-400">
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <div v-if="!cats.length && !loading" class="py-12 text-center text-[14px] text-white/20">{{ $t('admin.noCategoriesFound') }}</div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const { t, availableLocales } = useI18n()
const { $api, fetchCsrfCookie } = useApi()

const locales = availableLocales
const loading = ref(true)
const adding = ref(false)
const msg = ref('')

const emptyNames = () => Object.fromEntries(locales.map(l => [l, '']))
const newCat = reactive({ name: emptyNames() })

interface CatItem {
  id: number
  name: string
  slug: string
  parent_id: number | null
  translations?: { name: Record<string, string> }
  products_count?: number
  _names: Record<string, string>
}

const cats = ref<CatItem[]>([])

async function fetchCats() {
  loading.value = true
  try {
    const res = await $api<{ data: CatItem[] }>('/admin/categories')
    cats.value = res.data.map(c => ({
      ...c,
      _names: c.translations?.name
        ? { ...emptyNames(), ...c.translations.name }
        : Object.fromEntries(locales.map(l => [l, c.name])),
    }))
  } catch { /* */ } finally { loading.value = false }
}

fetchCats()

async function handleAdd() {
  adding.value = true
  try {
    await fetchCsrfCookie()
    const fd = new FormData()
    for (const loc of locales) fd.append(`name[${loc}]`, newCat.name[loc] || '')
    await $api('/admin/categories', { method: 'POST', body: fd })
    Object.assign(newCat.name, emptyNames())
    await fetchCats()
    msg.value = t('admin.categorySaved')
    setTimeout(() => msg.value = '', 3000)
  } catch { /* */ } finally { adding.value = false }
}

async function handleSave(cat: CatItem) {
  try {
    await fetchCsrfCookie()
    const fd = new FormData()
    for (const loc of locales) fd.append(`name[${loc}]`, cat._names[loc] || '')
    fd.append('_method', 'PUT')
    await $api(`/admin/categories/${cat.id}`, { method: 'POST', body: fd })
    msg.value = t('admin.categorySaved')
    setTimeout(() => msg.value = '', 3000)
  } catch { /* */ }
}

async function handleDelete(cat: CatItem) {
  if (!confirm(t('admin.categoryDeleteConfirm'))) return
  try {
    await fetchCsrfCookie()
    await $api(`/admin/categories/${cat.id}`, { method: 'DELETE' })
    await fetchCats()
  } catch { /* */ }
}
</script>
