<x-admin-layout>
    <x-slot:heading>
        Customer Details
    </x-slot:heading>

    <!-- Header with Back Button -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <a href="{{ route('admin.customers') }}"
                   class="text-gray-600 hover:text-gray-900 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h2 class="text-xl font-semibold text-gray-900">{{ $customer->name }}</h2>
                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $customer->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $customer->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <p class="text-gray-600">Customer since {{ $customer->created_at->format('F d, Y') }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.customers.edit', $customer->id) }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Customer
            </a>
            <form action="{{ route('admin.customers.toggle-status', $customer->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white {{ $customer->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} transition">
                    {{ $customer->is_active ? 'Deactivate' : 'Activate' }}
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
        <!-- Customer Information -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-xl">{{ substr($customer->name, 0, 2) }}</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900">{{ $customer->name }}</h4>
                            <p class="text-sm text-gray-500">Customer ID: {{ $customer->id }}</p>
                        </div>
                    </div>

                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="mailto:{{ $customer->email }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $customer->email }}
                                </a>
                            </dd>
                        </div>
                        @if($customer->phone)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="tel:{{ $customer->phone }}" class="text-blue-600 hover:text-blue-900">
                                        {{ $customer->phone }}
                                    </a>
                                </dd>
                            </div>
                        @endif
                        @if($customer->address)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Address</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $customer->address }}</dd>
                            </div>
                        @endif
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Account Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $customer->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $customer->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Joined Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $customer->created_at->format('F d, Y \a\t H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $customer->updated_at->format('F d, Y \a\t H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Orders -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Orders ({{ $customer->orders->count() }})</h3>
                </div>
                <div class="p-6">
                    @if($customer->orders->count() > 0)
                        <div class="space-y-4">
                            @foreach($customer->orders as $order)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-4">
                                                <h4 class="text-sm font-medium text-gray-900">Order #{{ $order->transaction_id }}</h4>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                                    @if($order->status === 'paid') bg-green-100 text-green-800
                                                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($order->status === 'confirmed') bg-green-100 text-green-800
                                                    @elseif($order->status === 'processing') bg-indigo-100 text-indigo-800
                                                    @elseif($order->status === 'completed') bg-emerald-100 text-emerald-800
                                                    @elseif($order->status === 'failed') bg-red-100 text-red-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>
                                            <div class="mt-2 text-sm text-gray-600">
                                                <div class="flex items-center space-x-4">
                                                    <span class="font-medium">৳{{ number_format($order->total_amount, 2) }}</span>
                                                    @if($order->products && is_array($order->products))
                                                        <span>{{ count($order->products) }} item(s)</span>
                                                    @endif
                                                    <span>{{ $order->created_at->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                            @if($order->products && is_array($order->products))
                                                <div class="mt-2">
                                                    <div class="text-xs text-gray-500">
                                                        @foreach(array_slice($order->products, 0, 2) as $product)
                                                            {{ $product['book_name'] ?? 'Unknown Book' }}@if(!$loop->last), @endif
                                                        @endforeach
                                                        @if(count($order->products) > 2)
                                                            and {{ count($order->products) - 2 }} more...
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <a href="{{ route('admin.orders.show', $order->id) }}"
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

                        <!-- Order Statistics -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-700 mb-4">Order Statistics</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="text-center">
                                    <div class="text-lg font-bold text-gray-900">{{ $customer->orders->count() }}</div>
                                    <div class="text-xs text-gray-500">Total Orders</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-green-600">{{ $customer->orders->where('status', 'completed')->count() }}</div>
                                    <div class="text-xs text-gray-500">Completed</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-yellow-600">{{ $customer->orders->whereIn('status', ['pending', 'paid', 'confirmed', 'processing'])->count() }}</div>
                                    <div class="text-xs text-gray-500">Active</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-blue-600">৳{{ number_format($customer->orders->where('status', '!=', 'failed')->sum('total_amount'), 2) }}</div>
                                    <div class="text-xs text-gray-500">Total Spent</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <p class="text-gray-500">No orders placed yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
