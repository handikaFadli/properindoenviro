@extends('layouts.app')

@section('title', 'Buat Tugas')

@section('content')

<div class="px-4 pt-6 pb-10 max-w-7xl mx-auto w-full min-w-0">

    {{-- =========================
        HEADER
    ========================== --}}
    <div class="mb-6">

        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Buat Tugas
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Tambahkan pekerjaan baru dan tentukan PIC yang bertanggung jawab.
        </p>

    </div>


    <form action="{{ route('tasks.store') }}" method="POST">

        @csrf

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

                            <div class="flex items-center justify-center
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
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2Z"/>

                                </svg>

                            </div>

                            <div>

                                <h2 class="text-sm font-semibold
                                           text-gray-900
                                           dark:text-white">

                                    Informasi Tugas

                                </h2>

                                <p class="text-xs text-gray-400">
                                    Isi detail utama pekerjaan yang akan dibuat.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Form Content --}}
                    <div class="p-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            {{-- =========================
                                PIC
                            ========================== --}}
                            <div>

                                <label for="pic_id"
                                       class="block mb-1.5
                                              text-sm font-medium
                                              text-gray-700
                                              dark:text-gray-300">

                                    PIC
                                    <span class="text-red-500">*</span>

                                </label>

                                <select name="pic_id"
                                        id="pic_id"
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
                                               @error('pic_id') border-red-500 @enderror">

                                    <option value="">
                                        Pilih PIC
                                    </option>

                                    @foreach($employees as $employee)

                                        <option value="{{ $employee->id }}"
                                            @selected(old('pic_id') == $employee->id)>

                                            {{ $employee->name }}
                                            -
                                            {{ $employee?->department?->name }}

                                        </option>

                                    @endforeach

                                </select>
                                @if(auth()->user()->isManagement())

                                    <div
                                        class="mb-4 p-3
                                            rounded-lg
                                            bg-blue-50
                                            border border-blue-200
                                            text-sm
                                            text-blue-700"
                                    >
                                        Anda hanya dapat membuat tugas untuk karyawan
                                        dari departemen

                                        <strong>
                                            {{ auth()->user()->employee?->department?->name }}
                                        </strong>.
                                    </div>

                                @endif

                                @error('pic_id')

                                    <p class="mt-1.5 text-xs text-red-500">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- =========================
                                PRIORITAS
                            ========================== --}}
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
                                            @selected(old('task_priority_id') == $priority->id)>

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


                            {{-- =========================
                                DEADLINE
                            ========================== --}}
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
                                       value="{{ old('deadline') }}"
                                       min="{{ now()->format('Y-m-d') }}"
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


                            {{-- =========================
                                STATUS AWAL
                            ========================== --}}
                            <div>

                                <label class="block mb-1.5
                                              text-sm font-medium
                                              text-gray-700
                                              dark:text-gray-300">

                                    Status Awal

                                </label>

                                <div class="flex items-center
                                            w-full
                                            min-h-11
                                            px-3 py-2.5
                                            bg-gray-50
                                            border
                                            border-gray-200
                                            rounded-xl
                                            dark:bg-gray-700
                                            dark:border-gray-600">

                                    <span class="inline-flex items-center
                                                 gap-1.5
                                                 px-2.5 py-1
                                                 text-xs font-medium
                                                 text-gray-700
                                                 bg-gray-200
                                                 rounded-full">

                                        <span class="w-1.5 h-1.5
                                                     rounded-full
                                                     bg-gray-500">
                                        </span>

                                        Belum Dimulai

                                    </span>

                                </div>

                                <p class="mt-1.5 text-xs text-gray-400">
                                    Status otomatis ditetapkan saat tugas dibuat.
                                </p>

                            </div>


                            {{-- =========================
                                JUDUL
                            ========================== --}}
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
                                       value="{{ old('title') }}"
                                       placeholder="Contoh: Membuat halaman dashboard monitoring"
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
                                              dark:placeholder-gray-400
                                              transition
                                              @error('title') border-red-500 @enderror">

                                @error('title')

                                    <p class="mt-1.5 text-xs text-red-500">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- =========================
                                DESKRIPSI
                            ========================== --}}
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
                                          placeholder="Jelaskan detail pekerjaan yang harus diselesaikan..."
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
                                                 dark:placeholder-gray-400
                                                 transition
                                                 resize-none
                                                 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>

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
                            class="inline-flex items-center gap-2
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

                        Simpan Tugas

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
                                Dibuat Oleh
                            </p>

                            <p class="font-medium
                                      text-gray-900
                                      dark:text-white">

                                {{ auth()->user()->employee?->name ?? auth()->user()->email }}

                            </p>

                        </div>


                        <div>

                            <p class="text-gray-500 mb-1">
                                Tanggal Dibuat
                            </p>

                            <p class="font-medium
                                      text-gray-900
                                      dark:text-white">

                                {{ now()->format('d M Y H:i') }}

                            </p>

                        </div>


                        <div>

                            <p class="text-gray-500 mb-1">
                                Status Awal
                            </p>

                            <span class="inline-flex items-center
                                         px-2.5 py-1
                                         rounded-full
                                         text-xs font-medium
                                         bg-gray-100
                                         text-gray-700">

                                Belum Dimulai

                            </span>

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

                        Panduan Tugas

                    </h3>

                    <div class="space-y-5">

                        {{-- Guide 1 --}}
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

                                    Gunakan judul yang jelas

                                </p>

                                <p class="text-xs text-gray-500 mt-1">
                                    Buat judul pekerjaan singkat dan mudah dipahami.
                                </p>

                            </div>

                        </div>


                        {{-- Guide 2 --}}
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

                                    Tentukan PIC yang sesuai

                                </p>

                                <p class="text-xs text-gray-500 mt-1">
                                    Pilih karyawan yang bertanggung jawab atas pekerjaan.
                                </p>

                            </div>

                        </div>


                        {{-- Guide 3 --}}
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

                                    Tentukan deadline realistis

                                </p>

                                <p class="text-xs text-gray-500 mt-1">
                                    Deadline digunakan sistem untuk monitoring dan notifikasi.
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