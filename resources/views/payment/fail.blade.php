<x-layout>
    <x-slot:heading>
        Payment Failed
    </x-slot:heading>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <!-- Fail Icon -->
            <div class="mb-6">
                <div class="mx-auto w-20 h-20 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-red-600 mb-4">Payment Failed!</h2>
            <p class="text-gray-600 mb-6">Unfortunately, your payment could not be processed. Please try again.</p>

            <!-- Order Details -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Transaction Details</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Transaction ID:</span>
                        <span class="font-medium">{{ $order_details->transaction_id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Amount:</span>
                        <span class="font-medium">{{ $order_details->formatted_amount }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="font-medium text-red-600">Failed</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-4">
                <a href="{{ route('cart.index') }}"
                   class="w-full bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-blue-700 font-semibold transition duration-200 inline-block">
                    Return to Cart
                </a>
                <a href="/books"
                   class="w-full bg-gray-600 text-white py-3 px-6 rounded-md hover:bg-gray-700 font-semibold transition duration-200 inline-block">
                    Continue Shopping
                </a>
            </div>

            <!-- Help Section -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <p class="text-sm text-blue-800">
                    <strong>Need Help?</strong> If you continue to experience issues, please contact our customer support.
                </p>
            </div>
        </div>
    </div>
</x-layout>
