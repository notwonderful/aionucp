export default defineNuxtRouteMiddleware(async () => {
  const { isAuthenticated, fetchUser } = useAuth()

  if (!isAuthenticated.value && import.meta.client) {
    await fetchUser()
  }

  if (!isAuthenticated.value) {
    return navigateTo('/login')
  }
})
