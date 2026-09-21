import { Button } from 'primevue'
import { createManagerButtonsApp } from '../app/createApp.js'
import WidgetApp from '../components/WidgetApp.vue'

function parsePayload(el) {
  const raw = el.getAttribute('data-payload')
  if (!raw) return { groups: [] }
  try {
    return JSON.parse(raw)
  } catch (e) {
    return { groups: [] }
  }
}

export function mountWidget(el) {
  if (!el || el.dataset.vApp === 'true') return
  const payload = parsePayload(el)
  const app = createManagerButtonsApp(WidgetApp, { payload }, { Button })
  app.mount(el)
  el.dataset.vApp = 'true'
}

function scan() {
  document.querySelectorAll('.managerbuttons-widget').forEach((el) => mountWidget(el))
}

scan()
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', scan)
}
const observer = new MutationObserver(scan)
observer.observe(document.documentElement, { childList: true, subtree: true })

window.ManagerButtonsWidget = { init: mountWidget }
