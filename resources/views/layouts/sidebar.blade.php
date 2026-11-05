<aside class="w-64 min-h-screen bg-gray-900 text-white p-5 shrink-0">

    <div class="text-xl font-bold mb-8">
        Aplikasi Admin
    </div>

    <nav class="space-y-2">

        @foreach ($menus as $menu)

            @php
                $canViewMenu = empty($menu->permission_name)
                    || auth()->user()->can($menu->permission_name);

                $visibleChildren = $menu->children->filter(function ($child) {
                    return empty($child->permission_name)
                        || auth()->user()->can($child->permission_name);
                });

                $hasChildren = $canViewMenu && $visibleChildren->isNotEmpty();
            @endphp

            {{-- MENU UTAMA DENGAN SUBMENU --}}
            @if ($hasChildren)

                <div
                    x-data="{ open: {{ $visibleChildren->contains(fn ($child) => request()->routeIs($child->route)) ? 'true' : 'false' }} }"
                >

                    <button
                        type="button"
                        @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-2 rounded hover:bg-gray-700"
                    >
                        <span class="flex items-center gap-3">

                            @if ($menu->icon)
                                <i data-lucide="{{ $menu->icon }}" class="w-5 h-5"></i>
                            @endif

                            <span>{{ $menu->name }}</span>

                        </span>

                        <span
                            :class="open ? 'rotate-180' : ''"
                            class="transition-transform"
                        >
                            ▼
                        </span>
                    </button>

                    <div
                        x-show="open"
                        x-transition
                        class="ml-4 mt-2 space-y-1"
                    >

                        @foreach ($visibleChildren as $child)

                            <a
                                href="{{ route($child->route) }}"
                                class="flex items-center gap-3 px-4 py-2 rounded
                                    {{ request()->routeIs($child->route)
                                        ? 'bg-blue-600 text-white'
                                        : 'hover:bg-gray-700' }}"
                            >
                                @if ($child->icon)
                                    <i data-lucide="{{ $child->icon }}" class="w-4 h-4"></i>
                                @endif

                                <span>{{ $child->name }}</span>
                            </a>

                        @endforeach

                    </div>

                </div>

            {{-- MENU UTAMA TANPA SUBMENU --}}
            @elseif ($canViewMenu && $menu->route)

                <a
                    href="{{ route($menu->route) }}"
                    class="flex items-center gap-3 px-4 py-2 rounded
                        {{ request()->routeIs($menu->route)
                            ? 'bg-blue-600 text-white'
                            : 'hover:bg-gray-700' }}"
                >
                    @if ($menu->icon)
                        <i data-lucide="{{ $menu->icon }}" class="w-5 h-5"></i>
                    @endif

                    <span>{{ $menu->name }}</span>
                </a>

            @endif

        @endforeach

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