<x-admin-layout>
    <x-slot:heading>
        Manuscripts Management
    </x-slot:heading>

    <!-- Header with Stats -->
    <div class="mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Author Submissions</h2>
                <p class="text-gray-600">Review and manage manuscript submissions from authors</p>
            </div>
            <div class="grid grid-cols-3 gap-4 text-center">
                <div class="bg-yellow-50 p-3 rounded-lg">
                    <div class="text-2xl font-bold text-yellow-600">{{ $manuscripts->where('status', 'pending')->count() }}</div>
                    <div class="text-xs text-yellow-600">Pending</div>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600">{{ $manuscripts->where('status', 'under_review')->count() }}</div>
                    <div class="text-xs text-blue-600">Under Review</div>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <div class="text-2xl font-bold text-green-600">{{ $manuscripts->where('status', 'approved')->count() }}</div>
                    <div class="text-xs text-green-600">Ready to Publish</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="mb-6 bg-white p-4 rounded-lg shadow">
        <form method="GET" action="{{ route('admin.manuscripts.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="Title or author name..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Genre Filter -->
                <div>
                    <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
                    <select name="genre" id="genre" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Genres</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre }}" {{ request('genre') === $genre ? 'selected' : '' }}>
                                {{ $genre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                    <select name="sort" id="sort" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Submission Date</option>
                        <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title</option>
                        <option value="status" {{ request('sort') === 'status' ? 'selected' : '' }}>Status</option>
                        <option value="reviewed_at" {{ request('sort') === 'reviewed_at' ? 'selected' : '' }}>Review Date</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex space-x-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.manuscripts.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                        Clear Filters
                    </a>
                </div>

                <!-- Bulk Actions -->
                <div class="flex items-center space-x-2" x-data="{ showBulkActions: false, selectedCount: 0 }">
                    <div x-show="selectedCount > 0" x-transition class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600" x-text="`${selectedCount} selected`"></span>
                        <select id="bulk-action" class="px-3 py-1 text-sm border border-gray-300 rounded">
                            <option value="">Bulk Actions</option>
                            <option value="approve">Approve</option>
                            <option value="reject">Reject</option>
                            <option value="under_review">Mark Under Review</option>
                        </select>
                        <button type="button" onclick="performBulkAction()" class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                            Apply
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Status Filter Tabs -->
    <div class="mb-6">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.manuscripts.index') }}"
               class="px-4 py-2 rounded-lg text-sm font-medium transition {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                All ({{ $manuscripts->total() }})
            </a>
            @foreach($statuses as $status)
                <a href="{{ route('admin.manuscripts.index', array_merge(request()->query(), ['status' => $status])) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition {{ request('status') === $status ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    {{ ucwords(str_replace('_', ' ', $status)) }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Manuscripts Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($manuscripts->count() > 0)
            <form id="bulk-form" action="{{ route('admin.manuscripts.bulk-action') }}" method="POST">
                @csrf
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left">
                                    <input type="checkbox" id="select-all" class="rounded border-gray-300"
                                           onchange="toggleAllCheckboxes(this)">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Manuscript</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Genre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pages</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($manuscripts as $manuscript)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" name="manuscript_ids[]" value="{{ $manuscript->id }}"
                                               class="manuscript-checkbox rounded border-gray-300"
                                               onchange="updateSelectedCount()">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-start">
                                            @if($manuscript->cover_image)
                                                <img src="{{ asset('storage/' . $manuscript->cover_image) }}"
                                                     alt="Cover" class="w-12 h-16 object-cover rounded mr-3">
                                            @else
                                                <div class="w-12 h-16 bg-gray-200 rounded mr-3 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $manuscript->title }}</div>
                                                @if($manuscript->description)
                                                    <div class="text-sm text-gray-500 mt-1">{{ Str::limit($manuscript->description, 80) }}</div>
                                                @endif
                                                @if($manuscript->suggested_price)
                                                    <div class="text-sm text-green-600 mt-1">Suggested Price: ${{ number_format($manuscript->suggested_price, 2) }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-900">{{ $manuscript->author->name }}</div>
                                            <div class="text-gray-500">{{ $manuscript->author->email }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $manuscript->genre }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $manuscript->getStatusBadgeClass() }}">
                                            {{ $manuscript->formatted_status }}
                                        </span>
                                        @if($manuscript->reviewed_at && $manuscript->reviewer)
                                            <div class="text-xs text-gray-500 mt-1">
                                                Reviewed by {{ $manuscript->reviewer->name ?? 'Admin' }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <div>{{ $manuscript->created_at->format('M j, Y') }}</div>
                                        <div class="text-xs">{{ $manuscript->created_at->format('g:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $manuscript->pages ? number_format($manuscript->pages) : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.manuscripts.show', $manuscript->id) }}"
                                               class="text-blue-600 hover:text-blue-900 px-2 py-1 rounded">
                                                Review
                                            </a>
                                            @if($manuscript->manuscript_file)
                                                <a href="{{ asset('storage/' . $manuscript->manuscript_file) }}"
                                                   target="_blank"
                                                   class="text-green-600 hover:text-green-900 px-2 py-1 rounded">
                                                    Download
                                                </a>
                                            @endif
                                            @if($manuscript->isApproved())
                                                <button type="button"
                                                        onclick="showPublishModal({{ $manuscript->id }}, '{{ $manuscript->title }}')"
                                                        class="text-purple-600 hover:text-purple-900 px-2 py-1 rounded">
                                                    Publish
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>

            <!-- Pagination -->
            <div class="px-6 py-3 border-t border-gray-200">
                {{ $manuscripts->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No manuscripts found</h3>
                <p class="mt-1 text-sm text-gray-500">No manuscripts match your current filters.</p>
            </div>
        @endif
    </div>

    <!-- Publish Modal -->
    <div id="publish-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <form id="publish-form" method="POST">
                    @csrf
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Publish Manuscript</h3>
                        <p class="text-sm text-gray-600 mb-4">Ready to publish "<span id="manuscript-title"></span>" as a book?</p>

                        <div class="space-y-4">
                            <div>
                                <label for="book_price" class="block text-sm font-medium text-gray-700">Book Price ($)</label>
                                <input type="number" name="book_price" id="book_price" step="0.01" min="0" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="book_publisher" class="block text-sm font-medium text-gray-700">Publisher</label>
                                <input type="text" name="book_publisher" id="book_publisher" value="IMS Publishing House"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="book_cover_link" class="block text-sm font-medium text-gray-700">Cover Image URL (optional)</label>
                                <input type="url" name="book_cover_link" id="book_cover_link"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="book_isbn_10" class="block text-sm font-medium text-gray-700">ISBN-10 (optional)</label>
                                    <input type="text" name="book_isbn_10" id="book_isbn_10"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="book_isbn_13" class="block text-sm font-medium text-gray-700">ISBN-13 (optional)</label>
                                    <input type="text" name="book_isbn_13" id="book_isbn_13"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-3 bg-gray-50 flex justify-end space-x-2">
                        <button type="button" onclick="hidePublishModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-md hover:bg-purple-700">
                            Publish Book
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Action Modal -->
    <div id="bulk-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Bulk Action</h3>
                    <p class="text-sm text-gray-600 mb-4" id="bulk-action-text"></p>

                    <div>
                        <label for="bulk_notes" class="block text-sm font-medium text-gray-700">Notes (optional)</label>
                        <textarea name="bulk_notes" id="bulk_notes" rows="3"
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>

                <div class="px-6 py-3 bg-gray-50 flex justify-end space-x-2">
                    <button type="button" onclick="hideBulkModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="button" onclick="confirmBulkAction()"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedManuscripts = [];
        let currentBulkAction = '';

        function toggleAllCheckboxes(source) {
            const checkboxes = document.querySelectorAll('.manuscript-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = source.checked;
            });
            updateSelectedCount();
        }

        function updateSelectedCount() {
            const checkboxes = document.querySelectorAll('.manuscript-checkbox:checked');
            const count = checkboxes.length;

            // Update Alpine.js data
            document.querySelector('[x-data]').__x.$data.selectedCount = count;

            // Update select all checkbox
            const selectAll = document.getElementById('select-all');
            const totalCheckboxes = document.querySelectorAll('.manuscript-checkbox').length;
            selectAll.checked = count === totalCheckboxes && count > 0;
            selectAll.indeterminate = count > 0 && count < totalCheckboxes;
        }

        function performBulkAction() {
            const selectedCheckboxes = document.querySelectorAll('.manuscript-checkbox:checked');
            const bulkAction = document.getElementById('bulk-action').value;

            if (!bulkAction) {
                alert('Please select an action');
                return;
            }

            if (selectedCheckboxes.length === 0) {
                alert('Please select manuscripts to perform bulk action');
                return;
            }

            currentBulkAction = bulkAction;
            const actionText = bulkAction.replace('_', ' ');
            document.getElementById('bulk-action-text').textContent =
                `Are you sure you want to ${actionText} ${selectedCheckboxes.length} selected manuscript(s)?`;

            document.getElementById('bulk-modal').classList.remove('hidden');
        }

        function confirmBulkAction() {
            const selectedCheckboxes = document.querySelectorAll('.manuscript-checkbox:checked');
            const bulkNotes = document.getElementById('bulk_notes').value;

            // Add hidden inputs to the bulk form
            const form = document.getElementById('bulk-form');

            // Remove existing hidden inputs
            const existingInputs = form.querySelectorAll('input[name="bulk_action"], input[name="bulk_notes"]');
            existingInputs.forEach(input => input.remove());

            // Add new inputs
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'bulk_action';
            actionInput.value = currentBulkAction;
            form.appendChild(actionInput);

            const notesInput = document.createElement('input');
            notesInput.type = 'hidden';
            notesInput.name = 'bulk_notes';
            notesInput.value = bulkNotes;
            form.appendChild(notesInput);

            form.submit();
        }

        function hideBulkModal() {
            document.getElementById('bulk-modal').classList.add('hidden');
            document.getElementById('bulk_notes').value = '';
        }

        function showPublishModal(manuscriptId, title) {
            document.getElementById('manuscript-title').textContent = title;
            document.getElementById('publish-form').action = `/admin/manuscripts/${manuscriptId}/publish`;
            document.getElementById('publish-modal').classList.remove('hidden');
        }

        function hidePublishModal() {
            document.getElementById('publish-modal').classList.add('hidden');
            document.getElementById('publish-form').reset();
        }

        // Close modals when clicking outside
        document.addEventListener('click', function(event) {
            const publishModal = document.getElementById('publish-modal');
            const bulkModal = document.getElementById('bulk-modal');

            if (event.target === publishModal) {
                hidePublishModal();
            }

            if (event.target === bulkModal) {
                hideBulkModal();
            }
        });
    </script>
</x-admin-layout>
