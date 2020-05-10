@extends('layouts.master')

@section('title', trans('author.author_list'))

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
@stop

@section('page-heading', trans('author.author'))

@section('content')
	<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">{{ trans('author.author_list') }}</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>{{ trans('author.name') }}</th>
							<th>{{ trans('author.year_of_birth') }}</th>
							<th>{{ trans('author.action') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $author)
						<tr>
							<th class="author-name"><a href="{{url('/author/detail', [$author->matacgia])}}">{{ $author->tentacgia }}</a></th>
							<th class="author-birthday">{{ $author->namsinh }}</th>
							<th style="text-align: center;">
								<input type="hidden" class="author-id" value="{{ $author->matacgia }}">
								<button type="button" class="btn btn-primary edit-button" data-toggle="modal" data-target="#editModal">{{ trans('author.edit') }}</button>
								<button type="button" class="btn btn-danger delete-button" data-toggle="modal" data-target="#deleteModal">{{ trans('author.delete') }}</button>
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
	        <h5 class="modal-title" id="exampleModalLabel">{{ trans('author.edit_author') }}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
			    <label>{{ trans('author.name') }}</label>
			    <input type="text" class="form-control" id="authorName">
			</div>
			<div class="form-group">
			    <label>{{ trans('author.year_of_birth') }}</label>
			    <input type="number" min="0" class="form-control" id="yearBirth">
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('author.close') }}</button>
	        <button type="button" class="btn btn-primary save-change-btn">{{ trans('author.save_changes') }}</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Delete Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{ trans('author.delete_author') }}</h5>
			<p class="heading-author-name" style="margin: auto 5px; font-size: 1.25rem; font-weight: 500;"></p>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		  	<p>{{ trans('author.are_you_sure') }}</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('author.close') }}</button>
	        <button type="button" class="btn btn-danger delete-btn">{{ trans('author.delete_author') }}</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Add Modal -->
	<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">{{ trans('author.add_author') }}</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
			    <label>{{ trans('author.name') }}</label>
			    <input type="text" class="form-control" id="addAuthorName">
			</div>
			<div class="form-group">
			    <label>{{ trans('author.year_of_birth') }}</label>
			    <input type="number" min="0" class="form-control" id="addYearBirth">
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('author.close') }}</button>
	        <button type="button" class="btn btn-success add-btn">{{ trans('author.add_author') }}</button>
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
				<p>{{ trans('author.please_wait') }}</p>
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
  <script src="js/author_index.js"></script>
@stop

@section('add-button')
	<button type="button" class="btn btn-success add-button" data-toggle="modal" data-target="#addModal">
		<i class="fas fa-plus"></i> {{ trans('author.add_author') }}
	</button>
@stop

