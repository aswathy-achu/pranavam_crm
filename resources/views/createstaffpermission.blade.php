@extends('index')
@section('content')
<div class="modal fade" id="permissionmodal" tabindex="-1" role="dialog" aria-labelledby="permissionmodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="card">
                <div class="card-header">
                <h5 class="modal-title" id="permissionmodal">Staff Permission</h5>
                </div>
                <div class="card-body">
                    <form action="{{ url('/managestaffpermission') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $permission->id ?? '' }}">
                        <div class="form-group col-9 col-md-9 col-lg-12">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $permission->name ?? '' }}" name="permission_name">
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Submit</button>
                            <button class="btn btn-secondary" type="reset">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        @endsection
       