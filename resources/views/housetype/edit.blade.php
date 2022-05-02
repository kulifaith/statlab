@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{ URL::route('housetype.index') }}">{{ Lang::choice('House type',1) }}</a></li>
	  <li class="active">{{trans('Edit house type')}}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-edit"></span>
		{{trans('Edit house type')}}
	</div>
	{{ Form::model($houseType, array(
			'route' => array('housetype.update', $houseType->id), 'method' => 'PUT',
			'id' => 'form-edit-bloodunit'
		)) }}
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

			<div class="form-group">
                        {{ Form::label('name', 'House Type')}}
                        {{ Form::text('name',  old('name'), array('class' => 'form-control'))}}
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
