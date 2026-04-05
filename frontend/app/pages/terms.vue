<template>
  <div class="text-white">
    <div class="relative overflow-hidden pt-28 pb-12">
      <div class="absolute inset-0 bg-[url('/img/bg_waterfall.jpg')] bg-cover bg-center opacity-[0.04]" />
      <div class="absolute inset-0 bg-gradient-to-b from-surface via-transparent to-surface" />
      <div class="relative mx-auto max-w-[760px] px-6">
        <h1 class="font-display text-5xl font-extrabold uppercase tracking-tighter">{{ t('terms.title') }}</h1>
        <p class="mt-3 text-[14px] text-white/30">{{ t('terms.updated') }}</p>
      </div>
    </div>

    <article class="mx-auto max-w-[760px] px-6 pb-24">
      <div class="prose-article">
        <h2>1. {{ t('terms.s1title') }}</h2>
        <p>{{ t('terms.s1text') }}</p>

        <h2>2. {{ t('terms.s2title') }}</h2>
        <p>{{ t('terms.s2text') }}</p>

        <h2>3. {{ t('terms.s3title') }}</h2>
        <ul>
          <li v-for="i in 7" :key="i">{{ t(`terms.r${i}`) }}</li>
        </ul>

        <h2>4. {{ t('terms.s4title') }}</h2>
        <p>{{ t('terms.s4text') }}</p>

        <h2>5. {{ t('terms.s5title') }}</h2>
        <p>{{ t('terms.s5text') }}</p>

        <h2>6. {{ t('terms.s6title') }}</h2>
        <p>{{ t('terms.s6text') }}</p>

        <h2>7. {{ t('terms.s7title') }}</h2>
        <p>{{ t('terms.s7text') }}</p>
      </div>
    </article>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'default' })
const { t } = useI18n()
</script>
