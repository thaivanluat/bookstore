@extends('layouts.master')

@section('title', trans('customer.customer_list'))

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
@stop

@section('page-heading', trans('customer.customer'))
        
@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">{{ trans('customer.customer_list') }}</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>{{ trans('customer.customer_id') }}</th>
							<th>{{ trans('customer.customer_name') }}</th>
							<th>{{ trans('customer.customer_phone') }}</th>
                            <th>{{ trans('customer.customer_address') }}</th>
                            <th>{{ trans('customer.customer_email') }}</th>
                            <th>{{ trans('customer.customer_debt') }}</th>
							<th>{{ trans('customer.action') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $customer)
						<tr>
							<th class="customer-id"><a href="{{url('/customer/detail', [$customer->makhachhang])}}">{{ $customer->makhachhang }}</a></th>
							<th class="customer-name"><a href="{{url('/customer/detail', [$customer->makhachhang])}}">{{ $customer->hoten }}</a></th>
							<th class="customer-phone">{{ $customer->dienthoai }}</th>
                            <th class="customer-address">{{ $customer->diachi }}</th>
                            <th class="customer-email">{{ $customer->email }}</th>
                            <th style="text-align: right;" class="customer-total-debt">{{ $customer->tongno }}</th>
							<th style="text-align: center;">
								<input type="hidden" class="customer-id" value="{{ $customer->makhachhang }}">
								<button type="button" class="btn btn-primary edit-button" data-toggle="modal" data-target="#editModal">{{ trans('customer.edit') }}</button>
								<button type="button" class="btn btn-danger delete-button" data-toggle="modal" data-target="#deleteModal">{{ trans('customer.delete') }}</button>
							</th>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Edit Modal -->
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{ trans('customer.edit_customer') }}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
			    <label>{{ trans('customer.customer_name') }}</label>
			    <input type="text" class="form-control" id="customerName">
			</div>
			<div class="form-group">
			    <label>{{ trans('customer.customer_phone') }}</label>
			    <input type="number" min="0" class="form-control" id="customerPhone">
			</div>
            <div class="form-group">
			    <label>{{ trans('customer.customer_address') }}</label>
			    <input type="text" class="form-control" id="customerAddress">
			</div>
            <div class="form-group">
			    <label>{{ trans('customer.customer_email') }}</label>
			    <input type="email" class="form-control" id="customerEmail">
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('customer.close') }}</button>
	        <button type="button" class="btn btn-primary save-change-btn">{{ trans('customer.save_changes') }}</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Delete Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{ trans('customer.delete_customer') }}</h5>
            <p class="heading-customer-name" style="margin: auto 5px; font-size: 1.25rem; font-weight: 500;"></p>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		  	<p>{{ trans('customer.are_you_sure') }}</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('customer.close') }}</button>
	        <button type="button" class="btn btn-danger delete-btn">{{ trans('customer.delete') }}</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Add Modal -->
	<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{ trans('customer.add_customer') }}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
			    <label>{{ trans('customer.customer_name') }}</label>
			    <input type="text" class="form-control" id="addCustomerName">
			</div>
			<div class="form-group">
			    <label>{{ trans('customer.customer_phone') }}</label>
			    <input type="number" min="0" class="form-control" id="addCustomerPhone">
			</div>
            <div class="form-group">
			    <label>{{ trans('customer.customer_address') }}</label>
			    <input type="text" class="form-control" id="addCustomerAddress">
			</div>
            <div class="form-group">
			    <label>{{ trans('customer.customer_email') }}</label>
			    <input type="email" class="form-control" id="addCustomerEmail">
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('customer.close') }}</button>
	        <button type="button" class="btn btn-success add-btn">{{ trans('customer.add') }}</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Loading Modal -->
	<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
		<div class="modal-body text-center">
			<div class="loader"></div>
			<div clas="loader-txt">
				<p>{{ trans('customer.please_wait') }}</p>
				<div class="spinner-border text-primary"></div>
			</div>
		</div>
		</div>
	</div>
	</div>
@stop

@section('scripts')
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
    <script src="vendor/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
    <script src="vendor/notify/notify.js"></script>
    <script src="js/customer_index.js"></script>
@stop

@section('add-button')
	<button type="button" class="btn btn-success add-button" data-toggle="modal" data-target="#addModal">
		<i class="fas fa-plus"></i> {{ trans('customer.add_customer') }}
	</button>
@stop


