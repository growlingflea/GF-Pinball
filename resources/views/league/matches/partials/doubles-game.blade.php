{{-- resources/views/league/matches/partials/doubles-game.blade.php --}}
<div class="border rounded p-4 mb-4">
    <input type="hidden" name="doubles[{{ $index }}][round_number]" value="{{ $roundNumber }}">
    <input type="hidden" name="doubles[{{ $index }}][game_number]" value="{{ $gameNumber }}">
    <input type="hidden" name="doubles[{{ $index }}][team_a_is_home]" value="{{ $teamAIsHome ? 1 : 0 }}">

    <div class="flex justify-between mb-2">
        <span class="text-sm text-gray-500">Game {{ $gameNumber }}</span>
    </div>
    <input type="text" name="doubles[{{ $index }}][machine_name]" placeholder="Machine name"
           value="{{ old("doubles.$index.machine_name", $existing->machine_name ?? '') }}"
           class="w-full border rounded p-2 mb-3">

    <div class="grid grid-cols-2 gap-3">
        @foreach (['team_a_p1' => $teamAIsHome ? 'Home P1' : 'Away P1', 'team_a_p2' => $teamAIsHome ? 'Home P3' : 'Away P3',
                   'team_b_p1' => $teamAIsHome ? 'Away P1' : 'Home P2', 'team_b_p2' => $teamAIsHome ? 'Away P3' : 'Home P4'] as $field => $label)
            <div>
                <label class="block text-xs text-gray-500 mb-1">{{ $label }}</label>
                <select name="doubles[{{ $index }}][{{ $field }}_id]" onchange="if(this.value==='sub') addSub(this, '{{ str_starts_with($field, 'team_a') === $teamAIsHome ? 'home' : 'away' }}')" class="w-full border rounded p-2 mb-1">
                    <option value="">Select player...</option>
                    @foreach ($players as $player)
                        <option value="{{ $player->id }}" @selected(old("doubles.$index.{$field}_id", $existing?->{$field.'_id'}) == $player->id)>
                            {{ $player->name }}{{ $player->is_sub ? ' (sub)' : '' }}
                        </option>
                    @endforeach
                    <option value="sub">+ Add sub...</option>
                </select>
                <input type="number" name="doubles[{{ $index }}][{{ $field }}_score]" placeholder="Score"
                       value="{{ old("doubles.$index.{$field}_score", $existing?->{$field.'_score'}) }}"
                       class="w-full border rounded p-2 text-sm">
            </div>
        @endforeach
    </div>
</div>
