<?php

namespace App\Console\Commands;

use App\Events\ServiceGroupReminderEvent;
use App\Models\ServiceGroup;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class SendReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'secretary:send-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a reminder to those responsible in each service group';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $serviceGroups = ServiceGroup::where('responsible_email', '!=', null)
            ->orWhere('assistant_email', '!=', null)
            ->whereHas('reports', function( Builder $query){
                return $query->where('has_been_in_service', false)
                    ->where('has_not_been_in_service', false);
            })
            ->with('reports')
            ->get();


        foreach ($serviceGroups as $serviceGroup) {
            event(new ServiceGroupReminderEvent($serviceGroup));
        }
    }
}
