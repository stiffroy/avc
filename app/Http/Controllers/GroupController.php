<?php

namespace App\Http\Controllers;

use App\Entity\Group;
use App\Http\Requests\StoreGroup;
use Illuminate\Support\Facades\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function overview()
    {
        $groups = Group::all();

        return view('group.pane', [
            'groups' => $groups,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listView()
    {
        $groups = Group::all();

        return view('group.list', [
            'groups' => $groups,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $group = new Group();

        return view('group.create', [
            'group' => $group,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGroup $request
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreGroup $request, Group $group)
    {
        $group = $group->create($request->except('_token'));

        return redirect()->route('group.show', ['id' => $group->id])
            ->with('status', 'Successfully created the client!');
    }

    /**
     * Display the specified resource.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return view('group.show', [
            'group' => $group,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Group $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view('group.edit', [
            'group' => $group,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreGroup $request
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreGroup $request, Group $group)
    {
        try {
            $group->update($request->except('_token'));
            $request->session()->flash('success', 'Successfully updated the client');
        } catch (\Exception $exception) {
            $request->session()->flash('failure', $exception);
        }

        return redirect()->route('group.show', ['id' => $group->id])
            ->with('status', 'Successfully updated the client!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Group $group)
    {
        try {
            $group->delete();
            $request->session()->flash('success', 'Successfully deleted the client');
        } catch (\Exception $exception) {
            $request->session()->flash('failure', $exception);
        }

        return back();
    }
}
