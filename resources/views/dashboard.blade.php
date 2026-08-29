@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | Dashboard Header
    |--------------------------------------------------------------------------
    */

    if ($user->isAdmin()) {

        $dashboardTitle =
            'Dashboard';

        $dashboardDescription =
            'Ringkasan aktivitas karyawan dan tugas seluruh perusahaan.';

    } elseif ($user->isManagement()) {

        $dashboardTitle =
            'Dashboard '
            . (
                $employee?->department?->name
                ?? 'Departemen'
            );

        $dashboardDescription =
            'Ringkasan karyawan dan tugas pada departemen Anda.';

    } else {

        $dashboardTitle =
            'Dashboard Saya';

        $dashboardDescription =
            'Ringkasan informasi dan tugas yang diberikan kepada Anda.';
    }


    /*
    |--------------------------------------------------------------------------
    | Colors
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


    $priorityColors =
        $statusColors;

@endphp


<main>

    {{-- ============================================================
        HEADER
    ============================================================ --}}
    <div class="pt-5 mb-6">

        <div class="flex
                    flex-col
                    lg:flex-row
                    lg:items-center
                    lg:justify-between
                    gap-4">

            <div>

                <h1 class="text-2xl
                           font-semibold
                           text-gray-900
                           dark:text-white">

                    {{ $dashboardTitle }}

                </h1>


                <p class="mt-1
                          text-sm
                          text-gray-500
                          dark:text-gray-400">

                    {{ $dashboardDescription }}

                </p>

            </div>


            {{-- Department Information --}}
            @if(!$user->isAdmin())

                <div class="inline-flex
                            items-center
                            gap-3
                            px-4 py-3
                            bg-white
                            dark:bg-gray-800
                            border
                            border-gray-200
                            dark:border-gray-700
                            rounded-xl
                            shadow-sm">

                    <div class="flex
                                items-center
                                justify-center
                                w-10 h-10
                                rounded-lg
                                bg-primary-50
                                text-primary-600">

                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.7"
                                d="M3 21h18M5 21V7l7-4 7 4v14M9 9h.01M9 13h.01M9 17h.01M15 9h.01M15 13h.01M15 17h.01"
                            />

                        </svg>

                    </div>


                    <div>

                        <p class="text-xs
                                  text-gray-400">

                            Departemen

                        </p>

                        <p class="text-sm
                                  font-semibold
                                  text-gray-700
                                  dark:text-white">

                            {{ $employee?->department?->name
                                ?? '-'
                            }}

                        </p>

                    </div>

                </div>

            @endif

        </div>

    </div>


    {{-- ============================================================
        MAIN SUMMARY
    ============================================================ --}}
    <div class="grid
                grid-cols-1
                sm:grid-cols-2
                lg:grid-cols-3
                xl:grid-cols-5
                gap-4
                mb-7">


        {{-- Karyawan --}}
        <div class="p-5
                    bg-white
                    dark:bg-gray-800
                    border
                    border-gray-100
                    dark:border-gray-700
                    rounded-2xl
                    shadow-sm">

            <div class="flex
                        items-center
                        justify-between">

                <div>

                    <p class="text-sm
                              text-gray-500">

                        {{ $user->isStaff()
                            ? 'Data Karyawan'
                            : 'Karyawan Aktif'
                        }}

                    </p>

                    <p class="mt-2
                              text-3xl
                              font-bold
                              text-gray-900
                              dark:text-white">

                        {{ $employeeStats['active'] }}

                    </p>

                </div>


                <div class="flex
                            items-center
                            justify-center
                            w-12 h-12
                            bg-violet-50
                            text-violet-600
                            rounded-xl">

                    <svg
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m7-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm13 10v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"
                        />

                    </svg>

                </div>

            </div>

        </div>


        {{-- Total Task --}}
        <div class="p-5
                    bg-white
                    dark:bg-gray-800
                    border border-gray-100
                    dark:border-gray-700
                    rounded-2xl
                    shadow-sm">

            <p class="text-sm text-gray-500">

                {{ $user->isStaff()
                    ? 'Total Tugas Saya'
                    : 'Total Tugas'
                }}

            </p>

            <p class="mt-2
                      text-3xl
                      font-bold
                      text-gray-900
                      dark:text-white">

                {{ $taskStats['total'] }}

            </p>

        </div>


        {{-- Progress --}}
        <div class="p-5
                    bg-white
                    dark:bg-gray-800
                    border border-gray-100
                    dark:border-gray-700
                    rounded-2xl
                    shadow-sm">

            <p class="text-sm text-gray-500">
                Sedang Dikerjakan
            </p>

            <p class="mt-2
                      text-3xl
                      font-bold
                      text-blue-600">

                {{ $taskStats['in_progress'] }}

            </p>

        </div>


        {{-- Completed --}}
        <div class="p-5
                    bg-white
                    dark:bg-gray-800
                    border border-gray-100
                    dark:border-gray-700
                    rounded-2xl
                    shadow-sm">

            <p class="text-sm text-gray-500">
                Tugas Selesai
            </p>

            <p class="mt-2
                      text-3xl
                      font-bold
                      text-green-600">

                {{ $taskStats['completed'] }}

            </p>

        </div>


        {{-- Overdue --}}
        <div class="p-5
                    bg-white
                    dark:bg-gray-800
                    border border-gray-100
                    dark:border-gray-700
                    rounded-2xl
                    shadow-sm">

            <p class="text-sm text-gray-500">
                Terlambat
            </p>

            <p class="mt-2
                      text-3xl
                      font-bold
                      text-red-600">

                {{ $taskStats['overdue'] }}

            </p>

        </div>

    </div>


    {{-- ============================================================
        EMPLOYEE SECTION
    ============================================================ --}}
    <div class="mb-7">

        <div class="flex
                    items-center
                    justify-between
                    mb-4">

            <div>

                <h2 class="text-lg
                           font-semibold
                           text-gray-900
                           dark:text-white">

                    Karyawan

                </h2>

                <p class="mt-1
                          text-sm
                          text-gray-500">

                    @if($user->isAdmin())

                        Ringkasan karyawan seluruh perusahaan.

                    @elseif($user->isManagement())

                        Ringkasan karyawan pada departemen Anda.

                    @else

                        Informasi data karyawan Anda.

                    @endif

                </p>

            </div>


            @if(
                $user->isAdmin()
                || $user->isManagement()
            )

                <a
                    href="{{ route('employees.index') }}"
                    class="text-sm
                           font-medium
                           text-primary-600
                           hover:text-primary-700">

                    Lihat Semua

                </a>

            @endif

        </div>


        {{-- Employee Stats --}}
        @if(!$user->isStaff())

            <div class="grid
                        grid-cols-1
                        sm:grid-cols-2
                        xl:grid-cols-4
                        gap-4
                        mb-5">

                <div class="p-4
                            bg-white
                            dark:bg-gray-800
                            border border-gray-200
                            dark:border-gray-700
                            rounded-xl">

                    <p class="text-xs text-gray-400">
                        Total Karyawan
                    </p>

                    <p class="mt-2
                              text-2xl
                              font-bold
                              text-gray-800
                              dark:text-white">

                        {{ $employeeStats['total'] }}

                    </p>

                </div>


                <div class="p-4
                            bg-white
                            dark:bg-gray-800
                            border border-gray-200
                            dark:border-gray-700
                            rounded-xl">

                    <p class="text-xs text-gray-400">
                        Manager
                    </p>

                    <p class="mt-2
                              text-2xl
                              font-bold
                              text-indigo-600">

                        {{ $employeeStats['manager'] }}

                    </p>

                </div>


                <div class="p-4
                            bg-white
                            dark:bg-gray-800
                            border border-gray-200
                            dark:border-gray-700
                            rounded-xl">

                    <p class="text-xs text-gray-400">
                        Supervisor
                    </p>

                    <p class="mt-2
                              text-2xl
                              font-bold
                              text-blue-600">

                        {{ $employeeStats['supervisor'] }}

                    </p>

                </div>


                <div class="p-4
                            bg-white
                            dark:bg-gray-800
                            border border-gray-200
                            dark:border-gray-700
                            rounded-xl">

                    <p class="text-xs text-gray-400">
                        Staff
                    </p>

                    <p class="mt-2
                              text-2xl
                              font-bold
                              text-green-600">

                        {{ $employeeStats['staff'] }}

                    </p>

                </div>

            </div>

        @endif


        {{-- Employee Table --}}
        <div class="bg-white
                    dark:bg-gray-800
                    border border-gray-200
                    dark:border-gray-700
                    rounded-2xl
                    shadow-sm
                    overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead>

                        <tr class="bg-slate-100
                                   dark:bg-gray-700">

                            <th class="px-5 py-3
                                       text-left
                                       text-xs
                                       font-semibold
                                       uppercase
                                       text-gray-500">

                                Karyawan

                            </th>

                            @if($user->isAdmin())

                                <th class="px-5 py-3
                                           text-left
                                           text-xs
                                           font-semibold
                                           uppercase
                                           text-gray-500">

                                    Departemen

                                </th>

                            @endif

                            <th class="px-5 py-3
                                       text-left
                                       text-xs
                                       font-semibold
                                       uppercase
                                       text-gray-500">

                                Posisi

                            </th>

                            <th class="px-5 py-3
                                       text-left
                                       text-xs
                                       font-semibold
                                       uppercase
                                       text-gray-500">

                                Role

                            </th>

                            <th class="px-5 py-3
                                       text-left
                                       text-xs
                                       font-semibold
                                       uppercase
                                       text-gray-500">

                                Status

                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($employees as $item)

                            <tr class="border-t
                                       border-gray-100
                                       dark:border-gray-700">

                                <td class="px-5 py-4">

                                    <div class="font-semibold
                                                text-gray-800
                                                dark:text-white">

                                        {{ $item->name }}

                                    </div>

                                    <div class="mt-1
                                                text-xs
                                                text-gray-400">

                                        {{ $item->employee_code }}

                                    </div>

                                </td>


                                @if($user->isAdmin())

                                    <td class="px-5 py-4">

                                        {{ $item->department?->name
                                            ?? '-'
                                        }}

                                    </td>

                                @endif


                                <td class="px-5 py-4">

                                    {{ $item->position?->name
                                        ?? '-'
                                    }}

                                </td>


                                <td class="px-5 py-4">

                                    <span class="inline-flex
                                                 px-2.5 py-1
                                                 rounded-full
                                                 text-xs
                                                 font-medium
                                                 bg-blue-50
                                                 text-blue-700">

                                        {{ ucfirst(
                                            $item
                                                ->position
                                                ?->role
                                                ?->name
                                            ?? '-'
                                        ) }}

                                    </span>

                                </td>


                                <td class="px-5 py-4">

                                    @if($item->status === 'active')

                                        <span class="inline-flex
                                                     px-2.5 py-1
                                                     rounded-full
                                                     text-xs
                                                     font-medium
                                                     bg-green-100
                                                     text-green-700">

                                            Aktif

                                        </span>

                                    @else

                                        <span class="inline-flex
                                                     px-2.5 py-1
                                                     rounded-full
                                                     text-xs
                                                     font-medium
                                                     bg-gray-100
                                                     text-gray-600">

                                            Tidak Aktif

                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-5
                                           py-10
                                           text-center
                                           text-gray-400">

                                    Tidak ada data karyawan.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- ============================================================
        TASK SECTION
    ============================================================ --}}
    <div>

        <div class="flex
                    items-center
                    justify-between
                    mb-4">

            <div>

                <h2 class="text-lg
                           font-semibold
                           text-gray-900
                           dark:text-white">

                    Tugas

                </h2>

                <p class="mt-1
                          text-sm
                          text-gray-500">

                    @if($user->isAdmin())

                        Monitoring tugas seluruh departemen.

                    @elseif($user->isManagement())

                        Monitoring tugas pada departemen Anda.

                    @else

                        Monitoring tugas yang diberikan kepada Anda.

                    @endif

                </p>

            </div>


            <a
                href="{{ route('tasks.index') }}"
                class="text-sm
                       font-medium
                       text-primary-600
                       hover:text-primary-700">

                Monitoring Tugas

            </a>

        </div>


        {{-- Progress + Status --}}
        <div class="grid
                    grid-cols-1
                    xl:grid-cols-12
                    gap-5
                    mb-5">


            {{-- Progress --}}
            <div class="xl:col-span-7
                        p-5
                        bg-white
                        dark:bg-gray-800
                        border border-gray-200
                        dark:border-gray-700
                        rounded-2xl
                        shadow-sm">

                <div class="flex
                            items-center
                            justify-between">

                    <div>

                        <h3 class="font-semibold
                                   text-gray-800
                                   dark:text-white">

                            Progress Penyelesaian

                        </h3>

                        <p class="mt-1
                                  text-xs
                                  text-gray-400">

                            Persentase tugas yang telah selesai.

                        </p>

                    </div>


                    <span class="text-2xl
                                 font-bold
                                 text-primary-600">

                        {{ $taskProgress }}%

                    </span>

                </div>


                <div class="mt-5
                            h-3
                            bg-gray-100
                            dark:bg-gray-700
                            rounded-full
                            overflow-hidden">

                    <div
                        class="h-full
                               bg-primary-600
                               rounded-full"
                        style="width: {{ min(
                            $taskProgress,
                            100
                        ) }}%">
                    </div>

                </div>


                <div class="grid
                            grid-cols-3
                            gap-4
                            mt-6">

                    <div>

                        <p class="text-xs text-gray-400">
                            Belum Dimulai
                        </p>

                        <p class="mt-1
                                  text-xl
                                  font-bold
                                  text-gray-600">

                            {{ $taskStats['not_started'] }}

                        </p>

                    </div>


                    <div>

                        <p class="text-xs text-gray-400">
                            Dikerjakan
                        </p>

                        <p class="mt-1
                                  text-xl
                                  font-bold
                                  text-blue-600">

                            {{ $taskStats['in_progress'] }}

                        </p>

                    </div>


                    <div>

                        <p class="text-xs text-gray-400">
                            Selesai
                        </p>

                        <p class="mt-1
                                  text-xl
                                  font-bold
                                  text-green-600">

                            {{ $taskStats['completed'] }}

                        </p>

                    </div>

                </div>

            </div>


            {{-- Upcoming Deadline --}}
            <div class="xl:col-span-5
                        bg-white
                        dark:bg-gray-800
                        border border-gray-200
                        dark:border-gray-700
                        rounded-2xl
                        shadow-sm">

                <div class="px-5 py-4
                            border-b
                            border-gray-100
                            dark:border-gray-700">

                    <h3 class="font-semibold
                               text-gray-800
                               dark:text-white">

                        Deadline Terdekat

                    </h3>

                    <p class="mt-1
                              text-xs
                              text-gray-400">

                        Tugas yang perlu segera diselesaikan.

                    </p>

                </div>


                @forelse($upcomingTasks as $task)

                    @php

                        $daysRemaining =
                            (int) today()
                                ->diffInDays(
                                    $task->deadline
                                );

                        if ($task->deadline->isToday()) {

                            $deadlineLabel =
                                'Hari ini';

                        } elseif ($daysRemaining === 1) {

                            $deadlineLabel =
                                'Besok';

                        } else {

                            $deadlineLabel =
                                'H-' . $daysRemaining;
                        }

                    @endphp


                    <a
                        href="{{ route(
                            'tasks.show',
                            $task
                        ) }}"
                        class="flex
                               items-center
                               justify-between
                               gap-3
                               px-5 py-3.5
                               border-b
                               border-gray-100
                               dark:border-gray-700
                               last:border-0
                               hover:bg-gray-50">

                        <div class="min-w-0">

                            <p class="text-sm
                                      font-medium
                                      text-gray-800
                                      dark:text-white
                                      truncate">

                                {{ $task->title }}

                            </p>

                            <p class="mt-1
                                      text-xs
                                      text-gray-400">

                                {{ $task->task_code }}

                                @if(!$user->isStaff())

                                    ·
                                    {{ $task->pic?->name }}

                                @endif

                            </p>

                        </div>


                        <span class="shrink-0
                                     text-xs
                                     font-semibold
                                     text-orange-600">

                            {{ $deadlineLabel }}

                        </span>

                    </a>

                @empty

                    <div class="px-5
                                py-10
                                text-center
                                text-sm
                                text-gray-400">

                        Tidak ada deadline terdekat.

                    </div>

                @endforelse

            </div>

        </div>


        {{-- Recent Tasks --}}
        <div class="bg-white
                    dark:bg-gray-800
                    border border-gray-200
                    dark:border-gray-700
                    rounded-2xl
                    shadow-sm
                    overflow-hidden">


            <div class="px-5 py-4
                        border-b
                        border-gray-100
                        dark:border-gray-700">

                <h3 class="font-semibold
                           text-gray-800
                           dark:text-white">

                    Tugas Terbaru

                </h3>

                <p class="mt-1
                          text-xs
                          text-gray-400">

                    Daftar tugas terbaru yang dapat Anda akses.

                </p>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead>

                        <tr class="bg-slate-100
                                   dark:bg-gray-700">

                            <th class="px-5 py-3
                                       text-left
                                       text-xs
                                       font-semibold
                                       uppercase
                                       text-gray-500">

                                Kode

                            </th>

                            <th class="px-5 py-3
                                       text-left
                                       text-xs
                                       font-semibold
                                       uppercase
                                       text-gray-500">

                                Judul

                            </th>

                            @if(!$user->isStaff())

                                <th class="px-5 py-3
                                           text-left
                                           text-xs
                                           font-semibold
                                           uppercase
                                           text-gray-500">

                                    PIC

                                </th>

                            @endif

                            <th class="px-5 py-3
                                       text-left
                                       text-xs
                                       font-semibold
                                       uppercase
                                       text-gray-500">

                                Prioritas

                            </th>

                            <th class="px-5 py-3
                                       text-left
                                       text-xs
                                       font-semibold
                                       uppercase
                                       text-gray-500">

                                Status

                            </th>

                            <th class="px-5 py-3
                                       text-left
                                       text-xs
                                       font-semibold
                                       uppercase
                                       text-gray-500">

                                Deadline

                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($recentTasks as $task)

                            @php

                                $priorityClass =
                                    $priorityColors[
                                        $task->priority?->color
                                    ]
                                    ?? 'bg-gray-100 text-gray-700';

                                $statusClass =
                                    $statusColors[
                                        $task->status?->color
                                    ]
                                    ?? 'bg-gray-100 text-gray-700';

                            @endphp


                            <tr class="border-t
                                       border-gray-100
                                       dark:border-gray-700
                                       hover:bg-gray-50">

                                <td class="px-5 py-4
                                           font-semibold
                                           text-primary-600">

                                    <a href="{{ route(
                                        'tasks.show',
                                        $task
                                    ) }}">

                                        {{ $task->task_code }}

                                    </a>

                                </td>


                                <td class="px-5 py-4">

                                    <p class="font-medium
                                              text-gray-800
                                              dark:text-white">

                                        {{ $task->title }}

                                    </p>

                                </td>


                                @if(!$user->isStaff())

                                    <td class="px-5 py-4">

                                        {{ $task->pic?->name
                                            ?? '-'
                                        }}

                                    </td>

                                @endif


                                <td class="px-5 py-4">

                                    <span class="inline-flex
                                                 px-2.5 py-1
                                                 text-xs
                                                 font-medium
                                                 rounded-full
                                                 {{ $priorityClass }}">

                                        {{ $task->priority?->name
                                            ?? '-'
                                        }}

                                    </span>

                                </td>


                                <td class="px-5 py-4">

                                    <span class="inline-flex
                                                 px-2.5 py-1
                                                 text-xs
                                                 font-medium
                                                 rounded-full
                                                 {{ $statusClass }}">

                                        {{ $task->status?->name
                                            ?? '-'
                                        }}

                                    </span>

                                </td>


                                <td class="px-5 py-4
                                           text-gray-600">

                                    {{ $task->deadline
                                        ->translatedFormat(
                                            'd M Y'
                                        ) }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="{{ $user->isStaff() ? 5 : 6 }}"
                                    class="px-5
                                           py-10
                                           text-center
                                           text-gray-400">

                                    Belum ada data tugas.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</main>

@endsection