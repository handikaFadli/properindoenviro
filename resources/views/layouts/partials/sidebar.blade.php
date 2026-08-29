@php
$currentPath = request()->segment(2) ?? 'dashboard';
$user = Auth::user();
$isMasterData = request()->is('departments*') || request()->is('positions*') || request()->is('roles*') || request()->is('task-statuses*') || request()->is('task-priorities*');

@endphp

<aside id="sidebar" class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width" aria-label="Sidebar">
  <div class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
      <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

        {{-- ─── INFO USER DI SIDEBAR ─── --}}
        <div class="pb-3 px-3 border-b border-gray-200 dark:border-gray-700">
          <div class="flex items-center space-x-3">
            @if ($user->avatar)
              <img class="w-10 h-10 rounded-full" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
            @else
              <div class="w-10 h-10 rounded-full bg-primary-600 flex items-center justify-center text-white font-bold text-lg">
                {{ strtoupper(substr($user->name, 0, 1)) }}
              </div>
            @endif
            <div class="flex-1 min-w-0">
              <p class="text-sm font-semibold text-gray-900 truncate dark:text-white">{{ $user->name }}</p>
              <p class="text-xs text-gray-500 truncate dark:text-gray-400">{{ $user->email }}</p>
            </div>
          </div>
          @php
              $roleName = $user->roleName() ?? 'Tanpa Role';
          @endphp

          <div class="mt-2">
              <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                  bg-green-100 text-green-800
                  dark:bg-green-900 dark:text-green-200"
              >
                  {{ $roleName }}
              </span>
          </div>
        </div>

        <ul class="pb-2 space-y-2 pt-3">
          {{-- ─── DASHBOARD ─── --}}
          <li>
            <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group {{ request()->is('/') ? 'bg-gray-100 dark:bg-gray-700' : '' }} dark:text-gray-200 dark:hover:bg-gray-700">
                <svg class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                <span class="ml-3" sidebar-toggle-item>Dashboard</span>
            </a>
          </li>
          @if($user->isAdmin())
            <li>
              <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 cursor-pointer {{ $isMasterData ? 'bg-gray-100 dark:bg-gray-700' : '' }}" aria-controls="dropdown-master" data-collapse-toggle="dropdown-master">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 6c0 1.657-3.134 3-7 3S5 7.657 5 6m14 0c0-1.657-3.134-3-7-3S5 4.343 5 6m14 0v6M5 6v6m0 0c0 1.657 3.134 3 7 3s7-1.343 7-3M5 12v6c0 1.657 3.134 3 7 3s7-1.343 7-3v-6"/>
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Master Data</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
              </button>
                <ul id="dropdown-master" class="{{ $isMasterData ? '' : 'hidden' }} py-2 space-y-2">
                  <li>
                    <a href="/departments" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->is('departments*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">Departemen</a>
                  </li>
                  <li>
                    <a href="/positions" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->is('positions*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">Posisi</a>
                  </li>
                  <li>
                    <a href="/roles" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->is('roles*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">Role</a>
                  </li>
                  <li>
                    <a href="/task-statuses" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->is('task-statuses*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">Status Tugas</a>
                  </li>
                  <li>
                    <a href="/task-priorities" class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->is('task-priorities*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">Prioritas Tugas</a>
                  </li>
                </ul>
            </li>
          @endif
          @if(
              $user->isAdmin()
              || $user->isManagement()
          )
            <li>
              <a href="/employees" class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group {{ $currentPath === 'employees' ? 'bg-gray-100 dark:bg-gray-700' : '' }} dark:text-gray-200 dark:hover:bg-gray-700">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.079 6.839a3 3 0 0 0-4.255.1M13 20h1.083A3.916 3.916 0 0 0 18 16.083V9A6 6 0 1 0 6 9v7m7 4v-1a1 1 0 0 0-1-1h-1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1Zm-7-4v-6H5a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h1Zm12-6h1a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-1v-6Z"/>
                </svg>
                <span class="ml-3" sidebar-toggle-item>Daftar Karyawan</span>
              </a>
            </li>
          @endif
            <li>
              <a href="/tasks" class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group {{ $currentPath === 'tasks' ? 'bg-gray-100 dark:bg-gray-700' : '' }} dark:text-gray-200 dark:hover:bg-gray-700">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.079 6.839a3 3 0 0 0-4.255.1M13 20h1.083A3.916 3.916 0 0 0 18 16.083V9A6 6 0 1 0 6 9v7m7 4v-1a1 1 0 0 0-1-1h-1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1Zm-7-4v-6H5a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h1Zm12-6h1a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-1v-6Z"/>
                </svg>
                <span class="ml-3" sidebar-toggle-item>Monitoring Tugas</span>
              </a>
            </li>
        <div class="pt-2 space-y-2"> 
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="flex items-center w-full p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700 cursor-pointer">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2"></path>
                </svg>
                <span class="ml-3" sidebar-toggle-item>Logout</span>
              </button>
            </form>
          </li>
        </div>

      </div>
    </div>
  </div>
</aside>

<div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>
