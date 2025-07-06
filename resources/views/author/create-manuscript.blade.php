<x-author-layout>
    <x-slot:heading>
        Submit New Manuscript
    </x-slot:heading>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Submit Your Manuscript</h2>
                <p class="text-gray-600 mt-2">Fill out the form below to submit your manuscript for review. Our editorial team will review your submission and provide feedback.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('author.manuscripts.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Book Title *
                        </label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('title') }}"
                            required
                            placeholder="Enter your book title"
                        >
                    </div>

                    <!-- Genre -->
                    <div>
                        <label for="genre" class="block text-sm font-medium text-gray-700 mb-2">
                            Genre *
                        </label>
                        <select
                            id="genre"
                            name="genre"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                            <option value="">Select a genre</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre }}" {{ old('genre') === $genre ? 'selected' : '' }}>
                                    {{ $genre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Language -->
                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700 mb-2">
                            Language *
                        </label>
                        <select
                            id="language"
                            name="language"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                            <option value="English" {{ old('language', 'English') === 'English' ? 'selected' : '' }}>English</option>
                            <option value="Bengali" {{ old('language') === 'Bengali' ? 'selected' : '' }}>Bengali</option>
                            <option value="Hindi" {{ old('language') === 'Hindi' ? 'selected' : '' }}>Hindi</option>
                            <option value="Urdu" {{ old('language') === 'Urdu' ? 'selected' : '' }}>Urdu</option>
                        </select>
                    </div>

                    <!-- Pages -->
                    <div>
                        <label for="pages" class="block text-sm font-medium text-gray-700 mb-2">
                            Number of Pages
                        </label>
                        <input
                            type="number"
                            id="pages"
                            name="pages"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('pages') }}"
                            min="1"
                            max="10000"
                            placeholder="e.g., 250"
                        >
                    </div>

                    <!-- Suggested Price -->
                    <div>
                        <label for="suggested_price" class="block text-sm font-medium text-gray-700 mb-2">
                            Suggested Price (৳)
                        </label>
                        <input
                            type="number"
                            id="suggested_price"
                            name="suggested_price"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('suggested_price') }}"
                            step="0.01"
                            min="0"
                            placeholder="e.g., 500.00"
                        >
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Book Description *
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required
                        placeholder="Provide a detailed description of your book, including plot summary, target audience, and key themes..."
                    >{{ old('description') }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Maximum 2000 characters</p>
                </div>

                <!-- File Uploads -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Manuscript File -->
                    <div>
                        <label for="manuscript_file" class="block text-sm font-medium text-gray-700 mb-2">
                            Manuscript File
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="mt-4">
                                <label for="manuscript_file" class="cursor-pointer">
                                    <span class="mt-2 block text-sm font-medium text-gray-900">
                                        Upload manuscript file
                                    </span>
                                    <input id="manuscript_file" name="manuscript_file" type="file" class="sr-only" accept=".pdf,.doc,.docx">
                                </label>
                                <p class="mt-1 text-sm text-gray-500">PDF, DOC, DOCX up to 10MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Cover Image -->
                    <div>
                        <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                            Cover Image (Optional)
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="mt-4">
                                <label for="cover_image" class="cursor-pointer">
                                    <span class="mt-2 block text-sm font-medium text-gray-900">
                                        Upload cover design
                                    </span>
                                    <input id="cover_image" name="cover_image" type="file" class="sr-only" accept=".jpg,.jpeg,.png">
                                </label>
                                <p class="mt-1 text-sm text-gray-500">JPG, PNG up to 5MB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submission Guidelines -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-blue-800 mb-2">Submission Guidelines:</h3>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Ensure your manuscript is complete and thoroughly edited</li>
                        <li>• Provide an accurate and compelling description</li>
                        <li>• Our review process typically takes 5-10 business days</li>
                        <li>• You'll receive email notifications about status updates</li>
                        <li>• You can only edit manuscripts with "Pending" status</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('author.manuscripts') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                        ← Back to Manuscripts
                    </a>
                    <div class="flex space-x-3">
                        <button
                            type="button"
                            onclick="window.history.back()"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium"
                        >
                            Submit Manuscript
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // File upload preview functionality
        document.getElementById('manuscript_file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const label = e.target.parentNode.querySelector('span');
                label.textContent = file.name;
            }
        });

        document.getElementById('cover_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const label = e.target.parentNode.querySelector('span');
                label.textContent = file.name;
            }
        });
    </script>
</x-author-layout>
