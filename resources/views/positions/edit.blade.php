{{-- =========================
    EDIT POSITION MODAL
========================= --}}
<div id="edit-modal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div id="edit-modal-content"
         class="bg-white dark:bg-gray-800 rounded-xl shadow-xl
                w-full max-w-md mx-4
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
                              d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>

                    </svg>

                </div>

                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        Edit Posisi
                    </h3>

                    <p class="text-xs text-gray-400">
                        Ubah data posisi
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
        <form id="edit-position-form"
              action=""
              method="POST">

            @csrf
            @method('PUT')

            <div class="p-6 space-y-4">

                <div>
                    <label for="edit_position_name"
                           class="block mb-1.5 text-sm font-medium
                                  text-gray-700 dark:text-gray-300">

                        Nama Posisi
                        <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="text"
                        name="name"
                        id="edit_position_name"
                        placeholder="Contoh: Programmer Junior"
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
                               transition"
                    >

                    <p id="edit-name-error"
                       class="hidden mt-1.5 text-xs text-red-500 items-center gap-1">

                        <svg class="w-3.5 h-3.5"
                             fill="currentColor"
                             viewBox="0 0 20 20">

                            <path fill-rule="evenodd"
                                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                  clip-rule="evenodd"/>

                        </svg>

                        <span id="edit-name-error-message"></span>

                    </p>

                </div>

                <div>
                    <label for="edit_position_department_id"
                           class="block mb-1.5 text-sm font-medium
                                  text-gray-700 dark:text-gray-300">

                        Departemen
                        <span class="text-red-500">*</span>

                    </label>

                    <select
                        name="department_id"
                        id="edit_position_department_id"

                        class="block w-full px-3 py-2.5 text-sm
                               text-gray-900 bg-gray-50
                               border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-primary-500
                               focus:border-primary-500
                               dark:bg-gray-700
                               dark:border-gray-600
                               dark:text-white
                               transition"
                    >
                        <option value="">Pilih departemen</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="edit_position_role_id"
                           class="block mb-1.5 text-sm font-medium
                                  text-gray-700 dark:text-gray-300">

                        Role
                        <span class="text-red-500">*</span>

                    </label>

                    <select
                        name="role_id"
                        id="edit_position_role_id"

                        class="block w-full px-3 py-2.5 text-sm
                               text-gray-900 bg-gray-50
                               border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-primary-500
                               focus:border-primary-500
                               dark:bg-gray-700
                               dark:border-gray-600
                               dark:text-white
                               transition"
                    >
                        <option value="">Pilih role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3
                        px-6 py-4
                        border-t border-gray-200 dark:border-gray-700">

                <button
                    type="button"
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

                <button
                    type="submit"
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
