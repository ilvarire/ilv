<div>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Contact Setting
    </h2>
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form wire:submit.prevent="updateContact" method="post" enctype="multipart/form-data" id="update_contact">
            @csrf
            @if (session()->has('success'))
                <a class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
                    href="{{route('admin.dashboard')}}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <span>Home &RightArrow;</span>
                </a>
            @endif

            <label class="block mt-4 text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">Address</span>
                <input type="text" wire:model="address" value="{{ old('address') }}"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    placeholder="Address" required />
                @error('address')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror
            </label>

            <label class="block mt-4 text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">Phone</span>
                <input type="text" wire:model="phone_number" value="{{ old('phone_number') }}"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    placeholder="Phone" required />
                @error('phone_number')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror
            </label>

            <label class="block mt-4 text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">Email</span>
                <input type="email" wire:model="email" value="{{ old('email') }}"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    placeholder="Email" required />
                @error('email')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror
            </label>

            <label class="block mt-4 text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">Facebook Link</span>
                <input type="text" wire:model="facebook_link" value="{{ old('facebook_link') }}"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    placeholder="Facebook Link" required />
                @error('facebook_link')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror
            </label>

            <label class="block mt-4 text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">Tiktok Link</span>
                <input type="text" wire:model="tiktok_link" value="{{ old('tiktok_link') }}"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    placeholder="Tiktok Link" required />
                @error('tiktok_link')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror
            </label>

            <label class="block mt-4 text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">Instagram Link</span>
                <input type="text" wire:model="instagram_link" value="{{ old('instagram_link') }}"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    placeholder="Instagram Link" required />
                @error('instagram_link')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror
            </label>

            <label class="block mt-4 text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">Whatsapp Link</span>
                <input type="text" wire:model="whatsapp_link" value="{{ old('x_link') }}"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    placeholder="Whatsapp Link" required />
                @error('whatsapp_link')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror
            </label>

        </form>
        <button type="submit" form="update_contact" wire:loading.class="opacity-50 cursor-not-allowed"
            wire:loading.remove.class="active:bg-purple-600 hover:bg-purple-700 focus:shadow-outline-purple"
            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            Create
        </button>
    </div>

</div>