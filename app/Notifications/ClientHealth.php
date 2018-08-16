<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ClientHealth extends Notification
{
    use Queueable;

    const BASE_URL = 'http://www.dashboard.avc/#/clients/notified/';
    private $client;

    /**
     * ClientHealth constructor.
     * @param $client
     */
    public function __construct($client)
    {
        $now = Carbon::now();
        $client->notified_at = $now;
        $client->save();
        $this->client = $client;
        Log::debug('In ClientHealth:__construct at: ' . $now);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $method = ['mail', 'slack', 'database', 'broadcast'];

        if ($notifiable->preferred_method) {
            $method = [$notifiable->preferred_method, 'database', 'broadcast'];
        }

        return $method;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->error()
            ->subject('VM ' . $this->client->name . ' in danger')
            ->greeting('Hello,')
            ->line('VM ' . $this->client->name . ' is in ' . $this->client->health . ' state.')
            ->line('Check-up time at: ' . Carbon::now('Europe/Vienna')->format('d.m.Y H:i'))
            ->action('Notification Action', url($this::BASE_URL . $this->client->id))
            ->line('Thank you.');
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'client_id' => $this->client->id,
            'health' => $this->client->health,
        ]);
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->error()
            ->content('VM ' . $this->client->name . '(' . $this->client->name . ')' . ' is in danger.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'client_id' => $this->client->id,
            'health' => $this->client->health,
        ];
    }
}
