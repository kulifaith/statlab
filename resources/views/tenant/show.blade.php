@extends("layout")
@section("content")
	<div>
		<ol class="breadcrumb">
		  <li><a href="{{{route('user.home')}}}">{{trans('messages.home')}}</a></li>
		  <li><a href="{{ route('tenant.index') }}">{{ Lang::choice('Tenant',1) }}</a></li>
		  <li class="active">{{trans('tenant details')}}</li>
		</ol>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading ">
			<span class="glyphicon glyphicon-cog"></span>
			{{trans('Tenant details')}}
			<div class="panel-btn">
				<a class="btn btn-sm btn-info" href="{{ URL::to("tenant/". $tenant->id ."/edit") }}">
					<span class="glyphicon glyphicon-edit"></span>
					{{trans('messages.edit')}}
				</a>
			</div>
		</div>
		<div class="panel-body">
			<div class="display-details">
				<p class="view"><strong>{{ Lang::choice('messages.name',1) }}</strong>{{ $tenant->firstname }} {{ $tenant->middlename }} {{ $tenant->lastname }}</p>
				<p class="view-striped"><strong>{{trans('Contact')}}</strong>
					{{ $tenant->contact }} | {{ $tenant->email }}</p>
				<p class="view-striped"><strong>{{trans('Occupied house')}}</strong>
					<b>{{ $tenant->house->house_no }}</b> of type <b>{{ $tenant->house->housetype->name }}</b> at <b>{{ $tenant->house->site->name }}</b></p>
				<p class="view"><strong>{{ Lang::choice('Date of Entry',1) }}</strong>
					{{ $tenant->date_in }}</p>

				<p class="view"><strong>{{trans('Presence of tenant')}}</strong>
					@if($tenant->status == 0)
					Available
				@else
				Exited/Left
			@endif</p>
				<p class="view-striped"><strong>{{trans('Date of exit')}}</strong>
					{{ $tenant->date_out }}</p>
			</div>
		</div>
	</div>
@stop
