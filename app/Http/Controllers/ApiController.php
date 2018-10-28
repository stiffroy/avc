<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
    /**
     * @var ApiService
     */
    private $apiService;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $this->apiService = new ApiService();
    }

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
        $status = $this->apiService->updateLiveStatus($externalId, $token);

        return response()->json($status);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeReport(Request $request)
    {
        $token = $request->get('token');
        $data = json_decode($request->get('data'));
        $status = $this->apiService->saveReport($token, $data);

        return response()->json($status);
    }
}
