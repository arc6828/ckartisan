@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="text-center">
                    <img class="card-img-top" src="{{ url('/') }}/images/fastwork.png" />
                </div>
                <div class="card-body">
                    <h1>Hello</h1>
                    <p>รับงาน Programming part-time สมัครเลย</p>
                    <div class="links text-center" >
                        <a class="btn btn-primary" href="https://www.facebook.com/groups/2367548006628254/">Facebok Group</a>
                        <a class="btn btn-success" href="{{ url('/') }}/fastwork">มีงานอะไรบ้าง</a>
                    </div>


                </div>


            </div>
        </div>
    </div>
</div>
@endsection
