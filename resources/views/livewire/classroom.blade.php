<div>
    <x-layouts-table>
        <div class="grid gap-3 px-6 py-4 border-b border-gray-200 md:flex md:justify-between md:items-center">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    {{ $title }}
                </h2>
            </div>
            <div>
                <div class="inline-flex">
                    <x-primary-button x-data="" x-on:click="$dispatch('open-modal', 'create-data')">
                        Tambah Data
                    </x-primary-button>
                </div>
            </div>
        </div>

        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="border divide-y divide-gray-200 rounded-lg">
                <div class="px-4 py-3">
                    <div class="relative max-w-xs">
                        <label for="hs-table-search" class="sr-only">Search</label>
                        <input type="search" wire:model.live="search" name="hs-table-search" id="hs-table-search"
                            class="block w-full px-3 py-2 text-sm border-gray-200 rounded-lg shadow-sm ps-9 focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                            placeholder="Search for items">
                        <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                            <svg class="text-gray-400 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8">
                                </circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-xs text-gray-500 uppercase pe-0 text-start">
                                    No
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">
                                    Nama Kelas</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">
                                    Jumlah Siswa</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">
                                    Jumlah Guru</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-end">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($classrooms as $item)
                                <tr>
                                    <th scope="col"
                                        class="px-4 py-3 text-xs text-gray-500 uppercase pe-0 text-start">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">
                                        {{ $item->class_name }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">
                                        {{ $item->students->count() }}
                                        @if ($item->students->count() >= 1)
                                            <x-primary-button class="mx-2 px-2 py-1"
                                                wire:click="getStudent({{ $item->id }})">
                                                detail
                                            </x-primary-button>
                                            <div wire:loading wire:target="getStudent({{ $item->id }})">
                                                <div class="animate-spin inline-block size-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full"
                                                    role="status" aria-label="loading">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">
                                        {{ $item->teachers->count() }}
                                        @if ($item->teachers->count() >= 1)
                                            <x-primary-button class="mx-2 px-2 py-1"
                                                wire:click="getTeacher({{ $item->id }})">
                                                detail
                                            </x-primary-button>
                                            <div wire:loading wire:target="getTeacher({{ $item->id }})">
                                                <div class="animate-spin inline-block size-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full"
                                                    role="status" aria-label="loading">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap text-end">
                                        <div class="flex justify-end space-x-2">
                                            <x-primary-button wire:click="getData({{ $item->id }})">
                                                Edit
                                            </x-primary-button>
                                            <x-danger-button wire:click="destroy({{ $item->id }})">
                                                Hapus
                                            </x-danger-button>
                                            <div wire:loading wire:target="getData({{ $item->id }})">
                                                <div class="animate-spin inline-block size-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full"
                                                    role="status" aria-label="loading">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                            <div wire:loading wire:target="destroy({{ $item->id }})">
                                                <div class="animate-spin inline-block size-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full"
                                                    role="status" aria-label="loading">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-layouts-table>

    <x-modal name="create-data" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="save" class="p-6">
            <div class="sm:col-span-3">
                <label for="class_name" class="inline-block text-lg font-medium text-gray-900 mt-2.5">
                    Nama Kelas
                </label>
            </div>
            <div class="sm:col-span-9">
                <x-text-input id="class_name" wire:model="class_name" class="block w-full mt-1" type="text"
                    :value="old('class_name')" autofocus />
                <x-input-error :messages="$errors->get('class_name')" class="mt-2" />
            </div>
            <div class="flex justify-end mt-5 gap-x-2">
                <x-danger-button type="button" x-on:click="$dispatch('close')">
                    Kembali
                </x-danger-button>
                <x-primary-button>
                    Submit
                </x-primary-button>
                <div wire:loading wire:target="save">
                    <div class="animate-spin inline-block size-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full"
                        role="status" aria-label="loading">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </form>
    </x-modal>

    <x-modal name="update-data" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="edit" class="p-6">
            <div class="sm:col-span-3">
                <label for="class_name" class="inline-block text-lg font-medium text-gray-900 mt-2.5">
                    Nama Kelas
                </label>
            </div>
            <div class="sm:col-span-9">
                <x-text-input id="edit_name" wire:model="edit_name" class="block w-full mt-1" type="text"
                    :value="old('edit_name')" autofocus />
                <x-input-error :messages="$errors->get('edit_name')" class="mt-2" />
            </div>
            <div class="flex justify-end mt-5 gap-x-2">
                <x-danger-button type="button" x-on:click="$dispatch('close')">
                    Kembali
                </x-danger-button>
                <x-primary-button>
                    Update
                </x-primary-button>
                <div wire:loading wire:target="edit">
                    <div class="animate-spin inline-block size-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full"
                        role="status" aria-label="loading">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </form>
    </x-modal>


    @if ($getTeachers)
        <x-modal name="get-teacher">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Daftar Guru Kelas {{ $getTeachers['class_name'] }}
                </h2>
                <ul class="marker:text-blue-600 list-disc ps-5 space-y-2 text-sm text-gray-600">
                    @foreach ($getTeachers['teachers'] as $teacher)
                        <li>{{ $teacher['name'] }}</li>
                    @endforeach
                </ul>
            </div>
        </x-modal>
    @endif

    @if ($getStudents)
        <x-modal name="get-student">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Daftar Siswa Kelas {{ $getStudents['class_name'] }}
                </h2>
                <ul class="marker:text-blue-600 list-disc ps-5 space-y-2 text-sm text-gray-600">
                    @foreach ($getStudents['students'] as $teacher)
                        <li>{{ $teacher['name'] }}</li>
                    @endforeach
                </ul>
            </div>
        </x-modal>
    @endif
</div>