<template>
  <div>
    <PageHeader :title="$t('admin.manageUsers')" :subtitle="$t('admin.manageUsersDesc')" />

    <div class="mb-5">
      <SearchInput v-model="search" :placeholder="$t('admin.searchUsers')" class="sm:w-72" />
    </div>

    <SkeletonLoader v-if="status === 'pending'" height="h-16" />

    <template v-else>
      <DataTable :columns="columns" :has-rows="!!users.length" :empty-text="$t('admin.noUsersFound')">
        <NuxtLink v-for="u in users" :key="u.id" :to="`/admin/users/${u.id}`"
          class="table-row border-b border-white/[0.04] last:border-0 transition-colors hover:bg-white/[0.015]">
          <td class="px-5 py-3.5 text-[13px] font-semibold text-white/70">{{ u.name }}</td>
          <td class="px-5 py-3.5 text-[13px] text-white/40">{{ u.email }}</td>
          <td class="px-5 py-3.5">
            <StatusBadge v-for="role in u.roles" :key="role" class="mr-1"
              :color="role === 'super-admin' ? 'red' : role === 'admin' ? 'sky' : role === 'content-manager' ? 'gold' : 'muted'"
              :label="role" />
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
