@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{route('user.home')}}}">{{trans('messages.home')}}</a></li>
	  <li class="active">Tenants</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="ion-ios-people"></span>
		 List of Tenants
		<div class="panel-btn">
                <a class="btn btn-sm btn-info"
                  data-visit-id=""
                  data-url="{{ URL::route('tenant.create') }}"
                  data-toggle="modal"
                  data-target=".update-tenant-modal"
                  title="Record New tenant">
                  <i class="glyphicon glyphicon-plus-sign"></i>
                  Record New Tenant
                </a>
            </div>
	</div>

	<div class="panel-body">
		<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Tenants</b>
					</div>
					<div class="card-body">
						<table class="table table-striped table-hover table-condensed search-table">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Name</th>
									<th class="text-center">Contact/Email</th>
									<th class="text-center">House rented</th>
									<th class="text-center">Apartment</th>
									<th class="text-center">Monthly Rate</th>
									<th class="text-center">Status</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								?>
								@foreach($tenant as $key => $value)
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<p>Name #: <b>{{ $value->firstname }} {{ $value->middlename }} {{ $value->lastname }}</b></p>
									</td>
									<td>
										<p>{{ $value->contact }}/{{ $value->email }}</p>
									</td>
									<td>
										<p>{{ $value->house->house_no }}</p>
									</td>
									<td>
										<p><small><b>{{ $value->house->site->name }}</b></small></p>
									</td>
									<td>
										<p><small><b>{{ $value->house->price }}</b></small></p>
									</td>
									<td>
										<p><small><b>@if($value->status == 0)
											Available
											@else 
											Left 
											@endif</b></small></p>
									</td>
									<td class="text-center">
										<a class="btn btn-sm btn-success" href="{{ URL::to("tenant/" . $value->id) }}">
											<span class="glyphicon glyphicon-eye-open"></span>
											{{trans('messages.view')}}
										</a>

										<!-- edit this testtype (uses the edit method found at GET /testtype/{id}/edit -->
										<a class="btn btn-sm btn-info" href="{{ URL::to("tenant/" . $value->id . "/edit") }}" >
											<span class="glyphicon glyphicon-edit"></span>
											Edit Info
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
  <div class="modal fade update-tenant-modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route' => array('tenant.index'), 'id' => 'form-create-tenant')) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;</button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="glyphicon glyphicon-plus"></span>
                    Record New Tenant
                </h4>
            </div>
                <div class="modal-body">                      
						<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
							<div class="form-group">
								<label for="" class="control-label">Last Name</label>
								<input type="text" class="form-control" name="lastname"  value="<?php echo isset($lastname) ? $lastname :'' ?>" required>
							</div>
							<div class="form-group">
								<label for="" class="control-label">First Name</label>
								<input type="text" class="form-control" name="firstname"  value="<?php echo isset($firstname) ? $firstname :'' ?>" required>
							</div>
							<div class="form-group">
								<label for="" class="control-label">Middle Name</label>
								<input type="text" class="form-control" name="middlename"  value="">
							</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label for="" class="control-label">Email</label>
								<input type="email" class="form-control" name="email"  value="<?php echo isset($email) ? $email :'' ?>" required>
							</div>
							<div class="col-md-4">
								<label for="" class="control-label">Contact #</label>
								<input type="text" class="form-control" name="contact"  value="<?php echo isset($contact) ? $contact :'' ?>" required>
							</div>
							
						</div>
								<div class="form-group">
									{{ Form::label('house_id', 'House') }}
									{{ Form::select('house_id', $house, old('house_id'), array('class' => 'form-control', 'id' => 'house_id')) }}
								</div>
								
								
							<div class="form-group">
								<label for="" class="control-label">Registration Date</label>
								<input type="date" class="form-control" name="date_in"  value="<?php echo isset($date_in) ? date("Y-m-d",strtotime($date_in)) :'' ?>" required>
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

<script type="text/javascript">
	$('#house').change(function() {
		var period = $('#house').val();
         selectedPrice = $(this).find("option:selected").data("price")
         $('#price').val(selectedPrice);
    })

$(document).ready(function () {
$('#house').on('change',function(e) {
var cat_id = e.target.value;
$.ajax({
url:"subcat",
type:"POST",
data: {
cat_id: cat_id
},
success:function (data) {
$('#site_id').empty();
$.each(data.site_id[0].site_id,function(index,site){
$('#site_id').append('<option value="'+site.id+'">'+site.name+'</option>');
})
}
})
});
});
</script>
@stop
