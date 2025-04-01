<div class="flex flex-row">
    <div class="w-full">
        <div class="flex rounded-lg shadow-md border border-gray-300 dark:border-neutral-700 bg-white dark:bg-gray-900 overflow-hidden transition-all hover:border-primary-300 dark:hover:border-primary-700">
            <x-filament::icon-button
                icon="heroicon-o-trash"
                wire:click="resetConversation"
                label="Reset Conversation"
                color="danger"
                size="sm"
                class="m-0 my-auto ml-2 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
            />

            <form wire:submit.prevent="sendMessage" class="w-full dark:text-gray-200 grow">
                <input
                    type="text"
                    wire:model.live="messageInput"
                    placeholder="Type your message here..."
                    class="py-3 px-4 block w-full text-sm focus:ring-0 focus:border-primary-500 border-0 dark:bg-gray-900 dark:placeholder-gray-500 focus-visible:outline-hidden"
                    autofocus
                    autocomplete="off">
            </form>

            <x-filament::icon-button
                icon="heroicon-s-paper-airplane"
                label="Send Message"
                wire:click="sendMessage"
                color="primary"
                :disabled="!$messageInput || $disabled"
                size="sm"
                class="m-0 my-auto mr-2 disabled:opacity-50 transition-all"
            />
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 text-right pr-2">
            Press Enter to send
        </div>
    </div>
</div> 