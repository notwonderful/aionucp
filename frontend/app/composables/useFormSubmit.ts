export function useFormSubmit() {
  const { $api, fetchCsrfCookie } = useApi()
  const loading = ref(false)
  const successMsg = ref('')
  const errorMsg = ref('')

  async function submit(fn: (api: typeof $api) => Promise<string | void>, fallbackError = '') {
    loading.value = true
    successMsg.value = ''
    errorMsg.value = ''

    try {
      await fetchCsrfCookie()
      const msg = await fn($api)
      if (msg) successMsg.value = msg
    } catch (e: unknown) {
      const err = e as { data?: { message?: string } }
      errorMsg.value = err.data?.message || fallbackError
    } finally {
      loading.value = false
    }
  }

  return { submit, loading, successMsg, errorMsg }
}
