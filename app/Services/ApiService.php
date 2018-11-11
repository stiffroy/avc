<?php

namespace App\Services;

use App\Entity\Client;
use App\Entity\Statistics;
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
     * @param $token
     * @param $data
     * @return array|bool
     */
    public function saveReport($token, $data)
    {
        $status = [
            'code'      => 404,
            'message'   => 'Something is missing, please check your API call',
        ];

        if ($data->group_identifier && $token) {
            $status = $this->checkAuthenticity($token, $data->group_identifier);
            if ($status['code'] === 200) {
                if ($data->mode === 'create') {
                    $status = $this->createNewStatistics($data);
                } elseif ($data->mode === 'update') {
                    $status = $this->updateExistingStatistics($data);
                }
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

    /**
     * @param $token
     * @param $groupIdentifier
     * @return array|bool
     */
    private function checkAuthenticity($token, $groupIdentifier)
    {
        $status = [
            'code'      => 401,
            'message'   => 'You are not authorised to make the call.',
        ];
        $user = User::where('api_token', $token)->first();

        if ($user && ApiUtilities::checkGroupForUser($user, $groupIdentifier)) {
            $status = [
                'code'  => 200,
            ];
        }

        return $status;
    }

    /**
     * @param $data
     * @return array
     */
    private function createNewStatistics($data)
    {
        Statistics::create([
            'group_identifier'      => $data->group_identifier,
            'subgroup_identifier'   => $data->subgroup_identifier,
            'data'                  => json_encode($data->data)
        ]);

        return $status = [
            'code'      => 204,
            'message'   => 'New data recorded at ' . Carbon::now() . ' for ' . $data->group_identifier,
        ];
    }

    /**
     * @param $data
     * @return array
     */
    private function updateExistingStatistics($data)
    {
        $status = [
            'code'      => 401,
            'message'   => $data->group_identifier . ' has multiple data and so cannot be updated',
        ];

        $statistics = Statistics::where('group_identifier', $data->group_identifier)
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->get();

        if (count($statistics) == 0) {
            $status = $this->createNewStatistics($data);
        } elseif (count($statistics) == 1) {
            $newData = $this->newUpdatedData($statistics[0]->data, $data->data);
            $statistics[0]->update(['data' => $newData]);
            $status = [
                'code'      => 204,
                'message'   => 'Data updated for ' . $data->group_identifier . ' at ' . Carbon::now(),
            ];
        }

        return $status;
    }

    /**
     * @param $oldData
     * @param $newData
     * @return false|string
     */
    private function newUpdatedData($oldData, $newData)
    {
        $data = [];
        $oldData = json_decode($oldData, true);
        $newData = json_decode(json_encode($newData), true);
        foreach (array_keys($oldData) as $key) {
            $data[$key] = $oldData[$key] + $newData[$key];
        }

        return json_encode($data);
    }
}
