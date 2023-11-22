<?php

namespace App\Console\Commands;

use App\Models\ServiceGroup;
use Illuminate\Console\Command;

class DeleteOldReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-reports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove reports if user not closing the reports manually.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ServiceGroup::query()->delete();
    }
}
