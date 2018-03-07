<?php

namespace App\Helpers;

use App\Models\Client;

class ApiHelpers
{
    public static function updateLiveStatus($token)
    {
        if ($token) {
            $client = Client::where('api_token', $token);
            $client->alive = true;
            $client->save();
            $code = 204;
        } else {
            $code = 404;
        }

        return $code;
    }
}
