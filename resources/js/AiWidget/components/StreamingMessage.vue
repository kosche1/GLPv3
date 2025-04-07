<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  streamUrl: {
    type: String,
    required: true
  },
  initialContent: {
    type: String,
    default: ''
  }
})

const emit = defineEmits(['stream-complete', 'stream-error'])

const content = ref(props.initialContent)
const isComplete = ref(false)
const hasError = ref(false)
const eventSource = ref(null)

onMounted(() => {
  // Create EventSource for SSE connection
  eventSource.value = new EventSource(props.streamUrl)
  
  // Handle incoming messages
  eventSource.value.onmessage = (event) => {
    try {
      const data = JSON.parse(event.data)
      
      if (data.type === 'chunk') {
        // Append new content
        content.value += data.content
      } else if (data.type === 'end') {
        // Stream complete
        isComplete.value = true
        closeConnection()
        emit('stream-complete', content.value)
      } else if (data.type === 'error') {
        // Handle error
        hasError.value = true
        closeConnection()
        emit('stream-error', data.message || 'An error occurred')
      }
    } catch (error) {
      console.error('Error parsing SSE data:', error)
      hasError.value = true
      closeConnection()
      emit('stream-error', 'Failed to parse streaming data')
    }
  }
  
  // Handle errors
  eventSource.value.onerror = (error) => {
    console.error('SSE connection error:', error)
    hasError.value = true
    closeConnection()
    emit('stream-error', 'Connection error')
  }
})

// Close the connection when component is unmounted
onUnmounted(() => {
  closeConnection()
})

// Helper to close the SSE connection
const closeConnection = () => {
  if (eventSource.value) {
    eventSource.value.close()
    eventSource.value = null
  }
}
</script>

<template>
  <div class="streaming-message">
    <div v-if="hasError" class="text-red-500">
      Error: Failed to load streaming response
    </div>
    <div v-else>
      {{ content }}<span v-if="!isComplete" class="blinking-cursor">|</span>
    </div>
  </div>
</template>

<style scoped>
.blinking-cursor {
  animation: blink 1s step-end infinite;
}

@keyframes blink {
  from, to { opacity: 1; }
  50% { opacity: 0; }
}
</style>
