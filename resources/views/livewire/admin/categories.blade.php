<div>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Categories
    </h2>

    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        @if (session()->has('success'))
            <a class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
                href="{{route('admin.products.add')}}">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                        </path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <span>Add Product &RightArrow;</span>
            </a>
        @endif
        <h2 class="mt-4 ml-4 text-xs font-semibold text-gray-700 dark:text-gray-200">
            Add Category
        </h2>
        <form wire:submit.prevent="storeCategory" enctype="multipart/form-data"
            class="flex justify-around ml-4 mt-2 flex-1 lg:mr-32">

            <input type="text" wire:model.live="name"
                class="block mr-2 text-sm dark:text-gray-300 border-0 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                placeholder="Name" style="width: 175px" required />
            <input type="file" wire:model="image" accept="image/*"
                class="block w-xs mt-1 mr-6 text-sm dark:text-gray-300 border-0 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                placeholder="Image" style="width: 175px" required />

            <button type="submit" wire:loading.class="opacity-50 cursor-not-allowed"
                wire:loading.remove.class="active:bg-purple-600 hover:bg-purple-700 focus:shadow-outline-purple"
                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Create
            </button>
        </form>
        @error('name')
            <span class="text-xs text-red-600 dark:text-red-400">
                {{$message}}
            </span>
        @enderror
        @error('image')
            <span class="text-xs text-red-600 dark:text-red-400">
                {{$message}}
            </span>
        @enderror

        <div class="w-full pl-4 mt-4 overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Image</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($categories as $category)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                {{$loop->index + 1}}.
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <!-- Avatar with inset shadow -->

                                    <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                        @if ($category->image_url)
                                            <img class="object-cover w-full h-full rounded-lg"
                                                src="{{ asset('storage/' . $category->image_url) }}" alt="" loading="lazy" />
                                        @else
                                            <img class="object-cover w-full h-full rounded-lg"
                                                src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjE3Nzg0fQ"
                                                alt="" loading="lazy" />
                                        @endif

                                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                    </div>
                                    <div>
                                        <p class="font-semibold">
                                        </p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">

                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">

                                    <div>
                                        <p class="font-semibold"> {{$category->name}} </p>
                                        @if ($category->is_featured)
                                            <span
                                                class="inline-flex items-center rounded-md bg-red-100 px-2 py-0 text-xs font-medium text-red-700 inset-ring inset-ring-red-100">
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3 text-sm">
                                {{$category->created_at}}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">
                                    <flux:modal.trigger name="edit-category">
                                        <button
                                            wire:click="$dispatch('open-cat-modal', { mode: 'edit', category: '{{ $category->slug }}' })"
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Edit">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                </path>
                                            </svg>

                                        </button>
                                    </flux:modal.trigger>

                                    <flux:modal.trigger name="delete-category">
                                        <button wire:click="$dispatch('delete-category', {id: {{ $category->id}}})"
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Delete">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </flux:modal.trigger>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3" colspan="5">
                                <div class="flex items-center text-sm">
                                    <span class="flex items-center col-span-3">
                                        No categories found
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>
    </div>

    <flux:modal name="edit-category" class="w-full bg-white rounded-t-lg dark:bg-gray-800  sm:rounded-lg sm:max-w-xl">
        <div>
            <div class="text-center mt-8 mb-2">
                <flux:text class="text-gray-700 dark:text-gray-400">Edit category
                </flux:text>
            </div>

            <div class="mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <form id="update_category" enctype="multipart/form-data" wire:submit.prevent="updateCategory">
                    <div class="grid gap-6 mb-6 mt-4 md:grid-cols-2 xl:grid-cols-4">
                        <img src="{{ asset('storage/' . $oldImage) }}" alt="img" class="rounded-lg">
                    </div>
                    <label class="block text-sm mb-2">
                        <span class="text-gray-700 dark:text-gray-400">
                            Name
                        </span>
                        <input type="text" wire:model="editName"
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                            placeholder="Name" required />
                        @error('editName')
                            <span class="text-xs text-red-600 dark:text-red-400">
                                {{$message}}
                            </span>
                        @enderror

                    </label>

                    <label class="block text-sm mb-2">
                        <span class="text-gray-700 dark:text-gray-400">
                            Featured: <span class="text-purple-600">{{ $editIsFeatured ? 'Yes' : 'No' }} </span>
                        </span>
                        <input type="checkbox" wire:model="editIsFeatured"
                            class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" />
                        <span class="ml-2">

                        </span>
                        @error('editIsFeatured')
                            <span class="text-xs text-red-600 dark:text-red-400">
                                {{$message}}
                            </span>
                        @enderror

                    </label>


                    <label class="block text-sm mb-2">
                        <span class="text-gray-700 dark:text-gray-400">
                            Image
                        </span>
                        <input type="file" accept="image/*" wire:model="editImage" value="{{ old('image_url') }}"
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                            placeholder="Select Images" />
                        @error('editImage')
                            <span class="text-xs text-red-600 dark:text-red-400">
                                {{$message}}
                            </span>
                        @enderror

                    </label>

                    @if ($editImage)
                        <div class="grid gap-6 mb-6 mt-4 md:grid-cols-2 xl:grid-cols-4">
                            <img src="{{ $editImage->temporaryUrl() }}" alt="img" class="rounded-lg">
                        </div>
                    @endif

                </form>
            </div>

            <div class="flex">
                <flux:spacer />

                <button type="submit" form="update_category"
                    class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Save
                </button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="delete-category" class="bg-white rounded-t-lg dark:bg-gray-800">
        <div>
            <div class="text-center mt-8 mb-2">
                <flux:text class="text-gray-700 dark:text-gray-400">Delete category?
                </flux:text>
            </div>

            <div class="mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <span class="text-sm text-gray-600 dark:text-gray-400">You're about to delete this category</span>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    This will affect product under this category</p>
            </div>

            <div class="flex">
                <flux:spacer />

                <flux:modal.close>
                    <button
                        class="w-full mr-4 px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                        Cancel
                    </button>
                </flux:modal.close>

                <button wire:click="deleteCategory"
                    class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
                    delete
                </button>
            </div>
        </div>
    </flux:modal>
</div>