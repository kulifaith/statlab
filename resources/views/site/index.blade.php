@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">Sites</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="ionicons ion-ios-home"></span>
		 List of Sites
		<div class="panel-btn">
                <a class="btn btn-sm btn-info"
                  data-visit-id=""
                  data-url="{{ URL::route('site.create') }}"
                  data-toggle="modal"
                  data-target=".update-site-modal"
                  title="Record New site">
                  <i class="glyphicon glyphicon-plus-sign"></i>
                  Record New site
                </a>
            </div>
	</div>

	<div class="panel-body">
		<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Site List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Site</th>
									<th class="text-center">Location</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								?>
								@foreach($site as $key => $value)
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<p>Site #: <b>{{ $value->name }}</b></p>
									</td>
									<td>
										<p><small>Location: <b>{{ $value->location }}</b></small></p>
									</td>
									<td class="text-center">
										<a class="btn btn-sm btn-info" href="{{ URL::to("site/" . $value->id . "/edit") }}" >
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
  <div class="modal fade update-site-modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route' => array('site.index'), 'id' => 'form-create-site')) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="glyphicon glyphicon-plus"></span>
                    Record New site
                </h4>
            </div>
                <div class="modal-body">                      
		                    <div class="form-group">
								<label class="control-label">Site Name</label>
								<input type="text" class="form-control" name="name" required="">
							</div>
							<div class="form-group">
								<label for="" class="control-label">Location</label>
								<textarea name="location" id="" cols="30" rows="4" class="form-control" required></textarea>
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
