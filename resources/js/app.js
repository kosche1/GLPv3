import { createApp } from 'vue'
import CodeEditor from './components/CodeEditor.vue'

const app = createApp({})
app.component('code-editor', CodeEditor)
app.mount('#app')
