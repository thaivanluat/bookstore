@extends('layouts.master')

@section('title', trans('receipt.receipt_list'))

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/select2-4.0.13/css/select2.min.css" rel="stylesheet">
	<link href="vendor/select2-4.0.13/css/select2-boostrap.min.css" rel="stylesheet">
@stop

@section('page-heading', trans('receipt.receipt'))
        
@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">{{trans('receipt.receipt_list')}}</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>{{trans('receipt.receipt_id')}}</th>
							<th>{{trans('receipt.date_created')}}</th>
                            <th>{{trans('receipt.customer_id')}}</th>
                            <th>{{trans('receipt.customer_name')}}</th>
							<th>{{trans('receipt.total')}}</th>
                            <th>{{trans('receipt.action')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $receipt)
						<tr>
							<th class="receipt-name">#{{ $receipt->maphieuthu }}</th>
							<th class="receipt-date-created">{{ $receipt->ngaylap }}</th>
                            <th class="receipt-customer-id"><a href="{{url('/customer/detail', [$receipt->makhachhang])}}">{{ $receipt->makhachhang }}</a></th>
                            <th class="receipt-customer-name"><a href="{{url('/customer/detail', [$receipt->makhachhang])}}">{{ $receipt->hoten }}</a></th>
                            <th class="receipt-total">{{ number_format($receipt->sotienthu) }} ₫</th>
                            <th style="text-align: center;">
								<input type="hidden" class="receipt-id" value="{{ $receipt->maphieuthu }}">
								<button type="button" class="btn btn-danger delete-button" data-toggle="modal" data-target="#deleteModal">Delete</button>
							</th>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

    <!-- Add Modal -->
	<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{trans('receipt.add_receipt')}}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
            <div class="form-group">
                <label>{{trans('receipt.customer')}}</label>
                <select class="form-control" id="customerSearch">
				</select>
                <input type="hidden" class="customer-debt" value="">
            </div>
	        <div class="form-group">
			    <label>{{trans('receipt.receipt_value')}}</label>
			    <input type="number" min="0" placeholder="0" class="form-control" id="addReceiptValue">
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('receipt.close')}}</button>
	        <button type="button" class="btn btn-success add-btn">{{trans('receipt.add')}}</button>
	      </div>
	    </div>
	  </div>
	</div>

    <!-- Delete Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{trans('receipt.delete_receipt')}}</h5>
			<p class="heading-receipt-name" style="margin: auto 5px; font-size: 1.25rem; font-weight: 500;"></p>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		  	<p>{{trans('receipt.are_you_sure')}}</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('receipt.close')}}</button>
	        <button type="button" class="btn btn-danger delete-btn">{{trans('receipt.delete')}}</button>
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
				<p>{{trans('receipt.please_wait')}}</p>
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
    <script src="vendor/select2-4.0.13/js/select2.min.js"></script>
    <script src="js/receipt_index.js"></script>
@stop

@section('add-button')
    <button type="button" class="btn btn-success add-button" data-toggle="modal" data-target="#addModal">
		<i class="fas fa-plus"></i> {{trans('receipt.add_receipt')}}
	</button>
@stop