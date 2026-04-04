import tailwindcss from '@tailwindcss/vite'

// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },

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
