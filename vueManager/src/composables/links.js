export function openManagerLink(url) {
  if (!url) return
  let parsed = null
  try {
    parsed = new URL(url, window.location.origin)
  } catch (e) {
    window.location.href = url
    return
  }
  const action = parsed.searchParams.get('a')
  const sameOrigin = parsed.origin === window.location.origin
  if (action && sameOrigin && window.MODx && typeof window.MODx.loadPage === 'function') {
    const params = new URLSearchParams(parsed.search)
    params.delete('a')
    window.MODx.loadPage(action, params.toString())
    return
  }
  if (/^https?:$/i.test(parsed.protocol)) {
    window.open(parsed.href, '_blank', 'noopener,noreferrer')
    return
  }
  window.location.href = url
}

export function downloadJson(filename, content) {
  const blob = new Blob([content], { type: 'application/json;charset=utf-8' })
  const href = URL.createObjectURL(blob)
  const a = document.createElement('a')
  a.href = href
  a.download = filename
  document.body.appendChild(a)
  a.click()
  a.remove()
  URL.revokeObjectURL(href)
}
