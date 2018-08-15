<?php

namespace App\Console\Commands;

use App\Entity\Client;
use App\Notifications\ClientHealth;
use App\Utilities\ClientUtilities;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class Notifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:health';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To periodically check and notify the users when a client health is in danger';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::debug('In Notifications:handle at: ' . now());
        $clients = Client::with('alive', true)->get();

        foreach ($clients as $client)
        {
            if (!$client->notified_at && $client->health === ClientUtilities::CRITICAL) {
                $this->sendNotification($client);
            }
        }
    }

    private function sendNotification($client)
    {
        $users = $client->group_id ? $client->group->users: new Collection();

        if (count($users) > 0) {
            Notification::send($users, new ClientHealth($client));
        }
    }
}
