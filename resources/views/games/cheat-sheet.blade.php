<x-layouts.app>
    <div class="cheat-sheet-page">
        <h1>{{ $game->name }} — Cheat Sheet</h1>

        @if ($game->cheat_sheet_png)
            <img src="{{ asset('storage/' . $game->cheat_sheet_png) }}"
                 alt="{{ $game->name }} cheat sheet"
                 class="cheat-sheet-page__image">
        @else
            <p>No cheat sheet uploaded yet.</p>
        @endif

        @if ($game->cheat_sheet_pdf)
            <a href="{{ asset('storage/' . $game->cheat_sheet_pdf) }}" class="cheat-sheet-page__download" download>
                Download printable PDF
            </a>
        @endif
    </div>
</x-layouts.app>
