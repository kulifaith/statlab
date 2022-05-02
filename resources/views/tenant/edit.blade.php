@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{ URL::route('tenant.index') }}">{{ Lang::choice('Tenant',1) }}</a></li>
	  <li class="active">{{trans('Edit Tenant info')}}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-edit"></span>
		{{trans('Edit tenant info')}}
	</div>
	{{ Form::model($tenant, array(
			'route' => array('tenant.update', $tenant->id), 'method' => 'PUT',
			'id' => 'form-edit-tenant'
		)) }}
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

							<div class="form-group">
		                        {{ Form::label('lastname', 'Last Name')}}
		                        {{ Form::text('lastname',  old('lastname'), array('class' => 'form-control'))}}
		                    </div>
		                    <div class="form-group">
		                        {{ Form::label('firstname', 'First Name')}}
		                        {{ Form::text('firstname',  old('firstname'), array('class' => 'form-control'))}}
		                    </div>
		                    <div class="form-group">
		                        {{ Form::label('middlename', 'Middle Name')}}
		                        {{ Form::text('middlename',  old('middlename'), array('class' => 'form-control'))}}
		                    </div>
		                    <div class="form-group">
		                        {{ Form::label('email', 'Email')}}
		                        {{ Form::text('email',  old('email'), array('class' => 'form-control'))}}
		                    </div>
		                    <div class="form-group">
		                        {{ Form::label('contact', 'Contact')}}
		                        {{ Form::text('contact',  old('contact'), array('class' => 'form-control'))}}
		                    </div>
		                   
								<div class="form-group">
									{{ Form::label('house_id', 'House') }}
									{{ Form::select('house_id', $house, old('house_id'), array('class' => 'form-control', 'id' => 'house_id')) }}
								</div>
								<div class="form-group">
									{{ Form::label('date_in', 'Registration Date') }}
									{{ Form::text('date_in', old('date_in'), array('class' => 'form-control standard-datepicker')) }}
								</div>
								
								<div class="form-group">
                                    <span><strong>Status</strong></span>
                                    <div class="radio-inline">{{ Form::radio('status', '0', true) }} <span class="input-tag">Available</span></div>
                                    <div class="radio-inline">{{ Form::radio("status", '1', false) }} <span class="input-tag">Left</span></div>
                                </div>
                            
								<div class="form-group">
									{{ Form::label('date_out', 'Date of exist') }}
									{{ Form::text('date_out', old('date_out'), array('class' => 'form-control standard-datepicker')) }}
								</div>
			
						<div class="panel-footer">
							<div class="form-group actions-row">
								{{ Form::button(
									'<span class="glyphicon glyphicon-save"></span> '.trans('messages.save'),
									['class' => 'btn btn-primary', 'onclick' => 'submit()']
								) }}
								{{ Form::button(trans('messages.cancel'),
									['class' => 'btn btn-default', 'onclick' => 'javascript:history.go(-1)']
								) }}
							</div>
						</div>
	{{ Form::close() }}
</div>
@stop
