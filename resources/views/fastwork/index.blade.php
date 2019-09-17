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
                                        <th>Job ID</th>
                                        <th>Photo</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Developer</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($fastwork as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            <a href="{{ url('/') }}/storage/{{ isset($item->photo) ? $item->photo : '../images/noimage.png' }}" target="_blank">
                                                <img src="{{ url('/') }}/storage/{{ isset($item->photo) ? $item->photo : '../images/noimage.png' }}" width="100">
                                            </a>
                                        </td>
                                        <td>
                                            <h5>
                                                <a href="{{ url('/') }}/fastwork/{{ $item->id }}">{{ $item->title }}</a>
                                            </h5>
                                            <div>
                                              <a href="{{ url('/') }}/project/{{ $item->project_id }}">{{ $item->project->title }}</a>
                                              by
                                              <a href="{{ url('/') }}/user/{{ $item->user_id }}">{{ $item->user->name }}</a>
                                            </div>
                                            <div>Dealine  : {{ $item->deadline }}</div>
                                            <div>
                                              <a class="" href="{{ url('/fastwork/' . $item->id . '/edit') }}" title="Edit Fastwork">
                                                  <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                              </a>
                                            </div>

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
                                        <td>
                                          @if( isset($item->developer_id) )
                                            <a href="{{ url('/') }}/user/{{ $item->developer_id }}">{{ $item->developer->name }}</a>
                                          @else
                                            {{ $item->developer_id }}
                                          @endif
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ url('/fastwork' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('PUT') }}
                                                {{ csrf_field() }}
                                                @if( !isset($item->reserve_date) )
                                                <input type="hidden" name="reserve_date" value="{{ date('Y-m-d H:i:s')  }}">
                                                <input type="hidden" name="developer_id" value="{{ Auth::id() }}">
                                                <button type="submit" class="btn btn-warning btn-sm" title="Delete Fastwork"><i class="fa fa-calendar-plus" aria-hidden="true"></i> จอง</button>
                                                @endif
                                            </form>


                                            <a class="d-none" href="{{ url('/fastwork/' . $item->id) }}" title="View Fastwork"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>

                                            <form class="d-none" method="POST" action="{{ url('/fastwork' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
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
