@extends('layouts.app')

@section('title', 'Daftar Posisi')

@section('content')
<main>
    
    <div class="pt-5 flex items-center justify-between mb-5">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Daftar Posisi</h1>

        <button type="button"
            onclick="openCreateModal()"
            class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 cursor-pointer">

            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 4v16m8-8H4"/>
            </svg>
            Tambah
        </button>
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
        </div>

        <div class="relative flex w-96">

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
                class="h-11 px-6 rounded-r-xl
                    bg-primary-600 hover:bg-primary-700
                    border border-primary-600
                    text-white text-sm font-medium
                    transition-all duration-200 cursor-pointer">

                Cari

            </button>

        </div>

    </div>

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
                                <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider w-12">#</th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Departemen</th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Role</th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center min-w-35">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($positions as $i => $position)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="px-4 py-3 text-xs text-gray-400">{{ $positions->firstItem() + $i }}</td>

                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $position->name }}</div>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="text-gray-700">{{ $position->department?->name }}</div>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="text-gray-700">{{ $position->role?->name }}</div>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-1">
                                        <button type="button"
                                                onclick="openEditModal({{ $position->id }}, @js($position->name), {{ $position->department_id }}, {{ $position->role_id }})"
                                                class="p-1.5 rounded border border-gray-300 text-gray-700 hover:bg-gray-100 cursor-pointer">

                                            <svg class="w-4 h-4 text-gray-800 dark:text-white"
                                                aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="24"
                                                height="24"
                                                fill="none"
                                                viewBox="0 0 24 24">

                                                <path stroke="currentColor"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1"
                                                    d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>

                                            </svg>

                                        </button>

                                        <form id="delete-form-{{ $position->id }}" action="{{ route('positions.destroy', $position->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    onclick="openDeleteModal('delete-form-{{ $position->id }}', '{{ $position->name }}')"
                                                    class="p-1.5 rounded border border-red-200 text-red-600 hover:bg-red-50 cursor-pointer">
                                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mt-6">

        {{-- Info --}}
        <div class="text-sm text-gray-500">
            Menampilkan
            <span class="font-semibold">{{ $positions->firstItem() ?? 0 }}</span>
            -
            <span class="font-semibold">{{ $positions->lastItem() ?? 0 }}</span>
            dari
            <span class="font-semibold">{{ $positions->total() }}</span>
            data
        </div>

        {{-- Pagination --}}
        <div>
            {{ $positions->withQueryString() }}
        </div>

    </div>
</main>

@push('scripts')
<script>

    function getUrl() {
        return new URL(window.location.href);
    }

    function searchTable() {

        const url = getUrl();
        const search = document.getElementById('search-input').value;

        if (search !== '') {
            url.searchParams.set('search', search);
        } else {
            url.searchParams.delete('search');
        }

        url.searchParams.set('page', 1);

        window.location.href = url.toString();
    }

    function updatePerPage(value) {

        const url = getUrl();

        url.searchParams.set('per_page', value);
        url.searchParams.set('page', 1);

        window.location.href = url.toString();
    }

    function openCreateModal() {
        const modal = document.getElementById('create-modal');
        const content = document.getElementById('create-modal-content');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        requestAnimationFrame(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        });

        setTimeout(() => {
            document.getElementById('position_name')?.focus();
        }, 200);
    }


    function closeCreateModal() {
        const modal = document.getElementById('create-modal');
        const content = document.getElementById('create-modal-content');

        content.classList.add('scale-95', 'opacity-0');
        content.classList.remove('scale-100', 'opacity-100');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 150);
    }


    document.getElementById('create-modal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeCreateModal();
        }
    });


    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCreateModal();
        }
    });


    {{-- Jika validasi create gagal --}}
    @if ($errors->any() && old('_method') !== 'PUT')
        document.addEventListener('DOMContentLoaded', function () {
            openCreateModal();
        });
    @endif

    function openEditModal(id, name, departmentId, roleId) {

        const modal = document.getElementById('edit-modal');
        const content = document.getElementById('edit-modal-content');
        const form = document.getElementById('edit-position-form');
        const nameInput = document.getElementById('edit_position_name');
        const departmentSelect = document.getElementById('edit_position_department_id');
        const roleSelect = document.getElementById('edit_position_role_id');

        nameInput.value = name;
        departmentSelect.value = departmentId;
        roleSelect.value = roleId;

        form.action = `{{ url('/positions') }}/${id}`;

        const error = document.getElementById('edit-name-error');

        error.classList.add('hidden');
        error.classList.remove('flex');

        nameInput.classList.remove('border-red-500');

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

        setTimeout(() => {

            nameInput.focus();
            nameInput.select();

        }, 200);

    }

    function closeEditModal() {

        const modal = document.getElementById('edit-modal');
        const content = document.getElementById('edit-modal-content');

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

    document
        .getElementById('edit-modal')
        ?.addEventListener('click', function (e) {

            if (e.target === this) {

                closeEditModal();

            }

        });

    document.addEventListener('keydown', function (e) {

        if (e.key === 'Escape') {

            closeEditModal();

        }

    });

</script>
@endpush

@include('positions.create')
@include('positions.edit')

@endsection
