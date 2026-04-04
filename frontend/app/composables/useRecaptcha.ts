import { useReCaptcha } from 'vue-recaptcha-v3'

export function useRecaptcha() {
  const recaptcha = import.meta.client ? useReCaptcha() : null

  async function getToken(action: string): Promise<string> {
    if (!recaptcha) return ''

    await recaptcha.recaptchaLoaded()
    return await recaptcha.executeRecaptcha(action)
  }

  return { getToken }
}
