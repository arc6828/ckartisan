<div class="col-md-3">
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
                <li role="presentation">
                    <a href="{{ url('/fastwork') }}">
                        fastwork
                    </a>
                </li>                           
                <li role="presentation">
                    <a href="{{ url('/fastwork?search=completed') }}">
                        ชั่วโมงสะสม
                    </a>
                </li>                         
                <li role="presentation">
                    <a href="{{ url('/payment') }}">
                        ประวัติการสร้างรายได้
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
