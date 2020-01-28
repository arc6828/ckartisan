@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Project</div>
                    <div class="card-body">
                        <a href="{{ url('/project/create') }}" class="btn btn-success btn-sm" title="Add New Project">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/project') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
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
                                        <th>ID</th><th>Photo</th><th>Title</th>
                                        @if(Auth::user()->profile->role == "admin")     
                                        <th>Income <span class="badge badge-pill badge-success"> {{ number_format($incomes->sum('total')) s }} </span></th>
                                        <th>Pay <span class="badge badge-pill badge-danger">{{ number_format($payments->sum('total')) }}</span></th>
                                        @endif
                                        <th class="d-none">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($project as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td><img src="{{ url("/")."/storage/".(isset($item->photo)? $item->photo : "images/noimage.png") }}" width="100" /></td>
                                        <td>
                                            <div><a href="{{ url('/project/' . $item->id) }}">{{ $item->title }} ({{ $item->type }})</a></div>
                                            <div>{{ $item->begin_date }} - {{ $item->deadline }} - {{ $item->complete_date }}</div>
                                            <div>Owner : {{ $item->user->name }}</div>
                                        </td>
                                        @if(Auth::user()->profile->role == "admin")             
                                        <td>{{ number_format($item->income->sum('total')) }}</td>
                                        <td>{{ number_format($item->paid_fastworks->sum('price')) }}</td>
                                        @endif
                                        <td class="d-none">
                                            <a class="d-none" href="{{ url('/project/' . $item->id)  }}" title="View Project"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a class="d-none" href="{{ url('/project/' . $item->id . '/edit') }}" title="Edit Project"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form class="d-none" method="POST" action="{{ url('/project' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Project" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $project->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
