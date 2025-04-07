<script setup>
import { ref } from 'vue'

const userInput = ref('')
const useStreaming = ref(true) // Default to streaming for better UX
const emit = defineEmits(['send-message'])

const sendMessage = () => {
  if (!userInput.value.trim()) return
  emit('send-message', userInput.value, useStreaming.value)
  userInput.value = ''
}

const handleKeydown = (event) => {
  if (event.key === 'Enter') {
    sendMessage()
  }
}

const toggleStreaming = () => {
  useStreaming.value = !useStreaming.value
}
</script>

<template>
  <div class="border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900 p-4 sticky bottom-0">
    <div class="relative">
      <input
        v-model="userInput"
        @keydown="handleKeydown"
        type="text"
        placeholder="Type your message..."
        class="w-full bg-white dark:bg-zinc-800 rounded-xl pl-12 pr-12 py-4 text-zinc-900 dark:text-zinc-100 placeholder-zinc-500 dark:placeholder-zinc-400 border border-zinc-200 dark:border-zinc-700 focus:outline-none focus:ring-2 focus:ring-accent text-base"
      >

      <div class="absolute left-3 top-1/2 -translate-y-1/2">
        <button
          @click="toggleStreaming"
          class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-full transition-colors"
          :title="useStreaming ? 'Streaming enabled' : 'Streaming disabled'"
        >
          <svg
            :class="['size-5', useStreaming ? 'text-accent-content' : 'text-zinc-500 dark:text-zinc-400']"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              v-if="useStreaming"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="1.5"
              d="M13 10V3L4 14h7v7l9-11h-7z"
            />
            <path
              v-else
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="1.5"
              d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"
            />
          </svg>
        </button>
      </div>

      <button
        @click="sendMessage"
        class="absolute right-3 top-1/2 -translate-y-1/2 bg-accent-content text-accent-foreground p-2 rounded-lg hover:opacity-90 transition-opacity"
      >
        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
        </svg>
      </button>
    </div>
    <div class="mt-2 flex justify-between items-center text-xs text-zinc-500 dark:text-zinc-400">
      <span>{{ useStreaming ? 'Streaming enabled' : 'Streaming disabled' }}</span>
      <span>Press Enter to send</span>
    </div>
  </div>
</template>
