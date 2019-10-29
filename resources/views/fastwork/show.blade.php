@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')
            <div class="col-md-9">
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
                                    <tr><th> Title </th><td> {{ $fastwork->title }} </td></tr>
                                    <tr><th> Content </th><td> {{ $fastwork->content }} </td></tr>
                                    <tr><th> Deadline </th><td> {{ $fastwork->deadline }} </td></tr>
                                    <tr><th> Reserve Date </th><td> {{ $fastwork->reserved_at }} </td></tr>
                                    <tr><th> Complete Date </th><td> {{ $fastwork->completed_at }} </td></tr>
                                    <tr><th> Paid Date </th><td> {{ $fastwork->paid_at }} </td></tr>
                                    
                                    <tr><th> Status </th><td> {{ $fastwork->status }} </td></tr>
                                    <tr><th> Developer Id </th><td> {{ $fastwork->developer? $fastwork->developer->name : '' }} </td></tr>
                                    <tr><th> Project Id </th><td> {{ $fastwork->project->title }} </td></tr>
                                    <tr><th> Project Owner </th><td> {{ $fastwork->user->name }} </td></tr>
                                    <tr><th> Hours </th><td> {{ $fastwork->hours }} </td></tr>
                                    <tr><th> Price Per Hour </th><td> {{ $fastwork->price_per_hour }} </td></tr>
                                    <tr><th> Price </th><td> {{ $fastwork->price }} </td></tr>
                                    <tr><th> Remark </th><td> {{ $fastwork->remark }} </td></tr>
                                    <tr><th> Photo </th>
                                        <td> 
                                        @if($fastwork->photo)
                                        <img src="{{ url('storage') }}/{{ $fastwork->photo }}" width="100" />
                                        @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
