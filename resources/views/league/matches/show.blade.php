{{-- resources/views/league/matches/show.blade.php --}}
<x-layouts.app :title="$leagueMatch->homeTeam->name . ' vs ' . $leagueMatch->awayTeam->name">
    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6">
    <h1 class="text-xl font-bold mb-4">
        {{ $leagueMatch->homeTeam->name }} vs {{ $leagueMatch->awayTeam->name }}
        — {{ $leagueMatch->match_date->format('M j, Y') }}
    </h1>

    @foreach ([1, 2, 3, 4] as $round)
        @php
            $games = in_array($round, [1,4])
                ? $leagueMatch->doublesGames->where('round_number', $round)
                : $leagueMatch->singlesGames->where('round_number', $round);
            $totals = $leagueMatch->roundTotals($round);
        @endphp

        <h2 class="font-semibold mt-6 mb-2">Round {{ $round }}</h2>

        @foreach ($games as $game)
            <div class="grid grid-cols-2 gap-4 border-b py-2">
                <div class="{{ $game->home_points > $game->away_points ? 'text-green-600 font-semibold' : '' }}">
                    Home: {{ $game->home_points }} pts
                </div>
                <div class="{{ $game->away_points > $game->home_points ? 'text-green-600 font-semibold' : '' }}">
                    Away: {{ $game->away_points }} pts
                </div>
            </div>
        @endforeach

        <div class="font-bold mt-2">
            Round {{ $round }} Total —
            <span class="{{ $totals['home'] > $totals['away'] ? 'text-green-600' : '' }}">Home {{ $totals['home'] }}</span>
            /
            <span class="{{ $totals['away'] > $totals['home'] ? 'text-green-600' : '' }}">Away {{ $totals['away'] }}</span>
        </div>
    @endforeach

    @php $matchTotal = $leagueMatch->match_total; @endphp
    <h2 class="text-lg font-bold mt-6">
        Match Total —
        <span class="{{ $matchTotal['home'] > $matchTotal['away'] ? 'text-green-600' : '' }}">Home {{ $matchTotal['home'] }}</span>
        /
        <span class="{{ $matchTotal['away'] > $matchTotal['home'] ? 'text-green-600' : '' }}">Away {{ $matchTotal['away'] }}</span>
    </h2>
    </div>
</x-layouts.app>
