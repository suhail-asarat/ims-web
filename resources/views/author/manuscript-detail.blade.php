<x-author-layout>
    <x-slot:heading>
        Manuscript Details
    </x-slot:heading>

    <!-- Manuscript Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex items-start justify-between">
            <div class="flex items-start space-x-4">
                @if($manuscript->cover_image)
                    <img src="{{ asset('storage/' . $manuscript->cover_image) }}"
                         alt="Cover"
                         class="w-24 h-32 object-cover rounded-lg shadow-sm">
                @else
                    <div class="w-24 h-32 bg-gray-200 rounded-lg shadow-sm flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                @endif

                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $manuscript->title }}</h1>

                    <div class="flex items-center space-x-4 mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $manuscript->genre }}
                        </span>

                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'under_review' => 'bg-blue-100 text-blue-800',
                                'approved' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                                'published' => 'bg-purple-100 text-purple-800',
                            ];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$manuscript->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst(str_replace('_', ' ', $manuscript->status)) }}
                        </span>

                        @if($manuscript->pages)
                            <span class="text-sm text-gray-500">{{ $manuscript->pages }} pages</span>
                        @endif
                    </div>

                    <p class="text-gray-600">{{ $manuscript->description }}</p>
                </div>
            </div>

            <div class="flex space-x-3">
                <a href="{{ route('author.manuscripts') }}"
                   class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition duration-200 inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to List
                </a>

                @if(in_array($manuscript->status, ['pending', 'rejected']))
                    <a href="{{ route('author.manuscripts.edit', $manuscript->id) }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Manuscript
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Manuscript Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>

            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Title</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $manuscript->title }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Genre</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $manuscript->genre }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500">Language</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $manuscript->language }}</dd>
                </div>

                @if($manuscript->pages)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Page Count</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $manuscript->pages }} pages</dd>
                    </div>
                @endif

                @if($manuscript->suggested_price)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Suggested Price</dt>
                        <dd class="text-sm text-gray-900 mt-1">${{ number_format($manuscript->suggested_price, 2) }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        <!-- Submission Details -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Submission Details</h3>

            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="text-sm text-gray-900 mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$manuscript->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst(str_replace('_', ' ', $manuscript->status)) }}
                        </span>
                    </dd>
                </div>

                @if($manuscript->submitted_at)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Submitted On</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $manuscript->submitted_at->format('F j, Y \a\t g:i A') }}</dd>
                    </div>
                @endif

                @if($manuscript->reviewed_at)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Reviewed On</dt>
                        <dd class="text-sm text-gray-900 mt-1">{{ $manuscript->reviewed_at->format('F j, Y \a\t g:i A') }}</dd>
                    </div>
                @endif

                <div>
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="text-sm text-gray-900 mt-1">{{ $manuscript->updated_at->format('F j, Y \a\t g:i A') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Description -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Description</h3>
        <div class="text-gray-700 leading-relaxed">
            {{ $manuscript->description }}
        </div>
    </div>

    <!-- Files Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Attached Files</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Manuscript File -->
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="text-sm font-medium text-gray-900">Manuscript File</h4>
                        @if($manuscript->manuscript_file)
                            <p class="text-sm text-gray-500">{{ basename($manuscript->manuscript_file) }}</p>
                            <a href="{{ asset('storage/' . $manuscript->manuscript_file) }}"
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Download File
                            </a>
                        @else
                            <p class="text-sm text-gray-500">No file uploaded</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Cover Image -->
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="text-sm font-medium text-gray-900">Cover Image</h4>
                        @if($manuscript->cover_image)
                            <p class="text-sm text-gray-500">{{ basename($manuscript->cover_image) }}</p>
                            <a href="{{ asset('storage/' . $manuscript->cover_image) }}"
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                View Image
                            </a>
                        @else
                            <p class="text-sm text-gray-500">No cover image uploaded</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Notes (if any) -->
    @if($manuscript->admin_notes)
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Review Notes
                </span>
            </h3>
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                <div class="text-blue-700">
                    {{ $manuscript->admin_notes }}
                </div>
            </div>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="flex justify-between items-center">
        <a href="{{ route('author.manuscripts') }}"
           class="bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition duration-200 inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to My Manuscripts
        </a>

        @if(in_array($manuscript->status, ['pending', 'rejected']))
            <div class="space-x-3">
                <a href="{{ route('author.manuscripts.edit', $manuscript->id) }}"
                   class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Manuscript
                </a>

                <button type="button"
                        onclick="if(confirm('Are you sure you want to delete this manuscript? This action cannot be undone.')) { document.getElementById('delete-form').submit(); }"
                        class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition duration-200 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete
                </button>

                <form id="delete-form" action="{{ route('author.manuscripts.delete', $manuscript->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        @endif
    </div>

</x-author-layout>
