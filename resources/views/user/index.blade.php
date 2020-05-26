@extends('layouts.master')

@section('title', trans('user.user_list'))

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="vendor/select2-4.0.13/css/select2.min.css" rel="stylesheet">
	<link href="vendor/select2-4.0.13/css/select2-boostrap.min.css" rel="stylesheet">
@stop

@section('page-heading', trans('user.user_management'))

@section('content')
	<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">{{trans('user.user_list')}}</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>{{trans('user.name')}}</th>
							<th>{{trans('user.username')}}</th>
							<th>{{trans('user.phone')}}</th>
							<th>{{trans('user.email')}}</th>
							<th style="width: 11%;">{{trans('user.birthday')}}</th>
                            <th>{{trans('user.created_date')}}</th>
                            <th style="width: 10%;">{{trans('user.position')}}</th>
							<th style="width: 20%;">{{trans('user.action')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $user)
						<tr>
                            <th>{{ $user->hoten }}</th>
                            <th class="username">{{ $user->tendangnhap }}</th>
							<th>{{ $user->dienthoai }}</th>
							<th>{{ $user->email }}</th>
                            <th>{{ date('d-m-Y', strtotime($user->ngaysinh)) }}</th>
                            <th>{{ $user->ngaytao }}</th>
                            <th>
							@if($user->chucvu == 'staff')
								{{ trans('user.staff') }}
							@else
								{{ trans('user.manager') }}
							@endif
							</th>
							<th style="text-align: center;">
								<input type="hidden" class="user-id" value="{{ $user->manguoidung }}">
								<input type="hidden" class="user-type" value="{{ $user->chucvu }}">
								<button type="button" class="btn btn-primary edit-button" data-toggle="modal" data-target="#editModal">{{ trans('user.edit') }}</button>
								<button type="button" class="btn btn-danger delete-button" data-toggle="modal" data-target="#deleteModal">{{ trans('user.delete') }}</button>
							</th>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Edit Modal -->
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{trans('user.edit_user')}}</h5>
			<p class="heading-edit-user-name" style="margin: auto 5px; font-size: 1.25rem; font-weight: 500;"></p>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
			    <label>{{trans('user.position')}}</label>
			    <select class="form-control" id="userType">
					<option value="staff">{{trans('user.staff')}}</option>
					<option value="manager">{{trans('user.manager')}}</option>
				</select>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('user.close') }}</button>
	        <button type="button" class="btn btn-primary save-change-btn">{{ trans('user.save_changes') }}</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Delete Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{trans('user.delete_user')}}</h5>
			<p class="heading-user-name" style="margin: auto 5px; font-size: 1.25rem; font-weight: 500;"></p>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		  	<p>{{ trans('user.are_you_sure') }}</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('user.close') }}</button>
	        <button type="button" class="btn btn-danger delete-btn">{{ trans('user.delete_user') }}</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Add Modal -->
	<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{ trans('user.add_user') }}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
			    <label>{{ trans('user.username') }}</label>
			    <input type="text" class="form-control" id="addUserName">
				<small id="emailHelp" class="form-text text-muted">{{ trans('user.password_for_new_user_policy') }}</small>
			</div>
			<div class="form-group">
			    <label>{{ trans('user.name') }}</label>
			    <input type="text" class="form-control" id="addName">
			</div>
			<div class="form-group">
			    <label>{{ trans('user.email') }}</label>
			    <input type="email" class="form-control" id="addEmail">
			</div>
			<div class="form-group">
			    <label>{{ trans('user.phone') }}</label>
			    <input type="number" min="0" class="form-control" id="addPhone">
			</div>
			<div class="form-group">
			    <label>{{ trans('user.birthday') }}</label>
			    <input type="date" min="0" class="form-control" id="addBirthday">
			</div>
			<div class="form-group">
			    <label>{{ trans('user.position') }}</label>
			    <select class="form-control" id="addUserType">
					<option value="staff">{{ trans('user.staff') }}</option>
					<option value="manager">{{ trans('user.manager') }}</option>
				</select>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('user.close') }}</button>
	        <button type="button" class="btn btn-success add-btn">{{ trans('user.add_user') }}</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Loading Modal -->
	<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
		<div class="modal-body text-center">
			<div class="loader"></div>
			<div clas="loader-txt">
				<p>{{ trans('user.please_wait') }}</p>
				<div class="spinner-border text-primary"></div>
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
  <script src="vendor/notify/notify.js"></script>
  <script src="vendor/select2-4.0.13/js/select2.min.js"></script>
  <script src="js/user_index.js"></script>
@stop

@section('add-button')
	<button type="button" class="btn btn-success add-button" data-toggle="modal" data-target="#addModal">
		<i class="fas fa-plus"></i> {{ trans('user.add_user') }}
	</button>
@stop

