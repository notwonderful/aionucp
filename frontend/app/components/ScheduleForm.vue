<template>
  <AdminFormLayout
    :item="entry" :saving="saving" :success-msg="successMsg" :error-msg="errorMsg"
    :save-label="$t('admin.saveEntry')" :create-label="$t('admin.createEntry')" :delete-label="$t('admin.deleteEntry')"
    @submit="onSubmit" @delete="onDelete">
    <template #main>
      <section class="card-panel p-6 space-y-4">
        <div>
          <label class="form-label">{{ $t('admin.categoryLabel') }}</label>
          <select v-model="form.category" :disabled="!!entry" class="form-input disabled:opacity-40">
            <option value="siege">Siege</option>
            <option value="dredgion">Dredgion</option>
            <option value="rift">Rift</option>
          </select>
        </div>

        <div>
          <label class="form-label">{{ $t('admin.entryName') }}</label>
          <input v-model="form.name" type="text" class="form-input"
            :placeholder="form.category === 'siege' ? 'Fortress name' : form.category === 'dredgion' ? 'Dredgion name' : 'Direction'">
        </div>

        <template v-if="form.category === 'siege'">
          <div class="grid gap-4 sm:grid-cols-3">
            <div>
              <label class="form-label">{{ $t('schedule.time') }}</label>
              <input v-model="form.metadata.time" type="text" class="form-input" placeholder="20:00">
            </div>
            <div>
              <label class="form-label">{{ $t('schedule.day') }}</label>
              <select v-model.number="form.metadata.day_of_week" class="form-input">
                <option v-for="(d, i) in dayNames" :key="i" :value="i">{{ d }}</option>
              </select>
            </div>
            <div>
              <label class="form-label">Fortress type</label>
              <select v-model="form.metadata.fortress_type" class="form-input">
                <option value="divine">Divine</option>
                <option value="upper">Upper Abyss</option>
                <option value="lower">Lower Abyss</option>
              </select>
            </div>
          </div>
        </template>

        <template v-if="form.category === 'dredgion'">
          <div>
            <label class="form-label">Level</label>
            <input v-model="form.metadata.level" type="text" class="form-input" placeholder="Lv. 46-55">
          </div>
          <div>
            <div class="mb-2 flex items-center justify-between">
              <label class="text-[12px] font-medium text-white/30">Time slots</label>
              <button type="button" @click="addSlot"
                class="rounded-lg bg-white/[0.04] px-2.5 py-1 text-[11px] font-bold text-white/30 transition-colors hover:bg-white/[0.08]">+</button>
            </div>
            <div v-for="(slot, i) in (form.metadata.slots as any[])" :key="i" class="mb-2 flex gap-2">
              <input v-model="slot.days" type="text" class="form-input w-40" placeholder="Mon — Fri">
              <input v-model="slot.time" type="text" class="form-input flex-1" placeholder="10:00 — 02:00">
              <button type="button" @click="removeSlot(i)"
                class="shrink-0 rounded-lg px-2 text-white/15 transition-colors hover:bg-red-600/10 hover:text-red-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
              </button>
            </div>
          </div>
        </template>

        <template v-if="form.category === 'rift'">
          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="form-label">{{ $t('schedule.time') }}</label>
              <input v-model="form.metadata.time" type="text" class="form-input" placeholder="01:00">
            </div>
            <div>
              <label class="form-label">{{ $t('schedule.direction') }}</label>
              <input v-model="form.metadata.direction" type="text" class="form-input" placeholder="Morheim → Eltnen">
            </div>
          </div>
        </template>
      </section>
    </template>

    <template #sidebar>
      <section class="card-panel p-6 space-y-4">
        <div>
          <label class="form-label">{{ $t('admin.sortOrder') }}</label>
          <input v-model.number="form.sort_order" type="number" min="0" class="form-input" placeholder="0">
        </div>
        <div class="flex items-center gap-3">
          <ToggleSwitch v-model="form.published" />
          <span class="text-[13px] text-white/50">{{ $t('admin.published') }}</span>
        </div>
      </section>
    </template>
  </AdminFormLayout>
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

const props = defineProps<{ entry?: ScheduleItem | null }>()
const emit = defineEmits<{ saved: [id: number] }>()

const { t } = useI18n()

const dayNames = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']

const { handleSubmit, handleDelete, saving, successMsg, errorMsg } = useAdminForm<ScheduleItem>({
  endpoint: '/admin/schedule',
  redirectTo: '/admin/schedule',
  i18n: { saved: t('admin.scheduleSaved'), created: t('admin.scheduleCreated'), failed: t('admin.scheduleFailed'), deleteConfirm: t('admin.scheduleDeleteConfirm') },
})

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

async function onSubmit() {
  const payload = {
    category: form.category,
    name: form.name,
    metadata: form.metadata,
    sort_order: form.sort_order,
    published: form.published,
  }
  await handleSubmit(props.entry, payload, id => emit('saved', id))
}

function onDelete() {
  handleDelete(props.entry)
}
</script>
