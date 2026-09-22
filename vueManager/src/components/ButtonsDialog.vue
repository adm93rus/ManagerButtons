<script setup>
import { computed, onMounted, ref, watch } from 'vue'
import { useConfirm, useToast } from 'primevue'
import { useLexicon } from '../composables/useLexicon.js'
import { useConnector } from '../composables/useConnector.js'
import ButtonFormDialog from './ButtonFormDialog.vue'
import GroupPreview from './GroupPreview.vue'

const props = defineProps({
  visible: Boolean,
  group: { type: Object, default: null },
  icons: { type: Array, default: () => [] },
})
const emit = defineEmits(['update:visible', 'changed'])
const { _ } = useLexicon()
const { post } = useConnector()
const confirm = useConfirm()
const toast = useToast()
const dialogVisible = ref(false)
const buttons = ref([])
const loading = ref(false)
const formVisible = ref(false)
const current = ref(null)

watch(
  () => props.visible,
  (v) => {
    dialogVisible.value = v
    if (v && props.group?.id) load()
  }
)
watch(dialogVisible, (v) => emit('update:visible', v))

const previewGroups = computed(() => [
  {
    id: props.group?.id,
    name: props.group?.name,
    buttons: buttons.value.map((b) => ({
      ...b,
      icon: b.icon_class || b.icon,
    })),
  },
])

function notifyError(error) {
  toast.add({
    severity: 'error',
    summary: _('managerbuttons_error'),
    detail: error.message || String(error),
    life: 4000,
  })
}

async function load() {
  loading.value = true
  try {
    const res = await post('ManagerButtons\\Processors\\Button\\GetList', { group_id: props.group.id, limit: 0 })
    buttons.value = res.results || res.object || []
  } catch (error) {
    notifyError(error)
  } finally {
    loading.value = false
  }
}

function openCreate() {
  current.value = null
  formVisible.value = true
}

function openEdit(row) {
  current.value = row
  formVisible.value = true
}

async function saveButton(form) {
  try {
    const action = current.value?.id
      ? 'ManagerButtons\\Processors\\Button\\Update'
      : 'ManagerButtons\\Processors\\Button\\Create'
    await post(action, { ...form, id: current.value?.id, group_id: props.group.id })
    formVisible.value = false
    await load()
    emit('changed')
  } catch (error) {
    notifyError(error)
  }
}

function askRemove(row) {
  confirm.require({
    message: _('managerbuttons_button_remove_confirm'),
    header: _('managerbuttons_button_remove'),
    icon: 'pi pi-exclamation-triangle',
    acceptLabel: _('managerbuttons_yes'),
    rejectLabel: _('managerbuttons_cancel'),
    acceptClass: 'p-button-danger',
    accept: async () => {
      try {
        await post('ManagerButtons\\Processors\\Button\\Remove', { id: row.id })
        await load()
        emit('changed')
      } catch (error) {
        notifyError(error)
      }
    },
  })
}

async function onReorder(event) {
  buttons.value = event.value
  try {
    await post('ManagerButtons\\Processors\\Button\\Sort', {
      group_id: props.group.id,
      ids: buttons.value.map((b) => b.id),
    })
  } catch (error) {
    notifyError(error)
    await load()
  }
}

onMounted(() => {
  if (props.visible && props.group?.id) load()
})
</script>

<template>
  <Dialog
    v-model:visible="dialogVisible"
    modal
    :header="group ? `${_('managerbuttons_buttons')}: ${group.name}` : _('managerbuttons_buttons')"
    :style="{ width: '64rem' }"
  >
    <Toolbar style="margin-bottom: 1rem;">
      <template #start>
        <Button :label="_('managerbuttons_button_create')" icon="pi pi-plus" severity="success" @click="openCreate" />
      </template>
    </Toolbar>
    <DataTable
      :value="buttons"
      dataKey="id"
      :loading="loading"
      stripedRows
      paginator
      :rows="10"
      :alwaysShowPaginator="false"
      reorderableRows
      @row-reorder="onReorder"
    >
      <Column rowReorder headerStyle="width: 3rem" />
      <Column :header="_('managerbuttons_icon')" style="width: 4rem">
        <template #body="{ data }">
          <i :class="data.icon_class || data.icon" />
        </template>
      </Column>
      <Column field="name" :header="_('managerbuttons_name')" />
      <Column field="url" :header="_('managerbuttons_url')" />
      <Column field="cols" :header="_('managerbuttons_cols')" style="width: 6rem" />
      <Column :header="_('managerbuttons_actions')" style="width: 8rem">
        <template #body="{ data }">
          <Button icon="pi pi-pencil" severity="secondary" text rounded :title="_('managerbuttons_button_update')" @click="openEdit(data)" />
          <Button icon="pi pi-trash" severity="danger" text rounded :title="_('managerbuttons_button_remove')" @click="askRemove(data)" />
        </template>
      </Column>
      <template #empty>{{ _('managerbuttons_empty') }}</template>
    </DataTable>
    <Panel :header="_('managerbuttons_button_preview')" style="margin-top: 1rem;">
      <GroupPreview :groups="previewGroups" />
    </Panel>
    <ButtonFormDialog v-model:visible="formVisible" :button="current" :icons="icons" @save="saveButton" />
  </Dialog>
</template>
