@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row  justify-content-center">
            @include('admin.sidebar')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Profile</div>
                    <div class="card-body">
                        <a href="{{ url('/profile/create') }}" class="btn btn-success btn-sm" title="Add New Profile">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/profile') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>User</th>
                                        <th>Bank</th>                                        
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($profile as $item)
                                    <tr>
                                        <td>
                                            <img class="img-thumbnail" src="{{ isset($item->photo) ? url('storage/'.$item->photo ) : url('/images/noimage.png') }}" width="100" />
                                        </td>
                                        <td>
                                            <div><a href="{{ url('/') }}/user/{{ $item->user_id }}">{{ $item->user->name }}</a></div>
                                            <div>{{ $item->user->email }}</div>
                                            <div>{{ $item->role }}</div>                                            
                                            @if(Auth::user()->profile->role == "admin"  )
                                            <div>รายได้สะสม : <span class="badge badge-pill badge-success">{{ number_format($item->fastworks->where('status','paid')->sum('price')) }}</span> บาท</div>
                                            @endif
                                            @if(Auth::user()->profile->role == "admin" && $item->completed_fastworks->sum('price') > 0)
                                            <div>ที่ค้างชำระ : <span class="badge badge-pill badge-danger">{{ number_format($item->completed_fastworks->sum('price')) }}</span> บาท</div>                                            
                                            @endif
                                        </td>
                                        <td>
                                            <div>{{ $item->bank_name }}</div>
                                            <div>{{ $item->bank_account }}</div>
                                        </td>        
                                        <td>
                                            <a href="{{ url('/payment/create') }}?user_id={{$item->user_id}}" title="สร้างรายได้"><button class="btn btn-info btn-sm"><i class="fa fa-credit-card pr-1" aria-hidden="true"></i> สร้างรายได้</button></a>
                                            
                                            <a href="{{ url('/profile/' . $item->id) }}" title="View Profile"><button class="btn btn-info btn-sm d-none"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/profile/' . $item->id . '/edit') }}" title="Edit Profile"><button class="btn btn-primary btn-sm d-none"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/profile' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline" class="d-none">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Profile" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $profile->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
