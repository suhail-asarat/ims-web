<x-admin-layout>
    <x-slot:heading>
        Author Details
    </x-slot:heading>

    <!-- Header with Back Button -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <a href="{{ route('admin.authors') }}"
                   class="text-gray-600 hover:text-gray-900 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h2 class="text-xl font-semibold text-gray-900">{{ $author->name }}</h2>
                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $author->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $author->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <p class="text-gray-600">Author since {{ $author->created_at->format('F d, Y') }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.authors.edit', $author->id) }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Author
            </a>
            <form action="{{ route('admin.authors.toggle-status', $author->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white {{ $author->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} transition">
                    {{ $author->is_active ? 'Deactivate' : 'Activate' }}
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Author Information -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Author Information</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-xl">{{ substr($author->name, 0, 2) }}</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">{{ $author->name }}</h4>
                            <p class="text-sm text-gray-500">Author ID: {{ $author->id }}</p>
                        </div>
                    </div>

                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="mailto:{{ $author->email }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $author->email }}
                                </a>
                            </dd>
                        </div>
                        @if($author->phone)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="tel:{{ $author->phone }}" class="text-blue-600 hover:text-blue-900">
                                        {{ $author->phone }}
                                    </a>
                                </dd>
                            </div>
                        @endif
                        @if($author->website)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Website</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="{{ $author->website }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                        {{ $author->website }}
                                    </a>
                                </dd>
                            </div>
                        @endif
                        @if($author->bio)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Bio</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $author->bio }}</dd>
                            </div>
                        @endif
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Account Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $author->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $author->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Joined Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $author->created_at->format('F d, Y \a\t H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $author->updated_at->format('F d, Y \a\t H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Manuscripts -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Manuscripts ({{ $author->manuscripts->count() }})</h3>
                </div>
                <div class="p-6">
                    @if($author->manuscripts->count() > 0)
                        <div class="space-y-4">
                            @foreach($author->manuscripts as $manuscript)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-gray-900">{{ $manuscript->title }}</h4>
                                            <p class="text-sm text-gray-500 mt-1">{{ $manuscript->genre }}</p>
                                            @if($manuscript->description)
                                                <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ Str::limit($manuscript->description, 150) }}</p>
                                            @endif
                                            <div class="flex items-center space-x-4 mt-3 text-xs text-gray-500">
                                                @if($manuscript->pages)
                                                    <span>{{ $manuscript->pages }} pages</span>
                                                @endif
                                                <span>Submitted {{ $manuscript->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex items-center space-x-3">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                                @if($manuscript->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($manuscript->status === 'under_review') bg-blue-100 text-blue-800
                                                @elseif($manuscript->status === 'approved') bg-green-100 text-green-800
                                                @elseif($manuscript->status === 'published') bg-emerald-100 text-emerald-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $manuscript->status)) }}
                                            </span>
                                            <a href="{{ route('admin.manuscripts.show', $manuscript->id) }}"
                                               class="text-blue-600 hover:text-blue-900">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500">No manuscripts submitted yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
