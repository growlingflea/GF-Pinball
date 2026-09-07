<x-layouts.app>
    <div class="simulator-page">
        <h1>{{ $game->name }} — Combo Simulator</h1>

        <nav class="view-switch">
            <a href="{{ route('games.simulator', $game) }}" class="view-switch__link view-switch__link--active">Simulator</a>
            <a href="{{ route('games.playfield', $game) }}" class="view-switch__link">Playfield</a>
        </nav>

        <div class="simulator-page__frame">
            <iframe
                src="{{ asset('game-assets/' . $game->slug . '/simulator.html') }}"
                title="{{ $game->name }} combo simulator"
                loading="lazy">
            </iframe>
        </div>
    </div>
</x-layouts.app>
