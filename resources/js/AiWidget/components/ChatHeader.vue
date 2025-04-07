<script setup>
defineProps({
  isFullscreen: {
    type: Boolean,
    default: false
  }
})

defineEmits(['toggle-fullscreen', 'close'])
</script>

<template>
  <div class="flex items-center justify-between p-4 bg-zinc-50 border-b border-zinc-200 dark:bg-zinc-900 dark:border-zinc-700 sticky top-0 z-10">
    <div class="flex items-center space-x-3">
      <div class="flex aspect-square size-10 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
        <span class="font-semibold text-accent-foreground">AI</span>
      </div>
      <div>
        <h3 class="font-semibold text-zinc-900 dark:text-zinc-100">AI Assistant</h3>
        <p class="text-sm text-zinc-500 dark:text-zinc-400">Always here to help</p>
      </div>
    </div>
    <div class="flex items-center space-x-2">
      <!-- Fullscreen toggle -->
      <button 
        @click="$emit('toggle-fullscreen')"
        class="rounded-full p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
        :aria-label="isFullscreen ? 'Exit fullscreen' : 'Enter fullscreen'"
      >
        <svg v-if="!isFullscreen" class="size-5 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 8V6a2 2 0 012-2h2M4 16v2a2 2 0 002 2h2m8-18h2a2 2 0 012 2v2m0 12v2a2 2 0 01-2 2h-2" />
        </svg>
        <svg v-else class="size-5 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      <!-- Close button -->
      <button 
        @click="$emit('close')"
        class="rounded-full p-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
      >
        <svg class="size-5 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
  </div>
</template>
