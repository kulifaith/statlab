@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">Summary</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="ion-ios-people"></span>
		 Tenant Records ({{count($data)}})
		
	</div>

	<div class="panel-body">
		<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Tenant Summary</b>
					</div>
					<div class="card-body">
						<table class="table table-striped table-hover table-condensed search-table">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Tenant</th>
									<th class="">House #</th>
									<th class="">Monthly rate</th>
									<th class="">Outstanding Balance</th>
									<th class="">Last payment</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								?>
								@foreach($data as $key => $value)
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<b>{{ $value->firstname }} {{ $value->middlename }} {{ $value->lastname }}</b>
									</td>
									<td>
										<p>{{ $value->house_no }}/{{ $value->site }}</p>
									</td>
									<td>
										{{ $value->price }}
									</td>
									<td>
										{{ $value->balance }}
									</td>
									<td>
										<?php
									$date1 = date_create($value->latestdate);
									$date2 = new DateTime();

									//difference between two dates
									$diff = date_diff($date1,$date2);
									//count days
									if($date2 >= $date1){
										echo '<span style="color:#FF0000;text-align:center;" class="glyphicon glyphicon-star"></span>';
											echo ''. $diff->format("%m")."months". " & ".$diff->format("%d") ." days past";
											echo '<br>' . $value->latestdate;
									}
									elseif($diff->m == 0){
									if($diff->d >= 0 && $diff->d <= 7){
											echo '<span style="color:#FF0000;text-align:center;" class="glyphicon glyphicon-star"></span>';
											echo '' . $diff->format("%d") ." days left";
											echo '<br>' . $value->latestdate;
										}
									}
									else{

										echo $value->latestdate;
									}
									?>
									</td>
									<td class="text-center">
										<a class="btn btn-sm btn-success" href="{{ URL::to('tenant_detail/' . $value->id) }}" >
											<span class="glyphicon glyphicon-eye-open"></span>
											{{trans('Details')}}
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

@stop
