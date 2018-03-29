@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Client
            <small>Edit</small>
        </h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li><a href="#">Client</a></li>
            <li class="active"><a href="#">Edit</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Edit {{ $group->name }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if(Session::has('status'))
                    <div class="alert alert-success">{{ Session::get('status') }}</div>
                @elseif(Session::has('failure'))
                    <div class="alert alert-danger">{{ Session::get('failure') }}</div>
                @endif

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

                    @include('group.form', ['group' => $group, 'action' => 'update'])
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
