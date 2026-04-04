<template>
  <div class="flex min-h-[100dvh] bg-surface font-body text-white">
    <!-- Left — form side -->
    <div class="flex flex-1 flex-col justify-between px-6 py-8 sm:px-12 lg:px-20">
      <!-- Top: logo -->
      <NuxtLink to="/" class="group inline-flex items-center gap-2.5 self-start">
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-600/15 ring-1 ring-red-500/20 transition-all duration-300 group-hover:bg-red-600/25">
          <svg class="h-3.5 w-3.5 text-red-500" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        </div>
        <span class="font-display text-lg font-extrabold tracking-tight">AION<span class="text-red-500">UCP</span></span>
      </NuxtLink>

      <!-- Middle: form content -->
      <div class="mx-auto w-full max-w-[400px] py-12">
        <slot />
      </div>

      <!-- Bottom: footer -->
      <div class="flex items-center justify-between text-[11px] text-white/15">
        <span>&copy; {{ new Date().getFullYear() }} AionUCP</span>
        <div class="flex gap-4">
          <NuxtLink to="/terms" class="transition-colors hover:text-white/30">Terms</NuxtLink>
          <NuxtLink to="/privacy" class="transition-colors hover:text-white/30">Privacy</NuxtLink>
        </div>
      </div>
    </div>

    <!-- Right — image side (hidden on mobile) -->
    <div class="relative hidden w-[45%] overflow-hidden lg:block xl:w-[50%]">
      <div class="absolute inset-0 bg-[url('/img/bg_waterfall.jpg')] bg-cover bg-center" />
      <div class="absolute inset-0 bg-gradient-to-r from-surface to-transparent" />
      <div class="absolute inset-0 bg-surface/30" />

      <!-- Decorative content on image -->
      <div class="absolute bottom-12 left-12 right-12">
        <div class="font-display text-[13px] font-bold uppercase tracking-[0.3em] text-white/30">Classic 3.9</div>
        <div class="mt-2 font-display text-3xl font-extrabold uppercase tracking-tight">
          The tower<br>of <span class="text-red-500">eternity</span>
        </div>
        <p class="mt-3 max-w-xs text-[13px] leading-relaxed text-white/30">
          Dedicated EU servers. No pay-to-win. The Aion experience as it was meant to be.
        </p>
      </div>
    </div>
  </div>
</template>
