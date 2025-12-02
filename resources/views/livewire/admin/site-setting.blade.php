<div>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Site settings
    </h2>
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

        @if (session()->has('success'))
            <a class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
                href="{{route('admin.dashboard')}}">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                        </path>
                    </svg>
                    <span>Updated successfully</span>
                </div>
                <span>Home &RightArrow;</span>
            </a>
        @endif

    </div>
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <label class="block text-sm mb-2">
            <span class="text-gray-700 mr-2 dark:text-gray-400">
                Maintenance mode
            </span>
            <a href="javascript:;" wire:click="toggleMaintenance()">
                <span
                    class="px-4 py-1 font-semibold leading-tight {{$general->maintenance ? 'text-green-700 bg-green-100' : 'text-red-600 bg-gray-50'}} rounded-md {{$general->maintenance ? 'dark:bg-green-700 dark:text-green-100' : 'text-red-600 bg-gray-50'}}">
                    {{$general->maintenance ? 'On' : 'Off'}}
                </span>
            </a>
        </label>

    </div>

    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Site Information
    </h2>
    <form wire:submit.prevent="updateSiteInfo" id="update_info">
        <span class="text-purple-600">OG Image | Logo | Favicon</span>
        <div class="grid gap-6 mb-6 mt-4 md:grid-cols-2 xl:grid-cols-4">
            @if ($existing_og_image)
                <img src="{{ asset('storage/' . $existing_og_image) }}" alt="" class="rounded-lg" loading="lazy" />
            @endif
            @if ($existing_logo)
                <img src="{{ asset('storage/' . $existing_logo) }}" alt="" class="rounded-lg" loading="lazy" />
            @endif
            @if ($existing_favicon)
                <img src="{{ asset('storage/' . $existing_favicon) }}" alt="" class="rounded-lg" loading="lazy" />
            @endif

        </div>
        <label class="block text-sm mb-2">
            <span class="text-gray-700 dark:text-gray-400">
                Policy
            </span>
            <textarea wire:model="policy" value="{{ old('policy') }}"
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                rows="3" placeholder=""></textarea>
            @error('policy')
                <span class="text-xs text-red-600 dark:text-red-400">
                    {{$message}}
                </span>
            @enderror

        </label>

        <label class="block text-sm mb-2">
            <span class="text-gray-700 dark:text-gray-400">
                Site Description
            </span>
            <textarea wire:model="site_description" value="{{ old('site_description') }}"
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                rows="3" placeholder=""></textarea>
            @error('site_description')
                <span class="text-xs text-red-600 dark:text-red-400">
                    {{$message}}
                </span>
            @enderror
        </label>

        <label class="block text-sm mb-2">
            <span class="text-gray-700 dark:text-gray-400">
                Site Title
            </span>
            <input type="text" wire:model="site_title" value="{{ old('site_title') }}"
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                placeholder="" required />
            @error('site_title')
                <span class="text-xs text-red-600 dark:text-red-400">
                    {{$message}}
                </span>
            @enderror
        </label>

        <label class="block text-sm mb-2">
            <span class="text-gray-700 dark:text-gray-400">
                Top Text
            </span>
            <input type="text" wire:model="top_text" value="{{ old('top_text') }}"
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                placeholder="" required />
            @error('top_text')
                <span class="text-xs text-red-600 dark:text-red-400">
                    {{$message}}
                </span>
            @enderror
        </label>

        <label class="block text-sm mb-2">
            <span class="text-gray-700 dark:text-gray-400">
                OG Image
            </span>

            <input type="file" accept=".jpg, .jpeg, .png" wire:model="og_image" value="{{ old('og_image') }}"
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                placeholder="Select Image" />
            @error('og_image')
                <span class="text-xs text-red-600 dark:text-red-400">
                    {{$message}}
                </span>
            @enderror
        </label>

        @if ($og_image)
            <div class="grid gap-6 mb-6 mt-4 md:grid-cols-2 xl:grid-cols-4">
                <img src="{{ $og_image->temporaryUrl() }}" alt="img" class="rounded-lg">
            </div>
        @endif

        <label class="block text-sm mb-2">
            <span class="text-gray-700 dark:text-gray-400">
                Favicon
            </span>

            <input type="file" accept=".svg" wire:model="favicon" value="{{ old('favicon') }}"
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                placeholder="Select Image" />
            @error('favicon')
                <span class="text-xs text-red-600 dark:text-red-400">
                    {{$message}}
                </span>
            @enderror
        </label>

        @if ($favicon)
            <div class="grid gap-6 mb-6 mt-4 md:grid-cols-2 xl:grid-cols-4">
                <img src="{{ $favicon->temporaryUrl() }}" alt="img" class="rounded-lg">
            </div>
        @endif

        <label class="block text-sm mb-2">
            <span class="text-gray-700 dark:text-gray-400">
                Logo
            </span>

            <input type="file" accept=".svg, .png" wire:model="logo" value="{{ old('logo') }}"
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                placeholder="Select Image" />
            @error('logo')
                <span class="text-xs text-red-600 dark:text-red-400">
                    {{$message}}
                </span>
            @enderror
        </label>
        @if ($logo)
            <div class="grid gap-6 mb-6 mt-4 md:grid-cols-2 xl:grid-cols-4">
                <img src="{{ $logo->temporaryUrl() }}" alt="img" class="rounded-lg">
            </div>
        @endif

        <button type="submit" form="update_info" wire:loading.class="opacity-50 cursor-not-allowed"
            wire:loading.remove.class="active:bg-purple-600 hover:bg-purple-700 focus:shadow-outline-purple"
            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            Update Site Info
        </button>
        <br>
    </form>
</div>