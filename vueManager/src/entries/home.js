import {
  Button,
  ColorPicker,
  Column,
  ConfirmDialog,
  DataTable,
  Dialog,
  Fieldset,
  FileUpload,
  IconField,
  InputIcon,
  InputText,
  MultiSelect,
  Panel,
  SelectButton,
  Tag,
  Textarea,
  Toast,
  Toolbar,
} from 'primevue'
import { createManagerButtonsApp } from '../app/createApp.js'
import App from '../components/App.vue'

const components = {
  Button,
  ColorPicker,
  Column,
  ConfirmDialog,
  DataTable,
  Dialog,
  Fieldset,
  FileUpload,
  IconField,
  InputIcon,
  InputText,
  MultiSelect,
  Panel,
  SelectButton,
  Tag,
  Textarea,
  Toast,
  Toolbar,
}

const el = document.getElementById('managerbuttons-app')
if (el && !el.dataset.vApp) {
  const app = createManagerButtonsApp(App, {}, components)
  app.mount(el)
  el.dataset.vApp = 'true'
}
