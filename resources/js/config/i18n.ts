export const defaultLocale = 'fr'
export const fallbackLocale = 'en'

export const availableLocales: Record<string, string> = {
  fr: 'fr',
  en: 'en',
}

export const transEndpoint = (lang: string) => `/api/v1/cache/trans/${lang}`
