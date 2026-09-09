@php
    $navItems = [
        ['route' => 'locations.index', 'label' => 'Locations'],
        ['route' => 'rulesheets.index', 'label' => 'Rulesheets'],
        ['route' => 'calendar.index', 'label' => 'Calendar'],
        ['route' => 'simulators.index', 'label' => 'Show Simulator'],
        ['route' => 'account.index', 'label' => 'Account'],
        ['route' => 'about.index', 'label' => 'About'],
    ];
@endphp

<nav class="bg-white border-b border-gray-200">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <a href="{{ route('games.index') }}" class="font-bold text-lg text-gray-800">
                GF-Pinball
            </a>

            <div class="hidden md:flex space-x-6">
                @foreach ($navItems as $item)
                    @php
                        $group = explode('.', $item['route'])[0];
                        $isActive = request()->routeIs("{$group}.*");
                    @endphp
                    <a href="{{ route($item['route']) }}"
                       class="text-sm font-medium {{ $isActive ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>

            <button id="nav-toggle" type="button" class="md:hidden p-2" aria-label="Toggle menu" aria-expanded="false">
                <svg id="nav-icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="nav-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <div id="nav-mobile-menu" class="hidden md:hidden border-t border-gray-200">
        <div class="px-4 py-3 space-y-1">
            @foreach ($navItems as $item)
                <a href="{{ route($item['route']) }}" class="block py-2 text-sm font-medium text-gray-600 hover:text-gray-900">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('nav-toggle');
        const menu = document.getElementById('nav-mobile-menu');
        const iconOpen = document.getElementById('nav-icon-open');
        const iconClose = document.getElementById('nav-icon-close');

        if (!toggle || !menu) return;

        toggle.addEventListener('click', function () {
            const nowHidden = menu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden', !nowHidden);
            iconClose.classList.toggle('hidden', nowHidden);
            toggle.setAttribute('aria-expanded', String(!nowHidden));
        });
    });
</script>
