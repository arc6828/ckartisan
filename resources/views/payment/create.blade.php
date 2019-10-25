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

                        <form method="POST" action="{{ url('/payment') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data" onsubmit="return ((document.querySelector('#total').value == '0')?  false : true ) "  >
                            {{ csrf_field() }}

                            @include ('payment.form', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>

                @if( $user )
                <div class="card mt-4">
                    <div class="card-header">Your Completed Fastworks are totally {{ $user->profile->completed_part_time_fastworks->sum('price') }}  Baht</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Title</th>
                                        <th>Hours</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($user->profile->completed_part_time_fastworks as $item)
                                    @include('fastwork/index_item')
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
