@extends('layouts.app')

@section('title', 'Edit Tugas')

@section('content')

<div class="px-4 pt-6 pb-10 max-w-7xl mx-auto w-full min-w-0">

    {{-- =========================
        HEADER
    ========================== --}}
    <div class="mb-6">

        <div class="flex flex-wrap items-center justify-between gap-4">

            <div>

                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Edit Tugas
                </h1>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Perbarui informasi dan penugasan pekerjaan.
                </p>

            </div>


            <span class="inline-flex items-center
                         px-3 py-1.5
                         rounded-lg
                         bg-blue-50
                         text-blue-700
                         text-sm font-semibold">

                {{ $task->task_code }}

            </span>

        </div>

    </div>


    <form action="{{ route('tasks.update', $task) }}"
          method="POST">

        @csrf
        @method('PUT')


        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

            {{-- =========================
                LEFT CONTENT
            ========================== --}}
            <div class="xl:col-span-9 space-y-5">

                {{-- =========================
                    INFORMASI TUGAS
                ========================== --}}
                <div class="bg-white
                            dark:bg-gray-800
                            border border-gray-200
                            dark:border-gray-700
                            rounded-2xl
                            shadow-xs">

                    {{-- Header Card --}}
                    <div class="px-6 py-5
                                border-b border-gray-200
                                dark:border-gray-700">

                        <div class="flex items-center gap-3">

                            <div class="flex items-center
                                        justify-center
                                        w-10 h-10
                                        rounded-xl
                                        bg-blue-50
                                        dark:bg-blue-900/20">

                                <svg class="w-5 h-5
                                            text-blue-600
                                            dark:text-blue-400"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.414-9.414a2 2 0 1 1 2.828 2.828L11.828 15H9v-2.828l8.586-8.586Z"/>

                                </svg>

                            </div>

                            <div>

                                <h2 class="text-sm font-semibold
                                           text-gray-900
                                           dark:text-white">

                                    Informasi Tugas

                                </h2>

                                <p class="text-xs text-gray-400">
                                    Perbarui detail pekerjaan yang dipilih.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Form --}}
                    <div class="p-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                            {{-- PRIORITY --}}
                            <div>

                                <label for="task_priority_id"
                                       class="block mb-1.5
                                              text-sm font-medium
                                              text-gray-700
                                              dark:text-gray-300">

                                    Prioritas
                                    <span class="text-red-500">*</span>

                                </label>

                                <select name="task_priority_id"
                                        id="task_priority_id"
                                        class="block w-full
                                               px-3 py-2.5
                                               text-sm
                                               text-gray-900
                                               bg-gray-50
                                               border
                                               border-gray-300
                                               rounded-xl
                                               focus:ring-2
                                               focus:ring-blue-500
                                               focus:border-blue-500
                                               dark:bg-gray-700
                                               dark:border-gray-600
                                               dark:text-white
                                               transition
                                               @error('task_priority_id') border-red-500 @enderror">

                                    <option value="">
                                        Pilih Prioritas
                                    </option>

                                    @foreach($priorities as $priority)

                                        <option value="{{ $priority->id }}"
                                            @selected(
                                                old(
                                                    'task_priority_id',
                                                    $task->task_priority_id
                                                ) == $priority->id
                                            )>

                                            {{ $priority->name }}

                                        </option>

                                    @endforeach

                                </select>

                                @error('task_priority_id')

                                    <p class="mt-1.5 text-xs text-red-500">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- DEADLINE --}}
                            <div>

                                <label for="deadline"
                                       class="block mb-1.5
                                              text-sm font-medium
                                              text-gray-700
                                              dark:text-gray-300">

                                    Deadline
                                    <span class="text-red-500">*</span>

                                </label>

                                <input type="date"
                                       name="deadline"
                                       id="deadline"
                                       value="{{ old(
                                            'deadline',
                                            $task->deadline->format('Y-m-d')
                                       ) }}"
                                       class="block w-full
                                              px-3 py-2.5
                                              text-sm
                                              text-gray-900
                                              bg-gray-50
                                              border
                                              border-gray-300
                                              rounded-xl
                                              focus:ring-2
                                              focus:ring-blue-500
                                              focus:border-blue-500
                                              dark:bg-gray-700
                                              dark:border-gray-600
                                              dark:text-white
                                              transition
                                              @error('deadline') border-red-500 @enderror">

                                @error('deadline')

                                    <p class="mt-1.5 text-xs text-red-500">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- TITLE --}}
                            <div class="md:col-span-2">

                                <label for="title"
                                       class="block mb-1.5
                                              text-sm font-medium
                                              text-gray-700
                                              dark:text-gray-300">

                                    Judul Tugas
                                    <span class="text-red-500">*</span>

                                </label>

                                <input type="text"
                                       name="title"
                                       id="title"
                                       value="{{ old('title', $task->title) }}"
                                       placeholder="Masukkan judul tugas"
                                       autocomplete="off"
                                       class="block w-full
                                              px-3 py-2.5
                                              text-sm
                                              text-gray-900
                                              bg-gray-50
                                              border
                                              border-gray-300
                                              rounded-xl
                                              focus:ring-2
                                              focus:ring-blue-500
                                              focus:border-blue-500
                                              dark:bg-gray-700
                                              dark:border-gray-600
                                              dark:text-white
                                              transition
                                              @error('title') border-red-500 @enderror">

                                @error('title')

                                    <p class="mt-1.5 text-xs text-red-500">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- DESCRIPTION --}}
                            <div class="md:col-span-2">

                                <label for="description"
                                       class="block mb-1.5
                                              text-sm font-medium
                                              text-gray-700
                                              dark:text-gray-300">

                                    Deskripsi

                                </label>

                                <textarea name="description"
                                          id="description"
                                          rows="8"
                                          placeholder="Jelaskan detail pekerjaan..."
                                          class="block w-full
                                                 px-3 py-2.5
                                                 text-sm
                                                 text-gray-900
                                                 bg-gray-50
                                                 border
                                                 border-gray-300
                                                 rounded-xl
                                                 focus:ring-2
                                                 focus:ring-blue-500
                                                 focus:border-blue-500
                                                 dark:bg-gray-700
                                                 dark:border-gray-600
                                                 dark:text-white
                                                 transition
                                                 resize-none
                                                 @error('description') border-red-500 @enderror">{{ old('description', $task->description) }}</textarea>

                                @error('description')

                                    <p class="mt-1.5 text-xs text-red-500">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =========================
                    ACTION
                ========================== --}}
                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('tasks.index') }}"
                       class="px-5 py-2.5
                              text-sm font-medium
                              text-gray-700
                              bg-white
                              border border-gray-300
                              rounded-xl
                              hover:bg-gray-50
                              transition">

                        Batal

                    </a>


                    <button type="submit"
                            class="inline-flex items-center
                                   gap-2
                                   px-5 py-2.5
                                   text-sm font-medium
                                   text-white
                                   bg-blue-600
                                   rounded-xl
                                   hover:bg-blue-700
                                   transition
                                   cursor-pointer">

                        <svg class="w-4 h-4"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 13l4 4L19 7"/>

                        </svg>

                        Simpan Perubahan

                    </button>

                </div>

            </div>


            {{-- =========================
                RIGHT SIDEBAR
            ========================== --}}
            <div class="xl:col-span-3 space-y-5">

                {{-- Informasi --}}
                <div class="bg-white
                            dark:bg-gray-800
                            border border-gray-200
                            dark:border-gray-700
                            rounded-2xl
                            p-6
                            shadow-xs">

                    <h3 class="text-sm font-semibold
                               text-gray-900
                               dark:text-white
                               mb-5">

                        Informasi Tugas

                    </h3>


                    <div class="space-y-4 text-sm">

                        <div>

                            <p class="text-gray-500 mb-1">
                                Kode Tugas
                            </p>

                            <p class="font-semibold text-blue-600">
                                {{ $task->task_code }}
                            </p>

                        </div>


                        <div>

                            <p class="text-gray-500 mb-1">
                                Dibuat Oleh
                            </p>

                            <p class="font-medium
                                      text-gray-900
                                      dark:text-white">

                                {{ $task->creator?->employee?->name
                                    ?? $task->creator?->email
                                    ?? '-' }}

                            </p>

                        </div>


                        <div>

                            <p class="text-gray-500 mb-1">
                                Dibuat
                            </p>

                            <p class="font-medium
                                      text-gray-900
                                      dark:text-white">

                                {{ $task->created_at->format('d M Y H:i') }}

                            </p>

                        </div>


                        <div>

                            <p class="text-gray-500 mb-1">
                                Terakhir Diubah
                            </p>

                            <p class="font-medium
                                      text-gray-900
                                      dark:text-white">

                                {{ $task->updated_at->format('d M Y H:i') }}

                            </p>

                        </div>

                    </div>

                </div>


                {{-- Panduan --}}
                <div class="bg-white
                            dark:bg-gray-800
                            border border-gray-200
                            dark:border-gray-700
                            rounded-2xl
                            p-6
                            shadow-xs">

                    <h3 class="text-sm font-semibold
                               text-gray-900
                               dark:text-white
                               mb-5">

                        Panduan Perubahan

                    </h3>


                    <div class="space-y-5">

                        <div class="flex items-start gap-3">

                            <div class="w-8 h-8
                                        rounded-lg
                                        bg-blue-50
                                        flex items-center
                                        justify-center
                                        shrink-0">

                                <svg class="w-4 h-4 text-blue-600"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M13 16h-1v-4h-1m1-4h.01"/>

                                </svg>

                            </div>

                            <div>

                                <p class="text-sm font-medium
                                          text-gray-900
                                          dark:text-white">

                                    Perbarui informasi

                                </p>

                                <p class="text-xs text-gray-500 mt-1">
                                    Sesuaikan detail tugas apabila ada perubahan pekerjaan.
                                </p>

                            </div>

                        </div>


                        <div class="flex items-start gap-3">

                            <div class="w-8 h-8
                                        rounded-lg
                                        bg-green-50
                                        flex items-center
                                        justify-center
                                        shrink-0">

                                <svg class="w-4 h-4 text-green-600"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9 12h6"/>

                                </svg>

                            </div>

                            <div>

                                <p class="text-sm font-medium
                                          text-gray-900
                                          dark:text-white">

                                    PIC dapat diganti

                                </p>

                                <p class="text-xs text-gray-500 mt-1">
                                    Ubah PIC apabila tanggung jawab pekerjaan dialihkan.
                                </p>

                            </div>

                        </div>


                        <div class="flex items-start gap-3">

                            <div class="w-8 h-8
                                        rounded-lg
                                        bg-yellow-50
                                        flex items-center
                                        justify-center
                                        shrink-0">

                                <svg class="w-4 h-4 text-yellow-600"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>

                                </svg>

                            </div>

                            <div>

                                <p class="text-sm font-medium
                                          text-gray-900
                                          dark:text-white">

                                    Status dipisahkan

                                </p>

                                <p class="text-xs text-gray-500 mt-1">
                                    Gunakan Update Status agar perubahan tercatat dalam history.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection