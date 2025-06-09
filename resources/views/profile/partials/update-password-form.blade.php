<div class="bg-white rounded-lg shadow-md p-6">
    <div class="mb-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">
            <i class="fas fa-lock mr-2 text-green-600"></i>
            {{ __('Update Password') }}
        </h3>
        <p class="text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-2">
                {{ __('Current Password') }}
            </label>
            <div class="relative">
                <input 
                    id="update_password_current_password" 
                    name="current_password" 
                    type="password" 
                    class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200" 
                    autocomplete="current-password"
                >
                <i class="fas fa-key absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            @error('current_password', 'updatePassword')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('New Password') }}
                </label>
                <div class="relative">
                    <input 
                        id="update_password_password" 
                        name="password" 
                        type="password" 
                        class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200" 
                        autocomplete="new-password"
                    >
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('password', 'updatePassword')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('Confirm Password') }}
                </label>
                <div class="relative">
                    <input 
                        id="update_password_password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200" 
                        autocomplete="new-password"
                    >
                    <i class="fas fa-check-circle absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('password_confirmation', 'updatePassword')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3"></i>
                <div>
                    <h4 class="text-sm font-medium text-blue-800 mb-1">Password Requirements</h4>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• At least 8 characters long</li>
                        <li>• Include uppercase and lowercase letters</li>
                        <li>• Include at least one number</li>
                        <li>• Include at least one special character</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <button 
                type="submit" 
                class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
            >
                <i class="fas fa-shield-alt mr-2"></i>
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <div 
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center text-green-600"
                >
                    <i class="fas fa-check-circle mr-2"></i>
                    <span class="text-sm font-medium">{{ __('Password updated successfully!') }}</span>
                </div>
            @endif
        </div>
    </form>
</div>
