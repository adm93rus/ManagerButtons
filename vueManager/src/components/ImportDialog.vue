<script setup>
import { computed, ref, watch } from 'vue'
import { useLexicon } from '../composables/useLexicon.js'

const props = defineProps({
  visible: Boolean,
})
const emit = defineEmits(['update:visible', 'import'])
const { _ } = useLexicon()
const dialogVisible = ref(false)
const payload = ref('')

watch(
  () => props.visible,
  (v) => {
    dialogVisible.value = v
    if (v) payload.value = ''
  }
)
watch(dialogVisible, (v) => emit('update:visible', v))

const canImport = computed(() => payload.value.trim().length > 2)

function readFile(file) {
  if (!file) return
  const reader = new FileReader()
  reader.onload = () => {
    payload.value = String(reader.result || '')
  }
  reader.readAsText(file)
}

function onUpload(event) {
  readFile(event.files?.[0])
}

function submit() {
  emit('import', payload.value)
}
</script>

<template>
  <Dialog v-model:visible="dialogVisible" modal :header="_('managerbuttons_import_title')" :style="{ width: '40rem' }">
    <div style="display: grid; gap: 0.75rem;">
      <p style="margin: 0;">{{ _('managerbuttons_import_help') }}</p>
      <FileUpload
        mode="basic"
        accept="application/json,.json"
        customUpload
        auto
        :chooseLabel="_('managerbuttons_import_file')"
        @uploader="onUpload"
      />
      <Textarea v-model="payload" rows="12" autoResize fluid />
    </div>
    <template #footer>
      <Button :label="_('managerbuttons_cancel')" severity="secondary" text @click="dialogVisible = false" />
      <Button :label="_('managerbuttons_group_import')" icon="pi pi-upload" severity="success" :disabled="!canImport" @click="submit" />
    </template>
  </Dialog>
</template>
