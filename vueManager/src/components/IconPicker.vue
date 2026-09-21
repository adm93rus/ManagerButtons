<script setup>
import { computed } from 'vue'
import { useLexicon } from '../composables/useLexicon.js'

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

const filtered = computed(() => {
  const q = (query.value || '').toLowerCase().trim()
  if (!q) return props.icons
  return props.icons.filter((icon) => icon.name.toLowerCase().includes(q) || icon.class.toLowerCase().includes(q))
})
</script>

<template>
  <div>
    <div class="p-fluid" style="display: grid; gap: 0.75rem;">
      <IconField>
        <InputIcon class="pi pi-search" />
        <InputText v-model="query" :placeholder="_('managerbuttons_icon_search')" />
      </IconField>
      <InputText v-model="selected" :placeholder="_('managerbuttons_icon_custom')" />
    </div>
    <div style="display: grid; grid-template-columns: repeat(8, minmax(0, 1fr)); gap: 0.35rem; max-height: 16rem; overflow: auto; margin-top: 0.75rem;">
      <Button
        v-for="icon in filtered"
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
