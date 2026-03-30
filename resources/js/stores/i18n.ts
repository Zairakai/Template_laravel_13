import { createI18n, type TranslationData } from '@zairakai/js-i18n'
import { defineStore } from 'pinia'
import { ref } from 'vue'
import { availableLocales, defaultLocale, fallbackLocale, transEndpoint } from '../config/i18n'

export const useI18nStore = defineStore('i18n', () => {
  const locale = ref(defaultLocale)
  const loaded = ref(false)
  const translations = ref<TranslationData>({})

  const t = ref(createI18n({}, defaultLocale))

  async function loadLocale(lang: string): Promise<void> {
    const target = Object.keys(availableLocales).includes(lang) ? lang : fallbackLocale

    if (translations.value[target]) {
      applyLocale(target)
      return
    }

    const response = await fetch(transEndpoint(target), {
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      credentials: 'same-origin',
    })

    if (!response.ok) {
      console.error(`[i18n] Failed to load locale "${target}": ${response.status}`)
      return
    }

    translations.value[target] = (await response.json()) as TranslationData[string]
    applyLocale(target)
  }

  function applyLocale(lang: string): void {
    locale.value = lang
    t.value = createI18n(translations.value, lang)
    loaded.value = true
  }

  return { locale, loaded, t, loadLocale }
})
