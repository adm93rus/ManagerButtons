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

watch(
  () => props.visible,
  (open) => {
    if (!open) return
    form.name = props.group?.name || ''
    form.usergroup_ids = [...(props.group?.usergroup_ids || [])]
  }
)

const dialogVisible = ref(false)
watch(
  () => props.visible,
  (v) => {
    dialogVisible.value = v
  }
)
watch(dialogVisible, (v) => emit('update:visible', v))

function save() {
  emit('save', { ...form })
}
</script>

<template>
  <Dialog
    v-model:visible="dialogVisible"
    modal
    :header="group?.id ? _('managerbuttons_group_update') : _('managerbuttons_group_create')"
    :style="{ width: '32rem' }"
  >
    <div class="p-fluid" style="display: grid; gap: 1rem;">
      <div>
        <label class="font-bold">{{ _('managerbuttons_name') }}</label>
        <InputText v-model="form.name" autofocus />
      </div>
      <div>
        <label class="font-bold">{{ _('managerbuttons_usergroups') }}</label>
        <MultiSelect
          v-model="form.usergroup_ids"
          :options="userGroups"
          optionLabel="name"
          optionValue="id"
          display="chip"
          filter
          :placeholder="_('managerbuttons_usergroups_empty')"
          style="width: 100%;"
        />
        <small>{{ _('managerbuttons_usergroups_help') }}</small>
      </div>
    </div>
    <template #footer>
      <Button :label="_('managerbuttons_cancel')" severity="secondary" @click="dialogVisible = false" />
      <Button :label="_('managerbuttons_save')" severity="success" :disabled="!form.name.trim()" @click="save" />
    </template>
  </Dialog>
</template>
