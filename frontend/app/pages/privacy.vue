<template>
  <div class="text-white">
    <div class="relative overflow-hidden pt-28 pb-12">
      <div class="absolute inset-0 bg-[url('/img/bg_waterfall.jpg')] bg-cover bg-center opacity-[0.04]" />
      <div class="absolute inset-0 bg-gradient-to-b from-surface via-transparent to-surface" />
      <div class="relative mx-auto max-w-[760px] px-6">
        <h1 class="font-display text-5xl font-extrabold uppercase tracking-tighter">{{ t('privacy.title') }}</h1>
        <p class="mt-3 text-[14px] text-white/30">{{ t('privacy.updated') }}</p>
      </div>
    </div>

    <article class="mx-auto max-w-[760px] px-6 pb-24">
      <div class="prose-article">
        <h2>{{ t('privacy.collectTitle') }}</h2>
        <p>{{ t('privacy.collectIntro') }}</p>
        <ul>
          <li v-for="i in 5" :key="i">{{ t(`privacy.c${i}`) }}</li>
        </ul>

        <h2>{{ t('privacy.usageTitle') }}</h2>
        <ul>
          <li v-for="i in 4" :key="i">{{ t(`privacy.u${i}`) }}</li>
        </ul>

        <h2>{{ t('privacy.storageTitle') }}</h2>
        <p>{{ t('privacy.storageText') }}</p>

        <h2>{{ t('privacy.sharingTitle') }}</h2>
        <p>{{ t('privacy.sharingText') }}</p>

        <h2>Cookies</h2>
        <p>{{ t('privacy.cookiesText') }}</p>

        <h2>{{ t('privacy.rightsTitle') }}</h2>
        <ul>
          <li v-for="i in 3" :key="i">{{ t(`privacy.ri${i}`) }}</li>
        </ul>

        <h2>{{ t('privacy.contactTitle') }}</h2>
        <p>{{ t('privacy.contactText') }}</p>
      </div>
    </article>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'default' })
const { t } = useI18n()
</script>
