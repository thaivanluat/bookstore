@extends('layouts.master')

@section('title', 'Book')

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">  
	<link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/select2-4.0.13/css/select2.min.css" rel="stylesheet">
	<link href="vendor/select2-4.0.13/css/select2-boostrap.min.css" rel="stylesheet">
@stop

@section('page-heading', 'Book')

@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Book List</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Name</th>
                            <th>Category</th>
                            <th>Author</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $book)
						<tr>
							<th class="book-name"><a href="{{url('/book/detail', [$book->madausach])}}">{{ $book->tendausach }}</a></th>
                            <th class="book-category"><a href="{{url('/bookcategory/detail', [$book->matheloai])}}">{{ $book->tentheloai }}</a></th>
                            <th class="book-author"><a href="{{url('/author/detail', [$book->matacgia])}}">{{ $book->tentacgia }}</a></th>
							<th style="text-align: center;">
								<input type="hidden" class="book-id" value="{{ $book->madausach }}">
								<input type="hidden" class="author-id" value="{{ $book->matacgia }}">
								<input type="hidden" class="category-id" value="{{ $book->matheloai }}">
								<button type="button" class="btn btn-primary edit-button" data-toggle="modal" data-target="#editModal">Edit</button>
								<button type="button" class="btn btn-danger delete-button" data-toggle="modal" data-target="#deleteModal">Delete</button>
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
	        <h5 class="modal-title" id="exampleModalLabel">Edit book</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		  	<div class="form-group">
			    <label>Name</label>
			    <input type="text" class="form-control" id="bookName">
			</div>
			<div class="form-group">
			    <label>Category</label>
			    <select class="form-control" id="bookCategory">
					@foreach ($category as $c)
						<option value="{{ $c->matheloai }}">{{ $c->tentheloai }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
			    <label>Author</label>
			    <select class="form-control" id="bookAuthor">
					@foreach ($author as $a)
						<option value="{{ $a->matacgia }}">{{ $a->tentacgia }}</option>
					@endforeach
				</select>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary save-change-btn">Save changes</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Delete Modal -->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Delete book</h5>
            <p class="heading-book-name" style="margin: auto 5px; font-size: 1.25rem; font-weight: 500;"></p>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		  	<p>Are you sure ?</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-danger delete-btn">Delete</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Add Modal -->
	<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Add book</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
			    <label>Name</label>
			    <input type="text" class="form-control" id="addBookName">
			</div>
			<div class="form-group">
			    <label>Category</label>
			    <select class="form-control" id="addCategory">
					@foreach ($category as $c)
						<option value="{{ $c->matheloai }}">{{ $c->tentheloai }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
			    <label>Author</label>
			    <select class="form-control" id="addAuthor">
					@foreach ($author as $a)
						<option value="{{ $a->matacgia }}">{{ $a->tentacgia }}</option>
					@endforeach
				</select>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-success add-btn">Add</button>
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
				<p>Please wait...</p>
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
	<script src="js/book_index.js"></script>
@stop

@section('add-button')
	<button type="button" class="btn btn-success add-button" data-toggle="modal" data-target="#addModal">
		<i class="fas fa-plus"></i> Add book
	</button>
@stop
