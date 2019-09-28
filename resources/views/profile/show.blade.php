@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row  justify-content-center">


            <div class="col-md-9">
                <div class="card">
                    <div class="card-header"><h5>Welcome, {{ $profile->user->name }} </h5></div>
                    <div class="card-body">

                        <a class="d-none" href="{{ url('/home') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/profile/' . $profile->id . '/edit') }}" title="Edit Profile"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

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
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
