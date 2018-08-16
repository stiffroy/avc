<?php

namespace App\Services;

use App\Entity\Client;
use App\Entity\User;
use App\Utilities\ApiUtilities;
use Illuminate\Support\Carbon;

class ApiService
{
    /**
     * The utility function for recording live status
     *
     * @param $externalId
     * @param $token
     * @return array $status
     */
    public function updateLiveStatus($externalId, $token)
    {
        $status = [
            'code'      => 404,
            'message'   => 'Something is missing, please check your API call',
        ];

        if ($externalId && $token) {
            $client = Client::where('external_id', $externalId)
                ->where('alive', 1)
                ->first();
            $user = User::where('api_token', $token)
                ->first();

            if ($client && $user) {
                $status = $this->getStatus($user, $client);
            }
        }

        return $status;
    }

    /**
     * @param $user
     * @param $client
     * @return array
     */
    private function getStatus($user, $client)
    {
        $status = [
            'code'      => 401,
            'message'   => 'You are not authorised to make the call for ' . $client->name,
        ];

        if (ApiUtilities::checkClientForUser($user, $client)) {
            $status = self::getStatusCode($client);
        }

        return $status;
    }

    /**
     * Helper class for getting the status code
     *
     * @param $client
     * @return array $status
     */
    private function getStatusCode($client)
    {
        $client->heartbeat_at = Carbon::now();
        $client->notified_at = null;

        try {
            $client->save();
            $status = [
                'code'      => 204,
                'message'   => 'The last heartbeat recorded for ' . $client->name . ' at '. $client->heartbeat_at,
            ];
        } catch (\Exception $exception) {
            $status = [
                'code'      => 404,
                'message'   => 'Could not record the heartbeat for ' . $client->name,
            ];
        }

        return $status;
    }
}
