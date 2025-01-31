<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DisableInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'disable:inactive-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable users who have not logged in for 30 days';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (setting('inactive_account_disabled', 'global') == 1) {
            $inactiveUsers = User::whereDoesntHave('activities', function ($query) {
                $query->where('created_at', '>', now()->subDays(30));
            })->get();

            foreach ($inactiveUsers as $user) {
                $user->update(['status' => 0]);
            }

            $this->info('Inactive users disabled successfully.');
        }
    }
}
