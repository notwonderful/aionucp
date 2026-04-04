<template>
  <div>
    <div class="mb-8">
      <h1 class="font-display text-2xl font-extrabold uppercase tracking-tight lg:text-3xl">{{ $t('admin.title') }}</h1>
      <p class="mt-1 text-[13px] text-white/25">{{ $t('admin.subtitle') }}</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      <NuxtLink to="/admin/tickets"
        class="group flex items-center gap-4 rounded-xl border border-white/[0.04] bg-white/[0.02] p-5 transition-all duration-300 hover:border-white/[0.08] hover:bg-white/[0.03]">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-500/10">
          <svg class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" /></svg>
        </div>
        <div>
          <div class="text-[15px] font-semibold transition-colors group-hover:text-emerald-400">{{ $t('admin.tickets') }}</div>
          <div class="mt-0.5 text-[12px] text-white/20">{{ $t('admin.ticketsDesc') }}</div>
        </div>
      </NuxtLink>

      <NuxtLink to="/admin/users"
        class="group flex items-center gap-4 rounded-xl border border-white/[0.04] bg-white/[0.02] p-5 transition-all duration-300 hover:border-white/[0.08] hover:bg-white/[0.03]">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-500/10">
          <svg class="h-6 w-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" /></svg>
        </div>
        <div>
          <div class="text-[15px] font-semibold transition-colors group-hover:text-sky-400">{{ $t('admin.users') }}</div>
          <div class="mt-0.5 text-[12px] text-white/20">{{ $t('admin.usersDesc') }}</div>
        </div>
      </NuxtLink>

      <NuxtLink to="/admin/products"
        class="group flex items-center gap-4 rounded-xl border border-white/[0.04] bg-white/[0.02] p-5 transition-all duration-300 hover:border-white/[0.08] hover:bg-white/[0.03]">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-600/10">
          <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72" /></svg>
        </div>
        <div>
          <div class="text-[15px] font-semibold transition-colors group-hover:text-red-400">{{ $t('admin.products') }}</div>
          <div class="mt-0.5 text-[12px] text-white/20">{{ $t('admin.productsDesc') }}</div>
        </div>
      </NuxtLink>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'dashboard', middleware: 'admin' })
</script>
