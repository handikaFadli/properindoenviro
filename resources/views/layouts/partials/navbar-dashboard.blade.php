@php($navbarNotifications = auth()->user()->notifications()->latest()->take(5)->get())
@php($navbarUnreadCount = auth()->user()->unreadNotifications()->count())
<nav class="fixed z-30 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
  <div class="px-3 py-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">
      <div class="flex items-center justify-start">
        <button id="toggleSidebarMobile" type="button" onclick="toggleMobileSidebar()" aria-expanded="false" aria-controls="sidebar" class="p-2 text-gray-600 rounded cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
          <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
          <svg id="toggleSidebarMobileClose" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
        <a href="{{ url('/') }}" class="flex ml-2 md:mr-24">
          {{-- <img src="{{ asset('images/logo.png') }}" class="h-8 mr-3" alt="FlowBite Logo" /> --}}
          <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap text-primary-900 dark:text-white">properindoenviro</span>
        </a>
        <form action="#" method="GET" class="hidden lg:block lg:pl-3.5">
          <label for="topbar-search" class="sr-only">Search</label>
          <div class="relative mt-1 lg:w-96">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </div>
            <input type="text" name="email" id="topbar-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search">
          </div>
        </form>
      </div>
      <div class="flex items-center">
          <!-- Search mobile -->
          <button id="toggleSidebarMobileSearch" type="button" class="p-2 text-gray-500 rounded-lg lg:hidden hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            <span class="sr-only">Search</span>
            <!-- Search icon -->
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
          </button>
          <!-- Notifications -->
          <button type="button" data-dropdown-toggle="notification-dropdown" class="relative p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
            <span class="sr-only">View notifications</span>
            <!-- Bell icon -->
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
            <span data-notification-badge class="absolute top-1 right-1 min-w-4 px-1 text-[10px] leading-4 text-white bg-red-600 rounded-full {{ $navbarUnreadCount ? '' : 'hidden' }}">{{ $navbarUnreadCount }}</span>
          </button>
          <!-- Dropdown menu -->
          <div class="z-50 hidden w-80 sm:w-96 my-2 overflow-hidden text-base list-none bg-white rounded-xl shadow-2xl ring-1 ring-black/5 dark:bg-gray-700 origin-top-right absolute right-0" id="notification-dropdown">

            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-600">
              <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">Notifikasi</span>
              @if($navbarNotifications->whereNull('read_at')->count())
                <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-primary-50 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400">
                  {{ $navbarNotifications->whereNull('read_at')->count() }} baru
                </span>
              @endif
            </div>

            <div id="notification-list" class="max-h-80 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-600">
              @forelse($navbarNotifications as $notification)
                <a href="{{ route('notifications.read', $notification->id) }}"
                  class="flex gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-600 transition relative {{ is_null($notification->read_at) ? 'bg-primary-50/40 dark:bg-primary-900/10' : '' }}">
                  @if(is_null($notification->read_at))
                    <span class="absolute left-0 top-0 bottom-0 w-0.5 bg-primary-600"></span>
                  @endif
                  <div class="shrink-0 w-9 h-9 rounded-full bg-primary-50 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                  </div>
                  <div class="min-w-0 flex-1">
                    {{-- <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                      {{ $notification->data['type'] ?? 'Notifikasi' }}
                    </p> --}}
                    <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                      {{ $notification->data['message'] ?? '' }}
                    </p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                      {{ $notification->created_at->diffForHumans() }}
                    </p>
                  </div>
                </a>
              @empty
                <div id="notification-empty" class="px-4 py-8 text-sm text-center text-gray-400 dark:text-gray-500">
                  Belum ada notifikasi.
                </div>
              @endforelse
            </div>

            @if($navbarNotifications->isNotEmpty())
              <div class="border-t border-gray-100 dark:border-gray-600">
                <form method="POST" action="{{ route('notifications.read-all') }}">
                  @csrf @method('PATCH')
                  <button type="submit" class="w-full py-2.5 text-sm font-medium text-center text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                    Tandai semua sudah dibaca
                  </button>
                </form>
              </div>
            @endif
          </div>
          <div class="flex items-center ml-3">
            <div>
              <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button-2" aria-expanded="false" data-dropdown-toggle="dropdown-2">
                <span class="sr-only">Open user menu</span>
                @if (Auth::user()->avatar)
                  <img class="w-8 h-8 rounded-full" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="user photo">
                @else
                  <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white text-sm font-semibold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                  </div>
                @endif
              </button>
            </div>
            <!-- Dropdown menu -->
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-2">
              <div class="px-4 py-3" role="none">
                <p class="text-sm text-gray-900 dark:text-white" role="none">
                  {{ Auth::user()->name }}
                </p>
              </div>

                </li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 cursor-pointer" role="menuitem">
                      Logout
                    </button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
    </div>
  </div>
</nav>

<script>
    function toggleMobileSidebar(forceOpen) {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        const button = document.getElementById('toggleSidebarMobile');
        const hamburger = document.getElementById('toggleSidebarMobileHamburger');
        const closeIcon = document.getElementById('toggleSidebarMobileClose');

        if (!sidebar || !backdrop || !button || !hamburger || !closeIcon) return;

        const open = forceOpen ?? sidebar.classList.contains('hidden');
        sidebar.classList.toggle('hidden', !open);
        sidebar.classList.toggle('flex', open);
        backdrop.classList.toggle('hidden', !open);
        hamburger.classList.toggle('hidden', open);
        closeIcon.classList.toggle('hidden', !open);
        button.setAttribute('aria-expanded', String(open));
    }
</script>
