@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Project id : {{ $project->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/project') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/project/' . $project->id . '/edit') }}" title="Edit Project"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('project' . '/' . $project->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Project" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>

                        <div class="text-center my-4">
                            @php
                                $img = isset($project->photo) ? "/storage/{$project->photo}" :  "/images/noimage.png"
                            @endphp
                            <img src="{{ url($img) }}  " class="img-thumbnail" width="200px;" />
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr class="d-none">
                                        <th>ID</th><td>{{ $project->id }}</td>
                                    </tr>
                                    <tr><th> Title </th><td> {{ $project->title }} </td></tr><tr><th> Content </th><td> {{ $project->content }} </td></tr><tr><th> Begin Date </th><td> {{ $project->begin_date }} </td></tr><tr><th> Deadline </th><td> {{ $project->deadline }} </td></tr><tr><th> Complete Date </th><td> {{ $project->complete_date }} </td></tr>
                                    <tr><th> Owner </th><td> {{ $project->user->name }} </td></tr>
                                    @if(Auth::user()->profile->role == "admin")             
                                    <tr><th>งบประมาณสะสม (บาท) </th><td>{{ number_format($project->incomes->sum('total')) }}</td></tr>
                                    <tr><th>ที่เบิกจ่าย (บาท)  </th><td>{{ number_format($project->paid_fastworks->sum('price')) }}</td></tr>                                    
                                    <tr><th>ที่รอเรียกเก็บ (บาท)  </th><td>{{ number_format($project->paid_fastworks->sum('price') - $project->incomes->sum('total') ) }}</td></tr>
                                    @endif
                                    <tr><th> Type </th><td> {{ $project->type }} </td></tr>
                                    <tr><th> Remark </th><td> {{ $project->remark }} </td></tr>
                                    <tr class="d-none"><th> Photo </th><td> {{ $project->photo }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header"><h5>Fastwork in {{ $project->title}}</h5></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg">
                                <a href="{{ url('/fastwork/') }}" title="See fastwork"><button class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> See all fastworks</button></a>

                            </div>
                            <div class="col-lg text-right">
                                <button class="mr-auto btn btn-warning btn-sm" disabled>
                                    Reserved At
                                    <span class="badge badge-light">{{ $project->fastworks->sum('hours') }}</span>
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
                                    @foreach($project->fastworks as $item)                                        
                                        @include('fastwork/index_item')
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">Income</div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-lg">
                                
                            </div>
                            <div class="col-lg text-right">
                                <button class="mr-auto btn btn-warning btn-sm" disabled>
                                    Total Income
                                    <span class="badge badge-light">{{ $project->incomes->sum('total') }}</span>
                                </button>
                            </div>


                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Total</th>
                                        <th>Receipt</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($project->incomes as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div>
                                                <a href="{{ url('/income/' . $item->id) }}" title="View Income">{{ $item->title }}</a>                                          
                                                
                                            </div>
                                            <div>Project : {{ $item->project->title }}</div>
                                            <div>ผู้รับเงิน : {{ $item->user->name }}</div>
                                            <div>วันที่รับเงิน : {{ $item->paid_date }}</div>
                                        </td>
                                        <td>{{ number_format($item->total) }}</td>                                        
                                        <td>
                                            @if( isset($item->receipt) )
                                                <a href="{{ url('storage') }}/{{ $item->receipt }}" target="_blank">
                                                    <img src="{{ url('storage') }}/{{ $item->receipt }}"  width="70" />
                                                </a>
                                            @endif  
                                        </td>
                                        <td >
                                            <a class="d-none"  href="{{ url('/income/' . $item->id) }}" title="View Income"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/income/' . $item->id . '/edit') }}" title="Edit Income"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/income' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Income" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
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
