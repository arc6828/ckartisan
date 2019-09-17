@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Fastwork {{ $fastwork->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/fastwork') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/fastwork/' . $fastwork->id . '/edit') }}" title="Edit Fastwork"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('fastwork' . '/' . $fastwork->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Fastwork" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $fastwork->id }}</td>
                                    </tr>
                                    <tr><th> Title </th><td> {{ $fastwork->title }} </td></tr><tr><th> Content </th><td> {{ $fastwork->content }} </td></tr><tr><th> Deadline </th><td> {{ $fastwork->deadline }} </td></tr><tr><th> Reserve Date </th><td> {{ $fastwork->reserve_date }} </td></tr><tr><th> Accept Date </th><td> {{ $fastwork->accept_date }} </td></tr><tr><th> Complete Date </th><td> {{ $fastwork->complete_date }} </td></tr><tr><th> Developer Id </th><td> {{ $fastwork->developer_id }} </td></tr><tr><th> Project Id </th><td> {{ $fastwork->project_id }} </td></tr><tr><th> User Id </th><td> {{ $fastwork->user_id }} </td></tr><tr><th> Remark </th><td> {{ $fastwork->remark }} </td></tr><tr><th> Photo </th><td> {{ $fastwork->photo }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
