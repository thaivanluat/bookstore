@extends('layouts.master')

@section('title', trans('customer.filter_birthday'))

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">  

    <style>
        .form {
            text-align: center;
            margin: 20px 0px;
        }
    </style>
@stop

@section('page-heading', trans('customer.filter_birthday'))

@section('content')
    <div class="form">
        <form action="" method="post" id="searchForm">
            @csrf
            <label for="bdaymonth">{{trans('customer.choose_month')}}:</label>
            <select id="month" name="month">
                <option value="">{{ trans('customer.month') }}</option>
                @for($i = 1; $i <= 12; $i++)
                    <option {{ old('month') == $i ? "selected" : "" }} value="{{ $i }}">
                        {{ trans('customer.month').' '.$i }}
                    </option>
                @endfor
            </select>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="typecheckbox1" value="vip" {{ old('type') == 'vip' ? "checked" : "" }}>
                    <label class="form-check-label" for="exampleRadios1">
                    {{ trans('customer.vip_customer_checkbox') }}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="type" id="typecheckbox2" value="normal" {{ old('type') == 'normal' ? "checked" : "" }}>
                    <label class="form-check-label" for="exampleRadios2">
                        {{ trans('customer.normal_customer_checkbox') }}
                    </label>
                </div>
            </div>  
            <input type="submit" class="btn btn-success" value="{{trans('customer.search_customer')}}">
            <input type="submit" name="print" class="btn btn-success" value="{{trans('customer.print_customer_list')}}">
        </form>
    </div>

    @if (Session::has('data'))
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ trans('customer.list_customer_has_birthday', [ 'month' => Session::get('month'), 'type' => Session::get('type')]) }}</h6>
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
                                <th>{{ trans('customer.customer_birthday') }}</th>
                                <th>{{ trans('customer.customer_debt') }}</th>
                                <th>{{ trans('customer.customer_type') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Session::get('data') as $customer)
                            <tr>
                                <th class="customer-id"><a href="{{url('/customer/detail', [$customer->makhachhang])}}">{{ $customer->makhachhang }}</a></th>
                                <th class="customer-name"><a href="{{url('/customer/detail', [$customer->makhachhang])}}">{{ $customer->hoten }}</a></th>
                                <th class="customer-phone">{{ $customer->dienthoai }}</th>
                                <th class="customer-address">{{ $customer->diachi }}</th>
                                <th class="customer-email">{{ $customer->email }}</th>
                                <th class="customer-birthday">{{ date('d-m-Y', strtotime($customer->sinhnhat)) }}</th>
                                <th style="text-align: right;" class="customer-total-debt">{{ number_format($customer->tongno) }}</th>
                                <th class="customer-type" style="text-align: center;">
                                @if($customer->trangthai == 'vip')
                                    <span class="badge badge-warning">{{trans('customer.vip_customer')}}</span>
                                @else
                                    <span class="badge badge-primary">{{trans('customer.normal_customer')}}</span>
                                @endif
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@stop

@section('scripts')
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
	<script src="js/demo/datatables-demo.js"></script>
    <script>
        $('#searchForm').submit(function() {
            let value = $('#month').val();
            let checkbox = ($('#typecheckbox1').is(':checked') || $('#typecheckbox2').is(':checked')) ? true : false; 
            
            if (value === "") {
                alert('{{ trans('customer.required_month_value') }}');
                return false;
            }

            if(!checkbox) {
                alert('{{ trans('customer.required_customer_type') }}');
                return false;
            }
        });
    </script>
@stop

