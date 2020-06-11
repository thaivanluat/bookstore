@extends('layouts.master')

@section('title', trans('inventory.detail_inventory_check').'#'. $inventoryCheck->maphieukiem)

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
@stop

@section('page-heading', trans('inventory.inventory_check'))
        
@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary" style="float:left">{{trans('inventory.inventory_check')}} #{{ $inventoryCheck->maphieukiem }}</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>{{trans('inventory.order_number')}}</th>
							<th>{{trans('inventory.book_name')}}</th>
							<th>{{trans('inventory.category')}}</th>
							<th>{{trans('inventory.author')}}</th>
                            <th>{{trans('inventory.publisher')}}</th>
                            <th>{{trans('inventory.publishing_year')}}</th>
                            <th>{{trans('inventory.stock')}}</th>
                            <th>{{trans('inventory.check_stock')}}</th>
                            <th>{{trans('inventory.different')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $key=>$inputItem)
						<tr>
                            <th>{{ $key+1 }}</th>
							<th class="input-item-name"><a href="{{url('/book/detail', [$inputItem->madausach])}}">{{ $inputItem->tendausach }}</a></th>
							<th class="input-item-category"><a href="{{url('/category/detail', [$inputItem->matheloai])}}">{{ $inputItem->tentheloai }}</a></th>
							<th class="input-item-author"><a href="{{url('/author/detail', [$inputItem->matacgia])}}">{{ $inputItem->tentacgia }}</a></th>
                            <th class="input-item-publisher">{{ $inputItem->nhaxuatban }}</th>
                            <th class="input-item-publisher-year">{{ $inputItem->namxuatban }}</th>
							<th class="input-item-stock">{{ $inputItem->tonkho }}</th>
							<th class="input-item-check-stock">{{ $inputItem->thucte }}</th>
                            <th class="input-item-different">{{ number_format($inputItem->giatrilech) }}</th>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop

@section('scripts')
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
    <script src="vendor/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
@stop
