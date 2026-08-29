@extends('layouts.app')

@section('title', 'Detail Tugas')

@section('content')

<div class="px-4 pt-6 pb-10 max-w-7xl mx-auto w-full min-w-0">

    @php

        /*
        |--------------------------------------------------------------------------
        | Status Color
        |--------------------------------------------------------------------------
        */

        $statusColors = [
            'gray' => 'bg-gray-100 text-gray-700 border-gray-200',
            'blue' => 'bg-blue-100 text-blue-700 border-blue-200',
            'green' => 'bg-green-100 text-green-700 border-green-200',
            'yellow' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
            'orange' => 'bg-orange-100 text-orange-700 border-orange-200',
            'red' => 'bg-red-100 text-red-700 border-red-200',
            'purple' => 'bg-purple-100 text-purple-700 border-purple-200',
        ];

        $statusClass =
            $statusColors[$task->status?->color]
            ?? 'bg-gray-100 text-gray-700 border-gray-200';


        /*
        |--------------------------------------------------------------------------
        | Priority Color
        |--------------------------------------------------------------------------
        */

        $priorityColors = [
            'gray' => 'bg-gray-100 text-gray-700 border-gray-200',
            'blue' => 'bg-blue-100 text-blue-700 border-blue-200',
            'green' => 'bg-green-100 text-green-700 border-green-200',
            'yellow' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
            'orange' => 'bg-orange-100 text-orange-700 border-orange-200',
            'red' => 'bg-red-100 text-red-700 border-red-200',
            'purple' => 'bg-purple-100 text-purple-700 border-purple-200',
        ];

        $priorityClass =
            $priorityColors[$task->priority?->color]
            ?? 'bg-gray-100 text-gray-700 border-gray-200';


        /*
        |--------------------------------------------------------------------------
        | Deadline
        |--------------------------------------------------------------------------
        */

        $deadline = $task->deadline
            ->copy()
            ->startOfDay();

        $today = today();

        if ($task->status?->code === 'completed') {

            $deadlineLabel = 'Selesai';
            $deadlineLabelClass = 'text-green-600';

        } elseif ($deadline->isToday()) {

            $deadlineLabel = 'Jatuh tempo hari ini';
            $deadlineLabelClass = 'text-orange-600';

        } elseif ($deadline->lt($today)) {

            $daysLate = (int) $deadline->diffInDays($today);

            $deadlineLabel =
                'Terlambat ' . $daysLate . ' hari';

            $deadlineLabelClass = 'text-red-600';

        } else {

            $remainingDays =
                (int) $today->diffInDays($deadline);

            $deadlineLabel =
                'H-' . $remainingDays;

            $deadlineLabelClass =
                $remainingDays <= 3
                    ? 'text-orange-600'
                    : 'text-gray-500';
        }

    @endphp


    {{-- =========================
        HEADER
    ========================== --}}

    <div class="flex flex-col md:flex-row
                md:items-center
                md:justify-between
                gap-4 mb-5">

        <div>

            <div class="flex items-center gap-3">

                <a href="{{ route('tasks.index') }}"
                   class="inline-flex items-center justify-center
                          w-9 h-9
                          rounded-lg
                          border border-gray-200
                          text-gray-500
                          hover:bg-gray-50">

                    <svg class="w-4 h-4"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M15 19l-7-7 7-7"/>

                    </svg>

                </a>


                <div>

                    <div class="flex items-center gap-2 mb-1">

                        <h1 class="text-2xl
                                   font-semibold
                                   text-gray-900
                                   dark:text-white">

                            Detail Tugas

                        </h1>


                        <span class="text-xs font-semibold
                                     px-2.5 py-1
                                     rounded-md
                                     bg-primary-50
                                     text-primary-600">

                            {{ $task->task_code }}

                        </span>

                    </div>


                    <p class="text-sm text-gray-500">
                        Informasi lengkap dan riwayat pekerjaan.
                    </p>

                </div>

            </div>

        </div>


        @can('update', $task)
        <a href="{{ route('tasks.edit', $task) }}"
           class="inline-flex items-center justify-center
                  gap-2
                  px-4 py-2.5
                  bg-primary-600
                  hover:bg-primary-700
                  text-white
                  text-sm font-medium
                  rounded-lg">

            Edit Tugas

        </a>
        @endcan

    </div>


    {{-- =========================
        STATUS & PRIORITY
    ========================== --}}

    <div class="flex flex-wrap items-center gap-3 mb-5">

        <span class="inline-flex items-center
                     gap-1.5
                     px-4 py-1.5
                     rounded-full
                     text-sm font-medium
                     border
                     {{ $statusClass }}">

            <span class="w-2 h-2
                         rounded-full
                         bg-current">
            </span>

            {{ $task->status?->name ?? '-' }}

        </span>


        <span class="inline-flex items-center
                     gap-1.5
                     px-4 py-1.5
                     rounded-full
                     text-sm font-medium
                     border
                     {{ $priorityClass }}">

            <svg class="w-4 h-4"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <circle cx="12"
                        cy="12"
                        r="9"
                        stroke-width="1.5"/>

                <path stroke-linecap="round"
                      stroke-width="1.5"
                      d="M12 8v4m0 4h.01"/>

            </svg>

            {{ $task->priority?->name ?? '-' }}

        </span>

    </div>


    {{-- =========================
        SUMMARY
    ========================== --}}

    <div class="grid
                grid-cols-1
                md:grid-cols-3
                gap-4
                mb-5">


        {{-- PIC --}}
        <div class="bg-white
                    rounded-xl
                    border border-gray-200
                    px-5 py-4">

            <p class="text-xs
                      text-gray-400
                      mb-1
                      flex items-center
                      gap-1.5">

                <svg class="w-3.5 h-3.5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.5"
                          d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/>

                </svg>

                PIC

            </p>


            <p class="font-semibold
                      text-gray-800
                      text-sm">

                {{ $task->pic?->name ?? '-' }}

            </p>


            @if($task->pic)

                <p class="text-xs
                          text-gray-400
                          mt-1">

                    {{ $task->pic->employee_code }}

                </p>

            @endif

        </div>


        {{-- Deadline --}}
        <div class="bg-white
                    rounded-xl
                    border border-gray-200
                    px-5 py-4">

            <p class="text-xs
                      text-gray-400
                      mb-1
                      flex items-center
                      gap-1.5">

                <svg class="w-3.5 h-3.5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <rect x="3"
                          y="4"
                          width="18"
                          height="18"
                          rx="2"
                          stroke-width="1.5"/>

                    <path d="M16 2v4M8 2v4M3 10h18"
                          stroke-width="1.5"/>

                </svg>

                Deadline

            </p>


            <p class="font-semibold
                      text-gray-800
                      text-sm">

                {{ $task->deadline->translatedFormat('d M Y') }}

            </p>


            <p class="text-xs
                      font-semibold
                      mt-1
                      {{ $deadlineLabelClass }}">

                {{ $deadlineLabel }}

            </p>

        </div>


        {{-- Dibuat --}}
        <div class="bg-white
                    rounded-xl
                    border border-gray-200
                    px-5 py-4">

            <p class="text-xs
                      text-gray-400
                      mb-1">

                Dibuat

            </p>


            <p class="font-semibold
                      text-gray-800
                      text-sm">

                {{ $task->created_at->translatedFormat('d M Y') }}

            </p>


            <p class="text-xs
                      text-gray-400
                      mt-1">

                oleh
                {{ $task->creator?->employee?->name
                    ?? $task->creator?->email
                    ?? '-' }}

            </p>

        </div>

    </div>


    {{-- =========================
        MAIN + SIDEBAR
    ========================== --}}

    <div class="flex
                flex-col
                lg:flex-row
                gap-5
                items-start">


        {{-- =========================
            LEFT
        ========================== --}}

        <div class="flex-1
                    min-w-0
                    flex
                    flex-col
                    gap-5">


            {{-- Detail --}}
            <div class="bg-white
                        rounded-xl
                        border border-gray-200
                        p-6">


                <h2 class="text-base
                           font-semibold
                           text-gray-800
                           flex items-center
                           gap-2
                           mb-5">

                    <svg class="w-4 h-4
                                text-primary-500"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.5"
                              d="M4 6h16M4 12h16M4 18h10"/>

                    </svg>

                    Detail Tugas

                </h2>


                {{-- Judul --}}
                <div class="border
                            border-gray-200
                            rounded-lg
                            p-4
                            mb-4">

                    <p class="text-xs
                              text-gray-400
                              mb-2">

                        Judul Tugas

                    </p>


                    <p class="text-sm
                              font-medium
                              text-gray-800">

                        {{ $task->title }}

                    </p>

                </div>


                {{-- Deskripsi --}}
                <div class="border
                            border-gray-200
                            rounded-lg
                            p-4
                            min-h-[120px]">

                    <p class="text-xs
                              text-gray-400
                              mb-2">

                        Deskripsi

                    </p>


                    <p class="text-sm
                              text-gray-700
                              whitespace-pre-line
                              leading-relaxed">

                        {{ $task->description ?: '-' }}

                    </p>

                </div>

            </div>


            {{-- =========================
								RIWAYAT TUGAS
						========================== --}}
						<div class="bg-white
												rounded-xl
												border border-gray-200
												p-6">

								<h2 class="text-base
													font-semibold
													text-gray-800
													flex items-center
													gap-2
													mb-5">

										<svg class="w-4 h-4 text-primary-500"
												fill="none"
												stroke="currentColor"
												viewBox="0 0 24 24">

												<circle cx="12"
																cy="12"
																r="9"
																stroke-width="1.5"/>

												<path stroke-linecap="round"
															stroke-width="1.5"
															d="M12 7v5l3 2"/>

										</svg>

										Riwayat Status

								</h2>


								<div class="relative">

										<div class="absolute
																left-3
																top-0
																bottom-0
																w-px
																bg-gray-200">
										</div>


										<div class="space-y-6">

												@forelse($task->statusHistories->sortByDesc('created_at') as $history)

														@php
																$historyStatusColors = [
																		'gray' => 'bg-gray-500',
																		'blue' => 'bg-blue-500',
																		'green' => 'bg-green-500',
																		'yellow' => 'bg-yellow-500',
																		'orange' => 'bg-orange-500',
																		'red' => 'bg-red-500',
																		'purple' => 'bg-purple-500',
																];

																$dotClass =
																		$historyStatusColors[$history->status?->color]
																		?? 'bg-gray-500';

																$changedBy =
																		$history->changedBy?->employee?->name
																		?? $history->changedBy?->email
																		?? '-';
														@endphp

														<div class="relative flex gap-4">

																{{-- Dot --}}
																<div class="relative
																						z-10
																						w-6 h-6
																						shrink-0
																						rounded-full
																						{{ $dotClass }}
																						flex
																						items-center
																						justify-center">

																		<svg class="w-3 h-3 text-white"
																				fill="none"
																				stroke="currentColor"
																				viewBox="0 0 24 24">

																				<path
																						stroke-linecap="round"
																						stroke-linejoin="round"
																						stroke-width="2.5"
																						d="M5 13l4 4L19 7"
																				/>

																		</svg>

																</div>

																{{-- Content --}}
																<div class="flex-1">

																		<div class="flex
																								justify-between
																								items-start
																								gap-3">

																				<div>

																						<h4 class="text-sm
																											font-semibold
																											text-gray-800">

																								Status:
																								{{ $history->status?->name ?? '-' }}

																						</h4>

																				</div>

																				<span class="text-xs
																										text-gray-400
																										whitespace-nowrap">

																						{{ $history->created_at->diffForHumans() }}

																				</span>

																		</div>

																		@if($history->note)

																				<div class="mt-2
																										px-3 py-2
																										bg-gray-50
																										border border-gray-100
																										rounded-lg">

																						<p class="text-sm
																											text-gray-600
																											whitespace-pre-line">

																								{{ $history->note }}

																						</p>

																				</div>

																		@endif

																		<div class="mt-2
																								flex
																								flex-wrap
																								items-center
																								gap-x-3
																								gap-y-1
																								text-xs
																								text-gray-400">

																				<span>
																						oleh {{ $changedBy }}
																				</span>

																				<span>
																						•
																				</span>

																				<span>
																						{{ $history->created_at->translatedFormat('d M Y H:i') }}
																				</span>

																		</div>

																</div>

														</div>

												@empty

														<div class="py-8
																				text-center
																				text-sm
																				text-gray-400">

																Belum ada riwayat status.

														</div>

												@endforelse

										</div>

								</div>

						</div>

        </div>


        {{-- =========================
            SIDEBAR
        ========================== --}}

        <div class="w-full
                    lg:w-80
                    shrink-0">


            <div class="bg-white
                        rounded-xl
                        border border-gray-200
                        p-6
                        sticky
                        top-6">


                <h2 class="text-base
                           font-semibold
                           text-gray-800
                           flex items-center
                           gap-2
                           mb-5">

                    <svg class="w-4 h-4
                                text-primary-500"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.5"
                              d="M12 6v6l4 2M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>

                    </svg>

                    Actions

                </h2>


                {{-- =========================
                    PINDAH PIC
                ========================== --}}
                @can('assignPic', $task)
                <div class="border
                            border-gray-200
                            rounded-lg
                            p-4
                            mb-4">


                    <h3 class="text-sm
                               font-semibold
                               text-gray-700
                               flex
                               items-center
                               gap-1.5
                               mb-3">

                        <svg class="w-4 h-4
                                    text-primary-500"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.5"
                                  d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8 0 2 2 4-4"/>

                        </svg>

                        Pindahkan PIC

                    </h3>


                    <form action="{{ route('tasks.assign-pic', $task) }}"
                          method="POST">

                        @csrf
                        @method('PATCH')


                        <select
                            name="pic_id"
                            class="w-full
                                   rounded-lg
                                   border border-gray-200
                                   px-3 py-2.5
                                   text-sm
                                   text-gray-700
                                   mb-3
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-primary-500
                                   bg-white
                                   cursor-pointer">

                            @foreach($employees as $employee)

                                <option
                                    value="{{ $employee->id }}"
                                    @selected(
                                        $task->pic_id == $employee->id
                                    )>

                                    {{ $employee->employee_code }}
                                    -
                                    {{ $employee->name }}

                                </option>

                            @endforeach

                        </select>


                        <button
                            type="submit"
                            class="w-full
                                   inline-flex
                                   items-center
                                   justify-center
                                   gap-2
                                   bg-primary-600
                                   hover:bg-primary-700
                                   text-white
                                   text-sm
                                   font-medium
                                   py-2.5
                                   rounded-lg
                                   transition-colors
                                   cursor-pointer">

                            Update PIC

                        </button>

                    </form>

                </div>
                @endcan

                {{-- =========================
                    UPDATE STATUS
                ========================== --}}
                @can('updateStatus', $task)
                <div class="border
                            border-gray-200
                            rounded-lg
                            p-4">


                    <h3 class="text-sm
                               font-semibold
                               text-gray-700
                               flex
                               items-center
                               gap-1.5
                               mb-3">

                        <svg class="w-4 h-4
                                    text-primary-500"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.5"
                                  d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>

                        </svg>

                        Update Status

                    </h3>


                    <form action="{{ route('tasks.update-status', $task) }}"
                          method="POST">

                        @csrf
                        @method('PATCH')


                        <select
                            name="task_status_id"
                            class="w-full
                                   rounded-lg
                                   border border-gray-200
                                   px-3 py-2.5
                                   text-sm
                                   text-gray-700
                                   mb-3
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-primary-500
                                   bg-white
                                   cursor-pointer">

                            @foreach($statuses as $status)

                                <option
                                    value="{{ $status->id }}"
                                    @selected(
                                        $task->task_status_id == $status->id
                                    )>

                                    {{ $status->name }}

                                </option>

                            @endforeach

                        </select>


                        <textarea
                            name="note"
                            rows="3"
                            maxlength="1000"
                            placeholder="Catatan perubahan status..."
                            class="w-full
                                   rounded-lg
                                   border border-gray-200
                                   px-3 py-2.5
                                   text-sm
                                   text-gray-700
                                   mb-3
                                   resize-none
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-primary-500"></textarea>


                        <button
                            type="submit"
                            class="w-full
                                   inline-flex
                                   items-center
                                   justify-center
                                   gap-2
                                   bg-primary-600
                                   hover:bg-primary-700
                                   text-white
                                   text-sm
                                   font-medium
                                   py-2.5
                                   rounded-lg
                                   transition-colors
                                   cursor-pointer">

                            Update Status

                        </button>

                    </form>

                </div>
                @endcan

            </div>

        </div>

    </div>

</div>

@endsection