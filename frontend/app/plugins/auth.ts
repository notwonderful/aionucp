export default defineNuxtPlugin(async () => {
  const { user, fetchUser } = useAuth()

  if (!user.value) {
    await fetchUser()
  }
})
