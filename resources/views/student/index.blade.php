@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">List</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="ionicons ion-ios-home"></span>
		 List of Students
		<div class="panel-btn">
                <a class="btn btn-sm btn-info"
                  data-visit-id=""
                  data-url="{{ URL::route('student.create') }}"
                  data-toggle="modal"
                  data-target=".update-student-modal"
                  title="Record New student">
                  <i class="glyphicon glyphicon-plus-sign"></i>
                  Record New Entry
                </a>
            </div>
	</div>

	<div class="panel-body">
		<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Student List</b>
					</div>
					<div class="card-body">
						<table class="table table-striped table-hover table-condensed search-table">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Lab Number</th>
									<th class="text-center">Student</th>
									<th class="text-center">Registration Number</th>
									<th class="text-center">Gender</th>
									<th class="text-center">Time</th>
									<th class="text-center">Row</th>
									<th class="text-center">Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								// header("refresh: 3");
								// echo date('H:i:s Y-m-d');
								?>
								@foreach($student as $key => $value)
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										{{ $value->auto_number }}
									</td>
									<td>
										{{ $value->name }}
									</td>
									<td>
										{{ $value->student_number }}
									</td>
									<td>
										@if($value->gender ==0) M @else F @endif
									</td>
									<td>
										{{ $value->time_in }} - {{ $value->time_out }}
									</td>
									<td>
										{{ $value->records->name }}
									</td>
									<td>
										<?php
										$time1 = date_create($value->time_out);
                                    	$time2 = new DateTime();
                                    	if($time2 <= $time1){
                                    		$update_sql = "update students set status=1 where status=0 AND id=$value->id";
											DB::update($update_sql);
                                    //difference between two dates
                                    	$diff = date_diff($time1,$time2);
                                    	echo $diff->format('%H hrs %i mins');
                                    	}else{
                                    		echo '<span style="color:green;text-align:center;">Completed</span>';
                                    		$update_sql = "update students set status=0 where status=1 AND id=$value->id";
											DB::update($update_sql);
                                    	}
										?>
									</td>
									<td class="text-center">
										<a class="btn btn-sm btn-info" href="{{ URL::to("student/" . $value->id . "/edit") }}" >
											<span class="glyphicon glyphicon-edit"></span>
											Adjust Time
										</a>
					
										
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
	</div>
</div>
<!-- OTHER UI COMPONENTS -->
  <div class="modal fade update-student-modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route' => array('student.index'), 'id' => 'form-create-student')) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="glyphicon glyphicon-plus"></span>
                    Record New student
                </h4>
            </div>
                <div class="modal-body">  
                			<div class="form-group">
								{{ Form::label('auto_number', 'Lab Number', array('class' => 'required')) }}
								{{ Form::text('auto_number', '',
									array('class' => 'form-control', 'readonly' =>'true', 'placeholder' => 'Auto generated upon succesfull save!')) }}
							</div>                    
		                    <div class="form-group">
								<label class="control-label">Student Name</label>
								<input type="text" class="form-control" name="name" required="">
							</div>
							<div class="form-group">
								<label class="control-label">Student number</label>
								<input type="text" class="form-control" name="student_number" required="">
							</div>
							<div class="form-group">
								<label class="control-label">Gender</label>
								<input type="radio" name="gender" value="0" checked> Male<br>
								<input type="radio" name="gender" value="1"> Female<br>
							</div>
							<div class="form-group">
									{{ Form::label('course_id', 'Course') }}
									{{ Form::select('course_id', $course, old('course_id'), array('class' => 'form-control')) }}
								</div>
							<div class="form-group">
									{{ Form::label('row_line', 'Row') }}
									{{ Form::select('row_line', $row, old('row_line'), array('class' => 'form-control')) }}
								</div>
							<div class="form-group">
								<label class="control-label">Duration</label>
								<input type="number" class="form-control" name="duration" required="">
							</div>
							
                </div>
            <div class="modal-footer">
                    {{ Form::button("<span class='glyphicon glyphicon-save'></span> ".trans('messages.submit'),
                        array('class' => 'btn btn-primary', 'data-dismiss' => 'modal', 'onclick' => 'submit()')) }}
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        {{trans('messages.cancel')}}</button>
                </div>
                {{ Form::close() }}
        </div>
    </div>
</div><!-- /.add-specimen-icd-modal --> 
@stop
