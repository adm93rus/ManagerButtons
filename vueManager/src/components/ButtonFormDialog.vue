<script setup>
import { reactive, ref, watch } from 'vue'
import { useLexicon } from '../composables/useLexicon.js'
import IconPicker from './IconPicker.vue'
import { normalizeColor } from '../composables/colors.js'

const props = defineProps({
  visible: Boolean,
  button: { type: Object, default: null },
  icons: { type: Array, default: () => [] },
  appearance: { type: Object, default: () => ({}) },
})
const emit = defineEmits(['update:visible', 'save'])
const { _ } = useLexicon()
const form = reactive({ name: '', url: '', icon: 'link', cols: 1, description: '', background: '' })
const iconQuery = ref('')
const dialogVisible = ref(false)

watch(
  () => props.visible,
  (open) => {
    dialogVisible.value = open
    if (!open) return
    form.name = props.button?.name || ''
    form.url = props.button?.url || ''
    form.icon = props.button?.icon || 'link'
    form.cols = Number(props.button?.cols) || 1
    form.description = props.button?.description || ''
    form.background = normalizeColor(props.button?.background)
    iconQuery.value = ''
  }
)
watch(dialogVisible, (v) => emit('update:visible', v))

function save() {
  emit('save', {
    name: form.name.trim(),
    url: form.url.trim(),
    icon: form.icon,
    cols: Number(form.cols) || 1,
    description: form.description.trim(),
    background: normalizeColor(form.background),
  })
}

function inheritedBackground() {
  return normalizeColor(props.appearance?.background) || props.appearance?.default_background || '#e5e5e5'
}

function onButtonBackground(value) {
  const next = normalizeColor(value)
  form.background = next === inheritedBackground() ? '' : next
}
</script>

<template>
  <Dialog
    v-model:visible="dialogVisible"
    modal
    :header="button?.id ? _('managerbuttons_button_update') : _('managerbuttons_button_create')"
    :style="{ width: '46rem' }"
  >
    <div style="display: flex; flex-direction: column; gap: 1.25rem; padding-top: 1rem;">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
        <div style="display: flex; flex-direction: column; gap: 0.375rem;">
          <label style="font-weight: 700;">{{ _('managerbuttons_name') }} *</label>
          <InputText v-model="form.name" fluid autofocus />
        </div>
        <div style="display: flex; flex-direction: column; gap: 0.375rem;">
          <label style="font-weight: 700;">{{ _('managerbuttons_url') }} *</label>
          <InputText v-model="form.url" fluid :placeholder="_('managerbuttons_url_placeholder')" />
        </div>
      </div>
      <Fieldset :legend="_('managerbuttons_cols')">
        <div style="display: flex; flex-direction: column; gap: 0.375rem; align-items: flex-start;">
          <SelectButton v-model="form.cols" :options="[1, 2, 3, 4]" :allowEmpty="false" />
          <small style="color: var(--p-text-muted-color);">{{ _('managerbuttons_cols_help') }}</small>
        </div>
      </Fieldset>
      <div style="display: flex; flex-direction: column; gap: 0.375rem;">
        <label style="font-weight: 700;">{{ _('managerbuttons_description') }}</label>
        <Textarea v-model="form.description" rows="3" autoResize fluid />
        <small style="color: var(--p-text-muted-color);">{{ _('managerbuttons_description_help') }}</small>
      </div>
      <Fieldset :legend="_('managerbuttons_button_background')">
        <div style="display: flex; flex-direction: column; gap: 0.375rem;">
          <div style="display: flex; align-items: center; gap: 0.75rem;">
            <ColorPicker
              :modelValue="(normalizeColor(form.background) || inheritedBackground()).slice(1)"
              @update:modelValue="onButtonBackground"
            />
            <InputText v-model="form.background" fluid :placeholder="inheritedBackground()" />
            <Button type="button" :label="_('managerbuttons_color_clear')" severity="secondary" text @click="form.background = ''" />
          </div>
          <small style="color: var(--p-text-muted-color);">{{ _('managerbuttons_button_background_help') }}</small>
        </div>
      </Fieldset>
      <Fieldset :legend="_('managerbuttons_icon')">
        <IconPicker v-model="form.icon" v-model:query="iconQuery" :icons="icons" />
      </Fieldset>
    </div>
    <template #footer>
      <Button :label="_('managerbuttons_cancel')" severity="secondary" text @click="dialogVisible = false" />
      <Button
        :label="_('managerbuttons_save')"
        severity="success"
        :disabled="!form.name.trim() || !form.url.trim()"
        @click="save"
      />
    </template>
  </Dialog>
</template>
