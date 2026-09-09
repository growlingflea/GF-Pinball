<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Rulesheet;
use Illuminate\Console\Command;

/**
 * Interactively matches games without an opdb_id against the rulesheets
 * table (which already has opdb_id from the pinballrules import) and lets
 * you confirm each suggested match rather than auto-assigning blind.
 *
 * Usage:
 *   php artisan games:backfill-opdb
 *   php artisan games:backfill-opdb --auto   (auto-apply only very
 *                                              confident, unambiguous matches;
 *                                              still prompts for the rest)
 */
class BackfillGameOpdbIds extends Command
{
    protected $signature = 'games:backfill-opdb {--auto : Auto-apply high-confidence, unambiguous matches without prompting}';

    protected $description = 'Fuzzy-match games against imported rulesheets to backfill opdb_id';

    private const AUTO_THRESHOLD = 92.0;

    private const AUTO_MARGIN = 15.0; // top match must beat 2nd place by this much to auto-apply

    public function handle(): int
    {
        $games = Game::whereNull('opdb_id')->orderBy('title')->get();

        if ($games->isEmpty()) {
            $this->info('No games are missing an opdb_id. Nothing to do.');

            return self::SUCCESS;
        }

        $rulesheets = Rulesheet::whereNotNull('opdb_id')->get(['id', 'title', 'manufacturer', 'opdb_id']);

        if ($rulesheets->isEmpty()) {
            $this->error('No rulesheets with an opdb_id found — run rulesheets:import first.');

            return self::FAILURE;
        }

        $matched = 0;
        $skipped = 0;

        foreach ($games as $game) {
            $candidates = $rulesheets
                ->map(function (Rulesheet $rulesheet) use ($game) {
                    return [
                        'rulesheet' => $rulesheet,
                        'score' => $this->score($game, $rulesheet),
                    ];
                })
                ->sortByDesc('score')
                ->values()
                ->take(3);

            $top = $candidates->first();
            $second = $candidates->get(1);

            $isConfidentAndUnambiguous = $top
                && $top['score'] >= self::AUTO_THRESHOLD
                && (! $second || ($top['score'] - $second['score']) >= self::AUTO_MARGIN);

            if ($this->option('auto') && $isConfidentAndUnambiguous) {
                $this->applyMatch($game, $top['rulesheet']);
                $this->info("Auto-matched: {$game->title} -> {$top['rulesheet']->title} ({$top['rulesheet']->opdb_id}) [{$top['score']}%]");
                $matched++;

                continue;
            }

            $this->newLine();
            $this->line("<fg=cyan>Game:</> {$game->title} ({$game->manufacturer})");

            if ($top === null || $top['score'] < 30) {
                $this->line('  No reasonable candidates found.');
                $skipped++;

                continue;
            }

            $options = $candidates
                ->map(fn ($c, $i) => sprintf(
                    '[%d] %.0f%% — %s (%s) [%s]',
                    $i,
                    $c['score'],
                    $c['rulesheet']->title,
                    $c['rulesheet']->manufacturer,
                    $c['rulesheet']->opdb_id
                ))
                ->push('skip')
                ->all();

            $choice = $this->choice('Pick a match (or skip)', $options, count($options) - 1);

            if ($choice === 'skip') {
                $skipped++;

                continue;
            }

            $index = (int) substr($choice, 1, strpos($choice, ']') - 1);
            $chosen = $candidates[$index]['rulesheet'];

            $this->applyMatch($game, $chosen);
            $matched++;
        }

        $this->newLine();
        $this->info("Done. Matched: {$matched}, Skipped: {$skipped}.");

        if ($matched > 0) {
            $this->comment('Re-run `php artisan db:seed --class=RulesheetSeeder` to link the rulesheets table to these games now that opdb_id is set.');
        }

        return self::SUCCESS;
    }

    private function applyMatch(Game $game, Rulesheet $rulesheet): void
    {
        $game->update(['opdb_id' => $rulesheet->opdb_id]);
    }

    private function score(Game $game, Rulesheet $rulesheet): float
    {
        $titleScore = 0.0;
        similar_text(
            $this->normalize($game->title),
            $this->normalize($rulesheet->title),
            $titleScore
        );

        $manufacturerBonus = 0.0;
        if ($game->manufacturer && $rulesheet->manufacturer) {
            $a = strtolower($game->manufacturer);
            $b = strtolower($rulesheet->manufacturer);
            if (str_contains($a, $b) || str_contains($b, $a)) {
                $manufacturerBonus = 5.0;
            }
        }

        return min(100.0, $titleScore + $manufacturerBonus);
    }

    private function normalize(string $title): string
    {
        $title = strtolower($title);
        $title = preg_replace('/\brulesheet\b/', '', $title);
        $title = preg_replace('/\b(pro|premium|le|limited edition|pinball|machine|home edition|wip)\b/', '', $title);
        $title = preg_replace('/[^a-z0-9\s]/', '', $title);
        $title = preg_replace('/\s+/', ' ', $title);

        return trim($title);
    }
}
