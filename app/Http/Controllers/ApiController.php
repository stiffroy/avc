<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelpers;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * The heartbeat of the clients is recorded here
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function heartbeat(Request $request)
    {
        $token = $request->get('token');
        $statusCode = ApiHelpers::updateLiveStatus($token);

        return response()->json(null, $statusCode);
    }
}
