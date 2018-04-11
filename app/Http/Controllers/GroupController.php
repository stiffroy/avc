<?php

namespace App\Http\Controllers;

use App\Entity\Group;
use App\Http\Requests\StoreGroup;
use App\Utilities\GroupUtilities;
use JavaScript;
use Softon\SweetAlert\Facades\SWAL;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function overview()
    {
        $groups = GroupUtilities::formatData(Group::all());

//        dump(json_encode($groups));

        JavaScript::put([
            'groups' => json_encode($groups),
        ]);

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
        try {
            $group = $group->create($request->except('_token'));
            SWAL::message('Group Created!', 'Successfully created a new group', 'success');
        } catch (\Exception $exception) {
            SWAL::message('We are Sorry', $exception['message'], 'error');
        }

        return redirect()->route('group.show', ['id' => $group->id]);
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
            SWAL::message('Group Updated!', 'Successfully updated the group', 'success');
        } catch (\Exception $exception) {
            SWAL::message('We are Sorry', $exception['message'], 'error');
        }

        return redirect()->route('group.show', ['id' => $group->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Group $group)
    {
        try {
            $group->delete();
            SWAL::message('Group Deleted!', 'Successfully deleted the group', 'success');
        } catch (\Exception $exception) {
            SWAL::message('We are Sorry', $exception['message'], 'error');
        }

        return redirect()->route('group.list');
    }
}
