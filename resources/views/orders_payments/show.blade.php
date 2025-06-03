@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Payment Order #{{ $ordersPayment->id }}</h1>
                            <p class="text-sm text-gray-500">Detailed view of payment order information</p>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0 flex items-center space-x-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($ordersPayment->status === 'completed') bg-green-100 text-green-800 
                            @elseif($ordersPayment->status === 'pending') bg-yellow-100 text-yellow-800 
                            @elseif($ordersPayment->status === 'failed') bg-red-100 text-red-800 
                            @else bg-gray-100 text-gray-800 @endif">
                            <div class="w-2 h-2 rounded-full mr-2
                                @if($ordersPayment->status === 'completed') bg-green-400 
                                @elseif($ordersPayment->status === 'pending') bg-yellow-400 
                                @elseif($ordersPayment->status === 'failed') bg-red-400 
                                @else bg-gray-400 @endif"></div>
                            {{ ucfirst($ordersPayment->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('orders-payments.edit', $ordersPayment->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Order
                    </a>
                    <button onclick="printOrder()" 
                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print
                    </button>
                    <button onclick="exportOrderData()" 
                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export
                    </button>
                    <a href="{{ route('orders-payments.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Order Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Details Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Order Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Order ID</label>
                                <div class="text-lg font-mono text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">#{{ $ordersPayment->id }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Total Amount</label>
                                <div class="text-lg font-bold text-green-600 bg-green-50 px-3 py-2 rounded-lg">${{ number_format($ordersPayment->total, 2) }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <div class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium
                                    @if($ordersPayment->status === 'completed') bg-green-100 text-green-800 border border-green-200
                                    @elseif($ordersPayment->status === 'pending') bg-yellow-100 text-yellow-800 border border-yellow-200
                                    @elseif($ordersPayment->status === 'failed') bg-red-100 text-red-800 border border-red-200
                                    @else bg-gray-100 text-gray-800 border border-gray-200 @endif">
                                    <div class="w-2 h-2 rounded-full mr-2
                                        @if($ordersPayment->status === 'completed') bg-green-400 
                                        @elseif($ordersPayment->status === 'pending') bg-yellow-400 
                                        @elseif($ordersPayment->status === 'failed') bg-red-400 
                                        @else bg-gray-400 @endif"></div>
                                    {{ ucfirst($ordersPayment->status) }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Created Date</label>
                                <div class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                                    {{ $ordersPayment->created_at->format('M d, Y') }}
                                    <span class="text-sm text-gray-500 ml-2">{{ $ordersPayment->created_at->format('H:i') }}</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                                <div class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                                    {{ $ordersPayment->updated_at->format('M d, Y') }}
                                    <span class="text-sm text-gray-500 ml-2">{{ $ordersPayment->updated_at->format('H:i') }}</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Time Since Creation</label>
                                <div class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $ordersPayment->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Timeline -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Payment Timeline
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="flow-root">
                            <ul class="-mb-8">
                                <li>
                                    <div class="relative pb-8">
                                        <div class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"></div>
                                        <div class="relative flex space-x-3">
                                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5">
                                                <div>
                                                    <p class="text-sm text-gray-500">Order created <span class="font-medium text-gray-900">{{ $ordersPayment->created_at->format('M d, Y \a\t H:i') }}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @if($ordersPayment->status === 'completed')
                                <li>
                                    <div class="relative pb-8">
                                        <div class="relative flex space-x-3">
                                            <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5">
                                                <div>
                                                    <p class="text-sm text-gray-500">Payment completed <span class="font-medium text-gray-900">{{ $ordersPayment->updated_at->format('M d, Y \a\t H:i') }}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @elseif($ordersPayment->status === 'pending')
                                <li>
                                    <div class="relative pb-8">
                                        <div class="relative flex space-x-3">
                                            <div class="h-8 w-8 rounded-full bg-yellow-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5">
                                                <div>
                                                    <p class="text-sm text-gray-500">Payment pending <span class="font-medium text-gray-900">Processing...</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @elseif($ordersPayment->status === 'failed')
                                <li>
                                    <div class="relative pb-8">
                                        <div class="relative flex space-x-3">
                                            <div class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5">
                                                <div>
                                                    <p class="text-sm text-gray-500">Payment failed <span class="font-medium text-gray-900">{{ $ordersPayment->updated_at->format('M d, Y \a\t H:i') }}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Customer Information -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Customer Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                <span class="text-indigo-600 font-semibold text-lg">{{ substr($ordersPayment->user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $ordersPayment->user->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $ordersPayment->user->email }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">User ID</span>
                                <span class="text-sm font-medium text-gray-900">#{{ $ordersPayment->user->id }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm text-gray-600">Member Since</span>
                                <span class="text-sm font-medium text-gray-900">{{ $ordersPayment->user->created_at->format('M Y') }}</span>
                            </div>
                            <div class="pt-3">
                                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">
                                    View Customer Profile →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Order Statistics
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-2xl font-bold text-gray-900">${{ number_format($ordersPayment->total, 2) }}</div>
                                <div class="text-sm text-gray-600">Order Total</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-2xl font-bold text-gray-900">{{ $ordersPayment->created_at->diffInDays(now()) }}</div>
                                <div class="text-sm text-gray-600">Days Since Created</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-2xl font-bold text-gray-900">{{ $ordersPayment->created_at->diffInHours(now()) }}</div>
                                <div class="text-sm text-gray-600">Hours Since Created</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            @if($ordersPayment->status === 'pending')
                            <button onclick="markAsCompleted()" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors duration-200">
                                Mark as Completed
                            </button>
                            <button onclick="markAsFailed()" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors duration-200">
                                Mark as Failed
                            </button>
                            @endif
                            <button onclick="duplicateOrder()" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                Duplicate Order
                            </button>
                            <button onclick="sendNotification()" class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                Send Notification
                            </button>
                            <button onclick="showDeleteModal()" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors duration-200">
                                Delete Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-2">Delete Payment Order</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete this payment order? This action cannot be undone.
                </p>
                <div class="bg-gray-50 rounded-lg p-3 mt-3">
                    <p class="text-sm text-gray-700"><strong>Order ID:</strong> #{{ $ordersPayment->id }}</p>
                    <p class="text-sm text-gray-700"><strong>Amount:</strong> ${{ number_format($ordersPayment->total, 2) }}</p>
                    <p class="text-sm text-gray-700"><strong>Status:</strong> {{ ucfirst($ordersPayment->status) }}</p>
                </div>
            </div>
            <div class="items-center px-4 py-3">
                <form method="POST" action="{{ route('orders-payments.destroy', $ordersPayment->id) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Delete
                    </button>
                </form>
                <button onclick="hideDeleteModal()" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function hideDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

function printOrder() {
    window.print();
}

function exportOrderData() {
    const orderData = {
        id: {{ $ordersPayment->id }},
        user: '{{ $ordersPayment->user->name }}',
        email: '{{ $ordersPayment->user->email }}',
        total: {{ $ordersPayment->total }},
        status: '{{ $ordersPayment->status }}',
        created_at: '{{ $ordersPayment->created_at->toISOString() }}',
        updated_at: '{{ $ordersPayment->updated_at->toISOString() }}'
    };
    
    const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(orderData, null, 2));
    const downloadAnchorNode = document.createElement('a');
    downloadAnchorNode.setAttribute("href", dataStr);
    downloadAnchorNode.setAttribute("download", "order_payment_{{ $ordersPayment->id }}.json");
    document.body.appendChild(downloadAnchorNode);
    downloadAnchorNode.click();
    downloadAnchorNode.remove();
}

function markAsCompleted() {
    if (confirm('Are you sure you want to mark this order as completed?')) {
        updateOrderStatus('completed');
    }
}

function markAsFailed() {
    if (confirm('Are you sure you want to mark this order as failed?')) {
        updateOrderStatus('failed');
    }
}

function updateOrderStatus(status) {
    fetch(`/orders-payments/{{ $ordersPayment->id }}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error updating status: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the status.');
    });
}

function duplicateOrder() {
    if (confirm('Create a new order with the same details?')) {
        window.location.href = '{{ route("orders-payments.create") }}?duplicate={{ $ordersPayment->id }}';
    }
}

function sendNotification() {
    if (confirm('Send notification to customer about this order?')) {
        fetch(`/orders-payments/{{ $ordersPayment->id }}/notify`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Notification sent successfully!');
            } else {
                alert('Error sending notification: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while sending the notification.');
        });
    }
}

// Auto-refresh for pending orders
@if($ordersPayment->status === 'pending')
setInterval(function() {
    fetch(window.location.href, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(data => {
        // Check if status has changed
        const parser = new DOMParser();
        const doc = parser.parseFromString(data, 'text/html');
        const newStatus = doc.querySelector('[data-order-status]');
        const currentStatus = document.querySelector('[data-order-status]');
        
        if (newStatus && currentStatus && newStatus.textContent !== currentStatus.textContent) {
            location.reload();
        }
    })
    .catch(error => console.error('Auto-refresh error:', error));
}, 30000); // Check every 30 seconds
@endif

// Add CSRF token meta tag if not already present
if (!document.querySelector('meta[name="csrf-token"]')) {
    const meta = document.createElement('meta');
    meta.name = 'csrf-token';
    meta.content = '{{ csrf_token() }}';
    document.getElementsByTagName('head')[0].appendChild(meta);
}
</script>
@endsection