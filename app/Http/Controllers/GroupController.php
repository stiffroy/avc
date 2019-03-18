<?php

namespace App\Http\Controllers;

use App\Entity\Client;
use App\Entity\Group;
use App\Entity\User;
use App\Http\Requests\StoreGroup;
use App\Http\Resources\Group as GroupResource;
use App\Services\ChartService;
use Illuminate\Support\Collection;

class GroupController extends Controller
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
        $groups = Group::with('clients', 'users')->paginate(self::PER_PAGE);
        return GroupResource::collection($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGroup $request
     * @return GroupResource
     */
    public function store(StoreGroup $request)
    {
        $clientIds = Collection::make($request->get('clients'))->pluck('value');
        $userIds = Collection::make($request->get('users'))->pluck('value');
        if ($request->id) {
            $group = Group::findOrFail($request->id);
            $group->update($request->except('_token', 'clients', 'users'));
            $group->users()->sync($userIds);
        } else {
            $group = Group::create($request->except('_token', 'clients', 'users'));
            $group->users()->sync($userIds);
        }

        $this->updateClient($group, $clientIds);

        return new GroupResource($group);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return GroupResource
     */
    public function show($id)
    {
        $group = Group::with('clients', 'users')->findOrFail($id);
        return new GroupResource($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreGroup $request
     * @param $id
     * @return GroupResource
     */
    public function update(StoreGroup $request, $id)
    {
        $group = Group::findOrFail($id);
        $group->update($request->except('_token'));

        return new GroupResource($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return GroupResource
     */
    public function destroy($id)
    {
        $group = Group::findOrFail($id);

        if ($group->delete()) {
            return new GroupResource($group);
        }
    }

    /**
     * @param $group
     * @param $clientIds
     */
    private function updateClient($group, $clientIds)
    {
        $clients = $group->clients->keyBy('id');

        foreach ($clientIds as $clientId) {
            if ($clients->contains('id', $clientId)) {
                $clients = $clients->forget($clientId);
            } else {
                $client = Client::findOrFail($clientId);
                $client->group()->associate($group);
                $client->save();
            }
        }

        foreach ($clients as $client) {
            $client->group()->dissociate();
            $client->save();
        }
    }

    /**
     * @param $userId
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function groupsByUser($userId)
    {
        $user = User::find($userId);

        if ($user->isAdmin()) {
            $groups = Group::with('clients')->paginate(self::PER_PAGE);
        } else {
            $groups = $user->groups()->with('clients')->paginate(self::PER_PAGE);
        }

        return GroupResource::collection($groups);
    }

    /**
     * @param $groupId
     * @return mixed
     */
    public function getChart($groupId)
    {
        $response = null;
        $type = request()->type;
        $from = request()->from;
        $till = request()->till;
        $group = Group::find($groupId);
        $statistics = $group->statistics
            ->where('created_at', '>', $from . ' 00:00:00')
            ->where('created_at', '<', $till . ' 23:59:59');

        if (!$statistics->isEmpty()) {
            $chartService = new ChartService();
            $response = $chartService->getChart($statistics, $type);
        }

        return $response;
    }
}
