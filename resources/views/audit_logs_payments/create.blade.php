@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-3 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Create Audit Log</h1>
                            <p class="text-gray-600 mt-1">Manually create a new payment audit log entry</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('audit-logs-payments.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Audit Logs
                    </a>
                </div>
            </div>
        </div>

        <!-- Warning Notice -->
        <div class="mb-6 bg-amber-50 border border-amber-200 rounded-xl p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-amber-800">Administrative Notice</h3>
                    <p class="mt-1 text-sm text-amber-700">
                        Audit logs are typically created automatically by the system. Manual creation should only be used for testing, 
                        data migration, or administrative purposes. All manually created logs will be marked appropriately.
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Audit Log Information
                </h2>
            </div>

            <form action="{{ route('audit-logs-payments.store') }}" method="POST" class="p-6 space-y-6" id="auditLogForm">
                @csrf
                
                <!-- Basic Information Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- User Selection -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                            User
                            <span class="text-red-500">*</span>
                        </label>
                        <select name="user_id" id="user_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('user_id') border-red-500 @enderror">
                            <option value="">Select a user...</option>
                            @foreach(\App\Models\User::all() as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action -->
                    <div>
                        <label for="action" class="block text-sm font-medium text-gray-700 mb-2">
                            Action
                            <span class="text-red-500">*</span>
                        </label>
                        <select name="action" id="action" required onchange="updateActionPreview()"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('action') border-red-500 @enderror">
                            <option value="">Select an action...</option>
                            <option value="create" {{ old('action') == 'create' ? 'selected' : '' }}>Create</option>
                            <option value="update" {{ old('action') == 'update' ? 'selected' : '' }}>Update</option>
                            <option value="delete" {{ old('action') == 'delete' ? 'selected' : '' }}>Delete</option>
                            <option value="view" {{ old('action') == 'view' ? 'selected' : '' }}>View</option>
                            <option value="login" {{ old('action') == 'login' ? 'selected' : '' }}>Login</option>
                            <option value="logout" {{ old('action') == 'logout' ? 'selected' : '' }}>Logout</option>
                            <option value="export" {{ old('action') == 'export' ? 'selected' : '' }}>Export</option>
                            <option value="import" {{ old('action') == 'import' ? 'selected' : '' }}>Import</option>
                        </select>
                        <div id="actionPreview" class="mt-2"></div>
                        @error('action')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Entity Type -->
                    <div>
                        <label for="entity_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Entity Type
                            <span class="text-red-500">*</span>
                        </label>
                        <select name="entity_type" id="entity_type" required onchange="updateEntityOptions()"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('entity_type') border-red-500 @enderror">
                            <option value="">Select entity type...</option>
                            <option value="Transaction" {{ old('entity_type') == 'Transaction' ? 'selected' : '' }}>Transaction</option>
                            <option value="PaymentGateway" {{ old('entity_type') == 'PaymentGateway' ? 'selected' : '' }}>Payment Gateway</option>
                            <option value="Refund" {{ old('entity_type') == 'Refund' ? 'selected' : '' }}>Refund</option>
                            <option value="Order" {{ old('entity_type') == 'Order' ? 'selected' : '' }}>Order</option>
                            <option value="User" {{ old('entity_type') == 'User' ? 'selected' : '' }}>User</option>
                            <option value="CreditCard" {{ old('entity_type') == 'CreditCard' ? 'selected' : '' }}>Credit Card</option>
                        </select>
                        @error('entity_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Entity ID -->
                    <div>
                        <label for="entity_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Entity ID
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="entity_id" id="entity_id" min="1" required
                               value="{{ old('entity_id') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('entity_id') border-red-500 @enderror"
                               placeholder="Enter entity ID">
                        <div id="entityInfo" class="mt-2 text-sm text-gray-600"></div>
                        @error('entity_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Technical Information Section -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Technical Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- IP Address -->
                        <div>
                            <label for="ip_address" class="block text-sm font-medium text-gray-700 mb-2">
                                IP Address
                            </label>
                            <input type="text" name="ip_address" id="ip_address"
                                   value="{{ old('ip_address', request()->ip()) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('ip_address') border-red-500 @enderror"
                                   placeholder="192.168.1.1">
                            <p class="mt-1 text-xs text-gray-500">Current IP: {{ request()->ip() }}</p>
                            @error('ip_address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- User Agent -->
                        <div>
                            <label for="user_agent" class="block text-sm font-medium text-gray-700 mb-2">
                                User Agent
                            </label>
                            <textarea name="user_agent" id="user_agent" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('user_agent') border-red-500 @enderror"
                                      placeholder="Browser user agent string">{{ old('user_agent', request()->userAgent()) }}</textarea>
                            @error('user_agent')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Changes Section -->
                <div class="border-t border-gray-200 pt-6" id="dataChangesSection">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Data Changes
                        <span class="ml-2 text-sm font-normal text-gray-500">(Optional)</span>
                    </h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Old Values -->
                        <div>
                            <label for="old_values" class="block text-sm font-medium text-gray-700 mb-2">
                                Previous Values (JSON)
                            </label>
                            <textarea name="old_values" id="old_values" rows="6"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 font-mono text-sm @error('old_values') border-red-500 @enderror"
                                      placeholder='{"field": "old_value", "status": "pending"}'>{{ old('old_values') }}</textarea>
                            <div class="flex items-center justify-between mt-2">
                                <p class="text-xs text-gray-500">Enter valid JSON format</p>
                                <button type="button" onclick="validateJson('old_values')" 
                                        class="text-xs text-blue-600 hover:text-blue-800">Validate JSON</button>
                            </div>
                            <div id="old_values_validation" class="mt-1"></div>
                            @error('old_values')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Values -->
                        <div>
                            <label for="new_values" class="block text-sm font-medium text-gray-700 mb-2">
                                New Values (JSON)
                            </label>
                            <textarea name="new_values" id="new_values" rows="6"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 font-mono text-sm @error('new_values') border-red-500 @enderror"
                                      placeholder='{"field": "new_value", "status": "completed"}'>{{ old('new_values') }}</textarea>
                            <div class="flex items-center justify-between mt-2">
                                <p class="text-xs text-gray-500">Enter valid JSON format</p>
                                <button type="button" onclick="validateJson('new_values')" 
                                        class="text-xs text-blue-600 hover:text-blue-800">Validate JSON</button>
                            </div>
                            <div id="new_values_validation" class="mt-1"></div>
                            @error('new_values')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- JSON Templates -->
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-700 mb-2">JSON Templates:</p>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" onclick="insertTemplate('transaction')" 
                                    class="px-3 py-1 bg-blue-100 text-blue-700 rounded text-xs hover:bg-blue-200">
                                Transaction
                            </button>
                            <button type="button" onclick="insertTemplate('payment')" 
                                    class="px-3 py-1 bg-green-100 text-green-700 rounded text-xs hover:bg-green-200">
                                Payment
                            </button>
                            <button type="button" onclick="insertTemplate('user')" 
                                    class="px-3 py-1 bg-purple-100 text-purple-700 rounded text-xs hover:bg-purple-200">
                                User
                            </button>
                            <button type="button" onclick="clearFields()" 
                                    class="px-3 py-1 bg-red-100 text-red-700 rounded text-xs hover:bg-red-200">
                                Clear All
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" id="confirm_manual" name="confirm_manual" required
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="confirm_manual" class="text-sm text-gray-700">
                                I confirm this is a manual audit log creation and understand the implications
                            </label>
                        </div>
                        <div class="flex space-x-3">
                            <button type="button" onclick="resetForm()"
                                    class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                                Reset Form
                            </button>
                            <button type="submit" 
                                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Create Audit Log
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Action preview functionality
function updateActionPreview() {
    const action = document.getElementById('action').value;
    const preview = document.getElementById('actionPreview');
    
    const actionInfo = {
        'create': { color: 'green', description: 'Records the creation of a new entity' },
        'update': { color: 'blue', description: 'Records modifications to an existing entity' },
        'delete': { color: 'red', description: 'Records the deletion of an entity' },
        'view': { color: 'purple', description: 'Records when an entity was viewed' },
        'login': { color: 'indigo', description: 'Records user authentication events' },
        'logout': { color: 'gray', description: 'Records user logout events' },
        'export': { color: 'emerald', description: 'Records data export operations' },
        'import': { color: 'amber', description: 'Records data import operations' }
    };
    
    if (action && actionInfo[action]) {
        const info = actionInfo[action];
        preview.innerHTML = `
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-${info.color}-100 text-${info.color}-800">
                ${action.charAt(0).toUpperCase() + action.slice(1)}
            </span>
            <p class="text-xs text-gray-600 mt-1">${info.description}</p>
        `;
    } else {
        preview.innerHTML = '';
    }
}

// Entity options functionality
function updateEntityOptions() {
    const entityType = document.getElementById('entity_type').value;
    const entityInfo = document.getElementById('entityInfo');
    
    if (entityType) {
        entityInfo.innerHTML = `<span class="text-blue-600">Selected: ${entityType}</span>`;
    } else {
        entityInfo.innerHTML = '';
    }
}

// JSON validation
function validateJson(fieldId) {
    const field = document.getElementById(fieldId);
    const validation = document.getElementById(fieldId + '_validation');
    const value = field.value.trim();
    
    if (!value) {
        validation.innerHTML = '<span class="text-gray-500 text-xs">No data to validate</span>';
        return;
    }
    
    try {
        JSON.parse(value);
        validation.innerHTML = '<span class="text-green-600 text-xs">✓ Valid JSON</span>';
        field.classList.remove('border-red-500');
        field.classList.add('border-green-500');
    } catch (e) {
        validation.innerHTML = `<span class="text-red-600 text-xs">✗ Invalid JSON: ${e.message}</span>`;
        field.classList.remove('border-green-500');
        field.classList.add('border-red-500');
    }
}

// Template insertion
function insertTemplate(type) {
    const templates = {
        transaction: {
            old: '{"amount": 100.00, "status": "pending", "currency": "USD"}',
            new: '{"amount": 100.00, "status": "completed", "currency": "USD", "transaction_fee": 2.50}'
        },
        payment: {
            old: '{"payment_method": "credit_card", "status": "processing"}',
            new: '{"payment_method": "credit_card", "status": "completed", "gateway_response": "approved"}'
        },
        user: {
            old: '{"name": "John Doe", "email": "john@example.com", "status": "inactive"}',
            new: '{"name": "John Doe", "email": "john@example.com", "status": "active", "last_login": "2024-01-15"}'
        }
    };
    
    if (templates[type]) {
        document.getElementById('old_values').value = templates[type].old;
        document.getElementById('new_values').value = templates[type].new;
        validateJson('old_values');
        validateJson('new_values');
    }
}

// Clear form fields
function clearFields() {
    document.getElementById('old_values').value = '';
    document.getElementById('new_values').value = '';
    document.getElementById('old_values_validation').innerHTML = '';
    document.getElementById('new_values_validation').innerHTML = '';
    document.getElementById('old_values').classList.remove('border-red-500', 'border-green-500');
    document.getElementById('new_values').classList.remove('border-red-500', 'border-green-500');
}

// Reset entire form
function resetForm() {
    if (confirm('Are you sure you want to reset the entire form? All data will be lost.')) {
        document.getElementById('auditLogForm').reset();
        clearFields();
        document.getElementById('actionPreview').innerHTML = '';
        document.getElementById('entityInfo').innerHTML = '';
    }
}

// Auto-validate JSON on input
document.getElementById('old_values').addEventListener('input', function() {
    clearTimeout(this.validationTimeout);
    this.validationTimeout = setTimeout(() => validateJson('old_values'), 500);
});

document.getElementById('new_values').addEventListener('input', function() {
    clearTimeout(this.validationTimeout);
    this.validationTimeout = setTimeout(() => validateJson('new_values'), 500);
});

// Form submission validation
document.getElementById('auditLogForm').addEventListener('submit', function(e) {
    const oldValues = document.getElementById('old_values').value.trim();
    const newValues = document.getElementById('new_values').value.trim();
    
    // Validate JSON if provided
    if (oldValues) {
        try {
            JSON.parse(oldValues);
        } catch (error) {
            e.preventDefault();
            alert('Please fix the JSON format in "Previous Values" field.');
            return;
        }
    }
    
    if (newValues) {
        try {
            JSON.parse(newValues);
        } catch (error) {
            e.preventDefault();
            alert('Please fix the JSON format in "New Values" field.');
            return;
        }
    }
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateActionPreview();
    updateEntityOptions();
});
</script>
@endsection
