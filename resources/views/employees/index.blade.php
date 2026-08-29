@extends('layouts.app')

@section('title', 'Daftar Karyawan')

@section('content')
<main>
    <div class="pt-5 flex items-center justify-between gap-4 mb-5">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Daftar Karyawan</h1>
        <div class="flex items-center gap-2">
            <div class="relative">
                <button id="exportDropdownButton" data-dropdown-toggle="exportDropdown" type="button" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                    Export
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/></svg>
                </button>
                <div id="exportDropdown" class="hidden z-20 w-25 mt-2 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">
                    <a href="{{ route('employees.export', array_merge(request()->query(), ['format' => 'xlsx'])) }}" data-download class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600">Excel</a>
                    <a href="{{ route('employees.export', array_merge(request()->query(), ['format' => 'csv'])) }}" data-download class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600">CSV</a>
                    <a href="{{ route('employees.export', array_merge(request()->query(), ['format' => 'pdf'])) }}" data-download class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600">PDF</a>
                </div>
            </div>
            <button type="button" onclick="openCreateModal()" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 cursor-pointer">
                <span class="text-lg leading-none">+</span> Tambah
            </button>
        </div>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-4 mb-2">
        <div class="flex items-center gap-3">
            <div class="relative inline-block">
                <button id="perPageButton"
                    data-dropdown-toggle="perPageDropdown"
                    class="flex items-center justify-between w-18 h-11 px-4
                        bg-white border border-gray-200 rounded-xl shadow-sm
                        text-sm font-medium text-gray-700
                        hover:border-primary-400 hover:shadow-md
                        focus:ring-4 focus:ring-primary-100
                        transition-all cursor-pointer">

                    <span>{{ request('per_page',10) }} </span>

                    <svg class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"/>
                    </svg>

                </button>

                <div id="perPageDropdown" class="hidden z-20 w-36 mt-2 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">
                    @foreach([10,25,50,100] as $size)
                        <button
                            onclick="updatePerPage({{ $size }})"
                            class="w-full px-4 py-2.5 text-left text-sm
                                hover:bg-primary-50
                                hover:text-primary-600
                                transition cursor-pointer
                                {{ request('per_page',10)==$size ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-gray-700' }}">
                            {{ $size }} 
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">

    {{-- =========================
        FILTER DEPARTEMEN
    ========================== --}}
    <div class="relative inline-block">

        <button
            id="departmentFilterButton"
            data-dropdown-toggle="departmentFilterDropdown"
            type="button"
            class="flex items-center justify-between min-w-48 h-11 px-4
                   bg-white border border-gray-200 rounded-xl shadow-sm
                   text-sm font-medium text-gray-700
                   hover:border-primary-400 hover:shadow-md
                   focus:ring-4 focus:ring-primary-100
                   transition-all cursor-pointer">

            <span>
                @if(request('department_id'))
                    {{ $departments->firstWhere('id', request('department_id'))?->name ?? 'Semua Departemen' }}
                @else
                    Semua Departemen
                @endif
            </span>

            <svg class="w-4 h-4 text-gray-400"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 9l-7 7-7-7"/>

            </svg>

        </button>


        <div id="departmentFilterDropdown"
             class="hidden z-20 w-56 mt-2 bg-white rounded-xl
                    shadow-xl border border-gray-100 overflow-hidden">

            {{-- Semua Departemen --}}
            <button
                type="button"
                onclick="filterDepartment('')"
                class="w-full px-4 py-2.5 flex items-center justify-between
                       hover:bg-primary-50 hover:text-primary-600
                       transition cursor-pointer
                       {{ !request('department_id')
                            ? 'bg-primary-50 text-primary-600 font-semibold'
                            : 'text-gray-700' }}">

                <span>Semua Departemen</span>

                @if(!request('department_id'))
                    <svg class="w-4 h-4"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5 13l4 4L19 7"/>

                    </svg>
                @endif

            </button>


            @foreach($departments as $department)

                <button
                    type="button"
                    onclick="filterDepartment('{{ $department->id }}')"
                    class="w-full px-4 py-2.5 flex items-center justify-between
                           hover:bg-primary-50 hover:text-primary-600
                           transition cursor-pointer
                           {{ request('department_id') == $department->id
                                ? 'bg-primary-50 text-primary-600 font-semibold'
                                : 'text-gray-700' }}">

                    <span>
                        {{ $department->name }}
                    </span>

                    @if(request('department_id') == $department->id)

                        <svg class="w-4 h-4"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 13l4 4L19 7"/>

                        </svg>

                    @endif

                </button>

            @endforeach

        </div>

    </div>


    {{-- =========================
        FILTER POSISI
    ========================== --}}
    <div class="relative inline-block">

        <button
            id="positionFilterButton"
            data-dropdown-toggle="positionFilterDropdown"
            type="button"
            class="flex items-center justify-between min-w-48 h-11 px-4
                   bg-white border border-gray-200 rounded-xl shadow-sm
                   text-sm font-medium text-gray-700
                   hover:border-primary-400 hover:shadow-md
                   focus:ring-4 focus:ring-primary-100
                   transition-all cursor-pointer">

            <span>
                @if(request('position_id'))
                    {{ $positions->firstWhere('id', request('position_id'))?->name ?? 'Semua Posisi' }}
                @else
                    Semua Posisi
                @endif
            </span>

            <svg class="w-4 h-4 text-gray-400"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 9l-7 7-7-7"/>

            </svg>

        </button>


        <div id="positionFilterDropdown"
             class="hidden z-20 w-56 mt-2 bg-white rounded-xl
                    shadow-xl border border-gray-100 overflow-hidden">

            {{-- Semua Posisi --}}
            <button
                type="button"
                onclick="filterPosition('')"
                class="w-full px-4 py-2.5 flex items-center justify-between
                       hover:bg-primary-50 hover:text-primary-600
                       transition cursor-pointer
                       {{ !request('position_id')
                            ? 'bg-primary-50 text-primary-600 font-semibold'
                            : 'text-gray-700' }}">

                <span>Semua Posisi</span>

                @if(!request('position_id'))

                    <svg class="w-4 h-4"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5 13l4 4L19 7"/>

                    </svg>

                @endif

            </button>


            @foreach($positions as $position)

                {{-- Jika departemen dipilih, hanya tampilkan posisi dari departemen tersebut --}}
                @if(
                    !request('department_id') ||
                    $position->department_id == request('department_id')
                )

                    <button
                        type="button"
                        onclick="filterPosition('{{ $position->id }}')"
                        class="w-full px-4 py-2.5 flex items-center justify-between
                            hover:bg-primary-50 hover:text-primary-600
                            transition cursor-pointer
                            {{ request('position_id') == $position->id
                                    ? 'bg-primary-50 text-primary-600 font-semibold'
                                    : 'text-gray-700' }}">

                        <span>{{ $position->name }}</span>

                        @if(request('position_id') == $position->id)
                            <svg class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"/>
                            </svg>
                        @endif

                    </button>

                @endif

            @endforeach

        </div>

    </div>


    {{-- =========================
        FILTER STATUS
    ========================== --}}
    <div class="relative inline-block">

        @php
            $statuses = [
                '' => 'Semua Status',
                'active' => 'Aktif',
                'inactive' => 'Non Aktif',
            ];

            $currentStatusLabel =
                $statuses[request('status')] ?? 'Semua Status';
        @endphp


        <button
            id="statusFilterButton"
            data-dropdown-toggle="statusFilterDropdown"
            type="button"
            class="flex items-center justify-between min-w-40 h-11 px-4
                   bg-white border border-gray-200 rounded-xl shadow-sm
                   text-sm font-medium text-gray-700
                   hover:border-primary-400 hover:shadow-md
                   focus:ring-4 focus:ring-primary-100
                   transition-all cursor-pointer">

            <span>
                {{ $currentStatusLabel }}
            </span>

            <svg class="w-4 h-4 text-gray-400"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 9l-7 7-7-7"/>

            </svg>

        </button>


        <div id="statusFilterDropdown"
             class="hidden z-20 w-40 mt-2 bg-white rounded-xl
                    shadow-xl border border-gray-100 overflow-hidden">

            @foreach($statuses as $value => $label)

                <button
                    type="button"
                    onclick="filterStatus('{{ $value }}')"
                    class="w-full px-4 py-2.5 flex items-center justify-between
                           hover:bg-primary-50 hover:text-primary-600
                           transition cursor-pointer
                           {{ request('status') == $value
                                ? 'bg-primary-50 text-primary-600 font-semibold'
                                : 'text-gray-700' }}">

                    <span>
                        {{ $label }}
                    </span>

                    @if(request('status') == $value)

                        <svg class="w-4 h-4"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 13l4 4L19 7"/>

                        </svg>

                    @endif

                </button>

            @endforeach

        </div>

    </div>


    {{-- =========================
        RESET FILTER
    ========================== --}}
    @if(
        request('department_id') ||
        request('position_id') ||
        request('status')
    )

        <button
            type="button"
            onclick="resetFilters()"
            class="inline-flex items-center gap-2 h-11 px-4
                   text-sm font-medium text-red-600
                   bg-red-50 border border-red-100 rounded-xl
                   hover:bg-red-100
                   transition cursor-pointer">

            <svg class="w-4 h-4"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>

            </svg>
        </button>

    @endif

</div>
        </div>

        <div class="relative flex w-75">

            <div class="relative flex-1">

                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/>
                </svg>

                <input
                    id="search-input"
                    value="{{ request('search') }}"
                    placeholder="Cari..."
                    class="w-full h-11 rounded-l-xl border border-gray-300 border-r-0
                        pl-11 pr-4 text-sm
                        focus:outline-none
                        focus:border-primary-500
                        focus:ring-4 focus:ring-primary-100
                        transition-all duration-200"
                    onkeypress="if(event.key==='Enter') searchTable()">

            </div>

            <button
                onclick="searchTable()"
                class="h-11 px-3 rounded-r-xl
                    bg-primary-600 hover:bg-primary-700
                    border border-primary-600
                    text-white text-sm font-medium
                    transition-all duration-200 cursor-pointer">

                Cari

            </button>

        </div>

    </div>

    <div class="overflow-x-auto bg-white
                dark:bg-gray-800
                border border-gray-200
                dark:border-gray-700
                rounded-2xl
                shadow-sm">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="bg-slate-200">
                    <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase">#</th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase">Kode</th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase">Karyawan</th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase">Departemen</th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase">Posisi</th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase">Status</th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $index => $employee)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-3 text-xs text-gray-400">{{ $employees->firstItem() + $index }}</td>
                        <td class="px-4 py-3 font-medium">{{ $employee->employee_code }}</td>
                        <td class="px-4 py-3"><div class="font-medium text-gray-900">{{ $employee->name }}</div><div class="text-xs text-gray-500">{{ $employee->email }}</div></td>
                        <td class="px-4 py-3">{{ $employee->department?->name }}</td>
                        <td class="px-4 py-3">{{ $employee->position?->name }}</td>
                        <td class="px-4 py-3"><span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $employee->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">{{ $employee->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-1">
                                <a href="{{ route('employees.show', $employee) }}"
                                class="p-1.5 rounded border border-gray-300
                                        text-gray-700 hover:bg-gray-100
                                        transition cursor-pointer"
                                title="Detail">

                                    <svg class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0
                                                3 3 0 016 0z"/>

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943
                                                7.523 5 12 5c4.478 0
                                                8.268 2.943 9.542 7
                                                -1.274 4.057-5.064 7
                                                -9.542 7-4.477 0
                                                -8.268-2.943-9.542-7z"/>

                                    </svg>

                                </a>
                                <button type="button"
                                        onclick="openEditModal(
                                            {{ $employee->id }},
                                            @js($employee->employee_code),
                                            @js($employee->name),
                                            {{ $employee->department_id }},
                                            {{ $employee->position_id }},
                                            @js($employee->email),
                                            @js($employee->status)
                                        )"
                                        class="p-1.5 rounded border border-gray-300
                                            text-gray-700 hover:bg-gray-100
                                            cursor-pointer">

                                    <svg class="w-4 h-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>

                                    </svg>

                                </button>
                                <form id="delete-form-{{ $employee->id }}" action="{{ route('employees.destroy', $employee) }}" method="POST">@csrf @method('DELETE')
                                    <button type="button" onclick="openDeleteModal('delete-form-{{ $employee->id }}', @js($employee->name))" class="p-1.5 rounded border border-red-200 text-red-600 hover:bg-red-50 cursor-pointer">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">Belum ada data karyawan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mt-6 text-sm text-gray-500">
        <div>Menampilkan {{ $employees->firstItem() ?? 0 }} - {{ $employees->lastItem() ?? 0 }} dari {{ $employees->total() }} data</div>
        <div>{{ $employees->links() }}</div>
    </div>
</main>

@include('employees.create')
@include('employees.edit')

@push('scripts')
<script>
    /*
    |--------------------------------------------------------------------------
    | URL Helper
    |--------------------------------------------------------------------------
    */

    function getCurrentUrl() {
        return new URL(window.location.href);
    }

    /*
|--------------------------------------------------------------------------
| Filter Department
|--------------------------------------------------------------------------
*/

function filterDepartment(departmentId) {
    const url = getCurrentUrl();

    if (departmentId === '') {
        url.searchParams.delete('department_id');
    } else {
        url.searchParams.set('department_id', departmentId);
    }

    // Hapus posisi lama ketika departemen berubah
    url.searchParams.delete('position_id');

    url.searchParams.set('page', 1);

    window.location.href = url.toString();
}


/*
|--------------------------------------------------------------------------
| Filter Position
|--------------------------------------------------------------------------
*/

function filterPosition(positionId) {
    const url = getCurrentUrl();

    if (positionId === '') {
        url.searchParams.delete('position_id');
    } else {
        url.searchParams.set(
            'position_id',
            positionId
        );
    }

    url.searchParams.set('page', 1);

    window.location.href = url.toString();
}


/*
|--------------------------------------------------------------------------
| Filter Status
|--------------------------------------------------------------------------
*/

function filterStatus(status) {
    const url = getCurrentUrl();

    if (status === '') {
        url.searchParams.delete('status');
    } else {
        url.searchParams.set(
            'status',
            status
        );
    }

    url.searchParams.set('page', 1);

    window.location.href = url.toString();
}


/*
|--------------------------------------------------------------------------
| Reset Filter
|--------------------------------------------------------------------------
*/

function resetFilters() {
    const url = getCurrentUrl();

    url.searchParams.delete('department_id');
    url.searchParams.delete('position_id');
    url.searchParams.delete('status');

    url.searchParams.set('page', 1);

    window.location.href = url.toString();
}


    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    function searchTable() {
        const url = getCurrentUrl();
        const searchInput = document.getElementById('search-input');

        if (!searchInput) return;

        const search = searchInput.value.trim();

        if (search) {
            url.searchParams.set('search', search);
        } else {
            url.searchParams.delete('search');
        }

        url.searchParams.set('page', 1);

        window.location.href = url.toString();
    }


    /*
    |--------------------------------------------------------------------------
    | Per Page
    |--------------------------------------------------------------------------
    */

    function updatePerPage(value) {
        const url = getCurrentUrl();

        url.searchParams.set('per_page', value);
        url.searchParams.set('page', 1);

        window.location.href = url.toString();
    }


    /*
    |--------------------------------------------------------------------------
    | Create - Filter Position berdasarkan Department
    |--------------------------------------------------------------------------
    */

    function filterPositions(restorePositionId = null) {
        const departmentSelect = document.getElementById('department_id');
        const positionSelect = document.getElementById('position_id');

        if (!departmentSelect || !positionSelect) return;

        const departmentId = String(departmentSelect.value);
        const options = positionSelect.querySelectorAll('option');

        // Reset position
        positionSelect.value = '';

        options.forEach((option) => {

            // Placeholder selalu ditampilkan
            if (!option.value) {
                option.hidden = false;
                return;
            }

            const optionDepartmentId = String(
                option.dataset.department
            );

            option.hidden =
                !departmentId ||
                optionDepartmentId !== departmentId;
        });

        // Restore position jika ada old value
        if (restorePositionId) {
            const targetOption = positionSelect.querySelector(
                `option[value="${restorePositionId}"]`
            );

            if (targetOption && !targetOption.hidden) {
                positionSelect.value = String(restorePositionId);
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Create Modal - Open
    |--------------------------------------------------------------------------
    */

    function openCreateModal() {
        const modal = document.getElementById('create-modal');
        const content = document.getElementById('create-modal-content');

        if (!modal || !content) return;

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        requestAnimationFrame(() => {
            content.classList.remove(
                'scale-95',
                'opacity-0'
            );

            content.classList.add(
                'scale-100',
                'opacity-100'
            );
        });

        // Filter position berdasarkan department
        filterPositions(@json(old('position_id')));

        // Focus ke input nama
        setTimeout(() => {
            document
                .getElementById('employee_name')
                ?.focus();
        }, 200);
    }


    /*
    |--------------------------------------------------------------------------
    | Create Modal - Close
    |--------------------------------------------------------------------------
    */

    function closeCreateModal() {
        const modal = document.getElementById('create-modal');
        const content = document.getElementById('create-modal-content');

        if (!modal || !content) return;

        content.classList.add(
            'scale-95',
            'opacity-0'
        );

        content.classList.remove(
            'scale-100',
            'opacity-100'
        );

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 150);
    }


    /*
    |--------------------------------------------------------------------------
    | Edit - Filter Position berdasarkan Department
    |--------------------------------------------------------------------------
    */

    function filterEditPositions(selectedPositionId = null) {
        const departmentSelect = document.getElementById(
            'edit_department_id'
        );

        const positionSelect = document.getElementById(
            'edit_position_id'
        );

        if (!departmentSelect || !positionSelect) return;

        const departmentId = String(departmentSelect.value);
        const options = positionSelect.querySelectorAll('option');

        // Reset position
        positionSelect.value = '';

        options.forEach((option) => {

            // Placeholder selalu ditampilkan
            if (!option.value) {
                option.hidden = false;
                return;
            }

            const optionDepartmentId = String(
                option.dataset.department
            );

            option.hidden =
                !departmentId ||
                optionDepartmentId !== departmentId;
        });

        // Restore position yang sedang dimiliki employee
        if (selectedPositionId !== null) {
            const targetOption = positionSelect.querySelector(
                `option[value="${selectedPositionId}"]`
            );

            if (targetOption && !targetOption.hidden) {
                positionSelect.value = String(selectedPositionId);
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Modal - Open
    |--------------------------------------------------------------------------
    */

    function openEditModal(
        id,
        employeeCode,
        name,
        departmentId,
        positionId,
        email,
        status
    ) {
        const modal = document.getElementById('edit-modal');
        const content = document.getElementById('edit-modal-content');
        const form = document.getElementById('edit-employee-form');

        if (!modal || !content || !form) return;

        /*
        |--------------------------------------------------------------------------
        | Set Form Action
        |--------------------------------------------------------------------------
        */

        form.action = `{{ url('/employees') }}/${id}`;


        /*
        |--------------------------------------------------------------------------
        | Set Employee Data
        |--------------------------------------------------------------------------
        */

        document.getElementById('edit_employee_id').value =
            id;

        document.getElementById('edit_employee_code').value =
            employeeCode ?? '';

        document.getElementById('edit_employee_name').value =
            name ?? '';

        document.getElementById('edit_department_id').value =
            departmentId ?? '';

        document.getElementById('edit_employee_email').value =
            email ?? '';

        document.getElementById('edit_employee_status').value =
            status ?? '';


        /*
        |--------------------------------------------------------------------------
        | Filter Position
        |--------------------------------------------------------------------------
        */

        filterEditPositions(positionId);


        /*
        |--------------------------------------------------------------------------
        | Clear Validation Errors
        |--------------------------------------------------------------------------
        */

        clearEditErrors();


        /*
        |--------------------------------------------------------------------------
        | Open Modal
        |--------------------------------------------------------------------------
        */

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        requestAnimationFrame(() => {
            content.classList.remove(
                'scale-95',
                'opacity-0'
            );

            content.classList.add(
                'scale-100',
                'opacity-100'
            );
        });


        /*
        |--------------------------------------------------------------------------
        | Focus Name Input
        |--------------------------------------------------------------------------
        */

        setTimeout(() => {
            const input = document.getElementById(
                'edit_employee_name'
            );

            input?.focus();
            input?.select();
        }, 200);
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Modal - Close
    |--------------------------------------------------------------------------
    */

    function closeEditModal() {
        const modal = document.getElementById('edit-modal');
        const content = document.getElementById('edit-modal-content');

        if (!modal || !content) return;

        content.classList.add(
            'scale-95',
            'opacity-0'
        );

        content.classList.remove(
            'scale-100',
            'opacity-100'
        );

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 150);
    }


    /*
    |--------------------------------------------------------------------------
    | Edit - Clear Validation Errors
    |--------------------------------------------------------------------------
    */

    function clearEditErrors() {
        const errors = [
            'edit-name-error',
            'edit-department-error',
            'edit-position-error',
            'edit-email-error',
            'edit-status-error',
        ];

        errors.forEach((id) => {
            const element = document.getElementById(id);

            if (!element) return;

            element.textContent = '';
            element.classList.add('hidden');
        });
    }


    /*
    |--------------------------------------------------------------------------
    | DOM Ready
    |--------------------------------------------------------------------------
    */

    document.addEventListener('DOMContentLoaded', function () {

        /*
        |--------------------------------------------------------------------------
        | Create Modal - Backdrop Click
        |--------------------------------------------------------------------------
        */

        const createModal = document.getElementById('create-modal');

        createModal?.addEventListener('click', function (event) {
            if (event.target === this) {
                closeCreateModal();
            }
        });


        /*
        |--------------------------------------------------------------------------
        | Create - Department Change
        |--------------------------------------------------------------------------
        */

        const departmentSelect = document.getElementById(
            'department_id'
        );

        departmentSelect?.addEventListener('change', function () {
            filterPositions();
        });


        /*
        |--------------------------------------------------------------------------
        | Edit Modal - Backdrop Click
        |--------------------------------------------------------------------------
        */

        const editModal = document.getElementById('edit-modal');

        editModal?.addEventListener('click', function (event) {
            if (event.target === this) {
                closeEditModal();
            }
        });


        /*
        |--------------------------------------------------------------------------
        | Edit - Department Change
        |--------------------------------------------------------------------------
        */

        const editDepartmentSelect = document.getElementById(
            'edit_department_id'
        );

        editDepartmentSelect?.addEventListener(
            'change',
            function () {
                filterEditPositions();
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Create - Open kembali jika validation gagal
        |--------------------------------------------------------------------------
        */

        @if ($errors->createEmployee->any())
            openCreateModal();
        @endif

        @if ($errors->editEmployee->any())
            openEditModal(
                @json(old('employee_id')),
                '',
                @json(old('name')),
                @json(old('department_id')),
                @json(old('position_id')),
                @json(old('email')),
                @json(old('status'))
            );
        @endif
    });


    /*
    |--------------------------------------------------------------------------
    | Keyboard - Escape
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (event) {
        if (event.key !== 'Escape') return;

        const createModal = document.getElementById('create-modal');
        const editModal = document.getElementById('edit-modal');


        /*
        |--------------------------------------------------------------------------
        | Close Create Modal
        |--------------------------------------------------------------------------
        */

        if (
            createModal &&
            !createModal.classList.contains('hidden')
        ) {
            closeCreateModal();
        }


        /*
        |--------------------------------------------------------------------------
        | Close Edit Modal
        |--------------------------------------------------------------------------
        */

        if (
            editModal &&
            !editModal.classList.contains('hidden')
        ) {
            closeEditModal();
        }
    });
</script>
@endpush
@endsection
