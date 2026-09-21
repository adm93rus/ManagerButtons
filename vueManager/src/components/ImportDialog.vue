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

function onFile(event) {
  const file = event.target.files?.[0]
  if (!file) return
  const reader = new FileReader()
  reader.onload = () => {
    payload.value = String(reader.result || '')
  }
  reader.readAsText(file)
}

function submit() {
  emit('import', payload.value)
}
</script>

<template>
  <Dialog v-model:visible="dialogVisible" modal :header="_('managerbuttons_import_title')" :style="{ width: '36rem' }">
    <p>{{ _('managerbuttons_import_help') }}</p>
    <div class="p-fluid" style="display: grid; gap: 0.75rem;">
      <input type="file" accept="application/json,.json" @change="onFile" />
      <Textarea v-model="payload" rows="12" autoResize />
    </div>
    <template #footer>
      <Button :label="_('managerbuttons_cancel')" severity="secondary" @click="dialogVisible = false" />
      <Button :label="_('managerbuttons_group_import')" severity="success" :disabled="!canImport" @click="submit" />
    </template>
  </Dialog>
</template>
