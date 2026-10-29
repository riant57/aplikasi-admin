<aside class="w-64 min-h-screen bg-gray-900 text-white p-5 shrink-0">

    <div class="text-xl font-bold mb-8">
        Aplikasi Admin
    </div>

    <nav class="space-y-2">

        {{-- Dashboard --}}
        @can('dashboard.view')
            <a href="{{ route('home') }}"
               class="block px-4 py-3 rounded-lg hover:bg-gray-700">
                Dashboard
            </a>
        @endcan

        {{-- Users --}}
        @can('users.view')
            <a href="{{ url('/users') }}"
               class="block px-4 py-3 rounded-lg hover:bg-gray-700">
                Users
            </a>
        @endcan

        {{-- Roles --}}
        @can('roles.view')
            <a href="{{ route('roles.index') }}"
               class="block px-4 py-3 rounded-lg hover:bg-gray-700">
                Roles
            </a>
        @endcan

        {{-- Permissions --}}
        @can('permissions.view')
            <a href="{{ route('permissions.index') }}"
            class="block px-4 py-3 rounded-lg hover:bg-gray-700">
                Permissions
            </a>
        @endcan

        {{-- Branches --}}
        @can('branches.view')
            <a href="{{ route('branches.index') }}"
            class="block px-4 py-3 rounded-lg hover:bg-gray-700">
                Branches
            </a>
        @endcan

    </nav>

    <div class="border-t border-gray-700 mt-8 pt-4">
        <p class="text-sm text-gray-300 mb-3">
            Login sebagai:
            <br>
            <strong>{{ auth()->user()->name }}</strong>
        </p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                    class="w-full text-left px-4 py-2 rounded-lg text-red-300 hover:bg-gray-700">
                Logout
            </button>
        </form>
    </div>

</aside>