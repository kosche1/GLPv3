<script setup>
defineProps({
  message: {
    type: Object,
    required: true
  }
})
</script>

<template>
  <!-- AI Message -->
  <div v-if="message.sender === 'ai'" class="flex gap-4 items-start max-w-[90%]">
    <div class="flex aspect-square size-10 shrink-0 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
      <span class="text-sm font-medium">DAF</span>
    </div>
    <div class="space-y-1">
      <div :class="[
        'rounded-2xl rounded-tl-none p-4',
        message.error ? 'bg-red-100 dark:bg-red-900/30' : 'bg-zinc-100 dark:bg-zinc-700/50'
      ]">
        <p :class="[
          'text-base',
          message.error ? 'text-red-700 dark:text-red-300' : 'text-zinc-900 dark:text-zinc-100'
        ]">
          {{ message.content }}
        </p>
      </div>
      <span class="text-xs text-zinc-500 dark:text-zinc-400 ml-2">{{ message.timestamp }}</span>
    </div>
  </div>

  <!-- User Message -->
  <div v-else class="flex gap-4 items-start justify-end ml-auto max-w-[90%]">
    <div class="space-y-1 text-right">
      <div class="bg-accent-content text-accent-foreground rounded-2xl rounded-tr-none p-4">
        <p class="text-base">{{ message.content }}</p>
      </div>
      <span class="text-xs text-zinc-500 dark:text-zinc-400 mr-2">{{ message.timestamp }}</span>
    </div>
    <div class="flex aspect-square size-10 shrink-0 items-center justify-center rounded-md bg-zinc-200 dark:bg-zinc-700">
      <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">ME</span>
    </div>
  </div>
</template>
