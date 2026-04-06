<template>
  <div>
    <PageHeader :title="$t('admin.manageSettings')" :subtitle="$t('admin.manageSettingsDesc')" />

    <h2 class="mb-4 font-display text-lg font-bold uppercase tracking-wider">{{ $t('admin.downloadSettings') }}</h2>

    <form @submit.prevent="handleSubmit" class="space-y-6">
      <div class="grid gap-6 lg:grid-cols-2">
        <section class="card-panel p-6 space-y-4">
          <h3 class="text-[13px] font-bold uppercase tracking-widest text-white/30">{{ $t('admin.downloadGeneral') }}</h3>
          <div>
            <label class="form-label">{{ $t('admin.downloadUrl') }}</label>
            <input v-model="form.url" type="text"
              class="form-input"
              placeholder="https://...">
          </div>
          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="form-label">{{ $t('admin.fileSize') }}</label>
              <input v-model="form.file_size" type="text"
                class="form-input"
                placeholder="~8.2 GB">
            </div>
          </div>
          <div>
            <label class="form-label">Discord URL</label>
            <input v-model="form.discord_url" type="text"
              class="form-input"
              placeholder="https://discord.gg/...">
          </div>
        </section>

        <div class="space-y-6">
          <section v-for="(reqs, key) in { min_requirements: form.min_requirements, rec_requirements: form.rec_requirements }" :key="key"
            class="card-panel p-6 space-y-3">
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
                class="form-input w-24 shrink-0"
                placeholder="Label">
              <input v-model="req.value" type="text"
                class="form-input flex-1"
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
        <section class="card-panel p-6 space-y-4">
          <div class="flex items-center gap-3">
            <ToggleSwitch v-model="announceForm.enabled" />
            <span class="text-[13px] text-white/50">{{ $t('admin.announceEnabled') }}</span>
          </div>

          <div>
            <label class="form-label">{{ $t('admin.announceText') }}</label>
            <input v-model="announceForm.text" type="text"
              class="form-input"
              placeholder="Patch 3.9.7 is live...">
          </div>

          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="form-label">{{ $t('admin.announceLinkText') }}</label>
              <input v-model="announceForm.link_text" type="text"
                class="form-input"
                placeholder="Read more">
            </div>
            <div>
              <label class="form-label">{{ $t('admin.announceLinkUrl') }}</label>
              <input v-model="announceForm.link_url" type="text"
                class="form-input"
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

    <div class="mt-12 border-t border-white/[0.04] pt-10">
      <h2 class="mb-4 font-display text-lg font-bold uppercase tracking-wider">{{ $t('admin.teleportSettings') }}</h2>

      <form @submit.prevent="handleTeleportSubmit" class="space-y-6">
        <div class="grid gap-6 lg:grid-cols-2">
          <section v-for="race in ['elyos', 'asmodians']" :key="race"
            class="card-panel p-6 space-y-3">
            <h3 class="text-[13px] font-bold uppercase tracking-widest text-white/30">{{ race === 'elyos' ? 'Elyos' : 'Asmodians' }}</h3>
            <div class="grid gap-3 sm:grid-cols-2">
              <div v-for="coord in ['x', 'y', 'z']" :key="coord">
                <label class="mb-1 block text-[11px] font-medium text-white/25">{{ coord.toUpperCase() }}</label>
                <input v-model.number="teleportForm[`${race}_${coord}`]" type="number" step="any"
                  class="form-input">
              </div>
              <div>
                <label class="mb-1 block text-[11px] font-medium text-white/25">Map ID</label>
                <input v-model.number="teleportForm[`${race}_map`]" type="number" step="1"
                  class="form-input">
              </div>
            </div>
          </section>
        </div>

        <section class="card-panel p-6">
          <div class="max-w-xs">
            <label class="form-label">{{ $t('admin.cooldownMinutes') }}</label>
            <input v-model.number="teleportForm.cooldown_minutes" type="number" min="1" step="1"
              class="form-input">
          </div>
        </section>

        <AlertMessage :message="teleportSuccess" variant="success" />
        <AlertMessage :message="teleportError" variant="error" />

        <AppButton type="submit" :loading="teleportSaving" :loading-text="$t('common.loading')">
          {{ $t('common.save') }}
        </AppButton>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const { t } = useI18n()
const { $api } = useApi()
const { submit, loading: saving, successMsg, errorMsg } = useFormSubmit()

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
  await submit(async (api) => {
    const res = await api<{ message: string }>('/admin/settings/download', { method: 'PUT', body: { ...form } })
    return res.message || t('admin.settingsSaved')
  }, t('admin.settingsFailed'))
}

const { submit: announceSubmit, loading: announceSaving, successMsg: announceSuccess, errorMsg: announceError } = useFormSubmit()

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
  await announceSubmit(async (api) => {
    const res = await api<{ message: string }>('/admin/settings/announcement', { method: 'PUT', body: { ...announceForm } })
    return res.message || t('admin.settingsSaved')
  }, t('admin.settingsFailed'))
}

const { submit: teleportSubmit, loading: teleportSaving, successMsg: teleportSuccess, errorMsg: teleportError } = useFormSubmit()

const teleportForm = reactive<Record<string, number>>({
  elyos_x: 0,
  elyos_y: 0,
  elyos_z: 0,
  elyos_map: 0,
  asmodians_x: 0,
  asmodians_y: 0,
  asmodians_z: 0,
  asmodians_map: 0,
  cooldown_minutes: 60,
})

async function fetchTeleportSettings() {
  try {
    const res = await $api<{ data: Record<string, number> }>('/admin/settings/teleport')
    Object.assign(teleportForm, res.data)
  } catch { /* */ }
}

fetchTeleportSettings()

async function handleTeleportSubmit() {
  await teleportSubmit(async (api) => {
    const res = await api<{ message: string }>('/admin/settings/teleport', { method: 'PUT', body: { ...teleportForm } })
    return res.message || t('admin.settingsSaved')
  }, t('admin.settingsFailed'))
}
</script>
