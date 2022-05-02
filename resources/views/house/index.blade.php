@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">House</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="ionicons ion-ios-home"></span>
		House List
		<div class="panel-btn">
                <a class="btn btn-sm btn-info"
                  data-visit-id=""
                  data-url="{{ URL::route('house.create') }}"
                  data-toggle="modal"
                  data-target=".update-house-modal"
                  title="Record House">
                  <i class="glyphicon glyphicon-plus-sign"></i>
                  Record House
                </a>
            </div>
	</div>

	<div class="panel-body">
		<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>House List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">House No.</th>
									<th class="text-center">Price</th>
									<th class="text-center">Type</th>
									<th class="text-center">Site</th>
									<th class="text-center">Description</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								?>
								@foreach($house as $key => $value)
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<p>House #: <b>{{ $value->house_no }}</b></p>
									</td>
									<td>
										<p><small>Price: <b>{{ $value->price }}</b></small></p>
									</td>
									<td>
										<p><small>House Type: <b>{{ $value->houseType->name }}</b></small></p>
									</td>
									<td>
										<p><small>Site: <b>{{ $value->site->name }}</b></small></p>
									</td>
									<td>
										<p><small>Description: <b>{{ $value->description }}</b></small></p>
									</td>
									<td class="text-center">
										
									<a class="btn btn-sm btn-info" href="{{ URL::to("house/" . $value->id . "/edit") }}" >
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
  <div class="modal fade update-house-modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route' => array('house.index'), 'id' => 'form-create-house')) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="glyphicon glyphicon-plus"></span>
                    Create House Name
                </h4>
            </div>
                <div class="modal-body">                      
							<div class="form-group">
								{{ Form::label('site_id', 'Site') }}
								{{ Form::select('site_id', $site, old('site_id'), array('class' => 'form-control')) }}
							</div>
							<div class="form-group">
								{{ Form::label('category_id', 'Category') }}
								{{ Form::select('category_id', $houseType, old('category_id'), array('class' => 'form-control')) }}
								@if ($errors->has('category_id'))
									<span class="text-danger">
				                            <strong>{{ $errors->first('category_id') }}</strong>
				                        </span>
								@endif
							</div>
							<div class="form-group">
								<label for="" class="control-label">Description</label>
								<textarea name="description" id="" cols="30" rows="4" class="form-control" required></textarea>
							</div>
                    		<div class="form-group">
								<label class="control-label">House No</label>
								<input type="text" class="form-control" name="house_no" required="">
							</div>
							<div class="form-group">
								<label class="control-label">Price</label>
								<input type="number" class="form-control text-right" name="price" step="any" required="">
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
