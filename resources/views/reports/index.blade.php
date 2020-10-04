@extends('layouts.app')
@section('content')
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="{{route('events.index')}}">Manage Events</a></li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>{{$event->name}}</span>
            </h6>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="{{route('events.show',$event)}}">Overview</a></li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Reports</span>
            </h6>
            <ul class="nav flex-column mb-2">
                <li class="nav-item"><a class="nav-link active" href="reports/index.html">Room capacity</a></li>
            </ul>
        </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="border-bottom mb-3 pt-3 pb-2">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                <h1 class="h2">{{$event->name}}</h1>
            </div>
            <span class="h6">{{date('F j, Y',strtotime($event->date))}}</span>
        </div>

        <div class="mb-3 pt-3 pb-2">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                <h2 class="h4">Room Capacity</h2>
            </div>
        </div>

        <!-- TODO create chart here -->
        <canvas id="myChart" width="400" height="200"></canvas>
        <script>
            var ctx = document.getElementById('myChart').getContext('2d');
            let data = @json($data);
            let attendees = [];
            let capacity = [];
            let title = [];
            let backgroundColor = [];

            data.forEach(i => {
                attendees.push(i.attendees);
                capacity.push(i.capacity);
                title.push(i.title);
                if (i.attendees > i.capacity)
                    backgroundColor.push('red');
                else
                    backgroundColor.push('green');
            })
            var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: title,
                        datasets: [{
                            label: '# of Attendees',
                            data: attendees,
                            backgroundColor
                        }, {
                            label: '# of Capacity',
                            data: capacity,
                            backgroundColor: 'blue'
                        },
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                })
            ;
        </script>
    </main>
@endsection
