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
    :style="{ width: '40rem' }"
  >
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
      <div>
        <label>{{ _('managerbuttons_name') }} *</label>
        <InputText v-model="form.name" fluid autofocus />
      </div>
      <div>
        <label>{{ _('managerbuttons_usergroups') }}</label>
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
        <small>{{ _('managerbuttons_usergroups_help') }}</small>
      </div>
    </div>
    <template #footer>
      <Button :label="_('managerbuttons_cancel')" severity="secondary" text @click="dialogVisible = false" />
      <Button :label="_('managerbuttons_save')" severity="success" :disabled="!form.name.trim()" @click="save" />
    </template>
  </Dialog>
</template>
