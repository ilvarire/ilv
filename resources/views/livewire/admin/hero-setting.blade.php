<div x-data="{ showModal: false, action: '', heroId: null }" x-on:modal-close.window="showModal = false">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Heroes
    </h2>
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
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
                <span>Dashboard &RightArrow;</span>
            </a>
        @endif
        <div class="w-full pl-4 mt-4 overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Heading</th>
                        <th class="px-4 py-3">Main Text</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($heros as $hero)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold"> {{$hero->heading}} </p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">

                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{$hero->main_text}}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    <button wire:click="edit({{ $hero->id }})"
                                        @click="action = 'edit'; heroId = {{ $hero->id }}; showModal = true"
                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                        aria-label="Edit">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                            </path>
                                        </svg>

                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <span class="flex items-center col-span-3">
                                        No hero found
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>
    </div>

    <!-- Modal backdrop. This what you want to place close to the closing body tag -->
    <div x-show="showModal" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
        style="padding-top: 10px;padding-bottom: 10px;">

        <!-- Modal -->
        <div x-show="showModal" x-transition:enter="transition ease-out duration-150" x-cloak
            x-transition:enter-start="opacity-0 transform translate-y-1/2" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0  transform translate-y-1/2" @click.away="showModal = false"
            @keydown.escape="showModal = false"
            class="w-full h-full overflow-y-auto px-6 py-6 bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
            role="dialog" id="modal">

            <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
            <header class="flex justify-end" style="padding-top: 8px;">
                <button
                    class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
                    aria-label="close" @click="showModal = false">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                        <path
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                </button>
            </header>
            <!-- Modal body -->
            <div class="mt-4 mb-6">
                <template x-if="action === 'edit'">
                    <div>
                        <!-- Modal title -->
                        <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                            Edit Hero
                        </p>

                        <div class="grid gap-6 mb-6 mt-4 md:grid-cols-2 xl:grid-cols-4">
                            @if ($existingHeroImage)
                                <img src="{{ asset('storage/' . $existingHeroImage) }}" alt="" class="rounded-lg"
                                    loading="lazy" />
                            @endif
                        </div>

                        <!-- Modal description -->
                        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                            <form method="POST" wire:submit.prevent="updateHero" enctype="multipart/form-data"
                                id="update_hero">
                                @csrf
                                <label class="block text-sm mb-2">
                                    <span class="text-gray-700 dark:text-gray-400">
                                        Heading
                                    </span>
                                    <input type="text" wire:model.defer="heading"
                                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="Heading" required />
                                    @error('heading')
                                        <span class="text-xs text-red-600 dark:text-red-400">
                                            {{$message}}
                                        </span>
                                    @enderror

                                </label>

                                <label class="block text-sm mb-2">
                                    <span class="text-gray-700 dark:text-gray-400">
                                        Main Text
                                    </span>
                                    <input type="text" wire:model.defer="main_text"
                                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="Main" required />
                                    @error('main_text')
                                        <span class="text-xs text-red-600 dark:text-red-400">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </label>

                                <label class="block text-sm mb-2">
                                    <span class="text-gray-700 dark:text-gray-400">
                                        Link
                                    </span>
                                    <input type="text" wire:model.defer="link"
                                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="Link" required />
                                    @error('link')
                                        <span class="text-xs text-red-600 dark:text-red-400">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </label>

                                <label class="block text-sm mb-2">
                                    <span class="text-gray-700 dark:text-gray-400">
                                        Text Color
                                    </span>
                                    <input type="color" wire:model.defer="text_color"
                                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="Text Color" required />
                                    @error('text_color')
                                        <span class="text-xs text-red-600 dark:text-red-400">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </label>

                                <label class="block text-sm mb-2">
                                    <span class="text-gray-700 dark:text-gray-400">
                                        Hero image
                                    </span>

                                    <input type="file" accept="image/*" wire:model="heroImage"
                                        value="{{ old('heroImage') }}"
                                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="Select Image" />
                                    @error('heroImage')
                                        <span class="text-xs text-red-600 dark:text-red-400">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </label>

                                @if ($heroImage)
                                    <div class="grid gap-6 mb-6 mt-4 md:grid-cols-2 xl:grid-cols-4">
                                        <img src="{{ $heroImage->temporaryUrl() }}" alt="img" class="rounded-lg">
                                    </div>
                                @endif
                            </form>
                        </div>

                        <footer
                            class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">

                            <button @click="showModal = false"
                                class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                                Cancel
                            </button>
                            <button type="submit" form="update_hero" wire:loading.class="opacity-50 cursor-not-allowed"
                                wire:loading.remove.class="active:bg-purple-600 hover:bg-purple-700 focus:shadow-outline-purple"
                                class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Save
                            </button>
                        </footer>
                    </div>
                </template>
            </div>

        </div>
    </div>
    <!-- End of modal backdrop -->
</div>