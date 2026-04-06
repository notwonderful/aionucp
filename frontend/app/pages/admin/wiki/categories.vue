<template>
  <div>
    <PageHeader :title="$t('admin.wikiCategories')" :subtitle="$t('admin.wikiCategoriesDesc')">
      <template #actions>
        <NuxtLink to="/admin/wiki" class="text-[13px] font-medium text-white/25 transition-colors hover:text-white/50">
          {{ $t('admin.backToWiki') }}
        </NuxtLink>
      </template>
    </PageHeader>

    <!-- Add new -->
    <form @submit.prevent="handleAdd" class="mb-8 flex gap-3">
      <input v-model="newCat.name" type="text" placeholder="Category name"
        class="form-input flex-1">
      <input v-model="newCat.slug" type="text" placeholder="slug"
        class="form-input w-32">
      <input v-model.number="newCat.sort_order" type="number" placeholder="0" min="0"
        class="form-input w-20">
      <AppButton type="submit" :loading="adding" :loading-text="'...'">{{ $t('common.save') }}</AppButton>
    </form>

    <AlertMessage :message="msg" variant="success" />

    <!-- List -->
    <div class="space-y-2">
      <div v-for="cat in cats" :key="cat.id"
        class="flex items-center gap-4 card-panel p-4">
        <input v-model="cat.name" type="text"
          class="form-input flex-1">
        <input v-model="cat.slug" type="text"
          class="form-input w-28">
        <input v-model.number="cat.sort_order" type="number" min="0"
          class="form-input w-16">
        <ToggleSwitch v-model="cat.published" class="shrink-0" />
        <button @click="handleSave(cat)" class="rounded-lg bg-white/[0.04] px-3 py-2 text-[12px] font-bold text-white/40 hover:bg-white/[0.08] hover:text-white/60">
          {{ $t('common.save') }}
        </button>
        <button @click="handleDelete(cat)" class="rounded-lg px-2 py-2 text-white/15 hover:bg-red-600/10 hover:text-red-400">
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const { t } = useI18n()
const { $api, fetchCsrfCookie } = useApi()

interface WikiCat { id: number; name: string; slug: string; sort_order: number; published: boolean; entries_count?: number }

const cats = ref<WikiCat[]>([])
const adding = ref(false)
const msg = ref('')
const newCat = reactive({ name: '', slug: '', sort_order: 0 })

async function fetchCats() {
  const res = await $api<{ data: WikiCat[] }>('/admin/wiki-categories?sort=sort_order')
  cats.value = res.data
}

fetchCats()

async function handleAdd() {
  adding.value = true
  try {
    await fetchCsrfCookie()
    await $api('/admin/wiki-categories', { method: 'POST', body: { ...newCat, published: true } })
    newCat.name = ''
    newCat.slug = ''
    newCat.sort_order = 0
    await fetchCats()
    msg.value = t('admin.wikiCategorySaved')
    setTimeout(() => msg.value = '', 3000)
  } catch { /* */ } finally { adding.value = false }
}

async function handleSave(cat: WikiCat) {
  try {
    await fetchCsrfCookie()
    await $api(`/admin/wiki-categories/${cat.id}`, { method: 'PUT', body: { name: cat.name, slug: cat.slug, sort_order: cat.sort_order, published: cat.published } })
    msg.value = t('admin.wikiCategorySaved')
    setTimeout(() => msg.value = '', 3000)
  } catch { /* */ }
}

async function handleDelete(cat: WikiCat) {
  if (!confirm(t('admin.wikiCategoryDeleteConfirm'))) return
  try {
    await fetchCsrfCookie()
    await $api(`/admin/wiki-categories/${cat.id}`, { method: 'DELETE' })
    await fetchCats()
  } catch { /* */ }
}
</script>
