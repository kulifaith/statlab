@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">Courses</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="ionicons ion-ios-home"></span>
		 List of Courses
		<div class="panel-btn">
                <a class="btn btn-sm btn-info"
                  data-visit-id=""
                  data-url="{{ URL::route('course.create') }}"
                  data-toggle="modal"
                  data-target=".update-course-modal"
                  title="Record New course">
                  <i class="glyphicon glyphicon-plus-sign"></i>
                  Record New course
                </a>
            </div>
	</div>

	<div class="panel-body">
		<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Row List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Name of Course</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								?>
								@foreach($row as $key => $value)
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<p>Course #: <b>{{ $value->name }}</b></p>
									</td>
									
									<td class="text-center">
										<a class="btn btn-sm btn-info" href="{{ URL::to("course/" . $value->id . "/edit") }}" >
											<span class="glyphicon glyphicon-edit"></span>
											Edit
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
  <div class="modal fade update-course-modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route' => array('course.index'), 'id' => 'form-create-rows')) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="glyphicon glyphicon-plus"></span>
                    Record New Row
                </h4>
            </div>
                <div class="modal-body">                      
		                    <div class="form-group">
								<label class="control-label">Name/Number</label>
								<input type="text" class="form-control" name="name" required="">
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
