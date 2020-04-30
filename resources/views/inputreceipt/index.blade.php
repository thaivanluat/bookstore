@extends('layouts.master')

@section('title', 'Input Receipt List')

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
@stop

@section('page-heading', 'Input Receipt')
        
@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Input Receipt List</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>ID</th>
							<th>Date created</th>
							<th>Total</th>
                            <th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $inputReceipt)
						<tr>
							<th class="input-receipt-name"><a target="_blank" href="{{url('/inputreceipt/detail', [$inputReceipt->maphieunhapsach])}}">#{{ $inputReceipt->maphieunhapsach }}</a></th>
							<th class="input-receipt-date-created">{{ $inputReceipt->ngaylap }}</th>
                            <th class="input-receipt-total">{{ number_format($inputReceipt->tongtien) }}</th>
							<th style="text-align: center;">
								<input type="hidden" class="input-receipt-id" value="{{ $inputReceipt->maphieunhapsach }}">
								<a target="_blank" href="{{url('/inputreceipt/detail', [$inputReceipt->maphieunhapsach])}}" class="btn btn-info detail-button"><i class="fas fa-info-circle"></i> Detail</a>
								<button type="button" class="btn btn-danger delete-button" data-toggle="modal" data-target="#deleteModal">Delete</button>
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
	        <h5 class="modal-title" id="exampleModalLabel">Delete input receipt</h5>
			<p class="heading-input-receipt-name" style="margin: auto 5px; font-size: 1.25rem; font-weight: 500;"></p>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		  	<p>Are you sure ?</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-danger delete-btn">Delete</button>
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
				<p>Please wait...</p>
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
    <script src="js/inputreceipt_index.js"></script>
@stop

@section('add-button')
	<a href="{{url('/inputreceipt/add')}}" class="btn btn-success add-button" >
		<i class="fas fa-plus"></i> Add input receipt
	</a>
@stop