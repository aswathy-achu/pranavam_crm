<div class="form-group col-5 col-md-5 col-lg-5">
                                <label>Batch Day<span class="text-danger">*</span></label>
                                <select class="form-control" type="time" name="batch" id="batch-day-dropdown" onchange="fetchBatchTimes(this.value)" required>
                                <option value="">--select--</option>
                                @if(isset($student->batch_id))
                                    <?php
                                $batchId = $student->batch_id;
                                $batch = Batch::find($batchId);
                                $days = '';
                                
                                if ($batch) {
                                    $batchDay = $batch->batch_day;
                                    $batchDaysList = Batchdayslist::find($batchDay);
                                    if ($batchDaysList) {
                                        $days = $batchDaysList->week_days;
                                    }
                                }
                                ?>
                                <option value="{{ $student->batch_id }}" data-max-occupancy="{{ $batch->total_no_student }}" data-occupied-students="{{ $batch->occupy_students }}" selected>
                                    {{ $days }}
                                </option>
                                @else
                                    @foreach($batch_daylist as $batch)
                                        <option value="{{ $batch->id }}" data-max-occupancy="{{ $batch->total_no_student }}" data-occupied-students="{{ $batch->occupy_students }}">{{ $batch->week_days }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                            <label>From Time - To Time<span class="text-danger">*</span></label>
                            <select class="form-control" name="from_time" id="from-time-dropdown" onchange="updateBatchId(this.value)" {{ isset($student->batch_id) ? '' : 'disabled' }} required>
                                <option value="">--select--</option>
                                @if(isset($student->batch_id))
                                    <?php
                                    $batch = Batch::find($student->batch_id);
                                    ?>
                                    <option value="{{ $batch->from_time }} - {{ $batch->to_time }}" data-batch-id="{{ $batch->id }}" selected>
                                        {{ $batch->from_time }} - {{ $batch->to_time }}
                                    </option>
                                @endif
                            </select>
                            <input type="hidden" name="batch_id" id="batch_id" value="{{ isset($student->batch_id) ? $student->batch_id : '' }}">
                        </div>
                        <div class="form-group col-5 col-md-5 col-lg-5">
                        <label>Course<span class="text-danger">*</span></label>
                        <select class="form-control" name="course" id="course-dropdown" onchange="updatecourseid(this)" required>
                            <option value="">--select--</option>
                            @foreach($courselist as $course)
                                <option value="{{ $course->id }}" data-batch-id="{{ $course->batch_id }}" 
                                        {{ isset($student->course_id) && $student->course_id == $course->id ? 'selected' : '' }}>
                                    {{ $course->course_name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="course_id" id="course_id" value="{{ isset($student->course_id) ? $student->course_id : '' }}">
                    </div>
