@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Income</div>
                    <div class="card-body">
                        <a href="{{ url('/income/create') }}" class="btn btn-success btn-sm" title="Add New Income">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/income') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Total</th>
                                        <th>Receipt</th><th class="d-none" >Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($income as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div>
                                                <a href="{{ url('/income/' . $item->id) }}" title="View Income">{{ $item->title }}</a>                                          
                                                
                                            </div>
                                            <div>Project : {{ $item->project->title }}</div>
                                            <div>ผู้รับเงิน : {{ $item->user->name }}</div>
                                            <div>วันที่รับเงิน : {{ $item->paid_date }}</div>
                                        </td>
                                        <td>{{ $item->total }}</td>                                        
                                        <td>
                                            {{ $item->receipt }}
                                            @if( isset($item->receipt) )
                                                <a href="{{ url('storage') }}/{{ $item->receipt }}" target="_blank">
                                                    <img src="{{ url('storage') }}/{{ $item->receipt }}"  width="70" />
                                                </a>
                                            @endif  
                                        </td>
                                        <td class="d-none" >
                                            <a href="{{ url('/income/' . $item->id) }}" title="View Income"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/income/' . $item->id . '/edit') }}" title="Edit Income"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/income' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Income" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $income->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
