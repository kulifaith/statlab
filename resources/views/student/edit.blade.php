@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{ URL::route('student.index') }}">{{ Lang::choice('Student',1) }}</a></li>
	  <li class="active">{{trans('Edit Student info')}}</li>
	</ol>
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-edit"></span>
		{{trans('Edit Student info')}}
	</div>
	{{ Form::model($student, array(
			'route' => array('student.update', $student->id), 'method' => 'PUT',
			'id' => 'form-edit-bloodunit'
		)) }}
		<div class="panel-body">
			@if($errors->all())
				<div class="alert alert-danger">
					{{ HTML::ul($errors->all()) }}
				</div>
			@endif

							<div class="form-group">
								{{$student->name}}
							</div>
							<div class="form-group">
			                    {{ Form::label('gender', trans('messages.gender')) }}
			                    <div>{{ Form::radio('gender', '0', true) }}<span class='input-tag'>
			                    	Male</span></div>
			                    <div>{{ Form::radio('gender', '1', false) }}<span class='input-tag'>
			                    	Female</span></div>
							</div>
							<div class="form-group">
									{{ Form::label('row_line', 'Row') }}
									{{ Form::select('row_line', $row, old('row_line'), array('class' => 'form-control')) }}
								</div>
							<div class="form-group">
								<label class="control-label">Duration</label>
								<input type="number" class="form-control" name="duration" required="">
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
