@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Fastwork</div>
                    <div class="card-body">
                        <a href="{{ url('/fastwork/create') }}" class="btn btn-success btn-sm" title="Add New Fastwork">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/fastwork') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                        <th>Photo</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Developer Id</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($fastwork as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ url('/') }}/storage/{{ $item->photo }}" target="_blank">
                                                <img src="{{ url('/') }}/storage/{{ $item->photo }}" width="100">
                                            </a>
                                        </td>
                                        <td>
                                            <h5>{{ $item->title }}</h5>
                                            <div>
                                              <a href="{{ url('/') }}/project/{{ $item->project_id }}">{{ $item->project->title }}</a>
                                              by
                                              <a href="{{ url('/') }}/user/{{ $item->user_id }}">{{ $item->user->name }}</a>
                                            </div>
                                            <div>Dealine  : {{ $item->deadline }}</div>
                                        </td>
                                        <td>
                                          @if( isset($item->complete_date) )
                                          <div ><span class="badge badge-success">Completed at</span></div>
                                          <div>{{ $item->complete_date }}</div>
                                          @elseif( isset($item->accept_date) )
                                          <div><span class="badge badge-info">Accepted at</span></div>
                                          <div>{{ $item->accept_date }}</div>
                                          @elseif( isset($item->reserve_date) )
                                          <div><span class="badge badge-warning">Reserved at</span></div>
                                          <div>{{ $item->reserve_date }}</div>
                                          @else
                                          <div><span class="badge badge-primary">Created at</span></div>
                                          <div>{{ $item->created_at }}</div>
                                          @endif

                                        </td>
                                        <td>{{ $item->developer_id }}</td>
                                        <td>
                                            <a href="{{ url('/fastwork/' . $item->id) }}" title="View Fastwork"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/fastwork/' . $item->id . '/edit') }}" title="Edit Fastwork"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/fastwork' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Fastwork" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $fastwork->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
