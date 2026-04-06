<template>
  <form @submit.prevent="handleSubmit" class="space-y-6">
    <div class="grid gap-6 lg:grid-cols-3">
      <div class="lg:col-span-2 space-y-5">
        <section class="card-panel p-6 space-y-4">
          <div>
            <label class="form-label">{{ $t('admin.categoryLabel') }}</label>
            <select v-model="form.category" :disabled="!!entry"
              class="form-input disabled:opacity-40">
              <option value="siege">Siege</option>
              <option value="dredgion">Dredgion</option>
              <option value="rift">Rift</option>
            </select>
          </div>

          <div>
            <label class="form-label">{{ $t('admin.entryName') }}</label>
            <input v-model="form.name" type="text"
              class="form-input"
              :placeholder="form.category === 'siege' ? 'Fortress name' : form.category === 'dredgion' ? 'Dredgion name' : 'Direction'">
          </div>

          <!-- Siege fields -->
          <template v-if="form.category === 'siege'">
            <div class="grid gap-4 sm:grid-cols-3">
              <div>
                <label class="form-label">{{ $t('schedule.time') }}</label>
                <input v-model="form.metadata.time" type="text"
                  class="form-input"
                  placeholder="20:00">
              </div>
              <div>
                <label class="form-label">{{ $t('schedule.day') }}</label>
                <select v-model.number="form.metadata.day_of_week"
                  class="form-input">
                  <option v-for="(d, i) in dayNames" :key="i" :value="i">{{ d }}</option>
                </select>
              </div>
              <div>
                <label class="form-label">Fortress type</label>
                <select v-model="form.metadata.fortress_type"
                  class="form-input">
                  <option value="divine">Divine</option>
                  <option value="upper">Upper Abyss</option>
                  <option value="lower">Lower Abyss</option>
                </select>
              </div>
            </div>
          </template>

          <!-- Dredgion fields -->
          <template v-if="form.category === 'dredgion'">
            <div>
              <label class="form-label">Level</label>
              <input v-model="form.metadata.level" type="text"
                class="form-input"
                placeholder="Lv. 46-55">
            </div>
            <div>
              <div class="mb-2 flex items-center justify-between">
                <label class="text-[12px] font-medium text-white/30">Time slots</label>
                <button type="button" @click="addSlot"
                  class="rounded-lg bg-white/[0.04] px-2.5 py-1 text-[11px] font-bold text-white/30 transition-colors hover:bg-white/[0.08]">+</button>
              </div>
              <div v-for="(slot, i) in (form.metadata.slots as any[])" :key="i" class="mb-2 flex gap-2">
                <input v-model="slot.days" type="text"
                  class="form-input w-40"
                  placeholder="Mon — Fri">
                <input v-model="slot.time" type="text"
                  class="form-input flex-1"
                  placeholder="10:00 — 02:00">
                <button type="button" @click="removeSlot(i)"
                  class="shrink-0 rounded-lg px-2 text-white/15 transition-colors hover:bg-red-600/10 hover:text-red-400">
                  <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
              </div>
            </div>
          </template>

          <!-- Rift fields -->
          <template v-if="form.category === 'rift'">
            <div class="grid gap-4 sm:grid-cols-2">
              <div>
                <label class="form-label">{{ $t('schedule.time') }}</label>
                <input v-model="form.metadata.time" type="text"
                  class="form-input"
                  placeholder="01:00">
              </div>
              <div>
                <label class="form-label">{{ $t('schedule.direction') }}</label>
                <input v-model="form.metadata.direction" type="text"
                  class="form-input"
                  placeholder="Morheim → Eltnen">
              </div>
            </div>
          </template>
        </section>
      </div>

      <div class="space-y-5">
        <section class="card-panel p-6 space-y-4">
          <div>
            <label class="form-label">{{ $t('admin.sortOrder') }}</label>
            <input v-model.number="form.sort_order" type="number" min="0"
              class="form-input"
              placeholder="0">
          </div>
          <div class="flex items-center gap-3">
            <ToggleSwitch v-model="form.published" />
            <span class="text-[13px] text-white/50">{{ $t('admin.published') }}</span>
          </div>
        </section>

        <AlertMessage :message="successMsg" variant="success" />
        <AlertMessage :message="errorMsg" variant="error" />

        <AppButton type="submit" :loading="saving" :loading-text="$t('common.loading')" block>
          {{ entry ? $t('admin.saveEntry') : $t('admin.createEntry') }}
        </AppButton>

        <button v-if="entry" type="button" @click="handleDelete"
          class="w-full rounded-lg border border-red-500/10 bg-red-600/5 py-2.5 text-[12px] font-bold uppercase tracking-widest text-red-400/60 transition-colors hover:bg-red-600/10 hover:text-red-400">
          {{ $t('admin.deleteEntry') }}
        </button>
      </div>
    </div>
  </form>
</template>

<script setup lang="ts">
interface ScheduleItem {
  id: number
  category: string
  name: string
  metadata: Record<string, unknown>
  sort_order: number
  published: boolean
}

const props = defineProps<{
  entry?: ScheduleItem | null
}>()

const emit = defineEmits<{
  saved: [id: number]
}>()

const { t } = useI18n()
const { $api, fetchCsrfCookie } = useApi()
const router = useRouter()

const dayNames = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
const { submit, loading: saving, successMsg, errorMsg } = useFormSubmit()

const form = reactive({
  category: 'siege',
  name: '',
  metadata: {} as Record<string, unknown>,
  sort_order: 0,
  published: true,
})

function initMetadata(cat: string) {
  if (cat === 'siege') return { time: '', day_of_week: 0, fortress_type: 'lower' }
  if (cat === 'dredgion') return { level: '', slots: [{ days: '', time: '' }] }
  return { time: '', direction: '' }
}

watch(() => form.category, (cat) => {
  if (!props.entry) form.metadata = initMetadata(cat)
})

watch(() => props.entry, (e) => {
  if (!e) return
  form.category = e.category
  form.name = e.name
  form.metadata = { ...e.metadata }
  if (e.metadata.slots) form.metadata.slots = [...(e.metadata.slots as any[])]
  form.sort_order = e.sort_order
  form.published = e.published
}, { immediate: true })

if (!props.entry) form.metadata = initMetadata(form.category)

function addSlot() {
  if (!form.metadata.slots) form.metadata.slots = []
  ;(form.metadata.slots as any[]).push({ days: '', time: '' })
}

function removeSlot(i: number) {
  ;(form.metadata.slots as any[]).splice(i, 1)
}

async function handleSubmit() {
  const payload = {
    category: form.category,
    name: form.name,
    metadata: form.metadata,
    sort_order: form.sort_order,
    published: form.published,
  }

  await submit(async (api) => {
    if (props.entry) {
      const res = await api<{ data: ScheduleItem; message: string }>(`/admin/schedule/${props.entry.id}`, { method: 'PUT', body: payload })
      emit('saved', res.data.id)
      return res.message || t('admin.scheduleSaved')
    }
    const res = await api<{ data: ScheduleItem; message: string }>('/admin/schedule', { method: 'POST', body: payload })
    emit('saved', res.data.id)
    return res.message || t('admin.scheduleCreated')
  }, t('admin.scheduleFailed'))
}

async function handleDelete() {
  if (!props.entry || !confirm(t('admin.scheduleDeleteConfirm'))) return
  try {
    await fetchCsrfCookie()
    await $api(`/admin/schedule/${props.entry.id}`, { method: 'DELETE' })
    router.push('/admin/schedule')
  } catch (e: unknown) {
    const err = e as { data?: { message?: string } }
    errorMsg.value = err.data?.message || t('admin.scheduleFailed')
  }
}
</script>
