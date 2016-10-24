<?php

namespace Packages\Backup\App\Backup\Recurring;

use Illuminate\Console\Scheduling\Schedule;
use App\Support\ScheduleServiceProvider;

class RecurringCommandProvider
extends ScheduleServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
        StartRecurringCommand::class,
    ];

    /**
     * Register the commands.
     */
    public function boot()
    {
        $this->commands($this->commands);
    }

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('pkg:backup:recurring')->everyThirtyMinutes();
    }
}
