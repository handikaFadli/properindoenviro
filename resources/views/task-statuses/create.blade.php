<div id="create-modal"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div id="create-modal-content"
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
                              d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>

                    </svg>

                </div>

                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        Tambah Status Tugas
                    </h3>

                    <p class="text-xs text-gray-400">
                        Tambahkan data status tugas baru
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
        <form action="{{ route('task-statuses.store') }}" method="POST">

            @csrf

            <div class="p-6 space-y-4">

                {{-- Code --}}
                <div>
                    <label for="task_status_code"
                           class="block mb-1.5 text-sm font-medium
                                  text-gray-700 dark:text-gray-300">

                        Kode Status
                        <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="text"
                        name="code"
                        id="task_status_code"
                        value="{{ old('code') }}"
                        placeholder="Contoh: in_progress"
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
                               @error('code') border-red-500 @enderror"
                    >

                    @error('code')
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

                {{-- Name --}}
                <div>
                    <label for="task_status_name"
                           class="block mb-1.5 text-sm font-medium
                                  text-gray-700 dark:text-gray-300">

                        Nama Status
                        <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="text"
                        name="name"
                        id="task_status_name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Sedang Dikerjakan"
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
                               @error('name') border-red-500 @enderror"
                    >

                    @error('name')
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

                {{-- Color --}}
                <div>
                    <label for="task_status_color"
                           class="block mb-1.5 text-sm font-medium
                                  text-gray-700 dark:text-gray-300">

                        Warna

                    </label>

                    <select
                        name="color"
                        id="task_status_color"
                        class="block w-full px-3 py-2.5 text-sm
                               text-gray-900 bg-gray-50
                               border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-primary-500
                               focus:border-primary-500
                               dark:bg-gray-700
                               dark:border-gray-600
                               dark:text-white
                               transition">

                        <option value="">Pilih Warna</option>
                        <option value="gray" @selected(old('color') === 'gray')>Abu-abu</option>
                        <option value="blue" @selected(old('color') === 'blue')>Biru</option>
                        <option value="green" @selected(old('color') === 'green')>Hijau</option>
                        <option value="yellow" @selected(old('color') === 'yellow')>Kuning</option>
                        <option value="red" @selected(old('color') === 'red')>Merah</option>
                        <option value="purple" @selected(old('color') === 'purple')>Ungu</option>

                    </select>
                </div>

                {{-- Sort Order --}}
                <div>
                    <label for="task_status_sort_order"
                           class="block mb-1.5 text-sm font-medium
                                  text-gray-700 dark:text-gray-300">

                        Urutan

                    </label>

                    <input
                        type="number"
                        name="sort_order"
                        id="task_status_sort_order"
                        value="{{ old('sort_order', 0) }}"
                        min="0"

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
                </div>

                {{-- Status Aktif --}}
                <div>
                    <label for="task_status_is_active"
                           class="block mb-1.5 text-sm font-medium
                                  text-gray-700 dark:text-gray-300">

                        Status Data

                    </label>

                    <select
                        name="is_active"
                        id="task_status_is_active"
                        class="block w-full px-3 py-2.5 text-sm
                               text-gray-900 bg-gray-50
                               border border-gray-300 rounded-lg
                               focus:ring-2 focus:ring-primary-500
                               focus:border-primary-500
                               dark:bg-gray-700
                               dark:border-gray-600
                               dark:text-white
                               transition">

                        <option value="1" @selected(old('is_active', 1) == 1)>
                            Aktif
                        </option>

                        <option value="0" @selected(old('is_active') === '0')>
                            Non Aktif
                        </option>

                    </select>
                </div>

            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3
                        px-6 py-4
                        border-t border-gray-200 dark:border-gray-700">

                <button
                    type="button"
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

                    Simpan

                </button>

            </div>

        </form>

    </div>
</div>