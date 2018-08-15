<?php

namespace App\Utilities;

use App\Entity\Client;
use Illuminate\Support\Carbon;

class ApiUtilities
{
    /**
     * The utility function for recording live status
     *
     * @param $externalId
     * @param $token
     * @return array $status
     */
    public static function updateLiveStatus($externalId, $token)
    {
        $status = [
            'code'      => 404,
            'message'   => 'Something is missing, please check your API call',
        ];

        if ($externalId && $token) {
            $client = Client::where('external_id', $externalId)
                ->where('api_token', $token)
                ->where('alive', 1)
                ->get()
                ->first();

            if ($client) {
                $status = self::getStatusCode($client);
            } else {
                $status = [
                    'code'      => 401,
                    'message'   => 'You are not authorised to make the call',
                ];
            }
        }

        return $status;
    }

    /**
     * Formatting collection of entities for Vue-select
     *
     * @param $entities
     * @return array
     */
    public static function formatRelatedEntities($entities)
    {
        $formattedEntities = [];

        foreach ($entities as $entity) {
            $formattedEntities[] = [
                'value' => $entity->id,
                'label' => $entity->name,
            ];
        }

        return $formattedEntities;
    }

    /**
     * Formatting entity for Vue-select
     *
     * @param $entity
     * @return array
     */
    public static function formatRelatedEntity($entity)
    {
        return [
            'value' => $entity->id,
            'label' => $entity->name,
        ];
    }



    /**
     * Helper class for getting the status code
     *
     * @param $client
     * @return array $status
     */
    private static function getStatusCode($client)
    {
        $client->heartbeat_at = Carbon::now();
        $client->notified_at = null;

        try {
            $client->save();
            $status = [
                'code'      => 204,
                'message'   => 'The last heartbeat recorded at '. $client->heartbeat_at,
            ];
        } catch (\Exception $exception) {
            $status = [
                'code'      => 404,
                'message'   => 'Could not record the heartbeat',
            ];
        }

        return $status;
    }
}
