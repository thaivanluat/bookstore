@extends('layouts.master')

@section('title', trans('inventory.inventory_check_list'))

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
@stop

@section('page-heading', trans('inventory.inventory_check'))
        
@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">{{trans('inventory.inventory_check_list')}}</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>{{trans('inventory.inventory_check_id')}}</th>
							<th>{{trans('inventory.created_date')}}</th>
							<th>{{trans('inventory.created_user')}}</th>
                            <th>{{trans('inventory.action')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $inventoryCheck)
						<tr>
							<th class="inventory-check-name"><a target="_blank" href="{{url('/inputreceipt/detail', [$inventoryCheck->maphieukiem])}}">#{{ $inventoryCheck->maphieukiem }}</a></th>
							<th class="inventory-check-created-date">{{ $inventoryCheck->ngaytao }}</th>
                            <th class="inventory-check-created-user">{{ $inventoryCheck->hoten }}</th>
							<th style="text-align: center;">
								<input type="hidden" class="inventory-check-id" value="{{ $inventoryCheck->maphieukiem }}">
								<a target="_blank" href="{{url('/inventory/detail', [$inventoryCheck->maphieukiem])}}" class="btn btn-info detail-button"><i class="fas fa-info-circle"></i> {{trans('inventory.detail')}}</a>
								<button type="button" class="btn btn-danger delete-button" data-toggle="modal" data-target="#deleteModal">{{trans('inventory.delete')}}</button>
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
	        <h5 class="modal-title" id="exampleModalLabel">{{trans('inventory.delete_inventory_check')}}</h5>
			<p class="heading-inventory-check-name" style="margin: auto 5px; font-size: 1.25rem; font-weight: 500;"></p>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		  	<p>{{trans('inventory.are_you_sure')}}</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('inventory.close')}}</button>
	        <button type="button" class="btn btn-danger delete-btn">{{trans('inventory.delete')}}</button>
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
				<p>{{trans('inventory.please_wait')}}</p>
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
    <script src="js/inventory_index.js"></script>
@stop

@section('add-button')
	<a href="{{url('/inventory/add')}}" class="btn btn-success add-button" >
		<i class="fas fa-plus"></i> {{trans('inventory.add_inventory_check')}}
	</a>
@stop