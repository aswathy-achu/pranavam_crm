@extends('index')
@section('content')
<?php
use App\Batchdayslist;
?>

<div class="main-content">
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <a href="{{route('createbatch')}}" class="btn btn-primary">+ Create New Batch</a>
          </div>
          <div class="card-body">
            <div class="card">
              <div class="card-header">
                <h3>Day List</h3>
              </div>
              <div class="card-body">
                <div class="list-group">
                  @foreach($batch as $batchItem)
                    <?php
                      $batch_day = $batchItem->batch_day;
                      $days = Batchdayslist::where('id', $batch_day)->first();
                    ?>
                    <a href="{{ route('timeschedule', ['id' => $batch_day]) }}" class="list-group-item list-group-item-action" style="text-align: left;">
                      {{ $days->week_days ?? '' }}
                    </a>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
