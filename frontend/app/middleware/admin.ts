export default defineNuxtRouteMiddleware(async () => {
  const { isAuthenticated, isAdmin, fetchUser } = useAuth()

  if (!isAuthenticated.value && import.meta.client) {
    await fetchUser()
  }

  if (!isAuthenticated.value) {
    return navigateTo('/login')
  }

  if (!isAdmin.value) {
    return navigateTo('/dashboard')
  }
})
