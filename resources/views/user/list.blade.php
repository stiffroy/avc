@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Users
            <small>List View Mode</small>
        </h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li><a href="#">Users</a></li>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Upgraded At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->timezone('Europe/Vienna')->format('d.m.Y \a\t H:i') }}</td>
                            <td>{{ $user->updated_at->timezone('Europe/Vienna')->format('d.m.Y \a\t H:i') }}</td>
                            <td>
                                <a class="pull-left btn btn-link" href="{{ route('user.show', ['id' => $user->id]) }}">
                                    <i class="ion ion-log-in"></i> Details
                                </a>
                                <a class="pull-left btn btn-link" href="{{ route('user.edit', ['id' => $user->id]) }}">
                                    <i class="ion ion-edit"></i> Edit
                                </a>
                                {!! Form::open(['route' => ['user.delete', $user->id]]) !!}
                                <button class="btn btn-link"><i class="ion ion-close-round"></i> Delete</button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Upgraded At</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection