<x-layouts.app>
    <div class="playfield-page">
        <h1>{{ $game->name }} — Playfield</h1>

        <nav class="view-switch">
            <a href="{{ route('games.simulator', $game) }}" class="view-switch__link">Simulator</a>
            <a href="{{ route('games.playfield', $game) }}" class="view-switch__link view-switch__link--active">Playfield</a>
        </nav>

        @if ($game->playfield_image)
            <img src="{{ asset('storage/' . $game->playfield_image) }}"
                 alt="{{ $game->name }} full playfield"
                 class="playfield-page__image">
        @else
            <p>No playfield image uploaded yet.</p>
        @endif
    </div>
</x-layouts.app>
