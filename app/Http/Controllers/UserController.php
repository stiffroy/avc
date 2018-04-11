<?php

namespace App\Http\Controllers;

use App\Entity\Group;
use App\Entity\User;
use App\Http\Requests\StoreUser;
use Softon\SweetAlert\Facades\SWAL;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function overview()
    {
        $users = User::all();

        return view('user.pane', [
            'users' => $users,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listView()
    {
        $users = User::all();

        return view('user.list', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        $groups = Group::all();

        return view('user.create', [
            'user'      => $user,
            'groups'    => $groups,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUser $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUser $request, User $user)
    {
        try {
            $user = $user->create($request->except('_token'));
            SWAL::message('User Created!', 'Successfully created a new user', 'success');
        } catch (\Exception $exception) {
            \Log::debug($exception['message']);
            SWAL::message('We are Sorry', $exception['message'], 'error');
        }

        return redirect()->route('user.show', ['id' => $user->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $groups = Group::all();

        return view('user.edit', [
            'user'      => $user,
            'groups'    => $groups,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUser $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreUser $request, User $user)
    {
        try {
            $user->update($request->except('_token'));
            SWAL::message('User Updated!', 'Successfully updated the user', 'success');
        } catch (\Exception $exception) {
            SWAL::message('We are Sorry', $exception['message'], 'error');
        }

        return redirect()->route('user.show', ['id' => $user->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(User $user)
    {
        try {
            $user->delete();
            SWAL::message('User Deleted!', 'Successfully deleted the user', 'success');
        } catch (\Exception $exception) {
            SWAL::message('We are Sorry', $exception['message'], 'error');
        }

        return redirect()->route('user.list');
    }
}
