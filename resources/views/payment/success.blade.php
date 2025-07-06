<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - IMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 text-center">
            <!-- Success Icon -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <!-- Success Message -->
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Payment Successful!</h2>
            <p class="text-gray-600 mb-6">Your order has been confirmed and payment has been processed successfully.</p>

            <!-- Order Details -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-500">Order ID:</span>
                        <span class="text-gray-900 font-mono">{{ $order->transaction_id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-500">Amount Paid:</span>
                        <span class="text-gray-900 font-bold">৳{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-500">Status:</span>
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    @if($order->bank_tran_id)
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-500">Bank Trans. ID:</span>
                            <span class="text-gray-900 font-mono text-xs">{{ $order->bank_tran_id }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Items Summary -->
            @if($order->products && is_array($order->products))
                <div class="text-left mb-6">
                    <h3 class="text-sm font-medium text-gray-500 mb-3">Items Purchased:</h3>
                    <div class="space-y-2">
                        @foreach($order->products as $product)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-900">{{ $product['book_name'] ?? 'Unknown Book' }}</span>
                                <span class="text-gray-500">Qty: {{ $product['quantity'] ?? 1 }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="space-y-3">
                @if(Auth::guard('customer')->check())
                    <a href="{{ route('customer.orders') }}"
                       class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition">
                        View My Orders
                    </a>
                @endif
                <a href="{{ url('/') }}"
                   class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                    Continue Shopping
                </a>
            </div>

            <!-- Support Info -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-xs text-gray-500">
                    Need help? Contact us at
                    <a href="mailto:support@ims.com" class="text-blue-600 hover:text-blue-800">support@ims.com</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Auto-redirect script for logged-in customers -->
    @if(Auth::guard('customer')->check())
        <script>
            // Auto-redirect to orders page after 10 seconds
            setTimeout(function() {
                if (confirm('Would you like to view your order details?')) {
                    window.location.href = '{{ route("customer.orders") }}';
                }
            }, 10000);
        </script>
    @endif
</body>
</html>
