import { createPinia, setActivePinia } from 'pinia'
import { beforeEach, describe, expect, it, vi } from 'vitest'
import { defaultLocale, fallbackLocale } from '@/config/i18n'
import { useI18nStore } from '@/stores/i18n'

const mockTranslations = {
  common: { hello: 'Bonjour' },
}

describe('useI18nStore', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
    vi.restoreAllMocks()
  })

  it('has correct initial state', () => {
    const store = useI18nStore()

    expect(store.locale).toBe(defaultLocale)
    expect(store.loaded).toBe(false)
  })

  it('loads a locale and marks store as loaded', async () => {
    vi.stubGlobal('fetch', vi.fn().mockResolvedValue({
      ok: true,
      json: vi.fn().mockResolvedValue(mockTranslations),
    }))

    const store = useI18nStore()
    await store.loadLocale('fr')

    expect(store.loaded).toBe(true)
    expect(store.locale).toBe('fr')
    expect(fetch).toHaveBeenCalledOnce()
  })

  it('falls back to fallbackLocale for unknown locale', async () => {
    vi.stubGlobal('fetch', vi.fn().mockResolvedValue({
      ok: true,
      json: vi.fn().mockResolvedValue(mockTranslations),
    }))

    const store = useI18nStore()
    await store.loadLocale('xx')

    expect(store.locale).toBe(fallbackLocale)
  })

  it('does not fetch again if locale already loaded', async () => {
    const fetchMock = vi.fn().mockResolvedValue({
      ok: true,
      json: vi.fn().mockResolvedValue(mockTranslations),
    })
    vi.stubGlobal('fetch', fetchMock)

    const store = useI18nStore()
    await store.loadLocale('fr')
    await store.loadLocale('fr')

    expect(fetchMock).toHaveBeenCalledOnce()
  })

  it('does not mark as loaded if fetch fails', async () => {
    vi.stubGlobal('fetch', vi.fn().mockResolvedValue({
      ok: false,
      status: 401,
    }))

    const store = useI18nStore()
    await store.loadLocale('fr')

    expect(store.loaded).toBe(false)
  })
})
