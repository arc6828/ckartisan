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

      <form action="{{ url('/') }}/publication" method="POST">
        @csrf
        @method('POST')
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
@endsection
