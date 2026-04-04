<template>
  <div class="text-white">
    <div class="relative overflow-hidden pt-28 pb-12">
      <div class="absolute inset-0 bg-[url('/img/bg_waterfall.jpg')] bg-cover bg-center opacity-[0.04]" />
      <div class="absolute inset-0 bg-gradient-to-b from-surface via-transparent to-surface" />
      <div class="relative mx-auto max-w-[760px] px-6">
        <h1 class="font-display text-5xl font-extrabold uppercase tracking-tighter">{{ lang === 'ru' ? 'Конфиденциальность' : 'Privacy Policy' }}</h1>
        <p class="mt-3 text-[14px] text-white/30">{{ lang === 'ru' ? 'Последнее обновление: 1 апреля 2026' : 'Last updated: April 1, 2026' }}</p>
      </div>
    </div>

    <article class="mx-auto max-w-[760px] px-6 pb-24">
      <div class="prose-article">
        <h2>{{ lang === 'ru' ? 'Какие данные мы собираем' : 'What data we collect' }}</h2>
        <p>{{ lang === 'ru' ? 'При регистрации и использовании сервиса мы собираем:' : 'When you register and use the service, we collect:' }}</p>
        <ul>
          <li v-for="item in dataCollected" :key="item">{{ item }}</li>
        </ul>

        <h2>{{ lang === 'ru' ? 'Как мы используем данные' : 'How we use the data' }}</h2>
        <ul>
          <li v-for="item in dataUsage" :key="item">{{ item }}</li>
        </ul>

        <h2>{{ lang === 'ru' ? 'Хранение и безопасность' : 'Storage and security' }}</h2>
        <p>{{ lang === 'ru'
          ? 'Пароли хранятся в виде SHA-1 хешей (требование игрового клиента). Мы рекомендуем использовать уникальный пароль, не совпадающий с паролями на других сервисах. Данные хранятся на выделенных серверах в Германии.'
          : 'Passwords are stored as SHA-1 hashes (game client requirement). We recommend using a unique password not shared with other services. Data is stored on dedicated servers in Germany.' }}</p>

        <h2>{{ lang === 'ru' ? 'Передача данных третьим лицам' : 'Third-party data sharing' }}</h2>
        <p>{{ lang === 'ru'
          ? 'Мы не продаём, не передаём и не предоставляем доступ к вашим данным третьим лицам. Исключение — требования правоохранительных органов в соответствии с законодательством.'
          : 'We do not sell, share, or provide access to your data to third parties. Exception: law enforcement requests in accordance with applicable law.' }}</p>

        <h2>Cookies</h2>
        <p>{{ lang === 'ru'
          ? 'Мы используем session cookies для авторизации и CSRF-защиты. Аналитические cookies не используются. Сторонние трекеры отсутствуют.'
          : 'We use session cookies for authentication and CSRF protection. No analytics cookies are used. No third-party trackers.' }}</p>

        <h2>{{ lang === 'ru' ? 'Ваши права' : 'Your rights' }}</h2>
        <ul>
          <li v-for="item in userRights" :key="item">{{ item }}</li>
        </ul>

        <h2>{{ lang === 'ru' ? 'Контакт' : 'Contact' }}</h2>
        <p>{{ lang === 'ru'
          ? 'По вопросам конфиденциальности обращайтесь через Discord или на email администрации.'
          : 'For privacy inquiries, contact us via Discord or administration email.' }}</p>
      </div>
    </article>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'default' })
const { lang } = useLang()

const dataCollected = computed(() => lang.value === 'ru' ? [
  'Email-адрес (для регистрации и восстановления пароля)',
  'Имя пользователя (игровое имя аккаунта)',
  'IP-адрес последнего входа (для безопасности)',
  'Хеш пароля (SHA-1)',
  'Игровая активность (персонажи, предметы, статистика — хранятся в игровой БД)',
] : [
  'Email address (for registration and password recovery)',
  'Username (game account name)',
  'Last login IP address (for security)',
  'Password hash (SHA-1)',
  'Game activity (characters, items, statistics — stored in game database)',
])

const dataUsage = computed(() => lang.value === 'ru' ? [
  'Авторизация и управление аккаунтом',
  'Восстановление пароля',
  'Защита от мошенничества и мультиаккаунтинга',
  'Отображение игровой статистики и рейтингов',
] : [
  'Authentication and account management',
  'Password recovery',
  'Fraud prevention and multi-accounting detection',
  'Displaying game statistics and rankings',
])

const userRights = computed(() => lang.value === 'ru' ? [
  'Запрос на удаление аккаунта и всех связанных данных',
  'Запрос на экспорт ваших данных',
  'Изменение email и пароля в личном кабинете',
] : [
  'Request deletion of your account and all associated data',
  'Request export of your data',
  'Change email and password in your dashboard',
])
</script>
