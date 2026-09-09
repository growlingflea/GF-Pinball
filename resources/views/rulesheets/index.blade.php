<x-layouts.app>
    <x-slot name="title">Rulesheets</x-slot>

    <div class="max-w-5xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Rulesheets</h1>

        <input
            type="text"
            id="rulesheet-search"
            placeholder="Search by title or manufacturer..."
            class="w-full rounded-lg border-gray-300 mb-2 px-4 py-2"
        >
        <p id="rulesheet-count" class="text-sm text-gray-500 mb-4">{{ $cards->count() }} machines</p>

        <div id="rulesheet-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($cards as $card)
                <a href="{{ $card['url'] }}"
                   class="game-card block rounded-lg border border-gray-200 hover:shadow-md transition overflow-hidden"
                   data-title="{{ Str::lower($card['title']) }}"
                   data-manufacturer="{{ Str::lower($card['manufacturer'] ?? '') }}">
                    <div class="aspect-video bg-gray-100 flex items-center justify-center overflow-hidden">
                        @if ($card['thumbnail'])
                            <img src="{{ $card['thumbnail'] }}" alt="{{ $card['title'] }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-4xl">🎰</span>
                        @endif
                    </div>
                    <div class="p-3">
                        <h2 class="font-semibold">{{ $card['title'] }}</h2>
                        <p class="text-sm text-gray-500">{{ $card['manufacturer'] }}</p>
                        @php
                            $badgeColors = [
                                'Simulator' => 'bg-emerald-100 text-emerald-700',
                                'Cheat Sheet' => 'bg-blue-100 text-blue-700',
                                'Rulesheet' => 'bg-amber-100 text-amber-700',
                                'Coming Soon' => 'bg-gray-100 text-gray-500',
                            ];
                        @endphp
                        <span class="inline-block mt-2 text-xs px-2 py-1 rounded-full {{ $badgeColors[$card['badge']] ?? 'bg-gray-100 text-gray-500' }}">
                            {{ $card['badge'] }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

        <p id="rulesheet-empty" class="text-center text-gray-400 mt-8 hidden">No machines match your search.</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('rulesheet-search');
            const cards = Array.from(document.querySelectorAll('.game-card'));
            const countEl = document.getElementById('rulesheet-count');
            const emptyEl = document.getElementById('rulesheet-empty');

            input.addEventListener('input', function () {
                const q = input.value.trim().toLowerCase();
                let visible = 0;

                cards.forEach(function (card) {
                    const match = !q
                        || card.dataset.title.includes(q)
                        || card.dataset.manufacturer.includes(q);

                    card.style.display = match ? '' : 'none';
                    if (match) visible++;
                });

                countEl.textContent = `${visible} of ${cards.length} machines`;
                emptyEl.classList.toggle('hidden', visible !== 0);
            });
        });
    </script>
</x-layouts.app>
