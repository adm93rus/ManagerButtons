import { computed } from 'vue'

const DEFAULT_TIMEOUT = 30000

export class ConnectorError extends Error {
  constructor(message, response = null, status = null) {
    super(message)
    this.name = 'ConnectorError'
    this.response = response
    this.status = status
  }
}

export function useConnector() {
  const cfg = window.ManagerButtons?.config || {}
  const baseUrl = computed(() => (cfg.connector_url || cfg.connectorUrl || '').replace(/\/$/, ''))
  const authToken = computed(() => cfg.modAuth || window.MODx?.siteId || '')

  function buildFormData(params) {
    const data = new URLSearchParams()
    for (const [key, value] of Object.entries(params)) {
      if (value === undefined || value === null) continue
      if (Array.isArray(value) || (typeof value === 'object' && !(value instanceof Date))) {
        data.append(key, JSON.stringify(value))
      } else {
        data.append(key, String(value))
      }
    }
    if (authToken.value) {
      data.append('modAuth', authToken.value)
      data.append('HTTP_MODAUTH', authToken.value)
    }
    return data
  }

  async function post(action, params = {}, options = {}) {
    const formData = buildFormData({ ...params, action })
    const controller = new AbortController()
    const timeoutId = setTimeout(() => controller.abort(), options.timeout || DEFAULT_TIMEOUT)
    try {
      const response = await fetch(baseUrl.value, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: formData.toString(),
        signal: controller.signal,
        credentials: 'same-origin',
      })
      clearTimeout(timeoutId)
      const data = await response.json()
      if (!response.ok || data.success === false) {
        throw new ConnectorError(data.message || `HTTP ${response.status}`, data, response.status)
      }
      return data
    } catch (error) {
      clearTimeout(timeoutId)
      if (error.name === 'AbortError') {
        throw new ConnectorError('Request timeout')
      }
      throw error instanceof ConnectorError ? error : new ConnectorError(error.message)
    }
  }

  return { post, ConnectorError }
}
