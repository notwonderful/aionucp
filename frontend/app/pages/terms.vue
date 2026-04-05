<template>
  <div class="text-white">
    <div class="relative overflow-hidden pt-28 pb-12">
      <div class="absolute inset-0 bg-[url('/img/bg_waterfall.jpg')] bg-cover bg-center opacity-[0.04]" />
      <div class="absolute inset-0 bg-gradient-to-b from-surface via-transparent to-surface" />
      <div class="relative mx-auto max-w-[760px] px-6">
        <h1 class="font-display text-5xl font-extrabold uppercase tracking-tighter">{{ locale === 'ru' ? 'Правила' : 'Terms of Service' }}</h1>
        <p class="mt-3 text-[14px] text-white/30">{{ locale === 'ru' ? 'Последнее обновление: 1 апреля 2026' : 'Last updated: April 1, 2026' }}</p>
      </div>
    </div>

    <article class="mx-auto max-w-[760px] px-6 pb-24">
      <div class="prose-article">
        <h2>1. {{ locale === 'ru' ? 'Общие положения' : 'General' }}</h2>
        <p>{{ locale === 'ru'
          ? 'AionUCP — некоммерческий фан-проект. Используя наш сервис, вы соглашаетесь с данными правилами. Администрация оставляет за собой право изменять правила без предварительного уведомления.'
          : 'AionUCP is a non-commercial fan project. By using our service, you agree to these terms. The administration reserves the right to modify these terms without prior notice.' }}</p>

        <h2>2. {{ locale === 'ru' ? 'Аккаунты' : 'Accounts' }}</h2>
        <p>{{ locale === 'ru'
          ? 'Каждый пользователь имеет право на один аккаунт. Мультиаккаунтинг разрешён в пределах 2 одновременных подключений (dual box). Продажа, обмен и передача аккаунтов третьим лицам запрещены.'
          : 'Each user is entitled to one account. Multi-accounting is allowed within 2 simultaneous connections (dual box). Selling, trading, and transferring accounts to third parties is prohibited.' }}</p>

        <h2>3. {{ locale === 'ru' ? 'Запрещённые действия' : 'Prohibited actions' }}</h2>
        <ul>
          <li v-for="rule in prohibitedRules" :key="rule">{{ rule }}</li>
        </ul>

        <h2>4. {{ locale === 'ru' ? 'Наказания' : 'Penalties' }}</h2>
        <p>{{ locale === 'ru'
          ? 'Нарушения караются предупреждением, временной или перманентной блокировкой аккаунта в зависимости от тяжести. Использование читов, ботов и эксплойтов — перманентный бан без предупреждения.'
          : 'Violations are punished with a warning, temporary or permanent account ban depending on severity. Use of cheats, bots, and exploits results in a permanent ban without warning.' }}</p>

        <h2>5. {{ locale === 'ru' ? 'Донат' : 'Donations' }}</h2>
        <p>{{ locale === 'ru'
          ? 'Все пожертвования добровольны и невозвратны. Toll-валюта приобретается для поддержки проекта. Администрация не гарантирует постоянную доступность сервера. Возврат средств не производится.'
          : 'All donations are voluntary and non-refundable. Toll currency is purchased to support the project. The administration does not guarantee permanent server availability. No refunds are issued.' }}</p>

        <h2>6. {{ locale === 'ru' ? 'Конфиденциальность данных' : 'Data handling' }}</h2>
        <p>{{ locale === 'ru'
          ? 'Мы храним минимум данных: email, хеш пароля, IP-адрес последнего входа. Данные не передаются третьим лицам. Подробнее — на странице Конфиденциальность.'
          : 'We store minimal data: email, password hash, last login IP. Data is not shared with third parties. See the Privacy page for details.' }}</p>

        <h2>7. {{ locale === 'ru' ? 'Ограничение ответственности' : 'Limitation of liability' }}</h2>
        <p>{{ locale === 'ru'
          ? 'AionUCP предоставляется «как есть». Мы не несём ответственности за потерю игровых данных, простои сервера или любой ущерб, связанный с использованием сервиса.'
          : 'AionUCP is provided "as is". We are not liable for loss of game data, server downtime, or any damage related to the use of the service.' }}</p>
      </div>
    </article>
  </div>
</template>

<script setup lang="ts">
definePageMeta({ layout: 'default' })
const { locale } = useI18n()

const prohibitedRules = computed(() => locale.value === 'ru' ? [
  'Использование сторонних программ (боты, читы, макросы, спидхаки)',
  'Эксплуатация багов и уязвимостей (обязательно сообщайте о найденных)',
  'Kill trading и фарм AP с согласия противника',
  'Оскорбления, расизм, угрозы в чате и на форуме',
  'Реклама других серверов',
  'Реальная торговля игровыми предметами и валютой (RMT)',
  'Намеренный обман администрации',
] : [
  'Use of third-party software (bots, cheats, macros, speed hacks)',
  'Exploiting bugs and vulnerabilities (report them instead)',
  'Kill trading and consensual AP farming',
  'Insults, racism, threats in chat and forums',
  'Advertising other servers',
  'Real money trading of game items and currency (RMT)',
  'Intentional deception of the administration',
])
</script>
