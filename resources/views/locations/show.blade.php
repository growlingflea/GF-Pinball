<x-layouts.app>
    <div class="location-header">
        <h1>{{ $location->name }}</h1>
    </div>

    <div class="games-grid">
        @foreach ($games as $game)
            @php
                $isBuiltOut = $game->has_simulator || $game->cheat_sheet_pdf || $game->cheat_sheet_png;
            @endphp
            <a href="{{ route('games.show', $game) }}" class="game-card @unless($isBuiltOut) game-card--coming-soon @endunless">
                @if ($game->cheat_sheet_png)
                    <img src="{{ asset('storage/' . $game->cheat_sheet_png) }}" alt="{{ $game->name }}" class="game-card__thumb">
                @else
                    <div class="game-card__thumb game-card__thumb--placeholder">{{ $game->name }}</div>
                @endif
                <div class="game-card__body">
                    <h2>{{ $game->name }}</h2>
                    <p>{{ $game->manufacturer }} @if($game->year) · {{ $game->year }} @endif</p>
                    @unless ($isBuiltOut)
                        <span class="game-card__badge">Coming soon</span>
                    @endunless
                    <span class="game-card__details-link">Machine details</span>
                </div>
            </a>
        @endforeach
    </div>
</x-layouts.app>
