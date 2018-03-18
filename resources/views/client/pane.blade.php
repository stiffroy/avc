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
                @foreach($clients as $client)
                    @if($client->health === 'Not Active')
                        @php($icon = 'ion-flag')
                    @elseif($client->health !== 'Healthy')
                        @php($heart = '-broken')
                    @endif
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-{{ $client->bg }}">
                            <div class="inner">
                                <h3>{{ $client->name }}</h3>
                                <p>{{ $client->external_id }}</p>
                                <p>{{ $client->health }}</p>
                            </div>

                            <div class="icon">
                                @if(!empty($icon))
                                <i class="ion {{ $icon }}"></i>
                                @elseif($heart)
                                <i class="ion ion-heart{{ $heart }}"></i>
                                @endif
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
