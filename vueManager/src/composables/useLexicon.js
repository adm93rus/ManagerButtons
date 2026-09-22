import { useLexicon as useVueToolsLexicon } from '@vuetools/useLexicon'

function applyParams(value, params) {
  if (!params || typeof value !== 'string') {
    return value
  }
  let out = value
  for (const [paramKey, paramValue] of Object.entries(params)) {
    const text = String(paramValue)
    out = out.replaceAll(`[[+${paramKey}]]`, text)
    out = out.replaceAll(`{${paramKey}}`, text)
  }
  return out
}

export function useLexicon() {
  const vt = useVueToolsLexicon()
  function _(key, params) {
    const local = window.ManagerButtons?.config?.lexicon?.[key]
    if (local) {
      return applyParams(local, params)
    }
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
