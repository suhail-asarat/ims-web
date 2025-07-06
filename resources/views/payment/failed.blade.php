<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed - IMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 text-center">
            <!-- Error Icon -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>

            <!-- Error Message -->
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Payment Failed</h2>
            <p class="text-gray-600 mb-6">We're sorry, but your payment could not be processed at this time.</p>

            <!-- Error Details -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-red-800">
                    {{ session('error', 'The payment transaction was unsuccessful. Please try again or contact support if the issue persists.') }}
                </p>
            </div>

            <!-- Possible Reasons -->
            <div class="text-left mb-6">
                <h3 class="text-sm font-medium text-gray-500 mb-3">Common reasons for payment failure:</h3>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Insufficient funds in your account</li>
                    <li>• Incorrect card information</li>
                    <li>• Card expired or blocked</li>
                    <li>• Network connectivity issues</li>
                    <li>• Bank declined the transaction</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ route('cart.index') }}"
                   class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Try Again
                </a>
                <a href="{{ url('/') }}"
                   class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                    Continue Shopping
                </a>
            </div>

            <!-- Support Info -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-xs text-gray-500">
                    Need assistance? Contact our support team at
                    <a href="mailto:support@ims.com" class="text-blue-600 hover:text-blue-800">support@ims.com</a>
                    <br>
                    or call us at <a href="tel:+8801234567890" class="text-blue-600 hover:text-blue-800">+880 123-456-7890</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
