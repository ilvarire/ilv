<div>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Add Shipping Rate
    </h2>
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form wire:submit.prevent="storeShippingFee" method="post" id="add_shipping_fee">
            @csrf
            @if (session()->has('success'))
                <a class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
                    href="{{route('admin.rates')}}">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <span>View all &RightArrow;</span>
                </a>
            @endif

            <label class="block text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">
                    Country
                </span>
                <select wire:model="country_id" value="{{ old('country_id') }}"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <option class="" value="">Select Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
                @error('country_id')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror

            </label>

            <label class="block text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">
                    State
                </span>
                <input type="text" wire:model="state" value="{{ old('state') }}"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    placeholder="State" required />
                @error('state')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror

            </label>

            <label class="block text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">
                    Base Fee
                </span>
                <input type="text" wire:model="base_fee" value="{{ old('base_fee') }}" name="money"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    placeholder="0.00" required />
                @error('base_fee')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror
            </label>

            <label class="block text-sm mb-2">
                <span class="text-gray-700 dark:text-gray-400">
                    Fee Per Kg
                </span>
                <input type="text" wire:model="fee_per_kg" value="{{ old('fee_per_kg') }}" name="money"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
                    placeholder="0.00" required />
                @error('fee_per_kg')
                    <span class="text-xs text-red-600 dark:text-red-400">
                        {{$message}}
                    </span>
                @enderror
            </label>


        </form>
        <button type="submit" form="add_shipping_fee" wire:loading.class="opacity-50 cursor-not-allowed"
            wire:loading.remove.class="active:bg-purple-600 hover:bg-purple-700 focus:shadow-outline-purple"
            class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
            Create
        </button>
    </div>
</div>