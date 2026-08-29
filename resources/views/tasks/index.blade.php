@extends('layouts.app')

@section('title', 'Monitoring Tugas')

@section('content')

@php
    $user = auth()->user();

    $canManageTask =
        $user->canManageTasks();

    $isStaff =
        $user->isStaff();
@endphp

<main>

    {{-- ============================================================
        HEADER
    ============================================================ --}}
    <div class="pt-5 mb-5">

        <div class="flex flex-col
                    md:flex-row
                    md:items-center
                    md:justify-between
                    gap-4">

            <div>
                <h1 class="text-2xl
                           font-semibold
                           text-gray-900
                           dark:text-white">

                    Monitoring Tugas

                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Pantau dan kelola seluruh tugas yang sedang berjalan.
                </p>
            </div>


            @if($canManageTask)
                <div class="flex items-center gap-2">
                    <div class="relative">
                        <button id="taskExportDropdownButton" data-dropdown-toggle="taskExportDropdown" type="button" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                            Export
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div id="taskExportDropdown" class="hidden z-20 w-25 mt-2 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">
                            <a href="{{ route('tasks.export', array_merge(request()->query(), ['format' => 'xlsx'])) }}" data-download class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600">Excel</a>
                            <a href="{{ route('tasks.export', array_merge(request()->query(), ['format' => 'csv'])) }}" data-download class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600">CSV</a>
                            <a href="{{ route('tasks.export', array_merge(request()->query(), ['format' => 'pdf'])) }}" data-download class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-600">PDF</a>
                        </div>
                    </div>
                    <a href="{{ route('tasks.create') }}"
                class="inline-flex
                        items-center
                        justify-center
                        gap-2
                        px-4 py-2.5
                        text-sm
                        font-medium
                        text-white
                        bg-primary-600
                        rounded-lg
                        hover:bg-primary-700
                        focus:outline-none
                        focus:ring-2
                        focus:ring-primary-500">

                    <svg class="w-4 h-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v16m8-8H4"/>

                    </svg>

                    Buat Tugas

                </a>
                </div>
            @endif
        </div>

    </div>


    {{-- ============================================================
        SUMMARY CARDS
    ============================================================ --}}
    <div class="grid
                grid-cols-1
                gap-4
                mb-6
                sm:grid-cols-2
                lg:grid-cols-3
                xl:grid-cols-5">


        {{-- Total --}}
        <div class="p-5
                    bg-white
                    dark:bg-gray-800
                    rounded-2xl
                    shadow-sm
                    border border-gray-100
                    dark:border-gray-700">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Total Tugas
                    </p>

                    <p class="mt-2
                              text-2xl
                              font-bold
                              text-gray-800
                              dark:text-white">

                        {{ $stats['total'] ?? 0 }}

                    </p>

                    {{-- <p class="mt-1 text-xs text-gray-400">
                        Seluruh tugas
                    </p> --}}

                </div>


                <div class="flex
                            items-center
                            justify-center
                            w-11 h-11
                            rounded-xl
                            bg-blue-50
                            text-blue-600">

                    <svg class="w-5 h-5"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.7"
                              d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a3 3 0 0 1 6 0M9 5h6M9 12h6m-6 4h6"/>

                    </svg>

                </div>

            </div>

        </div>


        {{-- Belum Dimulai --}}
        <div class="p-5
                    bg-white
                    dark:bg-gray-800
                    rounded-2xl
                    shadow-sm
                    border border-gray-100
                    dark:border-gray-700">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Belum Dimulai
                    </p>

                    <p class="mt-2
                              text-2xl
                              font-bold
                              text-gray-600">

                        {{ $stats['not_started'] ?? 0 }}

                    </p>

                    {{-- <p class="mt-1 text-xs text-gray-400">
                        Menunggu dikerjakan
                    </p> --}}

                </div>


                <div class="flex
                            items-center
                            justify-center
                            w-11 h-11
                            rounded-xl
                            bg-gray-100
                            text-gray-500">

                    <svg class="w-5 h-5"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <circle cx="12"
                                cy="12"
                                r="9"
                                stroke-width="1.7"/>

                        <path stroke-linecap="round"
                              stroke-width="1.7"
                              d="M12 7v5l3 2"/>

                    </svg>

                </div>

            </div>

        </div>


        {{-- Sedang Dikerjakan --}}
        <div class="p-5
                    bg-white
                    dark:bg-gray-800
                    rounded-2xl
                    shadow-sm
                    border border-gray-100
                    dark:border-gray-700">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Sedang Dikerjakan
                    </p>

                    <p class="mt-2
                              text-2xl
                              font-bold
                              text-blue-600">

                        {{ $stats['in_progress'] ?? 0 }}

                    </p>

                    {{-- <p class="mt-1 text-xs text-gray-400">
                        Dalam proses
                    </p> --}}

                </div>


                <div class="flex
                            items-center
                            justify-center
                            w-11 h-11
                            rounded-xl
                            bg-blue-50
                            text-blue-600">

                    <svg class="w-5 h-5"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <circle cx="12"
                                cy="12"
                                r="9"
                                stroke-width="1.7"/>

                        <path stroke-linecap="round"
                              stroke-width="1.7"
                              d="M12 8v4l3 2"/>

                    </svg>

                </div>

            </div>

        </div>


        {{-- Selesai --}}
        <div class="p-5
                    bg-white
                    dark:bg-gray-800
                    rounded-2xl
                    shadow-sm
                    border border-gray-100
                    dark:border-gray-700">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Selesai
                    </p>

                    <p class="mt-2
                              text-2xl
                              font-bold
                              text-green-600">

                        {{ $stats['completed'] ?? 0 }}

                    </p>

                    {{-- <p class="mt-1 text-xs text-gray-400">
                        Tugas selesai
                    </p> --}}

                </div>


                <div class="flex
                            items-center
                            justify-center
                            w-11 h-11
                            rounded-xl
                            bg-green-50
                            text-green-600">

                    <svg class="w-5 h-5"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <circle cx="12"
                                cy="12"
                                r="9"
                                stroke-width="1.7"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.7"
                              d="m8 12 2.5 2.5L16 9"/>

                    </svg>

                </div>

            </div>

        </div>


        {{-- Terlambat --}}
        <div class="p-5
                    bg-white
                    dark:bg-gray-800
                    rounded-2xl
                    shadow-sm
                    border border-gray-100
                    dark:border-gray-700">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Terlambat
                    </p>

                    <p class="mt-2
                              text-2xl
                              font-bold
                              text-red-600">

                        {{ $stats['overdue'] ?? 0 }}

                    </p>

                    {{-- <p class="mt-1 text-xs text-gray-400">
                        Melewati deadline
                    </p> --}}

                </div>


                <div class="flex
                            items-center
                            justify-center
                            w-11 h-11
                            rounded-xl
                            bg-red-50
                            text-red-600">

                    <svg class="w-5 h-5"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.7"
                              d="M12 9v4m0 4h.01M10.3 4.6 3.8 16a2 2 0 0 0 1.74 3h12.92A2 2 0 0 0 20.2 16L13.7 4.6a2 2 0 0 0-3.4 0Z"/>

                    </svg>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================
        FILTER CARD
    ============================================================ --}}
    <div class="mb-5
                bg-white
                dark:bg-gray-800
                border border-gray-200
                dark:border-gray-700
                rounded-2xl
                shadow-sm">

        {{-- Filter Header --}}
        <div class="flex
                    items-center
                    justify-between
                    gap-3
                    px-5 py-4
                    border-b border-gray-100
                    dark:border-gray-700">

            <div class="flex items-center gap-3">

                <div class="flex
                            items-center
                            justify-center
                            w-9 h-9
                            rounded-lg
                            bg-primary-50
                            text-primary-600">

                    <svg class="w-5 h-5"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.7"
                              d="M4 5h16l-6 7v5l-4 2v-7L4 5Z"/>

                    </svg>

                </div>


                <div>

                    <h2 class="text-base
                               font-semibold
                               text-gray-800
                               dark:text-white">

                        Filter Data

                    </h2>

                    <p class="text-xs text-gray-400 mt-0.5">
                        Atur data tugas sesuai kebutuhan.
                    </p>

                </div>

            </div>

        </div>


        {{-- Filter Form --}}
        <form action="{{ route('tasks.index') }}"
              method="GET"
              class="p-5">

            <input type="hidden"
                   name="per_page"
                   value="{{ request('per_page', 10) }}">


            {{-- =========================
                ROW 1
            ========================== --}}
            <div class="grid
                        grid-cols-1
                        gap-4
                        md:grid-cols-2
                        xl:grid-cols-12">


                {{-- Search --}}
                <div class="
                    {{ $user->isStaff()
                        ? 'xl:col-span-4'
                        : 'xl:col-span-4'
                    }}
                ">

                    <label
                        for="search"
                        class="block mb-2
                            text-sm font-medium
                            text-gray-700
                            dark:text-gray-200"
                    >
                        Cari Tugas
                    </label>


                    <div class="relative">

                        <div class="absolute
                                    inset-y-0
                                    left-0
                                    flex
                                    items-center
                                    pl-3.5
                                    pointer-events-none">

                            <svg
                                class="w-4 h-4 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"
                                />
                            </svg>

                        </div>


                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari..."
                            class="block
                                w-full
                                h-11
                                pl-10 pr-4
                                text-sm
                                text-gray-700
                                dark:text-gray-200
                                bg-white
                                dark:bg-gray-900
                                border border-gray-200
                                dark:border-gray-700
                                rounded-xl
                                focus:outline-none
                                focus:border-primary-500
                                focus:ring-2
                                focus:ring-primary-100"
                        >

                    </div>

                </div>


                {{-- PIC --}}
                @if(!$user->isStaff())

                    <div class="xl:col-span-3">

                        <label
                            for="pic_id"
                            class="block mb-2
                                text-sm font-medium
                                text-gray-700
                                dark:text-gray-200"
                        >
                            PIC
                        </label>


                        <select
                            id="pic_id"
                            name="pic_id"
                            class="block
                                w-full
                                h-11
                                px-3
                                text-sm
                                text-gray-700
                                dark:text-gray-200
                                bg-white
                                dark:bg-gray-900
                                border border-gray-200
                                dark:border-gray-700
                                rounded-xl
                                focus:outline-none
                                focus:border-primary-500
                                focus:ring-2
                                focus:ring-primary-100
                                cursor-pointer"
                        >

                            <option value="">
                                Semua PIC
                            </option>

                            @foreach($employees as $employee)

                                <option
                                    value="{{ $employee->id }}"
                                    @selected(
                                        request('pic_id') == $employee->id
                                    )
                                >
                                    {{ $employee->name }}

                                    @if($employee->employee_code)
                                        - {{ $employee->employee_code }}
                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>

                @endif


                {{-- Status --}}
                <div class="
                    {{ $user->isStaff()
                        ? 'xl:col-span-4'
                        : 'xl:col-span-2'
                    }}
                ">

                    <label
                        for="task_status_id"
                        class="block mb-2
                            text-sm font-medium
                            text-gray-700
                            dark:text-gray-200"
                    >
                        Status
                    </label>


                    <select
                        id="task_status_id"
                        name="task_status_id"
                        class="block
                            w-full
                            h-11
                            px-3
                            text-sm
                            text-gray-700
                            dark:text-gray-200
                            bg-white
                            dark:bg-gray-900
                            border border-gray-200
                            dark:border-gray-700
                            rounded-xl
                            focus:outline-none
                            focus:border-primary-500
                            focus:ring-2
                            focus:ring-primary-100
                            cursor-pointer"
                    >

                        <option value="">
                            Semua Status
                        </option>

                        @foreach($statuses as $status)

                            <option
                                value="{{ $status->id }}"
                                @selected(
                                    request('task_status_id') == $status->id
                                )
                            >
                                {{ $status->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Prioritas --}}
                <div class="
                    {{ $user->isStaff()
                        ? 'xl:col-span-4'
                        : 'xl:col-span-3'
                    }}
                ">

                    <label
                        for="task_priority_id"
                        class="block mb-2
                            text-sm font-medium
                            text-gray-700
                            dark:text-gray-200"
                    >
                        Prioritas
                    </label>


                    <select
                        id="task_priority_id"
                        name="task_priority_id"
                        class="block
                            w-full
                            h-11
                            px-3
                            text-sm
                            text-gray-700
                            dark:text-gray-200
                            bg-white
                            dark:bg-gray-900
                            border border-gray-200
                            dark:border-gray-700
                            rounded-xl
                            focus:outline-none
                            focus:border-primary-500
                            focus:ring-2
                            focus:ring-primary-100
                            cursor-pointer"
                    >

                        <option value="">
                            Semua Prioritas
                        </option>

                        @foreach($priorities as $priority)

                            <option
                                value="{{ $priority->id }}"
                                @selected(
                                    request('task_priority_id')
                                    == $priority->id
                                )
                            >
                                {{ $priority->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>


            {{-- =========================
                ROW 2
            ========================== --}}
            <div class="grid
                        grid-cols-1
                        gap-4
                        mt-4
                        md:grid-cols-2
                        xl:grid-cols-12">


                {{-- Deadline Start --}}
                <div class="xl:col-span-4">

                    <label for="deadline_start"
                           class="block
                                  mb-2
                                  text-sm
                                  font-medium
                                  text-gray-700
                                  dark:text-gray-200">

                        Deadline Mulai

                    </label>


                    <input
                        type="date"
                        id="deadline_start"
                        name="deadline_start"
                        value="{{ request('deadline_start') }}"
                        class="block
                               w-full
                               h-11
                               px-3
                               text-sm
                               text-gray-700
                               dark:text-gray-200
                               bg-white
                               dark:bg-gray-900
                               border border-gray-200
                               dark:border-gray-700
                               rounded-xl
                               focus:outline-none
                               focus:border-primary-500
                               focus:ring-2
                               focus:ring-primary-100"
                    >

                </div>


                {{-- Deadline End --}}
                <div class="xl:col-span-4">

                    <label for="deadline_end"
                           class="block
                                  mb-2
                                  text-sm
                                  font-medium
                                  text-gray-700
                                  dark:text-gray-200">

                        Deadline Akhir

                    </label>


                    <input
                        type="date"
                        id="deadline_end"
                        name="deadline_end"
                        value="{{ request('deadline_end') }}"
                        class="block
                               w-full
                               h-11
                               px-3
                               text-sm
                               text-gray-700
                               dark:text-gray-200
                               bg-white
                               dark:bg-gray-900
                               border border-gray-200
                               dark:border-gray-700
                               rounded-xl
                               focus:outline-none
                               focus:border-primary-500
                               focus:ring-2
                               focus:ring-primary-100"
                    >

                </div>


                {{-- Actions --}}
                <div class="xl:col-span-4
                            flex
                            items-end
                            justify-start
                            xl:justify-end
                            gap-3">


                    <a href="{{ route('tasks.index', [
                                'per_page' => request('per_page', 10)
                            ]) }}"
                       class="inline-flex
                              items-center
                              justify-center
                              gap-2
                              h-11
                              px-4
                              text-sm
                              font-medium
                              text-gray-600
                              dark:text-gray-300
                              bg-white
                              dark:bg-gray-900
                              border border-gray-200
                              dark:border-gray-700
                              rounded-xl
                              hover:bg-gray-50
                              dark:hover:bg-gray-800">

                        <svg class="w-4 h-4"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M4 4v6h6M20 20v-6h-6M5.1 15A8 8 0 0 0 18 17m.9-8A8 8 0 0 0 6 7"/>

                        </svg>

                        Reset

                    </a>


                    <button
                        type="submit"
                        class="inline-flex
                               items-center
                               justify-center
                               gap-2
                               h-11
                               px-5
                               text-sm
                               font-medium
                               text-white
                               bg-primary-600
                               border border-primary-600
                               rounded-xl
                               hover:bg-primary-700
                               focus:outline-none
                               focus:ring-2
                               focus:ring-primary-500">

                        <svg class="w-4 h-4"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M4 5h16l-6 7v5l-4 2v-7L4 5Z"/>

                        </svg>

                        Terapkan Filter

                    </button>

                </div>

            </div>

        </form>

    </div>


    {{-- ============================================================
        ACTIVE FILTERS
    ============================================================ --}}
    @php
        $hasActiveFilter =
            request()->filled('search')
            || request()->filled('pic_id')
            || request()->filled('task_status_id')
            || request()->filled('task_priority_id')
            || request()->filled('deadline_start')
            || request()->filled('deadline_end');

        $currentPic = request()->filled('pic_id')
            ? $employees->firstWhere('id', request('pic_id'))
            : null;

        $currentStatus = request()->filled('task_status_id')
            ? $statuses->firstWhere('id', request('task_status_id'))
            : null;

        $currentPriority = request()->filled('task_priority_id')
            ? $priorities->firstWhere('id', request('task_priority_id'))
            : null;
    @endphp


    @if($hasActiveFilter)

        <div class="flex
                    flex-col
                    md:flex-row
                    md:items-center
                    md:justify-between
                    gap-3
                    mb-5
                    px-4 py-3
                    bg-primary-50/50
                    dark:bg-gray-800
                    border border-primary-100
                    dark:border-gray-700
                    rounded-xl">


            <div class="flex
                        flex-wrap
                        items-center
                        gap-2">

                <span class="text-xs
                             font-semibold
                             text-gray-600
                             dark:text-gray-300
                             mr-1">

                    Filter aktif:

                </span>


                {{-- Search --}}
                @if(request()->filled('search'))

                    <a href="{{ route(
                                'tasks.index',
                                request()->except([
                                    'search',
                                    'page'
                                ])
                            ) }}"
                       class="inline-flex
                              items-center
                              gap-1.5
                              px-3 py-1.5
                              text-xs
                              font-medium
                              text-primary-700
                              bg-white
                              border border-primary-200
                              rounded-full
                              hover:bg-primary-50">

                        Pencarian:
                        {{ request('search') }}

                        <span class="text-primary-400">
                            ×
                        </span>

                    </a>

                @endif


                {{-- PIC --}}
                @if($currentPic)

                    <a href="{{ route(
                                'tasks.index',
                                request()->except([
                                    'pic_id',
                                    'page'
                                ])
                            ) }}"
                       class="inline-flex
                              items-center
                              gap-1.5
                              px-3 py-1.5
                              text-xs
                              font-medium
                              text-primary-700
                              bg-white
                              border border-primary-200
                              rounded-full
                              hover:bg-primary-50">

                        PIC:
                        {{ $currentPic->name }}

                        <span class="text-primary-400">
                            ×
                        </span>

                    </a>

                @endif


                {{-- Status --}}
                @if($currentStatus)

                    <a href="{{ route(
                                'tasks.index',
                                request()->except([
                                    'task_status_id',
                                    'page'
                                ])
                            ) }}"
                       class="inline-flex
                              items-center
                              gap-1.5
                              px-3 py-1.5
                              text-xs
                              font-medium
                              text-primary-700
                              bg-white
                              border border-primary-200
                              rounded-full
                              hover:bg-primary-50">

                        Status:
                        {{ $currentStatus->name }}

                        <span class="text-primary-400">
                            ×
                        </span>

                    </a>

                @endif


                {{-- Prioritas --}}
                @if($currentPriority)

                    <a href="{{ route(
                                'tasks.index',
                                request()->except([
                                    'task_priority_id',
                                    'page'
                                ])
                            ) }}"
                       class="inline-flex
                              items-center
                              gap-1.5
                              px-3 py-1.5
                              text-xs
                              font-medium
                              text-primary-700
                              bg-white
                              border border-primary-200
                              rounded-full
                              hover:bg-primary-50">

                        Prioritas:
                        {{ $currentPriority->name }}

                        <span class="text-primary-400">
                            ×
                        </span>

                    </a>

                @endif


                {{-- Deadline --}}
                @if(
                    request()->filled('deadline_start')
                    || request()->filled('deadline_end')
                )

                    <a href="{{ route(
                                'tasks.index',
                                request()->except([
                                    'deadline_start',
                                    'deadline_end',
                                    'page'
                                ])
                            ) }}"
                       class="inline-flex
                              items-center
                              gap-1.5
                              px-3 py-1.5
                              text-xs
                              font-medium
                              text-primary-700
                              bg-white
                              border border-primary-200
                              rounded-full
                              hover:bg-primary-50">

                        Deadline:

                        @if(request()->filled('deadline_start'))

                            {{ \Carbon\Carbon::parse(
                                request('deadline_start')
                            )->translatedFormat('d M Y') }}

                        @else

                            Awal

                        @endif

                        -

                        @if(request()->filled('deadline_end'))

                            {{ \Carbon\Carbon::parse(
                                request('deadline_end')
                            )->translatedFormat('d M Y') }}

                        @else

                            Seterusnya

                        @endif

                        <span class="text-primary-400">
                            ×
                        </span>

                    </a>

                @endif

            </div>


            <a href="{{ route('tasks.index', [
                        'per_page' => request('per_page', 10)
                    ]) }}"
               class="inline-flex
                      items-center
                      gap-1.5
                      text-xs
                      font-medium
                      text-red-600
                      hover:text-red-700">

                <svg class="w-4 h-4"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.7"
                          d="M5 7h14M9 7V4h6v3m-8 0 1 13h8l1-13M10 11v5m4-5v5"/>

                </svg>

                Hapus Semua

            </a>

        </div>

    @endif


    {{-- ============================================================
        TABLE CARD
    ============================================================ --}}
    <div class="bg-white
                dark:bg-gray-800
                border border-gray-200
                dark:border-gray-700
                rounded-2xl
                shadow-sm">


        {{-- Table Header --}}
        <div class="flex
                    flex-col
                    md:flex-row
                    md:items-center
                    md:justify-between
                    gap-4
                    px-5 py-4
                    border-b border-gray-100
                    dark:border-gray-700">


            {{-- Per Page --}}
            <div class="flex
                        items-center
                        gap-2
                        text-sm
                        text-gray-600
                        dark:text-gray-300">

                <span>
                    Tampilkan
                </span>


                <select
                    onchange="updatePerPage(this.value)"
                    class="h-10
                           px-3
                           text-sm
                           bg-white
                           dark:bg-gray-900
                           border border-gray-200
                           dark:border-gray-700
                           rounded-lg
                           focus:outline-none
                           focus:border-primary-500
                           focus:ring-2
                           focus:ring-primary-100">

                    @foreach([10, 25, 50, 100] as $size)

                        <option
                            value="{{ $size }}"
                            @selected(
                                request('per_page', 10) == $size
                            )>

                            {{ $size }}

                        </option>

                    @endforeach

                </select>


                <span>
                    data per halaman
                </span>

            </div>


            <div class="text-sm text-gray-500">

                Total
                <span class="font-semibold text-gray-700 dark:text-white">
                    {{ $tasks->total() }}
                </span>
                data

            </div>

        </div>


        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead>

                    <tr class="bg-slate-200
                               dark:bg-gray-700">

                        <th class="px-6 py-4
                                   text-xs
                                   font-bold
                                   tracking-wider
                                   text-gray-500
                                   uppercase">

                            Kode Tugas

                        </th>


                        <th class="px-6 py-4
                                   text-xs
                                   font-bold
                                   tracking-wider
                                   text-gray-500
                                   uppercase">

                            Judul

                        </th>


                        <th class="px-6 py-4
                                   text-xs
                                   font-bold
                                   tracking-wider
                                   text-gray-500
                                   uppercase">

                            PIC

                        </th>


                        <th class="px-6 py-4
                                   text-xs
                                   font-bold
                                   tracking-wider
                                   text-gray-500
                                   uppercase">

                            Prioritas

                        </th>


                        <th class="px-6 py-4
                                   text-xs
                                   font-bold
                                   tracking-wider
                                   text-gray-500
                                   uppercase">

                            Status

                        </th>


                        <th class="px-6 py-4
                                   text-xs
                                   font-bold
                                   tracking-wider
                                   text-gray-500
                                   uppercase">

                            Deadline

                        </th>


                        <th class="px-6 py-4
                                   text-xs
                                   font-bold
                                   tracking-wider
                                   text-gray-500
                                   uppercase">

                            Dibuat

                        </th>


                        <th class="px-6 py-4
                                   text-xs
                                   font-bold
                                   tracking-wider
                                   text-center
                                   text-gray-500
                                   uppercase">

                            Aksi

                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($tasks as $task)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | Priority Color
                            |--------------------------------------------------------------------------
                            */

                            $priorityColors = [
                                'gray' =>
                                    'bg-gray-100 text-gray-700',

                                'blue' =>
                                    'bg-blue-100 text-blue-700',

                                'green' =>
                                    'bg-green-100 text-green-700',

                                'yellow' =>
                                    'bg-yellow-100 text-yellow-700',

                                'orange' =>
                                    'bg-orange-100 text-orange-700',

                                'red' =>
                                    'bg-red-100 text-red-700',

                                'purple' =>
                                    'bg-purple-100 text-purple-700',
                            ];

                            $priorityClass =
                                $priorityColors[
                                    $task->priority?->color
                                ]
                                ?? 'bg-gray-100 text-gray-700';


                            /*
                            |--------------------------------------------------------------------------
                            | Status Color
                            |--------------------------------------------------------------------------
                            */

                            $statusColors = [
                                'gray' =>
                                    'bg-gray-100 text-gray-700',

                                'blue' =>
                                    'bg-blue-100 text-blue-700',

                                'green' =>
                                    'bg-green-100 text-green-700',

                                'yellow' =>
                                    'bg-yellow-100 text-yellow-700',

                                'orange' =>
                                    'bg-orange-100 text-orange-700',

                                'red' =>
                                    'bg-red-100 text-red-700',

                                'purple' =>
                                    'bg-purple-100 text-purple-700',
                            ];

                            $statusClass =
                                $statusColors[
                                    $task->status?->color
                                ]
                                ?? 'bg-gray-100 text-gray-700';


                            /*
                            |--------------------------------------------------------------------------
                            | Deadline
                            |--------------------------------------------------------------------------
                            */

                            $deadline =
                                $task->deadline
                                    ->copy()
                                    ->startOfDay();

                            $today = today();


                            if (
                                $task->status?->code
                                === 'completed'
                            ) {

                                $deadlineLabel =
                                    'Selesai';

                                $deadlineClass =
                                    'text-green-600 dark:text-green-400';

                            } elseif (
                                $deadline->isToday()
                            ) {

                                $deadlineLabel =
                                    'Jatuh tempo hari ini';

                                $deadlineClass =
                                    'text-orange-600 dark:text-orange-400';

                            } elseif (
                                $deadline->lt($today)
                            ) {

                                $daysLate =
                                    (int)
                                    $deadline
                                        ->diffInDays(
                                            $today
                                        );

                                $deadlineLabel =
                                    'Terlambat '
                                    . $daysLate
                                    . ' hari';

                                $deadlineClass =
                                    'text-red-600 dark:text-red-400';

                            } else {

                                $daysRemaining =
                                    (int)
                                    $today
                                        ->diffInDays(
                                            $deadline
                                        );

                                $deadlineLabel =
                                    'H-'
                                    . $daysRemaining;


                                if (
                                    $daysRemaining <= 3
                                ) {

                                    $deadlineClass =
                                        'text-orange-600 dark:text-orange-400';

                                } elseif (
                                    $daysRemaining <= 7
                                ) {

                                    $deadlineClass =
                                        'text-yellow-600 dark:text-yellow-400';

                                } else {

                                    $deadlineClass =
                                        'text-gray-500 dark:text-gray-400';

                                }
                            }

                        @endphp


                        <tr class="border-t
                                   border-gray-100
                                   dark:border-gray-700
                                   hover:bg-gray-50
                                   dark:hover:bg-gray-700/40
                                   transition">


                            {{-- Kode --}}
                            <td class="px-6 py-4 whitespace-nowrap">

                                <div class="font-semibold text-primary-600">

                                    {{ $task->task_code }}

                                </div>

                            </td>


                            {{-- Judul --}}
                            <td class="px-6 py-4">

                                <div class="font-medium
                                            text-gray-900
                                            dark:text-white
                                            text-sm">

                                    {{ $task->title }}

                                </div>


                                @if($task->description)

                                    <div class="mt-1
                                                max-w-xs
                                                text-xs
                                                text-gray-400
                                                truncate">

                                        {{ $task->description }}

                                    </div>

                                @endif

                            </td>


                            {{-- PIC --}}
                            <td class="px-6 py-4 whitespace-nowrap">

                                @if($task->pic)

                                    <div class="font-medium
                                                text-gray-700
                                                dark:text-gray-200">

                                        {{ $task->pic->name }}

                                    </div>


                                    <div class="mt-1
                                                text-xs
                                                text-gray-400">

                                        {{ $task->pic->employee_code }}

                                    </div>

                                @else

                                    <span class="text-gray-400">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- Prioritas --}}
                            <td class="px-6 py-4 whitespace-nowrap">

                                <span class="inline-flex
                                             items-center
                                             px-2.5 py-1
                                             text-xs
                                             font-medium
                                             rounded-full
                                             {{ $priorityClass }}">

                                    {{ $task->priority?->name ?? '-' }}

                                </span>

                            </td>


                            {{-- Status --}}
                            <td class="px-6 py-4 whitespace-nowrap">

                                <span class="inline-flex
                                             items-center
                                             px-2.5 py-1
                                             text-xs
                                             font-medium
                                             rounded-full
                                             {{ $statusClass }}">

                                    {{ $task->status?->name ?? '-' }}

                                </span>

                            </td>


                            {{-- Deadline --}}
                            <td class="px-6 py-4 whitespace-nowrap">

                                <div class="text-sm
                                            font-medium
                                            text-gray-700
                                            dark:text-gray-200">

                                    {{ $task->deadline
                                        ->translatedFormat(
                                            'd M Y'
                                        ) }}

                                </div>


                                <div class="mt-1
                                            text-xs
                                            font-semibold
                                            {{ $deadlineClass }}">

                                    {{ $deadlineLabel }}

                                </div>

                            </td>


                            {{-- Dibuat --}}
                            <td class="px-6 py-4 whitespace-nowrap">

                                <div class="text-sm
                                            text-gray-700
                                            dark:text-gray-200">

                                    {{ $task->created_at
                                        ->translatedFormat(
                                            'd M Y'
                                        ) }}

                                </div>


                                <div class="mt-1
                                            text-xs
                                            text-gray-400">

                                    {{ $task->created_at
                                        ->format('H:i') }}

                                </div>

                            </td>


                            {{-- ==================================================
                                ACTION
                            =================================================== --}}
                            <td class="px-6 py-4 text-center">

                                <div class="relative inline-block">

                                    <button
                                        id="dropdownDelay{{ $task->id }}Button"
                                        data-dropdown-toggle="dropdownDelay{{ $task->id }}"
                                        data-dropdown-delay="500"
                                        data-dropdown-trigger="click"
                                        type="button"
                                        class="inline-flex
                                               items-center
                                               justify-center
                                               w-9 h-9
                                               text-gray-600
                                               dark:text-gray-200
                                               bg-white
                                               dark:bg-gray-800
                                               border border-gray-200
                                               dark:border-gray-600
                                               rounded-lg
                                               hover:bg-gray-50
                                               dark:hover:bg-gray-700
                                               cursor-pointer">

                                        <svg
                                            class="w-5 h-5"
                                            fill="none"
                                            viewBox="0 0 24 24">

                                            <path
                                                stroke="currentColor"
                                                stroke-linecap="round"
                                                stroke-width="2"
                                                d="M12 6h.01M12 12h.01M12 18h.01"
                                            />

                                        </svg>

                                    </button>


                                    <div
                                        id="dropdownDelay{{ $task->id }}"
                                        class="absolute
                                               right-0
                                               mt-2
                                               z-50
                                               hidden
                                               bg-white
                                               dark:bg-gray-800
                                               border border-gray-200
                                               dark:border-gray-700
                                               rounded-lg
                                               shadow-lg
                                               w-44">

                                        <ul
                                            class="p-2
                                                   text-sm
                                                   text-gray-700
                                                   dark:text-gray-200
                                                   font-medium"
                                            aria-labelledby="dropdownDelay{{ $task->id }}Button">


                                            {{-- Detail --}}
                                            <li>

                                                <a
                                                    href="{{ route(
                                                        'tasks.show',
                                                        $task->id
                                                    ) }}"
                                                    class="inline-flex
                                                           items-center
                                                           gap-2
                                                           w-full
                                                           px-3 py-2
                                                           hover:bg-gray-100
                                                           dark:hover:bg-gray-700
                                                           rounded-lg">

                                                    <svg
                                                        class="w-4 h-4"
                                                        fill="none"
                                                        viewBox="0 0 24 24">

                                                        <path
                                                            stroke="currentColor"
                                                            stroke-width="1.5"
                                                            d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"
                                                        />

                                                        <path
                                                            stroke="currentColor"
                                                            stroke-width="1.5"
                                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                                        />

                                                    </svg>

                                                    Detail

                                                </a>

                                            </li>


                                            {{-- Edit --}}
                                            @can('update', $task)
                                            <li>

                                                <a
                                                    href="{{ route(
                                                        'tasks.edit',
                                                        $task->id
                                                    ) }}"
                                                    class="inline-flex
                                                           items-center
                                                           gap-2
                                                           w-full
                                                           px-3 py-2
                                                           hover:bg-gray-100
                                                           dark:hover:bg-gray-700
                                                           rounded-lg">

                                                    <svg
                                                        class="w-4 h-4"
                                                        fill="none"
                                                        viewBox="0 0 24 24">

                                                        <path
                                                            stroke="currentColor"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="1.5"
                                                            d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5"
                                                        />

                                                    </svg>

                                                    Edit

                                                </a>

                                            </li>
                                            @endcan


                                            {{-- Delete --}}
                                            @can('delete', $task)
                                            <li>

                                                <form
                                                    id="delete-form-{{ $task->id }}"
                                                    action="{{ route(
                                                        'tasks.destroy',
                                                        $task->id
                                                    ) }}"
                                                    method="POST">

                                                    @csrf
                                                    @method('DELETE')


                                                    <button
                                                        type="button"
                                                        onclick="openDeleteModal(
                                                            'delete-form-{{ $task->id }}',
                                                            @js($task->title)
                                                        )"
                                                        class="inline-flex
                                                               items-center
                                                               gap-2
                                                               w-full
                                                               px-3 py-2
                                                               text-red-600
                                                               hover:bg-red-50
                                                               dark:hover:bg-gray-700
                                                               rounded-lg
                                                               cursor-pointer">

                                                        <svg
                                                            class="w-4 h-4"
                                                            fill="none"
                                                            viewBox="0 0 24 24">

                                                            <path
                                                                stroke="currentColor"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="1.5"
                                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"
                                                            />

                                                        </svg>

                                                        Hapus

                                                    </button>

                                                </form>

                                            </li>
                                            @endcan
                                        </ul>

                                    </div>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="px-6
                                       py-12
                                       text-center">

                                <div class="flex
                                            flex-col
                                            items-center
                                            justify-center">

                                    <div class="flex
                                                items-center
                                                justify-center
                                                w-12 h-12
                                                mb-3
                                                rounded-full
                                                bg-gray-100
                                                text-gray-400">

                                        <svg class="w-6 h-6"
                                             fill="none"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="1.5"
                                                  d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a3 3 0 0 1 6 0M9 5h6"/>

                                        </svg>

                                    </div>


                                    <p class="text-sm
                                              font-medium
                                              text-gray-600
                                              dark:text-gray-300">

                                        Tidak ada data tugas

                                    </p>


                                    <p class="mt-1
                                              text-xs
                                              text-gray-400">

                                        Coba ubah filter atau kata pencarian.

                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- ============================================================
            PAGINATION
        ============================================================ --}}
        <div class="flex
                    flex-col
                    md:flex-row
                    items-center
                    justify-between
                    gap-4
                    px-5 py-4
                    border-t border-gray-100
                    dark:border-gray-700">


            <div class="text-sm text-gray-500">

                Menampilkan

                <span class="font-semibold">
                    {{ $tasks->firstItem() ?? 0 }}
                </span>

                -

                <span class="font-semibold">
                    {{ $tasks->lastItem() ?? 0 }}
                </span>

                dari

                <span class="font-semibold">
                    {{ $tasks->total() }}
                </span>

                data

            </div>


            <div>
                {{ $tasks->withQueryString()->links() }}
            </div>

        </div>

    </div>

</main>


@push('scripts')

<script>

    /*
    |--------------------------------------------------------------------------
    | Update Per Page
    |--------------------------------------------------------------------------
    */

    function updatePerPage(value)
    {
        const url = new URL(
            window.location.href
        );

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
    | Validasi Deadline Range
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function ()
        {
            const startInput =
                document.getElementById(
                    'deadline_start'
                );

            const endInput =
                document.getElementById(
                    'deadline_end'
                );


            if (
                !startInput
                || !endInput
            ) {
                return;
            }


            function updateEndMinimum()
            {
                if (
                    startInput.value
                ) {

                    endInput.min =
                        startInput.value;

                } else {

                    endInput.removeAttribute(
                        'min'
                    );

                }
            }


            startInput.addEventListener(
                'change',
                function ()
                {
                    updateEndMinimum();


                    if (
                        endInput.value
                        && startInput.value
                        && endInput.value
                            < startInput.value
                    ) {

                        endInput.value = '';

                    }
                }
            );


            updateEndMinimum();
        }
    );

</script>

@endpush

@endsection
