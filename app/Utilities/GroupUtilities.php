<?php

namespace App\Utilities;

use App\Entity\Client;
use App\Entity\Group;
use Illuminate\Database\Eloquent\Collection;

class GroupUtilities
{
    /**
     * @param Collection $groups
     * @return array
     */
    public static function formatData(Collection $groups)
    {
        $formattedGroup = [];
        foreach ($groups as $group) {
            $getData = self::getData($group);
            $formattedGroup[] = [
                'id' => $group->id,
                'name' => $group->name,
                'critical' => $group->critical,
                'warning' => $group->warning,
                'clients' => $getData['clients'],
                'data' => $getData['data'],
            ];
        }

        return $formattedGroup;
    }

    /**
     * @param Group $group
     * @return array
     */
    public static function getData(Group $group)
    {
        $na = $warning = $critical = $healthy = 0;
        $clients = $group->clients()->where('alive', 1)->get();

        foreach ($clients as $client) {
            if ($client->health === Client::NO_RECORDS_YET) {
                $na++;
            } elseif ($client->health === Client::WARNING) {
                $warning++;
            } elseif ($client->health === Client::CRITICAL) {
                $critical++;
            } elseif ($client->health === Client::HEALTHY) {
                $healthy++;
            }
        }

        return [
            'clients' => count($clients),
            'data'    => [$na, $warning, $critical, $healthy]
        ];
    }
}
