import { createApp } from 'vue'
import CodeEditor from './components/CodeEditor.vue'

// Import AiWidget to ensure it's included in the build
import './AiWidget/index.js'

const app = createApp({})
app.component('code-editor', CodeEditor)
app.mount('#app')
