<script setup>
import { computed } from 'vue'
import { useLexicon } from '../composables/useLexicon.js'

const FEATURED = [
  'home', 'plus', 'link', 'file-alt', 'folder', 'users', 'user', 'cog', 'wrench',
  'edit', 'trash', 'search', 'envelope', 'phone', 'image', 'calendar', 'shopping-cart',
  'globe', 'map-marker-alt', 'star', 'heart', 'check', 'info-circle', 'exclamation-triangle',
  'download', 'upload', 'external-link-alt', 'list', 'th-large', 'newspaper', 'book',
  'tag', 'comments', 'bell', 'lock', 'key', 'database', 'code', 'chart-bar', 'briefcase',
  'truck', 'gift', 'camera', 'video', 'music',
]
const LIMIT = 80

const props = defineProps({
  modelValue: { type: String, default: '' },
  icons: { type: Array, default: () => [] },
})
const emit = defineEmits(['update:modelValue'])
const { _ } = useLexicon()
const query = defineModel('query', { type: String, default: '' })

const selected = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value),
})

const matches = computed(() => {
  const q = (query.value || '').toLowerCase().trim()
  if (!q) {
    const featured = new Set(FEATURED)
    const picked = props.icons.filter((icon) => featured.has(icon.name))
    return picked.length ? picked : props.icons
  }
  return props.icons.filter((icon) => icon.name.toLowerCase().includes(q) || icon.class.toLowerCase().includes(q))
})

const visible = computed(() => matches.value.slice(0, LIMIT))
</script>

<template>
  <div style="display: grid; gap: 0.75rem;">
    <IconField>
      <InputIcon class="pi pi-search" />
      <InputText v-model="query" fluid :placeholder="_('managerbuttons_icon_search')" />
    </IconField>
    <InputText v-model="selected" fluid :placeholder="_('managerbuttons_icon_custom')" />
    <small>{{ _('managerbuttons_icon_limit') }}</small>
    <div style="display: grid; grid-template-columns: repeat(8, minmax(0, 1fr)); gap: 0.35rem; max-height: 16rem; overflow: auto;">
      <Button
        v-for="icon in visible"
        :key="icon.name"
        type="button"
        :severity="selected === icon.name ? 'success' : 'secondary'"
        :outlined="selected !== icon.name"
        :title="icon.name"
        @click="selected = icon.name"
      >
        <i :class="icon.class" />
      </Button>
    </div>
  </div>
</template>
