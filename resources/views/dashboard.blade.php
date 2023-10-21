
@extends('index')
@section('content')
<?php
use App\Course;
use App\Product;
use App\Batchdayslist;

?>

<div class="main-content">
        <section class="section">
          <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-stats">
                  <div class="card-stats-title">Order Statistics - 
                    <div class="dropdown d-inline">
                      <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="orders-month">August</a>
                      <ul class="dropdown-menu dropdown-menu-sm">
                        <li class="dropdown-title">Select Month</li>
                        <li><a href="#" class="dropdown-item">January</a></li>
                        <li><a href="#" class="dropdown-item">February</a></li>
                        <li><a href="#" class="dropdown-item">March</a></li>
                        <li><a href="#" class="dropdown-item">April</a></li>
                        <li><a href="#" class="dropdown-item">May</a></li>
                        <li><a href="#" class="dropdown-item">June</a></li>
                        <li><a href="#" class="dropdown-item">July</a></li>
                        <li><a href="#" class="dropdown-item active">August</a></li>
                        <li><a href="#" class="dropdown-item">September</a></li>
                        <li><a href="#" class="dropdown-item">October</a></li>
                        <li><a href="#" class="dropdown-item">November</a></li>
                        <li><a href="#" class="dropdown-item">December</a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="card-stats-items">
                    <div class="card-stats-item">
                      <div class="card-stats-item-count">24</div>
                      <div class="card-stats-item-label">Pending</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count">12</div>
                      <div class="card-stats-item-label">Shipping</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count">23</div>
                      <div class="card-stats-item-label">Completed</div>
                    </div>
                  </div>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-archive"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Orders</h4>
                  </div>
                  <div class="card-body">
                    59
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-chart">
                  <canvas id="balance-chart" height="80"></canvas>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Balance</h4>
                  </div>
                  <div class="card-body">
                    $187,13
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-chart">
                  <canvas id="sales-chart" height="80"></canvas>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                  <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Sales</h4>
                  </div>
                  <div class="card-body">
                    4,732
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8">
              <div class="card">
                <div class="card-header">
                  <h4>Budget vs Sales</h4>
                </div>
                <div class="card-body">
                  <canvas id="myChart" height="158"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card gradient-bottom">
                <div class="card-header">
                  <h4>STOCK OF PRODCUTS</h4>
                </div>
                <div class="card-body" id="top-5-scroll">
                  
                <ul class="list-unstyled list-unstyled-border">
                @foreach($productList as $product)
                <li class="media">
                    <img class="mr-3 rounded" width="55" src="{{config('app.assets')}}/img/products/product-3-50.png" alt="product">
                    <div class="media-body">
                        <div class="float-right"><div class="font-weight-600 text-muted text-small"></div></div>
                          <div class="media-title">{{$product->product_name}}</div>
                            <div class="mt-1">
                            <div class="budget-price">
                                <div class="budget-price-square bg-primary" data-width="64%"></div>
                                <div class="budget-price-label">{{$product->product_selling_price}}</div>
                            </div>
                            <div class="budget-price">
                                <div class="budget-price-square bg-danger" data-width="43%"></div>
                                <div class="budget-price-label">{{$product->product_buy_price}}</div>
                            </div>
                            </li>
                          @endforeach
                        </ul>
                <!-- Print the product_selling_price here -->
                <div class="card-footer pt-3 d-flex justify-content-center">
                  <div class="budget-price justify-content-center">
                    <div class="budget-price-square bg-primary" data-width="20"></div>
                    <div class="budget-price-label">Selling Price</div>
                  </div>
                  <div class="budget-price justify-content-center">
                    <div class="budget-price-square bg-danger" data-width="20"></div>
                    <div class="budget-price-label">Budget Price</div>
                  </div>
            </div>
          </div>
        </div>
      </div>
    </div>
   <div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>Best Students</h4>
            </div>
            <div class="card-body">
                <div class="owl-carousel owl-theme" id="products-carousel">
                @foreach ($bestStudents as $student)
                    <div class="product-item pb-3">
                        <div class="product-image">
                            <img alt="image" src="{{ config('app.assets') }}/img/avatar/avatar-3.png" class="img-fluid">
                        </div>
                        <div class="product-details">
                            <div class="product-name">{{ $student->name }}</div>
                            @php
                            $course = Course::find($student->course_id);
                            $courseName = $course ? $course->course_name : '';
                            @endphp
                            <div class="text-small text-muted">{{ $courseName }}</div>
                            <div class="product-cta">
                                <a href="studentlist" class="btn btn-primary">Detail</a>
                            </div>
                        </div> 
                    </div>
                    @endforeach 
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h4>Top Performers Of The Week</h4>
        </div>
        <div class="card-body" style="height: 300px; overflow-y: auto;">
            <div class="row">
                <ul>
                @foreach ($topPerformers as $student)
                    <li class="media">
                        <img class="img-fluid mt-1 img-shadow" src="{{ asset('storage/app/student_photo/'.$student->profile_image) }}" alt="image" width="40">
                        <div class="media-body ml-3">
                            <div class="media-title">{{ $student->name }}</div>
                            @php
                            $course = Course::find($student->course_id);
                            $courseName = $course ? $course->course_name : '';
                            @endphp
                            <div class="text-small text-muted">{{ $courseName }}</div>
                        </div>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card-body p-0">
  <div class="col-lg-12 grid-margin">
    <h3>Due List</h3>
      </div>
        <div class="table-responsive col-12 col-md-12 col-lg-12">
          <table id="data-table" class="table table-hover align-middle mb-0 dataTable ">
            <thead>
              <tr>
                <th>Stud ID</th>
                <th>Student Name</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="col-md-4">
            <div class="card card-hero">
              <div class="card-header">
                <div class="card-icon">
                  <i class="far fa-question-circle"></i>
                </div>
                <div class="card-description">Students need attention</div>
              </div>
              <div class="card-body p-0">
              @foreach ($badStudents as $student)
                  <div class="tickets-list">
                    <a href="#" class="ticket-item">
                      <div class="ticket-title">
                        <h4>{{$student->name}}</h4>
                      </div>
                      <div class="ticket-info">
                      @php
                            $course = Course::find($student->course_id);
                            $courseName = $course ? $course->course_name : '';
                            @endphp
                            <div class="text-small text-muted">{{ $courseName }}</div>
                      </div>
                    </a>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
  @endsection
  @section('contentjs')
  <script type="text/javascript">
  $(document).ready( function () {
  $('.dataTable').dataTable({
       processing: true,
       serverSide: true,
       destroy: true,
       ajax: "{{route('get-fee')}}",
       columns: [
                {
                    data: 'DT_RowIndex',
                    orderable: false, 
                    searchable: false
                }, 
                {data: 'name', name: 'name'},
                {data: 'status', name: 'status'},
                {data: 'due_date', name: 'due_date'},
                {data: 'action', name:'action'},
                
                ] 
    });
});
</script>
    
@endsection

