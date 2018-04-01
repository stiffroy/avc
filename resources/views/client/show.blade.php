@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Client
            <small>Details</small>
        </h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li><a href="#">Clients</a></li>
            <li class="active"><a href="#">{{ $client->name }}</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ $client->name }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td class="text-bold">{{ $client->name }}</td>
                        </tr>
                        <tr>
                            <th>External ID</th>
                            <td>{{ $client->external_id }}</td>
                        </tr>
                        <tr>
                            <th>Group</th>
                            <td>{{ $client->group->name }}</td>
                        </tr>
                        <tr>
                            <th>API Token</th>
                            <td>{{ $client->api_token }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><span>{{ $client->alive ? 'Alive' : 'Not active' }}</span></td>
                        </tr>
                        <tr>
                            <th>Health</th>
                            <td><span class="label label-{{ $client->statusLabel }}">{{ $client->health }}</span></td>
                        </tr>
                        <tr>
                            <th>Created On</th>
                            <td>{{ $client->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated</th>
                            <td>{{ $client->updated_at }}</td>
                        </tr>
                    </table>
                    {!! Form::open(['route' => ['client.delete', $client->id]]) !!}
                        <a href="{{ url()->previous() }}" class="btn btn-warning btn-flat">Back</a>
                        <a href="{{ route('client.edit', ['id' => $client->id]) }}" class="btn btn-primary btn-flat">Edit</a>
                        <button class="btn btn-danger btn-flat"><i class="ion ion-close-round"></i> Delete</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
