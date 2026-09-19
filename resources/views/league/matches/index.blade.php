<x-layouts.app title="League matches">
    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-bold">League matches</h1>
            <a href="{{ route('league.matches.create') }}" class="text-blue-600 hover:underline">+ New match</a>
        </div>

        @if (session('status'))
            <div class="mb-4 text-green-600">{{ session('status') }}</div>
        @endif

        @if ($matches->isEmpty())
            <p class="text-gray-500">No matches yet.</p>
        @else
            <div class="divide-y">
                @foreach ($matches as $match)
                    @php $totals = $match->match_total; @endphp
                    <a href="{{ route('league.matches.show', $match) }}" class="flex justify-between py-3 hover:bg-gray-50">
                        <span>
                            {{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}
                            <span class="text-gray-500 text-sm">— {{ $match->match_date->format('M j, Y') }}</span>
                        </span>
                        <span class="{{ $totals['home'] > $totals['away'] ? 'font-semibold' : '' }}">
                            {{ $totals['home'] }} – {{ $totals['away'] }}
                        </span>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $matches->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
