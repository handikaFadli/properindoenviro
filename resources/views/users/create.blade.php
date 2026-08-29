@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')

<div class="px-4 pt-6 pb-10 max-w-5xl mx-auto">

    {{-- ============================================================
        HEADER
    ============================================================ --}}
    <div class="mb-6">

        <h1 class="text-2xl
                   font-bold
                   text-gray-900
                   dark:text-white">

            Tambah User

        </h1>

        <p class="mt-1
                  text-sm
                  text-gray-500
                  dark:text-gray-400">

            Buat akun login baru untuk karyawan.

        </p>

    </div>


    <form
        action="{{ route('users.store') }}"
        method="POST"
    >

        @csrf


        {{-- ============================================================
            CARD
        ============================================================ --}}
        <div class="bg-white
                    dark:bg-gray-800
                    border
                    border-gray-200
                    dark:border-gray-700
                    rounded-xl
                    p-6
                    mb-5
                    shadow-sm">


            {{-- Card Header --}}
            <div class="flex
                        items-center
                        gap-3
                        mb-6">

                <div class="flex
                            items-center
                            justify-center
                            w-9 h-9
                            rounded-lg
                            bg-blue-50
                            dark:bg-blue-900/30">

                    <svg
                        class="w-5 h-5
                               text-blue-600
                               dark:text-blue-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v16m8-8H4"
                        />
                    </svg>

                </div>


                <div>

                    <h2 class="text-sm
                               font-semibold
                               text-gray-900
                               dark:text-white">

                        Informasi Akun

                    </h2>

                    <p class="text-xs text-gray-400">

                        Pilih karyawan yang akan diberikan akses login.

                    </p>

                </div>

            </div>


            <div class="grid
                        grid-cols-1
                        md:grid-cols-2
                        gap-5">


                {{-- ============================================================
                    EMPLOYEE
                ============================================================ --}}
                <div class="md:col-span-2">

                    <label
                        for="employee_id"
                        class="block
                               mb-1.5
                               text-sm
                               font-medium
                               text-gray-700
                               dark:text-gray-300"
                    >
                        Karyawan

                        <span class="text-red-500">
                            *
                        </span>
                    </label>


                    <select
                        name="employee_id"
                        id="employee_id"
                        required
                        class="block
                               w-full
                               px-3 py-2.5
                               text-sm
                               text-gray-900
                               bg-gray-50
                               border
                               border-gray-300
                               rounded-lg
                               focus:ring-2
                               focus:ring-blue-500
                               focus:border-blue-500
                               dark:bg-gray-700
                               dark:border-gray-600
                               dark:text-white
                               transition"
                    >

                        <option value="">
                            -- Pilih Karyawan --
                        </option>


                        @foreach($employees as $employee)

                            <option
                                value="{{ $employee->id }}"

                                data-email="{{ $employee->email }}"

                                data-department="{{
                                    $employee->department?->name ?? '-'
                                }}"

                                data-position="{{
                                    $employee->position?->name ?? '-'
                                }}"

                                data-role="{{
                                    ucfirst(
                                        $employee
                                            ->position
                                            ?->role
                                            ?->name
                                        ?? '-'
                                    )
                                }}"

                                @selected(
                                    old('employee_id')
                                    == $employee->id
                                )
                            >

                                {{ $employee->employee_code }}
                                -
                                {{ $employee->name }}

                            </option>

                        @endforeach

                    </select>


                    @error('employee_id')

                        <p class="mt-1
                                  text-xs
                                  text-red-500">

                            {{ $message }}

                        </p>

                    @enderror

                </div>


                {{-- ============================================================
                    EMPLOYEE INFORMATION
                ============================================================ --}}
                <div
                    id="employee-info"
                    class="md:col-span-2
                           hidden
                           p-4
                           bg-blue-50/50
                           dark:bg-gray-700/40
                           border
                           border-blue-100
                           dark:border-gray-600
                           rounded-xl"
                >

                    <div class="grid
                                grid-cols-1
                                sm:grid-cols-3
                                gap-4">


                        {{-- Department --}}
                        <div>

                            <p class="text-xs
                                      text-gray-400">

                                Departemen

                            </p>

                            <p
                                id="employee-department"
                                class="mt-1
                                       text-sm
                                       font-semibold
                                       text-gray-700
                                       dark:text-white"
                            >
                                -
                            </p>

                        </div>


                        {{-- Position --}}
                        <div>

                            <p class="text-xs
                                      text-gray-400">

                                Posisi

                            </p>

                            <p
                                id="employee-position"
                                class="mt-1
                                       text-sm
                                       font-semibold
                                       text-gray-700
                                       dark:text-white"
                            >
                                -
                            </p>

                        </div>


                        {{-- Role --}}
                        <div>

                            <p class="text-xs
                                      text-gray-400">

                                Role

                            </p>

                            <p
                                id="employee-role"
                                class="mt-1
                                       text-sm
                                       font-semibold
                                       text-gray-700
                                       dark:text-white"
                            >
                                -
                            </p>

                        </div>

                    </div>

                </div>


                {{-- ============================================================
                    EMAIL
                ============================================================ --}}
                <div class="md:col-span-2">

                    <label
                        for="email"
                        class="block
                               mb-1.5
                               text-sm
                               font-medium
                               text-gray-700
                               dark:text-gray-300"
                    >

                        Email Login

                        <span class="text-red-500">
                            *
                        </span>

                    </label>


                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        required
                        placeholder="Contoh: user@company.com"
                        class="block
                               w-full
                               px-3 py-2.5
                               text-sm
                               text-gray-900
                               bg-gray-50
                               border
                               border-gray-300
                               rounded-lg
                               focus:ring-2
                               focus:ring-blue-500
                               focus:border-blue-500
                               dark:bg-gray-700
                               dark:border-gray-600
                               dark:text-white
                               dark:placeholder-gray-400
                               transition"
                    >


                    @error('email')

                        <p class="mt-1
                                  text-xs
                                  text-red-500">

                            {{ $message }}

                        </p>

                    @enderror

                </div>


                {{-- ============================================================
                    PASSWORD
                ============================================================ --}}
                <div>

                    <label
                        for="password"
                        class="block
                               mb-1.5
                               text-sm
                               font-medium
                               text-gray-700
                               dark:text-gray-300"
                    >

                        Password

                        <span class="text-red-500">
                            *
                        </span>

                    </label>


                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        placeholder="Minimal 8 karakter"
                        class="block
                               w-full
                               px-3 py-2.5
                               text-sm
                               text-gray-900
                               bg-gray-50
                               border
                               border-gray-300
                               rounded-lg
                               focus:ring-2
                               focus:ring-blue-500
                               focus:border-blue-500
                               dark:bg-gray-700
                               dark:border-gray-600
                               dark:text-white
                               dark:placeholder-gray-400
                               transition"
                    >


                    @error('password')

                        <p class="mt-1
                                  text-xs
                                  text-red-500">

                            {{ $message }}

                        </p>

                    @enderror

                </div>


                {{-- ============================================================
                    PASSWORD CONFIRMATION
                ============================================================ --}}
                <div>

                    <label
                        for="password_confirmation"
                        class="block
                               mb-1.5
                               text-sm
                               font-medium
                               text-gray-700
                               dark:text-gray-300"
                    >

                        Konfirmasi Password

                        <span class="text-red-500">
                            *
                        </span>

                    </label>


                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        required
                        placeholder="Ulangi password"
                        class="block
                               w-full
                               px-3 py-2.5
                               text-sm
                               text-gray-900
                               bg-gray-50
                               border
                               border-gray-300
                               rounded-lg
                               focus:ring-2
                               focus:ring-blue-500
                               focus:border-blue-500
                               dark:bg-gray-700
                               dark:border-gray-600
                               dark:text-white
                               dark:placeholder-gray-400
                               transition"
                    >

                </div>

            </div>

        </div>


        {{-- ============================================================
            ACTION
        ============================================================ --}}
        <div class="flex
                    items-center
                    justify-end
                    gap-3">

            <a
                href="{{ route('users.index') }}"
                class="px-5 py-2.5
                       text-sm
                       font-medium
                       text-gray-700
                       bg-white
                       border
                       border-gray-300
                       rounded-lg
                       hover:bg-gray-50
                       dark:bg-gray-800
                       dark:text-gray-300
                       dark:border-gray-600
                       dark:hover:bg-gray-700
                       transition"
            >

                Batal

            </a>


            <button
                type="submit"
                class="inline-flex
                       items-center
                       gap-2
                       px-5 py-2.5
                       text-sm
                       font-medium
                       text-white
                       bg-blue-600
                       rounded-lg
                       hover:bg-blue-700
                       focus:ring-2
                       focus:ring-blue-500
                       transition"
            >

                <svg
                    class="w-4 h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                    />
                </svg>

                Simpan User

            </button>

        </div>

    </form>

</div>


{{-- ============================================================
    SCRIPT
============================================================ --}}
<script>

document.addEventListener(
    'DOMContentLoaded',
    function ()
    {
        const employeeSelect =
            document.getElementById(
                'employee_id'
            );

        const emailInput =
            document.getElementById(
                'email'
            );

        const infoBox =
            document.getElementById(
                'employee-info'
            );

        const departmentText =
            document.getElementById(
                'employee-department'
            );

        const positionText =
            document.getElementById(
                'employee-position'
            );

        const roleText =
            document.getElementById(
                'employee-role'
            );


        function updateEmployeeInfo()
        {
            const option =
                employeeSelect.options[
                    employeeSelect.selectedIndex
                ];


            if (!employeeSelect.value) {

                infoBox.classList.add(
                    'hidden'
                );

                return;
            }


            infoBox.classList.remove(
                'hidden'
            );


            departmentText.textContent =
                option.dataset.department
                || '-';


            positionText.textContent =
                option.dataset.position
                || '-';


            roleText.textContent =
                option.dataset.role
                || '-';


            /*
            |--------------------------------------------------------------------------
            | Auto fill email
            |--------------------------------------------------------------------------
            |
            | Jangan menimpa old input apabila sebelumnya gagal validasi.
            |
            */

            if (!emailInput.value) {

                emailInput.value =
                    option.dataset.email
                    || '';

            }
        }


        employeeSelect.addEventListener(
            'change',
            function ()
            {
                /*
                | Jika user benar-benar mengganti employee,
                | email mengikuti employee yang baru.
                */

                const option =
                    employeeSelect.options[
                        employeeSelect.selectedIndex
                    ];

                emailInput.value =
                    option.dataset.email
                    || '';

                updateEmployeeInfo();
            }
        );


        updateEmployeeInfo();
    }
);

</script>

@endsection