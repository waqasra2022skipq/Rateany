<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Business;

class MigrateBusinessLogosToS3 extends Command
{
    protected $signature = 'migrate:business-logos';
    protected $description = 'Migrate all local business logos to S3';

    public function handle()
    {
        $this->info("Starting logo migration...");

        $migrated = 0;
        $skipped = 0;

        foreach (Business::all() as $business) {
            $path = $business->business_logo;

            if (!$path) {
                $skipped++;
                continue;
            }

            if (!Storage::disk('public')->exists($path)) {
                $this->warn("File not found: $path");
                $skipped++;
                continue;
            }

            // Read the file from local
            $file = Storage::disk('public')->get($path);

            // Put it to S3
            Storage::disk('s3')->put($path, $file, 'public');

            // Optionally delete local file
            // Storage::disk('public')->delete($path);

            $this->info("Migrated: $path");
            $migrated++;
        }

        $this->info("Done! Migrated: $migrated | Skipped: $skipped");
    }
}
