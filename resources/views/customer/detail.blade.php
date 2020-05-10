@extends('layouts.master')

@section('title', trans('customer.detail_about'). $customer->hoten)

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		.sum :not(:first-child) {
			color:red;
		}
	</style>
@stop

@section('page-heading', trans('customer.customer_profile'))
        
@section('content')
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="home" aria-selected="true">{{ trans('customer.profile') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#invoice" role="tab" aria-controls="profile" aria-selected="false">{{ trans('customer.invoices') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#receipt" role="tab" aria-controls="contact" aria-selected="false">{{ trans('customer.receipts') }}</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <ul class="list-group">
                <li class="list-group-item"><strong>{{ trans('customer.customer_id') }}:</strong> {{ $customer->makhachhang }}</li>
                <li class="list-group-item"><strong>{{ trans('customer.customer_name') }}: </strong>{{ $customer->hoten }}</li>
                <li class="list-group-item"><strong>{{ trans('customer.customer_phone') }}: </strong>{{ $customer->dienthoai }}</li>
                <li class="list-group-item"><strong>{{ trans('customer.customer_email') }}: </strong>{{ $customer->email }}</li>
                <li class="list-group-item"><strong>{{ trans('customer.customer_address') }}: </strong>{{ $customer->diachi }}</li>
                <li class="list-group-item"><strong>{{ trans('customer.customer_debt') }}: </strong>{{ number_format($customer->tongno) }} ₫</li>
            </ul>
        </div>

        <div class="tab-pane fade" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ trans('customer.invoice_list') }}</h6>
                    <span>{{ trans('customer.customer') }} {{ $customer->hoten }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>{{ trans('customer.invoice_id') }}</th>
                                    <th>{{ trans('customer.date_created') }}</th>
                                    <th>{{ trans('customer.amount_received') }} (VND)</th>
                                    <th>{{ trans('customer.total') }} (VND)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                <tr>
                                    <th class="invoice-id"><a href="{{url('/invoice/detail', [$invoice->mahoadon])}}">#{{ $invoice->mahoadon }}</a></th>
                                    <th class="invoice-date-created">{{ $invoice->ngaylap }}</th>
                                    <th class="invoice-amount-received">{{ number_format($invoice->sotientra) }}</th>
                                    <th class="invoice-total">{{ number_format($invoice->tongtien) }}</th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="receipt" role="tabpanel" aria-labelledby="receipt-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ trans('customer.receipt_list') }}</h6>
                    <span>{{ trans('customer.customer') }} {{ $customer->hoten }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>{{ trans('customer.receipt_id') }}</th>
                                    <th>{{ trans('customer.date_created') }}</th>
                                    <th>{{ trans('customer.receipt_value') }} (VND)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($receipts as $receipt)
                                <tr>
                                    <th class="receipt-id">#{{ $receipt->maphieuthu }}</th>
                                    <th class="receipt-date-created">{{ $receipt->ngaylap }}</th>
                                    <th class="receipt-amount-received">{{ number_format($receipt->sotienthu) }}</th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
@stop
