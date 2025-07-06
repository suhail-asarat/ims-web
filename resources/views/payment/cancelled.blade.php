<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Cancelled - IMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 text-center">
            <!-- Warning Icon -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-6">
                <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>

            <!-- Cancelled Message -->
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Payment Cancelled</h2>
            <p class="text-gray-600 mb-6">You have cancelled the payment process. Your order has not been completed.</p>

            <!-- Information -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-yellow-800">
                    {{ session('info', 'No charges have been made to your account. Your items are still in your cart if you want to try again.') }}
                </p>
            </div>

            <!-- What happens next -->
            <div class="text-left mb-6">
                <h3 class="text-sm font-medium text-gray-500 mb-3">What happens next?</h3>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Your items remain in your cart</li>
                    <li>• No payment has been processed</li>
                    <li>• You can complete the purchase anytime</li>
                    <li>• Cart items may expire after 24 hours</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ route('cart.index') }}"
                   class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5H17M9 19v2m8-2v2" />
                    </svg>
                    Back to Cart
                </a>
                <a href="{{ url('/') }}"
                   class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                    Continue Shopping
                </a>
            </div>

            <!-- Support Info -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-xs text-gray-500">
                    Need help with your purchase? Contact us at
                    <a href="mailto:support@ims.com" class="text-blue-600 hover:text-blue-800">support@ims.com</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
