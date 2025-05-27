import { createApp } from 'vue'
import CodeEditor from './components/CodeEditor.vue'

// Import AiWidget to ensure it's included in the build
import './AiWidget/index.js'

// Import real-time functionality
import './realtime.js'

// Disabled old AutoLock in favor of Livewire component
// import AutoLock from './auto-lock.js'

const app = createApp({})
app.component('code-editor', CodeEditor)
app.mount('#app')

// Initialize auto-lock feature for all accounts
document.addEventListener('DOMContentLoaded', () => {
    // Get user role from meta tag (will be added to layout)
    const userRoleMeta = document.querySelector('meta[name="user-role"]');
    const userRole = userRoleMeta ? userRoleMeta.getAttribute('content') : 'student';

    console.log('User role detected:', userRole);

    // Auto-lock functionality is now handled by the Livewire SessionTimeout component
    console.log('Using Livewire SessionTimeout component for auto-lock functionality');
});
