<script setup>
// No props or emits needed for this component
</script>

<template>
  <div class="flex gap-4 items-start max-w-[90%]">
    <div class="flex aspect-square size-10 shrink-0 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
      <span class="text-sm font-medium">AI</span>
    </div>
    <div class="bg-zinc-100 dark:bg-zinc-700/50 rounded-2xl rounded-tl-none p-4">
      <div class="flex space-x-2">
        <div class="typing-dot"></div>
        <div class="typing-dot animation-delay-200"></div>
        <div class="typing-dot animation-delay-400"></div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.typing-dot {
  width: 8px;
  height: 8px;
  background-color: currentColor;
  border-radius: 50%;
  opacity: 0.6;
  animation: typing-dot 1.4s infinite both;
}

.animation-delay-200 {
  animation-delay: 0.2s;
}

.animation-delay-400 {
  animation-delay: 0.4s;
}

@keyframes typing-dot {
  0%, 80%, 100% { 
    transform: scale(0.6);
    opacity: 0.6;
  }
  40% { 
    transform: scale(1);
    opacity: 1;
  }
}
</style>
