<template>
  <div>
    <PageHeader :title="$t('admin.manageUsers')" :subtitle="$t('admin.manageUsersDesc')" />

    <div class="mb-5">
      <SearchInput v-model="search" :placeholder="$t('admin.searchUsers')" class="sm:w-72" />
    </div>

    <div v-if="status === 'pending'" class="space-y-2">
      <div v-for="i in 5" :key="i" class="h-16 animate-pulse rounded-xl bg-white/[0.02]" />
    </div>

    <template v-else>
      <DataTable :columns="columns" :has-rows="!!users.length" :empty-text="$t('admin.noUsersFound')">
        <NuxtLink v-for="u in users" :key="u.id" :to="`/admin/users/${u.id}`"
          class="table-row border-b border-white/[0.04] last:border-0 transition-colors hover:bg-white/[0.015]">
          <td class="px-5 py-3.5 text-[13px] font-semibold text-white/70">{{ u.name }}</td>
          <td class="px-5 py-3.5 text-[13px] text-white/40">{{ u.email }}</td>
          <td class="px-5 py-3.5">
            <span v-for="role in u.roles" :key="role"
              :class="['mr-1 rounded px-1.5 py-0.5 text-[10px] font-medium uppercase tracking-wider',
                role === 'super-admin' ? 'bg-red-500/10 text-red-400'
                  : role === 'admin' ? 'bg-sky-500/10 text-sky-400'
                  : role === 'content-manager' ? 'bg-gold-500/10 text-gold-400'
                  : 'bg-white/[0.04] text-white/25']">
              {{ role }}
            </span>
          </td>
          <td class="px-5 py-3.5 text-right text-[12px] text-white/20">{{ formatDate(u.created_at) }}</td>
        </NuxtLink>
      </DataTable>
    </template>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

interface UserItem { id: number; name: string; email: string; roles: string[]; created_at: string }

const { t } = useI18n()
const { $api } = useApi()
const { relative: formatDate } = useDate()

const search = ref('')

const columns = computed(() => [
  { key: 'name', label: t('admin.userName') },
  { key: 'email', label: t('common.email') },
  { key: 'roles', label: t('admin.role') },
  { key: 'created_at', label: t('admin.registered'), align: 'right' as const, sortable: true },
])

const queryParams = computed(() => {
  const params = new URLSearchParams()
  if (search.value) params.set('filter[name]', search.value)
  return params.toString()
})

const { data: usersData, status } = useAsyncData(
  'admin-users',
  () => $api<{ data: UserItem[] }>(`/admin/users${queryParams.value ? `?${queryParams.value}` : ''}`),
  { watch: [queryParams] },
)

const users = computed(() => usersData.value?.data ?? [])
</script>
