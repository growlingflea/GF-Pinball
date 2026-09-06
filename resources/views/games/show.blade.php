<x-layouts.app>
    <div class="game-detail">
        <h1>{{ $game->name }}</h1>
        <p>{{ $game->manufacturer }} @if($game->year) · {{ $game->year }} @endif</p>

        <nav class="game-detail__nav">
            <a href="{{ route('games.cheat-sheet', $game) }}">Cheat Sheet</a>
            <a href="{{ route('games.simulator', $game) }}">Combo Simulator</a>
            <a href="{{ route('games.comments', $game) }}">Comments</a>
        </nav>
    </div>
</x-layouts.app>
