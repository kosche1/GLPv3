<x-layouts.app>
    <div class="flex h-full w-full flex-1 flex-col gap-6 text-gray-100 p-6 border border-emerald-500 rounded-lg">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">{{ __('Learning Materials') }}</h1>
            </div>

            <!-- Search and Filter Section -->
            <div class="flex flex-col md:flex-row items-center gap-4">
                <!-- Search Input -->
                <div class="relative w-full md:w-auto">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" id="material-search" placeholder="Search materials..."
                        class="w-full md:min-w-[250px] rounded-lg border border-neutral-700 bg-neutral-800/80 pl-10 pr-4 py-2.5 text-sm text-white placeholder-neutral-400 focus:border-emerald-500/50 focus:outline-hidden focus:ring-1 focus:ring-emerald-500/30 transition-all duration-300 hover:border-neutral-600">
                </div>

                <!-- Filter Dropdown -->
                <div class="w-full md:w-auto">
                    <div class="relative">
                        <select id="material-type-filter" class="w-full rounded-lg border border-neutral-700 bg-neutral-800/80 px-4 py-2.5 text-sm text-white appearance-none focus:border-emerald-500/50 focus:outline-hidden focus:ring-1 focus:ring-emerald-500/30 transition-all duration-300 hover:border-neutral-600">
                            <option value="all">All Materials</option>
                            <option value="pdf">PDF</option>
                            <option value="doc">Documents</option>
                            <option value="video">Videos</option>
                            <option value="ppt">Presentations</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Sort Dropdown -->
                <div class="w-full md:w-auto">
                    <div class="relative">
                        <select id="material-sort" class="w-full rounded-lg border border-neutral-700/50 bg-neutral-800/50 px-4 py-2.5 text-sm text-white appearance-none focus:border-emerald-500/50 focus:ring-1 focus:ring-emerald-500/30 focus:outline-hidden transition-all duration-300 hover:border-neutral-600">
                            <option value="newest">Newest</option>
                            <option value="oldest">Oldest</option>
                            <option value="name-asc">Name (A-Z)</option>
                            <option value="name-desc">Name (Z-A)</option>
                            <option value="size-asc">Size (Small to Large)</option>
                            <option value="size-desc">Size (Large to Small)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Material Categories -->
        <div class="flex flex-wrap gap-2 py-2">
            <button class="bg-emerald-500/10 text-emerald-400 px-4 py-1.5 rounded-full text-sm font-medium border border-emerald-500/20 hover:bg-emerald-500/20 transition-all duration-300">All</button>
            <button class="bg-neutral-800 text-neutral-300 px-4 py-1.5 rounded-full text-sm font-medium border border-neutral-700 hover:bg-neutral-700/50 hover:text-white transition-all duration-300">PDF</button>
            <button class="bg-neutral-800 text-neutral-300 px-4 py-1.5 rounded-full text-sm font-medium border border-neutral-700 hover:bg-neutral-700/50 hover:text-white transition-all duration-300">Video</button>
            <button class="bg-neutral-800 text-neutral-300 px-4 py-1.5 rounded-full text-sm font-medium border border-neutral-700 hover:bg-neutral-700/50 hover:text-white transition-all duration-300">Document</button>
            <button class="bg-neutral-800 text-neutral-300 px-4 py-1.5 rounded-full text-sm font-medium border border-neutral-700 hover:bg-neutral-700/50 hover:text-white transition-all duration-300">Presentation</button>
        </div>

        <!-- Results Header -->
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <h2 class="text-xl font-semibold text-white">Available Materials</h2>
                <span class="bg-emerald-500/10 text-emerald-400 px-2.5 py-1 rounded-full text-xs font-medium">
                    {{ $materials->count() }} results
                </span>
            </div>
        </div>

        <!-- Learning Materials Grid -->
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
            @if($materials->count() > 0)
                @foreach($materials as $material)
                <div class="group bg-linear-to-br from-neutral-800 to-neutral-900 rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:scale-[1.02] border border-neutral-700 hover:border-emerald-500/30 hover:shadow-emerald-900/20">
                    <div class="relative h-40 overflow-hidden bg-neutral-700">
                        @php
                            // Get the file extension from the file_path instead of file_name
                            $extension = strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION));

                            // If extension is empty or not recognized, try to determine from file_name
                            if (empty($extension) || $extension === 'tmp') {
                                $extension = strtolower(pathinfo($material->file_name, PATHINFO_EXTENSION));

                                // If still not recognized, try to determine from file_type
                                if (empty($extension) || $extension === 'tmp') {
                                    // Map MIME types to extensions
                                    $mimeToExt = [
                                        'application/pdf' => 'pdf',
                                        'application/msword' => 'doc',
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
                                        'application/vnd.ms-excel' => 'xls',
                                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
                                        'application/vnd.ms-powerpoint' => 'ppt',
                                        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
                                        'video/mp4' => 'mp4',
                                        'video/x-msvideo' => 'avi',
                                        'video/quicktime' => 'mov'
                                    ];

                                    if (isset($mimeToExt[$material->file_type])) {
                                        $extension = $mimeToExt[$material->file_type];
                                    } else {
                                        // If we still can't determine the extension, use a default value
                                        $extension = 'file'; // Generic file type instead of 'tmp'
                                    }
                                }
                            }

                            $iconClass = 'text-emerald-400';
                            $bgClass = 'bg-emerald-500/10';

                            if (in_array($extension, ['pdf'])) {
                                $iconClass = 'text-red-400';
                                $bgClass = 'bg-red-500/10';
                            } elseif (in_array($extension, ['doc', 'docx'])) {
                                $iconClass = 'text-blue-400';
                                $bgClass = 'bg-blue-500/10';
                            } elseif (in_array($extension, ['xls', 'xlsx'])) {
                                $iconClass = 'text-green-400';
                                $bgClass = 'bg-green-500/10';
                            } elseif (in_array($extension, ['ppt', 'pptx'])) {
                                $iconClass = 'text-amber-400';
                                $bgClass = 'bg-amber-500/10';
                            } elseif (in_array($extension, ['mp4', 'avi', 'mov'])) {
                                $iconClass = 'text-purple-400';
                                $bgClass = 'bg-purple-500/10';
                            }
                        @endphp

                        <div class="absolute inset-0 flex items-center justify-center {{ $bgClass }}">
                            @if(in_array($extension, ['pdf']))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 {{ $iconClass }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            @elseif(in_array($extension, ['doc', 'docx']))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 {{ $iconClass }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            @elseif(in_array($extension, ['mp4', 'avi', 'mov']))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 {{ $iconClass }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 {{ $iconClass }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            @endif
                        </div>

                        <!-- File Type Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="rounded-full {{ $bgClass }} px-3 py-1 text-xs font-medium {{ $iconClass }} border border-{{ explode('-', $iconClass)[1] }}-500/20">
                                {{ strtoupper($extension) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5">
                        <h3 class="mb-2 text-lg font-semibold text-white group-hover:text-emerald-400 transition-colors duration-300">{{ $material->title }}</h3>
                        <p class="mb-4 text-sm text-neutral-400">{{ Str::limit($material->description, 80, '...') }}</p>

                        <!-- File Info -->
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="flex items-center gap-1.5 text-xs text-neutral-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $material->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-xs text-neutral-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                </svg>
                                <span>{{ number_format($material->file_size / 1024 / 1024, 1) }} MB</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-neutral-700">
                            <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm font-medium text-emerald-400 hover:text-emerald-300 transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <span>Preview</span>
                            </a>
                            <a href="{{ asset('storage/' . $material->file_path) }}" download class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-500 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-neutral-800 transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                <span>Download</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-span-full flex flex-col items-center justify-center p-10 text-center bg-neutral-800/50 rounded-xl border border-neutral-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-neutral-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-white mb-2">No Learning Materials Available</h3>
                    <p class="text-neutral-400 text-center mb-6">There are currently no learning materials in this category.</p>
                    {{-- <button class="flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        <span>Upload Materials</span>
                    </button> --}}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>