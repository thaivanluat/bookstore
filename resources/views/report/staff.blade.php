@extends('layouts.master')

@section('title', trans('report.staff_report'))

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">  

    <style>
        .form {
            text-align: center;
            margin: 20px 0px;
        }
    </style>
@stop

@section('page-heading', trans('report.staff_report'))

@section('content')
    <div class="form">
        <form action="{{ url('create-staff-report') }}" method="post" id="reportForm">
            @csrf
            <label for="bdaymonth">{{trans('report.choose_time')}}:</label>
            <input type="month" id="bdaymonth" name="date" value="{{ old('date') }}">
            <input type="submit" class="btn btn-success" value="{{trans('report.export_report')}}">
            <input type="submit" name="print" class="btn btn-success" value="{{trans('report.print_report')}}">
        </form>
    </div>
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

