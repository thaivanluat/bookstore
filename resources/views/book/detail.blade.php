@extends('layouts.master')

@section('title', 'Detail about '.$name)

@section('styles')
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">  
	<link href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css" rel="stylesheet">
@stop

@section('page-heading', $name)

@section('content')
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    <input type="hidden" id="bookId" value="{{ request()->route('id') }}">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary">Book Edition</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Name</th>
                            <th>Publishor</th>
                            <th>Publishing year</th>
                            <th>Price</th>
							<th>Amount</th>
                            <th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $book)
						<tr>
							<th class="book-name">{{ $name }}</th>
                            <th class="book-publisher">{{ $book->nhaxuatban }}</th>
                            <th class="book-publishing-year">{{ $book->namxuatban }}</th>
                            <th class="book-price">{{ $book->dongiaban }}</th>
                            <th class="book-amount">{{ $book->soluongton }}</th>
							<th style="text-align: center;">
								<input type="hidden" class="book-edition-id" value="{{ $book->masach }}">
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
	        <h5 class="modal-title" id="exampleModalLabel">Edit book edition</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
			<div class="form-group">
                <div class="form-group">
                    <label>Publisher</label>
                    <input type="text" class="form-control" id="bookPublisher">
                </div>
			</div>
			<div class="form-group">
                <div class="form-group">
                    <label>Publishing Year</label>
                    <input type="number" min="0" class="form-control" id="bookPublishingYear">
                </div>
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
	        <h5 class="modal-title" id="exampleModalLabel">Delete this book edition</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
            <table style="margin: auto; width: 60%;">
                <tr>
                    <td style="width: 50%"><strong>Publisher:</strong></td>
                    <td class="heading-book-publisher"></td>
                </tr>
                <tr>
                    <td><strong>Publishing Year:</strong></td>
                    <td class="heading-book-publishing-year"></td>
                </tr>
                <tr>
                    <td><strong>Price:</strong></td>
                    <td class="heading-book-price"></td>
                </tr>
                <tr>
                    <td><strong>Amount:</strong></td>
                    <td class="heading-book-amount"></td>
                </tr>
            </table>
            <br>
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
	        <h5 class="modal-title" id="exampleModalLabel">Add book edition</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
			    <label>Publisher</label>
			    <input type="text" class="form-control" id="addBookPublisher">
			</div>
            <div class="form-group">
			    <label>Publishing Year</label>
			    <input type="number" min="0" class="form-control" id="addBookPublishingYear">
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
	<script src="js/bookedition_index.js"></script>
@stop

@section('add-button')
	<button type="button" class="btn btn-success add-button" data-toggle="modal" data-target="#addModal">
		<i class="fas fa-plus"></i> Add book edition
	</button>
@stop
