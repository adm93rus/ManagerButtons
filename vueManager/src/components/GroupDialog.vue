<script setup>
import { reactive, ref, watch } from 'vue'
import { useLexicon } from '../composables/useLexicon.js'

const props = defineProps({
  visible: Boolean,
  group: { type: Object, default: null },
  userGroups: { type: Array, default: () => [] },
})
const emit = defineEmits(['update:visible', 'save'])
const { _ } = useLexicon()
const form = reactive({ name: '', usergroup_ids: [] })
const dialogVisible = ref(false)

watch(
  () => props.visible,
  (open) => {
    dialogVisible.value = open
    if (!open) return
    form.name = props.group?.name || ''
    form.usergroup_ids = [...(props.group?.usergroup_ids || [])]
  }
)
watch(dialogVisible, (v) => emit('update:visible', v))

function save() {
  emit('save', { name: form.name.trim(), usergroup_ids: [...form.usergroup_ids] })
}
</script>

<template>
  <Dialog
    v-model:visible="dialogVisible"
    modal
    :header="group?.id ? _('managerbuttons_group_update') : _('managerbuttons_group_create')"
    :style="{ width: '48rem' }"
  >
    <div style="display: flex; flex-direction: column; gap: 1.25rem; padding-top: 1rem;">
      <div style="display: flex; flex-direction: column; gap: 0.375rem;">
        <label style="font-weight: 700;">{{ _('managerbuttons_name') }} *</label>
        <InputText v-model="form.name" fluid autofocus />
      </div>
      <Fieldset :legend="_('managerbuttons_usergroups')">
        <div style="display: flex; flex-direction: column; gap: 0.375rem;">
          <MultiSelect
            v-model="form.usergroup_ids"
            :options="userGroups"
            optionLabel="name"
            optionValue="id"
            display="chip"
            filter
            fluid
            :placeholder="_('managerbuttons_usergroups_empty')"
          />
          <small style="color: var(--p-text-muted-color);">{{ _('managerbuttons_usergroups_help') }}</small>
        </div>
      </Fieldset>
    </div>
    <template #footer>
      <Button :label="_('managerbuttons_cancel')" severity="secondary" text @click="dialogVisible = false" />
      <Button :label="_('managerbuttons_save')" severity="success" :disabled="!form.name.trim()" @click="save" />
    </template>
  </Dialog>
</template>
