<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                @if (session()->has('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                        <div id="alert">
                            <div class="p-4 mb-4 text-sm text-teal-800 bg-teal-100 border border-teal-200 rounded-lg"
                                role="alert">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                @elseif (session()->has('warning'))
                    <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                        <div id="alert">
                            <div class="p-4 mb-4 text-sm text-yellow-800 bg-yellow-100 border border-yellow-200 rounded-lg"
                                role="alert">
                                {{ session('warning') }}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">

                                {{ $slot }}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
