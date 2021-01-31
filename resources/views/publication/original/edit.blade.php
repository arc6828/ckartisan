@extends('layouts.app')

@section('content')
<div class="container">

  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-12"><h4>Create Publications</h4></div>
      </div>
    </div>

    <div class="card-body">

      <form action="{{ url('/') }}/publication/{{ $publication->id }}" method="POST">
        @csrf
        @method('PUT')
        @include('publication/form')
        <div class="form-group row">
          <div class="col-sm-12 text-center">
            <a href="{{ url('/') }}/publication" class="btn btn-outline-primary" >Back</a>
            <button class="btn btn-primary" type="submit">Save</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">

  document.addEventListener("DOMContentLoaded", function(event) {
    console.log("DOM fully loaded and parsed");
    document.querySelector("#authors").value = "{{ $publication->authors }}" ;
    document.querySelector("#title").value = "{{ $publication->title }}" ;
    document.querySelector("#publisher").value = "{{ $publication->publisher }}" ;
    document.querySelector("#date").value = "{{ $publication->date }}" ;
    document.querySelector("#month").value = "{{ $publication->month }}" ;
    document.querySelector("#year").value = "{{ $publication->year }}" ;
    document.querySelector("#pages").value = "{{ $publication->pages }}" ;
    document.querySelector("#type").value = "{{ $publication->type }}" ;
    document.querySelector("#language").value = "{{ $publication->language }}" ;
    document.querySelector("#city").value = "{{ $publication->city }}" ;
    document.querySelector("#place").value = "{{ $publication->place }}" ;
    onChangeType();


  });

</script>
@endsection
