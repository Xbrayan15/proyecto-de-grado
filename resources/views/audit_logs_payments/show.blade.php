@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-3 rounded-xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Audit Log Details</h1>
                            <p class="text-gray-600 mt-1">Detailed audit log information and changes</p>
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
                    @if($auditLog->created_at->diffInDays(now()) <= 30)
                    <button onclick="exportAuditLog()" 
                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export Log
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Basic Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Log ID</label>
                                    <p class="mt-1 text-xl font-bold text-gray-900">#{{ $auditLog->id }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Action</label>
                                    <div class="mt-1">
                                        @php
                                            $actionColors = [
                                                'create' => 'bg-green-100 text-green-800 border-green-200',
                                                'update' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'delete' => 'bg-red-100 text-red-800 border-red-200',
                                                'view' => 'bg-purple-100 text-purple-800 border-purple-200',
                                                'login' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                                'logout' => 'bg-gray-100 text-gray-800 border-gray-200'
                                            ];
                                            $actionColor = $actionColors[strtolower($auditLog->action)] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium border {{ $actionColor }}">
                                            {{ ucfirst($auditLog->action) }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Entity Type</label>
                                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $auditLog->entity_type }}</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Entity ID</label>
                                    <p class="mt-1 text-xl font-bold text-gray-900">#{{ $auditLog->entity_id }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Timestamp</label>
                                    <p class="mt-1 text-lg text-gray-900">{{ $auditLog->created_at->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ $auditLog->created_at->format('h:i:s A') }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Time Ago</label>
                                    <p class="mt-1 text-lg text-gray-900">{{ $auditLog->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Information Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            User Information
                        </h2>
                    </div>
                    <div class="p-6">
                        @if($auditLog->user)
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                    {{ strtoupper(substr($auditLog->user->name, 0, 2)) }}
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Name</label>
                                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $auditLog->user->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Email</label>
                                        <p class="mt-1 text-lg text-gray-900">{{ $auditLog->user->email }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">User ID</label>
                                        <p class="mt-1 text-lg font-semibold text-gray-900">#{{ $auditLog->user->id }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Profile</label>
                                        <a href="{{ route('users.show', $auditLog->user->id) }}" 
                                           class="mt-1 inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                            View Profile
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-300 rounded-xl flex items-center justify-center text-gray-500 font-bold text-xl mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <p class="text-gray-500 font-medium">System Action</p>
                            <p class="text-sm text-gray-400">No user associated with this action</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Changes Information -->
                @if($auditLog->old_values || $auditLog->new_values)
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-600 to-orange-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Data Changes
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            @if($auditLog->old_values)
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <span class="w-4 h-4 bg-red-500 rounded-full mr-2"></span>
                                    Previous Values
                                </h3>
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                    <pre class="text-sm text-gray-800 whitespace-pre-wrap overflow-x-auto">{{ json_encode(json_decode($auditLog->old_values), JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                            @endif

                            @if($auditLog->new_values)
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <span class="w-4 h-4 bg-green-500 rounded-full mr-2"></span>
                                    New Values
                                </h3>
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <pre class="text-sm text-gray-800 whitespace-pre-wrap overflow-x-auto">{{ json_encode(json_decode($auditLog->new_values), JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        @if($auditLog->old_values && $auditLog->new_values)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <button onclick="showChangesComparison()" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                View Detailed Comparison
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Technical Details Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-slate-600 to-gray-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Technical Details
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">IP Address</label>
                            <p class="mt-1 text-lg font-mono text-gray-900">{{ $auditLog->ip_address ?: 'N/A' }}</p>
                            @if($auditLog->ip_address)
                            <a href="https://whatismyipaddress.com/ip/{{ $auditLog->ip_address }}" target="_blank" 
                               class="text-sm text-blue-600 hover:text-blue-800">
                                Lookup IP Details →
                            </a>
                            @endif
                        </div>
                        
                        @if($auditLog->user_agent)
                        <div>
                            <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">User Agent</label>
                            <p class="mt-1 text-sm text-gray-700 break-all">{{ Str::limit($auditLog->user_agent, 100) }}</p>
                            @if(strlen($auditLog->user_agent) > 100)
                            <button onclick="toggleUserAgent()" class="text-sm text-blue-600 hover:text-blue-800 mt-1">
                                <span id="userAgentToggle">Show Full</span>
                            </button>
                            <div id="fullUserAgent" class="hidden mt-2 text-sm text-gray-700 break-all">
                                {{ $auditLog->user_agent }}
                            </div>
                            @endif
                        </div>
                        @endif

                        <div>
                            <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Record Created</label>
                            <p class="mt-1 text-sm text-gray-700">{{ $auditLog->created_at->format('F j, Y g:i:s A') }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Record Updated</label>
                            <p class="mt-1 text-sm text-gray-700">{{ $auditLog->updated_at->format('F j, Y g:i:s A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Security Status Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-red-600 to-pink-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Security Status
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @php
                            $criticalActions = ['delete', 'create', 'update'];
                            $isCritical = in_array(strtolower($auditLog->action), $criticalActions);
                            $isRecent = $auditLog->created_at->diffInHours(now()) <= 24;
                        @endphp
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Action Criticality</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $isCritical ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $isCritical ? 'High' : 'Low' }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Time Sensitivity</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $isRecent ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $isRecent ? 'Recent' : 'Historical' }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">User Context</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $auditLog->user ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $auditLog->user ? 'Authenticated' : 'System' }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Data Changes</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ ($auditLog->old_values || $auditLog->new_values) ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ($auditLog->old_values || $auditLog->new_values) ? 'Modified' : 'No Changes' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Quick Actions
                        </h3>
                    </div>
                    <div class="p-6 space-y-3">
                        @if($auditLog->entity_type === 'Transaction' && $auditLog->entity_id)
                        <a href="{{ route('transactions.show', $auditLog->entity_id) }}" 
                           class="flex items-center justify-between p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group">
                            <span class="text-sm font-medium text-blue-700">View Transaction</span>
                            <svg class="w-4 h-4 text-blue-500 group-hover:text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        @endif
                        
                        @if($auditLog->entity_type === 'PaymentGateway' && $auditLog->entity_id)
                        <a href="{{ route('payment-gateways.show', $auditLog->entity_id) }}" 
                           class="flex items-center justify-between p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors group">
                            <span class="text-sm font-medium text-purple-700">View Payment Gateway</span>
                            <svg class="w-4 h-4 text-purple-500 group-hover:text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        @endif
                        
                        <a href="{{ route('audit-logs-payments.index', ['entity_type' => $auditLog->entity_type]) }}" 
                           class="flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors group">
                            <span class="text-sm font-medium text-gray-700">Related Logs</span>
                            <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        
                        @if($auditLog->user)
                        <a href="{{ route('audit-logs-payments.index', ['user_id' => $auditLog->user->id]) }}" 
                           class="flex items-center justify-between p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors group">
                            <span class="text-sm font-medium text-green-700">User Activity</span>
                            <svg class="w-4 h-4 text-green-500 group-hover:text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Comparison Modal -->
<div id="comparisonModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-6xl w-full max-h-[90vh] overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex items-center justify-between">
            <h3 class="text-xl font-semibold text-white">Detailed Changes Comparison</h3>
            <button onclick="closeComparisonModal()" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-6 overflow-y-auto max-h-[80vh]" id="comparisonContent">
            <!-- Content will be populated by JavaScript -->
        </div>
    </div>
</div>

<script>
function toggleUserAgent() {
    const fullUserAgent = document.getElementById('fullUserAgent');
    const toggle = document.getElementById('userAgentToggle');
    
    if (fullUserAgent.classList.contains('hidden')) {
        fullUserAgent.classList.remove('hidden');
        toggle.textContent = 'Show Less';
    } else {
        fullUserAgent.classList.add('hidden');
        toggle.textContent = 'Show Full';
    }
}

function showChangesComparison() {
    const modal = document.getElementById('comparisonModal');
    const content = document.getElementById('comparisonContent');
    
    @if($auditLog->old_values && $auditLog->new_values)
    const oldValues = @json(json_decode($auditLog->old_values));
    const newValues = @json(json_decode($auditLog->new_values));
    
    let comparisonHtml = '<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">';
    
    // Get all unique keys
    const allKeys = [...new Set([...Object.keys(oldValues || {}), ...Object.keys(newValues || {})])];
    
    allKeys.forEach(key => {
        const oldValue = oldValues ? oldValues[key] : null;
        const newValue = newValues ? newValues[key] : null;
        const hasChanged = JSON.stringify(oldValue) !== JSON.stringify(newValue);
        
        comparisonHtml += `
            <div class="border ${hasChanged ? 'border-amber-200 bg-amber-50' : 'border-gray-200 bg-gray-50'} rounded-lg p-4">
                <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                    ${hasChanged ? '<span class="w-3 h-3 bg-amber-500 rounded-full mr-2"></span>' : '<span class="w-3 h-3 bg-gray-400 rounded-full mr-2"></span>'}
                    ${key}
                </h4>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs font-medium text-red-600 uppercase tracking-wide">Previous</label>
                        <div class="mt-1 bg-red-50 border border-red-200 rounded p-2 text-sm">
                            <code>${oldValue !== null ? JSON.stringify(oldValue, null, 2) : 'N/A'}</code>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-green-600 uppercase tracking-wide">Current</label>
                        <div class="mt-1 bg-green-50 border border-green-200 rounded p-2 text-sm">
                            <code>${newValue !== null ? JSON.stringify(newValue, null, 2) : 'N/A'}</code>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    
    comparisonHtml += '</div>';
    content.innerHTML = comparisonHtml;
    @endif
    
    modal.classList.remove('hidden');
}

function closeComparisonModal() {
    document.getElementById('comparisonModal').classList.add('hidden');
}

function exportAuditLog() {
    const logData = {
        id: {{ $auditLog->id }},
        action: '{{ $auditLog->action }}',
        entity_type: '{{ $auditLog->entity_type }}',
        entity_id: {{ $auditLog->entity_id }},
        user: @json($auditLog->user ? ['id' => $auditLog->user->id, 'name' => $auditLog->user->name, 'email' => $auditLog->user->email] : null),
        old_values: @json($auditLog->old_values ? json_decode($auditLog->old_values) : null),
        new_values: @json($auditLog->new_values ? json_decode($auditLog->new_values) : null),
        ip_address: '{{ $auditLog->ip_address }}',
        user_agent: '{{ $auditLog->user_agent }}',
        created_at: '{{ $auditLog->created_at->toISOString() }}',
        updated_at: '{{ $auditLog->updated_at->toISOString() }}'
    };
    
    const blob = new Blob([JSON.stringify(logData, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `audit_log_${logData.id}_${new Date().toISOString().split('T')[0]}.json`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

// Close modal when clicking outside
document.getElementById('comparisonModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeComparisonModal();
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeComparisonModal();
    }
});
</script>
@endsection