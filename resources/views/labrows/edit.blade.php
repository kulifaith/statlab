@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{ URL::route('labrows.index') }}">{{ Lang::choice('Lab Row',1) }}</a></li>
	  <li class="active">{{trans('Edit Row info')}}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-edit"></span>
		{{trans('Edit Row info')}}
	</div>
	{{ Form::model($row, array(
			'route' => array('labrows.update', $row->id), 'method' => 'PUT',
			'id' => 'form-edit-bloodunit'
		)) }}
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

				<div class="form-group">
                    {{ Form::label('name', 'Row name')}}
                    {{ Form::text('name',  old('name'), array('class' => 'form-control'))}}
                </div>
				<div class="form-group">
                    {{ Form::label('no_of_computers', 'Number of houses')}}
                    {{ Form::number('no_of_computers',  old('no_of_computers'), array('class' => 'form-control'))}}
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
