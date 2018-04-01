<?php

namespace App\Http\Controllers;

use App\Entity\Client;
use App\Http\Requests\StoreClient;
use Softon\SweetAlert\Facades\SWAL;

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
        try {
            $client = $client->create($request->except('_token'));
            SWAL::message('Client Created!', 'Successfully created a new client', 'success');
        } catch (\Exception $exception) {
            SWAL::message('We are Sorry', $exception['message'], 'error');
        }

        return redirect()->route('client.show', ['id' => $client->id]);
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
            SWAL::message('Client Updated!', 'Successfully updated the client', 'success');
        } catch (\Exception $exception) {
            SWAL::message('We are Sorry', $exception['message'], 'error');
        }

        return redirect()->route('client.show', ['id' => $client->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Client $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Client $client)
    {
        try {
            $client->delete();
            SWAL::message('Client Deleted!', 'Successfully deleted the client', 'success');
        } catch (\Exception $exception) {
            SWAL::message('We are Sorry', $exception['message'], 'error');
        }

        return redirect()->route('client.list');
    }
}
