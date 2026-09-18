{{-- resources/views/league/matches/form.blade.php --}}
<x-layouts.app :title="$match->exists ? 'Edit match' : 'New match'">
    <div class="max-w-4xl mx-auto py-8" x-data="{ homeTeamId: '{{ old('home_team_id', $match->home_team_id) }}', awayTeamId: '{{ old('away_team_id', $match->away_team_id) }}' }">

        <h1 class="text-xl font-bold mb-6">{{ $match->exists ? 'Edit match' : 'New match' }}</h1>

        <form method="POST" action="{{ $submitRoute }}">
            @csrf
            @if ($method === 'PUT') @method('PUT') @endif

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm mb-1">Date</label>
                    <input type="date" name="match_date" value="{{ old('match_date', $match->match_date?->format('Y-m-d')) }}" class="w-full border rounded p-2">
                </div>
                <div></div>

                <div>
                    <label class="block text-sm mb-1">Home team</label>
                    <select name="home_team_id" x-model="homeTeamId" class="w-full border rounded p-2">
                        <option value="">Select...</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}" @selected(old('home_team_id', $match->home_team_id) == $team->id)>{{ $team->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="home_initials" placeholder="Initials" value="{{ old('home_initials', $match->home_initials) }}" class="w-full border rounded p-2 mt-1 text-sm">
                </div>
                <div>
                    <label class="block text-sm mb-1">Away team</label>
                    <select name="away_team_id" x-model="awayTeamId" class="w-full border rounded p-2">
                        <option value="">Select...</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}" @selected(old('away_team_id', $match->away_team_id) == $team->id)>{{ $team->name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="away_initials" placeholder="Initials" value="{{ old('away_initials', $match->away_initials) }}" class="w-full border rounded p-2 mt-1 text-sm">
                </div>
            </div>

            {{-- Round 1: Doubles, away chooses machines --}}
            <h2 class="font-semibold text-lg mt-8 mb-2">Round 1 — Doubles (away chooses machines)</h2>
            @for ($g = 1; $g <= 3; $g++)
                @include('league.matches.partials.doubles-game', [
                    'index' => $g - 1,
                    'roundNumber' => 1,
                    'gameNumber' => $g,
                    'teamAIsHome' => false,
                    'existing' => $match->doublesGames->firstWhere(fn($x) => $x->round_number == 1 && $x->game_number == $g),
                    'players' => $players,
                ])
            @endfor

            {{-- Round 2: Singles, home chooses machines --}}
            <h2 class="font-semibold text-lg mt-8 mb-2">Round 2 — Singles (home chooses machines)</h2>
            @for ($g = 1; $g <= 6; $g++)
                @include('league.matches.partials.singles-game', [
                    'index' => $g - 1,
                    'roundNumber' => 2,
                    'gameNumber' => $g,
                    'existing' => $match->singlesGames->firstWhere(fn($x) => $x->round_number == 2 && $x->game_number == $g),
                    'players' => $players,
                ])
            @endfor

            {{-- Round 3: Singles, away chooses machines --}}
            <h2 class="font-semibold text-lg mt-8 mb-2">Round 3 — Singles (away chooses machines)</h2>
            @for ($g = 1; $g <= 6; $g++)
                @include('league.matches.partials.singles-game', [
                    'index' => $g + 5,
                    'roundNumber' => 3,
                    'gameNumber' => $g,
                    'existing' => $match->singlesGames->firstWhere(fn($x) => $x->round_number == 3 && $x->game_number == $g),
                    'players' => $players,
                ])
            @endfor

            {{-- Round 4: Doubles, home chooses machines --}}
            <h2 class="font-semibold text-lg mt-8 mb-2">Round 4 — Doubles (home chooses machines)</h2>
            @for ($g = 1; $g <= 3; $g++)
                @include('league.matches.partials.doubles-game', [
                    'index' => $g + 2,
                    'roundNumber' => 4,
                    'gameNumber' => $g,
                    'teamAIsHome' => true,
                    'existing' => $match->doublesGames->firstWhere(fn($x) => $x->round_number == 4 && $x->game_number == $g),
                    'players' => $players,
                ])
            @endfor

            {{-- Tiebreaker --}}
            <h2 class="font-semibold text-lg mt-8 mb-2">Tiebreaker</h2>
            <div class="border rounded p-4 mb-6">
                <input type="text" name="tiebreaker[machine_name]" placeholder="Machine" value="{{ old('tiebreaker.machine_name', $match->tiebreaker?->machine_name) }}" class="w-full border rounded p-2 mb-2">
                <select name="tiebreaker[format]" class="w-full border rounded p-2 mb-2">
                    <option value="">Format...</option>
                    <option value="split" @selected(old('tiebreaker.format', $match->tiebreaker?->format) === 'split')>Split</option>
                    <option value="shared" @selected(old('tiebreaker.format', $match->tiebreaker?->format) === 'shared')>Shared</option>
                </select>
                <select name="tiebreaker[winner]" class="w-full border rounded p-2">
                    <option value="">Winner (if played)...</option>
                    <option value="home" @selected(old('tiebreaker.winner', $match->tiebreaker?->winner) === 'home')>Home</option>
                    <option value="away" @selected(old('tiebreaker.winner', $match->tiebreaker?->winner) === 'away')>Away</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white rounded px-4 py-2">Save match</button>
        </form>
    </div>

    <script>
        async function addSub(selectEl, side) {
            const name = prompt('Sub name:');
            if (!name) return;
            const teamId = side === 'home' ? document.querySelector('[name=home_team_id]').value : document.querySelector('[name=away_team_id]').value;
            if (!teamId) { alert('Pick a team first.'); return; }

            const res = await fetch('{{ route('league.players.store') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                body: JSON.stringify({ name, league_team_id: teamId, is_sub: true }),
            });
            const player = await res.json();

            const opt = document.createElement('option');
            opt.value = player.id;
            opt.textContent = player.name + ' (sub)';
            opt.selected = true;
            selectEl.insertBefore(opt, selectEl.lastElementChild);
        }
    </script>
</x-layouts.app>
