@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Payment {{ $payment->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/payment') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/payment/' . $payment->id . '/edit') }}" title="Edit Payment"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('payment' . '/' . $payment->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Payment" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $payment->id }}</td>
                                    </tr>
                                    <tr><th> total </th><td> {{ $payment->total }} </td></tr>
                                    <tr><th> User Id </th><td> {{ $payment->user->name }} </td></tr>
                                    <tr><th> Remark </th><td> {{ $payment->remark }} </td></tr>
                                    <tr><th> Paid At </th><td> {{ $payment->paid_at }} </td></tr>
                                    <tr><th> Receipt </th><td> 
                                        @if( isset($payment->receipt) )
                                            <img src="{{ url('storage') }}/{{ $payment->receipt }}" width=100 /> 
                                        @endif
                                    </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">Your Completed Fastworks are totally {{ $payment->fastworks->sum('price') }}  Baht</div>
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
                                    @foreach($payment->fastworks as $item)
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
            </div>
        </div>
    </div>
@endsection
