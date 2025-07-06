<x-author-layout>
    <x-slot:heading>
        Author Dashboard
    </x-slot:heading>

    <!-- Welcome Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Welcome back, {{ $author->name }}!</h2>
                <p class="text-gray-600 mt-1">Manage your manuscripts and track their publication status</p>
                @if($author->bio)
                    <p class="text-sm text-gray-500 mt-2">{{ Str::limit($author->bio, 100) }}</p>
                @endif
            </div>
            <div class="text-right">
                <a href="{{ route('author.manuscripts.create') }}"
                   class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Submit New Manuscript
                </a>
            </div>
        </div>
    </div>

    <!-- Notifications Section -->
    @if($recentlyReviewedManuscripts->count() > 0 || $manuscriptsNeedingAttention->count() > 0)
        <div class="mb-8 space-y-4">
            <!-- Recent Review Updates -->
            @if($recentlyReviewedManuscripts->count() > 0)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-lg font-medium text-blue-900">
                                📬 Recent Review Updates
                            </h3>
                            <p class="mt-1 text-sm text-blue-700">
                                You have {{ $recentlyReviewedManuscripts->count() }} manuscript(s) with recent review updates.
                            </p>
                            <div class="mt-3 space-y-2">
                                @foreach($recentlyReviewedManuscripts->take(3) as $manuscript)
                                    <div class="flex items-center justify-between bg-white p-3 rounded border">
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-900">{{ $manuscript->title }}</div>
                                            <div class="flex items-center mt-1">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $manuscript->getStatusBadgeClass() }}">
                                                    {{ $manuscript->formatted_status }}
                                                </span>
                                                <span class="ml-2 text-xs text-gray-500">
                                                    Reviewed {{ $manuscript->reviewed_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            @if($manuscript->admin_notes)
                                                <div class="mt-1 text-sm text-gray-600">{{ Str::limit($manuscript->admin_notes, 100) }}</div>
                                            @endif
                                        </div>
                                        <a href="{{ route('author.manuscripts.show', $manuscript->id) }}"
                                           class="ml-4 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            View Details →
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            @if($recentlyReviewedManuscripts->count() > 3)
                                <div class="mt-3">
                                    <a href="{{ route('author.manuscripts') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                        View all updates →
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Manuscripts Needing Attention -->
            @if($manuscriptsNeedingAttention->count() > 0)
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.314 14.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-lg font-medium text-amber-900">
                                ⚠️ Action Required
                            </h3>
                            <p class="mt-1 text-sm text-amber-700">
                                {{ $manuscriptsNeedingAttention->count() }} manuscript(s) need your attention.
                            </p>
                            <div class="mt-3 space-y-2">
                                @foreach($manuscriptsNeedingAttention as $manuscript)
                                    <div class="flex items-center justify-between bg-white p-3 rounded border">
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-900">{{ $manuscript->title }}</div>
                                            <div class="flex items-center mt-1">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $manuscript->getStatusBadgeClass() }}">
                                                    {{ $manuscript->formatted_status }}
                                                </span>
                                                @if($manuscript->status === 'rejected')
                                                    <span class="ml-2 text-xs text-red-600 font-medium">Rejected - Review Feedback</span>
                                                @elseif($manuscript->status === 'under_review')
                                                    <span class="ml-2 text-xs text-amber-600 font-medium">Changes Requested</span>
                                                @endif
                                            </div>
                                            @if($manuscript->admin_notes)
                                                <div class="mt-1 text-sm text-gray-600">{{ Str::limit($manuscript->admin_notes, 100) }}</div>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex space-x-2">
                                            <a href="{{ route('author.manuscripts.show', $manuscript->id) }}"
                                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                View
                                            </a>
                                            @if(in_array($manuscript->status, ['rejected', 'under_review']))
                                                <a href="{{ route('author.manuscripts.edit', $manuscript->id) }}"
                                                   class="text-green-600 hover:text-green-800 text-sm font-medium">
                                                    Edit
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6 mb-8">
        <!-- Total Manuscripts -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Manuscripts -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                </div>
            </div>
        </div>

        <!-- Under Review -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Under Review</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['under_review'] }}</p>
                </div>
            </div>
        </div>

        <!-- Approved -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Approved</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['approved'] }}</p>
                </div>
            </div>
        </div>

        <!-- Rejected -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Rejected</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['rejected'] }}</p>
                </div>
            </div>
        </div>

        <!-- Published -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Published</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['published'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Pending Actions -->
        @if($pendingManuscripts->count() > 0)
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Pending Review</h3>
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $pendingManuscripts->count() }} waiting
                    </span>
                </div>
                <p class="text-gray-600 text-sm mb-4">These manuscripts are waiting for admin review.</p>
                <div class="space-y-3">
                    @foreach($pendingManuscripts->take(3) as $manuscript)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900 text-sm">{{ $manuscript->title }}</p>
                                <p class="text-xs text-gray-500">Submitted {{ $manuscript->submitted_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('author.manuscripts.show', $manuscript->id) }}"
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                View
                            </a>
                        </div>
                    @endforeach
                </div>
                @if($pendingManuscripts->count() > 3)
                    <div class="mt-4 text-center">
                        <a href="{{ route('author.manuscripts') }}"
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            View all pending manuscripts
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <!-- Rejected - Needs Action -->
        @if($rejectedManuscripts->count() > 0)
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Needs Revision</h3>
                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $rejectedManuscripts->count() }} rejected
                    </span>
                </div>
                <p class="text-gray-600 text-sm mb-4">These manuscripts need revision before resubmission.</p>
                <div class="space-y-3">
                    @foreach($rejectedManuscripts->take(3) as $manuscript)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900 text-sm">{{ $manuscript->title }}</p>
                                <p class="text-xs text-gray-500">Rejected {{ $manuscript->reviewed_at ? $manuscript->reviewed_at->diffForHumans() : 'recently' }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('author.manuscripts.edit', $manuscript->id) }}"
                                   class="text-green-600 hover:text-green-800 text-sm font-medium">
                                    Edit
                                </a>
                                <a href="{{ route('author.manuscripts.show', $manuscript->id) }}"
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($rejectedManuscripts->count() > 3)
                    <div class="mt-4 text-center">
                        <a href="{{ route('author.manuscripts') }}"
                           class="text-red-600 hover:text-red-800 text-sm font-medium">
                            View all rejected manuscripts
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <!-- Published Success -->
        @if($stats['published'] > 0)
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Published Works</h3>
                    <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $stats['published'] }} live
                    </span>
                </div>
                <p class="text-gray-600 text-sm mb-4">Congratulations! Your published manuscripts are now available to readers.</p>
                <div class="space-y-3">
                    @foreach($manuscripts->where('status', 'published')->take(3) as $manuscript)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900 text-sm">{{ $manuscript->title }}</p>
                                <p class="text-xs text-gray-500">Published {{ $manuscript->reviewed_at ? $manuscript->reviewed_at->diffForHumans() : 'recently' }}</p>
                            </div>
                            <a href="{{ route('author.manuscripts.show', $manuscript->id) }}"
                               class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                View
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Getting Started (if no manuscripts) -->
        @if($stats['total'] == 0)
            <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg shadow p-6 lg:col-span-2">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 mb-4">
                        <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Welcome to Your Author Portal</h3>
                    <p class="text-gray-600 mb-6">Ready to share your story with the world? Start by submitting your first manuscript for review.</p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('author.manuscripts.create') }}"
                           class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Submit Your First Manuscript
                        </a>
                        <a href="{{ route('author.manuscripts') }}"
                           class="bg-white text-blue-600 border border-blue-600 px-6 py-3 rounded-lg hover:bg-blue-50 transition duration-200 inline-flex items-center justify-center">
                            View Guidelines
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Recent Manuscripts -->
    @if($recentManuscripts->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Recent Manuscripts</h3>
                    <a href="{{ route('author.manuscripts') }}"
                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View All
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Manuscript</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Genre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentManuscripts as $manuscript)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($manuscript->cover_image)
                                            <img src="{{ asset('storage/' . $manuscript->cover_image) }}"
                                                 alt="Cover"
                                                 class="w-10 h-12 object-cover rounded mr-3 flex-shrink-0">
                                        @else
                                            <div class="w-10 h-12 bg-gray-200 rounded mr-3 flex-shrink-0 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $manuscript->title }}</p>
                                            <p class="text-sm text-gray-500 truncate">{{ Str::limit($manuscript->description, 60) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $manuscript->genre }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $manuscript->getStatusBadgeClass() }}">
                                        {{ $manuscript->formatted_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $manuscript->submitted_at ? $manuscript->submitted_at->format('M d, Y') : 'Draft' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('author.manuscripts.show', $manuscript->id) }}"
                                           class="text-blue-600 hover:text-blue-900 transition duration-200">
                                            View
                                        </a>
                                        @if(in_array($manuscript->status, ['pending', 'rejected']))
                                            <a href="{{ route('author.manuscripts.edit', $manuscript->id) }}"
                                               class="text-green-600 hover:text-green-900 transition duration-200">
                                                Edit
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Author Profile Summary -->
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Author Profile</h3>
            <a href="{{ route('author.profile') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                Edit Profile
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="text-sm text-gray-900">{{ $author->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="text-sm text-gray-900">{{ $author->email }}</dd>
                    </div>
                    @if($author->phone)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone</dt>
                            <dd class="text-sm text-gray-900">{{ $author->phone }}</dd>
                        </div>
                    @endif
                    @if($author->website)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Website</dt>
                            <dd class="text-sm text-blue-600">
                                <a href="{{ $author->website }}" target="_blank" class="hover:text-blue-800">
                                    {{ $author->website }}
                                </a>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
            @if($author->bio)
                <div>
                    <dt class="text-sm font-medium text-gray-500 mb-2">Biography</dt>
                    <dd class="text-sm text-gray-900">{{ $author->bio }}</dd>
                </div>
            @endif
        </div>
    </div>

</x-author-layout>
