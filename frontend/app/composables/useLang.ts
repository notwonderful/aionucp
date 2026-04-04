export function useLang() {
  const { locale, t, setLocale } = useI18n()

  function setLang(lang: string) {
    setLocale(lang)
  }

  return { lang: locale, t, setLang }
}
