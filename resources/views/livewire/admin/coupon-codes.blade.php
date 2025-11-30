<div>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Counpons
    </h2>
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        @if (session()->has('success'))
            <a class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
                href="{{route('admin.coupon.add')}}">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                        </path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <span>Add coupons &RightArrow;</span>
            </a>
        @endif
        <h2 class="mt-4 ml-4 text-xs font-semibold text-gray-700 dark:text-gray-200">
            Add Coupon
        </h2>
        <form wire:submit.prevent="storeCoupon" class="flex justify-around ml-4 mt-2 flex-1 lg:mr-32">

            <input type="text" wire:model.live="code"
                class="block mr-2 text-sm dark:text-gray-300 border-0 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                placeholder="Code" style="width: 175px" required />
            <input type="number" wire:model.live="discount"
                class="block mr-2 text-sm dark:text-gray-300 border-0 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                placeholder="Discount percent" style="width: 175px" required />
            <input type="date" wire:model.live="startDate"
                class="block mr-2 text-sm dark:text-gray-300 border-0 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                placeholder="Start Date" style="width: 95px" required />

            <input type="date" wire:model.live="endDate"
                class="block mr-2 text-sm dark:text-gray-300 border-0 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                placeholder="End Date" style="width: 95px" required />

            <button type="submit" wire:loading.class="opacity-50 cursor-not-allowed"
                wire:loading.remove.class="active:bg-purple-600 hover:bg-purple-700 focus:shadow-outline-purple"
                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Create
            </button>
        </form>
        @error('discount')
            <span class="text-xs text-red-600 dark:text-red-400">
                {{$message}}
            </span>
        @enderror
        @error('startDate')
            <span class="text-xs text-red-600 dark:text-red-400">
                {{$message}}
            </span>
        @enderror
        @error('endDate')
            <span class="text-xs text-red-600 dark:text-red-400">
                {{$message}}
            </span>
        @enderror

        <div class="w-full pl-4 mt-4 overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Code</th>
                        <th class="px-4 py-3">Percentage</th>
                        <th class="px-4 py-3">Start Date</th>
                        <th class="px-4 py-3">End Date</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($coupons as $coupon)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">

                                    <div>
                                        <p class="font-semibold"> {{$coupon->code}} </p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">

                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{$coupon->discount_percentage}}%
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{$coupon->start_date}}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{$coupon->end_date}}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center space-x-4 text-sm">

                                    <flux:modal.trigger name="edit-coupon">
                                        <button
                                            wire:click="$dispatch('open-coupon-modal', { mode: 'edit', coupon: '{{ $coupon->id }}' })"
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                            aria-label="Edit">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                </path>
                                            </svg>
                                        </button>
                                    </flux:modal.trigger>

                                    <flux:modal.trigger name="delete-coupon">
                                        <button wire:click="$dispatch('delete-coupon', {id: {{ $coupon->id}}})"
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
                                        No coupons found
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>
    </div>

    <flux:modal name="edit-coupon" class="w-full bg-white rounded-t-lg dark:bg-gray-800  sm:rounded-lg sm:max-w-xl">
        <div>
            <div class="text-center mt-8 mb-2">
                <flux:text class="text-gray-700 dark:text-gray-400">Edit Coupon
                </flux:text>
            </div>

            <div class="mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <form id="update_coupon" wire:submit.prevent="updateCoupon">
                    <label class="block text-sm mb-2">
                        <span class="text-gray-700 dark:text-gray-400">
                            Code
                        </span>
                        <input type="text" wire:model.defer="editCode"
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                            placeholder="Code" disabled />
                        @error('editCode')
                            <span class="text-xs text-red-600 dark:text-red-400">
                                {{$message}}
                            </span>
                        @enderror

                    </label>

                    <label class="block text-sm mb-2">
                        <span class="text-gray-700 dark:text-gray-400">
                            Discount Percentage
                        </span>
                        <input type="text" wire:model.defer="editDiscount"
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                            placeholder="Discount" required />
                        @error('editDiscount')
                            <span class="text-xs text-red-600 dark:text-red-400">
                                {{$message}}
                            </span>
                        @enderror

                    </label>

                    <label class="block text-sm mb-2">
                        <span class="text-gray-700 dark:text-gray-400">
                            Start Date
                        </span>
                        <input type="date" wire:model.defer="editStartDate"
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                            placeholder="Start Date" required />
                        @error('editStartDate')
                            <span class="text-xs text-red-600 dark:text-red-400">
                                {{$message}}
                            </span>
                        @enderror

                    </label>

                    <label class="block text-sm mb-2">
                        <span class="text-gray-700 dark:text-gray-400">
                            End Date
                        </span>
                        <input type="date" wire:model.defer="editEndDate"
                            class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                            placeholder="End Date" required />
                        @error('editEndDate')
                            <span class="text-xs text-red-600 dark:text-red-400">
                                {{$message}}
                            </span>
                        @enderror

                    </label>
                </form>
            </div>

            <div class="flex">
                <flux:spacer />
                <button type="submit" form="update_coupon"
                    class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Save
                </button>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="delete-coupon" class="bg-white rounded-t-lg dark:bg-gray-800">
        <div>
            <div class="text-center mt-8 mb-2">
                <flux:text class="text-gray-700 dark:text-gray-400">Delete coupon?
                </flux:text>
            </div>

            <div class="mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <span class="text-sm text-gray-600 dark:text-gray-400">You're about to delete this coupon</span>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    This might affect order under this coupon</p>
            </div>

            <div class="flex">
                <flux:spacer />

                <flux:modal.close>
                    <button
                        class="w-full mr-4 px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                        Cancel
                    </button>
                </flux:modal.close>

                <button wire:click="deleteCoupon"
                    class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
                    delete
                </button>
            </div>
        </div>
    </flux:modal>
</div>