<div class="lg:ml-64">
  <nav
    class="fixed top-0 left-0 right-0 z-30 bg-gradient-to-br from-primary-600 via-primary-600 to-primary-700  px-4 py-3 flex justify-between items-center lg:left-64">
    <div class="flex items-center gap-2">
      <button type="button" data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar"
        class="lg:hidden text-primary-100 hover:text-primary-600 hover:bg-primary-100 transition duration-200 border px-2 py-1 rounded-lg focus:outline-none">
        <i class="fa-solid fa-bars"></i>
      </button>
      {{-- <span class="text-lg font-semibold text-white">Welcome</span> --}}
    </div>
    <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
      <button type="button"
        class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
        data-dropdown-placement="bottom">
        <span class="sr-only">Open user menu</span>
        <i class="fa-solid fa-circle-user text-primary-300 text-2xl"></i>
      </button>
      <!-- Dropdown menu -->
      <div
        class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600"
        id="user-dropdown">
        <div class="px-4 py-3">
          <span class="block text-sm text-gray-900 dark:text-white">{{ auth()->user()->name }}</span>
          <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">{{ auth()->user()->email }}</span>
        </div>
        <ul class="py-2" aria-labelledby="user-menu-button">
          {{-- <li>
            <a href="#"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
          </li>
          <li>
            <a href="#"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Settings</a>
          </li>
          <li>
            <a href="#"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Earnings</a>
          </li> --}}
          <li>
            <a href="/logout"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Keluar</a>
          </li>
        </ul>
      </div>

    </div>
  </nav>
</div>