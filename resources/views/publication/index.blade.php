@extends('layouts.app')

@section('meta')
<meta property="og:url"                content="{{ url('/') }}/publication" />
<meta property="og:type"               content="article" />
<meta property="og:title"              content="Publications" />
<meta property="og:description"        content="รวมผลงานที่ได้รับการตีพิมพ์เผยแพร่ต่อสาธารณะของหลักสูตรวิทยาการคอมพิวเตอร์มหาวิทยาลัมหาวิทยาลัยราชภัฏวไลยอลงกรณ์ ในพระบรมราชูปถัมภ์" />
<meta property="og:image"              content="{{ url('/') }}/img/online-exmaination-system.png" />
@endsection

@section('content')
<div class="container">
  <div class="row mb-4">
    <div class="offset-lg-3 col-lg-6 offset-md-2 col-md-8 col-sm-12">
      <img src="{{ url('/') }}/img/online-exmaination-system.png" width="100%" >
    </div>
  </div>  
  <h2 id="title">Publication</h2>
  <h5  class="mb-4 text-center" >
    รวมผลงานที่ได้รับการตีพิมพ์เผยแพร่ต่อสาธารณะของหลักสูตรวิทยาการคอมพิวเตอร์ <br/>มหาวิทยาลัมหาวิทยาลัยราชภัฏวไลยอลงกรณ์ ในพระบรมราชูปถัมภ์
  </h5>
  <div class="d-none" style="margin-bottom : 20px;">
    <a href="{{ url('/') }}/publication/create" class="btn btn-success">New Publication</a>
  </div>
  <div class="card" style="margin-bottom:20px;">
      <div class="card-header">
        <div class="row">
          <div class="col-6"><a href="{{ url('/') }}/publication/create" class="btn btn-success">New Publication</a></div>
          <div class="col-6">
            <form class="text-right" action="{{ url('/') }}/publication#title">
              <input name="authors" id="authors" placeholder="ค้นหาด้วยชื่อ">
              <select name="year" id="year" placeholder="ปีที่ตีพิมพ์" style="height:30px;" onchange="document.querySelector('#form-submit').click(); ">
                <option value="">ทุกปี</option>
                @foreach([2019,2018,2017,2016,2015] as $y)
                <option value="{{ $y }}">{{ ($y) }}</option>
                @endforeach
              </select>

              <button class="btn btn-success btn-sm" type="submit" id="form-submit">Search</button>
            </form>
          </div>
        </div>
      </div>

      <div class="card-body">
        <ul class="nav nav-tabs nav-pills nav-justified" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#table" role="tab" aria-controls="home" aria-selected="true">Table</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#bullet" role="tab" aria-controls="profile" aria-selected="false">Bullet</a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="table" role="tabpanel" aria-labelledby="home-tab" >

            <div class="table-responsive" style="margin-top:20px;">
              <table id="table-publication" class="table table-responsive w-100 d-block d-md-table table-striped table-bordered"></table>
            </div>
          </div>
          <div class="tab-pane fade" id="bullet" role="tabpanel" aria-labelledby="profile-tab">
            @php
              $list_m = ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"];
              $list_mL = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
              $list_mS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];

            @endphp

            <ul style="margin-top:20px;">
              @foreach($publications as $row)
                @if( $row->type === "Conference" )
                <li>
                  {{ $row->authors }}. 
                  ({{ ($row->language === "National") ? ($row->year + 543 ) : $row->year }}).
                  {{ $row->title }}. 
                  {{ ($row->language === "National") ? "ในเอกสารสืบเนื่อง" : "In Proceedings of " }}
                  {{ $row->publisher }}. 
                  {{ $row->date }} 
                  {{ ($row->language === "National") ? $list_m[$row->month-1] : $list_mL[$row->month-1]  }} 
                  {{ ($row->language === "National") ? ($row->year + 543 ) : $row->year }},
                  ({{ $row->pages }}).
                  {{ $row->city }}: {{ $row->place }}
                </li>
                @elseif( $row->type === "Journal" )
                <li>
                  {{ $row->authors }}.     
                  ({{ ($row->language === "National") ? ($row->year + 543 ) : $row->year }}).
                  {{ $row->title }}.
                  {{ $row->publisher }} : 
                  {{ $row->pages }}.
                </li>
                @endif
              @endforeach

              <script>
              //•	ฐาปกรณ์ ต้นสมบูรณ์ และ วิศรุต ขวัญคุ้ม. “ระบบจอง-ยืมรูปเล่มโปรเจคสาขาวิทยาการคอมพิวเตอร”.
                //การประชุมวิชาการระดับชาติด้านวิทยาศาสตร์และเทคโนโลยี ครั้งที่ 2 (NCOST2), 2561, หน้า 54-61.
              //•	วิศรุต ขวัญคุ้ม, จิรารัตน์ เอี่ยมสอาด และธนภัทร เอี่ยมตาล. “การประยุกต์ใช้ขั้นตอนวิธีหิ่งห้อยสำหรับค้นหาแผนการทดลองแบบลาตินไฮเปอร์คิวในการจำลองการทดลองด้วยคอมพิวเตอร์”. การประชุมวิชาการระดับชาติและนานาชาติ ครั้งที่ 2 (NIRC2018), 2561, หน้า 265-274.
              //•	ธนัชพร หันทะยุง และ วิศรุต ขวัญคุ้ม. “การพัฒนาแอพพลิเคชั่นสำหรับการจัดการร้านไก่ย่างห้าดาวบนระบบปฏิบัติการแอนดรอยด์ กรณีศึกษา ร้านไก่ย่างห้าดาว สาขาเคหะออเงิน”. การประชุมวิชาการระดับชาติ วิทยาศาสตร์และเทคโนโลยีระหว่างสถาบัน ครั้งที่ 6 (ASTC2018), 2561, หน้า IT270-IT276.
              //•	วิศรุต ขวัญคุ้ม, จิรารัตน์ เอี่ยมสอาด, ธนภัทร เอี่ยมตาล. “การประยุกต์ใช้วิธีสับค่าและวิธีปรับแก้ในขั้นตอนวิธีสืบค้นสำหรับการจำลองการทดลองด้วยคอมพิวเตอร์”. วารสารวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยมหาสารคาม ปีที่ 37ฉบับที่ 4 (กรกฎาคม - สิงหาคม 2561).
              //•	จิรารัตน์ เอี่ยมสอาด, ธนภัทร เอี่ยมตาล และวิศรุต ขวัญคุ้ม. “อัลกอริทึมตรวจจับโพรงของพื้นกระเบื้องโดยใช้สัญญาณเสียง”. การประชุมวิชาการระดับชาติ ครั้งที่ 3 มหาวิทยาลัยราชภัฏกาญจนบุรี, 2561, หน้า 134-139.

              </script>
            </ul>
          </div>
        </div>
      </div>
  </div>
  <div class="card">
      <div class="card-header">
        ข้อเสนอแนะ
      </div>

      <div class="card-body text-center">
        <p>ทุกคำแนะนำของท่านเราจะนำพัฒนาบริการของเราให้ดีขึ้น ขอขอบคุณสำหรับทุกคำแนะนำ</p>
        <a class="btn btn-success" href="https://goo.gl/forms/IFFEmw0jO1UMMP602">กรอกข้อเสนอแนะ</a>
      </div>
    </div>
</div>
<script type="text/javascript">
  //555
  //{{ $authors }}
  //{{ $year }}
  document.addEventListener("DOMContentLoaded", function(event) {
    console.log("DOM fully loaded and parsed");
    document.querySelector("#authors").value = "{{ $authors }}" ;
    document.querySelector("#year").value = "{{ $year }}" ;
    //console.log("Hello",document.querySelector("#year").value);

    //DATA table
    var jsonData = JSON.parse('@json($publications)');
    var dataSet = [];
    jsonData.forEach(function(element,index){
      var d = new Date(element.year, element.month-1, element.date);
      moment.locale('th');
      d = moment(d).format('YYYY/MM/DD');
      var a = [
        d,
        element.authors,
        "<a href='{{url('/')}}/publication/"+element.id+"/edit'>"+element.title+"</a>",
        element.publisher,
        element.city,
        element.place,
        element.pages,
        element.language + " " + element.type,
        "<a href='#' onclick='onDelete("+element.id+")' class='text-danger'><i class='fa fa-trash-alt'></i></a>"
      ];
      dataSet.push(a);
    });

    $('#table-publication').DataTable( {
        data: dataSet,
        columns: [
            { title: "date" },
            { title: "authors" },
            { title: "title" },
            { title: "publisher" },
            { title: "city" },
            { title: "place" },
            { title: "pages" },
            { title: "type" },
            { title: "action" },
        ]
    } ).order( [ 0, 'desc' ] ).draw();

  });

  function onDelete(id)
  {
    //GET FORM BY ID
    var form = document.querySelector("#form_delete");
    //SUBMIT
    var want_to_delete = confirm('Are you sure to delete this item?');
    if(want_to_delete)
    {
      //CHANGE ACTION TO SPECIFY ID
      form.action = "{{ url('/') }}/publication/"+id;
      form.submit();
    }
  }

</script>

<form action="#" method="POST" id="form_delete" class="d-none" >
  {{ csrf_field() }}
  {{ method_field('DELETE') }}
  <button type="submit">Delete</button>
</form>

@endsection
