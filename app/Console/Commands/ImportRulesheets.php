<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Yaml\Yaml;

/**
 * Pulls the community-maintained Pinball Rulesheets repo
 * (github.com/heyrocker/pinballrules — successor to the closed Tilt
 * Forums rulesheet wiki) and writes it out as a committed seed file at
 * database/seeders/data/rulesheets.json.
 *
 * This is a manual/re-runnable maintenance command, NOT part of the
 * migrate --seed path. Cloners of GF-Pinball seed from the committed
 * JSON, so nobody needs network access to GitHub just to stand up the app.
 *
 * Usage:
 *   php artisan rulesheets:import
 *   php artisan rulesheets:import --seed   (also runs RulesheetSeeder after)
 */
class ImportRulesheets extends Command
{
    protected $signature = 'rulesheets:import {--seed : Run RulesheetSeeder immediately after importing}';

    protected $description = 'Import rulesheet content from github.com/heyrocker/pinballrules into database/seeders/data/rulesheets.json';

    private const REPO_TARBALL_URL = 'https://codeload.github.com/heyrocker/pinballrules/tar.gz/refs/heads/main';

    private const SKIP_DIRS = ['contribute', '_layouts', 'assets'];

    private const SKIP_FILES = ['README.md', 'rulesheet-master-list.md'];

    public function handle(): int
    {
        $tmpDir = storage_path('app/tmp/rulesheets-import');
        File::ensureDirectoryExists($tmpDir);

        $tarGzPath = "{$tmpDir}/pinballrules.tar.gz";

        $this->info('Downloading pinballrules repo tarball...');
        $response = Http::timeout(60)->get(self::REPO_TARBALL_URL);

        if (! $response->ok()) {
            $this->error("Download failed with status {$response->status()}");

            return self::FAILURE;
        }

        File::put($tarGzPath, $response->body());

        $this->info('Extracting...');
        $extractDir = "{$tmpDir}/extracted";
        File::ensureDirectoryExists($extractDir);

        try {
            $phar = new \PharData($tarGzPath);
            $phar->decompress();
            $tarPath = substr($tarGzPath, 0, -3); // strip .gz
            (new \PharData($tarPath))->extractTo($extractDir, null, true);
        } catch (\Exception $e) {
            $this->error('Extraction failed: '.$e->getMessage());

            return self::FAILURE;
        }

        $repoRoot = collect(File::directories($extractDir))->first();
        $docsRoot = "{$repoRoot}/docs";

        if (! $repoRoot || ! File::isDirectory($docsRoot)) {
            $this->error('Could not find docs/ directory in extracted repo.');

            return self::FAILURE;
        }

        $results = [];
        $skipped = 0;

        foreach (File::directories($docsRoot) as $manufacturerDir) {
            $manufacturerSlug = basename($manufacturerDir);

            if (in_array($manufacturerSlug, self::SKIP_DIRS, true)) {
                continue;
            }

            foreach (File::files($manufacturerDir) as $file) {
                $filename = $file->getFilename();

                if ($file->getExtension() !== 'md' || in_array($filename, self::SKIP_FILES, true)) {
                    continue;
                }

                $raw = File::get($file->getPathname());

                if (! preg_match('/^---\s*\n(.*?)\n---\s*\n(.*)$/s', $raw, $matches)) {
                    $skipped++;

                    continue;
                }

                try {
                    $front = Yaml::parse($matches[1]) ?? [];
                } catch (\Exception) {
                    $skipped++;

                    continue;
                }

                $body = trim($matches[2]);

                if (strlen($body) < 40) {
                    $skipped++;

                    continue;
                }

                $results[] = [
                    'opdb_id' => $front['opdb_id'] ?? null,
                    'manufacturer' => $front['manufacturer'] ?? str($manufacturerSlug)->replace('-', ' ')->title()->toString(),
                    'title' => $front['title'] ?? str($filename)->replace(['-', '.md'], [' ', ''])->title()->toString(),
                    'source_path' => "{$manufacturerSlug}/{$filename}",
                    'content_markdown' => $body,
                ];
            }
        }

        $outputPath = database_path('seeders/data/rulesheets.json');
        File::ensureDirectoryExists(dirname($outputPath));
        File::put($outputPath, json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        File::deleteDirectory($tmpDir);

        $withOpdb = collect($results)->filter(fn ($r) => ! empty($r['opdb_id']))->count();
        $this->info('Imported '.count($results)." rulesheets ({$withOpdb} with opdb_id), skipped {$skipped}.");
        $this->info("Written to {$outputPath}");

        if ($this->option('seed')) {
            $this->call('db:seed', ['--class' => \Database\Seeders\RulesheetSeeder::class]);
        }

        return self::SUCCESS;
    }
}
