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
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($payment->fastworks as $item)
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
    </div>
@endsection
