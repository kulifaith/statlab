@extends("layout-menu")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">Payment</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-cog"></span>
		 Payment List
		 @if( $payment->balance != 0 )
		<div class="panel-btn">
                <a class="btn btn-sm btn-info"
					                  data-visit-id="{{ $payment->id }}"
					                  data-url="{{ URL::route('payment.update', [$payment->id]) }}"
					                  data-toggle="modal"
					                  data-target=".update-rentcost-modal"
					                  title="Update Costs">
					                  <i class="glyphicon glyphicon-plus-sign"></i>
					                  Update Costs
					                </a>
            </div>
            @endif
        <div class="panel-btn">
		<a class="btn btn-sm btn-default" href="{{{route('payment.index')}}}" >
											<span></span>
											Back
										</a>
        </div>
	</div>

	<div class="panel-body">
		<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Payments</b>
					</div>
					<div class="card-body">
						<table class="table table-striped table-hover table-condensed search-table">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Tenant</th>
									<th class="">Amount paid</th>
									<th class="">Balance</th>
									<th class="">Period</th>
								</tr>
							</thead>
							<tbody>
								
								<tr>
									<td class="text-center"></td>
									<td>
										<b>{{ $payment->tenant->firstname }} {{ $payment->tenant->middlename }} {{ $payment->tenant->lastname }}</b>
									</td>
									<td>
										{{ $payment->amount }}
									</td>
									<td>
										{{ $payment->balance }}
									</td>
									<td>
										<p><small><b>{{ $payment->date_from }} - {{ $payment->date_to }}</b></small></p>
									</td>
									
								</tr>
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
    aria-labelledby="myModalLabelx"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('url' => 'payment/update/'.$payment->id)) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;</button>
                <h4 class="modal-title" id="myModalLabelx">
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
