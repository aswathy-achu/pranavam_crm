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
    <div class="col-lg-10 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2>Product View</h2>
                <div class="container">
                    @foreach($product as $pro)
                    <div class="col-md-12">
                        <div class="card flex-sm-row align-items-sm-center">
                            <div class="card-body" style="padding-bottom: 60px;">
                                <div class="d-flex flex-column flex-sm-row">
                                    @if($pro->product_image)
                                    <img src="{{ asset('storage/app/product_image/' . $pro->product_image) }}" height="75" width="90" style="border-radius: 50%;">
                                    @else
                                    <img src="{{ config('app.assets') }}/img/avatar/avatar-1.png" height="75" width="100" style="border-radius: 50%;">
                                    @endif
                                </div>
                                  <div class="flex" style="min-width: 200px; height: 150px;">
                                        <h3><a href="" style="color: black;">{{$pro->product_name}}</a></h3>
                                        <h4 class="text-black-70 truncate-news">Product Price:{{$pro->product_buy_price}}</h4>
                                        <h4 class="text-black-70 truncate-news">Product Selling Price:{{$pro->product_selling_price}}</h4>
                                        <div class="d-flex align-items-end">
                                            <div class="d-flex flex flex-column mr-3">
                                                <div class="d-flex align-items-center border-bottom">
                                                    <small class="text-black-70 mr-2 mb-1">{{$pro->description}}</small><br>
                                                    <p class="text-black-70 truncate-news">
                                                        <!-- &#8377;1,230/mo -->
                                                    </p>
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
