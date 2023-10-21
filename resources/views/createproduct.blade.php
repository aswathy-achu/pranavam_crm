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
                    <form action="{{ url('/product_update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product->id ?? '' }}">
                        <div class="row">
                        </div>    
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Product Name</label>
                            <input type="text" class="form-control" value="{{ $product->product_name ?? '' }}" name="product_name">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Product Price</label>
                            <input type="text" class="form-control" value="{{ $product->product_buy_price ?? '' }}" name="product_buy_price">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>Selling Price</label>
                            <input type="text" class="form-control" value="{{ $product->product_selling_price ?? '' }}" name="product_selling_price">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5 ">
                            <label>Description</label>
                            <input type="text" class="form-control" value="{{ $product->description ?? '' }}" name="description">
                        </div>
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>File</label>
                                @if(isset($product->product_image))
                                <input type="file" accept="image/jpeg,image/jpg,image/png" name="product_image" id="profile-picture" class="dropify"  data-min-width="150px" data-height="200px" data-default-file="{{ asset('storage/app/product_image/'.$product->product_image) }}">
                                @else
                                <input type="file" accept="image/jpeg,image/jpg,image/png" name="product_image" id="profile-picture" class="dropify"  data-min-width="150px" data-height="200px">
                                @endif    
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1" type="submit">Submit</button>
                            <button class="btn btn-white mr-1" onclick="window.location='{{ URL::previous() }}'">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('contentjs')
<script type="text/javascript">
  $('.dropify').dropify();  
</script>
@endsection



