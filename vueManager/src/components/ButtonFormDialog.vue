<script setup>
import { reactive, ref, watch } from 'vue'
import { useLexicon } from '../composables/useLexicon.js'
import IconPicker from './IconPicker.vue'

const props = defineProps({
  visible: Boolean,
  button: { type: Object, default: null },
  icons: { type: Array, default: () => [] },
})
const emit = defineEmits(['update:visible', 'save'])
const { _ } = useLexicon()
const form = reactive({ name: '', url: '', icon: 'link', cols: 1 })
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
    form.cols = props.button?.cols || 1
    iconQuery.value = ''
  }
)
watch(dialogVisible, (v) => emit('update:visible', v))

function save() {
  emit('save', { ...form, cols: Number(form.cols) || 1 })
}
</script>

<template>
  <Dialog
    v-model:visible="dialogVisible"
    modal
    :header="button?.id ? _('managerbuttons_button_update') : _('managerbuttons_button_create')"
    :style="{ width: '42rem' }"
  >
    <div class="p-fluid" style="display: grid; gap: 1rem;">
      <div>
        <label class="font-bold">{{ _('managerbuttons_name') }}</label>
        <InputText v-model="form.name" autofocus />
      </div>
      <div>
        <label class="font-bold">{{ _('managerbuttons_url') }}</label>
        <InputText v-model="form.url" :placeholder="_('managerbuttons_url_placeholder')" />
      </div>
      <div>
        <label class="font-bold">{{ _('managerbuttons_cols') }}</label>
        <SelectButton v-model="form.cols" :options="[1, 2, 3, 4]" :allowEmpty="false" />
        <small>{{ _('managerbuttons_cols_help') }}</small>
      </div>
      <div>
        <label class="font-bold">{{ _('managerbuttons_icon') }}</label>
        <IconPicker v-model="form.icon" v-model:query="iconQuery" :icons="icons" />
      </div>
    </div>
    <template #footer>
      <Button :label="_('managerbuttons_cancel')" severity="secondary" @click="dialogVisible = false" />
      <Button
        :label="_('managerbuttons_save')"
        severity="success"
        :disabled="!form.name.trim() || !form.url.trim()"
        @click="save"
      />
    </template>
  </Dialog>
</template>
