<tr>
    <td>
        <a href="{{ url('/') }}/storage/{{ isset($item->photo) ? $item->photo : '../images/noimage.png' }}" target="_blank">
            <img src="{{ url('/') }}/storage/{{ isset($item->photo) ? $item->photo : '../images/noimage.png' }}" width="100">
        </a>
    </td>
    <td>
        <h5>
            <a href="{{ url('/') }}/fastwork/{{ $item->id }}">{{ $item->title }} ({{ $item->project->type }})</a>
        </h5>        
        <h5>Job ID : <span class="badge badge-info">#{{ $item->id }}</span></h5>
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
    <td  class="text-center">
        {{ isset($item->hours)? $item->hours : "-" }}
    </td>
    <td>
        @switch($item->status)
            @case("created")                                                     
                <div><span class="badge badge-danger">Created at</span></div>
                <div>{{ $item->created_at }}</div>
                @break
            @case("reserved")                                                 
                <div><span class="badge badge-warning">Reserved at</span></div>
                <div>{{ $item->reserved_at }}</div> 
                @break
            @case("completed")                                                    
                <div ><span class="badge badge-success">Completed at</span></div>
                <div>{{ $item->completed_at }}</div>
                @break
            @case("paid")                                                     
                <div><span class="badge badge-primary">Paid at</span></div>
                <div>{{ $item->paid_at }}</div>
                @break
        @endswitch   
        <div><strong>Developer : </strong></div>  
        @if( isset($item->developer_id) )
            <a href="{{ url('/') }}/user/{{ $item->developer_id }}">{{ $item->developer->name }}</a>
        @else
            {{ $item->developer_id }}
        @endif                                     
    </td>                                        
    <td>
        <form method="POST" action="{{ url('/fastwork' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            @if( !isset($item->reserve_date) )
            
            @endif
            @switch($item->status)
                @case("created")                                                  
                    <input type="hidden" name="reserved_at" value="{{ date('Y-m-d H:i:s')  }}">
                    <input type="hidden" name="status" value="reserved">
                    <input type="hidden" name="developer_id" value="{{ Auth::id() }}">
                    <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-calendar-plus" aria-hidden="true"></i> จอง</button>
                    @break
                @case("reserved") 
                    @if(Auth::user()->profile->role == "admin")
                    <input type="hidden" name="completed_at" value="{{ date('Y-m-d H:i:s')  }}">
                    <input type="hidden" name="status" value="completed">
                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check" aria-hidden="true"></i> เสร็จแล้ว</button>
                    @endif
                    @break
                @case("completed")
                    
                @case("paid")                                                    
                    
                    @break
            @endswitch
        </form>


        <a class="d-none" href="{{ url('/fastwork/' . $item->id) }}" title="View Fastwork"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>

        <form class="d-none" method="POST" action="{{ url('/fastwork' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
            {{ method_field('DELETE') }}
            {{ csrf_field() }}
            <button type="submit" class="btn btn-danger btn-sm" title="Delete Fastwork" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
        </form>
    </td>
</tr>
                                