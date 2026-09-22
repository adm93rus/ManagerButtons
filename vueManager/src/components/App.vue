<script setup>
import { onMounted, ref } from 'vue'
import { useConfirm, useToast } from 'primevue'
import { useLexicon } from '../composables/useLexicon.js'
import { useConnector } from '../composables/useConnector.js'
import { downloadJson } from '../composables/links.js'
import GroupDialog from './GroupDialog.vue'
import ButtonsDialog from './ButtonsDialog.vue'
import ImportDialog from './ImportDialog.vue'
import SettingsDialog from './SettingsDialog.vue'

const { _ } = useLexicon()
const { post } = useConnector()
const toast = useToast()
const confirm = useConfirm()

const groups = ref([])
const userGroups = ref([])
const icons = ref([])
const loading = ref(false)
const query = ref('')
const selected = ref([])
const groupDialog = ref(false)
const buttonsDialog = ref(false)
const importDialog = ref(false)
const settingsDialog = ref(false)
const appearance = ref({})
const current = ref(null)
let searchTimer = 0

function notifyError(error) {
  toast.add({
    severity: 'error',
    summary: _('managerbuttons_error'),
    detail: error.message || String(error),
    life: 4000,
  })
}

function notifyOk(detail) {
  toast.add({
    severity: 'success',
    summary: _('managerbuttons_success'),
    detail,
    life: 2500,
  })
}

async function loadGroups() {
  loading.value = true
  try {
    const res = await post('ManagerButtons\\Processors\\Group\\GetList', {
      query: query.value,
      limit: 0,
    })
    groups.value = res.results || []
    selected.value = []
  } catch (error) {
    notifyError(error)
  } finally {
    loading.value = false
  }
}

async function loadAppearance() {
  try {
    const res = await post('ManagerButtons\\Processors\\Settings\\Get')
    appearance.value = res.object || {}
  } catch (error) {
    notifyError(error)
  }
}

async function saveAppearance(form) {
  try {
    const res = await post('ManagerButtons\\Processors\\Settings\\Update', form)
    appearance.value = res.object || appearance.value
    settingsDialog.value = false
    notifyOk(res.message)
  } catch (error) {
    notifyError(error)
  }
}

async function loadLookups() {
  const [ug, ic] = await Promise.all([
    post('ManagerButtons\\Processors\\UserGroup\\GetList', { limit: 0 }),
    post('ManagerButtons\\Processors\\Icon\\GetList', { limit: 0 }),
  ])
  userGroups.value = ug.results || []
  icons.value = ic.results || []
}

function onSearch() {
  window.clearTimeout(searchTimer)
  searchTimer = window.setTimeout(loadGroups, 250)
}

function openCreate() {
  current.value = null
  groupDialog.value = true
}

function openEdit(row) {
  current.value = row
  groupDialog.value = true
}

function openButtons(row) {
  current.value = row
  buttonsDialog.value = true
}

async function saveGroup(form) {
  try {
    const action = current.value?.id
      ? 'ManagerButtons\\Processors\\Group\\Update'
      : 'ManagerButtons\\Processors\\Group\\Create'
    const res = await post(action, { ...form, id: current.value?.id })
    groupDialog.value = false
    notifyOk(res.message)
    await loadGroups()
  } catch (error) {
    notifyError(error)
  }
}

function askRemove(rows) {
  const list = Array.isArray(rows) ? rows : [rows]
  if (!list.length) return
  confirm.require({
    message: list.length > 1 ? _('managerbuttons_group_remove_selected') : _('managerbuttons_group_remove_confirm'),
    header: _('managerbuttons_group_remove'),
    icon: 'pi pi-exclamation-triangle',
    acceptLabel: _('managerbuttons_yes'),
    rejectLabel: _('managerbuttons_cancel'),
    acceptClass: 'p-button-danger',
    accept: async () => {
      try {
        const res = await post('ManagerButtons\\Processors\\Group\\Remove', {
          ids: list.map((row) => row.id),
        })
        notifyOk(res.message)
        await loadGroups()
      } catch (error) {
        notifyError(error)
      }
    },
  })
}

async function duplicate(row) {
  try {
    const res = await post('ManagerButtons\\Processors\\Group\\Duplicate', { id: row.id })
    notifyOk(res.message)
    await loadGroups()
  } catch (error) {
    notifyError(error)
  }
}

async function exportGroup(row) {
  try {
    const res = await post('ManagerButtons\\Processors\\Group\\Export', { id: row.id })
    const object = res.object || {}
    downloadJson(object.filename || 'managerbuttons.json', object.json || JSON.stringify(object.payload, null, 2))
  } catch (error) {
    notifyError(error)
  }
}

async function importGroup(payload) {
  try {
    const res = await post('ManagerButtons\\Processors\\Group\\Import', { payload })
    importDialog.value = false
    notifyOk(res.message)
    await loadGroups()
  } catch (error) {
    notifyError(error)
  }
}

async function onReorder(event) {
  if (query.value.trim()) {
    return
  }
  groups.value = event.value
  try {
    await post('ManagerButtons\\Processors\\Group\\Sort', {
      ids: groups.value.map((g) => g.id),
    })
  } catch (error) {
    notifyError(error)
    await loadGroups()
  }
}

onMounted(async () => {
  await Promise.all([loadLookups(), loadGroups(), loadAppearance()])
})
</script>

<template>
  <div class="managerbuttons-app">
    <Toast />
    <ConfirmDialog />
    <Toolbar style="margin-bottom: 1rem;">
      <template #start>
        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center;">
          <Button :label="_('managerbuttons_group_create')" icon="pi pi-plus" severity="success" @click="openCreate" />
          <Button :label="_('managerbuttons_group_import')" icon="pi pi-upload" severity="secondary" outlined @click="importDialog = true" />
          <Button :label="_('managerbuttons_settings')" icon="pi pi-cog" severity="secondary" outlined @click="settingsDialog = true" />
          <Button
            :label="_('managerbuttons_group_remove')"
            icon="pi pi-trash"
            severity="danger"
            :disabled="!selected.length"
            @click="askRemove(selected)"
          />
        </div>
      </template>
      <template #end>
        <IconField>
          <InputIcon class="pi pi-search" />
          <InputText v-model="query" :placeholder="_('managerbuttons_search')" @input="onSearch" @keyup.enter="loadGroups" />
        </IconField>
      </template>
    </Toolbar>
    <DataTable
      v-model:selection="selected"
      :value="groups"
      dataKey="id"
      :loading="loading"
      stripedRows
      paginator
      :rows="20"
      :rowsPerPageOptions="[10, 20, 50]"
      :alwaysShowPaginator="false"
      reorderableRows
      @row-reorder="onReorder"
    >
      <Column selectionMode="multiple" headerStyle="width: 3rem" />
      <Column v-if="!query.trim()" rowReorder headerStyle="width: 3rem" />
      <Column field="name" :header="_('managerbuttons_name')" sortable />
      <Column :header="_('managerbuttons_usergroups')">
        <template #body="{ data }">
          <div style="display: flex; flex-wrap: wrap; gap: 0.35rem;">
            <template v-if="data.usergroup_names?.length">
              <Tag v-for="name in data.usergroup_names" :key="name" :value="name" />
            </template>
            <Tag v-else :value="_('managerbuttons_usergroups_empty')" severity="secondary" />
          </div>
        </template>
      </Column>
      <Column field="buttons_count" :header="_('managerbuttons_buttons_count')" style="width: 8rem" />
      <Column :header="_('managerbuttons_actions')" style="width: 14rem">
        <template #body="{ data }">
          <Button icon="pi pi-th-large" severity="secondary" text rounded :title="_('managerbuttons_buttons')" @click="openButtons(data)" />
          <Button icon="pi pi-pencil" severity="secondary" text rounded :title="_('managerbuttons_group_update')" @click="openEdit(data)" />
          <Button icon="pi pi-copy" severity="secondary" text rounded :title="_('managerbuttons_group_duplicate')" @click="duplicate(data)" />
          <Button icon="pi pi-download" severity="secondary" text rounded :title="_('managerbuttons_group_export')" @click="exportGroup(data)" />
          <Button icon="pi pi-trash" severity="danger" text rounded :title="_('managerbuttons_group_remove')" @click="askRemove(data)" />
        </template>
      </Column>
      <template #empty>{{ _('managerbuttons_empty') }}</template>
    </DataTable>
    <GroupDialog v-model:visible="groupDialog" :group="current" :user-groups="userGroups" @save="saveGroup" />
    <ButtonsDialog v-model:visible="buttonsDialog" :group="current" :icons="icons" :appearance="appearance" @changed="loadGroups" />
    <ImportDialog v-model:visible="importDialog" @import="importGroup" />
    <SettingsDialog v-model:visible="settingsDialog" :appearance="appearance" @save="saveAppearance" />
  </div>
</template>
