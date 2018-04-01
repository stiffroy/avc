@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Users
            <small>Details</small>
        </h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li><a href="#">Users</a></li>
            <li class="active"><a href="#">{{ $user->name }}</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ $user->name }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if(Session::has('status'))
                    <div class="alert alert-success">{{ Session::get('status') }}</div>
                @elseif(Session::has('failure'))
                    <div class="alert alert-danger">{{ Session::get('failure') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td class="text-bold">{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email ID</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Created On</th>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated</th>
                            <td>{{ $user->updated_at }}</td>
                        </tr>
                    </table>
                    {!! Form::open(['route' => ['user.delete', $user->id]]) !!}
                        <a href="{{ url()->previous() }}" class="btn btn-warning btn-flat">Back</a>
                        <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="btn btn-primary btn-flat">Edit</a>
                        <button class="btn btn-danger btn-flat"><i class="ion ion-close-round"></i> Delete</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
