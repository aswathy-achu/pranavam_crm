@extends('index')
@section('content')
<style type="text/css">
.truncate-news {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
<div class="main-content">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h2>Course List</h2>
        <a href="{{ route('addcourse') }}" class="btn btn-primary">+ Add Course</a>
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-4">
                @foreach($course as $c)
                    <div class="col-lg-3 col-sm-6 " style="color:white;">
                        <div class="service-item card text-center pt-3">
                        @if(Auth::user()->type == 'A')
                        <div style="position: absolute; bottom: 10px; right: 10px;">
                            <a href="{{ route('manage_course',['id'=>$c->id]) }}" class="btn btn-primary btn-equal-size">Edit</a>
                            <a href="{{ route('courseview',['id'=>$c->id]) }}" class="btn btn-primary btn-equal-size">Details</a>
                            @if($c->students()->count() == 0)
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#delete_modal" title="Delete" class="btn btn-danger btn-equal-size" onclick="delete_confirm('/del_course/{{$c->id}}')">Delete</a>
                            @else
                            <button class="btn btn-danger btn-equal-size" disabled>Delete</button>
                            @endif
                        </div>
                        @else
                            <div style="position: absolute; bottom: 10px; left: 90px;">
                                <a href="{{ route('courseview',['id'=>$c->id]) }}" class="btn btn-primary btn-equal-size">Details</a>
                                <!-- <a href="javascript:void(0)" data-toggle="modal" data-target="#delete_modal" title="Delete" class="btn btn-danger btn-equal-size" onclick="delete_confirm('/del_course/{{$c->id}}')">Delete</a> -->
                            </div>
                            @endif
                            <a href="{{ route('courseview', ['id' => $c->id]) }}">
                                <div class="p-4" style="min-height: 235px; max-height: 235px">
                                    <div class="article-header">
                                        @if($c->course_file)
                                        <img src="{{ asset('storage/app/course_file/' . $c->course_file) }}" height="75" width="100" style="border-radius: 50%;">
                                        @else
                                        <img src= "{{ config('app.assets') }}/img/news/img08.jpg" height="75" width="100" style="border-radius: 50%;">

                                        @endif
                                    </div>
                                    <h5 class="mb-3">{{$c->course_name}}</h5>
                                    <p class="truncate-news">{{$c->duration}}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
