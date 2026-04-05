<template>
  <div>
    <PageHeader :title="$t('admin.manageSettings')" :subtitle="$t('admin.manageSettingsDesc')" />

    <h2 class="mb-4 font-display text-lg font-bold uppercase tracking-wider">{{ $t('admin.downloadSettings') }}</h2>

    <form @submit.prevent="handleSubmit" class="space-y-6">
      <div class="grid gap-6 lg:grid-cols-2">
        <section class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6 space-y-4">
          <h3 class="text-[13px] font-bold uppercase tracking-widest text-white/30">{{ $t('admin.downloadGeneral') }}</h3>
          <div>
            <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.downloadUrl') }}</label>
            <input v-model="form.url" type="text"
              class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30 placeholder:text-white/15"
              placeholder="https://...">
          </div>
          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.fileSize') }}</label>
              <input v-model="form.file_size" type="text"
                class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30 placeholder:text-white/15"
                placeholder="~8.2 GB">
            </div>
          </div>
          <div>
            <label class="mb-1.5 block text-[12px] font-medium text-white/30">Discord URL</label>
            <input v-model="form.discord_url" type="text"
              class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30 placeholder:text-white/15"
              placeholder="https://discord.gg/...">
          </div>
        </section>

        <div class="space-y-6">
          <section v-for="(reqs, key) in { min_requirements: form.min_requirements, rec_requirements: form.rec_requirements }" :key="key"
            class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6 space-y-3">
            <div class="flex items-center justify-between">
              <h3 class="text-[13px] font-bold uppercase tracking-widest text-white/30">
                {{ key === 'min_requirements' ? $t('admin.minRequirements') : $t('admin.recRequirements') }}
              </h3>
              <button type="button" @click="addReq(key)"
                class="rounded-lg bg-white/[0.04] px-2.5 py-1 text-[11px] font-bold text-white/30 transition-colors hover:bg-white/[0.08] hover:text-white/50">
                +
              </button>
            </div>
            <div v-for="(req, i) in reqs" :key="i" class="flex gap-2">
              <input v-model="req.label" type="text"
                class="w-24 shrink-0 rounded-lg border border-white/[0.06] bg-white/[0.03] px-3 py-2 text-[13px] text-white/70 outline-none focus:border-red-500/30 placeholder:text-white/15"
                placeholder="Label">
              <input v-model="req.value" type="text"
                class="flex-1 rounded-lg border border-white/[0.06] bg-white/[0.03] px-3 py-2 text-[13px] text-white/70 outline-none focus:border-red-500/30 placeholder:text-white/15"
                placeholder="Value">
              <button type="button" @click="removeReq(key, i)"
                class="shrink-0 rounded-lg px-2 text-white/15 transition-colors hover:bg-red-600/10 hover:text-red-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
            </div>
          </section>
        </div>
      </div>

      <AlertMessage :message="successMsg" variant="success" />
      <AlertMessage :message="errorMsg" variant="error" />

      <AppButton type="submit" :loading="saving" :loading-text="$t('common.loading')">
        {{ $t('common.save') }}
      </AppButton>
    </form>

    <div class="mt-12 border-t border-white/[0.04] pt-10">
      <h2 class="mb-4 font-display text-lg font-bold uppercase tracking-wider">{{ $t('admin.announcementSettings') }}</h2>

      <form @submit.prevent="handleAnnounceSubmit" class="space-y-6">
        <section class="rounded-xl border border-white/[0.04] bg-white/[0.02] p-6 space-y-4">
          <label class="flex cursor-pointer items-center gap-3">
            <input v-model="announceForm.enabled" type="checkbox"
              class="h-4 w-4 rounded border-white/10 bg-white/[0.03] text-red-600 focus:ring-red-500/20" />
            <span class="text-[13px] text-white/50">{{ $t('admin.announceEnabled') }}</span>
          </label>

          <div>
            <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.announceText') }}</label>
            <input v-model="announceForm.text" type="text"
              class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30 placeholder:text-white/15"
              placeholder="Patch 3.9.7 is live...">
          </div>

          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.announceLinkText') }}</label>
              <input v-model="announceForm.link_text" type="text"
                class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30"
                placeholder="Read more">
            </div>
            <div>
              <label class="mb-1.5 block text-[12px] font-medium text-white/30">{{ $t('admin.announceLinkUrl') }}</label>
              <input v-model="announceForm.link_url" type="text"
                class="w-full rounded-lg border border-white/[0.06] bg-white/[0.03] px-4 py-2.5 text-[14px] text-white/70 outline-none transition-colors focus:border-red-500/30"
                placeholder="/news/patch-notes">
            </div>
          </div>
        </section>

        <AlertMessage :message="announceSuccess" variant="success" />
        <AlertMessage :message="announceError" variant="error" />

        <AppButton type="submit" :loading="announceSaving" :loading-text="$t('common.loading')">
          {{ $t('common.save') }}
        </AppButton>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const { t } = useI18n()
const { $api, fetchCsrfCookie } = useApi()

const saving = ref(false)
const successMsg = ref('')
const errorMsg = ref('')

interface ReqItem { label: string; value: string }

const form = reactive({
  url: '',
  file_size: '',
  discord_url: '',
  min_requirements: [] as ReqItem[],
  rec_requirements: [] as ReqItem[],
})

function addReq(key: string) {
  ;(form as any)[key].push({ label: '', value: '' })
}

function removeReq(key: string, index: number) {
  ;(form as any)[key].splice(index, 1)
}

async function fetchSettings() {
  try {
    const res = await $api<{ data: typeof form }>('/admin/settings/download')
    Object.assign(form, res.data)
  } catch { /* */ }
}

fetchSettings()

async function handleSubmit() {
  saving.value = true
  successMsg.value = ''
  errorMsg.value = ''

  try {
    await fetchCsrfCookie()
    const res = await $api<{ message: string }>('/admin/settings/download', {
      method: 'PUT',
      body: { ...form },
    })
    successMsg.value = res.message || t('admin.settingsSaved')
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    errorMsg.value = err.data?.message || t('admin.settingsFailed')
  } finally {
    saving.value = false
  }
}

const announceSaving = ref(false)
const announceSuccess = ref('')
const announceError = ref('')

const announceForm = reactive({
  enabled: true,
  text: '',
  link_text: '',
  link_url: '',
})

async function fetchAnnounceSettings() {
  try {
    const res = await $api<{ data: typeof announceForm }>('/admin/settings/announcement')
    Object.assign(announceForm, res.data)
  } catch { /* */ }
}

fetchAnnounceSettings()

async function handleAnnounceSubmit() {
  announceSaving.value = true
  announceSuccess.value = ''
  announceError.value = ''

  try {
    await fetchCsrfCookie()
    const res = await $api<{ message: string }>('/admin/settings/announcement', {
      method: 'PUT',
      body: { ...announceForm },
    })
    announceSuccess.value = res.message || t('admin.settingsSaved')
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    announceError.value = err.data?.message || t('admin.settingsFailed')
  } finally {
    announceSaving.value = false
  }
}
</script>
