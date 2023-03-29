<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\UsersController;
use Illuminate\Console\Command;

class FilterResearches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'researches:filter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'start the process of sending invoice reminders and deleting overdue invoices and thier researches';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = UsersController::filter_users_researches();
        $this->info('the command was successful');
        $this->line(count($data['deleted']) . ' researches were deleted');
        $this->line(count($data['updated']) . ' researches were updated to next phase');
        $this->line('it took ' . $data['duration'] . ' seconds');
        return 0;
    }
}
