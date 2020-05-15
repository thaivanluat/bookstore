@extends('layouts.master')

@section('title', trans('user.change_password'))

@section('styles')
    <link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
@stop

@section('page-heading', trans('user.change_password'))
        
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
                <form id="form-profile" action="{{ url('/user/change-password') }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="exampleInputEmail1">{{trans('user.new_password')}}</label>
                            <input type="password" class="form-control" name="password"  aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="exampleInputEmail1">{{trans('user.re_password')}}</label>
                            <input type="password" class="form-control" name="re-password"  aria-describedby="emailHelp">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm m-t-10">{{trans('user.change_password_btn')}}</button>
                </form>
            </div>
        </div>
    </div>


@stop

@section('scripts')

@stop

