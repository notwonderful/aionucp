<template>
  <div>
    <NuxtLink to="/admin/schedule" class="inline-flex items-center gap-2 text-[13px] font-medium text-white/25 transition-colors hover:text-white/50">
      <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
      {{ $t('admin.backToSchedule') }}
    </NuxtLink>

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
