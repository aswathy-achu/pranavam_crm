@extends('index')
@section('content')
<div class="main-content">
  <div class="card">
    <div class="card-header">
      <h3>Staff Permission</h3>
      <!-- <button type="button" class="btn btn-primary btn-rounded btn-fw float-right" onclick="showLargePermissionModal('#permissionmodal');" style="width: 165px; margin: 0 5px 10px 0; border-radius: 20px;"><i class="mdi mdi-plus btn-icon-prepend"></i> Add Permission</button> -->

    </div>
  </div>
  <div class="row">
    <div class="col-12 col-md-12 col-lg-12"> 
      <div class="card">
        <div class="card-body">
            <!-- <div class="card">
              <div class="card-body"> -->
                <form class="forms-sample" action="{{route('manage_permission')}}" method="post" enctype="multipart/form-data">
                  @csrf
                    <input type="hidden" name="id" value="{{$staff->id ?? ''}}">
                      <div class="form-check">
                        @foreach($permissions as $p)
                            <div>
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="checkbox[]" value="{{ $p->name }}" {{ in_array($p->name, $items ?? []) ? 'checked' : '' }}> 
                                    {{ $p->name }}
                                </label>
                            </div>
                        @endforeach
                      </div>
                      <div class="card-footer float-right">
                          <button type="submit" class="btn btn-primary mr-2 ">Submit</button>
                          <button type="reset" class="btn btn-dark " onclick="window.location='{{ URL::previous() }}'">Cancel</button>
                      </div> 
                </form><!-- Add clearfix to clear floats -->
              <!-- </div>
            </div> -->
        </div>
    </div>
  </div>
</div>
@endsection
