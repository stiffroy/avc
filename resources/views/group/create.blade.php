@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Groups
            <small>Create</small>
        </h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li><a href="#">Group</a></li>
            <li class="active"><a href="#">Create</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Create New Group</h3>
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

                    @include('group.form', ['group' => $group, 'action' => 'store'])
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
