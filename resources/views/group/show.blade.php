@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Group
            <small>Details</small>
        </h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li><a href="#">Groups</a></li>
            <li class="active"><a href="#">{{ $group->name }}</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ $group->name }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td class="text-bold">{{ $group->name }}</td>
                        </tr>
                        <tr>
                            <th>Warning Time</th>
                            <td>{{ $group->warning }} seconds</td>
                        </tr>
                        <tr>
                            <th>Critical Time</th>
                            <td>{{ $group->critical }} seconds</td>
                        </tr>
                        <tr>
                            <th>Clients</th>
                            <td>
                                @foreach($group->clients AS $client)
                                    <a href="{{ route('client.show', ['id' => $client->id]) }}" class="btn-link">
                                        <p class="label label-{{ $client->statusLabel }}">{{ $client->name }}</p>
                                    </a>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Created On</th>
                            <td>{{ $group->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated</th>
                            <td>{{ $group->updated_at->format('d.m.Y H:i') }}</td>
                        </tr>
                    </table>
                    {!! Form::open(['route' => ['group.delete', $group->id]]) !!}
                        <a href="{{ route('group.list') }}" class="btn btn-warning btn-flat">List</a>
                        <a href="{{ route('group.create') }}" class="btn btn-success btn-flat">Create</a>
                        <a href="{{ route('group.edit', ['id' => $group->id]) }}" class="btn btn-primary btn-flat">Edit</a>
                        <button class="btn btn-danger btn-flat"><i class="ion ion-close-round"></i> Delete</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
