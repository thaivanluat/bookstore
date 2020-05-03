@extends('layouts.master')

@section('title', 'Detail Invoice #'. $invoice->mahoadon)

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
		.sum :not(:first-child) {
			color:red;
		}
	</style>
@stop

@section('page-heading', 'Detail Invoice')
        
@section('content')
	<div id="customerInfo">
		<table style="width: 50%; width: 30%; border: 1px solid black; margin: 25px 0px;">
			<tr>
				<th style="width: 40%;">Customer ID:</th>
				<td class="customer-id">{{ $invoice->makhachhang }}</td>
			</tr>
			<tr>
				<th>Name: </th>
				<td class="customer-name">{{ $invoice->hoten }}</td>
			</tr>
			<tr>
				<th>Phone: </th>
				<td class="customer-phone">{{ $invoice->dienthoai }}</td>
			</tr>
			<tr>
				<th>Email: </th>
				<td class="customer-email">{{ $invoice->email }}</td>
			</tr>
			<tr>
				<th>Address: </th>
				<td class="customer-address">{{ $invoice->diachi }}</td>
			</tr>
			<tr>
				<th>Debt: </th>
				<td class="customer-debt">{{ $invoice->tongno }} ₫</td>
			</tr>
		</table>
	</div> 
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary" style="float:left">Invoice #{{ $invoice->mahoadon }}</h6>
			<span class="sum" style="float:right"><strong>Total: </strong><span>{{ number_format($invoice->tongtien) }} ₫</span></span>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>STT</th>
							<th>Name</th>
							<th>Category</th>
							<th>Author</th>
                            <th>Publisher</th>
                            <th>Publising Year</th>
                            <th>Quantity</th>
                            <th>Price (VND)</th>
                            <th>Total</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $key=>$invoiceItem)
						<tr>
                            <th>{{$key+1 }}</th>
							<th class="invoice-item-name"><a href="{{url('/book/detail', [$invoiceItem->madausach])}}">{{ $invoiceItem->tendausach }}</a></th>
							<th class="invoice-item-category"><a href="{{url('/category/detail', [$invoiceItem->matheloai])}}">{{ $invoiceItem->tentheloai }}</a></th>
							<th class="invoice-item-author"><a href="{{url('/author/detail', [$invoiceItem->matacgia])}}">{{ $invoiceItem->tentacgia }}</a></th>
                            <th class="invoice-item-publisher">{{ $invoiceItem->nhaxuatban }}</th>
                            <th class="invoice-item-publisher-year">{{ $invoiceItem->namxuatban }}</th>
							<th class="invoice-item-quantity">{{ $invoiceItem->soluong }}</th>
                            <th class="invoice-item-price">{{ number_format($invoiceItem->dongia) }}</th>
							<th class="invoice-item-total">{{ number_format($invoiceItem->dongia*$invoiceItem->soluong) }}</th>
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
