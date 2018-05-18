<?php

namespace App\Http\Controllers\Api;

use App\Entity\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGroup;
use App\Http\Resources\Group as GroupResource;

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
        return GroupResource::collection(Group::paginate(self::PER_PAGE));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGroup $request
     * @return GroupResource
     */
    public function store(StoreGroup $request)
    {
        if ($request->id) {
            $group = Group::findOrFail($request->id);
            $group->update($request->except('_token'));
        } else {
            $group = Group::create($request->except('_token'));
        }

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
        return new GroupResource(Group::findOrFail($id));
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
}
