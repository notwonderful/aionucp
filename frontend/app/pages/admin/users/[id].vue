<template>
  <div>
    <BackLink to="/admin/users" :label="$t('admin.backToUsers')" />

    <div v-if="!userData" class="mt-8">
      <EmptyState :title="$t('admin.userNotFound')" />
    </div>

    <template v-else>
      <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <section class="card-panel">
          <div class="border-b border-white/[0.04] px-6 py-4">
            <h2 class="font-display text-[15px] font-bold uppercase tracking-wider">{{ $t('admin.userInfo') }}</h2>
          </div>
          <div class="space-y-4 px-6 py-5">
            <div class="flex items-center justify-between">
              <span class="text-[12px] text-white/30">ID</span>
              <span class="text-[13px] tabular-nums text-white/50">{{ userData.id }}</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-[12px] text-white/30">{{ $t('admin.userName') }}</span>
              <span class="text-[13px] font-medium text-white/70">{{ userData.name }}</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-[12px] text-white/30">{{ $t('common.email') }}</span>
              <span class="text-[13px] text-white/50">{{ userData.email }}</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-[12px] text-white/30">{{ $t('admin.emailVerified') }}</span>
              <span v-if="userData.email_verified_at" class="text-[12px] text-emerald-400">{{ formatDate(userData.email_verified_at) }}</span>
              <span v-else class="text-[12px] text-white/20">—</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-[12px] text-white/30">{{ $t('admin.registered') }}</span>
              <span class="text-[13px] text-white/40">{{ formatDate(userData.created_at) }}</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-[12px] text-white/30">{{ $t('admin.currentRole') }}</span>
              <span :class="['rounded px-2 py-0.5 text-[10px] font-medium uppercase tracking-wider',
                currentRole === 'super-admin' ? 'bg-red-500/10 text-red-400'
                  : currentRole === 'admin' ? 'bg-sky-500/10 text-sky-400'
                  : currentRole === 'content-manager' ? 'bg-gold-500/10 text-gold-400'
                  : 'bg-white/[0.04] text-white/25']">
                {{ currentRole }}
              </span>
            </div>
          </div>
        </section>

        <section class="card-panel">
          <div class="border-b border-white/[0.04] px-6 py-4">
            <h2 class="font-display text-[15px] font-bold uppercase tracking-wider">{{ $t('admin.changeRole') }}</h2>
          </div>
          <div class="space-y-3 px-6 py-5">
            <button
              v-for="role in roles" :key="role.value"
              @click="selectedRole = role.value"
              :class="['flex w-full items-center justify-between rounded-lg border p-4 text-left transition-all duration-300',
                selectedRole === role.value
                  ? 'border-red-500/30 bg-red-600/5'
                  : 'border-white/[0.04] bg-white/[0.02] hover:border-white/[0.08] hover:bg-white/[0.03]']"
            >
              <div>
                <div class="text-[14px] font-semibold" :class="selectedRole === role.value ? 'text-red-400' : 'text-white/60'">{{ role.label }}</div>
                <div class="mt-0.5 text-[12px] text-white/20">{{ role.value }}</div>
              </div>
              <div v-if="selectedRole === role.value" class="flex h-5 w-5 items-center justify-center rounded-full bg-red-500">
                <svg class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
              </div>
            </button>

            <AlertMessage :message="successMsg" variant="success" />
            <AlertMessage :message="errorMsg" variant="error" />

            <AppButton
              :loading="saving"
              :loading-text="$t('common.loading')"
              :disabled="selectedRole === currentRole"
              @click="handleAssignRole"
            >
              {{ $t('admin.saveRole') }}
            </AppButton>
          </div>
        </section>
      </div>
    </template>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

interface UserDetail { id: number; name: string; email: string; roles: string[]; permissions: string[]; email_verified_at: string | null; created_at: string }
interface RoleItem { value: string; label: string }

const route = useRoute()
const { t } = useI18n()
const { $api, fetchCsrfCookie } = useApi()
const { full: formatDate } = useDate()

const userData = ref<UserDetail | null>(null)
const roles = ref<RoleItem[]>([])
const selectedRole = ref('')
const { submit, loading: saving, successMsg, errorMsg } = useFormSubmit()

const currentRole = computed(() => userData.value?.roles?.[0] ?? 'member')

async function fetchData() {
  try {
    const [userRes, rolesRes] = await Promise.all([
      $api<{ data: UserDetail }>(`/admin/users/${route.params.id}`),
      $api<{ data: RoleItem[] }>('/admin/roles'),
    ])
    userData.value = userRes.data
    roles.value = rolesRes.data
    selectedRole.value = currentRole.value
  } catch { /* */ }
}

fetchData()

async function handleAssignRole() {
  if (!userData.value || selectedRole.value === currentRole.value) return
  await submit(async (api) => {
    const res = await api<{ data: UserDetail; message: string }>(`/admin/users/${userData.value!.id}/role`, {
      method: 'PUT',
      body: { role: selectedRole.value },
    })
    userData.value = res.data
    selectedRole.value = res.data.roles?.[0] ?? 'member'
    return res.message || t('admin.roleUpdated')
  }, t('admin.roleFailed'))
}
</script>
