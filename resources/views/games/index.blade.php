<x-layouts.app>
    <div class="games-grid">
        @foreach ($games as $game)
            <a href="{{ route('games.show', $game) }}" class="game-card">
                @if ($game->cheat_sheet_png)
                    <img src="{{ asset('storage/' . $game->cheat_sheet_png) }}" alt="{{ $game->name }}" class="game-card__thumb">
                @else
                    <div class="game-card__thumb game-card__thumb--placeholder">{{ $game->name }}</div>
                @endif
                <div class="game-card__body">
                    <h2>{{ $game->name }}</h2>
                    <p>{{ $game->manufacturer }} @if($game->year) · {{ $game->year }} @endif</p>
                </div>
            </a>
        @endforeach
    </div>
</x-layouts.app>
