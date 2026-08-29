@extends('layouts.app')

@section('title', 'Edit User')

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

            Edit User

        </h1>

        <p class="mt-1
                  text-sm
                  text-gray-500
                  dark:text-gray-400">

            Perbarui informasi akun login user.

        </p>

    </div>


    <form
        action="{{ route(
            'users.update',
            $user
        ) }}"
        method="POST"
    >

        @csrf
        @method('PUT')


        {{-- ============================================================
            EMPLOYEE INFORMATION
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
                            d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7Z"
                        />
                    </svg>

                </div>


                <div>

                    <h2 class="text-sm
                               font-semibold
                               text-gray-900
                               dark:text-white">

                        Informasi Karyawan

                    </h2>

                    <p class="text-xs
                              text-gray-400">

                        Informasi ini mengikuti data karyawan.

                    </p>

                </div>

            </div>


            <div class="grid
                        grid-cols-1
                        md:grid-cols-2
                        gap-5">


                {{-- Employee --}}
                <div class="md:col-span-2">

                    <label
                        class="block
                               mb-1.5
                               text-sm
                               font-medium
                               text-gray-700
                               dark:text-gray-300"
                    >
                        Karyawan
                    </label>


                    <div class="px-3 py-2.5
                                text-sm
                                bg-gray-100
                                dark:bg-gray-700
                                border
                                border-gray-200
                                dark:border-gray-600
                                rounded-lg">

                        <p class="font-semibold
                                  text-gray-800
                                  dark:text-white">

                            {{ $user->employee?->name
                                ?? '-'
                            }}

                        </p>

                        <p class="mt-1
                                  text-xs
                                  text-gray-400">

                            {{ $user->employee?->employee_code
                                ?? '-'
                            }}

                        </p>

                    </div>

                </div>


                {{-- Department --}}
                <div>

                    <label
                        class="block
                               mb-1.5
                               text-sm
                               font-medium
                               text-gray-700
                               dark:text-gray-300"
                    >
                        Departemen
                    </label>


                    <input
                        type="text"
                        readonly
                        value="{{
                            $user
                                ->employee
                                ?->department
                                ?->name
                            ?? '-'
                        }}"
                        class="block
                               w-full
                               px-3 py-2.5
                               text-sm
                               text-gray-500
                               bg-gray-100
                               border
                               border-gray-200
                               rounded-lg
                               dark:bg-gray-700
                               dark:border-gray-600
                               dark:text-gray-300
                               cursor-not-allowed"
                    >

                </div>


                {{-- Position --}}
                <div>

                    <label
                        class="block
                               mb-1.5
                               text-sm
                               font-medium
                               text-gray-700
                               dark:text-gray-300"
                    >
                        Posisi
                    </label>


                    <input
                        type="text"
                        readonly
                        value="{{
                            $user
                                ->employee
                                ?->position
                                ?->name
                            ?? '-'
                        }}"
                        class="block
                               w-full
                               px-3 py-2.5
                               text-sm
                               text-gray-500
                               bg-gray-100
                               border
                               border-gray-200
                               rounded-lg
                               dark:bg-gray-700
                               dark:border-gray-600
                               dark:text-gray-300
                               cursor-not-allowed"
                    >

                </div>


                {{-- Role --}}
                <div class="md:col-span-2">

                    <label
                        class="block
                               mb-1.5
                               text-sm
                               font-medium
                               text-gray-700
                               dark:text-gray-300"
                    >
                        Role
                    </label>


                    <div class="px-3 py-2.5
                                bg-gray-100
                                dark:bg-gray-700
                                border
                                border-gray-200
                                dark:border-gray-600
                                rounded-lg">

                        <span class="inline-flex
                                     px-2.5 py-1
                                     text-xs
                                     font-medium
                                     bg-blue-100
                                     text-blue-700
                                     rounded-full">

                            {{ ucfirst(
                                $user
                                    ->employee
                                    ?->position
                                    ?->role
                                    ?->name
                                ?? '-'
                            ) }}

                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- ============================================================
            ACCOUNT INFORMATION
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


            <div class="mb-5">

                <h2 class="text-sm
                           font-semibold
                           text-gray-900
                           dark:text-white">

                    Informasi Login

                </h2>

                <p class="mt-1
                          text-xs
                          text-gray-400">

                    Email digunakan untuk login ke dalam sistem.

                </p>

            </div>


            {{-- Email --}}
            <div>

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
                    required
                    value="{{ old(
                        'email',
                        $user->email
                    ) }}"
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


                @error('email')

                    <p class="mt-1
                              text-xs
                              text-red-500">

                        {{ $message }}

                    </p>

                @enderror

            </div>


            {{-- Last Login --}}
            <div class="mt-5
                        p-4
                        bg-gray-50
                        dark:bg-gray-700/40
                        rounded-xl">

                <p class="text-xs
                          text-gray-400">

                    Login Terakhir

                </p>

                <p class="mt-1
                          text-sm
                          font-semibold
                          text-gray-700
                          dark:text-white">

                    @if($user->last_login_at)

                        {{
                            $user->last_login_at
                                ->translatedFormat(
                                    'd M Y H:i'
                                )
                        }}

                    @else

                        Belum pernah login

                    @endif

                </p>

            </div>


            {{-- Password Information --}}
            <div class="mt-5
                        flex
                        items-start
                        gap-3
                        p-4
                        bg-amber-50
                        border
                        border-amber-100
                        rounded-xl">

                <svg
                    class="w-5 h-5
                           text-amber-500
                           shrink-0
                           mt-0.5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M12 9v4m0 4h.01M10.3 4.6 3.8 16a2 2 0 0 0 1.74 3h12.92A2 2 0 0 0 20.2 16L13.7 4.6a2 2 0 0 0-3.4 0Z"
                    />
                </svg>


                <div>

                    <p class="text-sm
                              font-medium
                              text-amber-800">

                        Password tidak diubah dari halaman ini.

                    </p>

                    <p class="mt-1
                              text-xs
                              text-amber-700">

                        Gunakan menu Reset Password pada halaman
                        Kelola User untuk mengubah password akun.

                    </p>

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

                Simpan Perubahan

            </button>

        </div>

    </form>

</div>

@endsection