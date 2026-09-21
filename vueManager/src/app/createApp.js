import { createApp } from 'vue'
import { PrimeVue, ToastService, ConfirmationService } from 'primevue'
import { getActiveTheme } from '@vuetools/useTheme'
import { getPrimeVueLocale } from '@vuetools/usePrimeVueLocale'

export function createManagerButtonsApp(RootComponent, rootProps = {}, components = {}) {
  const app = createApp(RootComponent, rootProps)
  app.use(PrimeVue, {
    ...getActiveTheme(),
    locale: getPrimeVueLocale(),
    ripple: false,
  })
  app.use(ToastService)
  app.use(ConfirmationService)
  for (const [name, component] of Object.entries(components)) {
    app.component(name, component)
  }
  return app
}
