<div>
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        All Customers
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
        <!-- Search input -->
        <div class="flex justify-between my-6 flex-1 lg:mr-32">
            <div>
                <button wire:click="$set('search', '')"
                    class="flex items-center justify-between mt-1 ml-4 px-2 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    aria-label="Like">
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 512 512">
                        <path
                            d="M48.5 224L40 224c-13.3 0-24-10.7-24-24L16 72c0-9.7 5.8-18.5 14.8-22.2s19.3-1.7 26.2 5.2L98.6 96.6c87.6-86.5 228.7-86.2 315.8 1c87.5 87.5 87.5 229.3 0 316.8s-229.3 87.5-316.8 0c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0c62.5 62.5 163.8 62.5 226.3 0s62.5-163.8 0-226.3c-62.2-62.2-162.7-62.5-225.3-1L185 183c6.9 6.9 8.9 17.2 5.2 26.2s-12.5 14.8-22.2 14.8L48.5 224z"
                            clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <div class="relative w-xs max-w-xl mr-6 focus-within:text-purple-500">
                <div class="absolute inset-y-0 flex items-center pl-2">
                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input wire:model.live.debounce.500ms="search"
                    class="w-full pl-8 mt-1 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                    type="text" placeholder="Search for customers" aria-label="Search" />
            </div>

        </div>
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Active</th>
                        <th class="px-4 py-3">Date</th>

                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($customers as $customer)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                {{$loop->index + 1}}.
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <!-- Avatar with inset shadow -->

                                    <div>
                                        <p class="font-semibold"> {{$customer->name}} </p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            {{$customer->email}}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <button wire:click=""
                                    class="{{$customer->is_active ? 'px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100' : 'px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700'}}">
                                    {{$customer->is_active ? 'ACTIVE' : 'inactive'}}
                                </button>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{$customer->created_at}}
                            </td>

                        </tr>
                    @empty
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3" colspan="4">
                                <div class="flex items-center justify-center text-sm">
                                    <span class="flex items-center col-span-3">
                                        No customer found
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>
        <div
            class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
            <span class="flex items-center col-span-3">
                @if ($customers->total() > 0)
                    Showing {{ $customers->firstItem() }}-{{ $customers->LastItem() }} of {{ $customers->total() }}
                @else

                @endif

            </span>
            <span class="col-span-2"></span>
            <!-- Pagination -->
            <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">

                {{ $customers->links() }}
            </span>
        </div>
    </div>
</div>