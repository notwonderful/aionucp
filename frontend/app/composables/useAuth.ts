interface User {
  id: number
  name: string
  email: string
  balance?: number
  [key: string]: unknown
}

export function useAuth() {
  const user = useState<User | null>('auth-user', () => null)
  const { $api } = useApi()

  async function fetchUser(): Promise<User | null> {
    try {
      const res = await $api<{ data: User }>('/auth/user')
      user.value = res.data
      return res.data
    } catch {
      user.value = null
      return null
    }
  }

  const isAuthenticated = computed(() => !!user.value)

  function clearUser() {
    user.value = null
  }

  async function logout() {
    try {
      await $api('/auth/logout', { method: 'POST' })
    } finally {
      clearUser()
      await navigateTo('/login')
    }
  }

  return { user, isAuthenticated, fetchUser, clearUser, logout }
}
