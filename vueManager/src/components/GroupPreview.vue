<script setup>
import { openManagerLink } from '../composables/links.js'

defineProps({
  groups: { type: Array, default: () => [] },
  clickable: { type: Boolean, default: false },
})

function spanStyle(cols) {
  const n = Math.min(4, Math.max(1, Number(cols) || 1))
  return { gridColumn: `span ${n}` }
}
</script>

<template>
  <div v-for="group in groups" :key="group.id || group.name" style="margin-bottom: 1.25rem;">
    <h3 v-if="group.name" style="margin: 0 0 0.75rem;">{{ group.name }}</h3>
    <div style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 0.75rem;">
      <div v-for="button in group.buttons" :key="button.id || button.name" :style="spanStyle(button.cols)">
        <Button
          type="button"
          style="width: 100%; justify-content: flex-start; gap: 0.6rem; white-space: normal; text-align: left;"
          @click="clickable && openManagerLink(button.url || button.raw_url)"
        >
          <i :class="button.icon_class || button.icon" />
          <span>{{ button.name }}</span>
        </Button>
      </div>
    </div>
  </div>
</template>
