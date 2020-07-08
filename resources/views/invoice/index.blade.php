@extends('layouts.master')

@section('title', trans('invoice.invoice_list'))

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
@stop

@section('page-heading', trans('invoice.invoice'))
        
@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">{{trans('invoice.invoice_list')}}</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>{{trans('invoice.invoice_id')}}</th>
							<th>{{trans('invoice.date_created')}}</th>
                            <th>{{trans('invoice.customer_id')}}</th>
                            <th>{{trans('invoice.customer_name')}}</th>
							<th>{{trans('invoice.amount_received')}}</th>
                            <th>{{trans('invoice.debt')}}</th>
                            <th>{{trans('invoice.total')}}</th>
							<th style="width: 10%;">{{trans('invoice.created_by')}}</th>
                            <th style="width: 20%;">{{trans('invoice.action')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $invoice)
						<tr>
							<th class="invoice-name"><a target="_blank" href="{{url('/invoice/detail', [$invoice->mahoadon])}}">#{{ $invoice->mahoadon }}</a></th>
							<th class="invoice-date-created">{{ $invoice->ngaylap }}</th>
                            <th class="invoice-customer-id"><a href="{{url('/customer/detail', [$invoice->makhachhang])}}">{{ $invoice->makhachhang }}</a></th>
							<th class="invoice-customer-name"><a href="{{url('/customer/detail', [$invoice->makhachhang])}}">{{ $invoice->hoten }}</a></th>
							<th class="invoice-amount-received">{{ number_format($invoice->sotientra) }}</th>
							<th class="invoice-debt">{{ number_format($invoice->tongtien - $invoice->sotientra) }}</th>
							<th class="invoice-total">{{ number_format($invoice->tongtien) }}</th>
							<th class="invoice-created-by">{{ $invoice->nguoitao }}</th>
							<th style="text-align: center;">
								<input type="hidden" class="invoice-id" value="{{ $invoice->mahoadon }}">
								<a target="_blank" href="{{url('/invoice/detail', [$invoice->mahoadon])}}" class="btn btn-info detail-button"><i class="fas fa-info-circle"></i> {{trans('invoice.detail')}}</a>
								<button type="button" class="btn btn-danger delete-button" data-toggle="modal" data-target="#deleteModal">{{trans('invoice.delete')}}</button>
							</th>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

    <!-- Delete Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{trans('invoice.delete_invoice')}}</h5>
			<p class="heading-invoice-name" style="margin: auto 5px; font-size: 1.25rem; font-weight: 500;"></p>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		  	<p>{{trans('invoice.are_you_sure')}}</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('invoice.close')}}</button>
	        <button type="button" class="btn btn-danger delete-btn">{{trans('invoice.delete')}}</button>
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
				<p>{{trans('invoice.please_wait')}}</p>
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
    <script src="js/invoice_index.js"></script>
@stop

@section('add-button')
	<a href="{{url('/invoice/add')}}" class="btn btn-success add-button" >
		<i class="fas fa-plus"></i> {{trans('invoice.add_invoice')}}
	</a>
@stop