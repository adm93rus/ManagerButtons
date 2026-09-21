import { useLexicon as useVueToolsLexicon } from '@vuetools/useLexicon'

export function useLexicon() {
  const vt = useVueToolsLexicon()
  function _(key, params) {
    if (vt && typeof vt._ === 'function') {
      const value = vt._(key, params)
      if (value && value !== key) {
        return value
      }
    }
    const fromModx = window.MODx?.lang?.[key]
    if (fromModx) {
      return fromModx
    }
    return key
  }
  return { _ }
}
