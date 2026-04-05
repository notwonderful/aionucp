import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

export default defineNuxtPlugin(() => {
  let echo: Echo | null = null

  function getEcho(): Echo {
    if (echo) return echo

    window.Pusher = Pusher

    const config = useRuntimeConfig()

    echo = new Echo({
      broadcaster: 'reverb',
      key: config.public.reverbKey,
      wsHost: config.public.reverbHost,
      wsPort: Number(config.public.reverbPort),
      wssPort: Number(config.public.reverbPort),
      forceTLS: false,
      enabledTransports: ['ws', 'wss'],
      authEndpoint: '/broadcasting/auth',
      auth: {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-XSRF-TOKEN': getXsrfToken(),
        },
      },
    })

    return echo
  }

  return { provide: { echo: getEcho } }
})

function getXsrfToken(): string {
  const match = document.cookie.match(/XSRF-TOKEN=([^;]+)/)
  return match ? decodeURIComponent(match[1]) : ''
}
