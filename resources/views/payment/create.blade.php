@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Create New Payment</div>
                    <div class="card-body">
                        <a href="{{ url('/payment') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/payment') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('payment.form', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>

                @if( $user )
                <div class="card mt-4">
                    <div class="card-header">Your Completed Fastworks are totally {{ $user->profile->completed_fastworks->sum('price') }}  Baht</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Job ID</th>
                                        <th>Photo</th>
                                        <th>Title</th>
                                        <th>Hours</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($user->profile->completed_fastworks as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            <a href="{{ url('/') }}/storage/{{ isset($item->photo) ? $item->photo : '../images/noimage.png' }}" target="_blank">
                                                <img src="{{ url('/') }}/storage/{{ isset($item->photo) ? $item->photo : '../images/noimage.png' }}" width="100">
                                            </a>
                                        </td>
                                        <td>
                                            <h5>
                                                <a href="{{ url('/') }}/fastwork/{{ $item->id }}">{{ $item->title }} ({{ $item->project->type }})</a>
                                            </h5>
                                            <div>
                                              <a href="{{ url('/') }}/project/{{ $item->project_id }}">{{ $item->project->title }}</a>
                                              by
                                              <a href="{{ url('/') }}/user/{{ $item->user_id }}">{{ $item->user->name }}</a>
                                            </div>
                                            <div>Dealine  : {{ $item->deadline }}</div>
                                            <div>
                                              <a class="" href="{{ url('/fastwork/' . $item->id . '/edit') }}" title="Edit Fastwork">
                                                  <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                              </a>
                                            </div>

                                        </td>
                                        <td  class="text-center">
                                            {{ isset($item->hours)? $item->hours : "-" }}
                                        </td>
                                        <td>
                                            @switch($item->status)
                                                @case("created")                                                     
                                                    <div><span class="badge badge-danger">Created at</span></div>
                                                    <div>{{ $item->created_at }}</div>
                                                    @break
                                                @case("reserved")                                                 
                                                    <div><span class="badge badge-warning">Reserved at</span></div>
                                                    <div>{{ $item->reserved_at }}</div> 
                                                    @break
                                                @case("completed")                                                    
                                                    <div ><span class="badge badge-success">Completed at</span></div>
                                                    <div>{{ $item->completed_at }}</div>
                                                    @break
                                                @case("paid")                                                     
                                                    <div><span class="badge badge-primary">Paid at</span></div>
                                                    <div>{{ $item->paid_at }}</div>
                                                    @break
                                            @endswitch   
                                            <div><strong>Developer : </strong></div>  
                                            @if( isset($item->developer_id) )
                                                <a href="{{ url('/') }}/user/{{ $item->developer_id }}">{{ $item->developer->name }}</a>
                                            @else
                                                {{ $item->developer_id }}
                                            @endif                                     
                                        </td>  
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    </div>
                </div>
                @endif
            </div>

            
        </div>
    </div>
@endsection
