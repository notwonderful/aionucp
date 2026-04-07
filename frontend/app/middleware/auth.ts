export default defineNuxtRouteMiddleware(async () => {
  const { isAuthenticated, fetchUser } = useAuth()

  if (!isAuthenticated.value && import.meta.client) {
    const hasSession = document.cookie.includes('laravel_session')
    if (hasSession) {
      await fetchUser()
    }
  }

  if (!isAuthenticated.value) {
    return navigateTo('/login')
  }
})
