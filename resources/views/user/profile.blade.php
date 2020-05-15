@extends('layouts.master')

@section('title', trans('user.user_profile'))

@section('styles')
    <link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
@stop

@section('page-heading', trans('user.user_profile'))
        
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
                <form id="form-profile" action="{{ url('/user/profile') }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="exampleInputEmail1">{{trans('user.username')}}</label>
                            <input type="text" class="form-control" disabled aria-describedby="emailHelp" value="{{$user->tendangnhap}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="exampleInputEmail1">{{trans('user.name')}}</label>
                            <input type="text" class="form-control" name="name" aria-describedby="emailHelp" value="{{$user->hoten}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="exampleInputEmail1">{{trans('user.birthday')}}</label>
                            <input type="date" class="form-control" name="birthday" aria-describedby="emailHelp" value="{{date('Y-m-d', strtotime($user->ngaysinh))}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="exampleInputEmail1">{{trans('user.phone')}}</label>
                            <input type="number" class="form-control" name="phone" aria-describedby="emailHelp" value="{{$user->dienthoai}}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="exampleInputEmail1">{{trans('user.email')}}</label>
                            <input type="email" class="form-control" name="email" aria-describedby="emailHelp" value="{{$user->email}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="exampleInputEmail1">{{trans('user.created_date')}}</label>
                            <input type="date" class="form-control" disabled value="{{date('Y-m-d', strtotime($user->ngaytao))}}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="exampleInputEmail1">{{trans('user.position')}}</label>
                            <input type="text" class="form-control" disabled @if($user->chucvu == 'staff')
                                                                                            value="{{trans('user.staff')}}"
                                                                                        @else
                                                                                        value="{{trans('user.manager')}}"
                                                                                        @endif>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm m-t-10">{{trans('user.save_changes')}}</button>
                </form>
            </div>
        </div>
    </div>


@stop

@section('scripts')

@stop

