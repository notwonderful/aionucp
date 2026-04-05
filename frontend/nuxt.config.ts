import tailwindcss from '@tailwindcss/vite'

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },

  modules: ['@nuxtjs/i18n'],

  i18n: {
    locales: [
      { code: 'en', language: 'en-US', file: 'en.json', name: 'English' },
      { code: 'ru', language: 'ru-RU', file: 'ru.json', name: 'Русский' },
    ],
    defaultLocale: 'en',
    strategy: 'prefix_except_default',
    detectBrowserLanguage: {
      useCookie: true,
      cookieKey: 'locale',
      redirectOn: 'root',
    },
    langDir: '../i18n/locales',
  },

  devServer: {
    host: 'aionucp.local',
    port: 3000,
  },

  runtimeConfig: {
    apiBaseServer: process.env.NUXT_API_BASE_SERVER || 'http://aionucp.local/api',
    appOrigin: process.env.NUXT_APP_ORIGIN || 'http://aionucp.local:3000',
    public: {
      apiBase: process.env.NUXT_PUBLIC_API_BASE || '/api',
      recaptchaSiteKey: process.env.NUXT_PUBLIC_RECAPTCHA_SITE_KEY || '',
      reverbKey: process.env.NUXT_PUBLIC_REVERB_KEY || 'pmcilkvvwjaifuyyk2nn',
      reverbHost: process.env.NUXT_PUBLIC_REVERB_HOST || 'localhost',
      reverbPort: process.env.NUXT_PUBLIC_REVERB_PORT || '8080',
      serverTimezone: process.env.NUXT_PUBLIC_SERVER_TIMEZONE || 'Europe/Berlin',
    },
  },

  vite: {
    plugins: [
      tailwindcss(),
    ],
  },

  css: ['~/assets/css/main.css'],

  nitro: {
    devProxy: {
      '/api': {
        target: 'http://aionucp.local/api',
        changeOrigin: true,
      },
      '/sanctum': {
        target: 'http://aionucp.local/sanctum',
        changeOrigin: true,
      },
      '/broadcasting': {
        target: 'http://aionucp.local/broadcasting',
        changeOrigin: true,
      },
    },
  },
})
