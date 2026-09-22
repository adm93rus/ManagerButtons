export const DEFAULT_BACKGROUND = '#234368'
export const DEFAULT_COLOR = '#ffffff'

export function normalizeColor(value) {
  const raw = String(value || '').trim()
  if (!raw) return ''
  const withHash = raw.startsWith('#') ? raw : `#${raw}`
  if (!/^#(?:[0-9a-fA-F]{3}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$/.test(withHash)) return ''
  return withHash.toLowerCase()
}

export function buttonColors(button, appearance = {}) {
  const background = normalizeColor(button?.background)
    || normalizeColor(appearance.background)
    || appearance.default_background
    || DEFAULT_BACKGROUND
  const color = normalizeColor(appearance.color) || appearance.default_color || DEFAULT_COLOR
  return { background, color }
}

export function buttonStyle(button, appearance) {
  const { background, color } = buttonColors(button, appearance)
  return {
    width: '100%',
    justifyContent: 'flex-start',
    gap: '0 0.6rem',
    whiteSpace: 'normal',
    textAlign: 'left',
    display: 'grid',
    gridTemplateColumns: 'auto 1fr',
    background,
    color,
    borderColor: background,
    '--p-button-primary-background': background,
    '--p-button-primary-hover-background': background,
    '--p-button-primary-active-background': background,
    '--p-button-primary-color': color,
    '--p-button-primary-hover-color': color,
    '--p-button-primary-active-color': color,
    '--p-button-primary-border-color': background,
    '--p-button-primary-hover-border-color': background,
    '--p-button-primary-active-border-color': background,
  }
}
