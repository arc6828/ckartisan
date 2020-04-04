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
                                    {{ $profile->completed_part_time_fastworks->where('status','completed')->sum('price') }}
                                </h1>
                                <p class="card-text">รายได้ที่คาดว่าจะได้รับ</p>
                            </div>
                        </div>                    
                    </div>
                    <div class="col-md-6">                         
                        <div class="card mt-4">
                            <div class="card-body text-center">
                                <h1 class="card-title">
                                    {{ $profile->fastworks->where('status','paid')->sum('price') }}
                                </h1>
                                <p class="card-text">รายได้สะสมของคุณ</p>
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
