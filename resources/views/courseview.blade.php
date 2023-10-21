@extends('index')
@section('content')

<style type="text/css">
.truncate-news {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

<div class="main-content">
  <div class="container">
    <div class="col-lg-10 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <a href="{{ route('courselist') }}" class="btn btn-primary mb-3">
              <i class="fa fa-arrow-left"></i> Back
          </a>
          <h2>Course View</h2>
          @foreach($course as $c)
            <div class="col-md-12">
              <div class="card flex-sm-row align-items-sm-center">
                <div class="card-body" style="padding-bottom: 60px;">
                  <div class="d-flex flex-column flex-sm-row">
                      @if($c->course_file)
                        <img src="{{ asset('storage/app/course_file/' . $c->course_file) }}" height="75" width="90" style="border-radius: 50%;">
                      @else
                        <img src="{{ config('app.assets') }}/img/avatar/avatar-1.png" height="75" width="90" style="border-radius: 50%;">
                      @endif
                  </div>
                    <div class="flex" style="min-width: 200px; height: 150px;">
                      <h2><a href="#" style="color: black;">{{$c->course_name}}</a></h2>
                      <h4 class="text-black-70 truncate-news">Course Fee: {{$c->course_fee}}</h4>
                      <h4 class="text-black-70 truncate-news">Course Duration: {{$c->duration}}</h4>
                      
                      <div class="d-flex align-items-end">
                        <div class="d-flex flex flex-column mr-3">
                          <div class="d-flex align-items-center border-bottom">
                            <medium class="text-black-70 mr-2 mb-1">{{$c->description}}</medium>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>  
</div>

@endsection
