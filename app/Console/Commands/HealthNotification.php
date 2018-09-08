<?php

namespace App\Console\Commands;

use App\Entity\Client;
use App\Notifications\ClientHealth;
use App\Utilities\ClientUtilities;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class HealthNotification extends Command
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
        Log::debug('In HealthNotification:handle at: ' . Carbon::now('Europe/Vienna'));
        $clients = Client::where('alive', true)->get();

        foreach ($clients as $client) {
            Log::debug('Client Health: ' . $client->health);
            if (!$client->notified_at && $client->health === ClientUtilities::CRITICAL) {
                $this->sendNotification($client);
            }
        }

        return 'Notify about the health of the clients are done';
    }

    /**
     * @param $client
     */
    private function sendNotification($client)
    {
        $users = $client->group_id ? $client->group->users : new Collection();

        if (count($users) > 0) {
            $this->sendNotificationByUser($client, $users);
        }
    }

    /**
     * @param $client
     * @param $users
     */
    private function sendNotificationByUser($client, $users)
    {
        $slackUrl = [];

        foreach ($users as $user) {
            if ($user->preferred_method === 'slack' && !in_array($user->slack_webhook_url, $slackUrl)) {
                $user->notify(new ClientHealth($client));
                $slackUrl[] = $user->slack_webhook_url;
            }
        }
    }
}
