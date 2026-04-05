import type { FetchOptions } from 'ofetch'

interface ApiRequestOptions extends Omit<FetchOptions, 'signal'> {
  signal?: AbortSignal
}

export function useApi() {
  const config = useRuntimeConfig()
  const locale = useCookie('locale')

  const baseURL = import.meta.server
    ? (config.apiBaseServer as string)
    : (config.public.apiBase as string)

  const serverHeaders = import.meta.server
    ? useRequestHeaders(['cookie'])
    : undefined

  function getXsrfToken(): string {
    const cookies = import.meta.server ? (serverHeaders?.cookie ?? '') : document.cookie
    const match = cookies.match(/XSRF-TOKEN=([^;]+)/)
    return match ? decodeURIComponent(match[1]) : ''
  }

  async function $api<T>(path: string, opts: ApiRequestOptions = {}): Promise<T> {
    const { headers: customHeaders, signal, ...restOpts } = opts

    const xsrfToken = getXsrfToken()

    const mergedHeaders: Record<string, string> = {
      'Accept': 'application/json',
      'Accept-Language': locale.value || 'en',
      'X-Requested-With': 'XMLHttpRequest',
      ...(xsrfToken ? { 'X-XSRF-TOKEN': xsrfToken } : {}),
      ...(import.meta.server && serverHeaders?.cookie ? { cookie: serverHeaders.cookie } : {}),
      ...(import.meta.server ? { origin: config.appOrigin as string } : {}),
      ...((customHeaders as Record<string, string>) ?? {}),
    }

    return $fetch<T>(path, {
      baseURL,
      credentials: 'include',
      headers: mergedHeaders,
      signal,
      ...restOpts,
    })
  }

  async function fetchCsrfCookie(): Promise<void> {
    await $fetch('/sanctum/csrf-cookie', {
      credentials: 'include',
    })
  }

  return { $api, fetchCsrfCookie }
}
