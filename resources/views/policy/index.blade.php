@extends('layouts.master')

@section('title', trans('policy.policy'))

@section('styles')
    <link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container1 {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default checkbox */
        .container1 input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* Create a custom checkbox */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
        }

        /* On mouse-over, add a grey background color */
        .container1:hover input ~ .checkmark {
            background-color: #ccc;
        }

        /* When the checkbox is checked, add a blue background */
        .container1 input:checked ~ .checkmark {
            background-color: #2196F3;
        }

        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark when checked */
        .container1 input:checked ~ .checkmark:after {
            display: block;
        }

        /* Style the checkmark/indicator */
        .container1 .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }
    </style>
@stop

@section('page-heading', trans('policy.change_policy'))
        
@section('content')
    <div class="container">        
        <div class="card">
            <div class="card-body card-padding">
                @if(count($errors)>0)
                    <div class="alert alert-danger" role="alert">
                    @foreach($errors->all() as $err)
                        {{$err}}<br>
                    @endforeach
                    </div>
                @endif
                @if (session('error-message'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error-message') }}
                    </div>
                @endif
                @if (session('success-message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success-message') }}
                    </div>
                @endif
                <form id="form-profile" action="" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="exampleInputEmail1">{{trans('policy.min_input_value')}}</label>
                        </div>
                        <div class="form-group col-sm-3">
                        <input type="number" min="0" class="form-control" name="min_input_value"  aria-describedby="emailHelp" value="{{ $data->soluongnhaptoithieu }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="exampleInputEmail1">{{trans('policy.max_stock_before_input_value')}}</label>
                            
                        </div>
                        <div class="form-group col-sm-3">
                            <input type="number" min="0" class="form-control" name="max_stock_before_input_value"  aria-describedby="emailHelp" value="{{ $data->soluongtondenhaptoida }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="exampleInputEmail1">{{trans('policy.max_debt_value')}}</label>
                            
                        </div>
                        <div class="form-group form-inline col-sm-4">
                            <input type="number" min="0" class="form-control" name="max_debt_value"  aria-describedby="emailHelp" value="{{ $data->tongnotoida }}">
                            <span>&nbsp VND</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="exampleInputEmail1">{{trans('policy.min_stock_after_sold_value')}}</label>
                            
                        </div>
                        <div class="form-group col-sm-3">
                            <input type="number" min="0" class="form-control" name="min_stock_after_sold_value"  aria-describedby="emailHelp" value="{{ $data->luongtonsaukhibantoithieu }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="exampleInputEmail1">{{trans('policy.ratio_of_selling_price')}}</label>
                        </div>
                        <div class="form-group form-inline col-sm-3">
                            <input type="number" min="0" class="form-control" name="ratio_of_selling_price"  aria-describedby="emailHelp" value="{{ $data->tiletinhdongiaban }}">
                            <span>&nbsp %</span>
                        </div>
                    </div>
                    <div class="row">
                         <div class="form-group col-sm-4">
                            <label for="exampleInputEmail1">{{trans('policy.allow_exceed_debt')}}</label>
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="container1">
                            <input name="allow_exceed_debt" type="checkbox" @if($data->chophepvuottongno == 1) checked @endif>
                            <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm m-t-10">{{trans('policy.change_policy_btn')}}</button>
                </form>
            </div>
        </div>
    </div>


@stop

@section('scripts')

@stop

