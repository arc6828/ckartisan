@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Project id : {{ $project->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/project') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/project/' . $project->id . '/edit') }}" title="Edit Project"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('project' . '/' . $project->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Project" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>

                        <div class="text-center my-4">
                            @php
                                $img = isset($project->photo) ? "/storage/{$project->photo}" :  "/images/noimage.png"
                            @endphp
                            <img src="{{ url($img) }}  " class="img-thumbnail" width="200px;" />
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr class="d-none">
                                        <th>ID</th><td>{{ $project->id }}</td>
                                    </tr>
                                    <tr><th> Title </th><td> {{ $project->title }} </td></tr><tr><th> Content </th><td> {{ $project->content }} </td></tr><tr><th> Begin Date </th><td> {{ $project->begin_date }} </td></tr><tr><th> Deadline </th><td> {{ $project->deadline }} </td></tr><tr><th> Complete Date </th><td> {{ $project->complete_date }} </td></tr>
                                    <tr><th> Owner </th><td> {{ $project->user->name }} </td></tr>
                                    <tr><th> Remark </th><td> {{ $project->remark }} </td></tr>
                                    <tr class="d-none"><th> Photo </th><td> {{ $project->photo }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header"><h5>Fastwork in {{ $project->title}}</h5></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg">
                                <a href="{{ url('/fastwork/') }}" title="See fastwork"><button class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> See all fastworks</button></a>

                            </div>
                            <div class="col-lg text-right">
                                <button class="mr-auto btn btn-warning btn-sm" disabled>
                                    Reserved At
                                    <span class="badge badge-light">{{ $project->fastworks->sum('hours') }}</span>
                                </button>
                            </div>


                        </div>

                        <div class="table-responsive mt-4">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Job ID</th>
                                            <th>Photo</th>
                                            <th>Title</th>
                                            <th>Hours</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($project->fastworks as $item)
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
                                            <td class="text-center">
                                                {{ $item->hours}}
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
                                        </tr>
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
