@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Users
            <small>Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li><a href="#">Users</a></li>
            <li class="active"><a href="#">Edit</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Edit {{ $user->name }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-sm-8 col-sm-offset-2">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @include('user.form', ['user' => $user, 'action' => 'update'])
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
