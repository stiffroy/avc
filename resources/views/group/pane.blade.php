@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Groups
            <small>Overview Mode</small>
        </h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li><a href="#">Groups</a></li>
            <li class="active"><a href="#">Overview</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Groups</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @foreach($groups as $group)
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box bg-teal">
                            <div class="inner">
                                <h3>{{ $group['name'] }}</h3>
                                <p>
                                    <span class="text-yellow">{{ $group['warning'] }} {{ str_plural('min', $group['warning']) }}</span> |
                                    <span class="text-red">{{ $group['critical'] }} {{ str_plural('min', $group['critical']) }}</span> |
                                    {{ $group['clients'] }} {{ str_plural('client', $group['clients']) }}
                                </p>
                            </div>

                            <div class="icon">
                                <canvas id="group-{{ $group['id'] }}" width="80" height="80">hello</canvas>
                            </div>

                            <a href="{{ route('group.show', ['id' => $group['id']]) }}" class="small-box-footer">
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

@section('footer-js')
    <script type="text/javascript">
        $(function () {
            @foreach($groups as $group)
            @if($group['clients'] > 0)
                let pieChartCanvas{{ $group["id"] }} = $('#group-{{ $group["id"] }}').get(0).getContext('2d');
                let pieChart{{ $group["id"] }} = new Chart(pieChartCanvas{{ $group["id"] }});

                // Pie data
                let PieData{{ $group["id"] }} = [
                    {
                        value    : {{ $group["data"][0] }},
                        color    : '#00c0ef',
                        highlight: '#00a7d0',
                        label    : '{{ \App\Entity\Client::NO_RECORDS_YET }}'
                    },
                    {
                        value    : {{ $group["data"][1] }},
                        color    : '#f39c12',
                        highlight: '#db8b0b',
                        label    : '{{ \App\Entity\Client::WARNING }}'
                    },
                    {
                        value    : {{ $group["data"][2] }},
                        color    : '#dd4b39',
                        highlight: '#d33724',
                        label    : '{{ \App\Entity\Client::CRITICAL }}'
                    },
                    {
                        value    : {{ $group["data"][3] }},
                        color    : '#00a65a',
                        highlight: '#008d4c',
                        label    : '{{ \App\Entity\Client::HEALTHY }}'
                    }
                ];
                pieChart{{ $group["id"] }}.Pie(PieData{{ $group["id"] }});
            @endif
            @endforeach
        })
    </script>
@endsection