interface FilterDef {
  key: string
  value: Ref<string>
}

interface UseListDataOptions<T> {
  cacheKey: string
  endpoint: string
  filters?: FilterDef[]
  extraParams?: Record<string, string>
}

export function useListData<T>(options: UseListDataOptions<T>) {
  const { $api } = useApi()

  const queryParams = computed(() => {
    const params = new URLSearchParams()
    if (options.filters) {
      for (const f of options.filters) {
        if (f.value.value) params.set(`filter[${f.key}]`, f.value.value)
      }
    }
    if (options.extraParams) {
      for (const [k, v] of Object.entries(options.extraParams)) {
        params.set(k, v)
      }
    }
    const qs = params.toString()
    return qs ? `?${qs}` : ''
  })

  const { data: raw, status } = useAsyncData(
    options.cacheKey,
    () => $api<{ data: T[] }>(`${options.endpoint}${queryParams.value}`),
    { watch: [queryParams] },
  )

  const items = computed(() => raw.value?.data ?? [])

  return { items, status }
}
