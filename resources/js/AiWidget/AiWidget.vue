<script setup>
import { ref, defineProps, onMounted, reactive, watch } from 'vue'
import MessageItem from './components/MessageItem.vue'
import ChatHeader from './components/ChatHeader.vue'
import ChatInput from './components/ChatInput.vue'
import TypingIndicator from './components/TypingIndicator.vue'
import StreamingMessage from './components/StreamingMessage.vue'

// Define props from Mingle
const props = defineProps({
    wire: Object,
    wireId: String,
    mingleData: Object
})

const isOpen = ref(false)
const isFullscreen = ref(false)
const isTyping = ref(false)
const streamingMessageId = ref(null)
const streamingUrl = ref('')

// Check if streaming is supported
const streamingSupported = ref(props.mingleData?.streamingSupported || false)

// Sample conversation history - in a real app, this would be dynamic
const messages = reactive([
    {
        id: 'welcome',
        sender: 'ai',
        content: 'Hello! I\'m your AI assistant powered by Prism. How can I help you today? 🌟',
        timestamp: new Date(Date.now() - 60000).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}),
        streaming: false
    }
])

// Toggle chat widget open/closed
const toggleWidget = () => {
    isOpen.value = !isOpen.value
    if (!isOpen.value) {
        isFullscreen.value = false
    }
}

// Toggle fullscreen mode
const toggleFullscreen = () => {
    isFullscreen.value = !isFullscreen.value
}

// Generate a unique ID for messages
const generateMessageId = () => {
    return 'msg_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9)
}

// Handle streaming completion
const handleStreamComplete = (content) => {
    if (streamingMessageId.value) {
        // Find the message and update its content
        const message = messages.find(m => m.id === streamingMessageId.value)
        if (message) {
            message.content = content
            message.streaming = false
        }
        streamingMessageId.value = null
        streamingUrl.value = ''
    }
}

// Handle streaming error
const handleStreamError = (error) => {
    console.error('Streaming error:', error)
    if (streamingMessageId.value) {
        // Find the message and update its content to show error
        const message = messages.find(m => m.id === streamingMessageId.value)
        if (message) {
            message.content = 'Sorry, I encountered an error while generating a response. Please try again.'
            message.streaming = false
            message.error = true
        }
        streamingMessageId.value = null
        streamingUrl.value = ''
    }
}

// Process a message from the user
const processMessage = (userMessage, useStreaming = false) => {
    // Add user message to chat
    const messageTimestamp = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})

    messages.push({
        id: generateMessageId(),
        sender: 'user',
        content: userMessage,
        timestamp: messageTimestamp
    })

    // Show AI is typing
    isTyping.value = true

    // Call the PHP backend via Mingle
    if (props.wire && typeof props.wire.processMessage === 'function') {
        // Use the Livewire component's processMessage method
        props.wire.processMessage(userMessage, useStreaming && streamingSupported.value)
            .then(response => {
                isTyping.value = false

                if (response.streaming && response.streamUrl) {
                    // Handle streaming response
                    const messageId = generateMessageId()
                    messages.push({
                        id: messageId,
                        sender: 'ai',
                        content: '',
                        timestamp: response.timestamp || messageTimestamp,
                        streaming: true,
                        streamUrl: response.streamUrl
                    })

                    streamingMessageId.value = messageId
                    streamingUrl.value = response.streamUrl
                } else {
                    // Handle regular response
                    messages.push({
                        id: generateMessageId(),
                        sender: 'ai',
                        content: response.content,
                        timestamp: response.timestamp || messageTimestamp,
                        error: response.error || false
                    })
                }

                scrollToBottom()
            })
            .catch(error => {
                console.error('Error processing message:', error)
                isTyping.value = false
                messages.push({
                    id: generateMessageId(),
                    sender: 'ai',
                    content: 'Sorry, I encountered an error processing your request. Please try again.',
                    timestamp: messageTimestamp,
                    error: true
                })
                scrollToBottom()
            })
    } else {
        // Fallback for when the wire connection isn't available
        setTimeout(() => {
            isTyping.value = false
            messages.push({
                id: generateMessageId(),
                sender: 'ai',
                content: `I received your message: "${userMessage}". How can I assist you further?`,
                timestamp: messageTimestamp
            })
            scrollToBottom()
        }, 1500)
    }
}

// Scroll to bottom of messages when new ones are added
const scrollToBottom = () => {
    const container = document.querySelector('.messages-container')
    if (container) {
        setTimeout(() => {
            container.scrollTop = container.scrollHeight
        }, 100)
    }
}

// Watch for changes in messages to scroll to bottom
watch(() => messages.length, () => {
    scrollToBottom()
})

// Watch for typing state changes
watch(() => isTyping.value, () => {
    scrollToBottom()
})

// Initialize
onMounted(() => {
    scrollToBottom()
})
</script>

<template>
    <div class="fixed bottom-4 right-4 z-50">
        <!-- Toggle Button -->
        <button
            v-if="!isOpen"
            @click="toggleWidget"
            class="flex items-center justify-center size-14 rounded-full bg-accent-content text-accent-foreground shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105"
            aria-label="Open AI Assistant"
        >
            <svg class="size-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-4l-4 4z" />
            </svg>
        </button>

        <!-- Chat Widget -->
        <div
            v-if="isOpen"
            :class="[
                'flex flex-col rounded-xl shadow-2xl overflow-hidden transition-all duration-300',
                isFullscreen ? 'fixed inset-4 w-auto h-auto' : 'w-[500px] max-w-full'
            ]"
            data-flux-modal
        >
            <!-- Header (fixed at top) -->
            <ChatHeader
                :is-fullscreen="isFullscreen"
                @toggle-fullscreen="toggleFullscreen"
                @close="toggleWidget"
            />

            <!-- Messages Container -->
            <div class="messages-container flex-1 overflow-y-auto bg-white dark:bg-zinc-800 p-5 space-y-6" style="height: calc(100vh - 200px); max-height: 500px;">
                <!-- Message items -->
                <template v-for="(message, index) in messages" :key="message.id || index">
                    <!-- Regular message -->
                    <div v-if="!message.streaming">
                        <MessageItem :message="message" />
                    </div>

                    <!-- Streaming message -->
                    <div v-else class="flex gap-4 items-start max-w-[90%]">
                        <div class="flex aspect-square size-10 shrink-0 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
                            <span class="text-sm font-medium">AI</span>
                        </div>
                        <div class="space-y-1">
                            <div class="bg-zinc-100 dark:bg-zinc-700/50 rounded-2xl rounded-tl-none p-4">
                                <p class="text-zinc-900 dark:text-zinc-100 text-base">
                                    <StreamingMessage
                                        :stream-url="message.streamUrl"
                                        @stream-complete="handleStreamComplete"
                                        @stream-error="handleStreamError"
                                    />
                                </p>
                            </div>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400 ml-2">{{ message.timestamp }}</span>
                        </div>
                    </div>
                </template>

                <!-- AI Typing Indicator -->
                <TypingIndicator v-if="isTyping" />
            </div>

            <!-- Input Area (fixed at bottom) -->
            <ChatInput @send-message="processMessage" />
        </div>
    </div>
</template>

<style scoped>
[data-flux-modal] {
    animation: modal-open 0.15s ease-out;
    display: flex;
    flex-direction: column;
    max-height: 100vh;
}

@keyframes modal-open {
    from {
        opacity: 0;
        transform: scale(0.95) translateY(10px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

/* Custom Scrollbar */
.messages-container {
    scrollbar-width: thin;
    scrollbar-color: var(--color-zinc-300) transparent;
    overflow-y: auto;
    flex: 1;
}

.messages-container::-webkit-scrollbar {
    width: 4px;
}

.messages-container::-webkit-scrollbar-track {
    background: transparent;
}

.messages-container::-webkit-scrollbar-thumb {
    background-color: var(--color-zinc-300);
    border-radius: 20px;
}

.dark .messages-container {
    scrollbar-color: var(--color-zinc-600) transparent;
}

.dark .messages-container::-webkit-scrollbar-thumb {
    background-color: var(--color-zinc-600);
}

/* Message transitions */
.messages-container > div {
    transition: all 0.3s ease;
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .w-\[500px\] {
        width: calc(100vw - 2rem) !important;
    }

    .fixed.inset-4 {
        inset: 0 !important;
        border-radius: 0 !important;
    }

    .messages-container {
        height: calc(100vh - 200px) !important;
    }

    .size-14 {
        width: 3rem !important;
        height: 3rem !important;
    }
}
</style>
