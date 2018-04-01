<?php

namespace App\Http\Controllers;

use App\Entity\Client;
use App\Http\Requests\StoreClient;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function overview()
    {
        $clients = Client::all();
        $sortedClients = $clients->sortBy(function($client){
            return $client->health;
        });

        return view('client.pane', [
            'clients' => $sortedClients,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listView()
    {
        $clients = Client::all();

        return view('client.list', [
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new Client();

        return view('client.create', [
            'client' => $client,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClient $request
     * @param Client $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreClient $request, Client $client)
    {
        $client = $client->create($request->except('_token'));

        return redirect()->route('client.show', ['id' => $client->id])
            ->with('status', 'Successfully created the client!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return view('client.show', [
            'client' => $client,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('client.edit', [
            'client' => $client,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreClient $request
     * @param Client $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreClient $request, Client $client)
    {
        try {
            $client->update($request->except('_token'));
            $request->session()->flash('success', 'Successfully updated the client');
        } catch (\Exception $exception) {
            $request->session()->flash('failure', $exception);
        }

        return redirect()->route('client.show', ['id' => $client->id])
            ->with('status', 'Successfully updated the client!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Client $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Client $client)
    {
        try {
            $client->delete();
            $request->session()->flash('success', 'Successfully deleted the client');
        } catch (\Exception $exception) {
            $request->session()->flash('failure', $exception);
        }

        return redirect()->route('client.list')
            ->with('status', 'Successfully deleted the client!');
    }
}
