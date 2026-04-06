<template>
  <div>
    <BackLink to="/admin/schedule" :label="$t('admin.backToSchedule')" />

    <h1 class="mt-4 font-display text-2xl font-extrabold uppercase tracking-tight">{{ $t('admin.createEntry') }}</h1>

    <ScheduleForm class="mt-6" @saved="handleSaved" />
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })

const router = useRouter()

function handleSaved(id: number) {
  router.push(`/admin/schedule/${id}`)
}
</script>
