<div>
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">authors <span class="text-danger">*</span></label>
    <div class="col-sm-10">
      <input class="form-control" name="authors" id="authors" placeholder="ชื่อผู้เขียน" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">title<span class="text-danger">*</span></label>
    <div class="col-sm-10">
      <input class="form-control" name="title" id="title" placeholder="ชื่อเรื่อง" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">publisher<span class="text-danger">*</span></label>
    <div class="col-sm-10">
      <input class="form-control" name="publisher" id="publisher" placeholder="สถานที่ตีพิมพ์">
    </div>
    <div class="offset-sm-2 col-sm-10 ">
      
    </div>
    <div class="offset-sm-2 col-sm-10 text-primary">
      ยกตัวอย่าง เช่น
      <ul>
        <li>conference  เช่น การประชุมวิชาการระดับชาติ วิทยาศาสตร์และเทคโนโลยีระหว่างสถาบัน  (ASTC2018). ครั้งที่ 6</li>
        <li>journal  เช่น วารสารวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยมหาสารคาม. ปีที่ 37 ฉบับที่ 4. กรกฎาคม - สิงหาคม 2561</li>
      </ul>      
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Date<span class="text-danger">*</span></label>
    <div class="col-sm-2">
      <input type="number" class="form-control" name="date" id="date" value="1"  >
    </div>
    <div class="col-sm-5">
      <select name="month" id="month" class="form-control" required>
        @php
          $list_m = ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"];
        @endphp
        @foreach($list_m as $m)
        <option value="{{ $loop->iteration }}">{{ $m }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-sm-3">
      <input type="number" class="form-control" name="year" id="year" value="2562"  required>
    </div>
    <div class="offset-sm-2 col-sm-10 text-primary">
      ยกตัวอย่าง เช่น กรอกเป็น 2019 หรือ 2562 ก็ได้
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">pages<span class="text-danger">*</span></label>
    <div class="col-sm-10">
      <input class="form-control" name="pages" id="pages" placeholder="หน้า">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Region <span class="text-danger">*</span></label>
    <div class="col-sm-4">
      <select name="language" id="language"  class="form-control">
        <option value="National">National</option>
        <option value="International">International</option>
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Type<span class="text-danger">*</span></label>
    <div class="col-sm-4">
      <select name="type" id="type" class="form-control" onchange="onChangeType();">
        <option value="Conference">Conference</option>
        <option value="Journal">Journal</option>
      </select>
    </div>
  </div>
  <div class="conference-only">
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">City<span class="text-danger">*</span></label>
      <div class="col-sm-10">
        <input class="form-control" name="city" id="city" placeholder="จังหวัด...">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Place<span class="text-danger">*</span></label>
      <div class="col-sm-10">
        <input class="form-control" name="place" id="place" placeholder="สถานที่...">
      </div>
    </div>
  </div>  
</div>
<script>
  function hideConferenceOnly(){
    $(".conference-only").addClass("d-none");
  }
  function showConferenceOnly(){
    $(".conference-only").removeClass("d-none");
  }
  function onChangeType(){
    if($("#type").val() === "Conference"){
      showConferenceOnly();
    }else if($("#type").val() === "Journal"){
      hideConferenceOnly();
    }
  }
</script>