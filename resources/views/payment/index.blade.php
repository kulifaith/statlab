@extends("layout")
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
		<span class="ionicons ion-ios-browsers"></span>
		 Payment List
		<div class="panel-btn">
                <a class="btn btn-sm btn-info"
                  data-visit-id=""
                  data-url="{{ URL::route('payment.create') }}"
                  data-toggle="modal"
                  data-target=".update-payment-modal"
                  title="Record payment made">
                  <i class="glyphicon glyphicon-plus-sign"></i>
                  Record Payment
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
									<th class="">House #</th>
									<th class="">Paid</th>
									<th class="">Balance</th>
									<th class="">Period</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								?>
								@foreach($payment as $key => $value)
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<b>{{ $value->tenant->firstname }} {{ $value->tenant->middlename }} {{ $value->tenant->lastname }}</b>
									</td>
									<td>
										<p>{{ $value->tenant->house->house_no }}</p>
									</td>
									<td>
										{{ $value->amount }}
									</td>
									<td>
										{{ $value->balance }}
									</td>
									<td>
										<p><small><b>{{ $value->date_from }} - {{ $value->date_to }}</b></small></p>
									</td>
									<td class="text-center">
										<a class="btn btn-sm btn-success" href="{{ URL::to("payment/" . $value->id . "/show") }}">
											<span class="glyphicon glyphicon-eye-open"></span>
											{{trans('View and update')}}
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
  <div class="modal fade update-payment-modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route' => array('payment.index'), 'id' => 'form-create-payment')) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="glyphicon glyphicon-plus"></span>
                    Record payment made
                </h4>
            </div>
                <div class="modal-body">                      
							
							<div class="form-group">
									{{ Form::label('tenant_id', 'Tenant') }}
									{{ Form::select('tenant_id', $tenant, old('tenant_id'), array('class' => 'form-control')) }}
								</div>
							<div class="form-group">
								<label for="" class="control-label">Rent Amount</label>
								<input type="text" class="form-control" name=""  value="" id="rent">
							</div>
							<div class="form-group">
								<label for="" class="control-label">Period</label>
								<input type="text" class="form-control" name=""  value="" id="period">
							</div>
							<div class="form-group">
								<label for="" class="control-label">Expected</label>
								<input type="text" class="form-control" name="expected"  value="" id="totalamount" placeholder="click to generate expected amount">
							</div>
							<div class="form-group">
								<label for="" class="control-label">Amount Paid</label>
								<input type="text" class="form-control" name="amount"  value="" id="paidamount">
							</div>
							<!-- <div class="form-group">
								<label for="" class="control-label">Balance</label>
								<input type="text" class="form-control" name="balance"  value="" id="Balance">
							</div> -->
								
							<div class="form-group">
								<label for="" class="control-label">Period From</label>
								<input type="date" class="form-control" name="date_from"  value="" id="expected_from">
							</div>
							<div class="form-group">
								<label for="" class="control-label">Period To</label>
								<input type="date" class="form-control" name="date_to"  value="" id="Expecteddate">
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
<!-- OTHER UI COMPONENTS -->
  <div class="modal fade update-rentcost-modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabelx"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route' => array('payment.index'), 'id' => 'form-create-payment')) }}
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
<script language="javascript">

        $("#period").change(function(){
            var date_from = $('#rent').val();
            var period = $('#period').val();

            var totalamount = multiplyNumbers(date_from, period);
            $('#totalamount').val(totalamount);          
        });

        
         function multiplyNumbers(date1,date2)
        {
                            
             var date1 = date1; 
             var date2 = date2;
             var n = date1 * date2;

            return n;

        }
      </script>
      <script language="javascript">
        $("#paidamount").change(function(){
            var expected = $('#expected').val();
            var paidamount = $('#paidamount').val();

            var balance = subtractAmount(expected, paidamount);
            $('#Balance').val(balance);          
        });

        function subtractAmount(date1,date2)
        {
                            
             var date1 = date1; 
             var date2 = date2;
             var n = date1 - date2;
            
            return n;

        }
    </script>
    <script language="javascript">

        $("#expected_from").change(function(){
            var expected_from = $('#date_from').val();
            var period = $('#period').val();

            var expecteddate = expectedDate(expected_from, period);
            $('#Expecteddate').val(expecteddate);          
        });

        function expectedDate(date1,period)
        {
                            
             var date1 = new Date(date1); 
             var period = period;
             var n = 0;

             var newDate = new Date(date1.setMonth(date1.getMonth()+ period));

            return newDate;

        }
    </script>
@stop
