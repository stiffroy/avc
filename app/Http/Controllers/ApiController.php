<?php

namespace App\Http\Controllers;

use App\Utilities\ApiUtilities;
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
        $externalId = $request->get('external-id');
        $status = ApiUtilities::updateLiveStatus($externalId, $token);

        return response()->json($status);
    }
}
