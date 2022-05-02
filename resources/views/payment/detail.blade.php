@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li><a href="{{{route('tenant.summary')}}}">Payment</a></li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-cog"></span>
		 Tenant Records ({{count($detail)}})
	<span align= 'margin-right'>
		<a class="btn btn-sm btn-default" href="{{{route('tenant.summary')}}}" >
											<span></span>
											Back
										</a>
	</span>
		
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
									<th class="">Paid</th>
									<th class="">Balance</th>
									<th class="">Payment Period</th>
									<th class=""># of months</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								?>
								@foreach($detail as $key => $value)

								<?php
								$date1 = $value->date_from;
								$date2 = $value->date_to;

								$ts1 = strtotime($date1);
								$ts2 = strtotime($date2);

								$year1 = date('Y', $ts1);
								$year2 = date('Y', $ts2);

								$month1 = date('m', $ts1);
								$month2 = date('m', $ts2);

								$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<b>{{ $value->firstname }}</b>
									</td>
									<td>
										<p>{{ $value->house_no }}/{{ $value->site }}</p>
									</td>
									<td>
										{{ $value->price }}
									</td>
									<td>
										{{ $value->amount }}
									</td>
									<td>
										{{ $value->balance }}
									</td>
									<td>
										{{ date('d-M-Y', strtotime($value->date_from)) }} - {{ date('d-M-Y', strtotime($value->date_to)) }}
									</td>
									<td>{{$diff}}</td>
									<td class="text-center">
									<a class="btn btn-sm btn-default" href="{{ URL::to('tenantReceipt/'.$value->tenantId.'/'.$value->id ) }}"
                                target="_blank">
                                <span class="glyphicon glyphicon-print"></span>
                                Receipt
                            </a>
                            		<a class="btn btn-sm btn-default" href="{{ URL::to('sendReceipt/'.$value->tenantId.'/'.$value->id ) }}"
                                target="_blank">
                                <span class="ionicons ion-arrow-up-a"></span>
                                mail
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
  <div class="modal fade update-rentcost-modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('url' => 'payment/update/'.$value->id)) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="glyphicon glyphicon-plus"></span>
                    Update Amount Paid
                </h4>
            </div>
                <div class="modal-body">                      
                    <div class="form-group">
                        {{ Form::label('amount', 'Enter Amount Here:')}}
                        {{ Form::text('amount',  old('amount'), array('class' => 'form-control'))}}
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
