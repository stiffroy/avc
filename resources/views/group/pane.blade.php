@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Clients
            <small>Overview Mode</small>
        </h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li><a href="#">Clients</a></li>
            <li class="active"><a href="#">Overview</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Clients</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @foreach($groups as $group)
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-{{ $group->bg }}">
                            <div class="inner">
                                <h3>{{ $group->name }}</h3>
                                <p>{{ $group->external_id }}</p>
                                <p>{{ $group->health }}</p>
                            </div>

                            <div class="icon">
                                <i class="ion {{ $group->bgIcon }}"></i>
                            </div>

                            <a href="{{ route('client.show', ['id' => $client->id]) }}" class="small-box-footer">
                                More info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
