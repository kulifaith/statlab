@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{ route('user.home') }}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{ route('house.index') }}">{{ Lang::choice('Houses',1) }}</a><li class="active">{{trans('Add house')}}</li>
	</ol>
</div>
<div class="panel panel-primary col-md-8" style="margin-left: 100px;">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-cog"></span>
		{{trans('House Form')}}
	</div>
	{{ Form::open(array('route' => array('house.index'), 'id' => 'form-create-house')) }}
	<div class="panel-body">
	<!-- if there are creation errors, they will show here -->

		@if($errors->all())
			<div class="alert alert-danger">
				{{ HTML::ul($errors->all()) }}
			</div>
		@endif

			<div class="col-md-12">
			<form action="" id="manage-house">
				<div class="card">
					<div class="card-header">
						    House Form
				  	</div>
					<div class="card-body col-md-12">
							<div class="form-group" id="msg"></div>
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">House No</label>
								<input type="text" class="form-control" name="house_no" required="">
							</div>
							<div class="form-group">
								{{ Form::label('category_id', 'Category') }}
								{{ Form::select('category_id', $houseType, array('class' => 'form-control')) }}
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
								<label class="control-label">Price</label>
								<input type="number" class="form-control text-right" name="price" step="any" required="">
							</div>
					</div>
					<!-- <div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="reset" > Cancel</button>
							</div>
						</div>
					</div> -->
				</div>
			</form>
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
