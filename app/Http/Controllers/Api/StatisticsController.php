<?php

namespace App\Http\Controllers\Api;

use App\Entity\Statistics;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStatistics;
use App\Http\Resources\Statistics as StatisticsResource;

class StatisticsController extends Controller
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
        $statistics = Statistics::all()->paginate(self::PER_PAGE);
        return StatisticsResource::collection($statistics);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreStatistics $request
     * @return StatisticsResource
     */
    public function store(StoreStatistics $request)
    {
        if ($request->id) {
            $statistics = Statistics::findOrFail($request->id);
            $statistics->update($request->except('_token', 'groups'));
        } else {
            $statistics = Statistics::create($request->except('_token'));
        }

        return new StatisticsResource($statistics);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return StatisticsResource
     */
    public function show($id)
    {
        $statistics = Statistics::with('groups')->findOrFail($id);
        return new StatisticsResource($statistics);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreStatistics $request
     * @param $id
     * @return StatisticsResource
     */
    public function update(StoreStatistics $request, $id)
    {
        $statistics = Statistics::findOrFail($id);
        $statistics->update($request->except('_token'));

        return new StatisticsResource($statistics);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return StatisticsResource
     */
    public function destroy($id)
    {
        $statistics = Statistics::findOrFail($id);

        if ($statistics->delete()) {
            return new StatisticsResource($statistics);
        }
    }
}
