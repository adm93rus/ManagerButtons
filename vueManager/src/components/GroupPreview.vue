<script setup>
import { openManagerLink } from '../composables/links.js'
import { buttonStyle } from '../composables/colors.js'

defineProps({
  groups: { type: Array, default: () => [] },
  clickable: { type: Boolean, default: false },
  appearance: { type: Object, default: () => ({}) },
})

function spanStyle(cols) {
  const n = Math.min(4, Math.max(1, Number(cols) || 1))
  return { gridColumn: `span ${n}`, display: 'flex', minWidth: 0 }
}
</script>

<template>
  <div v-for="group in groups" :key="group.id || group.name" style="margin-bottom: 1.25rem;">
    <h3 v-if="group.name" style="margin: 0 0 0.75rem;">{{ group.name }}</h3>
    <div style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 0.75rem;">
      <div v-for="button in group.buttons" :key="button.id || button.name" :style="spanStyle(button.cols)">
        <Button
          type="button"
          :style="{ ...buttonStyle(button, appearance), flex: '1 1 auto' }"
          @click="clickable && openManagerLink(button.url || button.raw_url)"
        >
          <i :class="button.icon_class || button.icon" />
          <span>{{ button.name }}</span>
          <span v-if="button.description" style="opacity: .7; font-size: .8em; grid-column: 2;">{{ button.description }}</span>
        </Button>
      </div>
    </div>
  </div>
</template>
