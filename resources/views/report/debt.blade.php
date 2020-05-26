@extends('layouts.master')

@section('title', trans('report.debt_report'))

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">  

    <style>
        .form {
            text-align: center;
            margin: 20px 0px;
        }
    </style>
@stop

@section('page-heading', trans('report.debt_report'))

@section('content')
    <div class="form">
        <form action="{{ url('create-debt-report') }}" method="post" id="reportForm">
            @csrf
            <label for="bdaymonth">{{trans('report.choose_time')}}:</label>
            <input type="month" id="bdaymonth" name="date" value="{{ old('date') }}">
            <input type="submit" class="btn btn-success" value="{{trans('report.export_report')}}">
            <input type="submit" name="print" class="btn btn-success" value="{{trans('report.print_report')}}">
        </form>
    </div>

    @if (Session::has('data'))
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ trans('report.debt_report_with_time', [ 'month' => Session::get('month'), 'year' => Session::get('year')]) }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>{{ trans('report.customer_name') }}</th>
                                <th>{{ trans('report.customer_phone') }}</th>
                                <th>{{ trans('report.customer_email') }}</th>
                                <th>{{ trans('report.opening_debt') }}</th>
                                <th>{{ trans('report.total_buy') }}</th>
                                <th>{{ trans('report.total_payment') }}</th>
                                <th>{{ trans('report.ending_debt') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Session::get('data') as $item)
                            <tr>
                                <th><a href="{{url('/customer/detail', [$item->makhachhang])}}">{{ $item->hoten }}</a></th>
                                <th>{{ $item->dienthoai }}</th>
                                <th>{{ $item->email }}</th>
                                <th>{{ $item->nodau }}</th>
                                <th>{{ $item->tongtienmua }}</th>
                                <th>{{ $item->tongtientra }}</th>
                                <th>{{ $item->nocuoi }}</th>
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
        $('#reportForm').submit(function() {
            let value = $('#bdaymonth').val();
            if (value === "") {
                alert('{{ trans('report.required_month_year_value') }}');
                return false;
            }
        });
    </script>
@stop

