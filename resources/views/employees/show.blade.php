@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')

<div class="px-4 pt-6 pb-10 max-w-7xl mx-auto w-full min-w-0">

    {{-- ================================
        HEADER
    ================================= --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

        <div>
            <div class="flex items-center gap-2 text-sm text-gray-400 mb-2">

                <a href="{{ route('employees.index') }}"
                   class="hover:text-primary-600 transition">
                    Daftar Karyawan
                </a>

                <svg class="w-4 h-4"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 5l7 7-7 7"/>
                </svg>

                <span>Detail</span>

            </div>

            <h1 class="text-2xl font-bold text-gray-900">
                {{ $employee->name }}
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                {{ $employee->employee_code }}
            </p>
        </div>


        <div class="flex items-center gap-3">

            {{-- STATUS --}}
            @if($employee->status === 'active')

                <span class="inline-flex items-center gap-2 px-4 py-2
                             rounded-xl text-sm font-medium
                             bg-green-50 text-green-600
                             border border-green-100">

                    <span class="w-2 h-2 rounded-full bg-green-500"></span>

                    Aktif
                </span>

            @else

                <span class="inline-flex items-center gap-2 px-4 py-2
                             rounded-xl text-sm font-medium
                             bg-gray-100 text-gray-600
                             border border-gray-200">

                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>

                    Non Aktif
                </span>

            @endif


            {{-- BACK --}}
            <a href="{{ route('employees.index') }}"
               class="inline-flex items-center gap-2 h-10 px-4
                      rounded-xl border border-gray-200
                      bg-white text-sm font-medium text-gray-700
                      hover:bg-gray-50 transition">

                <svg class="w-4 h-4"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 19l-7-7 7-7"/>

                </svg>

                Kembali
            </a>

        </div>

    </div>



    {{-- ================================
        SUMMARY
    ================================= --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">

        {{-- Department --}}
        <div class="bg-white rounded-xl border border-gray-200 px-5 py-4">

            <p class="text-xs text-gray-400 mb-1">
                Departemen
            </p>

            <p class="font-semibold text-gray-800 text-sm">
                {{ $employee->department?->name ?? '-' }}
            </p>

        </div>


        {{-- Position --}}
        <div class="bg-white rounded-xl border border-gray-200 px-5 py-4">

            <p class="text-xs text-gray-400 mb-1">
                Posisi
            </p>

            <p class="font-semibold text-gray-800 text-sm">
                {{ $employee->position?->name ?? '-' }}
            </p>

        </div>


        {{-- Activity --}}
        <div class="bg-white rounded-xl border border-gray-200 px-5 py-4">

            <p class="text-xs text-gray-400 mb-1">
                Total Aktivitas
            </p>

            <p class="font-semibold text-gray-800 text-sm">
                {{ $activityLogs->count() }}
            </p>

        </div>

    </div>



    {{-- ================================
        MAIN CONTENT
    ================================= --}}
    <div class="flex flex-col lg:flex-row gap-5 items-start">


        {{-- ============================
            LEFT CONTENT
        ============================= --}}
        <div class="flex-1 min-w-0 flex flex-col gap-5">


            {{-- ========================
                DETAIL KARYAWAN
            ========================= --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">

                <h2 class="text-base font-semibold text-gray-800
                           flex items-center gap-2 mb-5">

                    <svg class="w-5 h-5 text-primary-600"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5.121 17.804A9 9 0 1118.879 17.804
                                 M15 11a3 3 0 11-6 0
                                 3 3 0 016 0z"/>

                    </svg>

                    Informasi Karyawan
                </h2>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                    {{-- Employee Code --}}
                    <div class="border border-gray-200 rounded-lg p-4">

                        <p class="text-xs text-gray-400 mb-1">
                            Kode Karyawan
                        </p>

                        <p class="text-sm font-semibold text-gray-800">
                            {{ $employee->employee_code }}
                        </p>

                    </div>


                    {{-- Name --}}
                    <div class="border border-gray-200 rounded-lg p-4">

                        <p class="text-xs text-gray-400 mb-1">
                            Nama Karyawan
                        </p>

                        <p class="text-sm font-semibold text-gray-800">
                            {{ $employee->name }}
                        </p>

                    </div>


                    {{-- Email --}}
                    <div class="border border-gray-200 rounded-lg p-4">

                        <p class="text-xs text-gray-400 mb-1">
                            Email
                        </p>

                        <p class="text-sm font-semibold text-gray-800">
                            {{ $employee->email ?? '-' }}
                        </p>

                    </div>


                    {{-- Status --}}
                    <div class="border border-gray-200 rounded-lg p-4">

                        <p class="text-xs text-gray-400 mb-1">
                            Status
                        </p>

                        @if($employee->status === 'active')

                            <span class="inline-flex items-center gap-1.5
                                         text-sm font-medium text-green-600">

                                <span class="w-2 h-2 rounded-full bg-green-500"></span>

                                Aktif

                            </span>

                        @else

                            <span class="inline-flex items-center gap-1.5
                                         text-sm font-medium text-gray-500">

                                <span class="w-2 h-2 rounded-full bg-gray-400"></span>

                                Non Aktif

                            </span>

                        @endif

                    </div>


                    {{-- Department --}}
                    <div class="border border-gray-200 rounded-lg p-4">

                        <p class="text-xs text-gray-400 mb-1">
                            Departemen
                        </p>

                        <p class="text-sm font-semibold text-gray-800">
                            {{ $employee->department?->name ?? '-' }}
                        </p>

                    </div>


                    {{-- Position --}}
                    <div class="border border-gray-200 rounded-lg p-4">

                        <p class="text-xs text-gray-400 mb-1">
                            Posisi
                        </p>

                        <p class="text-sm font-semibold text-gray-800">
                            {{ $employee->position?->name ?? '-' }}
                        </p>

                    </div>

                </div>

            </div>



            {{-- ========================
                HISTORY
            ========================= --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">

                <div class="flex items-center justify-between mb-6">

                    <h2 class="text-base font-semibold text-gray-800
                               flex items-center gap-2">

                        <svg class="w-5 h-5 text-primary-600"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <circle cx="12"
                                    cy="12"
                                    r="9"
                                    stroke-width="2"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 7v5l3 2"/>

                        </svg>

                        History Perubahan

                    </h2>


                    <span class="text-xs text-gray-400">
                        {{ $activityLogs->count() }} aktivitas
                    </span>

                </div>


                <div class="relative">

                    {{-- Timeline Line --}}
                    @if($activityLogs->count())
                        <div class="absolute left-3 top-1 bottom-1
                                    w-px bg-gray-200">
                        </div>
                    @endif


                    <div class="space-y-6">

                        @forelse($activityLogs as $log)

                            <div class="relative flex gap-4">


                                {{-- Timeline Icon --}}
                                <div class="relative z-10 flex-shrink-0">

                                    @if($log->action === 'CREATE')

                                        <div class="w-6 h-6 rounded-full
                                                    bg-green-500
                                                    flex items-center justify-center">

                                            <svg class="w-3 h-3 text-white"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="3"
                                                      d="M12 6v12M6 12h12"/>

                                            </svg>

                                        </div>

                                    @elseif($log->action === 'DELETE')

                                        <div class="w-6 h-6 rounded-full
                                                    bg-red-500
                                                    flex items-center justify-center">

                                            <svg class="w-3 h-3 text-white"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="3"
                                                      d="M6 12h12"/>

                                            </svg>

                                        </div>

                                    @else

                                        <div class="w-6 h-6 rounded-full
                                                    bg-blue-500
                                                    flex items-center justify-center">

                                            <svg class="w-3 h-3 text-white"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2.5"
                                                      d="M11 4H4a2 2 0 00-2 2v14
                                                         a2 2 0 002 2h14
                                                         a2 2 0 002-2v-7"/>

                                            </svg>

                                        </div>

                                    @endif

                                </div>


                                {{-- Timeline Content --}}
                                <div class="flex-1 min-w-0">

                                    <div class="flex flex-col sm:flex-row
                                                sm:items-center
                                                sm:justify-between gap-1">

                                        <div class="flex items-center gap-2">

                                            <h4 class="text-sm font-semibold
                                                       text-gray-800">

                                                {{ $log->action }}

                                            </h4>


                                            @if($log->action === 'CREATE')

                                                <span class="px-2 py-0.5 rounded-full
                                                             bg-green-50 text-green-600
                                                             text-[11px] font-medium">
                                                    Data Dibuat
                                                </span>

                                            @elseif($log->action === 'UPDATE')

                                                <span class="px-2 py-0.5 rounded-full
                                                             bg-blue-50 text-blue-600
                                                             text-[11px] font-medium">
                                                    Data Diubah
                                                </span>

                                            @elseif($log->action === 'DELETE')

                                                <span class="px-2 py-0.5 rounded-full
                                                             bg-red-50 text-red-600
                                                             text-[11px] font-medium">
                                                    Data Dihapus
                                                </span>

                                            @endif

                                        </div>


                                        <span class="text-xs text-gray-400">
                                            {{ $log->created_at->format('d M Y H:i') }}
                                        </span>

                                    </div>


                                    {{-- User --}}
                                    <p class="text-xs text-gray-400 mt-1">
                                        oleh {{ $log->user?->name ?? 'System' }}
                                    </p>



                                    {{-- ============================
                                        UPDATE CHANGES
                                    ============================= --}}
                                    @if(
                                        $log->action === 'UPDATE' &&
                                        $log->old_values &&
                                        $log->new_values
                                    )

                                        <div class="mt-3
                                                    bg-gray-50
                                                    border border-gray-100
                                                    rounded-lg
                                                    divide-y divide-gray-100">

                                            @foreach($log->new_values as $field => $newValue)

                                                @php
																										$oldValue = $log->old_values[$field] ?? null;
																										$displayOldValue = $oldValue;
																										$displayNewValue = $newValue;

																										if ($field === 'department_id') {
																												$displayOldValue = $departmentNames[$oldValue] ?? '-';
																												$displayNewValue = $departmentNames[$newValue] ?? '-';
																										}

																										if ($field === 'position_id') {
																												$displayOldValue = $positionNames[$oldValue] ?? '-';
																												$displayNewValue = $positionNames[$newValue] ?? '-';
																										}

																										$fieldLabels = [
																												'name' => 'Nama',
																												'email' => 'Email',
																												'department_id' => 'Departemen',
																												'position_id' => 'Posisi',
																												'status' => 'Status',
																										];

																										$fieldLabel = $fieldLabels[$field]
																												?? ucwords(str_replace('_', ' ', $field));
																								@endphp


                                                @if(
                                                    $oldValue != $newValue &&
                                                    !in_array(
                                                        $field,
                                                        [
                                                            'updated_at',
                                                            'created_at',
                                                            'deleted_at',
                                                            'id'
                                                        ]
                                                    )
                                                )

                                                    <div class="px-4 py-3">

                                                        <p class="text-xs
                                                                  font-medium
                                                                  text-gray-500
                                                                  mb-2">

                                                            {{ $fieldLabel }}

                                                        </p>


                                                        <div class="flex
                                                                    flex-wrap
                                                                    items-center
                                                                    gap-2
                                                                    text-sm">

                                                            <span class="px-2.5 py-1
                                                                         bg-red-50
                                                                         text-red-600
                                                                         rounded-md">

                                                                {{ $displayOldValue ?? '-' }}

                                                            </span>


                                                            <svg class="w-4 h-4
                                                                        text-gray-400"
                                                                 fill="none"
                                                                 stroke="currentColor"
                                                                 viewBox="0 0 24 24">

                                                                <path stroke-linecap="round"
                                                                      stroke-linejoin="round"
                                                                      stroke-width="2"
                                                                      d="M9 5l7 7-7 7"/>

                                                            </svg>


                                                            <span class="px-2.5 py-1
                                                                         bg-green-50
                                                                         text-green-600
                                                                         rounded-md">

                                                                {{ $displayNewValue ?? '-' }}

                                                            </span>

                                                        </div>

                                                    </div>

                                                @endif

                                            @endforeach

                                        </div>

                                    @elseif($log->action === 'CREATE')

                                        <p class="text-sm text-gray-600 mt-2">
                                            Data karyawan dibuat.
                                        </p>

                                    @elseif($log->action === 'DELETE')

                                        <p class="text-sm text-gray-600 mt-2">
                                            Data karyawan dihapus.
                                        </p>

                                    @endif

                                </div>

                            </div>

                        @empty

                            <div class="text-center py-10">

                                <svg class="w-10 h-10 mx-auto text-gray-300 mb-3"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <circle cx="12"
                                            cy="12"
                                            r="9"
                                            stroke-width="1.5"/>

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="1.5"
                                          d="M12 7v5l3 2"/>

                                </svg>

                                <p class="text-sm text-gray-400">
                                    Belum ada history perubahan.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>



        {{-- ============================
            RIGHT SIDEBAR
        ============================= --}}
        <div class="w-full lg:w-72 shrink-0">

            <div class="bg-white rounded-xl border border-gray-200 p-6">

                <h2 class="text-base font-semibold text-gray-800
                           flex items-center gap-2 mb-5">

                    <svg class="w-5 h-5 text-primary-600"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <circle cx="12"
                                cy="12"
                                r="9"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8v4M12 16h.01"/>

                    </svg>

                    Informasi Sistem

                </h2>


                <div class="space-y-5">


                    {{-- Created --}}
                    <div>

                        <p class="text-xs text-gray-400 mb-1">
                            Dibuat
                        </p>

                        <p class="text-sm font-medium text-gray-800">
                            {{ $employee->created_at->format('d M Y') }}
                        </p>

                        <p class="text-xs text-gray-400">
                            {{ $employee->created_at->format('H:i') }}
                        </p>

                    </div>


                    <div class="border-t border-gray-100"></div>


                    {{-- Updated --}}
                    <div>

                        <p class="text-xs text-gray-400 mb-1">
                            Terakhir Diubah
                        </p>

                        <p class="text-sm font-medium text-gray-800">
                            {{ $employee->updated_at->format('d M Y') }}
                        </p>

                        <p class="text-xs text-gray-400">
                            {{ $employee->updated_at->format('H:i') }}
                        </p>

                    </div>


                    <div class="border-t border-gray-100"></div>


                    {{-- Activity --}}
                    <div>

                        <p class="text-xs text-gray-400 mb-1">
                            Total Aktivitas
                        </p>

                        <p class="text-sm font-medium text-gray-800">
                            {{ $activityLogs->count() }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection