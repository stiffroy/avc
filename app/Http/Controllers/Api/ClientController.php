<?php

namespace App\Http\Controllers\Api;

use App\Entity\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClient;
use App\Http\Resources\Client as ClientResource;
use App\Utilities\ApiUtilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ClientController extends Controller
{
    /**
     * The number of items to show per page
     */
    const PER_PAGE = 25;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $client = Client::with('group')->paginate(self::PER_PAGE);
        return ClientResource::collection($client);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClient $request
     * @return ClientResource
     */
    public function store(StoreClient $request)
    {
        $group = $request->get('group');
        $groupId = $group['value'];
        $request->merge(['group_id' => $groupId]);

        if ($request->id) {
            $client = Client::findOrFail($request->id);
            $client->update($request->except('_token', 'group'));
        } else {
            $client = Client::create($request->except('_token', 'group'));
        }

        return new ClientResource($client);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return ClientResource
     */
    public function show($id)
    {
        $client = Client::with('group')->findOrFail($id);
        return new ClientResource($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreClient $request
     * @param $id
     * @return mixed
     */
    public function update(StoreClient $request, $id)
    {
        $client = Client::findOrFail($id);
        $client->update($request->except('_token'));

        return new ClientResource($client);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return ClientResource
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);

        if ($client->delete()) {
            return new ClientResource($client);
        }
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
        $status = ApiUtilities::updateLiveStatus($externalId, $token);

        return response()->json($status);
    }

    /**
     * @return ClientResource
     */
    public function makeAlive()
    {
        $id = Input::get('id');
        $client = Client::findOrFail($id);
        $client->update(['alive' => true]);

        return new ClientResource($client);
    }
}
