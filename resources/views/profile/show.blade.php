@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row  justify-content-center">

            @include('admin.sidebar')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header"><h5>Welcome, {{ $profile->user->name }} </h5></div>
                    <div class="card-body">

                        <a class="d-none" href="{{ url('/home') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        @if(Auth::user()->profile->id == $profile->id)
                        <a href="{{ url('/profile/' . $profile->id . '/edit') }}" title="Edit Profile"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        @endif
                        <form class="d-none"  method="POST" action="{{ url('profile' . '/' . $profile->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Profile" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>
                        <div class="text-center my-4">
                            @php 
                                $img = isset($profile->photo) ? "/storage/{$profile->photo}" :  "/images/noimage.png"
                            @endphp
                            <img src="{{ url($img) }}  " class="img-thumbnail" width="200px;" />
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr><th> Name </th><td> {{ $profile->user->name }} </td></tr>
                                    <tr><th> Email </th><td> {{ $profile->user->email }} </td></tr>
                                    <tr><th> Role </th><td> {{ $profile->role }} </td></tr>
                                    <tr><th> บัญชีธนาคาร </th><td> 
                                        <div>{{ $profile->bank_name}} </div>
                                        <div>{{ $profile->bank_account ? str_replace([0,2,4,6,8], "x", $profile->bank_account ) : ''  }} </div>
                                    </td></tr>
                                    
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                @if(Auth::id() == $profile->user_id || Auth::user()->profile->role == "admin" )
                <div class="row">
                    <div class="col-md-6"> 
                        <div class="card mt-4">
                            <div class="card-body text-center">
                                <h1 class="card-title">
                                    {{ number_format($profile->reserved_part_time_fastworks->sum('price') ) }}
                                </h1>
                                <p class="card-text">รายได้ที่คาดว่าจะได้รับ</p>
                            </div>
                        </div>                    
                    </div>
                    <div class="col-md-6">                         
                        <div class="card mt-4">
                            <div class="card-body text-center">
                                <h1 class="card-title">
                                    {{ number_format($profile->fastworks->where('status','paid')->sum('price')) }}
                                </h1>
                                <p class="card-text">รายได้สะสมของคุณ</p>
                            </div>
                        </div>  
                    </div>
                </div>
                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
                @php
                    $projects = [];
                    
                    foreach ($profile->fastworks as $fastwork){
                        $projects[$fastwork->project->title] = [
                            $profile->fastworks->where('status','paid')->where('project_id',$fastwork->project->id)->sum('price'),
                            $profile->fastworks->where('status','reserved')->where('project_id',$fastwork->project->id)->sum('price'),
                        ];
                    }
                    //print_r($projects);
                    $project_keys = array_keys($projects);
                    $project_values_paid = array_map(function($values){
                        //print_r($values);
                        return ($values[0]);
                    }, array_values($projects));
                    $project_values_reserved = array_map(function($values){
                        return ($values[1]);
                    },array_values($projects));
                    //echo "<br>";
                    //print_r($project_values_paid);
                    //echo "<br>";
                    //print_r($project_values_reserved);
                @endphp
                <div class="row">                    
                    <div class="col-md-12">                         
                        <div class="card mt-4">
                            <div class="card-body">
                                <canvas id="myChart2" width="100" height="30"></canvas>
                                <script>
                                    var ctx = document.getElementById('myChart2');
                                    var myBarChart = new Chart(ctx, {
                                        "type": "horizontalBar",
                                        "data": {
                                            "labels": @json($project_keys) ,
                                            "datasets": [{
                                                    "label": 'Paid' ,
                                                    "data": @json($project_values_paid) ,
                                                    "fill": false,
                                                    "backgroundColor": "#007bff",
                                                    //"backgroundColor": ["rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)", "rgba(255, 205, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(153, 102, 255, 0.2)", "rgba(201, 203, 207, 0.2)"],
                                                    //"borderColor": ["rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)", "rgb(75, 192, 192)", "rgb(54, 162, 235)", "rgb(153, 102, 255)", "rgb(201, 203, 207)"],
                                                    //"borderWidth": 1
                                                },
                                                {
                                                    "label": 'Reserved' ,
                                                    "data": @json($project_values_reserved) ,
                                                    "fill": false,
                                                    "backgroundColor": "#dc3545",
                                                    //"backgroundColor": ["rgba(255, 99, 132, 0.2)", "rgba(255, 159, 64, 0.2)", "rgba(255, 205, 86, 0.2)", "rgba(75, 192, 192, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(153, 102, 255, 0.2)", "rgba(201, 203, 207, 0.2)"],
                                                    //"borderColor": ["rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)", "rgb(75, 192, 192)", "rgb(54, 162, 235)", "rgb(153, 102, 255)", "rgb(201, 203, 207)"],
                                                    //"borderWidth": 1
                                                }
                                            ]
                                        },
                                        "options": {
                                            "scales": {
                                                "xAxes": [
                                                    {
                                                        "ticks": {
                                                            "beginAtZero": true
                                                        },
                                                        stacked: true
                                                    }
                                                ],
                                                "yAxes": [{
                                                    stacked: true
                                                }]
                                            },
                                            legend: {
                                                //display: false
                                            },
                                        }
                                    });
                                
                                </script>
                            </div>
                        </div>  
                    </div>
                </div>
                @endif

                

                <div class="card mt-4">
                    <div class="card-header"><h5>Fastwork History</h5></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg">
                                <a href="{{ url('/fastwork/') }}" title="See fastwork"><button class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> See all fastworks</button></a>
                            
                            </div>
                            <div class="col-lg text-right">
                                <button class="mr-auto btn btn-warning btn-sm" disabled>
                                    Reserved At 
                                    <span class="badge badge-light">{{ $profile->fastworks->sum('hours') }}</span>
                                </button>    
                            </div>
                            
                                                    
                        </div>
                        <div class="table-responsive mt-4">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Photo</th>
                                            <th>Title</th>
                                            <th>Hours</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($profile->fastworks as $item)
                                        @include('fastwork/index_item')
                                    @endforeach
                                    </tbody>
                                </table>                            
                            </div>


                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
