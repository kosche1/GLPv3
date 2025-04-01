<div class="flex items-center space-x-2">
    <textarea
        wire:model="message"
        wire:keydown.enter.prevent="sendMessage"
        placeholder="Type your message..."
        class="flex-1 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
        rows="1"
    ></textarea>
    <button
        wire:click="sendMessage"
        class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150"
    >
        Send
    </button>
</div> 