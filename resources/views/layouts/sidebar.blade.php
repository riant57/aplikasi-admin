<aside class="w-64 min-h-screen bg-gray-900 text-white p-5 shrink-0">

    <div class="text-xl font-bold mb-8">
        Aplikasi Admin
    </div>

    <nav class="space-y-2">
        @foreach (config('menu') as $menu)
            {{-- Menu biasa --}}
            @if (isset($menu['route']))
                @can($menu['permission'])
                    <a href="{{ route($menu['route']) }}"
                    class="block px-4 py-3 rounded-lg
                    {{ request()->routeIs($menu['route']) ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                        {{ $menu['label'] }}
                    </a>
                @endcan
            {{-- Menu dengan submenu --}}
            @elseif (isset($menu['children']))
                @php
                    $visibleChildren = collect($menu['children'])
                        ->filter(fn ($child) => auth()->user()->can($child['permission']));
                    $isActive = $visibleChildren->contains(
                        fn ($child) => request()->routeIs($child['route'])
                    );
                @endphp
                @if ($visibleChildren->isNotEmpty())
                    <div class="mt-4"
                        x-data="{ open: {{ $isActive ? 'true' : 'false' }} }">
                        <button type="button"
                                @click="open = !open"
                                class="w-full flex items-center justify-between px-4 py-2 text-xs font-semibold uppercase tracking-wider text-gray-400 hover:text-white">

                            {{ $menu['label'] }}

                            <svg class="w-4 h-4 transition-transform"
                                :class="{ 'rotate-180': open }"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open"
                            x-transition
                            class="mt-1">
                            @foreach ($visibleChildren as $child)

                                <a href="{{ route($child['route']) }}"
                                class="block px-4 py-3 ml-2 rounded-lg
                                {{ request()->routeIs($child['route']) ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">

                                    {{ $child['label'] }}

                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
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