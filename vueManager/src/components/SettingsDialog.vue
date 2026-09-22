<script setup>
import { reactive, ref, watch } from 'vue'
import { useLexicon } from '../composables/useLexicon.js'
import { DEFAULT_BACKGROUND, DEFAULT_COLOR, normalizeColor } from '../composables/colors.js'

const props = defineProps({
  visible: Boolean,
  appearance: { type: Object, default: () => ({}) },
})
const emit = defineEmits(['update:visible', 'save'])
const { _ } = useLexicon()
const dialogVisible = ref(false)
const form = reactive({ background: '', color: '' })

watch(
  () => props.visible,
  (open) => {
    dialogVisible.value = open
    if (!open) return
    form.background = normalizeColor(props.appearance?.background) || ''
    form.color = normalizeColor(props.appearance?.color) || ''
  }
)
watch(dialogVisible, (value) => emit('update:visible', value))

function pickerValue(value, fallback) {
  return (normalizeColor(value) || fallback).slice(1)
}

function onBackground(value) {
  form.background = normalizeColor(value)
}

function onColor(value) {
  form.color = normalizeColor(value)
}

function save() {
  emit('save', {
    background: normalizeColor(form.background),
    color: normalizeColor(form.color),
  })
}
</script>

<template>
  <Dialog v-model:visible="dialogVisible" modal :header="_('managerbuttons_settings')" :style="{ width: '32rem' }">
    <div style="display: flex; flex-direction: column; gap: 1.25rem; padding-top: 1rem;">
      <div style="display: flex; flex-direction: column; gap: 0.375rem;">
        <label style="font-weight: 700;">{{ _('managerbuttons_settings_background') }}</label>
        <div style="display: flex; align-items: center; gap: 0.75rem;">
          <ColorPicker :modelValue="pickerValue(form.background, DEFAULT_BACKGROUND)" @update:modelValue="onBackground" />
          <InputText :modelValue="form.background" fluid :placeholder="DEFAULT_BACKGROUND" @update:modelValue="onBackground" />
          <Button type="button" :label="_('managerbuttons_color_clear')" severity="secondary" text @click="form.background = ''" />
        </div>
        <small style="color: var(--p-text-muted-color);">{{ _('managerbuttons_settings_background_help') }}</small>
      </div>
      <div style="display: flex; flex-direction: column; gap: 0.375rem;">
        <label style="font-weight: 700;">{{ _('managerbuttons_settings_color') }}</label>
        <div style="display: flex; align-items: center; gap: 0.75rem;">
          <ColorPicker :modelValue="pickerValue(form.color, DEFAULT_COLOR)" @update:modelValue="onColor" />
          <InputText :modelValue="form.color" fluid :placeholder="DEFAULT_COLOR" @update:modelValue="onColor" />
          <Button type="button" :label="_('managerbuttons_color_clear')" severity="secondary" text @click="form.color = ''" />
        </div>
        <small style="color: var(--p-text-muted-color);">{{ _('managerbuttons_settings_color_help') }}</small>
      </div>
    </div>
    <template #footer>
      <Button :label="_('managerbuttons_cancel')" severity="secondary" text @click="dialogVisible = false" />
      <Button :label="_('managerbuttons_save')" severity="success" @click="save" />
    </template>
  </Dialog>
</template>
