@extends('index')
@section('content')

<div class="main-content">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Attendance</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('attendencestudentlist') }}" method="POST">
                            @csrf
                            @if(isset($batch) && isset($course))
                                <input type="hidden" name="batch_id" value="{{ $batch->id }}">
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <h3>Student List</h3>
                                </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <th class="p-0 text-center">
                                                                Attendance
                                                            </th>
                                                            <th>Student Name</th>
                                                        </tr>
                                                        @foreach($students as $student)
                                                            <tr>
                                                                <td class="p-0 text-center">
                                                                    <div class="custom-checkbox custom-control">
                                                                        <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-{{$student->id}}" name="attendance[]" value="{{$student->id}}" @if(in_array($student->id, $selectedStudentIds)) checked @endif>
                                                                        <label for="checkbox-{{$student->id}}" class="custom-control-label">&nbsp;</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    {{$student->name}}
                                                                </td>
                                                            </tr>
                                                            @endforeach


                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Attendance</button>
                        <!-- <a href="{{ URL::previous() }}" class="btn btn-secondary">Submit Attendence</a> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
