<x-filament-panels::page>
    <x-filament::section>
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-medium tracking-tight">Communication & Feedback</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Manage communication with students and provide feedback on their work.</p>
            </div>
        </div>
    </x-filament::section>

    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-filament::section>
            <div class="space-y-4">
                <h3 class="text-base font-medium">Pending Reviews</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">View and assess student submissions that need your feedback.</p>

                <div class="mt-4">
                    <a href="{{ route('filament.teacher.resources.student-answers.index', ['status' => 'pending_manual_evaluation']) }}" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-warning-600 hover:bg-warning-500 focus:bg-warning-700 focus:ring-offset-warning-700">
                        <span class="flex items-center gap-1">
                            <x-heroicon-s-clipboard-document-check class="w-5 h-5" />
                            <span>View Pending Reviews ({{ \App\Models\StudentAnswer::where('status', 'pending_manual_evaluation')->count() }})</span>
                        </span>
                    </a>
                </div>
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="space-y-4">
                <h3 class="text-base font-medium">Feedback History</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Access previously provided feedback and student progress reports.</p>

                <div class="mt-4">
                    <a href="{{ route('filament.teacher.resources.student-answers.index', ['status' => 'evaluated']) }}" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-success-600 hover:bg-success-500 focus:bg-success-700 focus:ring-offset-success-700">
                        <span class="flex items-center gap-1">
                            <x-heroicon-s-check-circle class="w-5 h-5" />
                            <span>View Feedback History ({{ \App\Models\StudentAnswer::where('status', 'evaluated')->count() }})</span>
                        </span>
                    </a>
                </div>
            </div>
        </x-filament::section>
    </div>

    <div class="mt-6">
        <x-filament::section>
            <div class="space-y-4">
                <h3 class="text-base font-medium">Forum Discussions</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Manage and participate in forum discussions with students.</p>

                <div class="mt-4 grid grid-cols-1 gap-4">
                    <div class="rounded-lg border border-gray-300 dark:border-gray-700 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Forum Activity</p>
                                <p class="text-2xl font-semibold">{{ \App\Models\ForumTopic::count() + \App\Models\ForumComment::count() }}</p>
                            </div>
                            <div class="rounded-full bg-primary-100 dark:bg-primary-900/20 p-2">
                                <x-heroicon-o-chat-bubble-left-right class="h-5 w-5 text-primary-600 dark:text-primary-400" />
                            </div>
                        </div>
                    </div>

                    @php
                        $recentTopics = \App\Models\ForumTopic::with('user', 'category')
                            ->orderBy('created_at', 'desc')
                            ->take(3)
                            ->get();
                    @endphp

                    @if($recentTopics->count() > 0)
                        <div class="rounded-lg border border-gray-300 dark:border-gray-700 p-4">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Recent Topics</h4>
                            <div class="space-y-3">
                                @foreach($recentTopics as $topic)
                                    <div class="flex items-start gap-3 pb-3 {{ !$loop->last ? 'border-b border-gray-200 dark:border-gray-700' : '' }}">
                                        <div class="rounded-full bg-primary-100 dark:bg-primary-900/20 p-2 mt-1">
                                            <x-heroicon-o-chat-bubble-left class="h-4 w-4 text-primary-600 dark:text-primary-400" />
                                        </div>
                                        <div class="flex-1">
                                            <a href="{{ route('filament.admin.resources.forum-topics.edit', $topic) }}" class="text-sm font-medium text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400">{{ $topic->title }}</a>
                                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                <span>{{ $topic->user->name }}</span>
                                                <span class="mx-1">•</span>
                                                <span>{{ $topic->created_at->diffForHumans() }}</span>
                                                <span class="mx-1">•</span>
                                                <span>{{ $topic->comments_count }} {{ Str::plural('comment', $topic->comments_count) }}</span>
                                            </div>
                                            <div class="mt-2">
                                                <button type="button" x-data="{}" x-on:click="$dispatch('open-modal', { id: 'view-comments-{{ $topic->id }}' })" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-primary-700 bg-primary-100 hover:bg-primary-200 dark:text-primary-300 dark:bg-primary-900/30 dark:hover:bg-primary-900/50 transition">
                                                    <x-heroicon-s-chat-bubble-left-right class="-ml-0.5 mr-1 h-4 w-4" />
                                                    View Comments
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="mt-2">
                        <a href="{{ route('filament.admin.resources.forum-categories.index') }}" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">
                            <span class="flex items-center gap-1">
                                <x-heroicon-s-chat-bubble-left-right class="w-5 h-5" />
                                <span>Manage Forums</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </x-filament::section>
    </div>
    <!-- Comment Modals -->
    @foreach($recentTopics as $topic)
        <x-filament::modal id="view-comments-{{ $topic->id }}" width="md" alignment="center">
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-heroicon-o-chat-bubble-left-right class="h-5 w-5 text-primary-500" />
                    <span>Comments on: {{ $topic->title }}</span>
                </div>
            </x-slot>

            <div class="space-y-4 max-h-96 overflow-y-auto p-1">
                @php
                    $comments = \App\Models\ForumComment::where('forum_topic_id', $topic->id)
                        ->with('user')
                        ->orderBy('created_at', 'desc')
                        ->get();
                @endphp

                @if($comments->count() > 0)
                    @foreach($comments as $comment)
                        <div class="p-3 rounded-lg {{ $comment->parent_id ? 'ml-6 bg-gray-50 dark:bg-gray-800/50' : 'bg-white dark:bg-gray-800' }} border border-gray-200 dark:border-gray-700">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                                        <span class="text-xs font-medium text-primary-700 dark:text-primary-300">{{ substr($comment->user->name ?? 'User', 0, 2) }}</span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $comment->user->name ?? 'Unknown User' }}</p>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $comment->content }}
                                    </div>
                                    <div class="mt-2 flex items-center text-xs text-gray-500 dark:text-gray-400">
                                        <span>{{ $comment->likes_count }} {{ Str::plural('like', $comment->likes_count) }}</span>
                                        @if($comment->parent_id)
                                            <span class="mx-1">•</span>
                                            <span>Reply</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                        No comments yet.
                    </div>
                @endif
            </div>

            <x-slot name="footerActions">
                <x-filament::button
                    color="gray"
                    x-on:click="$dispatch('close-modal', { id: 'view-comments-{{ $topic->id }}' })"
                >
                    Close
                </x-filament::button>
            </x-slot>
        </x-filament::modal>
    @endforeach
</x-filament-panels::page>