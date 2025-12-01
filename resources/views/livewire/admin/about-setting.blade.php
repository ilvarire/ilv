<div>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        About Setting
    </h2>
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form wire:submit.prevent="updateAbout" method="post" enctype="multipart/form-data" id="update_about">
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
                </a>
            @endif
            <span class="text-purple-600">Story image | Mission image</span>
            <div class="grid gap-6 mb-6 mt-4 md:grid-cols-2 xl:grid-cols-4">
                @if ($existing_story_image)
                    <img src="{{ asset('storage/' . $existing_story_image) }}" alt="" class="rounded-lg" loading="lazy" />
                @endif
                @if ($existing_mission_image)
                    <img src="{{ asset('storage/' . $existing_mission_image) }}" alt="" class="rounded-lg" loading="lazy" />
                @endif

            </div>
            <label class="block mt-4 text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">Story(paragraph1)</span>
                <textarea wire:model="story_one" value="{{ old('story_one') }}"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    rows="3" placeholder="Enter Paragraph text"></textarea>
                @error('story_one')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror
            </label>
            <label class="block mt-4 text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">Story(paragraph2)</span>
                <textarea wire:model="story_two" value="{{ old('story_two') }}"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    rows="3" placeholder="Enter second paragraph text"></textarea>
                @error('story_two')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror
            </label>
            <label class="block mt-4 text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">Mission(paragraph1)</span>
                <textarea wire:model="mission_one" value="{{ old('mission_one') }}"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    rows="3" placeholder="Enter paragraph text"></textarea>
                @error('mission_one')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror
            </label>
            <label class="block mt-4 text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">Mission(paragraph2)</span>
                <textarea wire:model="mission_two" value="{{ old('mission_two') }}"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    rows="3" placeholder="Enter mission text"></textarea>
                @error('mission_two')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror
            </label>

            <label class="block text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">
                    Story image
                </span>

                <input type="file" accept="image/*" wire:model="story_image" value="{{ old('story_image') }}"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    placeholder="Select Image" />
                @error('story_image')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror
            </label>

            @if ($story_image)
                <div class="grid gap-6 mb-6 mt-4 md:grid-cols-2 xl:grid-cols-4">
                    <img src="{{ $story_image->temporaryUrl() }}" alt="img" class="rounded-lg">
                </div>
            @endif

            <label class="block text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">
                    Mission image
                </span>
                <input type="file" accept="image/*" wire:model="mission_image" value="{{ old('mission_image') }}"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    placeholder="Select Image" />
                @error('mission_image')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror
            </label>

            @if ($mission_image)
                <div class="grid gap-6 mb-6 mt-4 md:grid-cols-2 xl:grid-cols-4">
                    <img src="{{ $mission_image->temporaryUrl() }}" alt="img" class="rounded-lg">
                </div>
            @endif

        </form>
        <button type="submit" form="update_about" wire:loading.class="opacity-50 cursor-not-allowed"
            wire:loading.remove.class="active:bg-purple-600 hover:bg-purple-700 focus:shadow-outline-purple"
            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            Create
        </button>
    </div>

</div>