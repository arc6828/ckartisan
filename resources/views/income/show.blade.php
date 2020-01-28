@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Income {{ $income->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/income') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/income/' . $income->id . '/edit') }}" title="Edit Income"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('income' . '/' . $income->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Income" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $income->id }}</td>
                                    </tr>
                                    <tr><th> Title </th><td> {{ $income->title }} </td></tr><tr><th> Remark </th><td> {{ $income->remark }} </td></tr><tr><th> Project Id </th><td> {{ $income->project_id }} </td></tr><tr><th> User Id </th><td> {{ $income->user_id }} </td></tr><tr><th> Total </th><td> {{ $income->total }} </td></tr><tr><th> Paid Date </th><td> {{ $income->paid_date }} </td></tr><tr><th> Receipt </th><td> {{ $income->receipt }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
