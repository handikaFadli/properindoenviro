@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')

<main>

    {{-- ============================================================
        HEADER
    ============================================================ --}}
    <div class="pt-5
                flex
                flex-col
                md:flex-row
                md:items-center
                md:justify-between
                gap-4
                mb-5">

        <div>

            <h1 class="text-2xl
                       font-semibold
                       text-gray-900
                       dark:text-white">

                Kelola User

            </h1>

            {{-- <p class="mt-1
                      text-sm
                      text-gray-500
                      dark:text-gray-400">

                Kelola akun pengguna yang dapat mengakses sistem.

            </p> --}}

        </div>


        <a
            href="{{ route('users.create') }}"
            class="inline-flex
                   items-center
                   justify-center
                   gap-1.5
                   px-4 py-2.5
                   text-sm
                   font-medium
                   text-white
                   bg-primary-600
                   rounded-lg
                   hover:bg-primary-700
                   focus:outline-none
                   focus:ring-2
                   focus:ring-primary-500"
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
                    d="M12 4v16m8-8H4"
                />
            </svg>

            Tambah User

        </a>

    </div>


    {{-- ============================================================
        FILTER
    ============================================================ --}}
    <div class="flex
                flex-col
                xl:flex-row
                xl:items-center
                xl:justify-between
                gap-4
                mb-4">


        {{-- LEFT --}}
        <div class="flex
                    flex-wrap
                    items-center
                    gap-3">


            {{-- ====================================================
                PER PAGE
            ===================================================== --}}
            <div class="relative inline-block">

                <button
                    id="perPageButton"
                    data-dropdown-toggle="perPageDropdown"
                    type="button"
                    class="flex
                           items-center
                           justify-between
                           gap-3
                           min-w-[90px]
                           h-11
                           px-4
                           bg-white
                           dark:bg-gray-800
                           border
                           border-gray-200
                           dark:border-gray-700
                           rounded-xl
                           shadow-sm
                           text-sm
                           font-medium
                           text-gray-700
                           dark:text-gray-200
                           hover:border-primary-400
                           focus:ring-4
                           focus:ring-primary-100
                           transition-all
                           cursor-pointer"
                >

                    <span>
                        {{ request('per_page', 10) }}
                    </span>

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
                            d="M19 9l-7 7-7-7"
                        />
                    </svg>

                </button>


                <div
                    id="perPageDropdown"
                    class="hidden
                           z-30
                           w-36
                           mt-2
                           bg-white
                           dark:bg-gray-800
                           rounded-xl
                           shadow-xl
                           border
                           border-gray-100
                           dark:border-gray-700
                           overflow-hidden"
                >

                    @foreach([10, 25, 50, 100] as $size)

                        <button
                            type="button"
                            onclick="updatePerPage({{ $size }})"
                            class="w-full
                                   px-4 py-2.5
                                   text-left
                                   text-sm
                                   hover:bg-primary-50
                                   hover:text-primary-600
                                   dark:hover:bg-gray-700
                                   transition
                                   cursor-pointer
                                   {{
                                       request('per_page', 10) == $size
                                           ? 'bg-primary-50 text-primary-600 font-semibold'
                                           : 'text-gray-700 dark:text-gray-200'
                                   }}"
                        >

                            {{ $size }}

                        </button>

                    @endforeach

                </div>

            </div>

        </div>


        {{-- ========================================================
            SEARCH
        ========================================================= --}}
        <div class="relative
                    flex
                    w-full
                    xl:w-96">

            <div class="relative flex-1">

                <svg
                    class="absolute
                           left-4
                           top-1/2
                           -translate-y-1/2
                           w-5 h-5
                           text-gray-400"
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


                <input
                    id="search-input"
                    type="text"
                    value="{{ request('search') }}"
                    placeholder="Cari..."
                    class="w-full
                           h-11
                           rounded-l-xl
                           border
                           border-gray-300
                           dark:border-gray-700
                           border-r-0
                           bg-white
                           dark:bg-gray-800
                           pl-11 pr-4
                           text-sm
                           text-gray-700
                           dark:text-gray-200
                           focus:outline-none
                           focus:border-primary-500
                           focus:ring-4
                           focus:ring-primary-100
                           transition-all"
                >

            </div>


            <button
                type="button"
                onclick="searchTable()"
                class="h-11
                       px-6
                       rounded-r-xl
                       bg-primary-600
                       hover:bg-primary-700
                       border
                       border-primary-600
                       text-white
                       text-sm
                       font-medium
                       cursor-pointer"
            >

                Cari

            </button>

        </div>

    </div>


    {{-- ============================================================
        ACTIVE FILTER
    ============================================================ --}}
    @if(
        request()->filled('search')
        || request()->filled('role_id')
    )

        <div class="flex
                    flex-wrap
                    items-center
                    gap-2
                    mb-4">

            <span class="text-xs
                         font-medium
                         text-gray-500">

                Filter aktif:

            </span>


            @if(request()->filled('search'))

                <span class="inline-flex
                             items-center
                             px-2.5 py-1
                             text-xs
                             bg-primary-50
                             text-primary-700
                             rounded-full">

                    Pencarian:
                    {{ request('search') }}

                </span>

            @endif


            @if(request()->filled('role_id'))

                @php

                    $selectedRole =
                        $roles->firstWhere(
                            'id',
                            request('role_id')
                        );

                @endphp


                @if($selectedRole)

                    <span class="inline-flex
                                 items-center
                                 px-2.5 py-1
                                 text-xs
                                 bg-primary-50
                                 text-primary-700
                                 rounded-full">

                        Role:
                        {{ ucfirst($selectedRole->name) }}

                    </span>

                @endif

            @endif

        </div>

    @endif


    {{-- ============================================================
        TABLE
    ============================================================ --}}
    <div class="flex flex-col mt-4">

        <div class="overflow-x-auto
                    bg-white
                    dark:bg-gray-800
                    border
                    border-gray-200
                    dark:border-gray-700
                    rounded-2xl
                    shadow-sm">

            <table class="w-full
                          text-sm
                          text-left">

                <thead>

                    <tr class="bg-slate-200
                               dark:bg-gray-700">


                        <th class="px-4 py-3
                                   text-xs
                                   font-bold
                                   text-gray-600
                                   uppercase
                                   w-12">

                            #

                        </th>


                        <th class="px-4 py-3
                                   text-xs
                                   font-bold
                                   text-gray-600
                                   uppercase">

                            Karyawan

                        </th>


                        <th class="px-4 py-3
                                   text-xs
                                   font-bold
                                   text-gray-600
                                   uppercase">

                            Email

                        </th>


                        <th class="px-4 py-3
                                   text-xs
                                   font-bold
                                   text-gray-600
                                   uppercase">

                            Role

                        </th>


                        <th class="px-4 py-3
                                   text-xs
                                   font-bold
                                   text-gray-600
                                   uppercase">

                            Login Terakhir

                        </th>


                        <th class="px-4 py-3
                                   text-xs
                                   font-bold
                                   text-gray-600
                                   uppercase
                                   text-center
                                   min-w-[120px]">

                            Aksi

                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($users as $i => $item)

                        @php

                            $roleName =
                                $item
                                    ->employee
                                    ?->position
                                    ?->role
                                    ?->name
                                ?? '-';


                            $roleColors = [

                                'admin' =>
                                    'bg-purple-100 text-purple-700',

                                'manager' =>
                                    'bg-blue-100 text-blue-700',

                                'supervisor' =>
                                    'bg-cyan-100 text-cyan-700',

                                'staff' =>
                                    'bg-green-100 text-green-700',
                            ];


                            $roleClass =
                                $roleColors[
                                    strtolower($roleName)
                                ]
                                ?? 'bg-gray-100 text-gray-700';

                        @endphp


                        <tr class="border-b
                                   border-gray-200
                                   dark:border-gray-700
                                   hover:bg-gray-50
                                   dark:hover:bg-gray-700/40
                                   transition">


                            {{-- Number --}}
                            <td class="px-4 py-3
                                       text-xs
                                       text-gray-400">

                                {{ $users->firstItem() + $i }}

                            </td>


                            {{-- Employee --}}
                            <td class="px-4 py-3">

                                <div class="flex
                                            items-center
                                            gap-3">

                                    <div class="flex
                                                items-center
                                                justify-center
                                                w-9 h-9
                                                rounded-full
                                                bg-primary-100
                                                text-primary-700
                                                font-semibold
                                                text-sm
                                                shrink-0">

                                        {{
                                            strtoupper(
                                                substr(
                                                    $item->name,
                                                    0,
                                                    1
                                                )
                                            )
                                        }}

                                    </div>


                                    <div>

                                        <div class="font-medium
                                                    text-gray-900
                                                    dark:text-white">

                                            {{
                                                $item
                                                    ->employee
                                                    ?->name
                                                ?? $item->name
                                            }}

                                        </div>


                                        <div class="mt-0.5
                                                    text-xs
                                                    text-gray-400">

                                            {{
                                                $item
                                                    ->employee
                                                    ?->employee_code
                                                ?? '-'
                                            }}

                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Email --}}
                            <td class="px-4 py-3">

                                <span class="text-gray-700
                                             dark:text-gray-200">

                                    {{ $item->email }}

                                </span>

                            </td>


                            {{-- Role --}}
                            <td class="px-4 py-3">

                                <span class="inline-flex
                                             items-center
                                             px-2.5 py-1
                                             rounded-full
                                             text-xs
                                             font-medium
                                             {{ $roleClass }}">

                                    {{ ucfirst($roleName) }}

                                </span>

                            </td>


                            {{-- Last Login --}}
                            <td class="px-4 py-3">

                                @if($item->last_login_at)

                                    <div class="text-sm
                                                text-gray-700
                                                dark:text-gray-200">

                                        {{
                                            $item
                                                ->last_login_at
                                                ->translatedFormat(
                                                    'd M Y'
                                                )
                                        }}

                                    </div>

                                    <div class="mt-0.5
                                                text-xs
                                                text-gray-400">

                                        {{
                                            $item
                                                ->last_login_at
                                                ->format('H:i')
                                        }}

                                    </div>

                                @else

                                    <span class="text-xs
                                                 text-gray-400">

                                        Belum login

                                    </span>

                                @endif

                            </td>


                            {{-- Action --}}
														<td class="px-4 py-3">

																<div class="flex
																						justify-center
																						gap-1">

																		{{-- Edit --}}
																		<a
																				href="{{ route('users.edit', $item) }}"
																				title="Edit User"
																				class="p-1.5
																							rounded
																							border
																							border-gray-300
																							dark:border-gray-600
																							text-gray-700
																							dark:text-gray-200
																							hover:bg-gray-100
																							dark:hover:bg-gray-700"
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
																								stroke-width="1.5"
																								d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5"
																						/>
																				</svg>

																		</a>


																		{{-- Reset Password --}}
																		<button
																				type="button"
																				title="Reset Password"
																				onclick="openResetPasswordModal(
																						{{ $item->id }},
																						@js($item->name),
																						@js(route('users.reset-password', $item))
																				)"
																				class="p-1.5
																							rounded
																							border
																							border-amber-200
																							text-amber-600
																							hover:bg-amber-50
																							dark:border-amber-800
																							dark:text-amber-400
																							dark:hover:bg-amber-900/20
																							cursor-pointer"
																		>

																				<svg class="w-4 h-4"
																						fill="none"
																						stroke="currentColor"
																						viewBox="0 0 24 24">

																						<path stroke-linecap="round"
																									stroke-linejoin="round"
																									stroke-width="1.8"
																									d="M4 4v6h6M20 20v-6h-6M5.1 15A8 8 0 0 0 18 17m.9-8A8 8 0 0 0 6 7"/>

																				</svg>
																						<path
																								stroke-linecap="round"
																								stroke-linejoin="round"
																								stroke-width="1.6"
																								d="M15 7a4 4 0 1 0-4 3.874V13H9v3H6v3H3v2h5.5L15 14.5V13.13A4 4 0 0 0 15 7Z"
																						/>
																				</svg>

																		</button>


																		{{-- Nonaktifkan --}}
																		@if(auth()->id() !== $item->id)

																				<form
																						id="delete-form-{{ $item->id }}"
																						action="{{ route('users.destroy', $item) }}"
																						method="POST"
																						class="inline"
																				>

																						@csrf
																						@method('DELETE')

																						<button
																								type="button"
																								title="Nonaktifkan User"
																								onclick="openDeleteUserModal(
																										'delete-form-{{ $item->id }}',
																										@js($item->name)
																								)"
																								class="p-1.5
																											rounded
																											border
																											border-red-200
																											text-red-600
																											hover:bg-red-50
																											dark:hover:bg-red-900/20
																											cursor-pointer"
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
																												stroke-width="1.5"
																												d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"
																										/>
																								</svg>

																						</button>

																				</form>

																		@endif

																</div>

														</td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-4
                                       py-12
                                       text-center
                                       text-gray-400"
                            >

                                Tidak ada data user.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

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
                mt-6">

        <div class="text-sm text-gray-500">

            Menampilkan

            <span class="font-semibold">
                {{ $users->firstItem() ?? 0 }}
            </span>

            -

            <span class="font-semibold">
                {{ $users->lastItem() ?? 0 }}
            </span>

            dari

            <span class="font-semibold">
                {{ $users->total() }}
            </span>

            data

        </div>


        <div>
            {{ $users->links() }}
        </div>

    </div>


    {{-- ============================================================
        DELETE MODAL
    ============================================================ --}}
    <div
        id="delete-user-modal"
        class="fixed
               inset-0
               z-50
               hidden
               items-center
               justify-center
               bg-gray-900/50"
    >

        <div class="w-full
                    max-w-md
                    mx-4
                    bg-white
                    dark:bg-gray-800
                    rounded-2xl
                    shadow-xl
                    p-6">

            <div class="flex
                        items-center
                        justify-center
                        w-12 h-12
                        mx-auto
                        mb-4
                        rounded-full
                        bg-red-100
                        text-red-600">

                <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.7"
                        d="M12 9v4m0 4h.01M10.3 4.6 3.8 16a2 2 0 0 0 1.74 3h12.92A2 2 0 0 0 20.2 16L13.7 4.6a2 2 0 0 0-3.4 0Z"
                    />
                </svg>

            </div>


            <h3 class="text-lg
                       font-semibold
                       text-center
                       text-gray-900
                       dark:text-white">

                Nonaktifkan User?

            </h3>


            <p class="mt-2
                      text-sm
                      text-center
                      text-gray-500">

                Akun

                <span
                    id="delete-user-name"
                    class="font-semibold"
                ></span>

                akan dinonaktifkan.

            </p>


            <div class="flex
                        justify-center
                        gap-3
                        mt-6">

                <button
                    type="button"
                    onclick="closeDeleteUserModal()"
                    class="px-4 py-2.5
                           text-sm
                           font-medium
                           text-gray-700
                           bg-white
                           border
                           border-gray-300
                           rounded-lg
                           hover:bg-gray-50
                           cursor-pointer"
                >

                    Batal

                </button>


                <button
                    type="button"
                    onclick="confirmDeleteUser()"
                    class="px-4 py-2.5
                           text-sm
                           font-medium
                           text-white
                           bg-red-600
                           rounded-lg
                           hover:bg-red-700
                           cursor-pointer"
                >

                    Ya, Nonaktifkan

                </button>

            </div>

        </div>

    </div>

		{{-- ============================================================
    RESET PASSWORD MODAL
============================================================ --}}
<div
    id="reset-password-modal"
    class="fixed
           inset-0
           z-50
           hidden
           items-center
           justify-center
           bg-gray-900/50"
>

    <div class="w-full
                max-w-md
                mx-4
                bg-white
                dark:bg-gray-800
                rounded-2xl
                shadow-xl
                p-6">

        {{-- Icon --}}
        <div class="flex
                    items-center
                    justify-center
                    w-12 h-12
                    mx-auto
                    mb-4
                    rounded-full
                    bg-amber-100
                    dark:bg-amber-900/30
                    text-amber-600
                    dark:text-amber-400">

            <svg class="w-4 h-4"
								fill="none"
								stroke="currentColor"
								viewBox="0 0 24 24">

								<path stroke-linecap="round"
											stroke-linejoin="round"
											stroke-width="1.8"
											d="M4 4v6h6M20 20v-6h-6M5.1 15A8 8 0 0 0 18 17m.9-8A8 8 0 0 0 6 7"/>

						</svg>

        </div>


        <h3 class="text-lg
                   font-semibold
                   text-center
                   text-gray-900
                   dark:text-white">

            Reset Password

        </h3>


        <p class="mt-2
                  text-sm
                  text-center
                  text-gray-500
                  dark:text-gray-400">

            Masukkan password baru untuk

            <span
                id="reset-password-user-name"
                class="font-semibold
                       text-gray-700
                       dark:text-gray-200"
            ></span>

        </p>


        <form
            id="reset-password-form"
            method="POST"
            class="mt-6"
        >

            @csrf
            @method('PATCH')


            {{-- Password --}}
            <div>

                <label
                    for="reset-password"
                    class="block
                           mb-1.5
                           text-sm
                           font-medium
                           text-gray-700
                           dark:text-gray-300"
                >

                    Password Baru

                    <span class="text-red-500">*</span>

                </label>


                <div class="relative">

                    <input
                        type="password"
                        name="password"
                        id="reset-password"
                        required
                        minlength="8"
                        placeholder="Minimal 8 karakter"
                        class="block
                               w-full
                               px-3
                               py-2.5
                               pr-11
                               text-sm
                               text-gray-900
                               bg-gray-50
                               border
                               border-gray-300
                               rounded-lg
                               focus:ring-2
                               focus:ring-primary-500
                               focus:border-primary-500
                               dark:bg-gray-700
                               dark:border-gray-600
                               dark:text-white"
                    >


                    <button
                        type="button"
                        onclick="toggleResetPassword(
                            'reset-password',
                            'reset-eye-open',
                            'reset-eye-close'
                        )"
                        class="absolute
                               inset-y-0
                               right-0
                               flex
                               items-center
                               px-3
                               text-gray-400
                               hover:text-primary-600
                               cursor-pointer"
                    >

                        {{-- Eye --}}
                        <svg
                            id="reset-eye-open"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.7"
                                d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"
                            />

                            <circle
                                cx="12"
                                cy="12"
                                r="3"
                                stroke-width="1.7"
                            />
                        </svg>


                        {{-- Eye Slash --}}
                        <svg
                            id="reset-eye-close"
                            class="hidden w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.7"
                                d="m3 3 18 18M10.6 10.6A2 2 0 0 0 13.4 13.4M9.9 4.4A10.5 10.5 0 0 1 12 4.2c6 0 9.75 7.8 9.75 7.8a17.8 17.8 0 0 1-2.6 3.8M6.2 6.2C3.8 8.1 2.25 12 2.25 12S6 19.8 12 19.8a9 9 0 0 0 4-.9"
                            />
                        </svg>

                    </button>

                </div>

            </div>


            {{-- Confirmation --}}
            <div class="mt-4">

                <label
                    for="reset-password-confirmation"
                    class="block
                           mb-1.5
                           text-sm
                           font-medium
                           text-gray-700
                           dark:text-gray-300"
                >

                    Konfirmasi Password

                    <span class="text-red-500">*</span>

                </label>


                <div class="relative">

                    <input
                        type="password"
                        name="password_confirmation"
                        id="reset-password-confirmation"
                        required
                        minlength="8"
                        placeholder="Ulangi password baru"
                        class="block
                               w-full
                               px-3
                               py-2.5
                               pr-11
                               text-sm
                               text-gray-900
                               bg-gray-50
                               border
                               border-gray-300
                               rounded-lg
                               focus:ring-2
                               focus:ring-primary-500
                               focus:border-primary-500
                               dark:bg-gray-700
                               dark:border-gray-600
                               dark:text-white"
                    >


                    <button
                        type="button"
                        onclick="toggleResetPassword(
                            'reset-password-confirmation',
                            'reset-confirm-eye-open',
                            'reset-confirm-eye-close'
                        )"
                        class="absolute
                               inset-y-0
                               right-0
                               flex
                               items-center
                               px-3
                               text-gray-400
                               hover:text-primary-600
                               cursor-pointer"
                    >

                        <svg
                            id="reset-confirm-eye-open"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.7"
                                d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12Z"
                            />

                            <circle
                                cx="12"
                                cy="12"
                                r="3"
                                stroke-width="1.7"
                            />
                        </svg>


                        <svg
                            id="reset-confirm-eye-close"
                            class="hidden w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.7"
                                d="m3 3 18 18M10.6 10.6A2 2 0 0 0 13.4 13.4M9.9 4.4A10.5 10.5 0 0 1 12 4.2c6 0 9.75 7.8 9.75 7.8a17.8 17.8 0 0 1-2.6 3.8M6.2 6.2C3.8 8.1 2.25 12 2.25 12S6 19.8 12 19.8a9 9 0 0 0 4-.9"
                            />
                        </svg>

                    </button>

                </div>

            </div>


            {{-- Information --}}
            <div class="mt-4
                        p-3
                        rounded-lg
                        bg-blue-50
                        dark:bg-blue-900/20
                        border
                        border-blue-100
                        dark:border-blue-800">

                <p class="text-xs
                          text-blue-700
                          dark:text-blue-300">

                    Password minimal 8 karakter. Setelah password direset,
                    user dapat langsung login menggunakan password baru.

                </p>

            </div>


            {{-- Action --}}
            <div class="flex
                        items-center
                        justify-end
                        gap-3
                        mt-6">

                <button
                    type="button"
                    onclick="closeResetPasswordModal()"
                    class="px-4 py-2.5
                           text-sm
                           font-medium
                           text-gray-700
                           bg-white
                           border
                           border-gray-300
                           rounded-lg
                           hover:bg-gray-50
                           dark:bg-gray-700
                           dark:text-gray-300
                           dark:border-gray-600
                           dark:hover:bg-gray-600
                           cursor-pointer"
                >

                    Batal

                </button>


                <button
                    type="submit"
                    class="inline-flex
                           items-center
                           gap-2
                           px-4 py-2.5
                           text-sm
                           font-medium
                           text-white
                           bg-amber-500
                           rounded-lg
                           hover:bg-amber-600
                           focus:ring-2
                           focus:ring-amber-400
                           cursor-pointer"
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
                            stroke-width="1.7"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                    Reset Password

                </button>

            </div>

        </form>

    </div>

</div>

</main>


@push('scripts')

<script>

    /*
    |--------------------------------------------------------------------------
    | URL Helper
    |--------------------------------------------------------------------------
    */

    function getUserIndexUrl()
    {
        return new URL(
            window.location.href
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Per Page
    |--------------------------------------------------------------------------
    */

    function updatePerPage(size)
    {
        const url =
            getUserIndexUrl();

        url.searchParams.set(
            'per_page',
            size
        );

        url.searchParams.delete(
            'page'
        );

        window.location.href =
            url.toString();
    }


    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    function searchTable()
    {
        const url =
            getUserIndexUrl();

        const search =
            document
                .getElementById(
                    'search-input'
                )
                .value
                .trim();


        if (search) {

            url.searchParams.set(
                'search',
                search
            );

        } else {

            url.searchParams.delete(
                'search'
            );

        }


        url.searchParams.delete(
            'page'
        );

        window.location.href =
            url.toString();
    }


    function applyFilters()
    {
        const url =
            getUserIndexUrl();

        url.searchParams.delete(
            'page'
        );

        window.location.href =
            url.toString();
    }


    /*
    |--------------------------------------------------------------------------
    | Reset Filter
    |--------------------------------------------------------------------------
    */

    function resetFilters()
    {
        const url =
            new URL(
                "{{ route('users.index') }}"
            );

        const current =
            getUserIndexUrl();

        const perPage =
            current.searchParams.get(
                'per_page'
            );


        if (perPage) {

            url.searchParams.set(
                'per_page',
                perPage
            );

        }


        window.location.href =
            url.toString();
    }


    /*
    |--------------------------------------------------------------------------
    | Search Enter
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function ()
        {
            const searchInput =
                document.getElementById(
                    'search-input'
                );


            if (searchInput) {

                searchInput.addEventListener(
                    'keydown',
                    function (event)
                    {
                        if (
                            event.key === 'Enter'
                        ) {

                            event.preventDefault();

                            searchTable();
                        }
                    }
                );
            }
        }
    );


    /*
    |--------------------------------------------------------------------------
    | Delete Modal
    |--------------------------------------------------------------------------
    */

    let deleteUserFormId = null;


    function openDeleteUserModal(
        formId,
        userName
    ) {
        deleteUserFormId =
            formId;

        document
            .getElementById(
                'delete-user-name'
            )
            .textContent =
                userName;


        const modal =
            document.getElementById(
                'delete-user-modal'
            );

        modal.classList.remove(
            'hidden'
        );

        modal.classList.add(
            'flex'
        );
    }


    function closeDeleteUserModal()
    {
        deleteUserFormId =
            null;

        const modal =
            document.getElementById(
                'delete-user-modal'
            );

        modal.classList.add(
            'hidden'
        );

        modal.classList.remove(
            'flex'
        );
    }


    function confirmDeleteUser()
    {
        if (!deleteUserFormId) {
            return;
        }

        const form =
            document.getElementById(
                deleteUserFormId
            );

        if (form) {
            form.submit();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Close Delete Modal
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function ()
        {
            const modal =
                document.getElementById(
                    'delete-user-modal'
                );

            if (!modal) {
                return;
            }

            modal.addEventListener(
                'click',
                function (event)
                {
                    if (
                        event.target === modal
                    ) {
                        closeDeleteUserModal();
                    }
                }
            );
        }
    );


    document.addEventListener(
        'keydown',
        function (event)
        {
            if (
                event.key === 'Escape'
            ) {
                closeDeleteUserModal();
            }
        }
    );

		 /*
    |--------------------------------------------------------------------------
    | Reset Password Modal
    |--------------------------------------------------------------------------
    */

    function openResetPasswordModal(
        userId,
        userName,
        actionUrl
    ) {
        const modal =
            document.getElementById(
                'reset-password-modal'
            );

        const form =
            document.getElementById(
                'reset-password-form'
            );

        const userNameElement =
            document.getElementById(
                'reset-password-user-name'
            );


        /*
        | Set action URL
        */

        form.action =
            actionUrl;


        /*
        | Set User Name
        */

        userNameElement.textContent =
            userName;


        /*
        | Reset inputs
        */

        document
            .getElementById(
                'reset-password'
            )
            .value = '';

        document
            .getElementById(
                'reset-password-confirmation'
            )
            .value = '';


        /*
        | Password kembali hidden
        */

        resetPasswordVisibility();


        /*
        | Show Modal
        */

        modal.classList.remove(
            'hidden'
        );

        modal.classList.add(
            'flex'
        );


        /*
        | Focus
        */

        setTimeout(
            function ()
            {
                document
                    .getElementById(
                        'reset-password'
                    )
                    .focus();
            },
            100
        );
    }


    function closeResetPasswordModal()
    {
        const modal =
            document.getElementById(
                'reset-password-modal'
            );

        modal.classList.add(
            'hidden'
        );

        modal.classList.remove(
            'flex'
        );


        /*
        | Bersihkan form
        */

        document
            .getElementById(
                'reset-password'
            )
            .value = '';

        document
            .getElementById(
                'reset-password-confirmation'
            )
            .value = '';


        resetPasswordVisibility();
    }


    /*
    |--------------------------------------------------------------------------
    | Show / Hide Password
    |--------------------------------------------------------------------------
    */

    function toggleResetPassword(
        inputId,
        eyeOpenId,
        eyeCloseId
    ) {
        const input =
            document.getElementById(
                inputId
            );

        const eyeOpen =
            document.getElementById(
                eyeOpenId
            );

        const eyeClose =
            document.getElementById(
                eyeCloseId
            );


        if (
            input.type === 'password'
        ) {

            input.type =
                'text';

            eyeOpen.classList.add(
                'hidden'
            );

            eyeClose.classList.remove(
                'hidden'
            );

        } else {

            input.type =
                'password';

            eyeOpen.classList.remove(
                'hidden'
            );

            eyeClose.classList.add(
                'hidden'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Reset Eye State
    |--------------------------------------------------------------------------
    */

    function resetPasswordVisibility()
    {
        const password =
            document.getElementById(
                'reset-password'
            );

        const confirmation =
            document.getElementById(
                'reset-password-confirmation'
            );


        password.type =
            'password';

        confirmation.type =
            'password';


        document
            .getElementById(
                'reset-eye-open'
            )
            .classList
            .remove('hidden');

        document
            .getElementById(
                'reset-eye-close'
            )
            .classList
            .add('hidden');


        document
            .getElementById(
                'reset-confirm-eye-open'
            )
            .classList
            .remove('hidden');

        document
            .getElementById(
                'reset-confirm-eye-close'
            )
            .classList
            .add('hidden');
    }


    /*
    |--------------------------------------------------------------------------
    | Close Modal Click Outside
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'DOMContentLoaded',
        function ()
        {
            const modal =
                document.getElementById(
                    'reset-password-modal'
                );

            if (!modal) {
                return;
            }


            modal.addEventListener(
                'click',
                function (event)
                {
                    if (
                        event.target === modal
                    ) {
                        closeResetPasswordModal();
                    }
                }
            );
        }
    );


    /*
    |--------------------------------------------------------------------------
    | ESC
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event)
        {
            if (
                event.key === 'Escape'
            ) {

                const modal =
                    document.getElementById(
                        'reset-password-modal'
                    );

                if (
                    modal
                    && !modal.classList.contains(
                        'hidden'
                    )
                ) {
                    closeResetPasswordModal();
                }
            }
        }
    );


</script>

@endpush

@endsection