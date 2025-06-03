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
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Create New Payment Order</h1>
                            <p class="text-sm text-gray-500">Add a new payment order to the system</p>
                        </div>
                    </div>
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

        <!-- Form Section -->
        <form action="{{ route('orders-payments.store') }}" method="POST" id="orderForm" class="space-y-6">
            @csrf
            
            <!-- Order Information Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Basic Order Information
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Enter the essential details for the payment order</p>
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
                                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
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
                            <div id="customerPreview" class="hidden mt-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span id="customerInitial" class="text-blue-600 font-semibold text-sm"></span>
                                    </div>
                                    <div>
                                        <p id="customerName" class="text-sm font-medium text-gray-900"></p>
                                        <p id="customerEmail" class="text-xs text-gray-500"></p>
                                    </div>
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
                                       value="{{ old('total') }}" 
                                       required 
                                       placeholder="0.00"
                                       class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 @error('total') border-red-500 @enderror">
                            </div>
                            @error('total')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div id="totalFormatted" class="mt-2 text-sm text-gray-600"></div>
                        </div>

                        <!-- Order Status -->
                        <div class="md:col-span-2">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Initial Status <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                                    <input type="radio" name="status" value="pending" 
                                           {{ old('status', 'pending') === 'pending' ? 'checked' : '' }}
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
                                           {{ old('status') === 'completed' ? 'checked' : '' }}
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
                                           {{ old('status') === 'failed' ? 'checked' : '' }}
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
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Preview Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Order Preview
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Review the order details before creating</p>
                </div>
                <div class="p-6">
                    <div id="orderPreview" class="space-y-4">
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p>Fill in the form above to see the order preview</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Templates -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                        </svg>
                        Quick Templates
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Use predefined templates for common order types</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <button type="button" onclick="applyTemplate('small')" 
                                class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200 text-left">
                            <div class="text-sm font-medium text-gray-900">Small Order</div>
                            <div class="text-xs text-gray-500 mt-1">$25.00 - Pending</div>
                        </button>
                        <button type="button" onclick="applyTemplate('medium')" 
                                class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200 text-left">
                            <div class="text-sm font-medium text-gray-900">Medium Order</div>
                            <div class="text-xs text-gray-500 mt-1">$100.00 - Pending</div>
                        </button>
                        <button type="button" onclick="applyTemplate('large')" 
                                class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200 text-left">
                            <div class="text-sm font-medium text-gray-900">Large Order</div>
                            <div class="text-xs text-gray-500 mt-1">$500.00 - Completed</div>
                        </button>
                        <button type="button" onclick="applyTemplate('premium')" 
                                class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200 text-left">
                            <div class="text-sm font-medium text-gray-900">Premium Order</div>
                            <div class="text-xs text-gray-500 mt-1">$1000.00 - Completed</div>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" id="sendNotification" name="send_notification" value="1" 
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="sendNotification" class="text-sm text-gray-700">
                                Send notification to customer
                            </label>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button type="button" onclick="resetForm()" 
                                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                Reset Form
                            </button>
                            <button type="button" onclick="saveDraft()" 
                                    class="px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors duration-200">
                                Save as Draft
                            </button>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Create Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Update customer preview when selection changes
document.getElementById('user_id').addEventListener('change', function() {
    const select = this;
    const preview = document.getElementById('customerPreview');
    
    if (select.value) {
        const selectedOption = select.options[select.selectedIndex];
        const name = selectedOption.dataset.name;
        const email = selectedOption.dataset.email;
        
        document.getElementById('customerName').textContent = name;
        document.getElementById('customerEmail').textContent = email;
        document.getElementById('customerInitial').textContent = name.charAt(0).toUpperCase();
        
        preview.classList.remove('hidden');
    } else {
        preview.classList.add('hidden');
    }
    
    updateOrderPreview();
});

// Format total amount as user types
document.getElementById('total').addEventListener('input', function() {
    const value = parseFloat(this.value);
    const formatted = document.getElementById('totalFormatted');
    
    if (!isNaN(value) && value > 0) {
        formatted.textContent = `Formatted: $${value.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        formatted.classList.remove('text-red-600');
        formatted.classList.add('text-green-600');
    } else if (this.value) {
        formatted.textContent = 'Please enter a valid amount';
        formatted.classList.remove('text-green-600');
        formatted.classList.add('text-red-600');
    } else {
        formatted.textContent = '';
    }
    
    updateOrderPreview();
});

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
    
    updateOrderPreview();
}

// Update order preview
function updateOrderPreview() {
    const userId = document.getElementById('user_id').value;
    const total = document.getElementById('total').value;
    const status = document.querySelector('input[name="status"]:checked')?.value;
    const preview = document.getElementById('orderPreview');
    
    if (userId && total && status) {
        const userSelect = document.getElementById('user_id');
        const selectedOption = userSelect.options[userSelect.selectedIndex];
        const customerName = selectedOption.dataset.name;
        const customerEmail = selectedOption.dataset.email;
        const formattedTotal = parseFloat(total).toLocaleString('en-US', {
            style: 'currency',
            currency: 'USD'
        });
        
        const statusColors = {
            pending: 'bg-yellow-100 text-yellow-800 border-yellow-200',
            completed: 'bg-green-100 text-green-800 border-green-200',
            failed: 'bg-red-100 text-red-800 border-red-200'
        };
        
        const statusDots = {
            pending: 'bg-yellow-400',
            completed: 'bg-green-400',
            failed: 'bg-red-400'
        };
        
        preview.innerHTML = `
            <div class="border border-gray-200 rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Order Summary</h3>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border ${statusColors[status]}">
                        <div class="w-2 h-2 rounded-full mr-2 ${statusDots[status]}"></div>
                        ${status.charAt(0).toUpperCase() + status.slice(1)}
                    </span>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Customer:</span>
                        <span class="text-sm font-medium text-gray-900">${customerName}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Email:</span>
                        <span class="text-sm font-medium text-gray-900">${customerEmail}</span>
                    </div>
                    <div class="flex justify-between border-t pt-3">
                        <span class="text-sm font-medium text-gray-900">Total Amount:</span>
                        <span class="text-lg font-bold text-green-600">${formattedTotal}</span>
                    </div>
                </div>
            </div>
        `;
    } else {
        preview.innerHTML = `
            <div class="text-center py-8 text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p>Fill in the form above to see the order preview</p>
            </div>
        `;
    }
}

// Apply quick templates
function applyTemplate(type) {
    const templates = {
        small: { total: '25.00', status: 'pending' },
        medium: { total: '100.00', status: 'pending' },
        large: { total: '500.00', status: 'completed' },
        premium: { total: '1000.00', status: 'completed' }
    };
    
    const template = templates[type];
    if (template) {
        document.getElementById('total').value = template.total;
        document.querySelector(`input[name="status"][value="${template.status}"]`).checked = true;
        
        // Trigger events to update UI
        document.getElementById('total').dispatchEvent(new Event('input'));
        updateStatusPreview();
    }
}

// Reset form
function resetForm() {
    if (confirm('Are you sure you want to reset all form fields?')) {
        document.getElementById('orderForm').reset();
        document.getElementById('customerPreview').classList.add('hidden');
        document.getElementById('totalFormatted').textContent = '';
        updateStatusPreview();
        updateOrderPreview();
    }
}

// Save as draft
function saveDraft() {
    const formData = new FormData(document.getElementById('orderForm'));
    formData.append('is_draft', '1');
    
    fetch('{{ route("orders-payments.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Draft saved successfully!');
        } else {
            alert('Error saving draft: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving the draft.');
    });
}

// Initialize status preview on page load
document.addEventListener('DOMContentLoaded', function() {
    updateStatusPreview();
    
    // Check for duplication parameter
    const urlParams = new URLSearchParams(window.location.search);
    const duplicateId = urlParams.get('duplicate');
    if (duplicateId) {
        // You could fetch order details and pre-fill the form here
        console.log('Duplicating order:', duplicateId);
    }
});

// Add CSRF token meta tag if not already present
if (!document.querySelector('meta[name="csrf-token"]')) {
    const meta = document.createElement('meta');
    meta.name = 'csrf-token';
    meta.content = '{{ csrf_token() }}';
    document.getElementsByTagName('head')[0].appendChild(meta);
}

// Form validation
document.getElementById('orderForm').addEventListener('submit', function(e) {
    const userId = document.getElementById('user_id').value;
    const total = document.getElementById('total').value;
    const status = document.querySelector('input[name="status"]:checked');
    
    if (!userId || !total || !status) {
        e.preventDefault();
        alert('Please fill in all required fields.');
        return;
    }
    
    if (parseFloat(total) <= 0) {
        e.preventDefault();
        alert('Total amount must be greater than 0.');
        return;
    }
});
</script>
@endsection