<div>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Profile
    </h2>
    <span class="m-4 text-xs text-gray-700 dark:text-gray-400">
        Update your account's profile information and email address.
    </span>
    <div class="px-4 py-3 mt-1 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form wire:submit.prevent="updateProfile" method="post" id="profile">
            @csrf

            <label class="block text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">
                    Name
                </span>
                <input type="text" wire:model="name" value="{{ old('name') }}"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    placeholder="Name" required />
                @error('name')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror

            </label>

            <label class="block text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">
                    Email
                </span>
                <input type="email" wire:model="email" value="{{ old('email') }}"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    placeholder="email" required />
                @error('email')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror

            </label>

        </form>
        <button type="submit" form="profile" wire:loading.class="opacity-50 cursor-not-allowed"
            wire:loading.remove.class="active:bg-purple-600 hover:bg-purple-700 focus:shadow-outline-purple"
            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            Save
        </button>
        <div class="flex items-center gap-4">
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm mt-2 text-purple-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </div>

    {{-- update password area --}}
    <span class="m-4 text-xs text-gray-700 dark:text-gray-400">
        Update Password: Ensure your account is using a long, random password to stay secure
    </span>
    <div class="px-4 py-3 mt-1 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form wire:submit.prevent="updatePassword" method="post" id="password">
            @csrf

            <label class="block text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">
                    Current Password
                </span>
                <input type="password" wire:model="current_password"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    placeholder="Current Password" required />
                @error('current_password')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror

            </label>

            <label class="block text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">
                    New Password
                </span>
                <input type="password" wire:model="password"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    placeholder="New Password" required />
                @error('password')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror

            </label>
            <label class="block text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">
                    New Password
                </span>
                <input type="password" wire:model="password_confirmation"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    placeholder="Confirm Password" required />
                @error('password_confirmation')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror

            </label>

        </form>
        <button type="submit" form="password" wire:loading.class="opacity-50 cursor-not-allowed"
            wire:loading.remove.class="active:bg-purple-600 hover:bg-purple-700 focus:shadow-outline-purple"
            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            Save
        </button>
        <div class="flex items-center gap-4">
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm mt-2 text-purple-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </div>
</div>