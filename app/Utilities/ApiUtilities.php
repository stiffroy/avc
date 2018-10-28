<?php

namespace App\Utilities;

class ApiUtilities
{
    /**
     * @return string
     */
    public static function generateToken()
    {
        return str_random(60);
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
     * @param $user
     * @param $client
     * @return bool
     */
    public static function checkClientForUser($user, $client)
    {
        $result = false;

        foreach($user->groups as $group) {
            if ($group->clients->contains('id', $client->id)) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    /**
     * @param $user
     * @param $groupIdentifier
     * @return mixed
     */
    public static function checkGroupForUser($user, $groupIdentifier)
    {
        return $user->groups->contains('name', $groupIdentifier);
    }
}
