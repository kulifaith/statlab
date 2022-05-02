@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{ URL::route('house.index') }}">{{ Lang::choice('House',1) }}</a></li>
	  <li class="active">{{trans('Edit house info')}}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-edit"></span>
		{{trans('Edit house info')}}
	</div>
	{{ Form::model($house, array(
			'route' => array('house.update', $house->id), 'method' => 'PUT',
			'id' => 'form-edit-houseunit'
		)) }}
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif
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
								{{ Form::label('description', 'Description') }}
								{{ Form::textarea('description', old('description'), array('class' => 'form-control')) }}
							</div>
							<div class="form-group">
								{{ Form::label('house_no', 'House No') }}
								{{ Form::text('house_no', old('house_no'), array('class' => 'form-control')) }}
							</div>
							<div class="form-group">
								{{ Form::label('price', 'Price') }}
								{{ Form::text('price', old('price'), array('class' => 'form-control')) }}
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
