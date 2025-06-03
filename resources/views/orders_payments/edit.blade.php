@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Edit Payment Order #{{ $ordersPayment->id }}</h1>
                            <p class="text-sm text-gray-500">Modify payment order details and status</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
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
                            Current: {{ ucfirst($ordersPayment->status) }}
                        </span>
                        <a href="{{ route('orders-payments.show', $ordersPayment->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            View Order
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Warning Banner -->
            <div class="px-6 py-3 bg-amber-50 border-b border-amber-200">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <span class="text-sm font-medium text-amber-800">
                        Caution: Modifying payment orders may affect financial records and customer notifications
                    </span>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <form action="{{ route('orders-payments.update', $ordersPayment->id) }}" method="POST" id="editOrderForm" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Original vs New Values Comparison -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Original vs Modified Values
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Compare original and new values before saving changes</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Original Values -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Original Values
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-xs text-gray-500">Customer</span>
                                    <div class="text-sm font-medium text-gray-900">{{ $ordersPayment->user->name }}</div>
                                    <div class="text-xs text-gray-600">{{ $ordersPayment->user->email }}</div>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">Total Amount</span>
                                    <div class="text-sm font-medium text-gray-900">${{ number_format($ordersPayment->total, 2) }}</div>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">Status</span>
                                    <div class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                        @if($ordersPayment->status === 'completed') bg-green-100 text-green-800 
                                        @elseif($ordersPayment->status === 'pending') bg-yellow-100 text-yellow-800 
                                        @elseif($ordersPayment->status === 'failed') bg-red-100 text-red-800 
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($ordersPayment->status) }}
                                    </div>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">Created</span>
                                    <div class="text-sm font-medium text-gray-900">{{ $ordersPayment->created_at->format('M d, Y H:i') }}</div>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">Last Modified</span>
                                    <div class="text-sm font-medium text-gray-900">{{ $ordersPayment->updated_at->format('M d, Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- New Values Preview -->
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                New Values (Live Preview)
                            </h3>
                            <div id="newValuesPreview" class="space-y-3">
                                <!-- Will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Information Edit Form -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Order Details
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Modify the order information below</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Customer Selection -->
                        <div class="md:col-span-1">
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Customer <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="user_id" id="user_id" required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('user_id') border-red-500 @enderror">
                                    <option value="">Select a customer...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" 
                                                data-name="{{ $user->name }}" 
                                                data-email="{{ $user->email }}"
                                                {{ (old('user_id', $ordersPayment->user_id) == $user->id) ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('user_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div id="customerChangeWarning" class="hidden mt-3 p-3 bg-amber-50 rounded-lg border border-amber-200">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <span class="text-sm text-amber-800">Warning: Changing the customer will transfer this order to a different account.</span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Total -->
                        <div class="md:col-span-1">
                            <label for="total" class="block text-sm font-medium text-gray-700 mb-2">
                                Order Total <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-lg">$</span>
                                </div>
                                <input type="number" 
                                       name="total" 
                                       id="total" 
                                       step="0.01" 
                                       min="0.01" 
                                       value="{{ old('total', $ordersPayment->total) }}" 
                                       required 
                                       placeholder="0.00"
                                       class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('total') border-red-500 @enderror">
                            </div>
                            @error('total')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div id="totalChangeInfo" class="mt-2 text-sm"></div>
                        </div>

                        <!-- Order Status -->
                        <div class="md:col-span-2">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Order Status <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                                    <input type="radio" name="status" value="pending" 
                                           {{ old('status', $ordersPayment->status) === 'pending' ? 'checked' : '' }}
                                           class="sr-only" onchange="updateStatusPreview()">
                                    <div class="status-indicator w-4 h-4 bg-yellow-400 rounded-full mr-3"></div>
                                    <div class="flex-1">
                                        <div class="text-sm font-medium text-gray-900">Pending</div>
                                        <div class="text-xs text-gray-500">Payment awaiting processing</div>
                                    </div>
                                    <div class="status-check hidden">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </label>
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                                    <input type="radio" name="status" value="completed" 
                                           {{ old('status', $ordersPayment->status) === 'completed' ? 'checked' : '' }}
                                           class="sr-only" onchange="updateStatusPreview()">
                                    <div class="status-indicator w-4 h-4 bg-green-400 rounded-full mr-3"></div>
                                    <div class="flex-1">
                                        <div class="text-sm font-medium text-gray-900">Completed</div>
                                        <div class="text-xs text-gray-500">Payment successfully processed</div>
                                    </div>
                                    <div class="status-check hidden">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </label>
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                                    <input type="radio" name="status" value="failed" 
                                           {{ old('status', $ordersPayment->status) === 'failed' ? 'checked' : '' }}
                                           class="sr-only" onchange="updateStatusPreview()">
                                    <div class="status-indicator w-4 h-4 bg-red-400 rounded-full mr-3"></div>
                                    <div class="flex-1">
                                        <div class="text-sm font-medium text-gray-900">Failed</div>
                                        <div class="text-xs text-gray-500">Payment processing failed</div>
                                    </div>
                                    <div class="status-check hidden">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </label>
                            </div>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div id="statusChangeWarning" class="hidden mt-3 p-3 bg-amber-50 rounded-lg border border-amber-200">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <span class="text-sm text-amber-800">Status change detected. This may trigger customer notifications and financial record updates.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Change Reason -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Change Documentation
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Provide a reason for modifying this payment order (for audit purposes)</p>
                </div>
                <div class="p-6">
                    <label for="change_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Reason for Changes <span class="text-red-500">*</span>
                    </label>
                    <textarea name="change_reason" 
                              id="change_reason" 
                              rows="4" 
                              required 
                              placeholder="Please explain why this order is being modified..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('change_reason') border-red-500 @enderror">{{ old('change_reason') }}</textarea>
                    @error('change_reason')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div class="mt-3 text-sm text-gray-500">
                        <p><strong>Note:</strong> This information will be recorded in the audit log for compliance and tracking purposes.</p>
                    </div>
                </div>
            </div>

            <!-- Confirmation and Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4">
                    <div class="space-y-4">
                        <!-- Confirmation Checkboxes -->
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" id="confirmChanges" required 
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-3 text-sm text-gray-700">
                                    I confirm that the changes made to this payment order are accurate and necessary
                                </span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" id="confirmNotification" name="send_notification" value="1" 
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-3 text-sm text-gray-700">
                                    Send notification to customer about the order changes
                                </span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" id="confirmAuditLog" checked disabled 
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded opacity-50">
                                <span class="ml-3 text-sm text-gray-500">
                                    Create audit log entry for this modification (automatic)
                                </span>
                            </label>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t border-gray-200">
                            <div class="flex items-center space-x-3">
                                <button type="button" onclick="resetChanges()" 
                                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                    Reset Changes
                                </button>
                                <a href="{{ route('orders-payments.index') }}" 
                                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                                    Cancel
                                </a>
                            </div>
                            <div class="flex items-center space-x-3">
                                <button type="button" onclick="previewChanges()" 
                                        class="px-6 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                                    Preview Changes
                                </button>
                                <button type="submit" 
                                        class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors duration-200">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Preview Changes Modal -->
<div id="previewModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-lg bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Changes Preview</h3>
                <button onclick="hidePreviewModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="previewContent" class="space-y-4">
                <!-- Will be populated by JavaScript -->
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button onclick="hidePreviewModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Close Preview
                </button>
                <button onclick="submitForm()" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">
                    Confirm & Update
                </button>
            </div>
        </div>
    </div>
</div>

<script>
const originalValues = {
    user_id: {{ $ordersPayment->user_id }},
    user_name: '{{ $ordersPayment->user->name }}',
    user_email: '{{ $ordersPayment->user->email }}',
    total: {{ $ordersPayment->total }},
    status: '{{ $ordersPayment->status }}'
};

// Update new values preview
function updateNewValuesPreview() {
    const userId = document.getElementById('user_id').value;
    const total = document.getElementById('total').value;
    const status = document.querySelector('input[name="status"]:checked')?.value;
    const preview = document.getElementById('newValuesPreview');
    
    let customerName = '';
    let customerEmail = '';
    
    if (userId) {
        const userSelect = document.getElementById('user_id');
        const selectedOption = userSelect.options[userSelect.selectedIndex];
        customerName = selectedOption.dataset.name || '';
        customerEmail = selectedOption.dataset.email || '';
    }
    
    const statusColors = {
        pending: 'bg-yellow-100 text-yellow-800',
        completed: 'bg-green-100 text-green-800',
        failed: 'bg-red-100 text-red-800'
    };
    
    preview.innerHTML = `
        <div>
            <span class="text-xs text-gray-500">Customer</span>
            <div class="text-sm font-medium ${userId != originalValues.user_id ? 'text-amber-600' : 'text-gray-900'}">
                ${customerName || 'Not selected'}
            </div>
            <div class="text-xs ${userId != originalValues.user_id ? 'text-amber-600' : 'text-gray-600'}">
                ${customerEmail || ''}
            </div>
        </div>
        <div>
            <span class="text-xs text-gray-500">Total Amount</span>
            <div class="text-sm font-medium ${total != originalValues.total ? 'text-amber-600' : 'text-gray-900'}">
                $${total ? parseFloat(total).toFixed(2) : '0.00'}
            </div>
        </div>
        <div>
            <span class="text-xs text-gray-500">Status</span>
            <div class="inline-flex items-center px-2 py-1 rounded text-xs font-medium ${status ? statusColors[status] : 'bg-gray-100 text-gray-800'}">
                ${status ? status.charAt(0).toUpperCase() + status.slice(1) : 'Not selected'}
            </div>
        </div>
    `;
    
    // Show warnings for changes
    checkForChanges();
}

// Check for changes and show warnings
function checkForChanges() {
    const userId = document.getElementById('user_id').value;
    const total = document.getElementById('total').value;
    const status = document.querySelector('input[name="status"]:checked')?.value;
    
    // Customer change warning
    const customerWarning = document.getElementById('customerChangeWarning');
    if (userId && userId != originalValues.user_id) {
        customerWarning.classList.remove('hidden');
    } else {
        customerWarning.classList.add('hidden');
    }
    
    // Total change info
    const totalInfo = document.getElementById('totalChangeInfo');
    if (total && parseFloat(total) !== originalValues.total) {
        const difference = parseFloat(total) - originalValues.total;
        const sign = difference > 0 ? '+' : '';
        totalInfo.innerHTML = `<span class="text-amber-600">Change: ${sign}$${difference.toFixed(2)}</span>`;
    } else {
        totalInfo.innerHTML = '';
    }
    
    // Status change warning
    const statusWarning = document.getElementById('statusChangeWarning');
    if (status && status !== originalValues.status) {
        statusWarning.classList.remove('hidden');
    } else {
        statusWarning.classList.add('hidden');
    }
}

// Update status preview
function updateStatusPreview() {
    const radios = document.querySelectorAll('input[name="status"]');
    radios.forEach(radio => {
        const label = radio.closest('label');
        const check = label.querySelector('.status-check');
        
        if (radio.checked) {
            label.classList.add('ring-2', 'ring-blue-500', 'border-blue-500');
            check.classList.remove('hidden');
        } else {
            label.classList.remove('ring-2', 'ring-blue-500', 'border-blue-500');
            check.classList.add('hidden');
        }
    });
    
    updateNewValuesPreview();
}

// Reset changes
function resetChanges() {
    if (confirm('Are you sure you want to reset all changes to their original values?')) {
        document.getElementById('user_id').value = originalValues.user_id;
        document.getElementById('total').value = originalValues.total;
        document.querySelector(`input[name="status"][value="${originalValues.status}"]`).checked = true;
        document.getElementById('change_reason').value = '';
        
        updateStatusPreview();
        updateNewValuesPreview();
    }
}

// Preview changes
function previewChanges() {
    const userId = document.getElementById('user_id').value;
    const total = document.getElementById('total').value;
    const status = document.querySelector('input[name="status"]:checked')?.value;
    const reason = document.getElementById('change_reason').value;
    
    let customerName = '';
    let customerEmail = '';
    
    if (userId) {
        const userSelect = document.getElementById('user_id');
        const selectedOption = userSelect.options[userSelect.selectedIndex];
        customerName = selectedOption.dataset.name || '';
        customerEmail = selectedOption.dataset.email || '';
    }
    
    const changes = [];
    
    if (userId != originalValues.user_id) {
        changes.push({
            field: 'Customer',
            old: `${originalValues.user_name} (${originalValues.user_email})`,
            new: `${customerName} (${customerEmail})`
        });
    }
    
    if (parseFloat(total) !== originalValues.total) {
        changes.push({
            field: 'Total Amount',
            old: `$${originalValues.total.toFixed(2)}`,
            new: `$${parseFloat(total).toFixed(2)}`
        });
    }
    
    if (status !== originalValues.status) {
        changes.push({
            field: 'Status',
            old: originalValues.status.charAt(0).toUpperCase() + originalValues.status.slice(1),
            new: status.charAt(0).toUpperCase() + status.slice(1)
        });
    }
    
    const previewContent = document.getElementById('previewContent');
    
    if (changes.length === 0) {
        previewContent.innerHTML = `
            <div class="text-center py-8">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500">No changes detected</p>
            </div>
        `;
    } else {
        let changesHtml = changes.map(change => `
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                <div>
                    <div class="text-sm font-medium text-gray-900">${change.field}</div>
                    <div class="text-xs text-gray-500">From: ${change.old}</div>
                    <div class="text-xs text-amber-600">To: ${change.new}</div>
                </div>
            </div>
        `).join('');
        
        previewContent.innerHTML = `
            <div class="space-y-3">
                <h4 class="text-sm font-semibold text-gray-900">Changes to be made:</h4>
                ${changesHtml}
                ${reason ? `
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <div class="text-sm font-medium text-gray-900">Reason for changes:</div>
                        <div class="text-sm text-gray-700 mt-1">${reason}</div>
                    </div>
                ` : ''}
            </div>
        `;
    }
    
    document.getElementById('previewModal').classList.remove('hidden');
}

// Hide preview modal
function hidePreviewModal() {
    document.getElementById('previewModal').classList.add('hidden');
}

// Submit form
function submitForm() {
    hidePreviewModal();
    document.getElementById('editOrderForm').submit();
}

// Event listeners
document.getElementById('user_id').addEventListener('change', updateNewValuesPreview);
document.getElementById('total').addEventListener('input', updateNewValuesPreview);

// Form validation
document.getElementById('editOrderForm').addEventListener('submit', function(e) {
    const confirmChanges = document.getElementById('confirmChanges').checked;
    const reason = document.getElementById('change_reason').value.trim();
    
    if (!confirmChanges) {
        e.preventDefault();
        alert('Please confirm that the changes are accurate and necessary.');
        return;
    }
    
    if (!reason) {
        e.preventDefault();
        alert('Please provide a reason for the changes.');
        return;
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateStatusPreview();
    updateNewValuesPreview();
});

// Add CSRF token meta tag if not already present
if (!document.querySelector('meta[name="csrf-token"]')) {
    const meta = document.createElement('meta');
    meta.name = 'csrf-token';
    meta.content = '{{ csrf_token() }}';
    document.getElementsByTagName('head')[0].appendChild(meta);
}
</script>
@endsection