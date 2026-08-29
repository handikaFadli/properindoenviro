
<div id="edit-modal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div id="edit-modal-content"
         class="bg-white dark:bg-gray-800 rounded-xl shadow-xl
                w-full max-w-2xl mx-4
                scale-95 opacity-0
                transition-all duration-200">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4
                    border-b border-gray-200 dark:border-gray-700">

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
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>

                    </svg>

                </div>

                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        Edit Karyawan
                    </h3>

                    <p class="text-xs text-gray-400">
                        Perbarui data karyawan
                    </p>
                </div>

            </div>

            <button type="button"
                    onclick="closeEditModal()"
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
        <form id="edit-employee-form"
              action=""
              method="POST">

            @csrf
            @method('PUT')

            <input type="hidden"
                   id="edit_employee_id"
                   name="employee_id">

            <div class="p-6">

							<input type="text"
								id="edit_employee_code"
								hidden

								class="block w-full px-3 py-2.5 text-sm
												text-gray-500 bg-gray-100
												border border-gray-300 rounded-lg
												cursor-not-allowed
												dark:bg-gray-700
												dark:border-gray-600
												dark:text-gray-400">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Nama --}}
                    <div class="md:col-span-2">

                        <label for="edit_employee_name"
                               class="block mb-1.5 text-sm font-medium
                                      text-gray-700 dark:text-gray-300">

                            Nama Karyawan
                            <span class="text-red-500">*</span>

                        </label>

                        <input type="text"
                               name="name"
                               id="edit_employee_name"
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
                                      transition">

                        @error('name', 'editEmployee')
														<p class="mt-1.5 text-xs text-red-500">
																{{ $message }}
														</p>
												@enderror

                    </div>


                    {{-- Department --}}
                    <div>

                        <label for="edit_department_id"
                               class="block mb-1.5 text-sm font-medium
                                      text-gray-700 dark:text-gray-300">

                            Departemen
                            <span class="text-red-500">*</span>

                        </label>

                        <select name="department_id"
                                id="edit_department_id"

                                class="block w-full px-3 py-2.5 text-sm
                                       text-gray-900 bg-gray-50
                                       border border-gray-300 rounded-lg
                                       focus:ring-2 focus:ring-primary-500
                                       focus:border-primary-500
                                       dark:bg-gray-700
                                       dark:border-gray-600
                                       dark:text-white
                                       transition">

                            <option value="">
                                Pilih Departemen
                            </option>

                            @foreach ($departments as $department)

                                <option value="{{ $department->id }}">
                                    {{ $department->name }}
                                </option>

                            @endforeach

                        </select>

                       @error('department_id', 'editEmployee')
														<p class="mt-1.5 text-xs text-red-500">
																{{ $message }}
														</p>
												@enderror

                    </div>


                    {{-- Position --}}
                    <div>

                        <label for="edit_position_id"
                               class="block mb-1.5 text-sm font-medium
                                      text-gray-700 dark:text-gray-300">

                            Posisi
                            <span class="text-red-500">*</span>

                        </label>

                        <select name="position_id"
                                id="edit_position_id"

                                class="block w-full px-3 py-2.5 text-sm
                                       text-gray-900 bg-gray-50
                                       border border-gray-300 rounded-lg
                                       focus:ring-2 focus:ring-primary-500
                                       focus:border-primary-500
                                       dark:bg-gray-700
                                       dark:border-gray-600
                                       dark:text-white
                                       transition">

                            <option value="">
                                Pilih Posisi
                            </option>

                            @foreach ($positions as $position)

                                <option value="{{ $position->id }}"
                                        data-department="{{ $position->department_id }}">

                                    {{ $position->name }}

                                </option>

                            @endforeach

                        </select>

                        @error('position_id', 'editEmployee')
														<p class="mt-1.5 text-xs text-red-500">
																{{ $message }}
														</p>
												@enderror

                    </div>


                    {{-- Email --}}
                    <div>

                        <label for="edit_employee_email"
                               class="block mb-1.5 text-sm font-medium
                                      text-gray-700 dark:text-gray-300">

                            Email
                            <span class="text-red-500">*</span>

                        </label>

                        <input type="email"
                               name="email"
                               id="edit_employee_email"
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
                                      transition">

                        @error('email', 'editEmployee')
														<p class="mt-1.5 text-xs text-red-500">
																{{ $message }}
														</p>
												@enderror

                    </div>


                    {{-- Status --}}
                    <div>

                        <label for="edit_employee_status"
                               class="block mb-1.5 text-sm font-medium
                                      text-gray-700 dark:text-gray-300">

                            Status
                            <span class="text-red-500">*</span>

                        </label>

                        <select name="status"
                                id="edit_employee_status"

                                class="block w-full px-3 py-2.5 text-sm
                                       text-gray-900 bg-gray-50
                                       border border-gray-300 rounded-lg
                                       focus:ring-2 focus:ring-primary-500
                                       focus:border-primary-500
                                       dark:bg-gray-700
                                       dark:border-gray-600
                                       dark:text-white
                                       transition">

                            <option value="">
                                Pilih Status
                            </option>

                            <option value="active">
                                Aktif
                            </option>

                            <option value="inactive">
                                Non Aktif
                            </option>

                        </select>

                        @error('status', 'editEmployee')
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
                        onclick="closeEditModal()"

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

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>
