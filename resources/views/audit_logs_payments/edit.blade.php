@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-r from-amber-600 to-orange-600 p-3 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Edit Audit Log</h1>
                            <p class="text-gray-600 mt-1">Modify audit log entry #{{ $auditLog->id }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('audit-logs-payments.show', $auditLog) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        View Details
                    </a>
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

        <!-- Critical Warning -->
        <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-semibold text-red-800">⚠️ CRITICAL COMPLIANCE WARNING</h3>
                    <div class="mt-2 space-y-2 text-sm text-red-700">
                        <p><strong>Audit log modification is a serious action that may impact compliance and data integrity.</strong></p>
                        <ul class="list-disc list-inside space-y-1 ml-4">
                            <li>All changes to audit logs are automatically tracked and cannot be undone</li>
                            <li>This action may violate audit compliance requirements in your organization</li>
                            <li>Original values and modification details will be permanently recorded</li>
                            <li>Legal and regulatory implications may apply</li>
                        </ul>
                        <p class="font-medium">Only proceed if you have explicit authorization and understand the consequences.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Log Information -->
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Current Log Information
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="font-medium text-blue-800">Created:</span>
                    <p class="text-blue-700">{{ $auditLog->created_at->format('M d, Y H:i:s') }}</p>
                </div>
                <div>
                    <span class="font-medium text-blue-800">Action:</span>
                    <p class="text-blue-700">{{ ucfirst($auditLog->action) }}</p>
                </div>
                <div>
                    <span class="font-medium text-blue-800">Entity:</span>
                    <p class="text-blue-700">{{ $auditLog->entity_type }} #{{ $auditLog->entity_id }}</p>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-amber-600 to-orange-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modify Audit Log Information
                </h2>
            </div>

            <form action="{{ route('audit-logs-payments.update', $auditLog) }}" method="POST" class="p-6 space-y-6" id="auditLogForm">
                @csrf
                @method('PUT')
                
                <!-- Authorization Section -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 mb-3">Authorization Required</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="authorization_reason" class="block text-sm font-medium text-gray-700 mb-2">
                                Reason for Modification <span class="text-red-500">*</span>
                            </label>
                            <select name="authorization_reason" id="authorization_reason" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200">
                                <option value="">Select reason...</option>
                                <option value="data_correction">Data Correction</option>
                                <option value="privacy_compliance">Privacy/GDPR Compliance</option>
                                <option value="legal_requirement">Legal Requirement</option>
                                <option value="system_error">System Error Correction</option>
                                <option value="migration_cleanup">Data Migration Cleanup</option>
                                <option value="security_incident">Security Incident Response</option>
                                <option value="other">Other (specify in notes)</option>
                            </select>
                        </div>
                        <div>
                            <label for="authorization_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Authorization Notes <span class="text-red-500">*</span>
                            </label>
                            <textarea name="authorization_notes" id="authorization_notes" required rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200"
                                      placeholder="Detailed justification for this modification..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Basic Information Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- User Selection -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                            User
                            <span class="text-red-500">*</span>
                        </label>
                        <select name="user_id" id="user_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 @error('user_id') border-red-500 @enderror">
                            <option value="">Select a user...</option>
                            @foreach(\App\Models\User::all() as $user)
                                <option value="{{ $user->id }}" {{ ($auditLog->user_id == $user->id || old('user_id') == $user->id) ? 'selected' : '' }}>
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
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 @error('action') border-red-500 @enderror">
                            <option value="">Select an action...</option>
                            <option value="create" {{ ($auditLog->action == 'create' || old('action') == 'create') ? 'selected' : '' }}>Create</option>
                            <option value="update" {{ ($auditLog->action == 'update' || old('action') == 'update') ? 'selected' : '' }}>Update</option>
                            <option value="delete" {{ ($auditLog->action == 'delete' || old('action') == 'delete') ? 'selected' : '' }}>Delete</option>
                            <option value="view" {{ ($auditLog->action == 'view' || old('action') == 'view') ? 'selected' : '' }}>View</option>
                            <option value="login" {{ ($auditLog->action == 'login' || old('action') == 'login') ? 'selected' : '' }}>Login</option>
                            <option value="logout" {{ ($auditLog->action == 'logout' || old('action') == 'logout') ? 'selected' : '' }}>Logout</option>
                            <option value="export" {{ ($auditLog->action == 'export' || old('action') == 'export') ? 'selected' : '' }}>Export</option>
                            <option value="import" {{ ($auditLog->action == 'import' || old('action') == 'import') ? 'selected' : '' }}>Import</option>
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
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 @error('entity_type') border-red-500 @enderror">
                            <option value="">Select entity type...</option>
                            <option value="Transaction" {{ ($auditLog->entity_type == 'Transaction' || old('entity_type') == 'Transaction') ? 'selected' : '' }}>Transaction</option>
                            <option value="PaymentGateway" {{ ($auditLog->entity_type == 'PaymentGateway' || old('entity_type') == 'PaymentGateway') ? 'selected' : '' }}>Payment Gateway</option>
                            <option value="Refund" {{ ($auditLog->entity_type == 'Refund' || old('entity_type') == 'Refund') ? 'selected' : '' }}>Refund</option>
                            <option value="Order" {{ ($auditLog->entity_type == 'Order' || old('entity_type') == 'Order') ? 'selected' : '' }}>Order</option>
                            <option value="User" {{ ($auditLog->entity_type == 'User' || old('entity_type') == 'User') ? 'selected' : '' }}>User</option>
                            <option value="CreditCard" {{ ($auditLog->entity_type == 'CreditCard' || old('entity_type') == 'CreditCard') ? 'selected' : '' }}>Credit Card</option>
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
                               value="{{ old('entity_id', $auditLog->entity_id) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 @error('entity_id') border-red-500 @enderror"
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
                                   value="{{ old('ip_address', $auditLog->ip_address) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 @error('ip_address') border-red-500 @enderror"
                                   placeholder="192.168.1.1">
                            <p class="mt-1 text-xs text-gray-500">Original: {{ $auditLog->ip_address ?? 'N/A' }}</p>
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
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 @error('user_agent') border-red-500 @enderror"
                                      placeholder="Browser user agent string">{{ old('user_agent', $auditLog->user_agent) }}</textarea>
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
                        <span class="ml-2 text-sm font-normal text-gray-500">(Be extremely careful)</span>
                    </h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Old Values -->
                        <div>
                            <label for="old_values" class="block text-sm font-medium text-gray-700 mb-2">
                                Previous Values (JSON)
                            </label>
                            <textarea name="old_values" id="old_values" rows="6"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 font-mono text-sm @error('old_values') border-red-500 @enderror"
                                      placeholder='{"field": "old_value", "status": "pending"}'>{{ old('old_values', $auditLog->old_values) }}</textarea>
                            <div class="flex items-center justify-between mt-2">
                                <p class="text-xs text-gray-500">Enter valid JSON format</p>
                                <button type="button" onclick="validateJson('old_values')" 
                                        class="text-xs text-amber-600 hover:text-amber-800">Validate JSON</button>
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
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all duration-200 font-mono text-sm @error('new_values') border-red-500 @enderror"
                                      placeholder='{"field": "new_value", "status": "completed"}'>{{ old('new_values', $auditLog->new_values) }}</textarea>
                            <div class="flex items-center justify-between mt-2">
                                <p class="text-xs text-gray-500">Enter valid JSON format</p>
                                <button type="button" onclick="validateJson('new_values')" 
                                        class="text-xs text-amber-600 hover:text-amber-800">Validate JSON</button>
                            </div>
                            <div id="new_values_validation" class="mt-1"></div>
                            @error('new_values')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Original Data Display -->
                    <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <h4 class="text-sm font-medium text-blue-900 mb-2">Original Data (For Reference)</h4>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 text-xs">
                            <div>
                                <span class="font-medium text-blue-800">Original Old Values:</span>
                                <pre class="mt-1 text-blue-700 bg-blue-100 p-2 rounded overflow-x-auto">{{ $auditLog->old_values ? json_encode(json_decode($auditLog->old_values), JSON_PRETTY_PRINT) : 'N/A' }}</pre>
                            </div>
                            <div>
                                <span class="font-medium text-blue-800">Original New Values:</span>
                                <pre class="mt-1 text-blue-700 bg-blue-100 p-2 rounded overflow-x-auto">{{ $auditLog->new_values ? json_encode(json_decode($auditLog->new_values), JSON_PRETTY_PRINT) : 'N/A' }}</pre>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Final Confirmation Section -->
                <div class="border-t border-gray-200 pt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <h4 class="font-semibold text-red-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        Final Confirmation Required
                    </h4>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" id="understand_implications" name="understand_implications" required
                                   class="mt-1 h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                            <label for="understand_implications" class="text-sm text-red-800">
                                I understand that modifying audit logs can have serious legal and compliance implications
                            </label>
                        </div>
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" id="have_authorization" name="have_authorization" required
                                   class="mt-1 h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                            <label for="have_authorization" class="text-sm text-red-800">
                                I have proper authorization to make these changes and accept full responsibility
                            </label>
                        </div>
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" id="irreversible_action" name="irreversible_action" required
                                   class="mt-1 h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                            <label for="irreversible_action" class="text-sm text-red-800">
                                I understand this action will be permanently tracked and cannot be undone
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                        <div class="text-sm text-gray-600">
                            <p><strong>Last modified:</strong> {{ $auditLog->updated_at->format('F j, Y g:i:s A') }}</p>
                            <p><strong>Created:</strong> {{ $auditLog->created_at->format('F j, Y g:i:s A') }}</p>
                        </div>
                        <div class="flex space-x-3">
                            <button type="button" onclick="resetToOriginal()"
                                    class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                                Reset to Original
                            </button>
                            <button type="submit" onclick="return confirmUpdate()" 
                                    class="px-6 py-3 bg-gradient-to-r from-amber-600 to-orange-600 text-white font-medium rounded-lg hover:from-amber-700 hover:to-orange-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Update Audit Log
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Store original values for reset functionality
const originalValues = {
    user_id: '{{ $auditLog->user_id }}',
    action: '{{ $auditLog->action }}',
    entity_type: '{{ $auditLog->entity_type }}',
    entity_id: '{{ $auditLog->entity_id }}',
    ip_address: '{{ $auditLog->ip_address }}',
    user_agent: `{{ $auditLog->user_agent }}`,
    old_values: `{{ $auditLog->old_values }}`,
    new_values: `{{ $auditLog->new_values }}`
};

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
        entityInfo.innerHTML = `<span class="text-amber-600">Selected: ${entityType}</span>`;
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

// Reset to original values
function resetToOriginal() {
    if (confirm('Are you sure you want to reset all fields to their original values? All changes will be lost.')) {
        document.getElementById('user_id').value = originalValues.user_id;
        document.getElementById('action').value = originalValues.action;
        document.getElementById('entity_type').value = originalValues.entity_type;
        document.getElementById('entity_id').value = originalValues.entity_id;
        document.getElementById('ip_address').value = originalValues.ip_address;
        document.getElementById('user_agent').value = originalValues.user_agent;
        document.getElementById('old_values').value = originalValues.old_values;
        document.getElementById('new_values').value = originalValues.new_values;
        
        // Clear validation messages
        document.getElementById('old_values_validation').innerHTML = '';
        document.getElementById('new_values_validation').innerHTML = '';
        document.getElementById('old_values').classList.remove('border-red-500', 'border-green-500');
        document.getElementById('new_values').classList.remove('border-red-500', 'border-green-500');
        
        // Clear authorization fields
        document.getElementById('authorization_reason').value = '';
        document.getElementById('authorization_notes').value = '';
        
        // Uncheck confirmation boxes
        document.getElementById('understand_implications').checked = false;
        document.getElementById('have_authorization').checked = false;
        document.getElementById('irreversible_action').checked = false;
        
        updateActionPreview();
        updateEntityOptions();
    }
}

// Final confirmation before submission
function confirmUpdate() {
    const reason = document.getElementById('authorization_reason').value;
    const notes = document.getElementById('authorization_notes').value.trim();
    
    if (!reason || !notes) {
        alert('Please provide both authorization reason and detailed notes before proceeding.');
        return false;
    }
    
    const confirmMessage = `
WARNING: You are about to modify a permanent audit log record.

This action will:
• Permanently alter audit log #{{ $auditLog->id }}
• Create an additional audit trail of this modification
• Potentially impact compliance and legal requirements
• Be irreversible once completed

Reason: ${reason}
Notes: ${notes}

Do you want to proceed with this critical operation?
    `;
    
    return confirm(confirmMessage);
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
    
    // Check authorization fields
    const reason = document.getElementById('authorization_reason').value;
    const notes = document.getElementById('authorization_notes').value.trim();
    
    if (!reason || !notes) {
        e.preventDefault();
        alert('Authorization reason and notes are required for audit log modifications.');
        return;
    }
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateActionPreview();
    updateEntityOptions();
    
    // Validate existing JSON on load
    if (document.getElementById('old_values').value.trim()) {
        validateJson('old_values');
    }
    if (document.getElementById('new_values').value.trim()) {
        validateJson('new_values');
    }
});
</script>
@endsection
