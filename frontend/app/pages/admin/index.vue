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

      <NuxtLink to="/admin/news"
        class="group flex items-center gap-4 rounded-xl border border-white/[0.04] bg-white/[0.02] p-5 transition-all duration-300 hover:border-white/[0.08] hover:bg-white/[0.03]">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/10">
          <svg class="h-6 w-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" /></svg>
        </div>
        <div>
          <div class="text-[15px] font-semibold transition-colors group-hover:text-amber-400">{{ $t('admin.news') }}</div>
          <div class="mt-0.5 text-[12px] text-white/20">{{ $t('admin.newsDesc') }}</div>
        </div>
      </NuxtLink>

      <NuxtLink to="/admin/faq"
        class="group flex items-center gap-4 rounded-xl border border-white/[0.04] bg-white/[0.02] p-5 transition-all duration-300 hover:border-white/[0.08] hover:bg-white/[0.03]">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-500/10">
          <svg class="h-6 w-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" /></svg>
        </div>
        <div>
          <div class="text-[15px] font-semibold transition-colors group-hover:text-purple-400">{{ $t('admin.faq') }}</div>
          <div class="mt-0.5 text-[12px] text-white/20">{{ $t('admin.faqDesc') }}</div>
        </div>
      </NuxtLink>

      <NuxtLink to="/admin/wiki"
        class="group flex items-center gap-4 rounded-xl border border-white/[0.04] bg-white/[0.02] p-5 transition-all duration-300 hover:border-white/[0.08] hover:bg-white/[0.03]">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-500/10">
          <svg class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
        </div>
        <div>
          <div class="text-[15px] font-semibold transition-colors group-hover:text-indigo-400">{{ $t('admin.wiki') }}</div>
          <div class="mt-0.5 text-[12px] text-white/20">{{ $t('admin.wikiDesc') }}</div>
        </div>
      </NuxtLink>

      <NuxtLink to="/admin/schedule"
        class="group flex items-center gap-4 rounded-xl border border-white/[0.04] bg-white/[0.02] p-5 transition-all duration-300 hover:border-white/[0.08] hover:bg-white/[0.03]">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-500/10">
          <svg class="h-6 w-6 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
        </div>
        <div>
          <div class="text-[15px] font-semibold transition-colors group-hover:text-cyan-400">{{ $t('admin.schedule') }}</div>
          <div class="mt-0.5 text-[12px] text-white/20">{{ $t('admin.scheduleDesc') }}</div>
        </div>
      </NuxtLink>

      <NuxtLink to="/admin/settings"
        class="group flex items-center gap-4 rounded-xl border border-white/[0.04] bg-white/[0.02] p-5 transition-all duration-300 hover:border-white/[0.08] hover:bg-white/[0.03]">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-zinc-500/10">
          <svg class="h-6 w-6 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 010-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
        </div>
        <div>
          <div class="text-[15px] font-semibold transition-colors group-hover:text-zinc-400">{{ $t('admin.settings') }}</div>
          <div class="mt-0.5 text-[12px] text-white/20">{{ $t('admin.settingsDesc') }}</div>
        </div>
      </NuxtLink>

      <NuxtLink to="/admin/settings/payments"
        class="group flex items-center gap-4 rounded-xl border border-white/[0.04] bg-white/[0.02] p-5 transition-all duration-300 hover:border-white/[0.08] hover:bg-white/[0.03]">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-500/10">
          <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" /></svg>
        </div>
        <div>
          <div class="text-[15px] font-semibold transition-colors group-hover:text-green-400">{{ $t('admin.paymentSettings') }}</div>
          <div class="mt-0.5 text-[12px] text-white/20">{{ $t('admin.paymentSettingsDesc') }}</div>
        </div>
      </NuxtLink>

      <NuxtLink to="/admin/mail-items"
        class="group flex items-center gap-4 rounded-xl border border-white/[0.04] bg-white/[0.02] p-5 transition-all duration-300 hover:border-white/[0.08] hover:bg-white/[0.03]">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/10">
          <svg class="h-6 w-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
        </div>
        <div>
          <div class="text-[15px] font-semibold transition-colors group-hover:text-amber-400">{{ $t('admin.sendItem') }}</div>
          <div class="mt-0.5 text-[12px] text-white/20">{{ $t('admin.sendItemDesc') }}</div>
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
