interface UseAdminFormOptions {
  endpoint: string
  redirectTo: string
  i18n: {
    saved: string
    created: string
    failed: string
    deleteConfirm: string
  }
}

export function useAdminForm<T extends { id: number }>(options: UseAdminFormOptions) {
  const { $api, fetchCsrfCookie } = useApi()
  const router = useRouter()
  const { submit, loading: saving, successMsg, errorMsg } = useFormSubmit()

  async function handleSubmit(
    item: T | null | undefined,
    body: FormData | Record<string, unknown>,
    emit: (id: number) => void,
  ) {
    const isFormData = body instanceof FormData
    await submit(async (api) => {
      if (item) {
        if (isFormData) body.append('_method', 'PUT')
        const method = isFormData ? 'POST' : 'PUT'
        const res = await api<{ data: T; message: string }>(`${options.endpoint}/${item.id}`, { method, body })
        emit(res.data.id)
        return res.message || options.i18n.saved
      }
      const res = await api<{ data: T; message: string }>(options.endpoint, { method: 'POST', body })
      emit(res.data.id)
      return res.message || options.i18n.created
    }, options.i18n.failed)
  }

  async function handleDelete(item: T | null | undefined) {
    if (!item || !confirm(options.i18n.deleteConfirm)) return
    try {
      await fetchCsrfCookie()
      await $api(`${options.endpoint}/${item.id}`, { method: 'DELETE' })
      router.push(options.redirectTo)
    } catch (e: unknown) {
      const err = e as { data?: { message?: string } }
      errorMsg.value = err.data?.message || options.i18n.failed
    }
  }

  return { handleSubmit, handleDelete, saving, successMsg, errorMsg }
}
