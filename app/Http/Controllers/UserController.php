<?php

namespace App\Http\Controllers;

use App\Entity\User;
use App\Http\Requests\StoreUser;

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

        return view('user.create', [
            'user' => $user,
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
        $user = $user->create($request->except('_token'));

        return redirect()->route('user.show', ['id' => $user->id])
            ->with('status', 'Successfully created the user!');
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
        return view('user.edit', [
            'user' => $user,
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
        $status = 'Successfully updated the user!';
        try {
            $user->update($request->except('_token'));
            $request->session()->flash('success', $status);
        } catch (\Exception $exception) {
            $request->session()->flash('failure', $exception);
            $status = $exception['message'];
        }

        return redirect()->route('user.show', ['id' => $user->id])
            ->with('status', $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(User $user)
    {
        $status = 'Successfully deleted the user!';
        try {
            $user->delete();
        } catch (\Exception $exception) {
            $status = $exception['message'];
        }

        return redirect()->route('user.list')
            ->with('status', $status);
    }
}
