<script setup>
import { onMounted, ref } from 'vue'
import GroupPreview from './GroupPreview.vue'
import { useLexicon } from '../composables/useLexicon.js'

const props = defineProps({
  payload: { type: Object, default: () => ({ groups: [] }) },
})
const { _ } = useLexicon()
const groups = ref(props.payload?.groups || [])

onMounted(() => {
  groups.value = props.payload?.groups || []
})
</script>

<template>
  <div class="managerbuttons-widget-root">
    <p v-if="!groups.length">{{ payload.emptyText || _('managerbuttons_widget_empty') }}</p>
    <GroupPreview v-else :groups="groups" :appearance="payload.appearance || {}" clickable />
  </div>
</template>
