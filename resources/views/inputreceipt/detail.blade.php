@extends('layouts.master')

@section('title', trans('inputreceipt.detail_input_receipt').'#'. $inputReceipt->maphieunhapsach)

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		.sum :not(:first-child) {
			color:red;
		}
	</style>
@stop

@section('page-heading', trans('inputreceipt.input_receipt_detail'))
        
@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary" style="float:left">{{trans('inputreceipt.input_receipt')}} #{{ $inputReceipt->maphieunhapsach }}</h6>
			<span class="sum" style="float:right"><strong>{{trans('inputreceipt.total')}}: </strong><span>{{ number_format($inputReceipt->tongtien) }} ₫</span></span>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>{{trans('inputreceipt.order_number')}}</th>
							<th>{{trans('inputreceipt.book_name')}}</th>
							<th>{{trans('inputreceipt.category')}}</th>
							<th>{{trans('inputreceipt.author')}}</th>
                            <th>{{trans('inputreceipt.publisher')}}</th>
                            <th>{{trans('inputreceipt.publishing_year')}}</th>
                            <th>{{trans('inputreceipt.quanlity')}}</th>
                            <th>{{trans('inputreceipt.price')}} (VND)</th>
                            <th>{{trans('inputreceipt.total_price')}}</th>
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
							<th class="input-item-quantity">{{ $inputItem->soluong }}</th>
                            <th class="input-item-price">{{ number_format($inputItem->dongianhap) }}</th>
							<th class="input-item-total">{{ number_format($inputItem->dongianhap*$inputItem->soluong) }}</th>
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
