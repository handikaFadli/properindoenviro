@extends('layouts.app')

@section('title', 'Daftar Prioritas Tugas')

@section('content')

<main>

    {{-- =========================
        HEADER
    ========================== --}}
    <div class="pt-5 flex items-center justify-between mb-5">

        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
            Daftar Prioritas Tugas
        </h1>

        <button
            type="button"
            onclick="openCreateModal()"
            class="inline-flex items-center gap-1.5
                   px-4 py-2
                   text-sm font-medium
                   text-white
                   bg-primary-600
                   rounded-lg
                   hover:bg-primary-700
                   focus:outline-none
                   focus:ring-2
                   focus:ring-primary-500
                   cursor-pointer">

            <svg class="w-4 h-4"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4"/>

            </svg>

            Tambah

        </button>

    </div>


    {{-- =========================
        FILTER + SEARCH
    ========================== --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-2">

        {{-- Per Page --}}
        <div class="flex items-center gap-3">

            <div class="relative inline-block">

                <button
                    id="perPageButton"
                    data-dropdown-toggle="perPageDropdown"
                    type="button"
                    class="flex items-center justify-between
                           w-18 h-11 px-4
                           bg-white
                           border border-gray-200
                           rounded-xl
                           shadow-sm
                           text-sm font-medium
                           text-gray-700
                           hover:border-primary-400
                           hover:shadow-md
                           focus:ring-4
                           focus:ring-primary-100
                           transition-all
                           cursor-pointer">

                    <span>
                        {{ request('per_page', 10) }}
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


                <div
                    id="perPageDropdown"
                    class="hidden z-20 w-36 mt-2
                           bg-white
                           rounded-xl
                           shadow-xl
                           border border-gray-100
                           overflow-hidden">

                    @foreach([10, 25, 50, 100] as $size)

                        <button
                            type="button"
                            onclick="updatePerPage({{ $size }})"
                            class="w-full px-4 py-2.5
                                   text-left text-sm
                                   hover:bg-primary-50
                                   hover:text-primary-600
                                   transition
                                   cursor-pointer
                                   {{ request('per_page', 10) == $size
                                        ? 'bg-primary-50 text-primary-600 font-semibold'
                                        : 'text-gray-700' }}">

                            {{ $size }}

                        </button>

                    @endforeach

                </div>

            </div>

        </div>


        {{-- Search --}}
        <div class="relative flex w-96">

            <div class="relative flex-1">

                <svg
                    class="absolute left-4 top-1/2
                           -translate-y-1/2
                           w-5 h-5
                           text-gray-400"
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
                    type="text"
                    value="{{ request('search') }}"
                    placeholder="Cari..."
                    class="w-full h-11
                           rounded-l-xl
                           border border-gray-300
                           border-r-0
                           pl-11 pr-4
                           text-sm
                           focus:outline-none
                           focus:border-primary-500
                           focus:ring-4
                           focus:ring-primary-100
                           transition-all duration-200"
                    onkeypress="if(event.key === 'Enter') searchTable()"
                >

            </div>

            <button
                type="button"
                onclick="searchTable()"
                class="h-11 px-6
                       rounded-r-xl
                       bg-primary-600
                       hover:bg-primary-700
                       border border-primary-600
                       text-white
                       text-sm font-medium
                       transition-all duration-200
                       cursor-pointer">

                Cari

            </button>

        </div>

    </div>


    {{-- =========================
        TABLE
    ========================== --}}
    <div class="flex flex-col mt-4">

        <div class="overflow-x-auto bg-white
                dark:bg-gray-800
                border border-gray-200
                dark:border-gray-700
                rounded-2xl
                shadow-sm">

            <div class="inline-block min-w-full align-middle">

                <div class="overflow-hidden shadow relative bg-neutral-primary-soft">

                    <table class="w-full text-sm text-left">

                        <thead>

                            <tr class="bg-slate-200 dark:bg-gray-700">

                                <th class="px-4 py-3
                                           text-xs font-bold
                                           text-gray-600
                                           uppercase tracking-wider
                                           w-12">
                                    #
                                </th>

                                <th class="px-4 py-3
                                           text-xs font-bold
                                           text-gray-600
                                           uppercase tracking-wider">
                                    Kode
                                </th>

                                <th class="px-4 py-3
                                           text-xs font-bold
                                           text-gray-600
                                           uppercase tracking-wider">
                                    Nama Prioritas
                                </th>

                                <th class="px-4 py-3
                                           text-xs font-bold
                                           text-gray-600
                                           uppercase tracking-wider">
                                    Warna
                                </th>

                                <th class="px-4 py-3
                                           text-xs font-bold
                                           text-gray-600
                                           uppercase tracking-wider
                                           text-center">
                                    Urutan
                                </th>

                                <th class="px-4 py-3
                                           text-xs font-bold
                                           text-gray-600
                                           uppercase tracking-wider">
                                    Status
                                </th>

                                <th class="px-4 py-3
                                           text-xs font-bold
                                           text-gray-600
                                           uppercase tracking-wider
                                           text-center
                                           min-w-35">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($taskPriorities as $i => $taskPriority)

                                <tr class="border-b border-gray-200
                                           hover:bg-gray-50
                                           dark:hover:bg-gray-700
                                           transition">

                                    {{-- No --}}
                                    <td class="px-4 py-3 text-xs text-gray-400">

                                        {{ $taskPriorities->firstItem() + $i }}

                                    </td>


                                    {{-- Code --}}
                                    <td class="px-4 py-3">

                                        <div class="font-medium text-gray-900 dark:text-white">
                                            {{ $taskPriority->code }}
                                        </div>

                                    </td>


                                    {{-- Name --}}
                                    <td class="px-4 py-3">

                                        <div class="font-medium text-gray-900 dark:text-white">
                                            {{ $taskPriority->name }}
                                        </div>

                                    </td>


                                    {{-- Color --}}
                                    <td class="px-4 py-3">

                                        @php
                                            $colorClasses = [
                                                'gray' => 'bg-gray-100 text-gray-700',
                                                'blue' => 'bg-blue-100 text-blue-700',
                                                'green' => 'bg-green-100 text-green-700',
                                                'yellow' => 'bg-yellow-100 text-yellow-700',
                                                'orange' => 'bg-orange-100 text-orange-700',
                                                'red' => 'bg-red-100 text-red-700',
                                                'purple' => 'bg-purple-100 text-purple-700',
                                            ];

                                            $colorNames = [
                                                'gray' => 'Abu-abu',
                                                'blue' => 'Biru',
                                                'green' => 'Hijau',
                                                'yellow' => 'Kuning',
                                                'orange' => 'Oranye',
                                                'red' => 'Merah',
                                                'purple' => 'Ungu',
                                            ];

                                            $colorClass =
                                                $colorClasses[$taskPriority->color]
                                                ?? 'bg-gray-100 text-gray-700';

                                            $colorName =
                                                $colorNames[$taskPriority->color]
                                                ?? '-';
                                        @endphp

                                        <span class="inline-flex items-center gap-1.5
                                                     px-2.5 py-1
                                                     rounded-full
                                                     text-xs font-medium
                                                     {{ $colorClass }}">

                                            {{-- <span class="w-2 h-2 rounded-full bg-current"></span> --}}

                                            {{ $colorName }}

                                        </span>

                                    </td>


                                    {{-- Sort Order --}}
                                    <td class="px-4 py-3 text-center">

                                        <span class="inline-flex items-center justify-center
                                                     min-w-8 h-8
                                                     px-2
                                                     rounded-lg
                                                     bg-gray-100
                                                     text-sm font-medium
                                                     text-gray-700">

                                            {{ $taskPriority->sort_order }}

                                        </span>

                                    </td>


                                    {{-- Active --}}
                                    <td class="px-4 py-3">

                                        @if($taskPriority->is_active)

                                            <span class="inline-flex items-center gap-1.5
                                                         px-2.5 py-1
                                                         rounded-full
                                                         bg-green-100
                                                         text-green-700
                                                         text-xs font-medium">

                                                <span class="w-1.5 h-1.5
                                                             rounded-full
                                                             bg-green-500">
                                                </span>

                                                Aktif

                                            </span>

                                        @else

                                            <span class="inline-flex items-center gap-1.5
                                                         px-2.5 py-1
                                                         rounded-full
                                                         bg-gray-100
                                                         text-gray-600
                                                         text-xs font-medium">

                                                <span class="w-1.5 h-1.5
                                                             rounded-full
                                                             bg-gray-400">
                                                </span>

                                                Non Aktif

                                            </span>

                                        @endif

                                    </td>


                                    {{-- Actions --}}
                                    <td class="px-4 py-3">

                                        <div class="flex justify-center gap-1">

                                            {{-- Edit --}}
                                            <button
                                                type="button"
                                                onclick="openEditModal(
                                                    {{ $taskPriority->id }},
                                                    @js($taskPriority->code),
                                                    @js($taskPriority->name),
                                                    @js($taskPriority->color),
                                                    {{ $taskPriority->sort_order }},
                                                    {{ $taskPriority->is_active ? 1 : 0 }}
                                                )"
                                                class="p-1.5
                                                       rounded
                                                       border border-gray-300
                                                       text-gray-700
                                                       hover:bg-gray-100
                                                       cursor-pointer"
                                                title="Edit">

                                                <svg
                                                    class="w-4 h-4 text-gray-800 dark:text-white"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    fill="none"
                                                    viewBox="0 0 24 24">

                                                    <path
                                                        stroke="currentColor"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1"
                                                        d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>

                                                </svg>

                                            </button>


                                            {{-- Delete --}}
                                            <form
                                                id="delete-form-{{ $taskPriority->id }}"
                                                action="{{ route('task-priorities.destroy', $taskPriority->id) }}"
                                                method="POST"
                                                class="inline">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="button"
                                                    onclick="openDeleteModal(
                                                        'delete-form-{{ $taskPriority->id }}',
                                                        @js($taskPriority->name)
                                                    )"
                                                    class="p-1.5
                                                           rounded
                                                           border border-red-200
                                                           text-red-600
                                                           hover:bg-red-50
                                                           cursor-pointer"
                                                    title="Hapus">

                                                    <svg
                                                        class="w-4 h-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="24"
                                                        height="24"
                                                        fill="none"
                                                        viewBox="0 0 24 24">

                                                        <path
                                                            stroke="currentColor"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="1"
                                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>

                                                    </svg>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7"
                                        class="px-4 py-10
                                               text-center
                                               text-sm text-gray-400">

                                        Belum ada data prioritas tugas.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
        PAGINATION
    ========================== --}}
    <div class="flex flex-col md:flex-row
                items-center justify-between
                gap-4 mt-6">

        {{-- Info --}}
        <div class="text-sm text-gray-500">

            Menampilkan

            <span class="font-semibold">
                {{ $taskPriorities->firstItem() ?? 0 }}
            </span>

            -

            <span class="font-semibold">
                {{ $taskPriorities->lastItem() ?? 0 }}
            </span>

            dari

            <span class="font-semibold">
                {{ $taskPriorities->total() }}
            </span>

            data

        </div>


        {{-- Pagination --}}
        <div>
            {{ $taskPriorities->withQueryString() }}
        </div>

    </div>


    {{-- =========================
        MODALS
    ========================== --}}
    @include('task-priorities.create')
    @include('task-priorities.edit')

</main>


@push('scripts')

<script>

    /*
    |--------------------------------------------------------------------------
    | URL Helper
    |--------------------------------------------------------------------------
    */

    function getUrl() {
        return new URL(window.location.href);
    }


    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    function searchTable() {

        const url = getUrl();

        const searchInput =
            document.getElementById('search-input');

        if (!searchInput) return;

        const search =
            searchInput.value.trim();

        if (search !== '') {

            url.searchParams.set(
                'search',
                search
            );

        } else {

            url.searchParams.delete(
                'search'
            );

        }

        url.searchParams.set(
            'page',
            1
        );

        window.location.href =
            url.toString();

    }


    /*
    |--------------------------------------------------------------------------
    | Per Page
    |--------------------------------------------------------------------------
    */

    function updatePerPage(value) {

        const url = getUrl();

        url.searchParams.set(
            'per_page',
            value
        );

        url.searchParams.set(
            'page',
            1
        );

        window.location.href =
            url.toString();

    }


    /*
    |--------------------------------------------------------------------------
    | Create Modal
    |--------------------------------------------------------------------------
    */

    function openCreateModal() {

        const modal =
            document.getElementById(
                'create-modal'
            );

        const content =
            document.getElementById(
                'create-modal-content'
            );

        if (!modal || !content) {
            return;
        }

        modal.classList.remove(
            'hidden'
        );

        modal.classList.add(
            'flex'
        );

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

        setTimeout(() => {

            document
                .getElementById(
                    'task_priority_code'
                )
                ?.focus();

        }, 200);

    }


    function closeCreateModal() {

        const modal =
            document.getElementById(
                'create-modal'
            );

        const content =
            document.getElementById(
                'create-modal-content'
            );

        if (!modal || !content) {
            return;
        }

        content.classList.add(
            'scale-95',
            'opacity-0'
        );

        content.classList.remove(
            'scale-100',
            'opacity-100'
        );

        setTimeout(() => {

            modal.classList.add(
                'hidden'
            );

            modal.classList.remove(
                'flex'
            );

        }, 150);

    }


    /*
    |--------------------------------------------------------------------------
    | Edit Modal
    |--------------------------------------------------------------------------
    */

    function openEditModal(
        id,
        code,
        name,
        color,
        sortOrder,
        isActive
    ) {

        const modal =
            document.getElementById(
                'edit-modal'
            );

        const content =
            document.getElementById(
                'edit-modal-content'
            );

        const form =
            document.getElementById(
                'edit-task-priority-form'
            );

        const codeInput =
            document.getElementById(
                'edit_task_priority_code'
            );

        const nameInput =
            document.getElementById(
                'edit_task_priority_name'
            );

        const colorSelect =
            document.getElementById(
                'edit_task_priority_color'
            );

        const sortOrderInput =
            document.getElementById(
                'edit_task_priority_sort_order'
            );

        const activeSelect =
            document.getElementById(
                'edit_task_priority_is_active'
            );


        if (
            !modal ||
            !content ||
            !form ||
            !codeInput ||
            !nameInput ||
            !colorSelect ||
            !sortOrderInput ||
            !activeSelect
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Set Data
        |--------------------------------------------------------------------------
        */

        codeInput.value =
            code ?? '';

        nameInput.value =
            name ?? '';

        colorSelect.value =
            color ?? '';

        sortOrderInput.value =
            sortOrder ?? 0;

        activeSelect.value =
            String(isActive);


        /*
        |--------------------------------------------------------------------------
        | Set Form Action
        |--------------------------------------------------------------------------
        */

        form.action =
            `{{ url('/task-priorities') }}/${id}`;


        /*
        |--------------------------------------------------------------------------
        | Clear Error
        |--------------------------------------------------------------------------
        */

        clearEditErrors();


        /*
        |--------------------------------------------------------------------------
        | Open Modal
        |--------------------------------------------------------------------------
        */

        modal.classList.remove(
            'hidden'
        );

        modal.classList.add(
            'flex'
        );

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
        | Focus
        |--------------------------------------------------------------------------
        */

        setTimeout(() => {

            codeInput.focus();
            codeInput.select();

        }, 200);

    }


    function closeEditModal() {

        const modal =
            document.getElementById(
                'edit-modal'
            );

        const content =
            document.getElementById(
                'edit-modal-content'
            );

        if (!modal || !content) {
            return;
        }

        content.classList.add(
            'scale-95',
            'opacity-0'
        );

        content.classList.remove(
            'scale-100',
            'opacity-100'
        );

        setTimeout(() => {

            modal.classList.add(
                'hidden'
            );

            modal.classList.remove(
                'flex'
            );

        }, 150);

    }


    /*
    |--------------------------------------------------------------------------
    | Clear Edit Errors
    |--------------------------------------------------------------------------
    */

    function clearEditErrors() {

        const errorIds = [
            'edit-code-error',
            'edit-name-error',
        ];

        errorIds.forEach((id) => {

            const element =
                document.getElementById(id);

            if (!element) {
                return;
            }

            element.classList.add(
                'hidden'
            );

            element.classList.remove(
                'flex'
            );

        });


        const codeInput =
            document.getElementById(
                'edit_task_priority_code'
            );

        const nameInput =
            document.getElementById(
                'edit_task_priority_name'
            );

        codeInput?.classList.remove(
            'border-red-500'
        );

        nameInput?.classList.remove(
            'border-red-500'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | DOM Ready
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            /*
            |--------------------------------------------------------------------------
            | Create Modal Backdrop
            |--------------------------------------------------------------------------
            */

            const createModal =
                document.getElementById(
                    'create-modal'
                );

            createModal?.addEventListener(
                'click',
                function (event) {

                    if (event.target === this) {
                        closeCreateModal();
                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Edit Modal Backdrop
            |--------------------------------------------------------------------------
            */

            const editModal =
                document.getElementById(
                    'edit-modal'
                );

            editModal?.addEventListener(
                'click',
                function (event) {

                    if (event.target === this) {
                        closeEditModal();
                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Validation Create
            |--------------------------------------------------------------------------
            */

            @if ($errors->any() && old('_method') !== 'PUT')

                openCreateModal();

            @endif

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Escape
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key !== 'Escape') {
                return;
            }

            const createModal =
                document.getElementById(
                    'create-modal'
                );

            const editModal =
                document.getElementById(
                    'edit-modal'
                );


            if (
                createModal &&
                !createModal.classList.contains(
                    'hidden'
                )
            ) {

                closeCreateModal();

            }


            if (
                editModal &&
                !editModal.classList.contains(
                    'hidden'
                )
            ) {

                closeEditModal();

            }

        }
    );

</script>

@endpush

@endsection