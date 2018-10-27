<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Symfony\Component\HttpFoundation\Request;

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
        $apiService = new ApiService();
        $status = $apiService->updateLiveStatus($externalId, $token);

        return response()->json($status);
    }
}
