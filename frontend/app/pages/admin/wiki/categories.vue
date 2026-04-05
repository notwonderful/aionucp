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
        class="flex-1 rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none focus:border-red-500/30 placeholder:text-white/15">
      <input v-model="newCat.slug" type="text" placeholder="slug"
        class="w-32 rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none focus:border-red-500/30 placeholder:text-white/15">
      <input v-model.number="newCat.sort_order" type="number" placeholder="0" min="0"
        class="w-20 rounded-lg border border-white/[0.06] bg-white/[0.03] px-3 py-2.5 text-[14px] text-white/70 outline-none focus:border-red-500/30">
      <AppButton type="submit" :loading="adding" :loading-text="'...'">{{ $t('common.save') }}</AppButton>
    </form>

    <AlertMessage :message="msg" variant="success" />

    <!-- List -->
    <div class="space-y-2">
      <div v-for="cat in cats" :key="cat.id"
        class="flex items-center gap-4 rounded-xl border border-white/[0.04] bg-white/[0.02] p-4">
        <input v-model="cat.name" type="text"
          class="flex-1 rounded-lg border border-white/[0.06] bg-white/[0.03] px-3 py-2 text-[14px] text-white/70 outline-none focus:border-red-500/30">
        <input v-model="cat.slug" type="text"
          class="w-28 rounded-lg border border-white/[0.06] bg-white/[0.03] px-3 py-2 text-[14px] text-white/70 outline-none focus:border-red-500/30">
        <input v-model.number="cat.sort_order" type="number" min="0"
          class="w-16 rounded-lg border border-white/[0.06] bg-white/[0.03] px-3 py-2 text-[14px] text-white/70 outline-none focus:border-red-500/30">
        <button type="button" @click="cat.published = !cat.published"
          :class="['relative h-6 w-11 shrink-0 rounded-full transition-colors duration-300',
            cat.published ? 'bg-emerald-500' : 'bg-white/10']">
          <span :class="['absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white transition-transform duration-300',
            cat.published && 'translate-x-5']" />
        </button>
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
