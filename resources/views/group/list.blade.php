@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Groups
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
                        <th>Group</th>
                        <th>Warning Time</th>
                        <th>Critical Time</th>
                        <th>No of Clients</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($groups as $group)
                        <tr>
                            <td>{{ $group->name }}</td>
                            <td>{{ $group->warning }} seconds</td>
                            <td>{{ $group->critical }} seconds</td>
                            <td>{{ $group->clients->count() }}</td>
                            <td>
                                <a class="pull-left btn btn-link" href="{{ route('group.show', ['id' => $group->id]) }}">
                                    <i class="ion ion-log-in"></i> Details
                                </a>
                                <a class="pull-left btn btn-link" href="{{ route('group.edit', ['id' => $group->id]) }}">
                                    <i class="ion ion-edit"></i> Edit
                                </a>
                                {!! Form::open(['route' => ['group.delete', $group->id]]) !!}
                                <button class="btn btn-link"><i class="ion ion-close-round"></i> Delete</button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Group</th>
                        <th>Warning Time</th>
                        <th>Critical Time</th>
                        <th>No of Clients</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
