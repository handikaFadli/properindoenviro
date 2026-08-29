{{-- =========================
    CREATE EMPLOYEE MODAL
========================= --}}
<div id="create-modal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div id="create-modal-content"
         class="bg-white dark:bg-gray-800 rounded-xl shadow-xl
                w-full max-w-2xl mx-4
                scale-95 opacity-0
                transition-all duration-200">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">

            <div class="flex items-center gap-3">

                <div class="flex items-center justify-center w-9 h-9
                            rounded-lg bg-primary-50 dark:bg-primary-900/30">

                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-400"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2m7-10a4 4 0 100-8 4 4 0 000 8zm8 4v6m3-3h-6"/>

                    </svg>

                </div>

                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        Tambah Karyawan
                    </h3>

                    <p class="text-xs text-gray-400">
                        Tambahkan data karyawan baru
                    </p>
                </div>

            </div>

            <button type="button"
                    onclick="closeCreateModal()"
                    class="p-2 text-gray-400 hover:text-gray-600
                           hover:bg-gray-100 dark:hover:bg-gray-700
                           rounded-lg transition cursor-pointer">

                <svg class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>

                </svg>

            </button>

        </div>


        {{-- Form --}}
        <form action="{{ route('employees.store') }}" method="POST">

            @csrf

            <div class="p-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Nama --}}
                    <div class="md:col-span-2">

                        <label for="employee_name"
                               class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">

                            Nama Karyawan
                            <span class="text-red-500">*</span>

                        </label>

                        <input type="text"
                               name="name"
                               id="employee_name"
                               value="{{ old('name') }}"
                               placeholder="Contoh: Ahmad Fauzan"
                               autocomplete="off"

                               class="block w-full px-3 py-2.5 text-sm
                                      text-gray-900 bg-gray-50
                                      border border-gray-300 rounded-lg
                                      focus:ring-2 focus:ring-primary-500
                                      focus:border-primary-500
                                      dark:bg-gray-700
                                      dark:border-gray-600
                                      dark:text-white
                                      dark:placeholder-gray-400
                                      transition
                                      @error('name') border-red-500 @enderror">

                        @error('name', 'createEmployee')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">

                                <svg class="w-3.5 h-3.5"
                                     fill="currentColor"
                                     viewBox="0 0 20 20">

                                    <path fill-rule="evenodd"
                                          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                          clip-rule="evenodd"/>

                                </svg>

                                {{ $message }}

                            </p>
                        @enderror

                    </div>


                    {{-- Departemen --}}
                    <div>

                        <label for="department_id"
                               class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">

                            Departemen
                            <span class="text-red-500">*</span>

                        </label>

                        <select name="department_id"
                                id="department_id"

                                class="block w-full px-3 py-2.5 text-sm
                                       text-gray-900 bg-gray-50
                                       border border-gray-300 rounded-lg
                                       focus:ring-2 focus:ring-primary-500
                                       focus:border-primary-500
                                       dark:bg-gray-700
                                       dark:border-gray-600
                                       dark:text-white
                                       transition
                                       @error('department_id') border-red-500 @enderror">

                            <option value="">
                                Pilih Departemen
                            </option>

                            @foreach ($departments as $department)

                                <option value="{{ $department->id }}"
                                    {{ old('department_id') == $department->id ? 'selected' : '' }}>

                                    {{ $department->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('department_id', 'createEmployee')
                            <p class="mt-1.5 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Posisi --}}
                    <div>

                        <label for="position_id"
                               class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">

                            Posisi
                            <span class="text-red-500">*</span>

                        </label>

                        <select name="position_id"
                                id="position_id"

                                class="block w-full px-3 py-2.5 text-sm
                                       text-gray-900 bg-gray-50
                                       border border-gray-300 rounded-lg
                                       focus:ring-2 focus:ring-primary-500
                                       focus:border-primary-500
                                       dark:bg-gray-700
                                       dark:border-gray-600
                                       dark:text-white
                                       transition
                                       @error('position_id') border-red-500 @enderror">

                            <option value="">
                                Pilih Posisi
                            </option>

                            @foreach ($positions as $position)

                                <option value="{{ $position->id }}"
                                        data-department="{{ $position->department_id }}"
                                    {{ old('position_id') == $position->id ? 'selected' : '' }}>

                                    {{ $position->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('position_id', 'createEmployee')
                            <p class="mt-1.5 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Email --}}
                    <div>

                        <label for="employee_email"
                               class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">

                            Email
                            <span class="text-red-500">*</span>

                        </label>

                        <input type="email"
                               name="email"
                               id="employee_email"
                               value="{{ old('email') }}"
                               placeholder="Contoh: ahmad@company.com"
                               autocomplete="off"

                               class="block w-full px-3 py-2.5 text-sm
                                      text-gray-900 bg-gray-50
                                      border border-gray-300 rounded-lg
                                      focus:ring-2 focus:ring-primary-500
                                      focus:border-primary-500
                                      dark:bg-gray-700
                                      dark:border-gray-600
                                      dark:text-white
                                      dark:placeholder-gray-400
                                      transition
                                      @error('email') border-red-500 @enderror">

                        @error('email', 'createEmployee')
                            <p class="mt-1.5 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Status --}}
                    <div>

                        <label for="employee_status"
                               class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">

                            Status
                            <span class="text-red-500">*</span>

                        </label>

                        <select name="status"
                                id="employee_status"

                                class="block w-full px-3 py-2.5 text-sm
                                       text-gray-900 bg-gray-50
                                       border border-gray-300 rounded-lg
                                       focus:ring-2 focus:ring-primary-500
                                       focus:border-primary-500
                                       dark:bg-gray-700
                                       dark:border-gray-600
                                       dark:text-white
                                       transition
                                       @error('status') border-red-500 @enderror">

                            <option value="">
                                Pilih Status
                            </option>

                            <option value="active"
                                {{ old('status') === 'active' ? 'selected' : '' }}>

                                Aktif

                            </option>

                            <option value="inactive"
                                {{ old('status') === 'inactive' ? 'selected' : '' }}>

                                Non Aktif

                            </option>

                        </select>

                        @error('status', 'createEmployee')
                            <p class="mt-1.5 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3
                        px-6 py-4
                        border-t border-gray-200 dark:border-gray-700">

                <button type="button"
                        onclick="closeCreateModal()"

                        class="px-4 py-2.5
                               text-sm font-medium
                               text-gray-700
                               bg-gray-100
                               hover:bg-gray-200
                               rounded-lg
                               transition
                               cursor-pointer">

                    Batal

                </button>


                <button type="submit"

                        class="inline-flex items-center gap-2
                               px-4 py-2.5
                               text-sm font-medium
                               text-white
                               bg-primary-600
                               hover:bg-primary-700
                               rounded-lg
                               focus:outline-none
                               focus:ring-2
                               focus:ring-primary-500
                               transition
                               cursor-pointer">

                    <svg class="w-4 h-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5 13l4 4L19 7"/>

                    </svg>

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>