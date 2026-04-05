<template>
  <footer class="relative overflow-hidden border-t border-white/[0.04] bg-[#08070a]">
    <!-- Atmospheric bg -->
    <div class="absolute inset-0 bg-[url('/img/bg_waterfall.jpg')] bg-cover bg-center opacity-[0.02]" />

    <div class="relative mx-auto max-w-[1280px] px-6">
      <!-- Main grid -->
      <div class="grid gap-12 py-16 md:grid-cols-12">

        <!-- Brand column -->
        <div class="md:col-span-4">
          <NuxtLink :to="localePath('/')" class="group inline-flex items-center gap-2.5">
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-600/15 ring-1 ring-red-500/20">
              <svg class="h-4 w-4 text-red-500" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <span class="font-display text-xl font-extrabold tracking-tight text-white">AION<span class="text-red-500">UCP</span></span>
          </NuxtLink>
          <p class="mt-4 max-w-[260px] text-[13px] leading-relaxed text-white/20">
            {{ t('footer.desc') }}
          </p>
          <!-- Social -->
          <div class="mt-6 flex gap-2">
            <a href="#" class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/[0.03] text-white/25 ring-1 ring-white/[0.04] transition-all duration-300 hover:bg-[#5865F2]/15 hover:text-[#5865F2] hover:ring-[#5865F2]/20">
              <svg class="h-4 w-4" viewBox="0 0 127.14 96.36" fill="currentColor"><path d="M107.7,8.07A105.15,105.15,0,0,0,81.47,0a72.06,72.06,0,0,0-3.36,6.83A97.68,97.68,0,0,0,49,6.83,72.37,72.37,0,0,0,45.64,0,105.89,105.89,0,0,0,19.39,8.09C2.79,32.65-1.71,56.6.54,80.21h0A105.73,105.73,0,0,0,32.71,96.36,77.7,77.7,0,0,0,39.6,85.25a68.42,68.42,0,0,1-10.85-5.18c.91-.66,1.8-1.34,2.66-2a75.57,75.57,0,0,0,64.32,0c.87.71,1.76,1.39,2.66,2a68.68,68.68,0,0,1-10.87,5.19,77,77,0,0,0,6.89,11.1A105.25,105.25,0,0,0,126.6,80.22h0C129.24,52.84,122.09,29.11,107.7,8.07ZM42.45,65.69C36.18,65.69,31,60,31,53s5-12.74,11.43-12.74S54,46,53.89,53,48.84,65.69,42.45,65.69Zm42.24,0C78.41,65.69,73.25,60,73.25,53s5-12.74,11.44-12.74S96.23,46,96.12,53,91.08,65.69,84.69,65.69Z"/></svg>
            </a>
            <a href="#" class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/[0.03] text-white/25 ring-1 ring-white/[0.04] transition-all duration-300 hover:bg-white/[0.06] hover:text-white/50 hover:ring-white/[0.08]">
              <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.009-.866-.013-1.7-2.782.603-3.369-1.342-3.369-1.342-.454-1.155-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.202 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C19.138 20.161 22 16.416 22 12c0-5.523-4.477-10-10-10z"/></svg>
            </a>
          </div>
        </div>

        <!-- Link columns -->
        <div class="grid grid-cols-2 gap-8 sm:grid-cols-3 md:col-span-8">
          <div>
            <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/10">{{ t('footer.server') }}</span>
            <div class="mt-4 flex flex-col gap-2.5">
              <NuxtLink :to="localePath('/start')" class="text-[13px] text-white/25 transition-colors duration-200 hover:text-white/60">{{ t('footer.startPlaying') }}</NuxtLink>
              <NuxtLink :to="localePath('/news')" class="text-[13px] text-white/25 transition-colors duration-200 hover:text-white/60">{{ t('footer.news') }}</NuxtLink>
              <NuxtLink :to="localePath('/rankings')" class="text-[13px] text-white/25 transition-colors duration-200 hover:text-white/60">{{ t('footer.rankings') }}</NuxtLink>
              <NuxtLink :to="localePath('/schedule')" class="text-[13px] text-white/25 transition-colors duration-200 hover:text-white/60">{{ t('footer.schedule') }}</NuxtLink>
            </div>
          </div>
          <div>
            <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/10">{{ t('footer.info') }}</span>
            <div class="mt-4 flex flex-col gap-2.5">
              <NuxtLink :to="localePath('/wiki')" class="text-[13px] text-white/25 transition-colors duration-200 hover:text-white/60">Wiki</NuxtLink>
              <a href="#" class="text-[13px] text-white/25 transition-colors duration-200 hover:text-white/60">Discord</a>
              <a href="#" class="text-[13px] text-white/25 transition-colors duration-200 hover:text-white/60">{{ t('footer.forum') }}</a>
            </div>
          </div>
          <div>
            <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/10">{{ t('footer.legal') }}</span>
            <div class="mt-4 flex flex-col gap-2.5">
              <NuxtLink :to="localePath('/terms')" class="text-[13px] text-white/25 transition-colors duration-200 hover:text-white/60">{{ t('footer.terms') }}</NuxtLink>
              <NuxtLink :to="localePath('/privacy')" class="text-[13px] text-white/25 transition-colors duration-200 hover:text-white/60">{{ t('footer.privacy') }}</NuxtLink>
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom bar -->
      <div class="flex flex-col items-center justify-between gap-3 border-t border-white/[0.03] py-6 sm:flex-row">
        <p class="text-[11px] text-white/10">NCSOFT, Aion — registered trademarks of NCSOFT Corporation.</p>
        <p class="text-[11px] text-white/10">&copy; {{ new Date().getFullYear() }} AionUCP</p>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
const { t } = useI18n()
const localePath = useLocalePath()
</script>
