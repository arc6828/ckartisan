<div class="col-md-3 mb-4 d-print-none">
    <div class="card">
        <div class="card-header">
            Sidebar
        </div>

        <div class="card-body">
            <ul class="nav" role="tablist" style="flex-direction:column;">
                <li role="presentation">
                    <a href="{{ url('/home') }}">
                        หน้าหลัก
                    </a>
                </li>        
                @if(Auth::check())        
                    <li role="presentation">
                        <a href="{{ url('/fastwork') }}">
                            fastwork
                        </a>
                    </li>                         
                    <li role="presentation">
                        <a href="{{ url('/payment') }}">
                            การสร้างรายได้
                        </a>
                    </li>   
                    @if(Auth::user()->profile->role == "admin")                  
                    <li role="presentation">
                        <a href="{{ url('/profile') }}">
                            นักพัฒนา
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="{{ url('/project') }}">
                            Project
                        </a>
                    </li>                    
                    <li role="presentation">
                        <a href="{{ url('/income') }}">
                            Income
                        </a>
                    </li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
</div>
