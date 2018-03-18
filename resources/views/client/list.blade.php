@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Clients
            <small>List View Mode</small>
        </h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li><a href="#">Clients</a></li>
            <li class="active"><a href="#">List</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="table-clients" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Client</th>
                        <th>External ID</th>
                        <th>Last Updated</th>
                        <th>Health</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($clients as $client)
                        <tr class="{{ $client->statusLabel }}">
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->external_id }}</td>
                            <td>{{ $client->updated_at }}</td>
                            <td><span class="label label-{{ $client->statusLabel }}">{{ $client->health }}</span></td>
                            <td>
                                <a class="pull-left btn btn-link" href="{{ route('client.show', ['id' => $client->id]) }}">
                                    <i class="ion ion-log-in"></i> Details
                                </a>
                                <a class="pull-left btn btn-link" href="{{ route('client.edit', ['id' => $client->id]) }}">
                                    <i class="ion ion-edit"></i> Edit
                                </a>
                                {!! Form::open(['route' => ['client.delete', $client->id]]) !!}
                                <button class="btn btn-link"><i class="ion ion-close-round"></i> Delete</button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Client</th>
                        <th>External ID</th>
                        <th>Last Updated</th>
                        <th>Health</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
