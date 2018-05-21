<?php

namespace App\Http\Controllers\Api;

use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Collection;

class UserController extends Controller
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
        $groups = User::with('groups')->paginate(self::PER_PAGE);
        return UserResource::collection($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUser $request
     * @return UserResource
     */
    public function store(StoreUser $request)
    {
        $groupIds = Collection::make($request->get('groups'))->pluck('value');
        if ($request->id) {
            $user = User::findOrFail($request->id);
            $user->update($request->except('_token', 'groups'));
            $user->groups()->sync($groupIds);
        } else {
            $user = User::create($request->except('_token'));
            $user->groups()->sync($groupIds);
        }

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return UserResource
     */
    public function show($id)
    {
        $group = User::with('groups')->findOrFail($id);
        return new UserResource($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUser $request
     * @param $id
     * @return UserResource
     */
    public function update(StoreUser $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->except('_token'));

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return UserResource
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->delete()) {
            return new UserResource($user);
        }
    }
}
