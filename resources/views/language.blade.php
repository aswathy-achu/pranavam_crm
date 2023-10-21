@extends('index')
@section('content')
<div class="main-content">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Create Staff</h4>
                    </div>
                <div class="card-body">
                    <form action="{{ url('/terms') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                
                <div class="form-group col-5 col-md-5 col-lg-5 ">
                    <label>Description</label>
                    <input type="text" class="form-control" name="terms_and_condition">
                </div>
                <div class="form-group col-5 col-md-5 col-lg-5">
                <label>Language</label>
                    <select class="form-control"  name="language">
                        <option>Select</option>
                        <option>Malayalam</option>
                        <option>English</option>
                    </select>
                    </div>
                    <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Submit</button>
                            <button class="btn btn-white mr-1" onclick="window.location='{{ URL::previous() }}'">Cancel</button>
                    </div>
            </div>
        </div>
    </div>
</div>


@endsection