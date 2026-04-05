export default defineNuxtRouteMiddleware(() => {
  const { isAuthenticated, isVerified } = useAuth()

  if (isAuthenticated.value && !isVerified.value) {
    return navigateTo('/verify-email')
  }
})
