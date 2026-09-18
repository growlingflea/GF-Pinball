{{-- resources/views/league/matches/partials/singles-game.blade.php --}}
<div class="border rounded p-4 mb-4">
    <input type="hidden" name="singles[{{ $index }}][round_number]" value="{{ $roundNumber }}">
    <input type="hidden" name="singles[{{ $index }}][game_number]" value="{{ $gameNumber }}">

    <div class="text-sm text-gray-500 mb-2">Game {{ $gameNumber }}</div>
    <input type="text" name="singles[{{ $index }}][machine_name]" placeholder="Machine name"
           value="{{ old("singles.$index.machine_name", $existing->machine_name ?? '') }}"
           class="w-full border rounded p-2 mb-3">

    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs text-gray-500 mb-1">Home player</label>
            <select name="singles[{{ $index }}][home_player_id]" onchange="if(this.value==='sub') addSub(this, 'home')" class="w-full border rounded p-2 mb-1">
                <option value="">Select player...</option>
                @foreach ($players as $player)
                    <option value="{{ $player->id }}" @selected(old("singles.$index.home_player_id", $existing?->home_player_id) == $player->id)>
                        {{ $player->name }}{{ $player->is_sub ? ' (sub)' : '' }}
                    </option>
                @endforeach
                <option value="sub">+ Add sub...</option>
            </select>
            <input type="number" name="singles[{{ $index }}][home_score]" placeholder="Score"
                   value="{{ old("singles.$index.home_score", $existing?->home_score) }}" class="w-full border rounded p-2 text-sm">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Away player</label>
            <select name="singles[{{ $index }}][away_player_id]" onchange="if(this.value==='sub') addSub(this, 'away')" class="w-full border rounded p-2 mb-1">
                <option value="">Select player...</option>
                @foreach ($players as $player)
                    <option value="{{ $player->id }}" @selected(old("singles.$index.away_player_id", $existing?->away_player_id) == $player->id)>
                        {{ $player->name }}{{ $player->is_sub ? ' (sub)' : '' }}
                    </option>
                @endforeach
                <option value="sub">+ Add sub...</option>
            </select>
            <input type="number" name="singles[{{ $index }}][away_score]" placeholder="Score"
                   value="{{ old("singles.$index.away_score", $existing?->away_score) }}" class="w-full border rounded p-2 text-sm">
        </div>
    </div>
</div>
