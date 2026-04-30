<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupZipDownloads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-zip-downloads';

    protected $description = 'Delete ZIP files in storage/app/downloads older than 24 hours';

    public function handle(): void
    {
        $dir = storage_path('app/downloads');

        if (!is_dir($dir)) {
            return;
        }

        $cutoff = now()->subHours(24)->getTimestamp();
        $deleted = 0;

        foreach (glob($dir . '/*.zip') as $file) {
            if (filemtime($file) < $cutoff) {
                @unlink($file);
                $deleted++;
            }
        }

        $this->info("Deleted {$deleted} expired ZIP file(s).");
    }
}
